<?php

class StockStat extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_stock_stat';
	}


	public function rules()
	{

		return array(
			array('stock_id, sales_date', 'safe', 'on'=>'search'),
		);
	}

    public static function stockData($from, $to){

        $strtDate = date("Y-m-d", strtotime($from));
        $endDate = date("Y-m-d", strtotime($to));
        $pms = array(); $ago = array(); $dpk = array();

        $sql = "SELECT * FROM tbl_stock_stat WHERE user_id = :id AND sales_date >= :strtDate AND sales_date <= :endDate";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":id", Yii::app()->user->id, PDO::PARAM_STR);
        $command->bindValue(":strtDate", $strtDate, PDO::PARAM_STR);
        $command->bindValue(":endDate", $endDate, PDO::PARAM_STR);
        $stocks = $command->queryAll();

        foreach($stocks as $stock){
            if($stock['stock_id'] === self::getStockId(1)){
                $pms[] = $stock;
            }
            if($stock['stock_id'] === self::getStockId(2)){
                $ago[] = $stock;
            }
            if($stock['stock_id'] === self::getStockId(3)){
                $dpk[] = $stock;
            }
        }

        return array('pms'=>$pms,'ago'=>$ago,'dpk'=>$dpk);

    }

    public static function getStockId($type){
        $criteria = new CDbCriteria;
        $criteria->compare('stock_type',$type);
        $criteria->compare('user_id',Yii::app()->user->id);

         $stock = Stock::Model()->find($criteria);
        return $stock->id;
    }
	public function relations()
	{
		return array(
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'stock' => array(self::BELONGS_TO, 'Stock', 'stock_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'stock_id' => 'Stock',
			'user_id' => 'User',
			'prev_qty' => 'Prev Qty',
			'current_qty' => 'Current Qty',
			'sold_qty' => 'Sold Qty',
			'sold_qty_costprice' => 'Sold Qty Costprice',
			'sold_qty_revenue' => 'Sold Qty Revenue',
			'sold_qty_profit' => 'Sold Qty Profit',
			'sales_date' => 'Sales Date',
			'date_created' => 'date_created',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;
		$criteria->compare('stock_id',self::getStockType($this->stock_id),true);
		$criteria->compare('sales_date',$this->sales_date,true);
        $criteria->compare('user_id',Yii::app()->user->id,true);
        $criteria->order = 'sales_date DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public static function getStockType($stockId){
        if(is_null($stockId)) return $stockId;

        if($stockId === 'PMS'){
            $criteria = new CDbCriteria;
            $criteria->compare('stock_type',1);
            $stock = Stock::Model()->find($criteria);
            return $stock->stock_type;
        }
        if($stockId === 'AGO'){
            $criteria = new CDbCriteria;
            $criteria->compare('stock_type',2);
            $stock = Stock::Model()->find($criteria);
            return $stock->stock_type;
        }
        if($stockId === 'DPK'){
            $criteria = new CDbCriteria;
            $criteria->compare('stock_type',3);
            $stock = Stock::Model()->find($criteria);
            return $stock->stock_type;
        }
    }
}