<?php
$cs = Yii::app()->clientScript;
$cs->registerScriptFile(
    Yii::app()->baseUrl . '/js/mask.js',
    CClientScript::POS_END
);
$cs->registerScript(null,'$("#focus").focus();');
?>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'horizontalForm',
    'htmlOptions'=>array('class'=>'well btglassy'),
));
?>
    <span class="pull-right badge badge-warning">Subscribe Customer</span><br/><br/>
<?php echo $form->textFieldControlGroup($model, 'customer', array('class'=>'span6', 'id'=>'focus')); ?>
<?php echo $form->textFieldControlGroup($model, 'amountPaid', array('class'=>'span6 numberFormat', 'prepend'=>'₦')); ?>
<?php echo $form->passwordFieldControlGroup($model, 'adminPassword', array('class'=>'span6')); ?>

<?php echo TbHtml::formActions(array(
    TbHtml::submitButton('Subscribe', array('color' => TbHtml::BUTTON_COLOR_SUCCESS)),
    TbHtml::buttonGroup(array(
        array('label'=>'Tasks', 'url'=>array('index'), 'type'=>'primary'),
        array('label'=>'Logout','url'=>array('default/logout'),'type' => 'danger','icon'=>'icon-off'),
    ))
)); ?>
<?php $this->endWidget(); ?>