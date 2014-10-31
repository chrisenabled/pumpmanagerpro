<div style="height: 500px; width: 700px; border: 1px solid black; padding: 20px; font: normal 10pt tahoma,Helvetica,sans-serif; background-color: #f9ffc9">
    <h1 style="background-color: #ffc3ca; padding: 5px;">PMP Subscription Receipt</h1>
    <div style="text-align: right;">
        <span style="border: 1px solid #c8c8c8; padding: 10px;">Receipt ID : <?php echo $model['order_id'] ?></span>
    </div>
    <div style="text-align: left">
        <p>
            Billed to : <?php echo Yii::app()->user->name; ?><br/>
            Email : <?php echo Yii::app()->user->model->email ?><br/>
            Mobile : <?php echo Yii::app()->user->model->mobile_number ?><br/><br/>
            Date : <?php echo $model['date_created'] ?>
        </p>
    </div>
    <div style="position: relative">
    <table style="border: 1px solid #c8c8c8; padding: 10px;">
        <tr>
            <td style="height: 70px">Item : </td>
            <td style="height: 70px">Account Subscription</td>
            <td></td>
        </tr>
        <tr>
            <td>Subscription price : </td>
            <td><?php echo Yii::app()->numberFormatter->format("₦#,##0.00",$model['subscription_price']).'/day'; ?></td>
        </tr>
        <tr>
            <td>Number of Days : </td>
            <td><?php echo $model['number_of_days'] .' day(s)' ?></td>
            <td></td>
        </tr>
        <tr>
            <td>Cost : </td>
            <td><?php $cost = $model['subscription_price'] * $model['number_of_days'];
                echo  Yii::app()->numberFormatter->format("₦#,##0.00", $cost); ?></td>
            <td></td>
        </tr>
        <tr>
            <td>Discount : </td>
            <td><?php
                echo  $model['discount'] == 0 ? '-'.round((($cost - $model['amount_paid'])/$cost * 100),2).'%' : '-'.$model['discount'].'%'  ?></td>
            <td></td>
        </tr>
        <tr>
            <td>Total : </td>
            <td><?php echo Yii::app()->numberFormatter->format("₦#,##0.00",$model['amount_paid']) ?></td>
            <td></td>
        </tr>
        <tr>
            <td>Amount paid : </td>
            <td></td>
            <td style=" background-color: #5ba952; color: #ffffff"><?php echo Yii::app()->numberFormatter->format("₦#,##0.00",$model['amount_paid']) ?></td>
        </tr>
    </table>
        <img src="/pmp/images/paid.png" style="position: absolute; top: 50px; right: 0px;">
    </div>


</div>