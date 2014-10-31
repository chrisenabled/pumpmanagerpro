<?php
/* @var $this ExpenditureController */
/* @var $model Expenditure */
/* @var $form CActiveForm */
?>
<?php
$cs = Yii::app()->clientScript;
$cs->registerScriptFile(
    Yii::app()->baseUrl . '/js/mask.js',
    CClientScript::POS_END
);
?>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>

<fieldset>

    <legend>Expenditure Form</legend>
    <p class="note">Fields with <span class="required">*</span> are required.</p>
    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->textFieldControlGroup($model,'title',array('class'=>'input-medium','maxlength'=>50)); ?>
    <?php echo $form->textAreaControlGroup($model,'description',array('class'=>'','maxlength'=>140)); ?>
    <?php echo $form->textFieldControlGroup($model,'expense',array('class'=>'numberFormat input-small','maxlength'=>8,'prepend'=>'₦')); ?>
     <?php
    $datePicker = $this->widget(
        'yiiwheels.widgets.formhelpers.WhDatePickerHelper',
        array(
            'inputOptions' => array('class' => 'input-small'),
            'model' => $model,
            'attribute' => 'this_date',

        ),true
    );
    ?>


    <?php echo TbHtml::customActiveControlGroup($datePicker, $model, 'this_date'); ?>

</fieldset>

<?php echo TbHtml::formActions(array(
    TbHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('color' => TbHtml::BUTTON_COLOR_PRIMARY)),
)); ?>

<?php $this->endWidget(); ?>


