<?php

class PumpStatController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('admin','generateExcel','generatePdf'),
				'users'=>array('@'),
            ),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionAdmin()
	{
        $session=new CHttpSession;
        $session->open();
        $criteria = new CDbCriteria();

        $model=new PumpStat('search');
        $model->unsetAttributes();  // clear any default values
        $criteria->addSearchCondition('user_id',Yii::app()->user->id);
        if(isset($_GET['PumpStat']))
        {
            $model->attributes=$_GET['PumpStat'];
            if (!empty($model->pump_id)) $criteria->addCondition('pump_id = "'.$model->pump_id.'"');
            if (!empty($model->tank)) $criteria->addCondition('tank = "'.$model->tank.'"');
            if (!empty($model->shift)) $criteria->addCondition('shift = "'.$model->shift.'"');
            if (!empty($model->entry_reading)) $criteria->addCondition('entry_reading = "'.$model->entry_reading.'"');
            if (!empty($model->closing_reading)) $criteria->addCondition('closing_reading = "'.$model->closing_reading.'"');
            if (!empty($model->profit)) $criteria->addCondition('profit = "'.$model->profit.'"');
            if (!empty($model->offset)) $criteria->addCondition('offset = "'.$model->offset.'"');
            if (!empty($model->record_date)) $criteria->addCondition('record_date = "'.$model->record_date.'"');

        }
        $session['PumpStat_records']=PumpStat::model()->findAll($criteria);

		$this->render('admin',array(
			'model'=>$model,
		));
	}

    public function actionGenerateExcel()
    {
        $session=new CHttpSession;
        $session->open();

        if(isset($session['PumpStat_records']))
        {
            $model=$session['PumpStat_records'];
        }
        else
            $model = PumpStat::model()->findAll();


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

        if(isset($session['PumpStat_records']))
        {
            $model=$session['PumpStat_records'];
        }
        else
            $model = PumpStat::model()->findAll();



        $html = $this->renderPartial('expenseGridtoReport', array(
            'model'=>$model
        ), true);

        //die($html);

        $pdf = new TCPDF();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor(Yii::app()->name);
        $pdf->SetTitle('PumpStat Report');
        $pdf->SetSubject('PumpStat Report');
        //$pdf->SetKeywords('example, text, report');
        $pdf->SetHeaderData('', 0, "Report", '');
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, "" , "PumpStat List (".Yii::app()->user->station .")");
        $pdf->setHeaderFont(Array('helvetica', '', 10));
        $pdf->setFooterFont(Array('helvetica', '', 6));
        $pdf->SetMargins(7, 25, 15);
        $pdf->SetHeaderMargin(5);
        $pdf->SetFooterMargin(10);
        $pdf->SetAutoPageBreak(TRUE, 0);
        $pdf->SetFont('dejavusans', '', 8);
        $pdf->AddPage();
        $pdf->setPageOrientation('L');
        $pdf->setCellHeightRatio(2);
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->LastPage();
        $pdf->Output("PumpStat_002.pdf", "I");
    }

}
