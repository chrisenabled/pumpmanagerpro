<?php

/**
 * This is the model class for table "tbl_admin".
 *
 * The followings are the available columns in table 'tbl_admin':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $last_login
 */
class Admin extends PmpActiveRecord
{
    public $verifyCode;
    public $password_repeat;
    public $creatorPassCode;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_admin';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, password, creatorPassCode, pin_code', 'required'),
            array('username', 'unique'),
            array('pin_code','numerical','integerOnly'=>true),
			array('username', 'length', 'max'=>20),
			array('password', 'length', 'max'=>30, 'min'=>8),
            array('password','compare','message'=>'Your password must be repeated exactly below.'),
            array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
            array('verifyCode, creatorPassCode, password_repeat', 'safe'),
            array('creatorPassCode', 'creatorPassCode'),
            // The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('username, password', 'safe', 'on'=>'search'),
		);
	}


    protected function beforeSave(){

        $this->password = $this->hash($this->password);

        return parent::beforeSave();
    }

    public function creatorPassCode($attribute)
    {
        if($this->$attribute !== 'Chris@123'){
            $this->addError($attribute,'Pass code is not correct.');
        }
    }

    public static  function sqlAdmin($attribute){
        $sql = "SELECT password FROM tbl_admin WHERE username = :username LIMIT 1;";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":username", $attribute, PDO::PARAM_STR);
        return $command->queryRow();

    }
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
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

		$criteria->compare('id',$this->id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('last_login',$this->last_login,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}