
<p>&nbsp;</p>
<div>
<?php

if(count($pms) > 0){

    $totalQuantity = 0.00;
    $totalAmount = 0.00;

    foreach($pms as $pms){
        $totalQuantity += $pms['quantity'];
        $totalAmount += $pms['amount'];
    }

    echo 'PMS<br/>';
    echo '<table>';
        echo '<tr>';
            echo '<td>Quantity</td><td>Amount</td>';
        echo '</tr>';

        echo '<tr>';
            echo '<td>'.CHtml::textField('','',array('disabled'=>'disabled','placeholder'=>Yii::app()->format->number($totalQuantity).'L')).'</td>';
            echo '<td>'.CHtml::textField('','',array('disabled'=>'disabled','placeholder'=>Yii::app()->numberFormatter->format("₦#,##0.00",$totalAmount))).'</td>';
        echo '</tr>';

    echo '</table>';
}
if(count($ago) > 0){

    $totalQuantity = 0.00;
    $totalAmount = 0.00;

    foreach($ago as $ago){
        $totalQuantity += $ago['quantity'];
        $totalAmount += $ago['amount'];

    }
    echo 'AGO<br/>';
    echo '<table>';
        echo '<tr>';
            echo '<td>Quantity</td><td>Amount</td>';
        echo '</tr>';

        echo '<tr>';
            echo '<td>'.CHtml::textField('','',array('disabled'=>'disabled','placeholder'=>Yii::app()->format->number($totalQuantity).'L')).'</td>';
            echo '<td>'.CHtml::textField('','',array('disabled'=>'disabled','placeholder'=>Yii::app()->numberFormatter->format("₦#,##0.00",$totalAmount))).'</td>';
        echo '</tr>';

    echo '</table>';

}
if(count($dpk) > 0){

    $totalQuantity = 0.00;
    $totalAmount = 0.00;

    foreach($dpk as $dpk){
        $totalQuantity += $dpk['quantity'];
        $totalAmount += $dpk['amount'];

    }
    echo 'DPK<br/>';
    echo '<table>';
    echo '<tr>';
    echo '<td>Quantity</td><td>Amount</td>';
    echo '</tr>';

    echo '<tr>';
    echo '<td>'.CHtml::textField('','',array('disabled'=>'disabled','placeholder'=>Yii::app()->formar->number($totalQuantity).'L')).'</td>';
    echo '<td>'.CHtml::textField('','',array('disabled'=>'disabled','placeholder'=>Yii::app()->numberFormatter->format("₦#,##0.00",$totalAmount))).'</td>';
    echo '</tr>';

    echo '</table>';

}

?>
</div>