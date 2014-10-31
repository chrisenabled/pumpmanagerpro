<?php


class Stock extends CActiveRecord
{

    const TYPE_PMS = 1;
    const TYPE_AGO = 2;
    const TYPE_DPK = 3;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_stock';
	}

	/**
	 * @return array validation rules for model attributes.
	 */

    protected function beforeSave(){

        $this->user_id = Yii::app()->user->id;
        $this->id = $this->user_id.$this->stock_type;

        return parent::beforeSave();
    }


    private static function calc($stockStats){

        $soldQty1 = 0;
        $profit1 = 0;
        $soldQty2 = 0;
        $profit2 = 0;
        $soldQty3 = 0;
        $profit3 = 0;
        foreach($stockStats as $stockStat){
            if(substr($stockStat['stock_id'],7,1) === '1'){
            $soldQty1 += $stockStat['sold_qty'];
            $profit1 += $stockStat['sold_qty_profit'];
            }
            if(substr($stockStat['stock_id'],7,1) === '2'){
                $soldQty2 += $stockStat['sold_qty'];
                $profit2 += $stockStat['sold_qty_profit'];
            }
            if(substr($stockStat['stock_id'],7,1) === '3'){
                $soldQty3 += $stockStat['sold_qty'];
                $profit3 += $stockStat['sold_qty_profit'];
            }
        }
        return array('soldQty1'=>ceil($soldQty1),'soldQty2'=>ceil($soldQty2),'soldQty3'=>ceil($soldQty3),
            'profit1'=>ceil($profit1),'profit2'=>ceil($profit2),'profit3'=>ceil($profit3));
    }

    public static function getDailyStat(){

        $date = date("Y-m-d");

        $sql = "SELECT * FROM tbl_stock_stat WHERE user_id = :id AND sales_date = :date";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":id", Yii::app()->user->id, PDO::PARAM_STR);
        $command->bindValue(":date", $date, PDO::PARAM_STR);
        $stockStats =  $command->queryAll();

        return self::calc($stockStats);

    }

    public static function getWeeklyStat(){
        $strtDate = date("Y-m-d", strtotime('this week monday'));
        $endDate = date("Y-m-d", strtotime('this sunday'));
        if(date("Y-m-d", strtotime('NOW')) === $endDate){
            $strtDate = date("Y-m-d", strtotime('last monday'));

        }

        $sql = "SELECT * FROM tbl_stock_stat WHERE user_id = :id AND
        sales_date >= :startDate AND sales_date <= :endDate";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":id", Yii::app()->user->id, PDO::PARAM_STR);
        $command->bindValue(":startDate", $strtDate, PDO::PARAM_STR);
        $command->bindValue(":endDate", $endDate, PDO::PARAM_STR);
        $stockStats =  $command->queryAll();

        return self::calc($stockStats);

    }

    public static function getMonthlyStat(){
        $strtDate = date("Y-m-d", strtotime('first day of this month'));
        $endDate = date("Y-m-d", strtotime('last day of this month'));
        $sql = "SELECT * FROM tbl_stock_stat WHERE user_id = :id AND
        sales_date >= :startDate AND sales_date <= :endDate";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":id", Yii::app()->user->id, PDO::PARAM_STR);
        $command->bindValue(":startDate", $strtDate, PDO::PARAM_STR);
        $command->bindValue(":endDate", $endDate, PDO::PARAM_STR);
        $stockStats =  $command->queryAll();
        return self::calc($stockStats);
    }

    public static function getYearlyStat(){
        $strtDate = date("Y-m-d", strtotime('first day of january '.date('Y')));
        $endDate = date("Y-m-d", strtotime('last day of december '.date('Y')));
        $sql = "SELECT * FROM tbl_stock_stat WHERE user_id = :id AND
        sales_date >= :startDate AND sales_date <= :endDate";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":id", Yii::app()->user->id, PDO::PARAM_STR);
        $command->bindValue(":startDate", $strtDate, PDO::PARAM_STR);
        $command->bindValue(":endDate", $endDate, PDO::PARAM_STR);
        $stockStats =  $command->queryAll();
        return self::calc($stockStats);
    }

    public static  function sqlStock(){
        $sql = "SELECT stock_type FROM tbl_stock WHERE user_id = :id";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":id", Yii::app()->user->id, PDO::PARAM_STR);
        return $command->queryAll();
    }

    public function getStocks(){

        $stocks = self::sqlStock();
        $stockType = array(
            self::TYPE_PMS=> 'PMS',
            self::TYPE_AGO=> 'AGO',
            self::TYPE_DPK=> 'DPK'
        );
        if(count($stocks)>0){
            foreach($stocks as $stock){
                if (array_key_exists($stock['stock_type'], $stockType)) {
                    unset($stockType[$stock['stock_type']]);
                }
            }

        }
        return $stockType;

    }

    public function getStockOptions(){
        return array(
            self::TYPE_PMS=> 'PMS',
            self::TYPE_AGO=> 'AGO',
            self::TYPE_DPK=> 'DPK'
        );

    }

    public function getStockText(){

        $stockOptions = $this->stockOptions;
        return isset($stockOptions[$this->stock_type]) ? $stockOptions[$this->stock_type] :
            "Unknown Type ({$this->stock_type})";
    }

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('stock_type, cost_price, selling_price', 'required'),
			array('cost_price, selling_price', 'numerical', 'min'=> 0),
            array('cost_price, selling_price', 'length', 'max'=>6),
            array('selling_price','higherSelling'),

		);
	}


    public function higherSelling($attribute){

        if($this->$attribute < $this->cost_price){
            $this->addError($attribute,'Cost Price cannot be greater than Selling Price');
        }
    }
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'pumps' => array(self::HAS_MANY, 'Pump', 'stock_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'stockStats' => array(self::HAS_MANY, 'StockStat', 'stock_id'),
			'tanks' => array(self::HAS_MANY, 'Tank', 'stock_id'),
		);
	}

    public function getDaily(){

        $date = date("Y-m-d");
        $sql = "SELECT sold_qty_profit FROM tbl_stock_stat WHERE stock_id = :id AND sales_date = :date";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":id", $this->id, PDO::PARAM_STR);
        $command->bindValue(":date", $date, PDO::PARAM_STR);
        $stockStat =  $command->queryRow();

        return $stockStat['sold_qty_profit'];
    }


	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'stock_type' => 'Stock Type',
			'user_id' => 'User',
			'available_qty' => 'Available Qty',
			'cost_price' => 'Cost Price',
			'selling_price' => 'Selling Price',
			'last_record' => 'Last Sales',
		);
	}

    public function search()
    {
        $criteria=new CDbCriteria;
        $criteria->compare('user_id',Yii::app()->user->id,true);
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

}