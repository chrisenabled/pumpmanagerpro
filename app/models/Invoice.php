<?php

class Invoice extends CActiveRecord
{

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'tbl_invoice';
	}

	public function rules()
	{

		return array(
			array('id, vehicle_no, stock_type, quantity, price, invoice_date, date_received, invoice_type', 'required'),
			array('id', 'numerical', 'integerOnly'=>true),
            array('quantity, amount, adjustment', 'numerical'),
			array(' vehicle_no', 'length', 'max'=>8),
			array('quantity, amount, adjustment', 'length', 'max'=>10),
            array('quantity','isNumeric'),
            array('invoice_date,date_received','correctDate'),
            array('type','safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, vehicle_no, stock_type, quantity, amount, invoice_date, date_received, date_created', 'safe', 'on'=>'search'),
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

    public function getStockOptions(){

       $stocks = Stock::model()->findAllByAttributes(array('user_id'=>Yii::app()->user->id));
        return CHtml::listData($stocks, 'stock_type', 'stockText');
    }

    public function getStockText(){

        $stockOptions = $this->stockOptions;
        return isset($stockOptions[$this->stock_type]) ? $stockOptions[$this->stock_type] :
            "Unknown Type ({$this->stock_type})";
    }

    private  static function calcInvoice($invoices1,$invoices2,$invoices3){

        $quantity1 = 0.00;
        $amount1 = 0.00;
        $quantity2 = 0.00;
        $amount2 = 0.00;
        $quantity3 = 0.00;
        $amount3 = 0.00;
        foreach($invoices1 as $invoice){
            $quantity1 += $invoice['quantity'];
            $amount1 += $invoice['amount'];
        }
        foreach($invoices2 as $invoice){
            $quantity2 += $invoice['quantity'];
            $amount2 += $invoice['amount'];
        }
        foreach($invoices3 as $invoice){
            $quantity3 += $invoice['quantity'];
            $amount3 += $invoice['amount'];
        }
        if($quantity1 == 0 && $quantity2 == 0 && $quantity3 == 0){return array();}
        return array(
            'quantity1'=>ceil($quantity1),'quantity2'=>ceil($quantity2),'quantity3'=>ceil($quantity3),
            'amount1'=>ceil($amount1),'amount2'=>ceil($amount2),'amount3'=>ceil($amount3),
        );
    }

    public static function getDailyInvoice(){

        $date = date("Y-m-d");
        $invoices1 = array();
        $invoices2 = array();
        $invoices3 = array();
        $sql = "SELECT * FROM tbl_invoice WHERE user_id = :id AND date_received = :date";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":id", Yii::app()->user->id, PDO::PARAM_STR);
        $command->bindValue(":date", $date, PDO::PARAM_STR);
        $invoices =  $command->queryAll();
        foreach($invoices as $invoice){
            if($invoice['stock_type'] == 1){$invoices1[] = $invoice;}
            if($invoice['stock_type'] == 2){$invoices1[] = $invoice;}
            if($invoice['stock_type'] == 3){$invoices1[] = $invoice;}
        }

        return self::calcInvoice($invoices1,$invoices2,$invoices3);

    }

    public static function getWeeklyInvoice(){

        $strtDate = date("Y-m-d", strtotime('this week monday'));
        $endDate = date("Y-m-d", strtotime('this sunday'));
        $invoices1 = array();
        $invoices2 = array();
        $invoices3 = array();
        if(date("Y-m-d", strtotime('NOW')) === $endDate){
            $strtDate = date("Y-m-d", strtotime('last monday'));
        }


        $sql = "SELECT * FROM tbl_invoice WHERE user_id = :id  AND
        date_received >= :startDate AND date_received <= :endDate";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":id", Yii::app()->user->id, PDO::PARAM_STR);
        $command->bindValue(":startDate", $strtDate, PDO::PARAM_STR);
        $command->bindValue(":endDate", $endDate, PDO::PARAM_STR);
        $invoices =  $command->queryAll();

        foreach($invoices as $invoice){
            if($invoice['stock_type'] == 1){$invoices1[] = $invoice;}
            if($invoice['stock_type'] == 2){$invoices1[] = $invoice;}
            if($invoice['stock_type'] == 3){$invoices1[] = $invoice;}
        }

        return self::calcInvoice($invoices1,$invoices2,$invoices3);

    }

    public static function getMonthlyInvoice(){

        $strtDate = date("Y-m-d", strtotime('first day of this month'));
        $endDate = date("Y-m-d", strtotime('last day of this month'));
        $invoices1 = array();
        $invoices2 = array();
        $invoices3 = array();
        $sql = "SELECT * FROM tbl_invoice WHERE user_id = :id  AND
        date_received >= :startDate AND date_received <= :endDate";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":id", Yii::app()->user->id, PDO::PARAM_STR);
        $command->bindValue(":startDate", $strtDate, PDO::PARAM_STR);
        $command->bindValue(":endDate", $endDate, PDO::PARAM_STR);
        $invoices =  $command->queryAll();

        foreach($invoices as $invoice){
            if($invoice['stock_type'] == 1){$invoices1[] = $invoice;}
            if($invoice['stock_type'] == 2){$invoices1[] = $invoice;}
            if($invoice['stock_type'] == 3){$invoices1[] = $invoice;}
        }

        return self::calcInvoice($invoices1,$invoices2,$invoices3);
    }

    public static function getYearlyInvoice(){

        $strtDate = date("Y-m-d", strtotime('first day of january '.date('Y')));
        $endDate = date("Y-m-d", strtotime('last day of december '.date('Y')));
        $invoices1 = array();
        $invoices2 = array();
        $invoices3 = array();
        $sql = "SELECT * FROM tbl_invoice WHERE user_id = :id AND
        date_received >= :startDate AND date_received <= :endDate";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":id", Yii::app()->user->id, PDO::PARAM_STR);
        $command->bindValue(":startDate", $strtDate, PDO::PARAM_STR);
        $command->bindValue(":endDate", $endDate, PDO::PARAM_STR);
        $invoices =  $command->queryAll();

        foreach($invoices as $invoice){
            if($invoice['stock_type'] == 1){$invoices1[] = $invoice;}
            if($invoice['stock_type'] == 2){$invoices1[] = $invoice;}
            if($invoice['stock_type'] == 3){$invoices1[] = $invoice;}
        }

        return self::calcInvoice($invoices1,$invoices2,$invoices3);
    }

    public static function invoiceData($from, $to){

        $strtDate = date("Y-m-d", strtotime($from));
        $endDate = date("Y-m-d", strtotime($to));
        $pms = array();
        $ago = array();
        $dpk = array();

        $sql = "SELECT quantity, amount, stock_type FROM tbl_invoice WHERE user_id = :id AND invoice_date >= :strtDate AND invoice_date <= :endDate";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":id", Yii::app()->user->id, PDO::PARAM_STR);
        $command->bindValue(":strtDate", $strtDate, PDO::PARAM_STR);
        $command->bindValue(":endDate", $endDate, PDO::PARAM_STR);
        $invoices = $command->queryAll();

        foreach($invoices as $invoice){
            if($invoice['stock_type'] == 1){$pms[]=$invoice;}
            if($invoice['stock_type'] == 2){$ago[]=$invoice;}
            if($invoice['stock_type'] == 3){$dpk[]=$invoice;}

        }

        return array('pms'=>$pms,'ago'=>$ago,'dpk'=>$dpk);

    }

    public static  function sqlInvoice($attribute){
        $sql = "SELECT id FROM tbl_invoice WHERE user_id = :id LIMIT 1;";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":id", $attribute, PDO::PARAM_STR);
        return $command->execute();
    }

    public static  function sqlInvoiceDaily ($a, $b){
        $sql = "SELECT id FROM tbl_invoice WHERE user_id = :id AND date_received = :date LIMIT 1;";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":id", $a, PDO::PARAM_STR);
        $command->bindValue(":date", $b, PDO::PARAM_STR);
        return $command->execute();

    }

    public function getTypeText(){
        if ($this->invoice_type == 0) return 'Company';
        return 'Station';
    }

    protected function beforeSave(){

        $this->user_id = Yii::app()->user->id;
        $this->amount = $this->quantity * $this->price;
        $this->quantity = str_replace(',', '', $this->quantity);
        if($this->adjustment == 0)
        {$this->adjustment = $this->quantity;}
        else{$this->adjustment = str_replace(',', '', $this->adjustment);}

        return parent::beforeSave();
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
			'id' => 'Invoice No.',
			'user_id' => 'User',
			'vehicle_no' => 'Vehicle No',
			'stock_type' => 'Stock Type',
			'quantity' => 'Quantity',
			'amount' => 'Amount',
            'price' => 'Price/L',
            'adjustment'=>'Adjustment',
			'invoice_date' => 'Invoice Date',
			'date_received' => 'Date Received',
			'date_created' => 'Date Created',
		);
	}

	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
        $criteria->compare('invoice_type',$this->getInvoiceType($this->invoice_type),true);
		$criteria->compare('vehicle_no',$this->vehicle_no,true);
		$criteria->compare('stock_type',$this->getStockType($this->stock_type),true);
		$criteria->compare('quantity',$this->quantity,true);
		$criteria->compare('amount',$this->amount,true);
        $criteria->compare('price',$this->amount,true);
        $criteria->compare('invoice_date',$this->invoice_date,true);
		$criteria->compare('date_received',$this->date_received,true);
		$criteria->compare('date_created',$this->date_created,true);
        $criteria->compare('user_id',Yii::app()->user->id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getStockType($stockType){
        if(is_null($stockType)) return $stockType;

        if($stockType === 'PMS'){
            $criteria = new CDbCriteria;
            $criteria->compare('stock_type',1);
            $stock = Stock::Model()->find($criteria);
            return $stock->stock_type;
        }
        if($stockType === 'AGO'){
            $criteria = new CDbCriteria;
            $criteria->compare('stock_type',2);
            $stock = Stock::Model()->find($criteria);
            return $stock->stock_type;
        }
        if($stockType === 'DPK'){
            $criteria = new CDbCriteria;
            $criteria->compare('stock_type',3);
            $stock = Stock::Model()->find($criteria);
            return $stock->stock_type;
        }
    }

    public function getInvoiceType($invoiceType){
        if(is_null($invoiceType)) return $invoiceType;

        if($invoiceType === 'station' || $invoiceType === 'Station'){
            return 1;
        }
        if($invoiceType === 'company' || $invoiceType === 'Company'){
            return 0;
        }

    }
}