<?php


class Message extends CActiveRecord
{

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'tbl_message';
	}

	public function rules()
	{
		return array(
			array('title, content', 'required'),
			array('title', 'length', 'max'=>20),
			array('content', 'length', 'max'=>255),
			array('id, user_id, title, msg_status, content, date_created', 'safe', 'on'=>'search'),
		);
	}

    public static function welcomeMessage($customerId){

        $title = 'Welcome to pump manager pro';
        $content = '';
        $sql = "INSERT INTO tbl_message (user_id, title, content)
                        VALUES (:userId, :title, :content)";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":userId", $customerId, PDO::PARAM_STR);
        $command->bindValue(":title", $title, PDO::PARAM_STR);
        $command->bindValue(":content", $content, PDO::PARAM_STR);
        $command->execute();
    }

	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'title' => 'Title',
			'msg_status' => 'Msg Status',
			'content' => 'Content',
			'date_created' => 'Date Created',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
        $criteria->compare('user_id',Yii::app()->user->id,true);
        $criteria->compare('title',$this->title,true);
		$criteria->compare('msg_status',$this->msg_status);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('date_created',$this->date_created,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}