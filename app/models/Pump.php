<?php


class Pump extends CActiveRecord
{
    const TYPE_MORNING = 1;
    const TYPE_AFTERNOON = 2;
    const TYPE_NIGHT = 3;
    public $tanks = array();

    public function getShiftOptions(){

        return array(
            self::TYPE_MORNING => 'MORNING',
            self::TYPE_AFTERNOON => 'AFTERNOON',
            self::TYPE_NIGHT => 'NIGHT'
        );
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
            $this->tank_in_use = $this->tanks[0];
            $this->money_received = str_replace(',', '', $this->money_received);

        }
        return parent::beforeSave();
    }


    public function getShiftText(){

        $shiftOption = $this->shiftOptions;
        return isset($shiftOption[$this->shift]) ? $shiftOption[$this->shift] :
            "Unknown Type ({$shiftOption[$this->shift]})";
    }

    public function getAttendants(){
        $criteria = new CDBcriteria;
        $criteria->compare('user_id',Yii::app()->user->id);
        $attendant = Attendant::Model()->findAll($criteria);
        return CHtml::listData($attendant, 'alias','alias');
    }


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'tbl_pump';
	}

    public function getStockOptions(){
        $criteria = new CDbCriteria;
        $criteria->compare('user_id',Yii::app()->user->id);
        $tanks = Tank::Model()->findAll($criteria);
        return CHtml::listData($tanks, 'stock_id', 'stockText');
    }

	public function rules()
	{
		return array(
			array('stock_id, pump_no', 'required'),
            array('tanks', 'required', 'on'=>'insert'),
            array('tanks','tanks'),
            array('attendant, shift, entry_reading, closing_reading, money_received, record_date, tank_in_use', 'required', 'on'=>'update'),
			array('pump_no, shift, tank_in_use, entry_reading, closing_reading','numerical', 'integerOnly'=>true),
			array('money_received', 'isNumeric'),
            array('money_received', 'length','max'=>7),
            array('closing_reading, entry_reading','length','min'=>7, 'max'=>7, 'on'=>'update'),
            array('pump_no', 'length', 'max'=>2),
            array('pump_no','uniqueNumber'),
            array('closing_reading','correctReading', 'on'=>'update'),
            array('closing_reading', 'checkTankQuantity'),
            array('record_date','correctDate', 'on'=>'update'),
            array('tanks','safe', 'on'=>'create'),

			array(' pump_no, stock_id, tank_in_use', 'safe', 'on'=>'search'),
		);
	}

    public function isNumeric($attribute){
        $input = str_replace(',', '', $this->$attribute);
        if(!is_numeric($input)){
            $this->addError($attribute, 'Money must be numeric.');
        }
    }

    public function correctDate($attribute){
        $criteria = new CDbCriteria();
        $criteria->select="last_added_date";
        $criteria->compare("id",$this->tblTanks->tank_id);
        $criteria->compare("tank_no",$this->tank_in_use);
        $criteria->compare("user_id",Yii::app()->user->id);
        $date=Tank::model()->find($criteria);
        if(strtotime($this->$attribute) > strtotime("NOW")){
            $this->addError($attribute,'Date cannot be above today');
        }
        if(strtotime($this->$attribute) < strtotime($date->last_added_date)){
            $this->addError($attribute,"Date cannot be earlier than the tank's last discharged date.<br/>
            Any pump reading that is earlier can only be added to archive instead.");
        }
    }

    public function tanks($attribute){

        if($this->tanks == 0){
            $this->addError($attribute,'Tanks cannot be empty');
        }
    }

    public function correctReading($attribute){
        if($this->entry_reading > $this->closing_reading){
            $this->addError($attribute, 'Closing reading has to be greater than entry reading');
        }

    }

    public function checkTankQuantity($attribute){
        $criteria = new CDbCriteria;
        $criteria->compare('tank_no',$this->tank_in_use);
        $criteria->compare('id',$this->tanks->id);
        $criteria->compare('user_id',Yii::app()->user->id);
        $tank = Tank::Model()->find($criteria);
        if(($this->closing_reading - $this->entry_reading) > $tank->current_qty){
            $this->addError($attribute,'The Tank has lesser quantity available. Review your readings.');
        }
    }

    public function uniqueNumber($attribute){

        if($this->isNewRecord){
            $user = User::Model()->findByPk(Yii::app()->user->id);
            $pumpNos = array();
            $pumps = $user->pumps;
            foreach($pumps as $pump){
                    $pumpNos[] = $pump->pump_no;
            }
            if(in_array($this->$attribute,$pumpNos)){
                $this->addError($attribute, 'This Pump number already exists!!!');
            }
        }
    }

    public function getTanks(){

            return CHtml::listData($this, '','');

    }

    public static function sqlPumps($attribute){
        $sql = "SELECT stock_id FROM tbl_pump WHERE user_id = :id";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":id", $attribute, PDO::PARAM_STR);
        return $command->queryAll();
    }

    public function afterSave(){

        for($i=0; $i < count($this->tanks); $i++){
            $criteria = new CDBcriteria;
            $criteria->compare('user_id', Yii::app()->user->id);
            $criteria->compare('tank_no', $this->tanks[$i]);
            $tank = Tank::Model()->find($criteria);
            $transaction = Yii::app()->db->getCurrentTransaction() === null ? Yii::app()->db->beginTransaction() : false;
            try{
                $sql = "INSERT INTO tbl_pump_tank_assignment (pump_id, tank_id, pump_no, tank_no)
                    values (:pump_id, :tank_id, :pump_no, :tank_no)";

                $command = Yii::app()->db->createCommand($sql);
                $command->bindParam(":pump_id", $this->id, PDO::PARAM_STR);
                $command->bindParam(":pump_no", $this->pump_no, PDO::PARAM_INT);
                $command->bindParam(":tank_id", $tank->id, PDO::PARAM_STR);
                $command->bindParam(":tank_no", $tank->tank_no, PDO::PARAM_INT);
                $command->query();
                if($transaction){$transaction->commit();}
            }
            catch(Exception $e){
                if($transaction){
                    $transaction->rollback();
                    throw $e;
                }
                else{throw $e;}
            }
        }

        return array(parent::afterSave()) ;
    }

	public function relations()
	{
		return array(
			'stock' => array(self::BELONGS_TO, 'Stock', 'stock_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'pumpStats' => array(self::HAS_MANY, 'PumpStat', 'pump_id'),
			'tblTanks' => array(self::MANY_MANY, 'Tank', 'tbl_pump_tank_assignment(pump_id, tank_id)'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'pump_no' => 'Pump No',
			'user_id' => 'User',
			'stock_id' => 'Stock Used',
			'attendant' => 'Attendant',
			'shift' => 'Shift',
			'tank_in_use' => 'Tank In Use',
			'money_received' => 'Money Received',
			'record_date' => 'Readings Date',
			'entry_reading' => 'Entry Reading',
			'closing_reading' => 'Closing Reading',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('pump_no',$this->pump_no);
		$criteria->compare('stock_id',$this->getStockId($this->stock_id));
		$criteria->compare('tank_in_use',$this->tank_in_use);
        $criteria->compare('user_id',Yii::app()->user->id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getStockId($stockId){
        if(is_null($stockId)) return $stockId;

        if($stockId === 'PMS'){
            $criteria = new CDbCriteria;
            $criteria->compare('stock_type',1);
            $criteria->compare('user_id',Yii::app()->user->id);
            $stock = Stock::Model()->find($criteria);
            return $stock->id;
        }
        if($stockId === 'AGO'){
            $criteria = new CDbCriteria;
            $criteria->compare('stock_type',2);
            $criteria->compare('user_id',Yii::app()->user->id);
            $stock = Stock::Model()->find($criteria);
            return $stock->id;
        }
        if($stockId === 'DPK'){
            $criteria = new CDbCriteria;
            $criteria->compare('stock_type',3);
            $criteria->compare('user_id',Yii::app()->user->id);
            $stock = Stock::Model()->find($criteria);
            return $stock->id;
        }
    }
}