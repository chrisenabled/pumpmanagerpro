
<div class="wide form update">

<?php $form=$this->beginWidget('CActiveForm', array(
'id'=>'user-form',
'enableAjaxValidation'=>false,

)); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'email'); ?>
        <?php echo $form->textField($model,'email',array('size'=>30,'maxlength'=>50, 'id'=>'email')); ?>
        <?php echo $form->error($model,'email'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'land_line'); ?>
        <?php echo $form->textField($model,'land_line',array('size'=>11,'minlength'=>10, 'maxlength'=>10, 'id'=>'landline')); ?>
        <?php echo $form->error($model,'land_line'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'mobile_number'); ?>
        <?php echo $form->textField($model,'mobile_number',array('size'=>11,'maxlength'=>11, 'id'=>'mobile')); ?>
        <?php echo $form->error($model,'mobile_number'); ?>
    </div>
    <br/>
    <span style="font-size: 0.8rem; margin-left: 1em; color:#FF7BB2">Please enter your password in order to save the changes made</span>
    <div class="row">
        <?php echo CHtml::label('password',''); ?>
        <?php echo CHtml::passwordField('password','',array('size'=>30,'maxlength'=>20,'value'=>'', 'id'=>'cpassword')); ?>
    </div>

    <div  id="contact_confirm" class="errorMessage"></div>


    <div class="row buttons">
        <?php echo CHtml::ajaxSubmitButton(
        'save',
        array("contact"),
        array('data'=>array(
            'mobile'=>'js:$("#mobile").val()',
            'password'=>'js:$("#cpassword").val()',
            'landline'=>'js:$("#landline").val()',
            'email'=>'js:$("#email").val()'
        ),
            'type'=>'POST',
            'update'=>'#contact_confirm',
            'beforeSend'=>'function(){$("#boot").addClass("boot");$("#boot").html("Please Wait.....");$("#boot").fadeIn();
            $("#contact_confirm").html(""); $("#contact_confirm").fadeIn();}',
            'complete'=> 'function(){$("#boot").fadeOut("fast");
            $("#contact_confirm").delay(3000).fadeOut("slow");$("#cpassword").val("");}'
        )

    ); ?>
    </div>

<?php $this->endWidget(); ?>

</div>

