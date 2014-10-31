<?php

class TankController extends Controller
{

	public $layout='//layouts/column2';

	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
            'gateway + view update'
		);
	}

	public function accessRules()
	{
        return array(

            array('allow',
                'actions'=>array( 'view','admin','generatePdf','generateExcel'),
                'users'=>array('@'),
            ),

            array('allow',
                'actions'=>array('create','delete'),
                'users'=> array('@'),
                'expression'=>'$user->tableName==="tbl_user" && $user->subscription > 0'
            ),

            array('allow',
                'actions'=>array('update'),
                'users'=> array('@'),
                'expression'=>'($user->tableName==="tbl_user" || $user->tableName==="tbl_personnel")
                    && $user->subscription > 0',
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

    public function actionView($id)
	{
        $this->render('view',array(
			'model'=>$this->loadModel($id),
		));
    }

	public function actionCreate()
	{
        $user = Yii::app()->user->model;
        if(count($user->stocks) == 0){
            throw new CHttpException(407,'Please Create Stocks First!!!');
        }
		$model=new Tank;

		if(isset($_POST['Tank']))
		{
			$model->attributes=$_POST['Tank'];
            $transaction = Yii::app()->db->getCurrentTransaction() === null ? Yii::app()->db->beginTransaction() : false;

            try{
                if($model->validate()){
                    $model->save();
                    if($transaction){
                        $transaction->commit();
                    }
                    Yii::app()->user->model = User::model()->findByPk(Yii::app()->user->id);
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
		$model=Tank::model();
        $transaction = Yii::app()->db->getCurrentTransaction() === null ? Yii::app()->db->beginTransaction() : false;

        try{
            $tank = $model->findByPk($id);
            if(isset($_POST['Tank']))
            {
                $tank->attributes=$_POST['Tank'];
                if($tank->validate()){
                    $tank->save();
                    if($transaction){
                        $transaction->commit();
                    }
                    Yii::app()->user->todayHasRecord = User::todayHasRecord();
                    $this->redirect(array('view','id'=>$tank->id));
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
			'model'=>$tank,
		));
	}

	public function actionAdmin()
	{
        $session=new CHttpSession;
        $session->open();
        $criteria = new CDbCriteria();

        $model=new Tank('search');
        $model->unsetAttributes();  // clear any default values
        $criteria->addSearchCondition('user_id',Yii::app()->user->id);
        if(isset($_GET['Tank']))
        {
            $model->attributes=$_GET['Tank'];
            if (!empty($model->tank_no)) $criteria->addCondition('tank_no = "'.$model->pump_no.'"');
            if (!empty($model->stock_id)) $criteria->addCondition('stock_id = "'.$model->stock_id.'"');
            if (!empty($model->capacity)) $criteria->addCondition('capacity = "'.$model->tank_in_use.'"');
            if (!empty($model->prev_qty)) $criteria->addCondition('prev_qty = "'.$model->prev_qty.'"');
            if (!empty($model->current_qty)) $criteria->addCondition('current_qty = "'.$model->current_qty.'"');
            if (!empty($model->last_added_date)) $criteria->addCondition('last_added_date = "'.$model->last_added_date.'"');



        }
        $session['tank_records']=Tank::model()->findAll($criteria);

        $this->render('admin',array(
            'model'=>$model,
        ));

	}

    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();
        Yii::app()->user->model = User::model()->findByPk(Yii::app()->user->id);
                // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

	public function loadModel($id)
	{
		$model=Tank::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

    public function actionGenerateExcel()
    {
        $session=new CHttpSession;
        $session->open();

        if(isset($session['tank_records']))
        {
            $model=$session['tank_records'];
        }
        else
            $model = Pump::model()->findAll();


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

        if(isset($session['tank_records']))
        {
            $model=$session['tank_records'];
        }
        else
            $model = Pump::model()->findAll();



        $html = $this->renderPartial('expenseGridtoReport', array(
            'model'=>$model
        ), true);

        //die($html);

        $pdf = new TCPDF();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor(Yii::app()->name);
        $pdf->SetTitle('Tanks');
        $pdf->SetSubject('Tanks');
        //$pdf->SetKeywords('example, text, report');
        $pdf->SetHeaderData('', 0, "Report", '');
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, "" , "Tank List (".Yii::app()->user->station .")");
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
        $pdf->Output("Tank_002.pdf", "I");
    }

}


