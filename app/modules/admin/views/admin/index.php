<?php
/* @var $this AdminController */
/* @var $dataProvider CActiveDataProvider */
?>
<div style="position: fixed; top: 10px; left: 250px; z-index: 6">
    <?php
    $this->widget('bootstrap.widgets.TbAlert', array('id'=>'alert',
        'block'=>true, // display a larger alert block?
        'fade'=>true, // use transitions?
        'closeText'=>'×', // close link text - if set to false, no close link is displayed
        'alerts'=>array( // configurations per alert type
            'info'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'), // success, info, warning, error or danger
        ),
    ));
    ?>
</div>
<div class="well">
<h4 class="muted">Available Tasks</h4>

1. <?php echo CHtml::link('Subscribe a customer',array(), array('class'=>'label label-success','data-toggle'=>'modal',
        'data-target'=>'#pinCode', 'onclick'=>$action = 'subscribeCustomer')); ?><br/><br/>
2. <?php echo CHtml::link('View a customer\'s details',array('site/contact'), array('class'=>'label label-info')); ?><br/><br/>
3. <?php echo CHtml::link('Change your password',array('site/contact'), array('class'=>'label label-warning')); ?><br/><br/>
4. <?php echo CHtml::link('General System Message',array('site/contact'), array('class'=>'label label-info')); ?><br/><br/>
5. <?php echo CHtml::link('Individual Customer Message',array('site/contact'), array('class'=>'label label-info')); ?><br/><br/>
6. <?php echo CHtml::link('Go to PMP homepage',array('//site/index'), array('class'=>'label')); ?><br/><br/>
5. <?php echo CHtml::link('Delete an Admin Account',array('site/contact'), array('class'=>'label label-important')); ?><br/><br/>

    <style>
        #letterpress h1 {
            font-size:60px;
            font-family: Arial, Helvetica, sans-serif;
            color: #504f4f;
            text-shadow: 0px 2px 1px #bbbaba;
        }
    </style>
    <h1 id="letterpress" style="font-size:60px;
            font-family: Arial, Helvetica, sans-serif;
            color: #504f4f;
            text-shadow: 0px 2px 1px #d4d3d3;">Hello</h1>
<div class="row-fluid">
    <div class="span12">
        <span class="pull-right">
            <?php echo TbHtml::linkButton('Logout', array('color' => TbHtml::BUTTON_COLOR_DANGER, 'icon'=>'icon-off','url'=> array('default/logout'))); ?>
        </span>
    </div>
</div>
</div>


<?php $this->widget('bootstrap.widgets.TbModal', array(
    'id' => 'pinCode',
    'header' => 'Pin Code',
    'content' => '<form name="pinCode" method="POST" action='.$action.'>
            <fieldset>
                <legend>Pin Code</legend>
                <input type="text" placeholder="Enter your 4-digit pin code..." name="pinCode" id="focus">
                <span class="help-block">The pin code is used for verification purposes.</span>
                <button class="btn">Submit</button>
            </fieldset>
        </form>',
    'footer' => '        <span class="muted">Pump Manager Pro</span>
',
)); ?>

