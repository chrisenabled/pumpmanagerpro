<?php
/* @var $this DefaultController */
$this->pageTitle=Yii::app()->name . ' - Admin';

?>

<div style="position: fixed; top: 10px; left: 250px; z-index: 6">
    <?php
    $this->widget('bootstrap.widgets.TbAlert', array('id'=>'alert',
        'block'=>true, // display a larger alert block?
        'fade'=>true, // use transitions?
        'closeText'=>'×', // close link text - if set to false, no close link is displayed
        'alerts'=>array( // configurations per alert type
            'info'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'), // success, info, warning, error or danger
        ),
    ));
    ?>
</div>
<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'verticalForm',
    'htmlOptions'=>array('class'=>'well btglassy'),
));

Yii::app()->clientScript->registerScript('setFocus', '$(".username").focus();');

?>
<span class="pull-right badge badge-info">Sign In</span><br class="clear">
<?php echo $form->textFieldControlGroup($model, 'username', array('class'=>'span12 username')); ?>
<?php echo $form->passwordFieldControlGroup($model, 'password', array('class'=>'span12')); ?>
<?php echo TbHtml::formActions(array(
    TbHtml::submitButton('Sign In', array('color' => TbHtml::BUTTON_COLOR_PRIMARY)),
    TbHtml::resetButton('Reset'),
)); ?>
<?php $this->endWidget(); ?>
