

<div class="row-fluid">
    <div class="span8">
        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
    <div class="span2 offset1">
        <div class="right-side-icons-div">
            <div><?php echo TbHtml::link('<span>View&nbsp;Attendant</span>',array('//attendant/view', 'id'=>$model->id), array( 'class'=>'mini-icons-view icon32')); ?></div>
            <div><?php echo TbHtml::link('<span>Attendants</span>',array('//attendant/admin'), array( 'class'=>'mini-icons-attendant icon32')); ?></div>
            <div><?php echo TbHtml::link('<span>Add&nbsp;Attendant</span>',array('//attendant/create'), array( 'class'=>'mini-icons-add icon32')); ?></div>
            <div><?php echo TbHtml::link('<span>Delete&nbsp;Attendant</span>',array('url'=>'#'), array( 'class'=>'mini-icons-bin icon32','submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')); ?></div>

        </div>
    </div>
</div>