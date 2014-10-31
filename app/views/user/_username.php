
<div class="wide form update">

<?php $form=$this->beginWidget('CActiveForm', array(
'id'=>'username-form',
'enableAjaxValidation'=>false,

)); ?>

    <div class="row">
        <?php echo CHtml::label('username',''); ?>
        <?php echo $form->textField($model,'username',array('id'=>'username',
            'ajax'=>array(
                'type'=>'POST',
                'url'=>CController::createUrl('userAvailable'),
                'update'=>'#availability',
                'data'=>array('username'=>'js:$("#username").val()'),
                'beforeSend'=>'function(){$("#availability").html(""); $("#availability").fadeIn();}',
                'complete'=>'function(){if($("#availability").text().indexOf("taken") > -1){$("#username").val("");}
                                    $("#availability").delay(3000).fadeOut("slow");}'
            ),
            'size'=>30,'maxlength'=>30))?>
        <div  id="availability" class="errorMessage"></div>
    </div>

    <br/>
    <span style="font-size: 0.8rem; margin-left: 1em; color:#FF7BB2">Please enter your password in order to save the changes made</span>
    <div class="row">
        <?php echo CHtml::label('password',''); ?>
        <?php echo CHtml::passwordField('password','',array('size'=>30,'maxlength'=>30,'value'=>'', 'id'=>'upassword')); ?>
    </div>

    <div  id="user_confirm" class="errorMessage"></div>


    <div class="row buttons">
        <?php echo CHtml::ajaxSubmitButton(
        'save',
        array("username"),
        array('data'=>array(
                'username'=>'js:$("#username").val()',
                'password'=>'js:$("#upassword").val()'
            ),
            'type'=>'POST',
            'update'=>'#user_confirm',
            'beforeSend'=>'function(){$("#boot").addClass("boot");$("#boot").html("Please Wait.....");$("#boot").fadeIn();
            $("#user_confirm").html(""); $("#user_confirm").fadeIn();}',
            'complete'=> 'function(){$("#boot").fadeOut("fast");
            $("#user_confirm").delay(3000).fadeOut("slow");$("#upassword").val("");}'
        )

    ); ?>
    </div>

<?php $this->endWidget(); ?>

</div>

