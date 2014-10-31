<?php

class StockStatController extends Controller
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
            array('allow',
                'actions'=>array('calculate'),
                'users'=>array('*'),

            ),
            array('allow',
                'actions'=>array('admin','generateExcel','generatePdf'),
                'users'=>array('@')
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
	}

    public function actionCalculate(){

        if(Yii::app()->user->isGuest){

            echo CJSON::encode(array(
                'status' => 'Your current session has timed out. Go to the login page and sign in...',
            ));
        }
        else{

            $stockData = StockStat::stockData($_POST['from'],$_POST['to']);
            $pms = $stockData['pms'];
            $ago = $stockData['ago'];
            $dpk = $stockData['dpk'];
            $a = $this->renderPartial('calculate',array('pms'=>$pms,'ago'=>$ago,'dpk'=>$dpk),true);
            echo CJSON::encode(array(
                'status' =>  $pms == null && $ago == null && $dpk == null? '<div class="alert alert-danger">There is no match for this date range</div>':$a,
            ));

        }
    }

	public function actionAdmin()
	{
        $session=new CHttpSession;
        $session->open();
        $criteria = new CDbCriteria();

        $model=new StockStat('search');
        $model->unsetAttributes();  // clear any default values
        $criteria->addSearchCondition('user_id',Yii::app()->user->id);
        if(isset($_GET['StockStat']))
        {
            $model->attributes=$_GET['StockStat'];
            if (!empty($model->stock_type)) $criteria->addCondition('stock_type = "'.$model->stock_type.'"');
            if (!empty($model->available_qty)) $criteria->addCondition('available_qty = "'.$model->available_qty.'"');
            if (!empty($model->cost_price)) $criteria->addCondition('cost_price = "'.$model->cost_price.'"');
            if (!empty($model->selling_price)) $criteria->addCondition('selling_price = "'.$model->selling_price.'"');
            if (!empty($model->last_record)) $criteria->addCondition('last_record = "'.$model->last_record.'"');



        }
        $session['stock_stats']=StockStat::model()->findAll($criteria);

        $this->render('admin',array(
            'model'=>$model,
        ));
	}

    public function actionGenerateExcel()
    {
        $session=new CHttpSession;
        $session->open();

        if(isset($session['stock_stats']))
        {
            $model=$session['stock_stats'];
        }
        else
            $model = StockStat::model()->findAll();


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

        if(isset($session['stock_stats']))
        {
            $model=$session['stock_stats'];
        }
        else
            $model = StockStat::model()->findAll();



        $html = $this->renderPartial('expenseGridtoReport', array(
            'model'=>$model
        ), true);

        //die($html);

        $pdf = new TCPDF();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor(Yii::app()->name);
        $pdf->SetTitle('Stocks Record');
        $pdf->SetSubject('Stocks Record');
        //$pdf->SetKeywords('example, text, report');
        $pdf->SetHeaderData('', 0, "Report", '');
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, "" , "Stocks' Record (".Yii::app()->user->station .")");
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
        $pdf->Output("StockStat.pdf", "I");
    }

}
