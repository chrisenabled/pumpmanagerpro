<?php

class PersonnelController extends Controller
{

	public $layout='//layouts/column2';

	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
            'gateway + delete'
		);
	}

	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('create','view','delete'),
                'users'=> array('@'),
				'expression'=>'$user->tableName === "tbl_user" && $user->subscription > 0'
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

    public function filterGateway($filterChain){
        $id = $_GET['id'];
        $model = $this->loadModel($id);
        if(count($model)== 0){
            throw new CHttpException(404,'The requested page does not exist.');

        }

        else{
            if($model->user->id !== Yii::app()->user->id){
                throw new CHttpException(403,'Access Denied.');

            }

        }
        $filterChain->run();

    }


	public function actionCreate()
	{
        $this->layout = '//layouts/column1';
        $user = User::Model()->findByPk(Yii::app()->user->id);
        if(count($user->personnel) > 0){
            throw new CHttpException(404,'You already have a personnel account.');
        };
		$model=new Personnel;

		if(isset($_POST['Personnel']))
		{
			$model->attributes=$_POST['Personnel'];
            $transaction = Yii::app()->db->getCurrentTransaction() === null ? Yii::app()->db->beginTransaction() : false;

            try{
                if($model->validate()){
                    $model->save();
                    if($transaction){
                        $transaction->commit();
                    }
                    Yii::app()->user->model = User::model()->findByPk(Yii::app()->user->id);
                    $this->redirect(array('//user/users'));
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

		$this->render('create',array(
			'model'=>$model,
		));
	}


	public function actionDelete($id)
	{
		if($this->loadModel($id)->delete()){
            Yii::app()->user->model = User::model()->findByPk(Yii::app()->user->id);
            $model = Yii::app()->user->model;

            if(count($model->reader) == 1){
                $this->redirect(array('//user/users'));
            }
            else{
                $this->redirect(array('//user/view'));
            }
        }
        else{
            throw new CHttpException('505', 'The record was not deleted please try again after some time');
        }

    }

	public function loadModel($id)
	{
		$model=Personnel::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

}
