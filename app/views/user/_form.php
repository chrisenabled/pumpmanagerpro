<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
$cs = Yii::app()->clientScript;
$cs->registerScriptFile(
    Yii::app()->baseUrl . '/js/password.js',
    CClientScript::POS_END
);
$cs->registerScriptFile(
    Yii::app()->baseUrl . '/js/mask.js',
    CClientScript::POS_END
);
$cs->registerScript('maskInput', "
jQuery(function($){
        $.mask.definitions['h'] = '[8,7]';
        $.mask.definitions['i'] = '[0,1]';
        $('#mobile').mask('(0hi) 999-99999');
        $('#line').mask('(09)-9999999');
        $('#marketer').mask('9 9 9 9');
    });

");
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/password.css','screen');
?>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'verticalForm',
    'htmlOptions'=>array( 'class'=>''),
)); ?>
<?php CHtml::$afterRequiredLabel = ''; ?>

    <p class="pull-right"><span class="badge badge-inverse">Create Account</span></p><br style="clear: both" />

    <?php echo $form->textFieldControlGroup($model, 'username', array('label'=>'', 'class'=>'span12', 'label'=>'','placeholder'=>'Username (required)')); ?>

    <div style="position: relative">
        <span class="progressBar" style="width: 20px; height: 20px; position: absolute; top: 4px; right: 5px">
        </span>
        <?php echo $form->passwordFieldControlGroup($model, 'password', array('label'=>'', 'class'=>'span12 password', 'placeholder'=>'Password (required) must be at least 6 letters')); ?>
    </div>
    <?php echo $form->passwordFieldControlGroup($model, 'password_repeat', array('label'=>'', 'class'=>'span12', 'placeholder'=>'Confirm Password (required)')); ?>
    <?php echo $form->dropDownListControlGroup($model, 'station_id',$model->getStationOptions(),array('label'=>'', 'class'=>'span12',
        'disabled'=> ($model->isNewRecord)? false:true,
        'prompt'=>'Select Your Filling Station',
        'ajax'=>array(
            'type'=>'POST',
            'url'=>CController::createUrl('otherStation'),
            'update'=>'#other',
        ),
    )); ?>
    <div id="other"></div>
    <?php echo $form->textFieldControlGroup($model,'line_1',array('label'=>'', 'class'=>'span12','maxlength'=>50, 'placeholder'=>'Address Line 1 (required)')); ?>
    <?php echo $form->textFieldControlGroup($model,'line_2',array('label'=>'', 'class'=>'span12','maxlength'=>50, 'placeholder'=>'Address Line 2 (optional)')); ?>
    <?php echo $form->dropDownListControlGroup($model,'state', $model->getStateOptions(), array('label'=>'', 'class'=>'span12', 'id'=>'state',
        'prompt'=>'Select State of Station location',
        'ajax'=>array(
            'type'=>'POST',
            'dataType'=>'json',
            'url'=>CController::createUrl('location'),
            'beforeSend'=>'function(){$("#location").html("Loading..")}',
            'success'=>'function(data){
                if(data.content == "")$("#location").hide();
                else
                $("#location").html(data.content).show();
            }'
        ),
    )); ?>

    <div id="location"></div>
    <?php echo $form->textFieldControlGroup($model,'email',array('label'=>'', 'class'=>'span12','maxlength'=>50,'placeholder'=>'Email (required)')); ?>
    <?php echo $form->textFieldControlGroup($model,'mobile_number',array('label'=>'', 'class'=>'span12','id'=>'mobile','maxlength'=>11,
        'placeholder'=>'Mobile (required)')); ?>
    <?php echo $form->textFieldControlGroup($model,'land_line',array('label'=>'', 'class'=>'span12', 'id'=>'line', 'maxlength'=>10, 'placeholder'=>'Land line (optional)')); ?>
    <?php echo $form->dropDownListControlGroup($model,'security_question',$model->securityQuestions,array('label'=>'', 'class'=>'span12',
        'prompt'=>'Select a security question'
    )); ?>
    <?php echo $form->textFieldControlGroup($model,'security_answer',array('label'=>'', 'class'=>'span12','maxlength'=>10,
        'placeholder'=>'Answer to the security question'
    )); ?>
    <?php echo $form->textFieldControlGroup($model,'marketerId',array('id'=>'marketer', 'label'=>'', 'class'=>'span12','maxlength'=>4,'placeholder'=>'Marketer ID (optional)')); ?>

<?php
$mobile = $this->widget(
    'yiiwheels.widgets.formhelpers.WhPhone',
    array(
        'model' => $model,
        'attribute' => 'mobile_number',
        'format' => '+234 (dd) ddd-dddd',
    ),true
);
echo TbHtml::customActiveControlGroup($mobile, $model, 'mobile_number',array('placeholder'=>'Mobile'));
?>

    <?php echo $form->checkboxControlGroup($model, 'agreement',array('help'=>'By ticking this checkbox, I agree to the '.
        CHtml::link('Terms of Service',array('site/page', 'view'=>'legal')).' and '.
        CHtml::link('Privacy Policy',array('site/page', 'view'=>'legal')).' of Pump Manager Pro.
    ')); ?><br>

    <?php if(CCaptcha::checkRequirements()): ?>
        <?php $this->widget('CCaptcha'); ?>
        <?php echo $form->textFieldControlGroup($model,'verifyCode', array('help'=>'Please enter the letters as they are shown in the image above.
        Letters are not case-sensitive.')); ?>
    <?php endif; ?>
    <div class="form-actions">
        <?php
        echo TbHtml::submitButton('Sign Up', array('color' => TbHtml::BUTTON_COLOR_SUCCESS ));
        ?>
    </div>
    <?php $this->endWidget(); ?>
</div>
