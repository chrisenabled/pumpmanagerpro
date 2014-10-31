<?php
Yii::app()->clientScript->registerScript('worldNews', "
$(document).ready(function() {
        ajaxNews();
    });
    setInterval(ajaxNews ,30000);

");
if(!Yii::app()->user->isGuest){
    Yii::app()->user->model->resetSubscription();
}
Yii::app()->cache->flush();
if(Yii::app()->user->hasState('operationUrl')){
    Yii::app()->user->setState('operationUrl', null);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="en" />
    <meta name="ROBOTS" content="index, follow, archive" />
    <meta name="description" content="Pump Manager Pro is your no.1 online filling station management client">
    <meta name="keywords" content="pmp, PMP, pumpmanagerpro, PumpManagerPro, pump manager pro, pumpmanagerpro.com, station, management,">
    <meta http-equiv="imagetoolbar" content="no" />
    <link rel="shortcut icon" href="/pmp/images/favicon.ico">
    <link rel="stylesheet" type="text/css" href="/pmp/css/bt.css" />
    <link rel="stylesheet" type="text/css" href="/pmp/css/sprite.css" />
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <?php Yii::app()->bootstrap->register(); ?>
</head>

<body class="frontpage">
<div class="navbar navbar-inverse navbar-static-top">
    <div class="navbar-inner">
        <div class="container">
            <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".mainav">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <div class="">
                <a class="brand label-important hidden-phone" style="color: white;" href="#">Pump Manager Pro</a>
                <a class="brand visible-phone" style="color: white;" href="#">
                    <b class="label label-info" style="font-size: 30; background-color: #143491">P</b>
                    <b class="label label-important" style="font-size: 30; background-color: #871239">M</b>
                    <b class="label label-success" style="font-size: 30; background-color: #007100">P</b>
                </a>
            </div>
            <div class="nav-collapse collapse mainav">
                <ul class="nav">
                    <li class="active">
                        <?php echo CHtml::link('<i class="icon-home icon-white"></i>', array('index')); ?>
                    </li>
                    <li class="">
                        <?php echo CHtml::link('About', array('page', 'view'=>'about')); ?>
                    </li>
                    <li class="">
                        <?php echo CHtml::link('Learn', array('page', 'view'=>'learn')); ?>
                    </li>
                    <li class="">
                        <?php echo CHtml::link('FAQ', array('page', 'view'=>'FAQ')); ?>
                    </li>
                    <li class="hidden-desktop">
                        <?php echo Yii::app()->user->isGuest? CHtml::link('Login', array('login')) : '' ; ?>
                    </li>
                    <li class="hidden-desktop">
                        <?php echo Yii::app()->user->isGuest? CHtml::link('Register', array('//user/create')) : '' ; ?>
                    </li>
                    <li class="hidden-desktop">
                        <?php echo Yii::app()->user->isGuest? '' : CHtml::link('Logout ('.Yii::app()->user->name.')', array('logout')) ; ?>
                    </li>
                    <li class="">&emsp;&emsp;</li>

                    &emsp;&emsp;
                    <?php echo Yii::app()->user->isGuest? '' :  TbHtml::linkButton('Panel', array('color' => TbHtml::BUTTON_COLOR_SUCCESS, 'icon'=>'icon-briefcase',
                        'url'=> array('//user/view'))); ?>
                </ul>
                <p class="hidden-desktop">
                    <!-- webim button --><a href="/pmp/webim/client.php?locale=en&amp;style=default" target="_blank" onclick="if(navigator.userAgent.toLowerCase().indexOf('opera') != -1 &amp;&amp; window.event.preventDefault) window.event.preventDefault();this.newWindow = window.open('/pmp/webim/client.php?locale=en&amp;style=default&amp;url='+escape(document.location.href)+'&amp;referrer='+escape(document.referrer), 'webim', 'toolbar=0,scrollbars=0,location=0,status=1,menubar=0,width=640,height=480,resizable=1');this.newWindow.focus();this.newWindow.opener=window;return false;"><img src="/pmp/webim/b.php?i=simple&amp;lang=en" border="0" width="177" height="61" alt=""/></a><!-- / webim button -->
                </p>

            </div>

            <div class="navbar-text pull-right nav-collapse collapse" style = "position:relative;">
                <ul class="nav" style="background-color: #363636">
                    <li><?php echo Yii::app()->user->isGuest? '' : CHtml::link('Logout ('.Yii::app()->user->name.')', array('logout')); ?></li>
                </ul>
                <img  class="" src="/pmp/images/logo.png" >
                <b class="label label-info" style="background-color: #143491">P</b>
                <b class="label label-important" style="background-color: #871239">M</b>
                <b class="label label-success" style="background-color: #007100">P</b>
            </div>
        </div>
    </div>
</div>
<div class="navbar navbar-static-top">
    <div class=" btquote">
        <div class="row-fluid">
            <div class="span12" id="quote">
                <blockquote class="pull-right">
                    <?php $quote = Quote::Model()->findByPk(mt_rand(1, 221)); ?>
                    <p style="text-shadow: 0px 1px 1px #dddddd;">
                        <?php echo $quote->quote; ?>
                    </p>
                    <small style="color: #8b0000"><?php echo $quote->author ?><cite>
                            <a href="http://www.brainyquote.com/" target="_blank" style="text-decoration: none; color: #d03802">[Brainy Quotes]</a>
                        </cite></small>
                </blockquote>
            </div>
        </div>
    </div>
</div>

<div class="row-fluid" style="margin-top: 20px;">
    <?php  echo $content ?>
</div>

<div style="padding: 0px 10px; ">
<div class="row-fluid">
    <div class=" btboxradius btnews" id="newsPanel">
        <div id="news">
            Searching for news......
            <noscript>
                <span style="color: #b22222">Javascript is disabled or not supported by your browser. Enable javascript or use a browser that supports javascript
                so that this website can function properly.</span>
            </noscript>
        </div>
    </div>
</div>
</div>
<div class="row-fluid btfooter visible-desktop">

    <div class="span12" style="position: relative">
        <div style="float: left">&emsp;<img src="/pmp/images/est.png" alt="enabled systems technology" style="height: 40px">&emsp;&emsp;
        </div>
        <div style="float: left;">
        &emsp;&emsp;<i class="icon-share-alt"></i><?php echo CHtml::link('About',array('//site/page', 'view'=>'about')); ?>&emsp;.&emsp;
        <i class="icon-share-alt"></i><?php echo CHtml::link('Contact',array('site/contact')); ?>&emsp;.&emsp;
        <i class="icon-share-alt"></i><?php echo CHtml::link('Terms of Service',array('site/legal', 'active'=>'#terms')); ?>&emsp;.&emsp;
        <i class="icon-share-alt"></i><?php echo CHtml::link('Privacy Policy',array('site/legal' ,  'active'=> '#privacy')); ?>
        &emsp;.&emsp;&copy; <?php echo date('Y'); ?>
        Pump Manager Pro. All Rights Reserved.</div>
        <div style="position: absolute; right: 0;">
            <!-- webim button --><a href="/pmp/webim/client.php?locale=en&amp;style=default" target="_blank" onclick="if(navigator.userAgent.toLowerCase().indexOf('opera') != -1 &amp;&amp; window.event.preventDefault) window.event.preventDefault();this.newWindow = window.open('/pmp/webim/client.php?locale=en&amp;style=default&amp;url='+escape(document.location.href)+'&amp;referrer='+escape(document.referrer), 'webim', 'toolbar=0,scrollbars=0,location=0,status=1,menubar=0,width=640,height=480,resizable=1');this.newWindow.focus();this.newWindow.opener=window;return false;"><img src="/pmp/webim/b.php?i=mblue&amp;lang=en" border="0" width="177" height="61" alt=""/></a><!-- / webim button -->
        </div>
    </div>
</div>
<div class="row-fluid hidden-desktop">
    <div class="span12 btglassy btboxradius">
            <?php echo CHtml::link('About',array('site/page', 'view'=>'about'));?>&nbsp;|&nbsp;
            <?php echo CHtml::link('Contact',array('site/contact')); ?>&nbsp;|&nbsp;
            <?php echo CHtml::link('Terms',array('site/legal', 'active'=>'#terms'));?>&nbsp;|&nbsp;
            <?php echo CHtml::link('Privacy',array('site/legal' , 'active'=>'#privacy'));?>&nbsp;|&nbsp;
        <span>&copy;&nbsp;www.PumpManagerPro.com</span>&emsp;All Rights Reserved.
    </div>
</div>

<script type="text/javascript">
    <!--

    function ajaxNews(){
       var myUrl = <?php echo "'". Yii::app()->getBaseUrl() . "/index.php/site/news'"  ?>;
        var myRand = parseInt(Math.random()* new Date().getTime());
        var modUrl = myUrl+"?rand="+myRand;
        $.ajax({
            url: modUrl,
            type: 'GET',
            dataType: 'JSON',
            cache: false,
            async: true,
            success: function(res){
                var count = Math.floor((Math.random()*20)+1);

                $.each(res.articles, function(i, item){
                    if(i == count ){
                        if($("#news").html() !== '<span style="color: #8b0000">World News:</span>&emsp;' + item.summary + '&emsp;' +
                            '<a href="' + item.source_url + '" target="_blank">Visit the News</a>' && $("#news").html().replace(/ /g,'') !== ''){

                            $("#news").fadeOut();

                            $("#news").html('<span style="color: #8b0000">World News:</span>&emsp;' + item.summary + '&emsp;' +
                                '<a href="' + item.source_url + '" target="_blank">Visit the News</a> ' + count
                            );
                        }
                    }

                });
                $("#news").fadeIn();
            },
            error: function(jqXHR, textStatus){
                $("#news").html('<strong style="color: #873514;"> Oops!!! There seems to be a glitch!</strong> '
                     + ': ' + textStatus + '  >>>>>>  ' + jqXHR.statusText );
            }
        });
    }
     -->
</script>



</body>

</html>