<div class="form">
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'tbl-test-form',
	'enableAjaxValidation'=>false,
        'method'=>'post',
	'type'=>'horizontal',
	'htmlOptions'=>array(
		'enctype'=>'multipart/form-data'
	)
)); ?>
     	<fieldset>
		<legend>
			<p class="note">Fields with <span class="required">*</span> are required.</p>
		</legend>

	<?php echo $form->errorSummary($model,'Opps!!!', null,array('class'=>'alert alert-error span12')); ?>
        		
   <div class="control-group">		
			<div class="span4">

	<?php echo $form->textFieldRow($model,'id',array('class'=>'span5','maxlength'=>8)); ?>

	<?php echo $form->textFieldRow($model,'username',array('class'=>'span5','maxlength'=>30)); ?>

	<?php echo $form->passwordFieldRow($model,'password',array('class'=>'span5','maxlength'=>90)); ?>

	<?php echo $form->textFieldRow($model,'station_id',array('class'=>'span5','maxlength'=>3)); ?>

	<?php echo $form->textFieldRow($model,'address',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'location_id',array('class'=>'span5','maxlength'=>3)); ?>

	<?php echo $form->textFieldRow($model,'email',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'land_line',array('class'=>'span5','maxlength'=>9)); ?>

	<?php echo $form->textFieldRow($model,'mobile_number',array('class'=>'span5','maxlength'=>11)); ?>

                        </div>   
  </div>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
                        'icon'=>'ok white',  
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
              <?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'reset',
                        'icon'=>'remove',  
			'label'=>'Reset',
		)); ?>
	</div>
</fieldset>

<?php $this->endWidget(); ?>

</div>
