<?php


class UserIdentity extends CUserIdentity
{
    private $_id;

	public function authenticate()
	{

        $criteria = new CDbCriteria();
        $criteria->compare('LOWER(username)',strtolower($this->username),true);
        $user = User::Model()->find($criteria);
        $personnel = Personnel::Model()->find($criteria);
        $reader = Reader::Model()->find($criteria);


        if($user===null && $personnel===null && $reader===null){

            $this->errorCode=self::ERROR_USERNAME_INVALID;

        }
        else{
            if($user!==null){
                if(!$user->validate_password($this->password, $user->password)){
                    $this->errorCode=self::ERROR_PASSWORD_INVALID;
                }
                else{
                    $this->username = $user->username;
                    $this->_id = $user->id;
                    if(null===$user->dynamic->ulast_login){
                        $lastLogin = date("Y-m-d H:i:s");
                    }
                    else{
                        $lastLogin = strtotime($user->dynamic->ulast_login);
                    }

                    if($user->station_id === 'zzz'){
                        $arr = explode('#$%',$user->address);
                        $name = $arr[1];
                    }
                    else{
                        $name = $user->name;
                    }
                    $this->setPersistentStates(array('lastLogin'=>$lastLogin, 'tableName'=>$user->tableName(),
                        'subscription'=>$user->resetSubscription(), 'model'=>$user, 'station'=>$name)
                    );
                    $this->errorCode=self::ERROR_NONE;

                }
            }
            if($reader!==null){
                if(!CPasswordHelper::verifyPassword($this->password, $reader->password)){
                    $this->errorCode=self::ERROR_PASSWORD_INVALID;
                }
                else{
                    $this->username = $reader->username;
                    $user = User::model()->findByPk($reader->id);
                    $this->_id = $reader->id;
                    if(null===$user->dynamic->rlast_login){
                        $lastLogin = date("Y-m-d H:i:s");
                    }
                    else{
                        $lastLogin = strtotime($user->dynamic->rlast_login);
                    }
                    if($user->station_id === 'zzz'){
                        $arr = explode('#$%',$user->address);
                        $name = $arr[1];
                    }
                    else{
                        $name = $user->name;
                    }
                    $this->setPersistentStates(array('lastLogin'=>$lastLogin, 'tableName'=>$reader->tableName(),
                        'subscription'=>$user->resetSubscription(), 'model'=>$user, 'station'=>$name)
                    );
                    $this->errorCode=self::ERROR_NONE;

                }
            }
            if($personnel!==null){
                if(!CPasswordHelper::verifyPassword($this->password, $personnel->password)){
                    $this->errorCode=self::ERROR_PASSWORD_INVALID;
                }
                else{
                    $this->username = $personnel->username;
                    $user = User::model()->findByPk($personnel->id);
                    $this->_id = $personnel->id;
                    if(null===$user->dynamic->plast_login){
                        $lastLogin = date("Y-m-d H:i:s");
                    }
                    else{
                        $lastLogin = strtotime($user->dynamic->plast_login);
                    }
                    if($user->station_id === 'zzz'){
                        $arr = explode('#$%',$user->address);
                        $name = $arr[1];
                    }
                    else{
                        $name = $user->name;
                    }
                    $this->setPersistentStates(array('lastLogin'=>$lastLogin, 'tableName'=>$personnel->tableName(),
                        'subscription'=>$user->resetSubscription(), 'model'=>$user, 'station'=>$name)
                    );
                    $this->errorCode=self::ERROR_NONE;

                }
            }

        }
        return !$this->errorCode;
	}

    public function getId(){

        return $this->_id;
    }
}