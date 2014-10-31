<div class="row-fluid">
    <div class="span8 well">
        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
    <div class="span2 offset1">
        <div class="right-side-icons-div">
            <div><?php echo TbHtml::link('<span>View&nbsp;Pump</span>',array('//pump/view', 'id'=>$model->id), array( 'class'=>'mini-icons-view icon32')); ?></div>
            <div><?php echo TbHtml::link('<span>Pumps</span>',array('//pump/admin'), array( 'class'=>'mini-icons-pump icon32')); ?></div>
            <div><?php echo TbHtml::link('<span>Add&nbsp;Pump</span>',array('//pump/create'), array( 'class'=>'mini-icons-add icon32')); ?></div>
        </div>
    </div>
</div>
