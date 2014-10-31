<?php

class PumpController extends Controller
{

	public $layout='//layouts/column2';

	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request

		);
	}

    public function gateway($id){
        $model = $this->loadModel($id);
        if(count($model)== 0){
            throw new CHttpException(404,'The requested page does not exist.');

        }

        else{
            if($model->user->id !== Yii::app()->user->id){
                throw new CHttpException(403,'You are not authorized to access this page.');

            }

        }

    }

	public function accessRules()
	{
        return array(

            array('allow',
                'actions'=>array('chooseTank'),
                'users'=>array('*'),
            ),

            array('allow',
                'actions'=>array( 'view','admin','generateExcel','generatePdf'),
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

    public function actionChooseTank(){

        if(Yii::app()->user->isGuest){
            echo CJSON::encode(array(
                'status' => 'Your current session has timed out. Go to the login page and sign in...',
            ));
        }
        else{
            $class = new Pump;
            $data = Tank::Model()->findAll('stock_id=:stock_id', array(
                ':stock_id'=> $_POST['Pump']['stock_id']
            ));
            //$data = CHtml::listData($data,'tank_no','tank_no');
            $a = '';
            if($data != null){
                foreach ($data as $value) {
                   $a .=  '<input type="checkbox" name="' . CHtml::activeName($class, 'tanks') . '[]" value="' . $value->tank_no . '" ' .  'id="'. $value->tank_no  . '"/>'.
                    '<label class = "custom" for="'. $value->tank_no .'"><span class="first"></span><span class="second">'.$value->tank_no .'</span></label>';
                }
                $a = TbHtml::customActiveControlGroup($a, $class, 'tanks');
            }
            echo CJSON::encode(array(
                'status' => $a,
            ));
        }
    }

	public function actionView($id)
	{
        $this->gateway($id);
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
        if(count($user->tanks) == 0){
            throw new CHttpException(407,'Please Create Tanks First!!!');
        }
		$model=new Pump;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Pump']))
		{
			$model->attributes=$_POST['Pump'];
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
        $this->gateway($id);
        $model=Pump::model();
        $transaction = Yii::app()->db->getCurrentTransaction() === null ? Yii::app()->db->beginTransaction() : false;

        try{
            $pump = $model->findByPk($id);
            if(isset($_POST['Pump']))
            {
                $pump->attributes=$_POST['Pump'];
                if($pump->validate()){
                    $pump->save();
                    if($transaction){
                        $transaction->commit();
                    }
                    Yii::app()->user->todayHasRecord = User::todayHasRecord();
                    $this->redirect(array('view','id'=>$pump->id));
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
			'model'=>$pump,
		));
	}

	public function actionAdmin()
	{

        $session=new CHttpSession;
        $session->open();
        $criteria = new CDbCriteria();
        $model=new Pump('search');
        $model->unsetAttributes();  // clear any default values
        $criteria->addCondition('user_id="'.Yii::app()->user->id.'"');

        if(isset($_GET['Pump']))
        {
            $model->attributes=$_GET['Pump'];
            if (!empty($model->pump_no)) $criteria->addCondition('pump_no = "'.$model->pump_no.'"');
            if (!empty($model->stock_id)) $criteria->addCondition('stock_id = "'.$model->stock_id.'"');
            if (!empty($model->tank_in_use)) $criteria->addCondition('tank_in_use = "'.$model->tank_in_use.'"');
            if (!empty($model->closing_reading)) $criteria->addCondition('closing_reading = "'.$model->closing_reading.'"');

        }
        $session['pump_records']=Pump::model()->findAll($criteria);

		$this->render('admin',array(
			'model'=>$model,
		));
	}

    public function actionGenerateExcel()
    {
        $session=new CHttpSession;
        $session->open();

        if(isset($session['pump_records']))
        {
            $model=$session['pump_records'];
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

        if(isset($session['pump_records']))
        {
            $model=$session['pump_records'];
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
        $pdf->SetTitle('Pumps');
        $pdf->SetSubject('Pumps');
        //$pdf->SetKeywords('example, text, report');
        $pdf->SetHeaderData('', 0, "Report", '');
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, "" , "Pump List (".Yii::app()->user->station .")");
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
        $pdf->Output("Pump_002.pdf", "I");
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

	public function loadModel($id)
	{
		$model=Pump::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='pump-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
