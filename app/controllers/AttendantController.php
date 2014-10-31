<?php

class AttendantController extends Controller
{
	public $layout='//layouts/column2';

	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
            'gateway + view update delete'

		);
	}

    public function accessRules()
    {
        return array(

			array('allow',
                'actions'=>array('view','admin','ajax','generateExcel','generatePdf'),
                'users'=>array('@'),
			),

            array('allow',
                'actions'=>array('create','update'),
                'users'=> array('@'),
                'expression'=>'($user->tableName==="tbl_user" || $user->tableName==="tbl_personnel")
                   && $user->subscription > 0 '
            ),

            array('allow',
                'actions'=>array('delete'),
                'users'=> array('@'),
                'expression'=>'$user->tableName==="tbl_user" && $user->subscription > 0'
            ),

			array('deny',  // deny all users
                'users'=>array('*'),
			),
		);
    }

    public function filterGateway($filterChain){

        if(isset($_GET['model']) ){
            if($_GET['model']->user_id !== Yii::app()->user->id)
            throw new CHttpException(403,'Access Denied.');
        }
        else{
            $id = $_GET['id'];
            $model = $this->loadModel($id);
            if(count($model)== 0){
                throw new CHttpException(404,'The requested page does not exist.');

            }

            else{
                if($model->user_id !== Yii::app()->user->id){
                    throw new CHttpException(403,'Access Denied.');

                }

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
		$model=new Attendant;

        if(isset($_POST['Attendant']))
        {
            $model->attributes=$_POST['Attendant'];
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

    public function actionAjax(){
        Yii::app()->user->setState('operationUrl',"'/pmp/index.php/attendant/ajax'");
        //$model = new Attendant;
        //$summary =  $this->renderPartial('create', array('model'=>$model),true);
        echo  'This is the attendant controller. All is well!';
    }

	public function actionUpdate($id)
	{
        $model=Attendant::model();
        $transaction = Yii::app()->db->getCurrentTransaction() === null ? Yii::app()->db->beginTransaction() : false;
        try{
            $attendant  = $model->findByPk($id);
            if(isset($_POST['Attendant']))
            {
                $attendant->attributes=$_POST['Attendant'];
                if($attendant->validate()){
                    $attendant->save();
                    if($transaction){
                        $transaction->commit();
                    }
                    $this->redirect(array('view','id'=>$attendant->id));
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
			'model'=>$attendant,
		));

	}

	public function actionDelete($id)
	{

		    if($this->loadModel($id)->delete()){

                Yii::app()->user->model = User::model()->findByPk(Yii::app()->user->id);
                // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
                if(!isset($_GET['ajax']))
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            }
	}

	public function actionAdmin()
	{
        $this->layout = '//layouts/column1';
        $session=new CHttpSession;
        $session->open();
        $criteria = new CDbCriteria();
        $model=new Attendant('search');
        $model->unsetAttributes();  // clear any default values
        $criteria->addSearchCondition('user_id',Yii::app()->user->id);

        if(isset($_GET['Attendant']))
        {
            $model->attributes=$_GET['Attendant'];
            if (!empty($model->first_name)) $criteria->addCondition('first_name = "'.$model->first_name.'"');
            if (!empty($model->middle_name)) $criteria->addCondition('middle_name = "'.$model->middle_name.'"');
            if (!empty($model->last_name)) $criteria->addCondition('last_name = "'.$model->last_name.'"');
            if (!empty($model->gender)) $criteria->addCondition('gender = "'.$model->gender.'"');
            if (!empty($model->state_of_origin)) $criteria->addCondition('state_of_origin = "'.$model->state_of_origin.'"');
            if (!empty($model->mobile_number)) $criteria->addCondition('mobile_number = "'.$model->mobile_number.'"');
            if (!empty($model->date_employed)) $criteria->addCondition('date_employed = "'.$model->date_employed.'"');

        }
        $session['Attendant_records']=Attendant::model()->findAll($criteria);

		$this->render('admin',array(
			'model'=>$model,
		));
	}

    public function actionGenerateExcel()
    {
        $session=new CHttpSession;
        $session->open();

        if(isset($session['Attendant_records']))
        {
            $model=$session['Attendant_records'];
        }
        else
            $model = Attendant::model()->findAll();


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

        if(isset($session['Attendant_records']))
        {
            $model=$session['Attendant_records'];
        }
        else
            $model = Attendant::model()->findAll();



        $html = $this->renderPartial('expenseGridtoReport', array(
            'model'=>$model
        ), true);

        //die($html);

        $pdf = new TCPDF();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor(Yii::app()->name);
        $pdf->SetTitle('Attendant Report');
        $pdf->SetSubject('Attendant Report');
        //$pdf->SetKeywords('example, text, report');
        $pdf->SetHeaderData('', 0, "Report", '');
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, "" , "Attendant List (".Yii::app()->user->station .")");
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
        $pdf->Output("Attendant_002.pdf", "I");
    }

	public function loadModel($id)
	{
		$model=Attendant::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

}
