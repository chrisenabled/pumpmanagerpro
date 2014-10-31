<div style="height: 500px; width: 700px; border: 1px solid black; padding: 20px; font: tahoma">
    <h1>PMP Subscription Receipt</h1>
    <div style="text-align: right;">
        <span style="border: 1px solid black; padding: 10px;">Receipt ID : <?php echo $model['order_id'] ?></span>
    </div>
    <div style="text-align: left">
        <p>
            Billed to : <?php echo Yii::app()->user->name; ?><br/>
            Email : <?php echo Yii::app()->user->model->email ?><br/>
            Mobile : <?php echo Yii::app()->user->model->mobile_number ?><br/><br/>
            Date : <?php echo $model['date_created'] ?>
        </p>
    </div>
    <table style="border: 1px solid black">
        <tr>
            <th style="border-bottom: 1px solid black">&emsp;Items</th>
            <th style="border-bottom: 1px solid black">&emsp;Price @ 335 Naira/day</th>
        </tr>
        <tr>
            <td style="height: 200px; border-right: 1px solid black">&emsp;Subscription x <?php echo $model['number_of_days'] .' day(s)' ?></td>
            <td style="height: 200px;">&emsp;&emsp;<?php echo Yii::app()->numberFormatter->format("N#,##0.00",$model['amount_paid']) ?></td>
        </tr>
        <tr>
            <td style="border-top: 1px solid black">&emsp;Total</td>
            <td style="border-top: 1px solid black">&emsp;&emsp;<?php echo Yii::app()->numberFormatter->format("N#,##0.00",$model['amount_paid']) ?></td>
        </tr>
    </table>
</div>