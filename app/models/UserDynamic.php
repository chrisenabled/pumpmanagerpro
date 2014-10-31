<?php

/**
 * This is the model class for table "tbl_user_dynamic".
 *
 * The followings are the available columns in table 'tbl_user_dynamic':
 * @property integer $id
 * @property string $user_id
 * @property string $ulast_login
 * @property string $plast_login
 * @property string $rlast_login
 *
 * The followings are the available model relations:
 * @property User $user
 */
class UserDynamic extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserDynamic the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_user_dynamic';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id', 'required'),
			array('user_id', 'length', 'max'=>8),
			array('ulast_login, plast_login, rlast_login', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, ulast_login, plast_login, rlast_login', 'safe', 'on'=>'search'),
		);
	}

    public static function sqlDynamic($id){

        $sql = "SELECT * FROM tbl_user_dynamic WHERE user_id = :id LIMIT 1;";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":id", $id, PDO::PARAM_STR);
        return $command->queryRow();
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
			'ulast_login' => 'Ulast Login',
			'plast_login' => 'Plast Login',
			'rlast_login' => 'Rlast Login',
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
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('ulast_login',$this->ulast_login,true);
		$criteria->compare('plast_login',$this->plast_login,true);
		$criteria->compare('rlast_login',$this->rlast_login,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}