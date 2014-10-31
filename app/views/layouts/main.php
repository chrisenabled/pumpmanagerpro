<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <?php if(!Yii::app()->user->isGuest){
       Yii::app()->user->model->resetSubscription();
    } ?>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
    <meta name="ROBOTS" content="noindex, nofollow, noarchive" />
    <meta http-equiv="imagetoolbar" content="no" />
    <link rel="shortcut icon" href="/pmp/images/favicon.ico">
    <link rel="stylesheet" type="text/css" href="/pmp/css/main.css" />
    <link rel="stylesheet" type="text/css" href="/pmp/css/pmpsprites.css" />

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <?php Yii::app()->bootstrap->registerCoreCss(); ?>
    <?php Yii::app()->bootstrap->registerYiistrapCss(); ?>
    <?php Yii::app()->bootstrap->registerAllScripts(); ?>

</head>

<body>
<div id="header" class="container">
    <div id="topNav">
        <ul>
            <li><?php echo CHtml::link('<img src="/pmp/images/panel.png"> Panel',array('user/view'),array('id'=>'panel')); ?></li>
            <li class="chat">
                    <!-- webim button --><a href="/pmp/webim/client.php?locale=en&amp;style=default" target="_blank" onclick="if(navigator.userAgent.toLowerCase().indexOf('opera') != -1 &amp;&amp; window.event.preventDefault) window.event.preventDefault();this.newWindow = window.open('/pmp/webim/client.php?locale=en&amp;style=default&amp;url='+escape(document.location.href)+'&amp;referrer='+escape(document.referrer), 'webim', 'toolbar=0,scrollbars=0,location=0,status=1,menubar=0,width=640,height=480,resizable=1');this.newWindow.focus();this.newWindow.opener=window;return false;"><img src="/pmp/webim/b.php?i=simple&amp;lang=en" border="0" width="177" height="61" alt=""/>&nbsp;Chat</a><!-- / webim button -->
            </li>
            <li><?php echo CHtml::link('<img src="/pmp/images/settings.png"> Settings',array('site/page', 'view'=>'FAQ'),array('class'=>'admin')); ?></li>
            <li><?php echo CHtml::link('<img src="/pmp/images/logout.png"> Logout',array('site/index')); ?></li>
        </ul>
    </div>
    <div class="shadow-hr"></div>
</div>
<div id="subscription-notification">
    <?php if(Yii::app()->user->subscription >0 && Yii::app()->user->subscription <= 5){ ?>
        <span class="sn-orange">Expires in <?php echo (Yii::app()->user->subscription) <= 1 ?  ceil(Yii::app()->user->subscription * 24). ' hr(s).' :
                ceil(Yii::app()->user->subscription).' day(s).'  ?>
            </span>
    <?php } elseif(Yii::app()->user->subscription <= 0){ ?>
        <span class="sn-red">Subscription has expired.</span>
    <?php } ?>
</div>

<div style="height: 100px;"></div>

<div>
    <?php echo $content; ?>
</div>

<div class="container" id="footer">
    <div class="shadow-hr"></div>
    <div class="row-fluid">
        <div class="span2"></div>
        <div class="span8">Developed by: <img src="/pmp/images/est.png" alt="" width="100px;"/></div>
        <div class="span2"></div>
    </div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function(){
        var target = $("#subscription-notification").offset().top,
            timeout = null;

        $(window).scroll(function () {
            if (!timeout) {
                timeout = setTimeout(function () {
                    clearTimeout(timeout);
                    timeout = null;
                    if ($(window).scrollTop() >= target) {
                        $("#subscription-notification").hide('fast');
                    }
                    else{$("#subscription-notification").show('slow')}
                }, 250);
            }
        });
    });
</script>

</body>
</html>
