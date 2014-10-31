<?php

class SiteController extends Controller
{
    public $layout='//layouts/bootstrap2';



    public function actions()
	{
		return array(
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}


    public function actionMetro(){
       $this->layout = '//layouts/MetroUI';
        $this->render('metroUI');
    }

    public function actionLegal($active){
        $this->render('legal', array('active'=>$active));
    }

    public function actionNews(){
        $this->layout='';
        $urlArray = array(
            "http://api.feedzilla.com/v1/categories/26/subcategories/1314/articles.json",
            "http://api.feedzilla.com/v1/categories/19/subcategories/866/articles.json",
            "http://api.feedzilla.com/v1/categories/26/subcategories/1320/articles.json",
            "http://api.feedzilla.com/v1/categories/19/subcategories/866/articles.json",
            "http://api.feedzilla.com/v1/categories/26/subcategories/1323/articles.json",
            "http://api.feedzilla.com/v1/categories/19/subcategories/866/articles.json",
            "http://api.feedzilla.com/v1/categories/26/subcategories/1328/articles.json",
            "http://api.feedzilla.com/v1/categories/19/subcategories/866/articles.json",
            "http://api.feedzilla.com/v1/categories/26/subcategories/1306/articles.json",
        );

        $chooseUrl = rand(0,8);
        $url = $urlArray[$chooseUrl];
        $http = curl_init($url);
        $result = curl_exec($http);
        curl_close($http);

        $news = substr_replace($result, "", -1);
            echo $news;

    }

	public function actionIndex()
	{
        $this->layout ='//layouts/bootstrap';
        $model=new LoginForm;
        // if it is ajax validation request
        if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if(isset($_POST['LoginForm']))
        {
            $model->attributes=$_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if($model->validate() && $model->login()){
                Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS, 'Welcome! <strong>' .Yii::app()->user->name. '</strong> You have successfully logged in.');
                $this->refresh();
            }
        }
        $this->render('index',array('model'=>$model));
	}

    public function actionLogin()
    {
        $this->layout ='//layouts/bootstrap2';
        $model=new LoginForm;

        // if it is ajax validation request
        if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if(isset($_POST['LoginForm']))
        {
            $model->attributes=$_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if($model->validate() && $model->login()){
                Yii::app()->user->setFlash('success', '<strong>Welcome!</strong> '.Yii::app()->user->name .
                ' You have successfully logged in.');
                $this->redirect(Yii::app()->user->returnUrl);
            }
        }

        if(Yii::app()->user->isGuest){
        $this->render('login',array('model'=>$model));
        }
        else{
            $this->redirect(Yii::app()->user->returnUrl);
        }

    }

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
        $this->layout ='//layouts/bootstrap4';
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{

				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
                $message = '<strong>'.$model->name.' wrote:</strong><br/>'.$model->body;
                $mail = new YiiMailer();
                $mail->setView('contact');
                $mail->AltBody = 'Pump Manager Pro Message';
                $mail->setData(array('message' => $message, 'description' => 'Email from : '.$model->name.' >>> '.$model->email));
                $mail->render();
                //set properties as usually with PHPMailer
                $mail->From = $model->email;
                $mail->FromName = $name;
                $mail->Subject = $subject;
                $mail->AddAddress('chrisenabled@gmail.com');
                //send
                if ($mail->Send()) {
                    $mail->ClearAddresses();
                    Yii::app()->user->setFlash('info','Thank you for contacting us. We will respond to you as soon as possible.');
                } else {
                    Yii::app()->user->setFlash('info','Error while sending email: '.$mail->ErrorInfo);
                }

                $this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

    public function actionRecovery(){

        $model = new RecoveryForm;

        if(isset($_POST['RecoveryForm'])){

            $model->attributes = $_POST['RecoveryForm'];
            $problem = $_POST['RecoveryForm']['problemType'];
            $email = $_POST['RecoveryForm']['email'];
            $message = '';

            if($model->validate()){

               if($problem == 1){
                   $username = $model->solveUsername($email);
                   $message = "<strong>Hello cherished customer:</strong><br/>Your username is <strong>". $username."</strong>";
               }
                if($problem == 2){
                    $password = $model->solvePassword($email);
                    $message = "<p><strong>Hello ".$model->username.":</strong><br/>Your new password is " .
                        "<strong>". $password . "</strong></p>It is advised that you change your password when you are logged in";
                }
                if($problem == 3){
                    $solved = $model->solveBoth($email);
                    $username = $solved['username'];
                    $password = $solved['password'];
                    $message = "<p><strong>Hello cherished customer:</strong><br/>Your username is: <strong>" . $username .
                        "</strong><br/>Your new password is: <strong>" . $password . "</strong></p>It is advised that you change your password when you are logged in";
                }
                $mail = new YiiMailer();
                $mail->setView('contact');
                $mail->AltBody = 'PMP Account recovery Message';
                $mail->setData(array('message' => $message, 'description' => 'PMP Account Recovery'));
                $mail->render();
                //set properties as usually with PHPMailer
                $mail->From = 'NO-REPLY@PUMPMANAGERPRO';
                $mail->FromName = 'PUMP MANAGER PRO';
                $mail->Subject = 'Account Recovery';
                $mail->AddAddress('chrisenabled@gmail.com');
                //send
                if ($mail->Send()) {
                    $mail->ClearAddresses();
                    Yii::app()->user->setFlash('success','Account recovery Successful. Check your email ( '. $email .' ) for your account details.');
                }
                else {
                    Yii::app()->user->setFlash('error','Error while sending email: '. $mail->ErrorInfo);
                }
                $this->refresh();

            }
        }
        $this->render('recovery',array('model'=>$model));
    }

    public function actionRecoveryAjax(){

        if (Yii::app()->request->isAjaxRequest) {

            $problem = $_POST['RecoveryForm']['problemType'];
            if($problem == 1){
                $password = $_POST['RecoveryForm']['userPassword'];
                $email = $_POST['RecoveryForm']['email'];
                $user = User::model()->findByAttributes(array('email'=>$email));
                if(count($user)== 1){
                    if($user->validate_password($password, $user->password)){
                        echo CJSON::encode(array(
                            'status' => 'successPassword',
                        ));
                    }
                    else{
                        echo CJSON::encode(array(
                            'status' => 'fail',
                        ));
                    }
                }
                else{
                    echo CJSON::encode(array(
                        'status'=>'fail',
                    ));
                }
            }
            if($problem == 2){
                $username = $_POST['RecoveryForm']['username'];
                $email = $_POST['RecoveryForm']['email'];
                $user = User::model()->findByAttributes(array('email'=>$email));
                if(count($user)== 1){
                    if($user->username === $username){
                        $securityQuestion = '<h5>Answer your security Question:</h5>' . $user->securityQuestionText . '<span style="color:red;"> *</span>';
                        echo CJSON::encode(array(
                            'status' => 'success',
                            'securityQuestion' => $securityQuestion,
                        ));
                    }
                    else{
                        echo CJSON::encode(array(
                            'status' => 'fail',
                        ));
                    }
                }
                else{
                    echo CJSON::encode(array(
                        'status'=>'fail',
                    ));
                }
            }
            if($problem == 3){
                $mobile = $_POST['RecoveryForm']['mobile'];
                $email = $_POST['RecoveryForm']['email'];
                $user = User::model()->findByAttributes(array('email'=>$email));
                if(count($user)== 1){
                    if($user->mobile_number === $mobile){
                        $securityQuestion = '<h5>Answer your security Question:</h5>' .$user->securityQuestionText . '<span style="color:red;"> *</span>';
                        echo CJSON::encode(array(
                            'status' => 'success',
                            'securityQuestion' => $securityQuestion,
                        ));
                    }
                    else{
                        echo CJSON::encode(array(
                            'status' => 'fail',
                        ));
                    }
                }
                else{
                    echo CJSON::encode(array(
                        'status'=>'fail',
                    ));
                }
            }

            Yii::app()->end();

        }


    }

    public function actionRecoveryAjaxFinal(){
        if (Yii::app()->request->isAjaxRequest) {

            $email = $_POST['RecoveryForm']['email'];
            $answer = preg_replace('/\s+/','',$_POST['RecoveryForm']['securityAnswer']);

            $user = User::model()->findByAttributes(array('email'=>$email));

            if($user->static->security_answer === $answer){
                echo CJSON::encode(array(
                    'status'=>'success',
                ));
            }
            else{
                echo CJSON::encode(array(
                    'status'=>'fail',
                ));
            }


            Yii::app()->end();
        }

    }



    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

}