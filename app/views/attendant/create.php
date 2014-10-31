
<div class="row-fluid">
    <div class="span8 well">
        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
    <div class="span2 offset1">
        <div class="right-side-icons-div">
            <div><?php echo TbHtml::link('<span>Attendants</span>',array('//attendant/admin'), array( 'class'=>'mini-icons-attendant icon32')); ?></div>
            <div><?php echo TbHtml::link('<span>Add&nbsp;Attendant</span>',array('//attendant/create'), array( 'class'=>'mini-icons-add icon32')); ?></div>
        </div>
    </div>
</div>