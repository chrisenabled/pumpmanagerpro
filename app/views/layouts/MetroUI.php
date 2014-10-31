<?php
    $cs = Yii::app()->clientScript;
    $cs->registerScriptFile(
        Yii::app()->baseUrl . '/MetroJs/MetroJs.min.js',
        CClientScript::POS_END
    );
    $cs->registerScriptFile(
        Yii::app()->baseUrl . '/js/tileJs.js',
        CClientScript::POS_END
    );

    $cs->registerScriptFile(
        Yii::app()->baseUrl . '/js/metroUI.js',
        CClientScript::POS_END
    );
    $cs->registerScriptFile(
        Yii::app()->baseUrl . '/ScrollerJs/jquery.mCustomScrollbar.concat.min.js',
        CClientScript::POS_END
    );

     if(!Yii::app()->user->isGuest){
        Yii::app()->user->model->resetSubscription();
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="en" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/pmp/images/favicon.ico">
    <link rel="stylesheet" type="text/css" href="/pmp/MetroJs/MetroJs.min.css" />
    <link rel="stylesheet" type="text/css" href="/pmp/css/metroUI.css" />
    <link rel="stylesheet" type="text/css" href="/pmp/ScrollerJs/jquery.mCustomScrollbar.css" />
    <style>
        .theww{height:0; border:none; border-bottom:1px solid rgba(255,255,255,0.13); border-top:1px solid rgb(35, 35, 35); margin: 0; padding: 0; clear:both; }
    </style>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <?php Yii::app()->bootstrap->register(); ?>

</head>

<body class="desktop home dark">

<header style="padding-bottom: 30px">
    <table style="width: 96%">
        <tr>
            <td><span class="site-title">CONOIL FILLING STATION O1</span></td>
            <td>
                <span style="float: right">
                <img  class="" src="/pmp/images/logo.png" >
                <b class="label label-info" style="font-size: 30; background-color: #143491">P</b>
                <b class="label label-important" style="font-size: 30; background-color: #871239">M</b>
                <b class="label label-success" style="font-size: 30; background-color: #007100">P</b></span>
            </td>
        </tr>
    </table>
    <div class="">

    </div>
    <hr class="theww"/>
</header>

<section>
    <div>
        <?php echo $content; ?>
    </div>
</section>

<footer class="appbar" style="height: 70px;">
    <nav class="clear">
        <ul id="menu" class="appbar-buttons">
            <li>
                <a href="/" class="home"><img src="/pmp/MetroJs/images/1pixel.gif" alt="home"></a>
                <span class="charm-title">Home</span>
            </li>
            <li>
                <a href="/about" class="about"><img src="/pmp/MetroJs/images/1pixel.gif" alt="about"></a>
                <span class="charm-title">About</span>
            </li>
            <li>
                <a href="/" class="twitter"><img src="/pmp/MetroJs/images/1pixel.gif" alt="twitter"></a>
                <span class="charm-title">Twitter</span>
            </li>
        </ul>
    </nav>
    <a class="etc">&bull;&bull;&bull;</a>
    <div class="tray">
        <section class="base-theme-options">
            <h2>Base Theme</h2>
            <ul><li><a class="accent light" title="light" href="javascript:;"></a></li>
                <li><a class="accent dark" title="dark" href="javascript:;"></a></li>
            </ul>
        </section>
        <section class="theme-options">
            <h2>Tile Color</h2>
            <ul><li><a class="accent amber" title="amber" href="javascript:;"></a></li>
                <li><a class="accent blue" title="blue" href="javascript:;"></a></li>
                <li><a class="accent brown" title="brown" href="javascript:;"></a></li>
                <li><a class="accent cobalt" title="cobalt" href="javascript:;"></a></li>
                <li><a class="accent crimson" title="crimson" href="javascript:;"></a></li>
                <li><a class="accent cyan" title="cyan" href="javascript:;"></a></li>
                <li><a class="accent magenta" title="magenta" href="javascript:;"></a></li>
                <li><a class="accent lime" title="lime" href="javascript:;"></a></li>
                <li><a class="accent indigo" title="indigo" href="javascript:;"></a></li>
                <li><a class="accent green" title="green" href="javascript:;"></a></li>
                <li><a class="accent emerald" title="emerald" href="javascript:;"></a></li>
                <li><a class="accent mango" title="mango" href="javascript:;"></a></li>
                <li><a class="accent mauve" title="mauve" href="javascript:;"></a></li>
                <li><a class="accent olive" title="olive" href="javascript:;"></a></li>
                <li><a class="accent orange" title="orange" href="javascript:;"></a></li>
                <li><a class="accent pink" title="pink" href="javascript:;"></a></li>
                <li><a class="accent red" title="red" href="javascript:;"></a></li>
                <li><a class="accent sienna" title="sienna" href="javascript:;"></a></li>
                <li><a class="accent steel" title="steel" href="javascript:;"></a></li>
                <li><a class="accent teal" title="teal" href="javascript:;"></a></li>
                <li><a class="accent violet" title="violet" href="javascript:;"></a></li>
                <li><a class="accent yellow" title="yellow" href="javascript:;"></a></li>
            </ul>
        </section>
    </div>
</footer>

<script>
    (function($){
        $(document).ready(function(){
            $('html, body, *').mousewheel(function(e, delta) {
                this.scrollLeft -= (delta * 40);
                e.preventDefault();
            });
        });
    })(jQuery);
</script>
</body>

</html>
