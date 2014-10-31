<?php
$cs = Yii::app()->clientScript;
$cs->registerScript('setFocus', '$(".username").focus();');
$cs->registerScriptFile(
    Yii::app()->baseUrl . '/js/password.js',
    CClientScript::POS_END
);
?>


<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'verticalForm',
    'htmlOptions'=>array('class'=>'well'),
));
?>
    <span class="pull-right badge badge-inverse">create account</span><br class="clear">
<?php echo $form->textFieldControlGroup($model, 'username', array('class'=>'span12 username')); ?>
<div style="position: relative">
    <span class="progress" style="width: 23%; position: absolute; left: 75%">
            <span class="bar" style="width:0%"></span>
            <small class="feedback" style="font-size: 80%"></small>
        </span>
<?php echo $form->passwordFieldControlGroup($model, 'password', array('class'=>'span12 password')); ?>
</div>
<?php echo $form->passwordFieldControlGroup($model, 'password_repeat', array('class'=>'span12')); ?>
<?php echo $form->textFieldControlGroup($model, 'pin_code', array('class'=>'span4', 'maxLength'=>4)).' 4 digits pin code'; ?><br/><br/>

<?php echo $form->passwordFieldControlGroup($model, 'creatorPassCode', array('class'=>'span12')); ?>


    <div class="form-actions">
        <?php echo TbHtml::submitButton('Create', array('color' => TbHtml::BUTTON_COLOR_SUCCESS)); ?>
        <?php echo TbHtml::linkButton('Login', array('color' => TbHtml::BUTTON_COLOR_SUCCESS, 'size'=>'small', 'url'=>array('default/index'))); ?>
    </div>
<?php $this->endWidget(); ?>