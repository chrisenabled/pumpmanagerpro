<?php
/* @var $this AttendantController */
/* @var $model Attendant */
/* @var $form CActiveForm */
Yii::app()->clientScript->registerScriptFile(
    Yii::app()->baseUrl . '/js/mask.js',
    CClientScript::POS_END
);
Yii::app()->clientScript->registerScript('maskInput', "
jQuery(function($){
        $.mask.definitions['h'] = '[8,7]';
        $.mask.definitions['i'] = '[0,1]';
        $('#mobile').mask('(0hi) 999-99999');
    });

");
?>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>

<fieldset>

    <legend>Attendant Form</legend>
    <p class="note">Fields with <span class="required">*</span> are required.</p>
    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->textFieldControlGroup($model,'first_name',array('size'=>20,'maxlength'=>20)); ?>
    <?php echo $form->textFieldControlGroup($model,'middle_name',array('size'=>20,'maxlength'=>20)); ?>
    <?php echo $form->textFieldControlGroup($model,'last_name',array('size'=>20,'maxlength'=>20)); ?>
    <?php echo $form->dropDownListControlGroup($model,'gender',$model->getGenderOptions(), array('prompt'=>'--Select Gender--')); ?>
    <?php echo $form->dropDownListControlGroup($model,'state_of_origin',$model->getStateOptions(), array('prompt'=>'--Select State--')); ?>
    <?php echo $form->textFieldControlGroup($model,'mobile_number',array('id'=>'mobile', 'size'=>13)); ?>
    <?php
    $datePicker = $this->widget(
        'yiiwheels.widgets.formhelpers.WhDatePickerHelper',
        array(
            'inputOptions' => array('class' => 'input-small'),
            'model' => $model,
            'attribute' => 'date_employed',

        ),true
    );
    ?>


    <?php echo TbHtml::customActiveControlGroup($datePicker, $model, 'date_employed'); ?>

</fieldset>

<?php echo TbHtml::formActions(array(
    TbHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('color' => TbHtml::BUTTON_COLOR_PRIMARY)),
)); ?>

<?php $this->endWidget(); ?>



