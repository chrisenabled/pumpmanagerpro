<?php
/* @var $this UserController */
/* @var $model User*/

$this->pageTitle=Yii::app()->name . ' - Create Account';

?>

<div class="span5 offset1">
    <h2 style="color: #b22222">Bring Your Station Online!</h2>
    <br>
    <?php
    $this->widget('bootstrap.widgets.TbCarousel', array(
        'items'=>array(
            array(
                'image'=>Yii::app()->request->baseUrl.'/images/earth.png'),

            array(
                'image'=>Yii::app()->request->baseUrl.'/images/control.png'),
            array(
                'image'=>Yii::app()->request->baseUrl.'/images/calculator.png'),
            array(
                'image'=>Yii::app()->request->baseUrl.'/images/coins.png'),
            array(
                'image'=>Yii::app()->request->baseUrl.'/images/people.png'),

            array(
                'image'=>Yii::app()->request->baseUrl.'/images/info.png'),

        ),
        'displayPrevAndNext'=>false
    ));
    ?>
    <img src="/pmp/images/nigeria.png" style="margin-bottom: 20%">
    <img src="/pmp/images/boost.png">


</div>

<div class="span4 offset1" style="padding-top: 60px">
    <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
