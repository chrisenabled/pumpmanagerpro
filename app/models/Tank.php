<?php


class Tank extends CActiveRecord
{

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'tbl_tank';
	}

    public function rules()
    {
        return array(
            array('stock_id, capacity, tank_no', 'required'),
            array('last_added_date, added_qty','required', 'on'=>'update'),
            array('last_added_date','correctDate','on'=>'update'),
            array('tank_no', 'numerical', 'integerOnly'=>true, 'min'=> 0),
            array('added_qty', 'balance'),
            array('added_qty, capacity', 'isNumeric'),
            array('tank_no','length','max'=>2),
            array('capacity','length','max'=>8),
            array('tank_no', 'uniqueNumber'),
            array('updated', 'updated', 'on'=>'update'),

            array(' tank_no, stock_id, capacity', 'safe', 'on'=>'search'),
		);
    }

    public function isNumeric($attribute){
        $input = str_replace(',', '', $this->$attribute);
        if(!is_numeric($input)){
            $this->addError($attribute, 'Money must be numeric.');
        }
    }
    protected function beforeSave(){

        if($this->isNewRecord){
            $this->user_id = Yii::app()->user->id;
            $counter = 1;
            $concat = $this->user_id.$counter;
            $class = get_class($this);

            while(count($class::model()->findByPk($concat)) == 1){

                $counter += 1;
                $concat = $this->user_id.$counter;
            }

            $this->id = $concat;

        }
        $this->capacity = str_replace(',', '', $this->capacity);
        $this->added_qty = str_replace(',', '', $this->added_qty);


        return parent::beforeSave();
    }

    protected function afterSave(){

        if(!$this->isNewRecord && $this->added_qty > 0){

            $date = date("Y-m-d");
            try{
                $sql = "INSERT INTO tbl_tank_stat (tank_no, user_id, qty_added, date_added, date_created)
                            VALUES (:tankNo, :userId, :qtyAdded, :dateAdded, :dateCreated)";
                $command = Yii::app()->db->createCommand($sql);
                $command->bindValue(":tankNo", $this->tank_no, PDO::PARAM_STR);
                $command->bindValue(":userId", $this->user_id, PDO::PARAM_STR);
                $command->bindValue(":qtyAdded", $this->added_qty, PDO::PARAM_STR);
                $command->bindValue(":dateAdded", $this->last_added_date, PDO::PARAM_STR);
                $command->bindValue(":dateCreated", $date, PDO::PARAM_STR);
                $command->execute();
            }
            catch(Exception $e){
                throw $e;
            }
        }
        return parent::afterSave();
    }

    public function updated($attribute){
        $this->$attribute =  $this->updated = date("Y-m-d H:i:s", strtotime('NOW'));

    }

    public function correctDate($attribute){
        $criteria = new CDbCriteria();
        $criteria->select="last_added_date";
        $criteria->addSearchCondition("id",$this->id);
        $date=Tank::model()->find($criteria);
        if(strtotime($this->$attribute) > strtotime("NOW")){
            $this->addError($attribute,'Date cannot be above today');
        }
        if(strtotime($this->$attribute) < strtotime($date->last_added_date)){
            $this->addError($attribute,'Date cannot be earlier than the previous last discharge date');
        }
    }
    public function uniqueNumber($attribute){

        if($this->isNewRecord){
            $user = User::Model()->findByPk(Yii::app()->user->id);
            $tanks = $user->tanks;
            $error = array();
            foreach($tanks as $tank){
                $error[] = $tank->tank_no;
            }
            if(in_array($this->$attribute,$error)){
                $this->addError($attribute, 'This pump number already exists!!!');
            }
        }
    }

    public function balance($attribute){

        if($this->added_qty > $this->capacity){
            $this->addError($attribute, 'cannot be greater than tank capacity');
        }
        if(($this->added_qty + $this->current_qty) > $this->capacity){
            $this->addError($attribute, 'you cannot add this much value');
        }
    }

    public function getStockOptions(){

        $user = User::Model()->findByPk(Yii::app()->user->id);
        return CHtml::listData($user->stocks, 'id', 'stockText');
    }
    public function getStockText(){

        $stockOptions = $this->stockOptions;
        return isset($stockOptions[$this->stock_id]) ? $stockOptions[$this->stock_id] :
            "Unknown Type ({$this->stock_id})";
    }

    public static function sqlTanks($attribute){
        $sql = "SELECT stock_id FROM tbl_tank WHERE user_id = :id";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":id", $attribute, PDO::PARAM_STR);
        return $command->queryAll();
    }

    public static function wipeStats(){
        $today = date("Y-m-d");
        try{
            $sql = "DELETE FROM tbl_tank_stat WHERE date_created < :today AND user_id = :userid";
            $command = Yii::app()->db->createCommand($sql);
            $command->bindValue(":userid", Yii::app()->user->id, PDO::PARAM_STR);
            $command->bindValue(":today", $today, PDO::PARAM_STR);
            $command->execute();
        }
        catch(Exception $e){
            throw $e;
        }
    }

    //end of added Methods......

    /**
     * @return array relational rules.
     */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'tblPumps' => array(self::MANY_MANY, 'Pump', 'tbl_pump_tank_assignment(tank_id, pump_id)'),
			'stock' => array(self::BELONGS_TO, 'Stock', 'stock_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'tank_no' => 'Tank No.',
			'user_id' => 'User',
			'stock_id' => 'Stock Used',
			'capacity' => 'Capacity',
			'prev_qty' => 'Previous Quantity',
			'added_qty' => 'Add Quantity',
			'current_qty' => 'Current Quantity',
			'last_added_date' => 'Date Discharged',
			'last_record' => 'Last Record',
			'updated' => 'Updated',
		);
	}


	public function search()
	{

		$criteria=new CDbCriteria;

		$criteria->compare('tank_no',$this->tank_no);
        $criteria->compare('stock_id',$this->getStockId($this->stock_id),true);
        $criteria->compare('capacity',$this->capacity);
		$criteria->compare('last_record',$this->last_record,true);
        $criteria->compare('user_id',Yii::app()->user->id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getStockId($stockId){
        if(is_null($stockId)) return $stockId;

        if($stockId === 'PMS' ){
            $criteria = new CDbCriteria;
            $criteria->compare('stock_type',1);
            $stock = Stock::Model()->find($criteria);
            return $stock->id;
        }
        if($stockId === 'AGO'){
            $criteria = new CDbCriteria;
            $criteria->compare('stock_type',2);
            $stock = Stock::Model()->find($criteria);
            return $stock->id;
        }
        if($stockId === 'DPK'){
            $criteria = new CDbCriteria;
            $criteria->compare('stock_type',3);
            $stock = Stock::Model()->find($criteria);
            return $stock->id;
        }
    }
}