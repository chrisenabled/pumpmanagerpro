<?php
/* @var $this TankController */
/* @var $model Tank */
/* @var $form CActiveForm */
?>
<?php
$cs = Yii::app()->clientScript;
$cs->registerScriptFile(
    Yii::app()->baseUrl . '/js/mask.js',
    CClientScript::POS_END
);
?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'tank-form',
    'enableAjaxValidation'=>false,
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>


    <fieldset>
        <legend>Tank Form</legend>
        <?php echo $form->errorSummary($model); ?>
        <?php if($model->isNewRecord){ ?>
            <?php echo TbHtml::alert(TbHtml::ALERT_COLOR_INFO, 'Note: You cannot edit/delete a tank after stock quantity has been inputted. Make sure
            the fields are accurate before submission.'); ?>
        <?php }else{  ?>
        <?php echo TbHtml::alert(TbHtml::ALERT_COLOR_INFO, 'Note: You cannot edit after record has been submitted. Make sure
    the fields are accurate before submission.'); ?>
        <?php } ?>
        <p class="note">Fields with <span class="required">*</span> are required.</p>

        <?php if ($model->isNewRecord):?>
            <?php echo $form->dropDownListControlGroup($model,'stock_id',$model->getStockOptions(),array('class'=>'input-small')); ?>
            <?php echo $form->textFieldControlGroup($model,'tank_no',array('class'=>'input-small')); ?>

            <?php echo $form->textFieldControlGroup($model,'capacity',array( 'class'=>'numberFormat input-small', 'append'=>'Litres')); ?>


        <?php endif;?>

        <?php if(!$model->isNewRecord):?>

            <?php echo $form->textFieldControlGroup($model,'added_qty', array('value'=>'','class'=>'numberFormat input-small', 'append'=>'Litres')); ?>
            <?php
            if($model->last_added_date == '0000-00-00')$model->last_added_date = null;
            $datePicker = $this->widget(
                'yiiwheels.widgets.formhelpers.WhDatePickerHelper',
                array(
                    'inputOptions' => array('class' => 'input-small'),
                    'model' => $model,
                    'attribute' => 'last_added_date',
                ),true
            );
            ?>
            <?php echo TbHtml::customActiveControlGroup($datePicker, $model, 'last_added_date'); ?>

        <?php endif;?>
    </fieldset>

    <?php echo TbHtml::formActions(array(
        TbHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('color' => TbHtml::BUTTON_COLOR_PRIMARY)),
    )); ?>

<?php $this->endWidget(); ?>

