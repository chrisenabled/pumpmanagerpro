

<div class="top-mini-icons-div-container" style="margin-top: 30px;">
    <div class="top-mini-icons-div">
        <?php echo TbHtml::link('<span class="hspan">Expenditures</span>',array('//expenditure/admin'), array('class'=>'mini-icons-expenditure icon32')); ?>
    </div>
    <div class="top-mini-icons-div"><?php echo TbHtml::link('<span class="hspan">Add&nbsp;Expenditure</span>',array('//expenditure/create'), array( 'class'=>'mini-icons-add icon32')); ?></div>
    <div class="top-mini-icons-div"><?php echo TbHtml::link('<span class="hspan">Print&nbsp;Info</span>',array('url'=>'javascript:void(0);return false'), array( 'class'=>'mini-icons-print icon32','onclick'=>'printDiv();return false;')); ?></div>
    <div class="top-mini-icons-div"><?php echo TbHtml::link('<span class="hspan">Edit&nbsp;Expenditure</span>',array('//expenditure/update', 'id'=>$model->id), array('class'=>'mini-icons-edit icon32')); ?></div>
    <div class="top-mini-icons-div"><?php echo TbHtml::link('<span class="hspan">Delete&nbsp;Expenditure</span>',array('url'=>'#'), array( 'class'=>'mini-icons-bin icon32','submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this Attendant?')); ?></div>

    <br class="break" />
</div>

<div class="printableArea">
    <?php $this->widget('bootstrap.widgets.TbDetailView', array(
        'data'=>$model,
        'attributes'=>array(
            'id',
            'title',
            'description',
            array('name'=>'expense', 'value'=>Yii::app()->numberFormatter->format("₦#,##0.00",$model->expense)),
            array('name'=>'Initial Profit', 'value'=>Yii::app()->numberFormatter->format("₦#,##0.00",$model->initial_profit)),
            array('name'=>'Net Profit', 'value'=>Yii::app()->numberFormatter->format("₦#,##0.00",$model->final_profit)),
            'this_date',
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

