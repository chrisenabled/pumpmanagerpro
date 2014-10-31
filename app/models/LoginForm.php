<?php

class LoginForm extends CFormModel
{
	public $username;
	public $password;
	public $rememberMe;

    private $_identity;

	public function rules()
	{
		return array(
			// username and password are required
			array('username, password', 'required'),
			// password needs to be authenticated
			array('password', 'authenticate'),

        );
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			$this->_identity=new UserIdentity($this->username,$this->password);
			if(!$this->_identity->authenticate())
				$this->addError('password','Incorrect username or password.');
		}
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		if($this->_identity===null)
		{
			$this->_identity=new UserIdentity($this->username,$this->password);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
            $duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days

			Yii::app()->user->login($this->_identity,$duration);

            $lastLogin = date("Y-m-d H:i:s");

            if(Yii::app()->user->tableName === 'tbl_user'){
                $sql = "UPDATE tbl_user_dynamic SET ulast_login = :lastLogin WHERE user_id = :userid";
            }
            if(Yii::app()->user->tableName === 'tbl_personnel'){
                $sql = "UPDATE tbl_user_dynamic SET plast_login = :lastLogin WHERE user_id = :userid";
            }
            if(Yii::app()->user->tableName === 'tbl_reader'){
                $sql = "UPDATE tbl_user_dynamic SET rlast_login = :lastLogin WHERE user_id = :userid";
            }
            $command = Yii::app()->db->createCommand($sql);
            $command->bindValue(":userid", $this->_identity->id, PDO::PARAM_STR);
            $command->bindValue(":lastLogin", $lastLogin, PDO::PARAM_STR);
            $command->execute();
            Tank::wipeStats();
            Yii::app()->user->setState('todayHasRecord',User::todayHasRecord());
            return true;
		}
		else
			return false;
	}
}
