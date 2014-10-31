
<div class="wide form update">

<?php $form=$this->beginWidget('CActiveForm', array(
'id'=>'user-form',
'enableAjaxValidation'=>false,

)); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'security_question'); ?>
        <?php echo $form->dropDownList($model,'security_question',$user->securityQuestions,array('id'=>'question')); ?>
        <?php echo $form->error($model,'security_question'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'security_answer'); ?>
        <?php echo $form->textField($model,'security_answer',array('size'=>11,'minlength'=>10, 'maxlength'=>10, 'id'=>'answer')); ?>
        <?php echo $form->error($model,'security_answer'); ?>
    </div>

    <br/>
    <span style="font-size: 0.8rem; margin-left: 1em; color:#FF7BB2">Please enter your password in order to save the changes made</span>
    <div class="row">
        <?php echo CHtml::label('password',''); ?>
        <?php echo CHtml::passwordField('password','',array('size'=>30,'maxlength'=>20,'value'=>'', 'id'=>'qpassword')); ?>
    </div>

    <div  id="qconfirm" class="errorMessage"></div>


    <div class="row buttons">
        <?php echo CHtml::ajaxSubmitButton(
        'save',
        array("question"),
        array('data'=>array(
            'question'=>'js:$("#question").val()',
            'answer'=>'js:$("#answer").val()',
            'password'=>'js:$("#qpassword").val()'
        ),
            'type'=>'POST',
            'update'=>'#qconfirm',
            'beforeSend'=>'function(){$("#boot").addClass("boot");$("#boot").html("Please Wait.....");$("#boot").fadeIn();
            $("#qconfirm").html(""); $("#qconfirm").fadeIn();}',
            'complete'=> 'function(){$("#boot").fadeOut("fast");
            $("#qconfirm").delay(3000).fadeOut("slow");$("#qpassword").val("");}'
        )

    ); ?>
    </div>

<?php $this->endWidget(); ?>

</div>

