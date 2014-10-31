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
                    <li class="">
                        <?php echo CHtml::link('Learn', array('//site/page', 'view'=>'learn')); ?>
                    </li>
                    <li class="<?php echo $this->pageTitle == Yii::app()->name . ' - Contact Us'? 'active':'' ?>">
                        <?php echo CHtml::link('Contact', array('//site/contact')); ?>
                    </li>
                    <li class="">
                        <?php echo CHtml::link('Help', array('//site/page', 'view'=>'learn', '#'=>'help')); ?>
                    </li>
                    <li class="">
                        <?php echo Yii::app()->user->isGuest? '' : CHtml::link('Logout ('.Yii::app()->user->name.')', array('//site/logout')) ; ?>
                    </li>
                    <?php echo
                    Yii::app()->user->isGuest? '' :
                        '<span class="navbar-text pull-left">'.
                        CHtml::link(CHtml::image('/pmp/images/inbox.png'),array('//message/admin')).
                        '</span>';
                    ?>
                </ul>
            </div>
            <div class="navbar-text pull-right nav-collapse collapse" style = "position:relative;">
                <b class="label label-info" style="font-size: 30; background-color: #143491">P</b>
                <b class="label label-important" style="font-size: 30; background-color: #871239">M</b>
                <b class="label label-success" style="font-size: 30; background-color: #007100">P</b>
                <img  class="btlogo" src="/pmp/images/logo.png" >
            </div>
        </div>
    </div>
</div>
<div class="navbar navbar-static-top">
    <div class="navbar-inner" style="padding: 20px;">
        <div class="container">
            <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".mainav">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <div class="brand hidden-desktop">PMP</div>
            <div class="navbar-text pull-left visible-desktop" style="padding-right: 50px;">
                <!-- webim button --><a href="/pmp/webim/client.php?locale=en&amp;style=default" target="_blank" onclick="if(navigator.userAgent.toLowerCase().indexOf('opera') != -1 &amp;&amp; window.event.preventDefault) window.event.preventDefault();this.newWindow = window.open('/pmp/webim/client.php?locale=en&amp;style=default&amp;url='+escape(document.location.href)+'&amp;referrer='+escape(document.referrer), 'webim', 'toolbar=0,scrollbars=0,location=0,status=1,menubar=0,width=640,height=480,resizable=1');this.newWindow.focus();this.newWindow.opener=window;return false;"><img src="/pmp/webim/b.php?i=mblue&amp;lang=en" border="0" width="177" height="61" alt=""/></a><!-- / webim button -->
            </div>
            <div class="navbar-text pull-left  nav-collapse collapse mainav" id="btheader3">

                <ul class="nav">
                    <li class="">
                        <?php echo CHtml::link('<i class="icon-home"></i>Home',array('site/index'),array('class'=>'btA')); ?>
                    </li>
                    <li class="">
                        <?php echo CHtml::link('Learn',array('site/page','view'=>'learn'),array('class'=>'btA',
                            'style'=> $this->pageTitle===Yii::app()->name . ' - Learn' ? 'color: #b22222' : ''
                        )); ?>
                    </li>
                    <li class="">
                        <?php echo CHtml::link('FAQ',array('site/page','view'=>'FAQ'),array('class'=>'btA',
                            'style'=> $this->pageTitle===Yii::app()->name . ' - FAQ' ? 'color: #b22222' : ''
                        )); ?>
                    </li>
                    <?php if(Yii::app()->user->isGuest):  ?>
                        <li class="">
                            <?php echo CHtml::link('Sign in',array('site/login'),array('class'=>'btA')); ?>
                        </li>
                        <li class="">
                            <?php echo CHtml::link('Create Account',array('//user/create'),array('class'=>'btA')); ?>
                        </li>
                    <?php endif; ?>
                    <?php if(!Yii::app()->user->isGuest):  ?>
                        <li class="">
                            <?php echo CHtml::link('Logout ('.Yii::app()->user->name.')',array('site/logout'),array('class'=>'btA')); ?>
                        </li>
                        <li class="">
                            <?php echo CHtml::link(CHtml::image('/pmp/images/inbox.png'),array('message/admin')); ?>
                        </li>
                    <?php endif; ?>

                </ul>
                <?php Yii::app()->user->isGuest? '' :
                    $this->widget('bootstrap.widgets.TbButton',array(
                        'label'=>'Panel',
                        'icon'=>'icon-briefcase',
                        'buttonType'=>'link',
                        'url'=> array('//user/view'),

                    ));
                ?>
                <p class="hidden-desktop">
                    <!-- webim button --><a href="/pmp/webim/client.php?locale=en&amp;style=default" target="_blank" onclick="if(navigator.userAgent.toLowerCase().indexOf('opera') != -1 &amp;&amp; window.event.preventDefault) window.event.preventDefault();this.newWindow = window.open('/pmp/webim/client.php?locale=en&amp;style=default&amp;url='+escape(document.location.href)+'&amp;referrer='+escape(document.referrer), 'webim', 'toolbar=0,scrollbars=0,location=0,status=1,menubar=0,width=640,height=480,resizable=1');this.newWindow.focus();this.newWindow.opener=window;return false;"><img src="/pmp/webim/b.php?i=mblue&amp;lang=en" border="0" width="177" height="61" alt=""/></a><!-- / webim button -->
                </p>
            </div>

            <span class="navbar-text pull-right nav-collapse collapse">
                    <img  class="" src="/pmp/images/logo.png" >
                    <b class="label label-info" style="font-size: 30; background-color: #143491">P</b>
                    <b class="label label-important" style="font-size: 30; background-color: #871239">M</b>
                    <b class="label label-success" style="font-size: 30; background-color: #007100">P</b>
                </span>
        </div>
    </div>
</div>

<div>
    <?php echo $content ?>
</div>
<div class="hero-unit" id="btlearnhero">
    <h1 id="help">Need Help?
        <img src='/pmp/images/phone.png'  >
        <img src='/pmp/images/mail.png'  >
    </h1>
    <p>
        If you need help, you can chat with our operators on our live support. You can also <?php echo CHtml::link('Contact Us',array('site/contact'),array('style'=>'color:yellow;')); ?>
        for specific enquiries. In case you need our representative to come and set up your online station for you
        (charges applicable), you can call us on our help line at <span class="badge badge-success" id="helpline">+2347016030401</span>.
        Please, note that our help line is specifically for making arrangements for meeting with our representatives and for
        critical application issues that may have occurred. Any other enquiries or questions should be made known to us
        via our live chat or via email. We @PumpManagerPro value you our customer and answer promptly to your requests. Let us help you.
    </p>
</div>
<div class="row-fluid">
    <div class="span12 btfooter3">
            <?php echo CHtml::link('About',array('//site/page', 'view'=>'about')); ?>&emsp;.&emsp;
            <?php echo CHtml::link('Terms & Policy',array('site/legal', 'active'=>'#terms')); ?>&emsp;.&emsp;
            <?php echo CHtml::link('Contact',array('site/contact')); ?>
        <span class="pull-left">&copy;&nbsp;www.PumpManagerPro.com</span>

    </div>
</div>

</body>

</html>





