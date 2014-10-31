<?php $this->pageTitle = Yii::app()->name . ' -Subscription Detail' ?>

<div class="row-fluid">
    <div class="span10 offset1" style="text-align: center">
        <?php echo Yii::app()->user->subscription > 0 ?
            Yii::app()->user->subscription <= 5 ?
                '<div class="btn-large btn-block btn-warning yes">
                <div style="width:20%; float:left;">'.CHtml::link('Panel',array('view'),array('class'=>'btn btn-small btn-inverse')).'</div>
                <div style="width:60%; float:left;">Your Subscription remains</div>
                <div style="width:20%; float:left; text-align:left;">'.CHtml::link('Click to renew',array('subscribe'),array('class'=>'badge badge-success hidden-phone')).'</div>
                <br style="clear:both;"/>
                </div>' :
                '<div class="btn-large btn-block btn-success yes">
                <div style="width:20%; float:left;">'.CHtml::link('Panel',array('view'),array('class'=>'btn btn-small btn-danger')).'</div>
                <div style="width:60%; float:left;">Your Subscription remains</div>
                <div style="width:20%; float:left; text-align:left;">'.CHtml::link('Click to subscribe',array('subscribe'),array('class'=>'badge badge-info hidden-phone')).'</div>
                <br style="clear:both;"/>
                </div>':
            '<div class="btn-large btn-block btn-danger yes">
                <div style="width:20%; float:left;">'.CHtml::link('Panel',array('view'),array('class'=>'btn btn-small btn-primary')).'</div>
                <div style="width:60%; float:left;">Your Subscription has expired</div>
                <div style="width:20%; float:left; text-align:left;">'.CHtml::link('Renew Now!',array('subscribe'),array('class'=>'badge badge-warning hidden-phone')).'</div>
                <br style="clear:both;"/>
                </div>'
            ;
        echo  (Yii::app()->user->subscription) <= 1 ?  ceil(Yii::app()->user->subscription * 24). ' hr(s).' :
                ceil(Yii::app()->user->subscription).' day(s).';

        ?>
    </div>
</div>
<div class="row-fluid">
    <div class="span8 offset2 well btn-inverse" style="margin-top: 30px; text-align: center">
        <h5>Current Subscription Details</h5><br/><br/>
        <p>Date of Purchase: <?php echo date( "Y-m-d" ,$user->decryptIt($model['start_date'])); ?></p>
        <p>Number of days: <?php echo $subscription['number_of_days']; ?></p>
        <p>Subscription Charge: <?php $cost = $subscription['subscription_price'] * $subscription['number_of_days'];
            echo Yii::app()->numberFormatter->format("₦#,##0.00", $cost);  ?></p>
        <p>
            <table class="btn-danger yes" cellpadding="10" style="display: inline-table">
            <tr style="border-bottom: 1px solid #d4d4d4">
                <td style="border-right: 1px solid #d4d4d4"><strong>Discount:</strong></td>
                <td><?php echo $subscription['discount'] == 0 ?
                        '-'.round((($cost - $subscription['amount_paid'])/$cost * 100),2).'%' : '-'.$subscription['discount'].'%'; ?></td>
            </tr>
            <tr style="border-bottom: 1px solid #d4d4d4">
                <td style="border-right: 1px solid #d4d4d4"><strong>Total:</strong></td>
                <td><?php echo Yii::app()->numberFormatter->format("₦#,##0.00",$subscription['amount_paid']); ?></td>
            </tr>
            <tr style="border-bottom: 1px solid #d4d4d4">
                <td style="border-right: 1px solid #d4d4d4"><strong>Amount Paid:</strong></td>
                <td><?php echo Yii::app()->numberFormatter->format("₦#,##0.00",$subscription['amount_paid']); ?></td>
            </tr>
            </table>
        </p>
        <p><?php echo Yii::app()->user->subscription > 0 ?  CHtml::link('Renew subscription',array('subscribe'),array('class'=>'badge badge-success hidden-phone')) :
                CHtml::link('Renew subscription Now!',array('subscribe'),array('class'=>'badge badge-important hidden-phone'));
            ?>
            <?php
                $keepStatus = User::getKeepState();
                if($keepStatus['keep'] == 0  && Yii::app()->user->subscription <= 0){
                    echo CHtml::link('Keep for 3 days',array('keep'),array('class'=>'btn btn-small btn-primary'));
                }
            ?>
        </p>
    </div>
</div>