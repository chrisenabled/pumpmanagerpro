

<h3>Update Expenditure #<?php echo $model->id; ?></h3>



<div class="row-fluid">
    <div class="span8 well">
        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
    <div class="span2 offset1">
        <div class="right-side-icons-div">
            <div><?php echo TbHtml::link('<span>View&nbsp;Expenditure</span>',array('//expenditure/view', 'id'=>$model->id), array( 'class'=>'mini-icons-view icon32')); ?></div>
            <div><?php echo TbHtml::link('<span>Expenditure</span>',array('//expenditure/admin'), array( 'class'=>'mini-icons-expenditure icon32')); ?></div>
            <div><?php echo TbHtml::link('<span>Add&nbsp;Expenditure</span>',array('//expenditure/create'), array( 'class'=>'mini-icons-add icon32')); ?></div>
            <div><?php echo TbHtml::link('<span>Delete&nbsp;Expenditure</span>',array('url'=>'#'), array( 'class'=>'mini-icons-bin icon32','submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')); ?></div>

        </div>
    </div>
</div>