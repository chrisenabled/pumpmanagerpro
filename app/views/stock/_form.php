<?php
/* @var $this StockController */
/* @var $model Stock */
/* @var $form CActiveForm */
?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'stock-form',
	'enableAjaxValidation'=>false,
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,

)); ?>

    <fieldset>
        <legend>Stock Form</legend>
        <?php echo $form->errorSummary($model); ?>
        <p class="note">Fields with <span class="required">*</span> are required.</p>
        <?php if($model->isNewRecord):?>
                <?php echo $form->dropDownListControlGroup($model,'stock_type', $model->getStocks(),array('class'=>'input-small')); ?>
        <?php endif;?>
            <?php echo $form->textFieldControlGroup($model,'cost_price',array('class'=>'input-small','value'=> $model->isNewRecord? '' : $model->cost_price,'prepend'=>'₦')); ?>
            <?php echo $form->textFieldControlGroup($model,'selling_price',array('class'=>'input-small','value'=> $model->isNewRecord? '' : $model->selling_price,'prepend'=>'₦')); ?>
    </fieldset>

    <?php echo TbHtml::formActions(array(
        TbHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('color' => TbHtml::BUTTON_COLOR_PRIMARY)),
    )); ?>

<?php $this->endWidget(); ?>
