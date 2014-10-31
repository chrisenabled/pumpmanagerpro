<?php

/**
 * This is the model class for table "tbl_user_static".
 *
 * The followings are the available columns in table 'tbl_user_static':
 * @property integer $id
 * @property string $user_id
 * @property integer $security_question
 * @property string $security_answer
 * @property string $udate_created
 * @property string $pdate_created
 * @property string $rdate_created
 *
 * The followings are the available model relations:
 * @property User $user
 */
class UserStatic extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserStatic the static model class
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
		return 'tbl_user_static';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, security_question, security_answer, udate_created', 'required'),
			array('security_question', 'numerical', 'integerOnly'=>true),
			array('user_id', 'length', 'max'=>8),
			array('security_answer', 'length', 'max'=>30),
			array('pdate_created, rdate_created', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, security_question, security_answer, udate_created, pdate_created, rdate_created', 'safe', 'on'=>'search'),
		);
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
			'security_question' => 'Security Question',
			'security_answer' => 'Security Answer',
			'udate_created' => 'Udate Created',
			'pdate_created' => 'Pdate Created',
			'rdate_created' => 'Rdate Created',
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
		$criteria->compare('security_question',$this->security_question);
		$criteria->compare('security_answer',$this->security_answer,true);
		$criteria->compare('udate_created',$this->udate_created,true);
		$criteria->compare('pdate_created',$this->pdate_created,true);
		$criteria->compare('rdate_created',$this->rdate_created,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}