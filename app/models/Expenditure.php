<?php


class Expenditure extends CActiveRecord
{

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'tbl_expenditure';
	}

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, expense, this_date', 'required'),
            array('expense','checkBalance'),
            array('expense','isNumeric'),
            array('this_date','correctDate'),
			array('user_id', 'length', 'max'=>8),
			array('title', 'length', 'max'=>50),
			array('description', 'length', 'max'=>150),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array(' title, this_date', 'safe', 'on'=>'search'),
		);
	}

    public function isNumeric($attribute){
        $input = str_replace(',', '', $this->$attribute);
        if(!is_numeric($input)){
            $this->addError($attribute, 'Money must be numeric.');
        }
    }

    public function correctDate($attribute){
        if(strtotime($this->$attribute) > strtotime("NOW")){
            $this->addError($attribute,'Date cannot be above today');
        }
    }

    public  function checkBalance($attribute){

        $revenue = 0.00;
        $sql = "SELECT sold_qty_revenue FROM tbl_stock_stat WHERE user_id = :id AND sales_date = :date;";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":id", Yii::app()->user->id, PDO::PARAM_STR);
        $command->bindValue(":date", $this->this_date, PDO::PARAM_STR);
        $stockStats = $command->queryAll();

        if(!empty($stockStats)){
            foreach($stockStats as $stockStat){
                $revenue += $stockStat['sold_qty_revenue'];
            }
        }

        if($this->expense > $revenue){
            $this->addError($attribute, 'Expense Cannot be greater than money available');
        }

    }

    protected  function beforeSave(){

        $this->user_id = Yii::app()->user->id;
        $this->initial_profit = $this->user->daily['netProfit'];
        $this->final_profit  = $this->initial_profit - $this->expense;
        $this->expense = str_replace(',', '', $this->expense);


        return parent::beforeSave();
    }

    public static function expenseData($from, $to){

        $strtDate = date("Y-m-d", strtotime($from));
        $endDate = date("Y-m-d", strtotime($to));

        $sql = "SELECT expense FROM tbl_expenditure WHERE user_id = :id AND this_date >= :strtDate AND this_date <= :endDate";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":id", Yii::app()->user->id, PDO::PARAM_STR);
        $command->bindValue(":strtDate", $strtDate, PDO::PARAM_STR);
        $command->bindValue(":endDate", $endDate, PDO::PARAM_STR);
        $expense = $command->queryAll();

        return $expense;
    }


	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
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
			'user_id' => 'User',
			'title' => 'Title',
			'description' => 'Description',
			'expense' => 'Expense',
			'initial_profit' => 'Initial Net Profit',
			'final_profit' => 'Final Net Profit',
			'this_date' => 'Expense Date',
            'date_created'=>'Date Created',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('title',$this->title,true);
		$criteria->compare('this_date',$this->this_date,true);
        $criteria->compare('user_id',Yii::app()->user->id);


        return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}