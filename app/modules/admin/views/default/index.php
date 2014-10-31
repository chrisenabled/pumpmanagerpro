<?php
/* @var $this DefaultController */
$this->pageTitle=Yii::app()->name . ' - Admin';

?>
<div style="margin-bottom: 10px;">
    <img src='/pmp/images/admin.png'  >
</div>
<div style="position: fixed; top: 10px; left: 250px; z-index: 6">
    <?php
    $this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>true, // display a larger alert block?
        'fade'=>true, // use transitions?
        'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
        'alerts'=>array( // configurations per alert type
            'info'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
        ),
    ));
    ?>
</div>
<?php if(Yii::app()->user->isGuest): ?>
<div class="well">
    <?php echo TbHtml::linkButton('Login', array('color' => TbHtml::BUTTON_COLOR_PRIMARY,'url'=> array('default/login'))); ?>
</div>
<?php endif; ?>
<?php if(!Yii::app()->user->isGuest): ?>
    <div class="well">
        <span>
                <?php echo TbHtml::linkButton('Actions', array('color' => TbHtml::BUTTON_COLOR_SUCCESS,'url'=> array('admin/index'))); ?>
        </span>
        <span class="pull-right">
                <?php echo TbHtml::linkButton('Logout', array('color' => TbHtml::BUTTON_COLOR_DANGER,'url'=> array('default/logout'),'icon'=>'icon-off')); ?>
        </span>
    <div>
<?php endif; ?>
