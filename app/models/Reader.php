<?php


class Reader extends CActiveRecord
{
    public $password_repeat;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_reader';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, password', 'required'),
			array('username', 'length', 'max'=>30),
            array('password','compare'),
            array('username','whiteSpace'),
            array('username','uniqueUsername'),
            array('password', 'length', 'max'=>256),
			array('last_login, password_repeat', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, username, password, date_created, last_login', 'safe', 'on'=>'search'),
		);
	}
    public function whiteSpace($attribute){

        if((preg_match('/\s/',$this->$attribute)) == 1){
            $this->addError($attribute,'Please use only letters (a-z), numbers, and periods.');
        }
    }
    public function uniqueUsername($attribute){

        $account = Personnel::sqlPersonnel($this->$attribute);
        if(strtolower($account['username']) === strtolower($this->$attribute)){
            $this->addError($attribute,'Username'.' '.'"'.$this->$attribute.'"'.' '.'has already been taken.');
        }
        else{
            $account = User::sqlUser($this->$attribute);
            if(strtolower($account['username']) === strtolower($this->$attribute)){
                $this->addError($attribute,'Username'.' '.'"'.$this->$attribute.'"'.' '.'has already been taken.');
            }
        }

    }

    public static function sqlReader($attribute){
        $sql = "SELECT username FROM tbl_user WHERE username = :username LIMIT 1;";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":username", $attribute, PDO::PARAM_STR);
        return $command->queryScalar();
    }

    public static  function sqlReaderId($attribute){
        $sql = "SELECT * FROM tbl_reader WHERE id = :id LIMIT 1;";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":id", $attribute, PDO::PARAM_STR);
        return $command->queryRow();
    }


    protected function beforeSave(){

        $this->id = Yii::app()->user->id;
        $this->password = CPasswordHelper::hashPassword($this->password);
        $this->date_created = date("Y-m-d H:i:s");

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
			'id0' => array(self::BELONGS_TO, 'User', 'id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => 'Username',
			'password' => 'Password',
			'date_created' => 'Date Created',
			'last_login' => 'Last Login',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('last_login',$this->last_login,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}