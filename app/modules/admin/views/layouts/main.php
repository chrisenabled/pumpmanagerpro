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
<body style='background: #000000 url("/pmp/images/background.png");'>
<div class="container-fluid">
    <div style="height: 100px;"></div>
    <div class="row-fluid">
        <div class="span6 offset3">
            <div class="btboxradius" style="background: #d25a11">
                <h1 style="color: #ffffff">
                <?php
                    echo Yii::app()->user->isGuest ? 'PMP Admin page' : Yii::app()->user->name;
                ?>
                    <span class="pull-right">
                        <img src='/pmp/images/logo.png'  >
                        <b class="label label-info" style="font-size: 30; background-color: #143491">P</b>
                        <b class="label label-important" style="font-size: 30; background-color: #871239">M</b>
                        <b class="label label-success" style="font-size: 30; background-color: #007100">P</b>
                    </span>
                </h1>

                <?php echo $content; ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>