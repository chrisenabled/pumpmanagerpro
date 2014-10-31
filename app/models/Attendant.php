<?php

class Attendant extends CActiveRecord
{
    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;

    public function getGenderOptions(){

        return array(

            self::GENDER_MALE => 'Male',
            self::GENDER_FEMALE => 'Female',
        );

    }

    protected function beforeSave(){

        if($this->isNewRecord){
            $this->user_id = Yii::app()->user->id;
        }
        $this->first_name = ucfirst(strtolower($this->first_name));
        $this->middle_name = ucfirst(strtolower($this->middle_name));
        $this->last_name = ucfirst(strtolower($this->last_name));
        $mask = array(" ", "(", ")", "-");
        $this->mobile_number = str_replace($mask, "", $this->mobile_number);
        return parent::beforeSave();
    }

    public function getGenderText(){

        $genderText = $this->genderOptions;
        return isset($genderText[$this->gender]) ? $genderText[$this->gender]
            : "unknown type ({$this->gender})";

    }

    public function getStateOptions(){

        return array(1=>'Abia',2=>'Adamawa',3=>'Akwa Ibom',4=>'Anambra',5=>'Bauchi',6=>'Bayelsa',
            7=>'Benue',8=>'Borno',9=>'Cross River',10=>'Delta',11=>'Ebonyi',12=>'Edo',13=>'Ekiti',14=>'Enugu',15=>'F.C.T',16=>'Gombe',
            17=>'Imo',18=>'Jigawa',19=>'Kaduna',20=>'Kano',21=>'Katsina',22=>'Kebbi',23=>'Kogi',24=>'Kwara',
            25=>'Lagos',26=>'Nasarawa',27=>'Niger',28=>'Ogun',29=>'Ondo',30=>'Osun',31=>'Oyo',32=>'Plateau',
            33=>'Rivers',34=>'Sokoto',35=>'Taraba',36=>'Yobe',37=>'Zamfara',

        );
    }

    public function getStateText(){
        $stateText = $this->stateOptions;
        return isset($stateText[$this->state_of_origin]) ? $stateText[$this->state_of_origin]
            : "unknown type ({$this->state_of_origin})";

    }

    public function getAlias(){

        $alias  = $this->first_name . '.'. substr($this->last_name, 0, 2);
        return $alias;
    }

    public static function sqlAttendants($attribute){
        $sql = "SELECT gender FROM tbl_attendant WHERE user_id = :id";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":id", $attribute, PDO::PARAM_STR);
        return $command->queryAll();
    }


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_attendant';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('first_name, last_name, gender, mobile_number, state_of_origin', 'required'),
			array('first_name, middle_name, last_name', 'length', 'max'=>20),
            array('mobile_number','mobilePattern'),
            array('mobile_number','unique'),
			array('date_employed', 'safe'),
            array('date_employed','correctDate'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('first_name, middle_name, last_name, gender, date_employed, state_of_origin', 'safe', 'on'=>'search'),

		);
	}

    public function mobilePattern($attribute)
    {
        if(substr($this->$attribute, 0,5) !== '(080)' && substr($this->$attribute, 0,5) !== '(070)' &&
            substr($this->$attribute, 0,5) !== '(081)'){
            $this->addError($attribute,'Please write a correct nigerian mobile number.');
        }
    }

    public function correctDate($attribute){
        if(strtotime($this->$attribute) > strtotime("NOW")){
            $this->addError($attribute,'Date cannot be above today');
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
			'first_name' => 'First Name',
			'middle_name' => 'Middle Name',
			'last_name' => 'Last Name',
			'gender' => 'Gender',
			'state_of_origin' => 'State Of Origin',
			'mobile_number' => 'Mobile',
			'date_employed' => 'Date Employed',
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

		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('middle_name',$this->middle_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('gender',$this->gender);
        $criteria->compare('state_of_origin',$this->state_of_origin);
		$criteria->compare('date_employed',$this->date_employed,true);
        $criteria->compare('user_id',Yii::app()->user->id,true);


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}