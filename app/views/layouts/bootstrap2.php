<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="en" />
    <meta name="ROBOTS" content="index, follow, archive" />
    <meta name="description" content="Pump Manager Pro is your no.1 online filling station management client">
    <meta name="keywords" content="pmp, PMP, pumpmanagerpro, filling station, pump manager pro, pumpmanagerpro.com, pms, ago, dpk,custom audit">
    <meta http-equiv="imagetoolbar" content="no" />
    <link rel="shortcut icon" href="/pmp/images/favicon.ico">
    <link rel="stylesheet" type="text/css" href="/pmp/css/bt.css" />
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <?php Yii::app()->bootstrap->register(); ?>
    <?php if(!Yii::app()->user->isGuest){
         Yii::app()->user->model->resetSubscription();
    } ?>

</head>

<body>
    <div class="container-fluid" id="btcontainer" style="background-color: #fffaf0;">

        <div class="navbar navbar-static-top">
            <div class="navbar-inner">
                <div class="container">
                    <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".mainave">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <div class="">
                        <a class="brand label-important hidden-phone" style="color: white; text-shadow: none" href="#">Pump Manager Pro</a>
                        <a class="brand visible-phone" style="color: #800000;" href="#">
                            <b class="label label-info" style="font-size: 30; background-color: #143491">P</b>
                            <b class="label label-important" style="font-size: 30; background-color: #871239">M</b>
                            <b class="label label-success" style="font-size: 30; background-color: #007100">P</b>
                        </a>
                    </div>
                    <div class="nav-collapse collapse mainave">
                        <ul class="nav">
                            <li class="">
                                <?php echo CHtml::link('<i class="icon-home"></i> Home', array('//site/index')); ?>
                            </li>
                            <li class="<?php echo $this->pageTitle == Yii::app()->name . ' - About'? 'active':'' ?>" >
                                <?php echo CHtml::link('About', array('//site/page', 'view'=>'about')); ?>
                            </li>
                            <li class="<?php echo $this->pageTitle == Yii::app()->name . ' - Learn'? 'active':'' ?>">
                                <?php echo CHtml::link('Learn', array('//site/page', 'view'=>'learn')); ?>
                            </li>
                            <li class="<?php echo $this->pageTitle == Yii::app()->name . ' - Contact Us'? 'active':'' ?>">
                                <?php echo CHtml::link('Contact', array('//site/contact')); ?>
                            </li>
                            <li class="">
                                <?php echo CHtml::link('Help', array('//site/page', 'view'=>'learn', '#'=>'help')); ?>
                            </li>
                            <li class="hidden-desktop">
                                <?php echo Yii::app()->user->isGuest? CHtml::link('Login', array('login')) : '' ; ?>
                            </li>
                            <li class="hidden-desktop">
                                <?php echo Yii::app()->user->isGuest? CHtml::link('Register', array('//user/create')) : '' ; ?>
                            </li>
                            <li class="hidden-desktop">
                                <?php echo Yii::app()->user->isGuest? '' : CHtml::link('Logout ('.Yii::app()->user->name.')', array('//site/logout')) ; ?>
                            </li>
                            <?php echo
                            Yii::app()->user->isGuest? '' :
                                '<span class="navbar-text pull-left">'.
                                CHtml::link(CHtml::image('/pmp/images/inbox.png'),array('//message/admin')).
                                '</span>';

                            ?>
                            &emsp;
                            <?php Yii::app()->user->isGuest? '' :
                                $this->widget('bootstrap.widgets.TbButton',array(
                                    'label'=>'Panel',
                                    'icon'=>'icon-briefcase',
                                    'type'=>'success',
                                    'buttonType'=>'link',
                                    'url'=> array('//user/view'),

                                ));
                            ?>
                        </ul>
                    </div>
                    <div class="navbar-text pull-right nav-collapse collapse" style = "position:relative;">
                        <ul class="nav" style="background-color: #f3dbba">
                            <li class="<?php echo $this->pageTitle == Yii::app()->name . ' - Login'? 'active':'' ?>">
                                <?php echo Yii::app()->user->isGuest? CHtml::link('Login', array('//site/login')) : '' ; ?></li>
                            <li class="<?php echo $this->pageTitle == Yii::app()->name . ' - Create Account'? 'active':'' ?>">
                                <?php echo Yii::app()->user->isGuest? CHtml::link('Register', array('user/create')) : '' ; ?></li>
                            <li><?php echo Yii::app()->user->isGuest? '' : CHtml::link('Logout ('.Yii::app()->user->name.')', array('logout')); ?></li>
                        </ul>
                        <img  class="" src="/pmp/images/logo.png" >
                        <b class="label label-info" style="font-size: 30; background-color: #143491">P</b>
                        <b class="label label-important" style="font-size: 30; background-color: #871239">M</b>
                        <b class="label label-success" style="font-size: 30; background-color: #007100">P</b>
                    </div>
                </div>
            </div>
        </div>


        <div class="row-fluid" style="height: 20px;"></div>
        <div class="row-fluid">
            <?php echo $content; ?>
        </div>

        <div class="row-fluid">
            <div class="span12 btfooter2" >
                <?php echo CHtml::link('Terms of Service',array('site/legal','active'=>'#terms')); ?>&emsp;.&emsp;
                <?php echo CHtml::link('Privacy Policy',array('site/legal', 'active'=>'#privacy')); ?>&emsp;.&emsp;
                <?php echo CHtml::link('Help',array('site/page','view'=>'learn', '#'=>'help')); ?>&emsp;.&emsp;
                <?php echo CHtml::link('FAQ',array('site/page','view'=>'FAQ')); ?>&emsp;.&emsp;
                <?php echo CHtml::link('Contact Us',array('site/contact')); ?>
                <span class="muted pull-right">&copy;&nbsp;<?php echo date('Y'); ?>&nbsp;www.pumpmanagerpro.com</span>
            </div>
        </div>
    </div>

</body>

</html>