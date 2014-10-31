<?php

$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->baseUrl . '/js/password.js',
    CClientScript::POS_END
);

$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/password.css','screen');

?>
<div class="wide form update">

<?php $form=$this->beginWidget('CActiveForm', array(
'id'=>'user-form',
'enableAjaxValidation'=>false,

)); ?>

    <div class="row">
        <?php echo CHtml::label('old password',''); ?>
        <?php echo CHtml::passwordField('password','',array('size'=>30,'maxlength'=>20, 'id'=>'ppassword')); ?>

    </div>

    <div class="row pswd">
        <?php echo CHtml::label('new password',''); ?>
        <?php echo CHtml::passwordField('password','',array('size'=>30,'maxlength'=>20, 'id'=>"newpswd",'class'=>'password')); ?>

        <div class="progress red row">
            <span class="bar" style="width:0%"></span>
            <small class="feedback"></small>
        </div>
    </div>

    <div class="row">
        <?php echo CHtml::label('password repeat',''); ?>
        <?php echo CHtml::passwordField('password repeat','',array('size'=>30,'maxlength'=>20, 'id'=>'pswdrpt')); ?>
    </div>

    <div  id="pswd_confirm" class="errorMessage"></div>


    <div class="row buttons">
        <?php echo CHtml::ajaxSubmitButton(
        'save',
        array("password"),
        array('data'=>array(
            'newpswd'=>'js:$("#newpswd").val()',
            'pswdrpt'=>'js:$("#pswdrpt").val()',
            'password'=>'js:$("#ppassword").val()'
        ),
            'type'=>'POST',
            'update'=>'#pswd_confirm',
            'beforeSend'=>'function(){$("#boot").addClass("boot");$("#boot").html("Please Wait.....");$("#boot").fadeIn();
            $("#pswd_confirm").html(""); $("#pswd_confirm").fadeIn();}',
            'complete'=> 'function(){$("#boot").fadeOut("fast");
            $("#pswd_confirm").delay(3000).fadeOut("slow");$("#ppassword").val(""); $("#pswdrpt").val("");}'
        )

    ); ?>
    </div>

<?php $this->endWidget(); ?>

</div>

