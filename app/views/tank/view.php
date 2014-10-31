<?php
/* @var $this TankController */
/* @var $model Tank */

$this->breadcrumbs=array(
    'Manage Tanks'=>array('admin'),
    'View');

$this->menu=array(
	array('label'=>'Add Stock', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Manage Tanks', 'url'=>array('admin')),
);
if(count($model->tblPumps) == 0){
    $this->menu[] = array('label'=>'Delete Tank', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),
        'confirm'=>'Are you sure you want to delete this item?'));
}
?>

<div class="viewdiv">
    <div class="image">
        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/tank.png" alt="Pump Manager Pro" />
        <div class="text" id="tank">
            <?php echo $model->tank_no?>
        </div>
        <div class="text" id="tanktype">
            <?php echo $model->stock->getStockText()?>
        </div>
    </div>

    <div>
        <?php $this->widget('application.extensions.widgets.DetailView4Col', array(
            'data'=>$model,
            'attributes'=>array(
                array(
                    'header'=>'DETAILS'
                ),
                array('name'=>'Capacity', 'value'=>Yii::app()->numberFormatter->format("#,##0L",$model->capacity), 'oneRow'=>true),
                array('name'=>'Previous Quantity', 'value'=>Yii::app()->numberFormatter->format("#,##0L",$model->prev_qty), 'oneRow'=>true),
                array('name'=>'Current Quantity', 'value'=>Yii::app()->numberFormatter->format("#,##0L",$model->current_qty), 'oneRow'=>true),
                array('name'=>'Last Discharge', 'value'=>$model->last_added_date, 'oneRow'=>true),
            ),

        )); ?>
    </div>

</div>
