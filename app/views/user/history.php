<h2>Payment History</h2>
<div style="margin:20px;">
    <?php
        foreach($payments as $payment){
            echo CHtml::link( 'Receipt ID: '. $payment['order_id'] .'&emsp;('. $payment['date_created'] .')',
                array('user/receipt','id'=>$payment['order_id'])) .'<br/>';
        }
    ?>
</div>