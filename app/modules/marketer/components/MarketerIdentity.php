<?php


class MarketerIdentity extends CUserIdentity
{
    private $_id;

	public function authenticate()
	{

		$marketer = Marketer::Model()->findByAttributes(array('username'=> $this->username));

        if($marketer===null){
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        }
        else{

            if(!$marketer->validate_password($this->password, $marketer->password)){
                
                $this->errorCode=self::ERROR_PASSWORD_INVALID;
            }
            else{
                $this->_id = $marketer->id;
                if(null===$marketer->last_login){
                    $lastLogin = date("Y-m-d H:i:s");
                }
                else{
                    $lastLogin = strtotime($marketer->last_login);
                }
                $this->setState('lastLogin',$lastLogin);
                $this->errorCode=self::ERROR_NONE;

            }



        }
        return !$this->errorCode;
	}

    public function getId(){

        return $this->_id;
    }
}