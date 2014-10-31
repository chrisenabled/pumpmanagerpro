<?php
/* @var $this InvoiceController */
/* @var $model Invoice */
/* @var $form CActiveForm */
?>
<?php
$cs = Yii::app()->clientScript;
$cs->registerScriptFile(
    Yii::app()->baseUrl . '/js/mask.js',
    CClientScript::POS_END
);
?>
<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'invoice-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'id'); ?>
		<?php echo $form->textField($model,'id',array('size'=>8)); ?>
		<?php echo $form->error($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'vehicle_no'); ?>
		<?php echo $form->textField($model,'vehicle_no',array('size'=>8,'maxlength'=>8)); ?>
		<?php echo $form->error($model,'vehicle_no'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'stock_type'); ?>
		<?php echo $form->dropDownList($model,'stock_type',$model->stockOptions,array('prompt'=>'Select Type')); ?>
		<?php echo $form->error($model,'stock_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'quantity'); ?>
		<?php echo $form->textField($model,'quantity',array('size'=>5,'maxlength'=>6, 'class'=>'numberFormat')).' Litres'; ?>
		<?php echo $form->error($model,'quantity'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'price'); ?>
		<?php echo '₦ '.$form->textField($model,'price',array('size'=>5,'maxlength'=>6)); ?>
		<?php echo $form->error($model,'price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'invoice_date'); ?>
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model'=>$model,
            'attribute'=> 'invoice_date',
            // additional javascript options for the date picker plugin
            'options'=>array(
                'showAnim'=>'slideDown',//'show' (the default), 'slideDown', 'fadeIn', 'fold'
                'dateFormat'=>'yy-mm-dd',
                'showOn'=>'both',// 'focus', 'button', 'both'
                'buttonText'=>Yii::t('ui','Select form calendar'),
                'buttonImage'=>Yii::app()->request->baseUrl.'/images/calendar.png',
                'buttonImageOnly'=>true,
            ),
            'htmlOptions'=>array(
                'style'=>'height:20px;',
                'style'=>'width:80px;vertical-align:top',
                'value'=>''
            ),
        ));?>
		<?php echo $form->error($model,'invoice_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_received'); ?>
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model'=>$model,
            'attribute'=> 'date_received',
            // additional javascript options for the date picker plugin
            'options'=>array(
                'showAnim'=>'slideDown',//'show' (the default), 'slideDown', 'fadeIn', 'fold'
                'dateFormat'=>'yy-mm-dd',
                'showOn'=>'both',// 'focus', 'button', 'both'
                'buttonText'=>Yii::t('ui','Select form calendar'),
                'buttonImage'=>Yii::app()->request->baseUrl.'/images/calendar.png',
                'buttonImageOnly'=>true,
            ),
            'htmlOptions'=>array(
                'style'=>'height:20px;',
                'style'=>'width:80px;vertical-align:top',
                'value'=>''
            ),
        ));?>
		<?php echo $form->error($model,'date_received'); ?>
	</div>

    <div class="row">
        &emsp;Choose Invoice Type<br/><br/>
        <?php echo $form->radioButtonList($model,'invoice_type',array('company','station')); ?>
        <?php echo $form->error($model,'type'); ?>
    </div>

    <div class="note" style="color: #3e3e3e">
        Click the checkbox below to make quantity adjustment (if any).
    </div>
    <div class="row">
        <?php echo $form->labelEx($model,'adjustment'); ?>
        <?php echo CHtml::checkBox('','',array('id'=>'checkbox',

            'onclick'=>'js:if($("#checkbox").prop("checked")=== true){$("#adjustment").show();}else{$("#dip").val(0.00); $("#adjustment").hide();}',


        )); ?>
        <?php echo $form->error($model,'adjustment'); ?>
    </div>
    <div class="row" id='adjustment' style="display: none">

        <?php echo 'Quantity after Dipping '.$form->textField($model,'adjustment',array('id'=>'dip',
            'onclick'=>'js:$(this).val("")','class'=>'numberFormat',
            'size'=>5,
            'maxlength'=>6,
        )).' Litres';  ?>
    </div>

    <br/><br/>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('confirm'=>
        'Are you sure you want to save ?')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->