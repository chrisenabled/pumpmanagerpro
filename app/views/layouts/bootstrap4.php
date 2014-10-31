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

<div class="row-fluid" id="btheader4">
    <div class="span11 offset1">
        <p>
            <img src='/pmp/images/logo.png'  >
            <b class="label label-info" style="font-size: 30; background-color: #143491">P</b>
            <b class="label label-important" style="font-size: 30; background-color: #871239">M</b>
            <b class="label label-success" style="font-size: 30; background-color: #007100">P</b>
            <img src='/pmp/images/pq.png'  >
        </p>
    </div>
</div>

<div class="row-fluid">
    <?php echo $content; ?>
</div>

<div style="height: 40px;"></div>
<div class="row-fluid">
    <div class="span8 offset2 btglassy btboxradius" id="btfooter4">
        <?php if(!Yii::app()->errorHandler->error): ?>
        <?php echo CHtml::link('Home',array('site/index')); ?>&nbsp;|&nbsp;
        <?php echo CHtml::link('About',array('site/page', 'view'=>'about'));?>&nbsp;|&nbsp;
        <?php echo CHtml::link('Learn',array('site/page', 'view'=>'learn'));?>&nbsp;|&nbsp;
        <?php echo CHtml::link('FAQ',array('site/page', 'view'=>'FAQ'));?>&nbsp;|&nbsp;
        <?php echo CHtml::link('Contact',array('site/contact')); ?>&nbsp;|&nbsp;
        <?php endif; ?>
        <?php echo CHtml::link('TOS',array('site/legal',  'active'=>'#terms'));?>&nbsp;|&nbsp;
        <?php echo CHtml::link('Privacy',array('site/legal', 'active'=>'#privacy'));?>
        <span class="pull-right">&copy;&nbsp;www.PumpManagerPro.com</span>

    </div>
</div>
<div style="height: 10px;"></div>

</body>

</html>



