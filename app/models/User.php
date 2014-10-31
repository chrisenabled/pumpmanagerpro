<?php

class User extends PmpActiveRecord
{

    public $verifyCode;
    public $password_repeat;
    public $other;
    public $line_1;
    public $line_2;
    public $security_question;
    public $security_answer;
    public $agreement = false;
    public $marketerId;
    public $state;

    public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'tbl_user';
	}

	public function rules()
	{

		return array(
			array('username, password, station_id, location_id, email, mobile_number, line_1,security_question,security_answer,state',
                'required', 'message'=>'This field cannot be blank.'),
            array('username','unique','message'=>'This username has already been taken'),
            array('email,mobile_number', 'unique'),
			array('username, password', 'length','max'=>30, 'min'=>6, 'message'=>'Minimum of 6 characters'),
            array('marketerId','checkMarketer'),
            array('username','whiteSpace'),
            array('username', 'uniqueUsername'),
            array('mobile_number', 'mobilePattern'),
            array('password', 'length', 'min'=>6),
            array('password','compare','message'=>'Your password must be repeated exactly below.'),
			array('address', 'length', 'max'=>256),
			array('email', 'length', 'max'=>50),
            array('email', 'email', 'message'=>'Your email address is not valid.'),
            array('agreement','agreement'),
            array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
            array('verifyCode, password_repeat, other,line_1,line_2, agreement, security_question, security_answer, marketerId, state', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, username, station_id, location_id, email, mobile_number', 'safe', 'on'=>'search'),
		);
	}

    public function whiteSpace($attribute){

        if((preg_match('/\s/',$this->$attribute)) == 1){
            $this->addError($attribute,'Please use only letters (a-z), numbers, and periods.');
        }
    }
    public function trimAttributes($attributes){
        $mask = array(" ", "(", ")", "-");
        foreach($attributes as $attribute){
            $this->$attribute = str_replace($mask, "", $this->$attribute);
            if($this->$attribute === ''){$this->$attribute = 'None';}
        }

    }
    public function checkMarketer($attribute){
        if(str_replace(' ', '', $this->$attribute) !== ''){
            $sql = "SELECT * FROM tbl_marketer WHERE marketer_id = :id LIMIT 1;";
            $command = Yii::app()->db->createCommand($sql);
            $command->bindValue(":id", $this->$attribute, PDO::PARAM_STR);
            $result = $command->execute();
            if($result != 1){
                $this->addError($attribute,'This marketer code is incorrect.');
            }
        }
    }

    public function mobilePattern($attribute)
    {
        if(substr($this->$attribute, 0,5) !== '(080)' && substr($this->$attribute, 0,5) !== '(070)' &&
            substr($this->$attribute, 0,5) !== '(081)'){
            $this->addError($attribute,'Please write a correct nigerian mobile number.');
        }
    }
    protected  function beforeSave(){

        if($this->isNewRecord){
            $pre_id = $this->station_id;
            $pre_id .= $this->location_id;
            $counter = 1;
            $concat = $pre_id.$counter;

            $this->trimAttributes(array('marketerId','mobile_number','land_line'));

            while(count(User::Model()->findByPk($concat)) == 1){

                $counter += 1;
                $concat = $pre_id.$counter;
            }
            $this->id = $concat;

            $this->address = $this->line_1." ".$this->line_2;
            if($this->station_id==='zzz'){
                $this->address.='#$%'.$this->other;
            }
            $this->password = $this->hash($this->password);
        }
        return parent::beforeSave();
    }

    protected function afterSave(){

        if($this->isNewRecord){
            $transaction = Yii::app()->db->getCurrentTransaction() === null ? Yii::app()->db->beginTransaction() : false;

            try{
                $date_created = date("Y-m-d H:i:s");
                $date = strtotime("now");
                $endDate = strtotime("+14 days");
                $date = $this->encryptIt($date);
                $endDate = $this->encryptIt($endDate);
                $this->security_answer =  preg_replace('/\s+/', '', $this->security_answer);

                $sql = "INSERT INTO tbl_user_static (user_id, security_question, security_answer, marketer_id, udate_created)
                        VALUES (:id, :sq, :sa, :marketer_id, :date_created)";
                $command = Yii::app()->db->createCommand($sql);
                $command->bindValue(":id", $this->id, PDO::PARAM_STR);
                $command->bindValue(":sq", $this->security_question, PDO::PARAM_STR);
                $command->bindValue(":sa", $this->security_answer, PDO::PARAM_STR);
                $command->bindValue(":marketer_id", $this->marketerId, PDO::PARAM_STR);
                $command->bindValue(":date_created", $date_created, PDO::PARAM_STR);
                $command->execute();

                $sql = "INSERT INTO tbl_user_dynamic (user_id, start_date, end_date)
                    VALUES (:id, :start_date, :end_date)";
                $command = Yii::app()->db->createCommand($sql);
                $command->bindValue(":id", $this->id, PDO::PARAM_STR);
                $command->bindValue(":start_date", $date, PDO::PARAM_STR);
                $command->bindValue(":end_date", $endDate, PDO::PARAM_STR);
                $command->execute();

                $sql = "INSERT INTO tbl_keep (user_id) VALUES (:id)";
                $command = Yii::app()->db->createCommand($sql);
                $command->bindValue(":id", $this->id, PDO::PARAM_STR);
                $command->execute();



                if($transaction){
                    $transaction->commit();
                }
            }
            catch(Exception $e){
                if($transaction){
                    $transaction->rollback();
                    throw $e;
                }
                else{
                    throw $e;
                }
            }
        }

        return parent::afterSave();
    }

    public function agreement($attribute){
        if($this->isNewRecord){
            if(!$this->$attribute){
                $this->addError($attribute,'You must agree to Pump Manager Pro\'s Terms of Service and Policy to proceed. ');
            }
        }
    }

    public function uniqueUsername($attribute){

        $account = Personnel::sqlPersonnel($this->$attribute);
        if(strtolower($account['username']) === strtolower($this->$attribute)){
            $this->addError($attribute,'Username'.' '.'"'.$this->$attribute.'"'.' '.'has already been taken.');
        }
        else{
            $account = Reader::sqlReader($this->$attribute);
            if(strtolower($account['username']) === strtolower($this->$attribute)){
                $this->addError($attribute,'Username'.' '.'"'.$this->$attribute.'"'.' '.'has already been taken.');
            }
        }

    }
    public static  function sqlUser($attribute){
        $sql = "SELECT username,id FROM tbl_user WHERE username = :username LIMIT 1;";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":username", $attribute, PDO::PARAM_STR);
        return $command->queryRow();

    }

    public function resetSubscription($noOfDays = 0,$username = NULL){

        $endDate = UserDynamic::sqlDynamic($this->id);
        $endDate = (int) $this->decryptIt($endDate['end_date']);
        $time = time();
        $id = $this->id;
        $remaining = $endDate - (int)$time;
        if($username !== NULL){
            $user = User::sqlUser($username);
            $id = $user['id'];
        }

        if($noOfDays > 0){
            $noOfDays =  (int)strtotime('+'. $noOfDays .' days') - (int)$time;
            if($time > $endDate){
                $remaining = $noOfDays;
            }
            else{
                $remaining = ($endDate - (int)$time) + $noOfDays;
            }
            $endDate = strtotime('+'. $remaining .' seconds');
            $time = $this->encryptIt($time);
            $endDate = $this->encryptIt($endDate);

            $transaction = Yii::app()->db->getCurrentTransaction() === null ? Yii::app()->db->beginTransaction() : false;

            try{
                $sql = "UPDATE tbl_user_dynamic SET start_date = :startDate, end_date = :endDate
                   WHERE user_id = :userid LIMIT 1;";
                $command = Yii::app()->db->createCommand($sql);
                $command->bindValue(":userid", $id, PDO::PARAM_STR);
                $command->bindValue(":startDate", $time, PDO::PARAM_STR);
                $command->bindValue(":endDate", $endDate, PDO::PARAM_STR);
                $command->execute();
                $sql = "UPDATE tbl_keep SET keep = :keep WHERE user_id = :userid";
                $command = Yii::app()->db->createCommand($sql);
                $command->bindValue(":userid", $id, PDO::PARAM_STR);
                $command->bindValue(":keep", 0, PDO::PARAM_STR);
                $command->execute();

                if($transaction){
                    $transaction->commit();
                }
            }
            catch(Exception $e){
                if($transaction){
                    $transaction->rollback();
                    throw $e;
                }
                else{
                    throw $e;
                }
            }
        }

        if($remaining <= 0){
            $remaining = 0;
        }
        else{
            $remaining =(($remaining/24)/60)/60;
        }

        if(Yii::app()->user->hasState("subscription") && Yii::app()->user->id == $this->id){
            Yii::app()->user->subscription = $remaining;
        }
        else{
            return $remaining;
        }
    }

    public static function getKeepState(){

        $sql = "SELECT keep FROM tbl_keep WHERE user_id = :id LIMIT 1;";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":id", Yii::app()->user->id, PDO::PARAM_STR);
        return $command->queryRow();
    }

    public function getPaymentHistory(){

        $sql = "SELECT * FROM tbl_order  WHERE user_id = :id ORDER BY date_created DESC;";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":id", Yii::app()->user->id, PDO::PARAM_STR);
        return $command->queryAll();
    }

    public static function getCurrentSubscription(){

        $sql = "SELECT * FROM tbl_order  WHERE user_id = :id ORDER BY date_created DESC LIMIT 1";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":id", Yii::app()->user->id, PDO::PARAM_STR);
        return $command->queryRow();
    }

    public static  function getReceipt($id){

        $sql = "SELECT * FROM tbl_order WHERE order_id = :id";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":id", $id, PDO::PARAM_STR);
        return $command->queryRow();
    }

    public function getStationOptions(){
        $stationArray = CHtml::listData(Station::Model()->findAll(), 'id', 'name');
        return $stationArray;
    }

    public function getLocationOptions($state){

        $locationArray = CHtml::listData(Location::Model()->findAllByAttributes(array('state_id'=>$state)), 'id', 'city');

        return $locationArray;
    }

    public function getStateOptions(){
        return $stateArray = CHtml::listData(State::Model()->findAll(), 'id', 'state');
    }

    public function getSecurityQuestions(){
        return array(
            ' What was your childhood nickname?',
            ' In what city did you meet your spouse?',
            ' What is the middle name of your oldest child?',
            ' What school did you attend for sixth grade?',
            ' In what city or town did your mother and father meet?',
            ' What is the name of the company of your first job?',
            ' In what city or town was your first job?',
            ' What is your maternal grandmother\'s maiden name?',
            ' What is your oldest sibling\'s middle name?',
            ' What is the country of your ultimate dream vacation?',
            ' To what city did you go on your honeymoon?',
            ' What time of the day were you born?',
            ' What is your spouse\'s mother\'s maiden name?',
            ' What was your dream job as a child?',
            ' What are the last 5 digits of your driver\'s license number?',
            ' What is your grandmother\'s first name?',
            ' What was the make and model of your first car?',
            ' What is your preferred musical genre?',
            ' What is your mother\'s middle name? ',
            ' What year did you graduate from High School?',
            ' In what year was your father born?',
            ' What is your favorite movie?',
            ' What is your mother\'s maiden name?',
            ' What is your mother\'s (father\'s) first name?',
            ' Largest amount of money you have lent that was never paid back?',
            ' Which of your siblings was your parents\' favorite?'

        );
    }
    public function getSecurityQuestionText(){

        $securityText = $this->securityQuestions;
        return isset($securityText[$this->static->security_question]) ? $securityText[$this->static->security_question]
            : "unknown type ({$this->static->security_question})";

    }

    public function getName(){

        $no = substr($this->id, 6);
        if(strlen($no) == 1) $no = '0'.$no;
        $name = '';
        $name .= $this->station->name;
        $name .= ' ';
        $name .= $this->location->city;
        $name .= ' ';
        $name .=$no;


        return $name;
    }

    private  function calc($pumpStats, $expenditures){

        $gain = 0.00;
        $revenue = 0.00;
        $offset =  0.00;
        $expense = 0.00;
        $soldQty = 0.00;

        foreach($pumpStats as $pumpStat){
            $gain += $pumpStat['profit'];
            $revenue += $pumpStat['sold_qty_revenue'];
            $offset += $pumpStat['offset'];
            $soldQty += $pumpStat['sold_qty'];
        }

        foreach($expenditures as $expenditure){
            $expense += $expenditure['expense'];
        }

        $netProfit = $gain - $expense;

        return array(
            'gain'=>ceil($gain),'revenue'=>ceil($revenue),
            'offset'=>ceil($offset), 'expense'=>ceil($expense),
            'netProfit'=>ceil($netProfit), 'soldQty'=>ceil($soldQty)
        );
    }

    public function getDaily(){

        $date = date("Y-m-d");
        try{
            $sql = "SELECT * FROM tbl_pump_stat WHERE user_id = :id AND record_date = :date";
            $command = Yii::app()->db->createCommand($sql);
            $command->bindValue(":id", Yii::app()->user->id, PDO::PARAM_STR);
            $command->bindValue(":date", $date, PDO::PARAM_STR);
            $pumpStats =  $command->queryAll();

            $sql = "SELECT * FROM tbl_expenditure WHERE user_id = :id AND this_date = :date";
            $command = Yii::app()->db->createCommand($sql);
            $command->bindValue(":id", Yii::app()->user->id, PDO::PARAM_STR);
            $command->bindValue(":date", $date, PDO::PARAM_STR);
            $expenditures =  $command->queryAll();

        }
        catch(Exception $e){
                throw $e;
        }

        return $this->calc($pumpStats, $expenditures);


    }

    public function getWeekly(){

        $strtDate = date("Y-m-d", strtotime('this week monday'));
        $endDate = date("Y-m-d", strtotime('this sunday'));
        if(date("Y-m-d", strtotime('NOW')) === $endDate){
            $strtDate = date("Y-m-d", strtotime('last monday'));
        }

        try{
            $sql = "SELECT * FROM tbl_pump_stat WHERE user_id = :id AND
            record_date >= :startDate AND record_date <= :endDate";
            $command = Yii::app()->db->createCommand($sql);
            $command->bindValue(":id", Yii::app()->user->id, PDO::PARAM_STR);
            $command->bindValue(":startDate", $strtDate, PDO::PARAM_STR);
            $command->bindValue(":endDate", $endDate, PDO::PARAM_STR);
            $pumpStats =  $command->queryAll();

            $sql = "SELECT * FROM tbl_expenditure WHERE user_id = :id AND
            this_date >= :startDate AND this_date <= :endDate";
            $command = Yii::app()->db->createCommand($sql);
            $command->bindValue(":id", Yii::app()->user->id, PDO::PARAM_STR);
            $command->bindValue(":startDate", $strtDate, PDO::PARAM_STR);
            $command->bindValue(":endDate", $endDate, PDO::PARAM_STR);
            $expenditures =  $command->queryAll();
        }
        catch(Exception $e){
            throw $e;
        }

        return $this->calc($pumpStats, $expenditures);

    }

    public function getMonthly(){

        $strtDate = date("Y-m-d", strtotime('first day of this month'));
        $endDate = date("Y-m-d", strtotime('last day of this month'));

        try{
            $sql = "SELECT * FROM tbl_pump_stat WHERE user_id = :id AND
            record_date >= :startDate AND record_date <= :endDate";
            $command = Yii::app()->db->createCommand($sql);
            $command->bindValue(":id", Yii::app()->user->id, PDO::PARAM_STR);
            $command->bindValue(":startDate", $strtDate, PDO::PARAM_STR);
            $command->bindValue(":endDate", $endDate, PDO::PARAM_STR);
            $pumpStats =  $command->queryAll();

            $sql = "SELECT * FROM tbl_expenditure WHERE user_id = :id AND
            this_date >= :startDate AND this_date <= :endDate";
            $command = Yii::app()->db->createCommand($sql);
            $command->bindValue(":id", Yii::app()->user->id, PDO::PARAM_STR);
            $command->bindValue(":startDate", $strtDate, PDO::PARAM_STR);
            $command->bindValue(":endDate", $endDate, PDO::PARAM_STR);
            $expenditures =  $command->queryAll();
        }
        catch(Exception $e){
            throw $e;
        }

        return $this->calc($pumpStats, $expenditures);

    }

    public function getYearly(){

        $strtDate = date("Y-m-d", strtotime('first day of january '.date('Y')));
        $endDate = date("Y-m-d", strtotime('last day of december '.date('Y')));

        try{
            $sql = "SELECT * FROM tbl_pump_stat WHERE user_id = :id AND
            record_date >= :startDate AND record_date <= :endDate";
            $command = Yii::app()->db->createCommand($sql);
            $command->bindValue(":id", Yii::app()->user->id, PDO::PARAM_STR);
            $command->bindValue(":startDate", $strtDate, PDO::PARAM_STR);
            $command->bindValue(":endDate", $endDate, PDO::PARAM_STR);
            $pumpStats =  $command->queryAll();

            $sql = "SELECT * FROM tbl_expenditure WHERE user_id = :id AND
            this_date >= :startDate AND this_date <= :endDate";
            $command = Yii::app()->db->createCommand($sql);
            $command->bindValue(":id", Yii::app()->user->id, PDO::PARAM_STR);
            $command->bindValue(":startDate", $strtDate, PDO::PARAM_STR);
            $command->bindValue(":endDate", $endDate, PDO::PARAM_STR);
            $expenditures =  $command->queryAll();
        }
        catch(Exception $e){
            throw $e;
        }

        return $this->calc($pumpStats, $expenditures);
    }

    public function changeQuestion($question, $answer){
        $transaction = Yii::app()->db->getCurrentTransaction() === null ? Yii::app()->db->beginTransaction() : false;
        try{
            $sql = "UPDATE tbl_user_static SET security_question = :question, security_answer = :answer WHERE user_id = :userid";
            $command = Yii::app()->db->createCommand($sql);
            $command->bindValue(":userid", $this->id, PDO::PARAM_STR);
            $command->bindValue(":question", $question, PDO::PARAM_STR);
            $command->bindValue(":answer", $answer, PDO::PARAM_STR);
            $command->execute();
            if($transaction){
                $transaction->commit();
            }
        }
        catch(Exception $e){
            if($transaction){
                $transaction->rollback();
                throw $e;
            }
            else{
                throw $e;
            }
        }
    }

    public function changeUsername($username){
        $transaction = Yii::app()->db->getCurrentTransaction() === null ? Yii::app()->db->beginTransaction() : false;
        try{
            $sql = "UPDATE tbl_user SET username = :username WHERE id = :userid";
            $command = Yii::app()->db->createCommand($sql);
            $command->bindValue(":userid", $this->id, PDO::PARAM_STR);
            $command->bindValue(":username", $username, PDO::PARAM_STR);
            $command->execute();
            if($transaction){
                $transaction->commit();
            }
        }
        catch(Exception $e){
            if($transaction){
                $transaction->rollback();
                throw $e;
            }
            else{
                throw $e;
            }
        }
    }

    public function changePswd($password){
        $transaction = Yii::app()->db->getCurrentTransaction() === null ? Yii::app()->db->beginTransaction() : false;
        try{
            $newpswd = $this->hash($password);
            $sql = "UPDATE tbl_user SET password = :password WHERE id = :userid LIMIT 1;";
            $command = Yii::app()->db->createCommand($sql);
            $command->bindValue(":userid", $this->id, PDO::PARAM_STR);
            $command->bindValue(":password", $newpswd, PDO::PARAM_STR);
            $command->execute();
            if($transaction){
                $transaction->commit();
            }
        }
        catch(Exception $e){
            if($transaction){
                $transaction->rollback();
                throw $e;
            }
            else{
                throw $e;
            }
        }
    }

    public function changeAddress($line_1, $line_2){
        $address = $line_1.' '.$line_2;
        if($this->station_id==='zzz'){
            $arr = explode('#$%',$this->address);
            $address .= '#$%'.$arr[1];
        }
        $transaction = Yii::app()->db->getCurrentTransaction() === null ? Yii::app()->db->beginTransaction() : false;
        try{
            $sql = "UPDATE tbl_user SET address = :address WHERE id = :userid LIMIT 1;";
            $command = Yii::app()->db->createCommand($sql);
            $command->bindValue(":userid", $this->id, PDO::PARAM_STR);
            $command->bindValue(":address", $address, PDO::PARAM_STR);
            $command->execute();
            if($transaction){
                $transaction->commit();
            }
        }
        catch(Exception $e){
            if($transaction){
                $transaction->rollback();
                throw $e;
            }
            else{
                throw $e;
            }
        }
    }

    public function changeContact($email, $landline, $mobile){
        $transaction = Yii::app()->db->getCurrentTransaction() === null ? Yii::app()->db->beginTransaction() : false;
        try{
            if($email !== $this->email && ($email !== null || $email !== '')){
                $req = CValidator::createValidator('email',$this,array('email'));
                $sql = "UPDATE tbl_user SET email = :email WHERE id = :userid LIMIT 1;";
                $command = Yii::app()->db->createCommand($sql);
                $command->bindValue(":userid", $this->id, PDO::PARAM_STR);
                $command->bindValue(":email", $email, PDO::PARAM_STR);
                $command->execute();
            }
            if($landline !== $this->land_line && ($landline !== null || $landline !== '')){
                $sql = "UPDATE tbl_user SET land_line = :landline WHERE id = :userid LIMIT 1;";
                $command = Yii::app()->db->createCommand($sql);
                $command->bindValue(":userid", $this->id, PDO::PARAM_STR);
                $command->bindValue(":landline", $landline, PDO::PARAM_STR);
                $command->execute();
            }
            if($mobile !== $this->mobile_number && ($mobile !== null || $mobile !== '')){
                $sql = "UPDATE tbl_user SET mobile_number = :mobile WHERE id = :userid LIMIT 1;";
                $command = Yii::app()->db->createCommand($sql);
                $command->bindValue(":userid", $this->id, PDO::PARAM_STR);
                $command->bindValue(":mobile", $mobile, PDO::PARAM_STR);
                $command->execute();
            }
            if($transaction){
                $transaction->commit();
            }
        }
        catch(Exception $e){
            if($transaction){
                $transaction->rollback();
                throw $e;
            }
            else{
                throw $e;
            }
        }
    }

    public static function rollBack(){

        $todayBegin = date("Y-m-d 00:00:00");
        $todayEnd = date("Y-m-d 23:59:59");
        $today = date("Y-m-d");

        $transaction = Yii::app()->db->getCurrentTransaction() === null ? Yii::app()->db->beginTransaction() : false;
        try{
            $sql = "SELECT * FROM tbl_pump_stat WHERE user_id = :id AND
            date_created >= :todayBegin AND date_created <= :todayEnd";
            $command = Yii::app()->db->createCommand($sql);
            $command->bindValue(":id", Yii::app()->user->id, PDO::PARAM_STR);
            $command->bindValue(":todayBegin", $todayBegin, PDO::PARAM_STR);
            $command->bindValue(":todayEnd", $todayEnd, PDO::PARAM_STR);
            $pumpStats =  $command->queryAll();

            $sql = "SELECT * FROM tbl_tank WHERE user_id = :id AND
            updated >= :todayBegin AND updated <= :todayEnd";
            $command = Yii::app()->db->createCommand($sql);
            $command->bindValue(":id", Yii::app()->user->id, PDO::PARAM_STR);
            $command->bindValue(":todayBegin", $todayBegin, PDO::PARAM_STR);
            $command->bindValue(":todayEnd", $todayEnd, PDO::PARAM_STR);
            $tanks =  $command->queryAll();

            foreach($tanks as $tank){

                $sql = "SELECT qty_added FROM tbl_tank_stat WHERE user_id = :id AND tank_no = :tankNo AND date_created = :today";
                $command = Yii::app()->db->createCommand($sql);
                $command->bindValue(":id", Yii::app()->user->id, PDO::PARAM_STR);
                $command->bindValue(":tankNo", $tank['tank_no'], PDO::PARAM_STR);
                $command->bindValue(":today", $today, PDO::PARAM_STR);
                $tankStats =  $command->queryAll();
                $added = 0;
                foreach($tankStats as $tankStat){
                    $added += $tankStat['qty_added'];
                }
                $added = -($added);
                $sql = "UPDATE tbl_tank SET added_qty = :added WHERE id = :tankId";
                $command = Yii::app()->db->createCommand($sql);
                $command->bindValue(":tankId", $tank['id'], PDO::PARAM_STR);
                $command->bindValue(":added", $added, PDO::PARAM_STR);
                $command->execute();
                $added = 0;
                $sql = "UPDATE tbl_tank SET added_qty = :added WHERE id = :tankId";
                $command = Yii::app()->db->createCommand($sql);
                $command->bindValue(":tankId", $tank['id'], PDO::PARAM_STR);
                $command->bindValue(":added", $added, PDO::PARAM_STR);
                $command->execute();

            }


            foreach($pumpStats as $pumpStat){

                $added = $pumpStat['sold_qty'];
                $sql = "UPDATE tbl_tank SET added_qty = :added WHERE user_id = :userid AND tank_no = :tankNo";
                $command = Yii::app()->db->createCommand($sql);
                $command->bindValue(":userid", Yii::app()->user->id, PDO::PARAM_STR);
                $command->bindValue(":added", $added, PDO::PARAM_STR);
                $command->bindValue(":tankNo", $pumpStat['tank'], PDO::PARAM_INT);
                $command->execute();
                $added = 0;
                $sql = "UPDATE tbl_tank SET added_qty = :added WHERE user_id = :userid AND tank_no = :tankNo";
                $command = Yii::app()->db->createCommand($sql);
                $command->bindValue(":userid", Yii::app()->user->id, PDO::PARAM_STR);
                $command->bindValue(":added", $added, PDO::PARAM_STR);
                $command->bindValue(":tankNo", $pumpStat['tank'], PDO::PARAM_INT);
                $command->execute();
            }

            $sql = "DELETE FROM tbl_pump_stat WHERE date_created >= :todayBegin AND date_created <= :todayEnd AND user_id = :userid";
            $command = Yii::app()->db->createCommand($sql);
            $command->bindValue(":userid", Yii::app()->user->id, PDO::PARAM_STR);
            $command->bindValue(":todayBegin", $todayBegin, PDO::PARAM_STR);
            $command->bindValue(":todayEnd", $todayEnd, PDO::PARAM_STR);
            $command->execute();

            $sql = "DELETE FROM tbl_stock_stat WHERE date_created >= :todayBegin AND date_created <= :todayEnd AND user_id = :userid";
            $command = Yii::app()->db->createCommand($sql);
            $command->bindValue(":userid", Yii::app()->user->id, PDO::PARAM_STR);
            $command->bindValue(":todayBegin", $todayBegin, PDO::PARAM_STR);
            $command->bindValue(":todayEnd", $todayEnd, PDO::PARAM_STR);
            $command->execute();

            $sql = "DELETE FROM tbl_tank_stat WHERE date_created = :today AND user_id = :userid";
            $command = Yii::app()->db->createCommand($sql);
            $command->bindValue(":userid", Yii::app()->user->id, PDO::PARAM_STR);
            $command->bindValue(":today", $today, PDO::PARAM_STR);
            $command->execute();

            $sql = "DELETE FROM tbl_expenditure WHERE date_created >= :todayBegin AND date_created <= :todayEnd AND user_id = :userid";
            $command = Yii::app()->db->createCommand($sql);
            $command->bindValue(":userid", Yii::app()->user->id, PDO::PARAM_STR);
            $command->bindValue(":todayBegin", $todayBegin, PDO::PARAM_STR);
            $command->bindValue(":todayEnd", $todayEnd, PDO::PARAM_STR);
            $command->execute();

            $sql = "DELETE FROM tbl_invoice WHERE date_created >= :todayBegin AND date_created <= :todayEnd AND user_id = :userid";
            $command = Yii::app()->db->createCommand($sql);
            $command->bindValue(":userid", Yii::app()->user->id, PDO::PARAM_STR);
            $command->bindValue(":todayBegin", $todayBegin, PDO::PARAM_STR);
            $command->bindValue(":todayEnd", $todayEnd, PDO::PARAM_STR);
            $command->execute();
            if($transaction){
                $transaction->commit();
            }
        }

        catch(Exception $e){
            if($transaction){
                $transaction->rollback();
                throw $e;
            }
            else{
                throw $e;
            }
        }

    }

    public static  function todaysRecord(){

        $todayBegin = date("Y-m-d 00:00:00");
        $todayEnd = date("Y-m-d 23:59:59");
        $today = date("Y-m-d");
        $added = array();
        $criteria = new CDbCriteria();
        $criteria->condition = 'date_created >= :strtDate AND date_created <= :endDate';
        $criteria->params = array(':strtDate'=>$todayBegin, ':endDate'=>$todayEnd);

        try{
            $pumpStats = PumpStat::model()->findAllByAttributes(array('user_id'=>Yii::app()->user->id),$criteria);

            $sql = "SELECT * FROM tbl_expenditure WHERE user_id = :id AND
            date_created >= :todayBegin AND date_created <= :todayEnd";
            $command = Yii::app()->db->createCommand($sql);
            $command->bindValue(":id", Yii::app()->user->id, PDO::PARAM_STR);
            $command->bindValue(":todayBegin", $todayBegin, PDO::PARAM_STR);
            $command->bindValue(":todayEnd", $todayEnd, PDO::PARAM_STR);
            $expenditure =  $command->queryAll();

            $sql = "SELECT * FROM tbl_invoice WHERE user_id = :id AND
            date_created >= :todayBegin AND date_created <= :todayEnd";
            $command = Yii::app()->db->createCommand($sql);
            $command->bindValue(":id", Yii::app()->user->id, PDO::PARAM_STR);
            $command->bindValue(":todayBegin", $todayBegin, PDO::PARAM_STR);
            $command->bindValue(":todayEnd", $todayEnd, PDO::PARAM_STR);
            $invoice =  $command->queryAll();

            $sql = "SELECT * FROM tbl_tank_stat WHERE user_id = :id AND date_created = :today";
            $command = Yii::app()->db->createCommand($sql);
            $command->bindValue(":id", Yii::app()->user->id, PDO::PARAM_STR);
            $command->bindValue(":today", $today, PDO::PARAM_STR);
            $tanks =  $command->queryAll();
        }
        catch(Exception $e){
            throw $e;
        }

        return array('pumpStats'=>$pumpStats, 'tanks'=>$tanks,
            'expenditure'=>$expenditure, 'invoices'=>$invoice);
    }

    public static function todayHasRecord(){

        $todayBegin = date("Y-m-d 00:00:00");
        $todayEnd = date("Y-m-d 23:59:59");

        try{
            $sql = "SELECT user_id FROM tbl_pump_stat WHERE user_id = :id AND date_created >= :todayBegin AND date_created <= :todayEnd";
            $command = Yii::app()->db->createCommand($sql);
            $command->bindValue(":id", Yii::app()->user->id, PDO::PARAM_STR);
            $command->bindValue(":todayBegin", $todayBegin, PDO::PARAM_STR);
            $command->bindValue(":todayEnd", $todayEnd, PDO::PARAM_STR);
            $stats =  $command->queryScalar();
            if($stats === Yii::app()->user->id){return true;}
            else{
                $sql = "SELECT added_qty FROM tbl_tank WHERE user_id = :id AND updated >= :todayBegin AND updated <= :todayEnd";
                $command = Yii::app()->db->createCommand($sql);
                $command->bindValue(":id", Yii::app()->user->id, PDO::PARAM_STR);
                $command->bindValue(":todayBegin", $todayBegin, PDO::PARAM_STR);
                $command->bindValue(":todayEnd", $todayEnd, PDO::PARAM_STR);
                $stats =  $command->queryScalar();
                if($stats > 0 ){return true;}
                else{
                    $sql = "SELECT user_id FROM tbl_invoice WHERE user_id = :id AND date_created >= :todayBegin AND date_created <= :todayEnd";
                    $command = Yii::app()->db->createCommand($sql);
                    $command->bindValue(":id", Yii::app()->user->id, PDO::PARAM_STR);
                    $command->bindValue(":todayBegin", $todayBegin, PDO::PARAM_STR);
                    $command->bindValue(":todayEnd", $todayEnd, PDO::PARAM_STR);
                    $stats =  $command->queryScalar();
                    if($stats === Yii::app()->user->id){return true;}
                    else{
                        $sql = "SELECT user_id FROM tbl_expenditure WHERE user_id = :id AND date_created >= :todayBegin AND date_created <= :todayEnd";
                        $command = Yii::app()->db->createCommand($sql);
                        $command->bindValue(":id", Yii::app()->user->id, PDO::PARAM_STR);
                        $command->bindValue(":todayBegin", $todayBegin, PDO::PARAM_STR);
                        $command->bindValue(":todayEnd", $todayEnd, PDO::PARAM_STR);
                        $stats =  $command->queryScalar();
                        if($stats === Yii::app()->user->id){return true;}
                        else{
                            return false;
                        }
                    }
                }
            }
        }
        catch(Exception $e){
            throw $e;
        }

    }

    /**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'attendants' => array(self::HAS_MANY, 'Attendant', 'user_id'),
            'personnel'=>array(self::HAS_ONE,'Personnel','id'),
            'reader'=>array(self::HAS_ONE,'Reader','id'),
            'invoice'=>array(self::HAS_MANY,'Invoice','user_id'),
			'pumps' => array(self::HAS_MANY, 'Pump', 'user_id'),
			'stocks' => array(self::HAS_MANY, 'Stock', 'user_id'),
			'tanks' => array(self::HAS_MANY, 'Tank', 'user_id'),
			'station' => array(self::BELONGS_TO, 'Station', 'station_id'),
			'location' => array(self::BELONGS_TO, 'Location', 'location_id'),
            'stockStats'=> array(self::HAS_MANY, 'StockStat', 'user_id'),
            'pumpStats'=> array(self::HAS_MANY, 'PumpStat', 'user_id'),
            'expenditures'=> array(self::HAS_MANY, 'Expenditure','user_id'),
            'static'=>array(self::HAS_ONE, 'UserStatic', 'user_id'),
            'dynamic'=>array(self::HAS_ONE, 'UserDynamic', 'user_id'),
            'message'=>array(self::HAS_MANY, 'Message', 'user_id'),


        );
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => Yii::app()->user->isGuest ? 'Pick a Username' : 'Username',
			'password' => Yii::app()->user->isGuest ? 'Conjure a Password' :'Password',
			'station_id' => 'Your Station',
			'address' => 'Your Station Address',
			'location_id' => 'City',
            'verifyCode'=>'Verification Code',
			'email' => 'Your valid email address',
			'land_line' => 'Official Land Line',
			'mobile_number' => 'Official mobile number',
            'password_repeat'=>'Repeat your Password',
            'agreement'=>'Agreement',
            'marketerId'=>'Marketer code (for PMP marketers only)'

		);
	}


	public function search()
	{

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('username',$this->username,true);
		//$criteria->compare('password',$this->password,true);
		$criteria->compare('station_id',$this->station_id,true);
		//$criteria->compare('address',$this->address,true);
		$criteria->compare('location_id',$this->location_id,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('land_line',$this->land_line,true);
		$criteria->compare('mobile_number',$this->mobile_number,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}