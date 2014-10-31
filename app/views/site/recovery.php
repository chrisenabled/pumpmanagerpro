<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Recovery';
$this->layout = '//layouts/bootstrap4';
?>

<div class="row-fluid" xmlns="http://www.w3.org/1999/html">
    <div class="span8 offset2">
        <h4 class="problemTypes">Select the sentence that explains your problem.</h4><br/>
        <div>
            <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
            'id'=>'recoveryForm',
            'htmlOptions'=>array('class'=>'writing', 'style'=>'text-shadow:none;'),
        )); ?>

            <div class="problemTypes">
            <?php echo $form->radioButtonListRow($model, 'problemType', $model->getProblemType(),array('id'=>'radio', 'checked'=>false,
            'onclick'=>'js:
                if(this.value == 1){$("#tbUsername").val(""); $("#tbMobile").val(""); $("#password").show(); $("#emailAdd").show(); $("#error").hide(); $("#username").hide(); $("#mobile").hide(); $("#nextStep").show(); $("#finish").hide(); $("#security").hide(); $("#finalStep").hide();}
                if(this.value == 2){$("#password").hide(); $("#emailAdd").show(); $("#tbPassword").val(""); $("#error").hide(); $("#tbMobile").val(""); $("#username").show(); $("#mobile").hide(); $("#nextStep").show(); $("#finish").hide(); $("#security").hide(); $("#finalStep").hide();}
                if(this.value == 3){$("#password").hide(); $("#emailAdd").show(); $("#username").hide(); $("#error").hide(); $("#tbUsername").val(""); $("#tbPassword").val(""); $("#mobile").show(); $("#nextStep").show(); $("#finish").hide(); $("#security").hide(); $("#finalStep").hide();}

            ',
             )); ?></div>
            <br/>
            <div>
                <p id="username" class="q" style="display: none">
                    Enter the Username of your account <span style="color: red">*</span><br/>
                    <?php echo $form->textField($model,'username', array('id'=>'tbUsername')); ?>
                </p>
                <p id="password" class="q" style="display: none">
                    Enter the Password of your account <span style="color: red">*</span><br/>
                    <?php echo $form->passwordField($model,'userPassword', array('id'=>'tbPassword')); ?>
                </p>
                <p id="mobile" class="q" style="display: none">
                    Enter the Mobile Number registered on your account <span style="color: red">*</span><br/>
                    <?php echo $form->textField($model,'mobile', array('id'=>'tbMobile')); ?>
                </p>
                <p id="emailAdd" class="q" style="display: none">
                    Enter the email address connected to your account <span style="color: red">*</span><br/>
                    <?php echo $form->textField($model, 'email'); ?>
                </p>
                <p id="security" class="q" style="display: none">
                    <span id="securityQ"></span><br/>
                    <?php echo $form->textField($model,'securityAnswer'); ?>
                </p>
                <p id="error" style="display: none">
                    <span style='color: red' >The data you supplied is incorrect, please try again</span>
                </p>
                <br/>
                <p id="nextStep" style="display: none" >
                    <?php echo CHtml::ajaxSubmitButton(
                    'Next Step',
                    array("recoveryAjax"),
                    array(

                        'type'=>'POST',
                        'dataType'=>'json',
                        'success'=> 'function(data){
                            if(data.status == "success"){
                                $("#securityQ").html(data.securityQuestion); $("#error").hide(); $(".q").hide();
                                $("#security").show(); $("#nextStep").hide(); $("#finalStep").show();
                            }
                            if(data.status == "fail"){
                                $("#error").show()
                            }
                            if(data.status == "successPassword"){
                                $("#nextStep").hide(); $("#finish").show(); $(".q").hide();
                                $(".problemTypes").hide(); $("#error").hide();
                            }

                        }'
                    ),
                    array('class'=>'blueButton')

                ); ?>
                </p>
                <p id="finalStep" style="display: none">
                    <?php echo CHtml::ajaxSubmitButton(
                    'Final Step',
                    array("recoveryAjaxFinal"),
                    array(

                        'type'=>'POST',
                        'dataType'=>'json',
                        'success'=> 'function(data){
                            if(data.status == "success"){
                                $("#error").hide(); $(".q").hide(); $(".problemTypes").hide(); $("#finish").show(); $("#finalStep").hide();
                            }
                            if(data.status == "fail"){
                                $("#error").show()
                            }

                        }',
                    ),
                    array('class'=>'blueButton')

                ); ?>
                </p>
            </div>
            <div class="boot btglassy btboxradius">Please Wait...</div>
            <div id="finish" style="display: none">
                <h5>Enter the captcha correctly, as an incorrect input will cause the recovery process to start afresh.</h5>
                <br/>
                <?php if(CCaptcha::checkRequirements()): ?>
                <?php echo $form->captchaRow($model, 'verifyCode',array( 'hint'=>
                    'Confirm that you are <code>Human</code> by entering the letters as they are shown in the image above.
                    Letters are not case-sensitive.'
                )); ?>
                <?php endif; ?>
                <div class="form-actions">
                    <?php $this->widget('bootstrap.widgets.TbButton', array(
                    'buttonType'=>'submit',
                    'type'=>'primary',
                    'label'=>'Send',
                    'htmlOptions'=>array(
                        'onclick'=>'js: $(".boot").show();

                        '
                    )
                    )); ?>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>
<?php if((Yii::app()->user->hasFlash('success') ||Yii::app()->user->hasFlash('error')) && !Yii::app()->user->isGuest):?>
    <div style="position: fixed; top: 50px; left: 40%;">
        <?php
        $this->widget('bootstrap.widgets.TbAlert', array('id'=>'flash',
            'block'=>false, // display a larger alert block?
            'fade'=>true, // use transitions?
            'closeText'=>'×', // close link text - if set to false, no close link is displayed
            'alerts'=>array( // configurations per alert type
                'success'=>array('block'=>false, 'fade'=>true, 'closeText'=>'×'), // success, info, warning, error or danger
                'error'=>array('block'=>false, 'fade'=>true, 'closeText'=>'×'),
            ),
        ));
        ?>
    </div>
<?php endif; ?>


