<?php

class ExpenditureController extends Controller
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
                'actions'=>array('calculate'),
                'users'=>array('*')
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>array('view','admin','generatePdf','generateExcel'),
                'users'=>array('@'),
            ),

            array('allow',
                'actions'=>array('create'),
                'users'=> array('@'),
                'expression'=>'($user->tableName==="tbl_user" || $user->tableName==="tbl_personnel")
                    && $user->subscription > 0'
            ),

            array('allow',
                'actions'=>array('update'),
                'users'=> array('@'),
                //'expression'=>array($this,'isAllowed'),
            ),

            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
	}

    function isAllowed($user, $rule){
        $model = $this->loadModel($_GET['id']);
        $date = new DateTime();
        $mDate = new DateTime($model->date_created);
        $diff = $date->getTimestamp()- $mDate->getTimeStamp();
        if(Yii::app()->user->subscription > 0){
            if($user->tableName==='tbl_user'  && $diff <= 2*24*60*60 ||
                ($user->tableName==='tbl_personnel' &&  $diff <= 30*60)){
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }


    public function actionCalculate(){

        if(Yii::app()->user->isGuest){

            echo CJSON::encode(array(
                'status' => 'Your current session has timed out. Go to the login page and sign in...',
            ));
        }
        else{
            if($_POST['from']==='' || $_POST['to']===''){
                echo CJSON::encode(array(
                    'status' => '"From" and "To" dates cannot be empty',
                ));
            }
            else if(date($_POST['from']) > date($_POST['to'])){
                echo CJSON::encode(array(
                    'status' => '"From" date cannot be greater than "To" date',
                ));
            }
            else{
                $expenseData = Expenditure::expenseData($_POST['from'],$_POST['to']);

                $a = $this->renderPartial('calculate',array('expenses'=>$expenseData),true);
                echo CJSON::encode(array(
                    'status' => $a,
                ));
            }
        }
    }

	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionCreate()
	{
		$model=new Expenditure;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Expenditure']))
		{
            $model->attributes=$_POST['Expenditure'];
            $transaction = Yii::app()->db->getCurrentTransaction() === null ? Yii::app()->db->beginTransaction() : false;

            try{

                if($model->validate()){
                    $model->save();
                    if($transaction){
                        $transaction->commit();
                    }
                    Yii::app()->user->model = User::model()->findByPk(Yii::app()->user->id);
                    Yii::app()->user->todayHasRecord = User::todayHasRecord();
                    $this->redirect(array('view','id'=>$model->id));
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

	public function actionUpdate($id)
	{
        $model= Expenditure::model();
        $transaction = Yii::app()->db->getCurrentTransaction() === null ? Yii::app()->db->beginTransaction() : false;
        try{

            $expenditure = $model->findByPk($id);
            if(isset($_POST['Expenditure']))
            {
                $expenditure->attributes=$_POST['Expenditure'];
                if($expenditure->validate()){
                    $expenditure->save();
                    if($transaction){
                        $transaction->commit();
                    }
                    $this->redirect(array('view','id'=>$expenditure->id));
                }

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

		$this->render('update',array(
			'model'=>$expenditure,
		));
	}

	public function actionAdmin()
	{
        $session=new CHttpSession;
        $session->open();
        $criteria = new CDbCriteria();
        $model=new Expenditure('search');
        $model->unsetAttributes();  // clear any default values
        $criteria->addCondition('user_id="'.Yii::app()->user->id.'"');

        if(isset($_GET['Expenditure']))
        {
            $model->attributes=$_GET['Expenditure'];
            if (!empty($model->title)) $criteria->addCondition('title = "'.$model->title.'"');
            if (!empty($model->expense)) $criteria->addCondition('expense = "'.$model->expense.'"');
            if (!empty($model->initial_profit)) $criteria->addCondition('initial_profit = "'.$model->initial_profit.'"');
            if (!empty($model->final_profit)) $criteria->addCondition('final_profit = "'.$model->final_profit.'"');
            if (!empty($model->this_date)) $criteria->addCondition('this_date = "'.$model->this_date.'"');

        }
        $session['expenditure']=Expenditure::model()->findAll($criteria);

        $this->render('admin',array(
            'model'=>$model,
        ));

	}

    public function actionGenerateExcel()
    {
        $session=new CHttpSession;
        $session->open();

        if(isset($session['expenditure']))
        {
            $model=$session['expenditure'];
        }
        else
            $model = Expenditure::model()->findAll();


        Yii::app()->request->sendFile(date('YmdHis').'.xls',
            $this->renderPartial('excelReport', array(
                'model'=>$model
            ), true)
        );
    }

    public function actionGeneratePdf()
    {
        $session=new CHttpSession;
        $session->open();
        require_once('tcpdf/tcpdf.php');
        require_once('tcpdf/config/lang/eng.php');

        if(isset($session['expenditure']))
        {
            $model=$session['expenditure'];
        }
        else
            $model = Expenditure::model()->findAll();



        $html = $this->renderPartial('expenseGridtoReport', array(
            'model'=>$model
        ), true);

        //die($html);

        $pdf = new TCPDF();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor(Yii::app()->name);
        $pdf->SetTitle('Expenditures');
        $pdf->SetSubject('Expenditures');
        //$pdf->SetKeywords('example, text, report');
        $pdf->SetHeaderData('', 0, "Report", '');
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, "" , "Expenditure List (".Yii::app()->user->station .")");
        $pdf->setHeaderFont(Array('helvetica', '', 10));
        $pdf->setFooterFont(Array('helvetica', '', 6));
        $pdf->SetMargins(7, 25, 15);
        $pdf->SetHeaderMargin(5);
        $pdf->SetFooterMargin(10);
        $pdf->SetAutoPageBreak(TRUE, 0);
        $pdf->SetFont('dejavusans', '', 8);
        $pdf->AddPage();
        $pdf->setPageOrientation('P');
        $pdf->setCellHeightRatio(2);
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->LastPage();
        $pdf->Output("Expenditure.pdf", "I");
    }

	public function loadModel($id)
	{
		$model=Expenditure::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='expenditure-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
