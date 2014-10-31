<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' - About';

?>
<div class="row-fluid" style="background-color: black;">
    <div class="span3">
        <img  src= '/pmp/images/globe.png'  >
    </div>
    <div class="span8" style="padding-top: 100px; text-align: center;
">
        <h4 style="color: white">Pump Manager Pro helps you manage your filling station in an easy and convenient
            manner from anywhere around the globe.

        </h4>
    </div>
    <div class="span1"></div>
</div>
<br/>

<div style="padding: 10px;">
<?php $this->widget('bootstrap.widgets.TbHeroUnit', array(
    'heading' => '#Do it Quick, Do it easy!',
    'content' => '<p>Our objective @<strong>PumpManagerPro</strong> is to bring before our customers a fast, effortless and relatively easy
                    means of tracking activities in their filling stations, from anywhere and anytime. As daily records are updated online,
                    the system stores the information and performs necessary computations which are normally done before, during and after
                    stock sales. In just a click, our customers are immediately provided with necessary stock and financial information.</p>' .
                    TbHtml::linkButton('Learn More...', array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'size' => TbHtml::BUTTON_SIZE_LARGE, 'icon'=>'book',
                    'url'=> array('/site/page', 'view'=>'learn'))),
)); ?>
</div>

<div class="row-fluid">
    <div class="span3 offset1">
        <h5>Features</h5>
        <i class="icon-ok"></i>Multiple accounts with different authorization levels for tighter security.<br>
        <i class="icon-ok"></i>Records for, PMS, AGO, DPK, invoice and expenditure.<br>
        <i class="icon-ok"></i>Daily, weekly, monthly, yearly summaries.<br>
        <i class="icon-ok"></i>Daily data feeds.<br>
        <i class="icon-ok"></i>All computations pertaining to stocks.<br>
        <i class="icon-ok"></i>Data search functionality with filter capability.

    </div>
    <div class="span3 offset1">
        <h5>Advantages</h5>
        &bull;&nbsp;Oversee your station from any where at anytime.<br/>
        &bull;&nbsp;Be disillusioned and know the exact <code>net profit</code> you make.<br/>
        &bull;&nbsp;View or make audit for any period span, any time you wish.<br/>
        &bull;&nbsp;Have your station records online, organised and safe.<br/>
    </div>
    <div class="span3 offset1" style="padding-right: 10px;">
        <h5>What must you do ?</h5>
        All you have to do is&nbsp;
        <?php echo Yii::app()->user->isGuest?
        CHtml::link('create account',array('user/create'),array('class'=>'blueButton btA')) :
        ' create an account ' ?>
        for your station and enter daily records. Our system does all the hideous computations.
        Then, query the system to know what you really want to know. Pump Manager Pro has been tailored to compute
        the various necessary calculations done in all filling stations.
    </div>
</div>
    <br>


