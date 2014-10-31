<?php
/* @var $this StockController */
/* @var $model Stock */

$this->breadcrumbs=array(
    'Manage Stocks'=>array('admin'),
    'View');

$this->menu=array(
	array('label'=>'Update '.$model->getStockText(), 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Manage Stocks', 'url'=>array('admin')),
);
?>

<div class="viewdiv">
    <div class="image">
        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/stock.png" alt="Pump Manager Pro" />
        <div class="text" id="stock">
            <?php echo $model->getStockText()?>
        </div>
    </div>

    <div>
        <?php $this->widget('application.extensions.widgets.DetailView4Col', array(
            'data'=>$model,
            'attributes'=>array(
                array(
                    'header'=>'DETAILS'
                ),
                array('name'=>'Cost Price', 'value'=>Yii::app()->numberFormatter->format("₦#,##0.00",$model->cost_price), 'oneRow'=>true),
                array('name'=>'Selling Price', 'value'=>Yii::app()->numberFormatter->format("₦#,##0.00",$model->selling_price), 'oneRow'=>true),
                array('name'=>'Available Quantity', 'value'=>Yii::app()->numberFormatter->format("#,##0L",$model->available_qty), 'oneRow'=>true),
            ),

        )); ?>
    </div>

</div>


<?php /*$this->widget('zii.widgets.CDetailView', array(
	*'data'=>$model,
	*'attributes'=>array(
		*array('name'=>'stock_type', 'value'=>$model->getStockText()),
		*array('label'=>'Available Quantity', 'value'=>$model->available_qty.' Litres'),
		*array('label'=>'Cost Price', 'value'=>$model->cost_price.' Naira'),
        *array('label'=>'Selling Price', 'value'=>$model->selling_price.' Naira'),
		'last_record',
	*),
*));
  *
  */

?>
