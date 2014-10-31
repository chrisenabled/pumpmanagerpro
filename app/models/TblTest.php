<?php

/**
 * This is the model class for table "tbl_test".
 *
 * The followings are the available columns in table 'tbl_test':
 * @property string $id
 * @property string $username
 * @property string $password
 * @property string $station_id
 * @property string $address
 * @property string $location_id
 * @property string $email
 * @property string $land_line
 * @property string $mobile_number
 */
class TblTest extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_test';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, username, password, station_id, address, location_id, email, land_line, mobile_number', 'required'),
			array('id', 'length', 'max'=>8),
			array('username', 'length', 'max'=>30),
			array('password', 'length', 'max'=>90),
			array('station_id, location_id', 'length', 'max'=>3),
			array('address', 'length', 'max'=>100),
			array('email', 'length', 'max'=>50),
			array('land_line', 'length', 'max'=>9),
			array('mobile_number', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, username, password, station_id, address, location_id, email, land_line, mobile_number', 'safe', 'on'=>'search'),
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
			'station_id' => 'Station',
			'address' => 'Address',
			'location_id' => 'Location',
			'email' => 'Email',
			'land_line' => 'Land Line',
			'mobile_number' => 'Mobile Number',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('station_id',$this->station_id,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('location_id',$this->location_id,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('land_line',$this->land_line,true);
		$criteria->compare('mobile_number',$this->mobile_number,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=> 1,
            ),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TblTest the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
