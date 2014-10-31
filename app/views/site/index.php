<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>
<?php
Yii::app()->clientScript->registerScript(
    'successFlash',
    '$("#flash").animate({opacity: 1.0}, 6000).fadeOut("slow");',
    CClientScript::POS_READY
);
?>
<div class="row-fluid">
        <div class="span4" id="btindex-side" style="position: relative">
            <img src="/pmp/images/fuelpump1.png"  class="hidden-phone" style="position: absolute; z-index: -1; top: -40px; left: 23%"  />
        <span style="font-size: 30px; font-weight: bold">Your Station Management</span><br>
            <span>within your convenience... </span><br>
            <div  class="visible-desktop" style="padding-top: 50px;">

            <?php
            if(Yii::app()->user->isGuest){

                echo TbHtml::button('Sign in', array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'size' => TbHtml::BUTTON_SIZE_LARGE, 'icon'=>'icon-user',
                    'data-toggle'=>'modal', 'data-target'=>'#signIn'));

                echo ' Or ';

                echo TbHtml::button('Register', array('color' => TbHtml::BUTTON_COLOR_DANGER, 'size' => TbHtml::BUTTON_SIZE_LARGE, 'icon'=>'align-left',
                    'url'=> array('//user/create')));
            }
                else{

                    echo TbHtml::linkButton('Learn More...', array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'size' => TbHtml::BUTTON_SIZE_LARGE, 'icon'=>'book',
                        'url'=> array('/site/page', 'view'=>'learn')));
                }
                ?>
            </div>
        </div>
        <div class="span8" id="btslider">
            <?php
            $this->widget('bootstrap.widgets.TbCarousel', array(
                'items'=>array(
                    array('image'=>Yii::app()->request->baseUrl.'/images/pic1.jpg',
                        'caption'=>'Avail yourself an automated computation of pump readings.'),
                    array(
                        'image'=>Yii::app()->request->baseUrl.'/images/pic2.jpg',
                        'caption'=>'Worry less about how vital information are kept.'),
                    array(
                        'image'=>Yii::app()->request->baseUrl.'/images/pic3.jpg',
                        'caption'=>'Know instantly how much comes to you as cash.'),

                ),
            ));
            ?>
        </div>
</div>

<?php  if(Yii::app()->user->isGuest){
    $this->widget('bootstrap.widgets.TbModal', array(
        'id' => 'signIn',
        'header' => 'Pump Manager Pro',
        'content' => $this->renderPartial('loginForm',array('model'=>$model),true),
        'footer' => array(
        ),
    ));
    }
?>

<?php if(Yii::app()->user->hasFlash('success')):?>
    <div id="flash" style="position: absolute; top: 47px; left: 10px;">
        <?php $this->widget('bootstrap.widgets.TbAlert'); ?>
    </div>
<?php endif; ?>

<script type="text/javascript">

    <?php if(isset($_POST['LoginForm'])) { ?>

    $(function() {
        $('#signIn').modal('show');
    });

        <?php } ?>

</script>

