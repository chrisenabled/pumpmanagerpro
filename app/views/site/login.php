<?php $this->pageTitle=Yii::app()->name . ' - Login';?>

<div class="container-fluid">
    <?php echo TbHtml::pageHeader('Your Station Records', 'all in one place'); ?>
    <div class="row-fluid">
        <div class="span5 offset1">
    <h3 style="color: #b22222; padding: 0px; margin: 0px">Station Management</h3>
    <small class="label">made simple</small><br><br>
    <p style="font-family: Palatino Linotype, Book Antiqua, tahoma; line-height: 1.8em; color: #000">
        Pump Manager Pro is made to simulate a real life station management. It is user friendly and intuitive.
        Go through records or perform audit in very simple steps. Sign in to the right or
        <?php echo CHtml::link('register',array('user/create'),array('class'=>'blueButton btA')); ?> or
        <?php echo CHtml::link('Learn More',array('site/page', 'view'=>'learn'),array('class'=>'redButton btA')); ?>
    </p><br>
    <div class="media">
        <img class="media-object pull-left" src= <?php echo Yii::app()->request->baseUrl.'/images/pump-icon.png' ?>  >
        <div class="media-body">
            <h4 class="media-heading">Pump Reading calculations</h4>
                Easily get complex calculation done, draw up inference and manipulate the
                calculations to suit your taste.
        </div>
    </div>
    <div class="media">
            <img class="media-object pull-left" src= <?php echo Yii::app()->request->baseUrl.'/images/archive.png' ?>  >
        <div class="media-body">
            <h4 class="media-heading">Organised online archive</h4>
            Store records, receipts, expenditures in an organized archive online.

        </div>
    </div>
    <div class="media">
        <img class="media-object pull-left" src= <?php echo Yii::app()->request->baseUrl.'/images/wallet.png' ?>  >
        <div class="media-body">
            <h4 class="media-heading">Monitor your spending</h4>
           Check and balance your finances. Know where your money goes, and how much comes to you as cash.
        </div>
    </div>
    <div style="height: 85px;"></div>
</div>
        <div class="span5">
    <?php echo $this->renderPartial('loginForm', array('model'=>$model)); ?>
</div>
    </div>
</div>