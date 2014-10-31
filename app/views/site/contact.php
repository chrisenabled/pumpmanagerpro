<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */
$this->pageTitle=Yii::app()->name . ' - Contact Us';

?>
<?php
Yii::app()->clientScript->registerScript(
    'emailed',
    '$("#alert").animate({opacity: 1.0}, 6000).fadeOut("slow");',
    CClientScript::POS_READY
);
?>

<div class="span6 offset1">
    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id'=>'verticalForm',
        'htmlOptions'=>array(),
    )); ?>

    <?php echo $form->textFieldControlGroup($model, 'name', array()); ?>
    <?php echo $form->textFieldControlGroup($model, 'email', array()); ?>
    <?php echo $form->textFieldControlGroup($model, 'subject', array()); ?>
    <?php echo $form->textAreaControlGroup($model, 'body', array('class'=>'span8', 'rows'=>5)); ?>
    <?php if(CCaptcha::checkRequirements()): ?>
        <?php $this->widget('CCaptcha'); ?>
        <?php echo $form->textFieldControlGroup($model,'verifyCode', array('help'=>'Please enter the letters as they are shown in the image above.
        Letters are not case-sensitive.')); ?>
    <?php endif; ?>
    <div class="form-actions">
        <?php echo TbHtml::submitButton('Send', array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'onclick'=>'js: $("#boot").show();'));?>
    </div>

    <?php $this->endWidget(); ?>
</div>

    <div id="boot" class="boot btboxradius btglassy">Please Wait...</div>

<div class="span3">
    <h1 style="color: #b22222">Contact Us</h1>
    We at Pump Manager Pro strive to bring our customers the best of our service. If you have any questions, queries,
    or business related enquiries, please feel free to send us an email by filling out the form to your left.<br>

    <div class="media">
        <img class="media-object pull-left" src= <?php echo Yii::app()->request->baseUrl.'/images/search.png' ?>  >
        <div class="media-body">
            <h4 class="media-heading">Search Records</h4>
            You can search through tables quickly by providing search parameters on any record table. You can even
            advance your search to create more streamlined data pool.
            <?php echo CHtml::link('Learn how',array('site/page', 'view'=>'learn'),array('class'=>'redButton btA')); ?>

        </div>
    </div>
</div>
    <div class="span2"></div>

<?php if(Yii::app()->user->hasFlash('info')):?>
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
<?php endif; ?>
