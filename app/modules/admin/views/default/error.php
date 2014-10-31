<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
?>
<div class="row-fluid">
    <div class="span3"></div>
    <div class="span6" style="text-align: center">
        <h2>Oops! <?php echo CHtml::image(Yii::app()->request->baseUrl.'/images/sorry.png') ?>something went wrong!!!</h2>
        <div class="error bterror writing btboxradius">
        <?php echo CHtml::encode($message); ?>
        </div>
    </div>
    <div class="span3"></div>
</div>