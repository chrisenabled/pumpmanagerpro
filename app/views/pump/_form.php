
<?php
$cs = Yii::app()->clientScript;
$cs->registerScriptFile(
    Yii::app()->baseUrl . '/js/mask.js',
    CClientScript::POS_END
);
?>
<?php $noOfTanks = $model->tblTanks; ?>
<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>

<fieldset>

    <legend>Pump Form</legend>
    <?php if($model->isNewRecord){ ?>
    <?php echo TbHtml::alert(TbHtml::ALERT_COLOR_INFO, 'Note: You cannot edit/delete a pump after it has been used to make sales. Make sure
            the fields are accurate before submission.'); ?>
    <?php }else{  ?>
        <?php echo TbHtml::alert(TbHtml::ALERT_COLOR_INFO, 'Note: You cannot edit a pump reading after it has been submitted. Make sure
    the fields are accurate before submission.');
        if(count($noOfTanks) > 1)echo TbHtml::alert(TbHtml::ALERT_COLOR_DANGER, '<b>Important</b> : This pump uses more than one tank, make sure you select the appropriate
        tank that corresponds to the pump reading.');
        ?>
    <?php } ?>
    <p class="note">Fields with <span class="required">*</span> are required.</p>
    <?php echo $form->errorSummary($model); ?>
    <?php if($model->isNewRecord):?>
    <?php echo $form->textFieldControlGroup($model,'pump_no',array('class'=>'input-small','maxlength'=>3)); ?>
    <?php echo $form->dropDownListControlGroup($model,'stock_id',$model->getStockOptions(),array('class'=>'input-small',
        'prompt'=>'-Select-',
        'ajax'=>array(
            'type'=>'POST',
            'url'=>CController::createUrl('chooseTank'),
            'dataType'=>'json',//.CHtml::activeId($model, 'tanks'),
            'beforeSend'=>'js:function(){$("#tanks").html("processing...")}',
            'success'=> 'function(data){
                        if(data.status != ""){$("#tanks").html("Select the tank or tanks(s) this pump will use: <br/><br/>" + data.status);}
                        else{$("#tanks").html("");}
                    }'
    ))); ?>
                <div id="tanks"></div>
    <?php endif;?>
    <?php if(!$model->isNewRecord):?>

                <?php
                $a = '';
                    foreach($noOfTanks as $noOfTank){
                        $checked = '';
                        if($noOfTank->tank_no == $model->tank_in_use)$checked = 'checked';
                        $a .= '<input '. $checked .'  type="radio" name="' . CHtml::activeName($model, 'tank_in_use') . '" value="' . $noOfTank->tank_no . '" ' .  'id="'. $noOfTank->tank_no  . '"/>'.
                            '<label class = "custom" for="'. $noOfTank->tank_no .'"><span class="first"></span><span class="second">'.$noOfTank->tank_no .'</span></label>';
                    }
                 echo TbHtml::customActiveControlGroup($a, $model, 'tank_in_use');
                ?>
        <?php echo $form->dropDownListControlGroup($model,'shift',$model->getShiftOptions(), array('prompt'=>'--Select Shift--','options'=>array(4=>array('selected'=>'selected')))); ?>
        <?php echo $form->dropDownListControlGroup($model,'attendant',$model->getAttendants(), array('empty'=>'--Select Attendant--')); ?>
        <?php echo $form->textFieldControlGroup($model,'money_received', array('class'=>'span6 numberFormat', 'value'=>'','prepend'=>'₦')); ?>
        <?php echo $form->textFieldControlGroup($model,'entry_reading', array('value'=>'', 'class'=>'reading span4')); ?>
        <?php echo $form->textFieldControlGroup($model,'closing_reading', array('value'=>'', 'class'=>'reading span4')); ?>
        <?php
            if($model->record_date == '0000-00-00')$model->record_date = null;
             $datePicker = $this->widget(
            'yiiwheels.widgets.formhelpers.WhDatePickerHelper',
            array(
                'inputOptions' => array('class' => 'span6'),
                'model' => $model,
                'attribute' => 'record_date',
                ),true
            );
        ?>
    <?php echo TbHtml::customActiveControlGroup($datePicker, $model, 'record_date'); ?>
    <?php endif;?>

</fieldset>

<?php echo TbHtml::formActions(array(
    TbHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('color' => TbHtml::BUTTON_COLOR_PRIMARY)),
)); ?>

<?php $this->endWidget(); ?>

