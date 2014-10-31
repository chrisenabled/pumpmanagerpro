
<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
));

Yii::app()->clientScript->registerScript('setFocus', '$(".username").focus();');

?>
<fieldset>

    <legend>Sign In</legend>
    <?php CHtml::$afterRequiredLabel = ''; ?>
    <?php echo $form->textFieldControlGroup($model, 'username',array('rel'=>"txtTooltip", 'title'=>'if you are employer than please enter your company email', 'class'=>'username', 'placeholder'=>'Enter your username', 'label'=>'')); ?>
    <?php echo $form->passwordFieldControlGroup($model, 'password', array('class'=>'', 'placeholder'=>'Enter your password', 'label'=>'')); ?>
</fieldset>
<?php echo TbHtml::formActions(array(
    TbHtml::submitButton('Sign in', array('color' => TbHtml::BUTTON_COLOR_PRIMARY)),
    TbHtml::link('Forgot Account ?',array('site/recovery'), array('class' => 'redButton btA')),

)); ?>

<?php $this->endWidget(); ?>

