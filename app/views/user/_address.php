
<div class="wide form update">

<?php $form=$this->beginWidget('CActiveForm', array(
'id'=>'user-form',
'enableAjaxValidation'=>false,

)); ?>

    <div class="row">
        <?php echo CHtml::label('new address',''); ?>
    </div>
    <br>

    <div class="row">
        <?php echo CHtml::label('line 1',''); ?>
        <?php echo CHtml::textField('line_1','',array('size'=>50,'maxlength'=>50, 'id'=>'line1')); ?>
    </div>

    <div class="row">
        <?php echo CHtml::label('line 2',''); ?>
        <?php echo CHtml::textField('line_2','',array('size'=>50,'maxlength'=>50, 'id'=>'line2')); ?>

    </div>
    <br/>
    <span style="font-size: 0.8rem; margin-left: 1em; color:#FF7BB2">Please enter your password in order to save the changes made</span>
    <div class="row">
        <?php echo CHtml::label('password',''); ?>
        <?php echo CHtml::passwordField('password','',array('size'=>30,'maxlength'=>20,'value'=>'', 'id'=>'apassword')); ?>
    </div>

    <div  id="ad_confirm" class="errorMessage"></div>


    <div class="row buttons">
        <?php echo CHtml::ajaxSubmitButton(
        'save',
        array("address"),
        array('data'=>array(
            'password'=>'js:$("#apassword").val()',
            'line1'=>'js:$("#line1").val()',
            'line2'=>'js:$("#line2").val()'
        ),
            'type'=>'POST',
            'update'=>'#ad_confirm',
            'beforeSend'=>'function(){$("#boot").addClass("boot");$("#boot").html("Please Wait.....");$("#boot").fadeIn();
            $("#ad_confirm").html(""); $("#ad_confirm").fadeIn();}',
            'complete'=> 'function(){$("#boot").fadeOut("fast");
            $("#ad_confirm").delay(3000).fadeOut("slow"); $("#apassword").val("");}'
        )

    ); ?>
    </div>

<?php $this->endWidget(); ?>

</div>

