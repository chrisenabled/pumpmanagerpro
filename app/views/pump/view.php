
<div class="top-mini-icons-div-container" style="margin-top: 30px;">
    <div class="top-mini-icons-div">
        <?php echo TbHtml::tooltip('<span class="hspan">Pumps</span>',array('//pump/admin'),'Attendant list', array('placement' => TbHtml::TOOLTIP_PLACEMENT_RIGHT,'class'=>'mini-icons-pump icon32')); ?>
    </div>
    <div class="top-mini-icons-div"><?php echo TbHtml::tooltip('<span class="hspan">Add&nbsp;Pump</span>',array('//pump/create'),'Create a new pump', array('placement' => TbHtml::TOOLTIP_PLACEMENT_TOP,'class'=>'mini-icons-add icon32')); ?></div>
    <div class="top-mini-icons-div"><?php echo TbHtml::link('<span class="hspan">Print&nbsp;Info</span>',array('url'=>'javascript:void(0);return false'), array( 'class'=>'mini-icons-print icon32','onclick'=>'printDiv();return false;')); ?></div>
    <div class="top-mini-icons-div"><?php echo TbHtml::tooltip('<span class="hspan">Edit&nbsp;Pump</span>',array('//pump/update', 'id'=>$model->id),'Take pump reading', array('placement' => TbHtml::TOOLTIP_PLACEMENT_TOP,'class'=>'mini-icons-edit icon32')); ?></div>
    <div class="top-mini-icons-div"><?php echo TbHtml::link('<span class="hspan">Delete&nbsp;Pump</span>',array('url'=>'#'), array( 'class'=>'mini-icons-bin icon32','submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this Attendant?')); ?></div>

    <br class="break" />
</div>

<div class="printableArea">
    <?php $this->widget('bootstrap.widgets.TbDetailView', array(
        'data'=>$model,
        'attributes'=>array(
            array('name'=>'stock_id', 'value'=>$model->stock->stockText),

            array('name'=>'Tank in use', 'value'=>'Tank '.$model->tank_in_use),
            array('name'=>'attendant', 'label'=>'Last Assigned to:'),
            array('name'=>'closing_reading', 'label'=>'Meter Reading'),
            array('label'=>'Reading Date', 'name'=>'record_date')

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




