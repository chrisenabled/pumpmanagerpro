

<h1>Create Expenditure</h1>

<div class="row-fluid">
    <div class="span8 well">
        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
    <div class="span2 offset1">
        <div class="right-side-icons-div">
            <div><?php echo TbHtml::link('<span>Expenditures</span>',array('//expenditure/admin'), array( 'class'=>'mini-icons-expenditure icon32')); ?></div>
            <div><?php echo TbHtml::link('<span>Add&nbsp;Expenditure</span>',array('//expenditure/create'), array( 'class'=>'mini-icons-add icon32')); ?></div>
        </div>
    </div>
</div>