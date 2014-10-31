<?php

class AdminController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='main';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
            'accessControl',
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

    public function accessRules(){
        return array(

            array('allow',
                'actions'=>array('view','update', 'index', 'subscribeCustomer'),
                'users'=>array('@'),
            ),

            array('allow',
                'actions'=>array('create','captcha'),
                'users'=> array('*'),
            ),

            array('allow',
                'actions'=>array('delete','admin'),
                'users'=> array('@'),
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


    public function actionSubscribeCustomer(){
        if($_POST['pinCode'] === Yii::app()->user->pinCode || (Yii::app()->user->hasState('isCode') && Yii::app()->user->isCode === true)){
           $subscribe = new SubscribeForm;
            if(!Yii::app()->user->hasState('isCode') || (Yii::app()->user->hasState('isCode') && Yii::app()->user->isCode === false)){
                Yii::app()->user->setState('isCode',true);
            }
            if(isset($_POST['SubscribeForm']))
            {
                $subscribe->attributes=$_POST['SubscribeForm'];
                // validate user input and redirect to the previous page if valid
                if($subscribe->validate()){
                    $subscribe->creditCustomer();
                    $subscribe->issueOrderInvoice();
                    Yii::app()->user->setFlash('info', 'Customer '. $subscribe->customer .' has been credited with '. $subscribe->getNoOfDays() .' day(s).');
                    $this->redirect(array('index'));
                }
            }
            $this->render('subscribeCustomer',array('model'=>$subscribe));
        }
        else{
            $this->redirect(array('index'));
        }


    }

	public function actionView()
	{
		$this->render('view',array(
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Admin;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Admin']))
		{
			$model->attributes=$_POST['Admin'];
			if($model->save()){
                Yii::app()->user->setFlash('info', 'Done! Admin <strong>'. $model->username .'</strong> has been successfully created.');
                $this->redirect(array('default/index'));

            }
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Admin']))
		{
			$model->attributes=$_POST['Admin'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->render('index');
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Admin('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Admin']))
			$model->attributes=$_GET['Admin'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Admin::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='admin-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
