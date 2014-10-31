<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - FAQ';
?>

<div class="hero-unit btglassy" style="margin-top: 20px; text-align: center; background-color: white">
    <h1 id="faq">FAQs</h1>
    <small>Frequently Asked Questions</small>
</div>

<div class="row-fluid">
    <div class="span11 offset1 q" id="q1">
    <h5><?php echo CHtml::link('What is Pump Manager Pro(PMP)?',array('site/page', 'view'=>'FAQ', '#'=>'faq'),array('onclick'=>'js:$(".answer").hide(); $("#ans1").show();
     $(".q a").css("color","#0088CC"); $(this).css("color","grey")',

    )); ?></h5>
    </div>
</div>
<div class="row-fluid answer" id="ans1">
    <div class="span9 offset2">
        Pump Manager Pro also known as PMP is an online simulation of a real filling station. It majorly deals with the stock(PMS, AGO, DPK)
        handling part of a filling station. It is like an online version of fuel sales record keeping. And even more, it does the basic
        financial, accounting, balance & check of stocks normally performed in filling stations. In summary Pump Manager Pro is an online system
        used to store and perform basic calculation of information related to stocks in a filling station.
    </div>
</div>

<div class="row-fluid">
    <div class="span11 offset1 q" id="q2">
        <h5><?php echo CHtml::link('What can i do with PMP?',array('site/page', 'view'=>'FAQ', '#'=>'faq'),array('onclick'=>'js:$(".answer").hide(); $("#ans2").show();
        $(".q a").css("color","#0088CC"); $(this).css("color","grey")')); ?></h5>
    </div>
</div>
<div class="row-fluid answer" id="ans2">
    <div class="span9 offset2">
        With PMP, you can operate and manage your station online. You can build up an online version of your real station,
        store data of pump readings, fuel discharge, invoices of stocks, expenditures, your attendants. You can
        visualise what is happening in your station on screen, easily see audit of daily, weekly, monthly and yearly
        summaries of your finances and stocks. You can also make audit for a custom range of dates you want.
        The system is a way for you to take super control of your station even when you are far away.

    </div>
</div>

<div class="row-fluid">
    <div class="span11 offset1 q" id="q3">
        <h5><?php echo CHtml::link('How do i operate the system?',array('site/page', 'view'=>'FAQ', '#'=>'faq'),array('onclick'=>'js:$(".answer").hide(); $("#ans3").show();
        $(".q a").css("color","#0088CC"); $(this).css("color","grey")')); ?></h5>
    </div>
</div>
<div class="row-fluid answer" id="ans3">
    <div class="span9 offset2">
        Pump manager Pro is intuitive and easy to operate, especially for those who are involved in real life handling
        of a filling station. Read through the <?php echo CHtml::link('Guide',array('site/page', 'view'=>'learn')); ?>
        to jump start your understanding of how to operate your online station. In a little period, operating the system
        will be second nature to you. You can also chat with our operators when they are online and ask for assistance.
        If you would need further help, you can send us an <?php echo CHtml::link('email',array('site/contact')); ?>
        or you can call us on our <?php echo CHtml::link('help line',array('site/page', 'view'=>'FAQ', '#'=>'helpline')); ?>
        if you would prefer to have our representative come over to you and help you in creating your online station
        (charges applicable).
    </div>
</div>

<div class="row-fluid">
    <div class="span11 offset1 q" id="q4">
        <h5><?php echo CHtml::link('Is my online payment safe?',array('site/page', 'view'=>'FAQ', '#'=>'q1'),array('onclick'=>'js:$(".answer").hide(); $("#ans4").show();
        $(".q a").css("color","#0088CC"); $(this).css("color","grey")')); ?></h5>
    </div>
</div>
<div class="row-fluid answer " id="ans4">
    <div class="span9 offset2">
        Our customers' Security and Privacy are a top priority to us @PumpManagerPro, therefore, we provide our customers
        with standard online security measures. Your payments on our website are safe and secure as we make use of
        <a href="http://en.wikipedia.org/wiki/HTTP_Secure">HTTPS</a> communication protocol for all our pages. You can be
        rest assured that your payments and personal credentials are safe. <br/><br/>
        <p class="offset1">
            <span class="label label-info">Note :</span> Pump Manager Pro does not store your payment credentials after payment transactions have been made.<br/>
            <span class="label label-important">Important !</span> <strong>Do not</strong> visit PumpManagerPro website or any other website from links you do
            <strong>NOT</strong> trust.
        </p>
    </div>
</div>

<div class="row-fluid">
    <div class="span11 offset1 q" id="q5">
        <h5><?php echo CHtml::link('I can\'t sign in',array('site/page', 'view'=>'FAQ', '#'=>'q2'),array('onclick'=>'js:$(".answer").hide(); $("#ans5").show();
        $(".q a").css("color","#0088CC"); $(this).css("color","grey")')); ?></h5>
    </div>
</div>
<div class="row-fluid answer" id="ans5">
    <div class="span9 offset2">
         Having problems signing in? If you have forgotten your account login details you can click on the
        <code>Forgot account?</code> link below the <code>Sign in</code> button.
        It will take you to a page that would help you recover your account details.<br/><br/>
        <span class="label label-important">Important !</span> Please make sure you remember the answer to your security
        question and the email address connected to your pmp account. These information is your guarantee for retrieving
        your account if you happen to forget your login credentials.
    </div>
</div>




<div style="height: 180px;"></div>


