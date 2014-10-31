
<div class="top-mini-icons-div-container" style="margin-top: 30px;">
    <div class="top-mini-icons-div">
        <?php echo TbHtml::tooltip('<span class="hspan">Attendants</span>',array('//attendant/admin'),'Attendant list', array('placement' => TbHtml::TOOLTIP_PLACEMENT_RIGHT,'class'=>'mini-icons-attendant icon32')); ?>
    </div>
    <div class="top-mini-icons-div"><?php echo TbHtml::tooltip('<span class="hspan">Add&nbsp;Attendant</span>',array('//attendant/create'),'Create a new attendant', array('placement' => TbHtml::TOOLTIP_PLACEMENT_TOP,'class'=>'mini-icons-add icon32')); ?></div>
    <div class="top-mini-icons-div"><?php echo TbHtml::link('<span class="hspan">Print&nbsp;Info</span>',array('url'=>'javascript:void(0);return false'), array( 'class'=>'mini-icons-print icon32','onclick'=>'printDiv();return false;')); ?></div>
    <div class="top-mini-icons-div"><?php echo TbHtml::tooltip('<span class="hspan">Edit&nbsp;Attendant</span>',array('//attendant/update', 'id'=>$model->id),'Edit this info', array('placement' => TbHtml::TOOLTIP_PLACEMENT_TOP,'class'=>'mini-icons-edit icon32')); ?></div>
    <div class="top-mini-icons-div"><?php echo TbHtml::link('<span class="hspan">Delete&nbsp;Attendant</span>',array('url'=>'#'), array( 'class'=>'mini-icons-bin icon32','submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this Attendant?')); ?></div>

    <br class="break" />
</div>

<div class="printableArea">
<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'first_name',
		array('name'=>'middle_name','value'=> $model->middle_name !== '' ? $model->middle_name:'- - - -'),
        'last_name',
		array('name'=>'gender', 'value'=> $model->getGenderText()),
		array('name'=>'state_of_origin','value'=>$model->getStateText()),
		'mobile_number',
		'date_employed',
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
