<?php
$this->breadcrumbs=array(
	'Tbl Tests'=>array('index'),
	$model->id,
);
?>

<h1>View TblTest #<?php echo $model->id; ?></h1>
<hr />
<?php 
$this->beginWidget('zii.widgets.CPortlet', array(
	'htmlOptions'=>array(
		'class'=>''
	)
));

$this->widget('bootstrap.widgets.TbNavbar', array(
    'brandLabel' => 'Title',
    'display' => null, // default is static to top
    'items' => array(
        array(
            'class' => 'bootstrap.widgets.TbNav',
            'items' => array(
                array('label'=>'Create', 'icon'=>'icon-plus', 'url'=>Yii::app()->controller->createUrl('create'), 'linkOptions'=>array()),
                array('label'=>'List', 'icon'=>'icon-th-list', 'url'=>Yii::app()->controller->createUrl('index'), 'linkOptions'=>array()),
                array('label'=>'Update', 'icon'=>'icon-edit', 'url'=>Yii::app()->controller->createUrl('update',array('id'=>$model->id)), 'linkOptions'=>array()),
                //array('label'=>'Search', 'icon'=>'icon-search', 'url'=>'#', 'linkOptions'=>array('class'=>'search-button')),
                array('label'=>'Print', 'icon'=>'icon-print', 'url'=>'javascript:void(0);return false', 'linkOptions'=>array('onclick'=>'printDiv();return false;')),
            ),
        ),
    ),
));

$this->endWidget();
?>

<div class="top-mini-icons-div"><?php echo CHtml::link('<span class="hspan">Export&nbsp;to&nbsp;PDF</span>', array('url'=>'javascript:void(0);return false'), array('onclick'=>'printDiv();return false;','class'=>'mini-icons-pdf icon32','target'=>'_blank')); ?></div>

<div class='printableArea'>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'username',
		'password',
		'station_id',
		'address',
		'location_id',
		'email',
		'land_line',
		'mobile_number',
	),
)); ?>
</div>
<style type="text/css" media="print">
body {visibility:hidden;}
.printableArea{visibility:visible;} 
</style>
<script type="text/javascript">
function printDiv()
{

window.print();

}
</script>
