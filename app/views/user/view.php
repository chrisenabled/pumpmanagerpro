<?php
Yii::app()->clientScript->registerScriptFile(
    Yii::app()->baseUrl . '/js/display_content.js',
    CClientScript::POS_END
);
?>
<div class="row-fluid">
    <div class="span8 box">
        <div id="operations-container" class="well">
        <table>
            <tr>
                <td style="margin: 0; padding: 10px;"></td>
            </tr>
            <tr>
                <td><div class="operations-icons-div">
                        <?php echo CHtml::link('Pumps', array('//pump/admin'), array('class'=>'icons-pump operations-icons icon64')); ?>
                        <div class="notifications-div"></div>
                    </div>
                </td>
                <td><div class="operations-icons-div">
                        <?php echo CHtml::link('Stocks', array('//stock/admin'), array('class'=>'icons-stock operations-icons icon64')); ?>
                        <div class="notifications-div">20</div>
                    </div>
                </td>
                <td><div class="operations-icons-div">
                        <?php echo CHtml::link('Tanks', array('//tank/admin'), array('class'=>'icons-tank operations-icons icon64')); ?>
                        <div class="notifications-div" style="text-shadow: none">289</div>
                    </div>
                </td>
            </tr>

            <tr>
                <td><div class="operations-icons-div">
                        <?php echo CHtml::link('Invoices', array('//invoice/admin'), array('class'=>'icons-invoice operations-icons icon64')); ?>
                        <div class="notifications-div" style="text-shadow: none">89</div>
                    </div>
                </td>
                <td><div class="operations-icons-div">
                        <?php echo CHtml::link('Expenditures', array('//expenditure/admin'), array('class'=>'icons-expenditure operations-icons icon64')); ?>
                        <div class="notifications-div" style="text-shadow: none"></div>
                    </div>
                </td>

                <td><div class="operations-icons-div">
                        <?php echo CHtml::link('Attendants', array('//attendant/admin'), array('class'=>'icons-attendant operations-icons icon64')); ?>
                        <div class="notifications-div" style="text-shadow: none"></div>
                    </div>
                </td>
            </tr>

            <tr>
                <td><div class="operations-icons-div">
                        <?php echo CHtml::link('Audit', array('//user/audit'), array('class'=>'icons-audit operations-icons icon64')); ?>
                        <div class="notifications-div" style="text-shadow: none">9</div>
                    </div>
                </td>
                <td><div class="operations-icons-div">
                        <a class="icons-user-setting operations-icons icon64 admin" href="Javascript:serveContent('daily'); ">Users&nbsp;Settings</a>
                        <div class="notifications-div" style="text-shadow: none">8</div>
                    </div>
                </td>
                <td><div class="operations-icons-div">
                        <a class="icons-archive operations-icons icon64" href="Javascript:serveContent('daily'); ">Archive</a>
                        <div class="notifications-div" style="text-shadow: none"></div>
                    </div>
                </td>
            </tr>

            <tr>
                <td><div class="operations-icons-div">
                        <a class="icons-inbox operations-icons icon64" onclick="serveContent('daily'); ">Inbox</a>
                        <div class="notifications-div" style="text-shadow: none"></div>
                    </div>
                </td>
                <td><div class="operations-icons-div">
                        <a class="icons-subscription operations-icons icon64" onclick="serveContent('daily'); ">Subscription</a>
                        <div class="notifications-div" style="text-shadow: none">3</div>
                    </div>
                </td>
                <td><div class="operations-icons-div">
                        <a class="icons-pay-history operations-icons icon64" onclick="serveContent('daily'); ">Pay&nbsp;History</a>
                        <div class="notifications-div" style="text-shadow: none">10</div>
                    </div>
                </td>
            </tr>


        </table>
    </div>
    </div>
    <div class="span3">
        <div class="right-side-icons-div">
            <div><a class="mini-icons-pay-online  icon32" onclick="serveContent('daily'); "><span>Pay&nbsp;Online</span></a></div>
            <div><a class="mini-icons-teller icon32" onclick="serveContent('daily'); "><span>Upload&nbsp;Teller&nbsp;No.</span></a></div>
            <div><a class="mini-icons-logfile icon32 admin" href="Javascript:serveContent('daily'); "><span>View&nbsp;Log&nbsp;File</span></a></div>
            <div><button class="button tutorial-button" onclick="location.href='http://www.example.com'">Tutorial</button></div>
        </div>
    </div>
</div>



