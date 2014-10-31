<?php

class UserController extends Controller
{
	public $layout='//layouts/column2';

	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request


		);
	}


    public function accessRules()
    {
        return array(

            array('allow',
                'actions'=> array('create','otherStation','location','feeds','audit','daily','captcha','ajaxOperation'),
                'users'=>array('*'),
            ),

            array('allow',
                'actions'=>array('metroView','view','viewprofile','ajaxProfile','calculator','subscriptionDetail','subscribe','keep','paymentHistory','receipt'),
                'users'=>array('@')
            ),


            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>array('update','username','address','contact','password','question'
                            ,'userAvailable','users','rollBack'),
                'users'=> array('@'),
                'expression'=>'$user->tableName==="tbl_user" && $user->subscription > 0'
            ),

            array(
                'actions'=>array('index','admin'),
                'users'=>array('MrEnabled@HQ')
            ),

			array('deny',  // deny all users
                'users'=>array('*'),
			),
		);
    }

    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha'=>array(
                'class'=>'CCaptchaAction',
                'backColor'=>0xFFFFFF,
            ),

        );
    }

    public function actionCalculator(){
        $this->renderPartial('calculator');
    }

    public function actionRollBack(){
        User::rollBack();
        Yii::app()->user->model = User::model()->findByPk(Yii::app()->user->id);
        Yii::app()->user->todayHasRecord = User::todayHasRecord();

    }

    public function actionAudit(){
            $this->render('audit', array('model'=>Yii::app()->user->model));
    }
    public function actionDaily(){
        $summary =  $this->renderPartial('dailySummary', array('model'=>Yii::app()->user->model),true);
        echo $summary;
    }

    public function actionAjaxProfile(){
        $profile =  $this->renderPartial('_viewprofile', array('model'=>Yii::app()->user->model),true);
        echo $profile;

    }

    public function actionFeeds(){

        $model = Yii::app()->user->model;
        if(Yii::app()->user->isGuest){
            echo CJSON::encode(array(
                'status' => 'Your current session has timed out. Go to the login page to sign in...',
            ));
        }
        else{

            $a = $this->renderPartial('feeds',array('model'=>$model),true);
            echo CJSON::encode(array(
                'status' => $a,
            ));
        }

    }

    public function actionKeep(){

        $keepStatus = User::getKeepState();
        $keepStatus = $keepStatus['keep'];
        if($keepStatus == 0){
            Yii::app()->user->model->resetSubscription(3,null);
            $sql = "UPDATE tbl_keep SET keep = :keep WHERE user_id = :userid";
            $command = Yii::app()->db->createCommand($sql);
            $command->bindValue(":userid", Yii::app()->user->id, PDO::PARAM_STR);
            $command->bindValue(":keep", 1, PDO::PARAM_STR);
            $command->execute();
        }
        $this->redirect('subscriptionDetail');
    }

    public function actionSubscribe(){
        $this->render('subscribe');
    }
    public function actionSubscriptionDetail(){
        $this->layout = '//layouts/bootstrap4';
        $model = UserDynamic::sqlDynamic(Yii::app()->user->model->id);
        $subscription = User::getCurrentSubscription();
        $this->render('subscriptionDetail', array('user'=>Yii::app()->user->model, 'model'=>$model, 'subscription'=>$subscription));
    }

    public function actionLocation(){
        $model = new User;
        $state = $_POST['User']['state'];
        if($state !== ""){
         $content =  CHtml::activeLabelEx($model,'location_id');
        $content .= CHtml::activeDropDownList($model,'location_id' ,$model->getLocationOptions($state),array('class'=>'span12',
            'prompt'=>'Select City of Station location',));
        }
        else{$content = "";}
        echo CJSON::encode(array(
            'content' => $content,
        ));


    }

    public function actionPaymentHistory(){
        $paymentHistory = Yii::app()->user->model->paymentHistory;
        $this->render('history',array('payments'=>$paymentHistory));
    }

    public  function actionReceipt($id){
        $model = User::getReceipt($id);
        $this->render('receipt',array('model'=>$model));
    }

    public function actionOtherStation(){

        $model = new User;
        $choice = $_POST['User']['station_id'];
        if($choice === 'zzz'){

            echo CHtml::activeLabelEx($model,'other');
            echo CHtml::activeTextField($model, 'other',
                array(
                    'size'=>30,
                    'maxlength'=>30,
                    'placeholder'=>'write name of your station here',

                )
            );
        }

    }

	public function actionView()
	{
        $this->render('view',array(
			'model'=>Yii::app()->user->model,
		));
	}

    public function actionViewprofile(){
        $this->layout = '//layouts/column1';

        $this->render('viewprofile',array(
            'model'=>Yii::app()->user->model,
        ));
    }

    public function actionUsers(){

        $this->render('users',array(
            'model'=>Yii::app()->user->model,
        ));
    }

	public function actionCreate()
	{
        $this->layout = '//layouts/bootstrap2';
        $model=new User;

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
            $transaction = Yii::app()->db->getCurrentTransaction() === null ? Yii::app()->db->beginTransaction() : false;

            try{
                if($model->validate()){
                    $model->save();
                    if($transaction){
                        $transaction->commit();
                    }
                    $this->redirect(array('view','id'=>$model->id));
                }
            }
            catch(Exception $e){

                if($transaction){
                    $transaction->rollback();
                }
                throw $e;
            }
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate()
	{

        $this->render('update',array(
            'model'=>Yii::app()->user->model,
        ));

	}

    public function actionUsername(){

        $model = Yii::app()->user->model;
        $username = $_POST['username'];
        if(Yii::app()->request->isAjaxRequest){

            if($model->validate_password($_POST['password'],$model->password)){
                if(strlen(trim(preg_replace('/\xc2\xa0/','',$username))) == 0){
                    echo 'Username cannot be empty.';
                }
                else{
                    if($username !== $model->username){
                        $model->changeUsername($username);
                        echo '<span class="ajaxSuccess">your username has been successfully changed.</span>';
                    }
                }
            }
            else{
                echo '<span>Password is incorrect.</span>';
            }
            Yii::app()->end();

        }

    }

    public function actionUserAvailable(){

        $user= Yii::app()->user->model;

        $username = $_POST['username'];
        if(Yii::app()->request->isAjaxRequest){
            if($username === $user->personnel->username || $username === $user->reader->username){
                echo '<span>Username'.' '.'"'.$username.'"'.' '.'has already been taken.</span>';
            }
            Yii::app()->end();
        }
    }

    public function actionQuestion(){
        $model = Yii::app()->user->model;
        $question = $_POST['question'];
        $answer = $_POST['answer'];
        if(Yii::app()->request->isAjaxRequest){

            if($model->validate_password($_POST['password'],$model->password)){
                if(strlen(trim(preg_replace('/\xc2\xa0/','',$answer))) == 0){
                    echo 'Security Answer cannot be empty.';
                }
                else{
                    $model->changeQuestion($question, $answer);
                    echo '<span class="ajaxSuccess">your security question and answer have been changed successfully.</span>';
                }
            }
            else{
                echo '<span>Password is incorrect.</span>';
            }
            Yii::app()->end();

        }
    }

    public function actionPassword(){

        $model = Yii::app()->user->model;
        if(Yii::app()->request->isAjaxRequest){

            if($model->validate_password($_POST['password'],$model->password)){
                if(!empty($_POST['newpswd'])){
                    if(($_POST['pswdrpt'] === $_POST['newpswd'])){
                        $model->changePswd($_POST['newpswd']);
                        echo '<span class="ajaxSuccess">your password has been successfully changed.</span>';
                    }
                    else{
                        echo '<span>Password must be repeated exactly.</span>';
                    }
                }

            }
        else{
            echo '<span>Password is incorrect.</span>';
        }
            Yii::app()->end();

        }

    }

    public function actionContact(){

        $model = Yii::app()->user->model;
        if(Yii::app()->request->isAjaxRequest){

            if($model->validate_password($_POST['password'],$model->password)){
                if(strlen(trim(preg_replace('/\xc2\xa0/','',$_POST['email']))) == 0||
                    strlen(trim(preg_replace('/\xc2\xa0/','',$_POST['mobile']))) == 0){
                    echo 'email and mobile cannot be blank.';
                }
                else{
                    if(!is_numeric($_POST['mobile']) || (!empty($_POST['landline']) && !is_numeric($_POST['landline']))){
                        echo 'make sure values for mobile and landline are numbers';
                    }
                    else{
                    $model->changeContact($_POST['email'],$_POST['landline'],$_POST['mobile']);
                    echo '<span class="ajaxSuccess">your contact has been successfully updated.</span>';
                    }


                }
            }
            else{
                echo '<span>Password is incorrect.</span>';
            }
            Yii::app()->end();

        }

    }

    public function actionAddress(){

        $model = Yii::app()->user->model;
        if(Yii::app()->request->isAjaxRequest){

            if($model->validate_password($_POST['password'],$model->password)){
                if(strlen(trim(preg_replace('/\xc2\xa0/','',$_POST['line1']))) == 0){

                }
                else{
                    $model->changeAddress($_POST['line1'],$_POST['line2']);
                    echo '<span class="ajaxSuccess">your address has been successfully changed.</span>';
                }
            }
        else{
                echo '<span>Password is incorrect.</span>';
            }
            Yii::app()->end();

        }

    }

	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('User');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionAdmin()
	{
		$model=new User('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
