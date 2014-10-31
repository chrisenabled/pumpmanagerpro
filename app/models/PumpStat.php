<?php

class PumpStat extends CActiveRecord
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
		return 'tbl_pump_stat';
	}

    public function rules()
    {

        return array(
            array('pump_id, shift, record_date', 'safe', 'on'=>'search'),
        );
    }

    public function getShiftText(){

        $shiftOption = $this->pump->shiftOptions;
        return isset($shiftOption[$this->shift]) ? $shiftOption[$this->shift] :
            "Unknown Type ({$shiftOption[$this->shift]})";
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
			'pump' => array(self::BELONGS_TO, 'Pump', 'pump_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'pump_id' => 'Pump',
            'tank' => 'Tank Used',
			'user_id' => 'User',
			'attendant_name' => 'Attendant Name',
			'shift' => 'Shift',
			'entry_reading' => 'Entry Reading',
			'closing_reading' => 'Closing Reading',
			'sold_qty' => 'Sold Qty',
			'sold_qty_cost' => 'Sold Qty Cost',
			'sold_qty_revenue' => 'Sold Qty Revenue',
			'profit' => 'Profit',
			'offset' => 'Offset',
			'record_date' => 'Readings Date',
			'date_created' => 'Date Created',
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

		$criteria->compare('pump_id',$this->getPumpId($this->pump_id),true);
        $criteria->compare('tank',$this->tank,true);
		$criteria->compare('attendant_name',$this->attendant_name,true);
		$criteria->compare('shift',$this->shift);
		$criteria->compare('record_date',$this->record_date,true);
        $criteria->compare('user_id',Yii::app()->user->id,true);
        $criteria->order = 'record_date DESC';


        return new CActiveDataProvider($this, array(
            'pagination'=>array(
                'pageSize'=> 1,
            ),
			'criteria'=>$criteria,
		));
	}

    public function getPumpId($pumpId){

        if(is_null($pumpId)) return $pumpId;

        $pump = Pump::Model()->findByAttributes(array('pump_no'=> $pumpId));
        return $pump->id;

    }
}