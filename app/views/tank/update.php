<div class="row-fluid">
    <div class="span8 well">
        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
    <div class="span2 offset1">
        <div class="right-side-icons-div">
            <div><?php echo TbHtml::link('<span>View&nbsp;Tank</span>',array('//tank/view', 'id'=>$model->id), array( 'class'=>'mini-icons-view icon32')); ?></div>
            <div><?php echo TbHtml::link('<span>Tanks</span>',array('//tank/admin'), array( 'class'=>'mini-icons-tank icon32')); ?></div>
            <div><?php echo TbHtml::link('<span>Add&nbsp;Tank</span>',array('//tank/create'), array( 'class'=>'mini-icons-add icon32')); ?></div>
        </div>
    </div>
</div>