<?php

class StockController extends Controller
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
                'actions'=>array( 'view','admin','ajaxView','generateExcel','generatePdf'),
                'users'=>array('@'),
            ),

            array('allow',
                'actions'=>array('create','update'),
                'users'=> array('@'),
                'expression'=>'$user->tableName==="tbl_user" && $user->subscription > 0'
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


    public function actionAjaxView(){

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
        if(count($user->stocks) == 3){
            throw new CHttpException(405, 'You cannot create more stock!!!');
        }
		$model=new Stock;


		if(isset($_POST['Stock']))
		{
			$model->attributes=$_POST['Stock'];
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
		$model=Stock::model();
        $transaction = Yii::app()->db->getCurrentTransaction() === null ? Yii::app()->db->beginTransaction() : false;

        try{
            $stock = $model->findByPk($id);
            if(isset($_POST['Stock']))
            {
                $stock->attributes=$_POST['Stock'];
                if($stock->validate()){
                    $stock->save();
                    if($transaction){
                        $transaction->commit();
                    }
                    $this->redirect(array('view','id'=>$stock->id));
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
			'model'=>$stock,
		));
	}

	public function actionAdmin()
	{
        $session=new CHttpSession;
        $session->open();
        $criteria = new CDbCriteria();

        $model=new Stock('search');
        $model->unsetAttributes();  // clear any default values

        $criteria->addSearchCondition('user_id',Yii::app()->user->id);
        if(isset($_GET['Stock']))
        {
            $model->attributes=$_GET['Stock'];
            if (!empty($model->stock_type)) $criteria->addCondition('stock_type = "'.$model->stock_type.'"');
            if (!empty($model->available_qty)) $criteria->addCondition('available_qty = "'.$model->available_qty.'"');
            if (!empty($model->cost_price)) $criteria->addCondition('cost_price = "'.$model->cost_price.'"');
            if (!empty($model->selling_price)) $criteria->addCondition('selling_price = "'.$model->selling_price.'"');
            if (!empty($model->last_record)) $criteria->addCondition('last_record = "'.$model->last_record.'"');



        }
        $session['stock_records']=Stock::model()->findAll($criteria);

        $this->render('admin',array(
            'model'=>$model,
        ));

	}

	public function loadModel($id)
	{
		$model=Stock::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

    public function actionGenerateExcel()
    {
        $session=new CHttpSession;
        $session->open();

        if(isset($session['stock_records']))
        {
            $model=$session['stock_records'];
        }
        else
            $model = Stock::model()->findAll();


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

        if(isset($session['stock_records']))
        {
            $model=$session['stock_records'];
        }
        else
            $model = Stock::model()->findAll();



        $html = $this->renderPartial('expenseGridtoReport', array(
            'model'=>$model
        ), true);

        //die($html);

        $pdf = new TCPDF();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor(Yii::app()->name);
        $pdf->SetTitle('Stocks');
        $pdf->SetSubject('Stocks');
        //$pdf->SetKeywords('example, text, report');
        $pdf->SetHeaderData('', 0, "Report", '');
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, "" , "Stock List (".Yii::app()->user->station .")");
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
        $pdf->Output("Stock_002.pdf", "I");
    }

}
