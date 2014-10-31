
<h1>Update <?php echo $model->getStockText(); ?></h1>
<div class="row-fluid">
    <div class="span8 well">
        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
    <div class="span2 offset1">
        <div class="right-side-icons-div">
            <div><?php echo TbHtml::link('<span>View&nbsp;stock</span>',array('//stock/view', 'id'=>$model->id), array( 'class'=>'mini-icons-view icon32')); ?></div>
            <div><?php echo TbHtml::link('<span>stocks</span>',array('//stock/admin'), array( 'class'=>'mini-icons-stock icon32')); ?></div>
            <div><?php echo TbHtml::link('<span>Add&nbsp;stock</span>',array('//stock/create'), array( 'class'=>'mini-icons-add icon32')); ?></div>
        </div>
    </div>
</div>