<?php


class RecoveryForm extends CFormModel
{
	const  PROBLEM_USERNAME = 1;
    const  PROBLEM_PASSWORD = 2;
    const  PROBLEM_BOTH = 3;
    public $problemType;
	public $userPassword;
    public $mobile;
    public $username;
    public $email;
    public $securityAnswer;
	public $verifyCode;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
		);
	}

    public function getProblemType(){
        return array(
            self::PROBLEM_USERNAME => 'I cannot remember my username.',
            self::PROBLEM_PASSWORD => 'I have forgotten my password.',
            self::PROBLEM_BOTH => 'It\'s funny but i can\'t remember both.'
        );
    }

    public function solvePassword($email){

       return  $this->newPassword($email);
    }

    public function solveUsername($email){

        $user = User::model()->findByAttributes(array('email'=>$email));
        return $username = $user->username;
    }

    public function solveBoth($email){

        $password = $this->newPassword($email);
        $user = User::model()->findByAttributes(array('email'=>$email));
        $username = $user->username;

        return array(
            'password'=>$password,
            'username'=>$username
        );
    }

    public function newPassword($email){

        $user = User::model()->findByAttributes(array('email'=>$email));
        $password = $this->randomPassword();
        $newpswd = $user->hash($password);

        $sql = "UPDATE tbl_user SET password = :password WHERE id = :userid";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":userid", $user->id, PDO::PARAM_STR);
        $command->bindValue(":password", $newpswd, PDO::PARAM_STR);
        $command->execute();

        return $password;
    }

    public function randomPassword() {

        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

	public function attributeLabels()
	{
		return array(
			'verifyCode'=>'Verification Code',
            'problemType'=>'The problem is;'
		);
	}
}