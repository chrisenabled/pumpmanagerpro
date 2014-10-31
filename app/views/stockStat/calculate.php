
<p>&nbsp;</p>
<div>
<?php

if(count($pms) > 0){

    $totalSold = 0.00;
    $totalCost = 0.00;
    $totalRevenue = 0.00;
    $totalProfit = 0.00;

    foreach($pms as $pms){
        $totalSold += $pms['sold_qty'];
        $totalCost += $pms['sold_qty_costprice'];
        $totalRevenue += $pms['sold_qty_revenue'];
        $totalProfit += $pms['sold_qty_profit'];
    }

    echo 'PMS<br/>';
    echo '<table class="calculate">';
        echo '<tr>';
            echo '<td>Sold Quantity</td><td>Cost</td><td>Revenue</td><td>Profit</td>';
        echo '</tr>';

        echo '<tr>';
            echo '<td>'.TbHtml::textField('appendedInput', number_format($totalSold),array('append' => 'Litres','disabled'=>'disabled', 'class'=>'input-medium')).'</td>';
            echo '<td>'.TbHtml::textField('prependedInput',number_format($totalCost),array('prepend'=>'₦', 'disabled'=>'disabled','class'=>'input-medium')).'</td>';
            echo '<td>'.TbHtml::textField('prependedInput',number_format($totalRevenue),array('prepend'=>'₦', 'disabled'=>'disabled','class'=>'input-medium')).'</td>';
            echo '<td>'.TbHtml::textField('prependedInput',number_format($totalProfit),array('prepend'=>'₦', 'disabled'=>'disabled','class'=>'input-medium')).'</td>';

        echo '</tr>';

    echo '</table>';
}
if(count($ago) > 0){

    $totalSold = 0.00;
    $totalCost = 0.00;
    $totalRevenue = 0.00;
    $totalProfit = 0.00;

    foreach($ago as $ago){
        $totalSold += $ago['sold_qty'];
        $totalCost += $ago['sold_qty_costprice'];
        $totalRevenue += $ago['sold_qty_revenue'];
        $totalProfit += $ago['sold_qty_profit'];
    }
    echo 'AGO<br/>';
    echo '<table>';
        echo '<tr>';
            echo '<td>Sold Quantity</td><td>Cost</td><td>Revenue</td><td>Profit</td>';
        echo '</tr>';

    echo '<tr>';
        echo '<td>'.TbHtml::textField('appendedInput', number_format($totalSold),array('append' => 'Litres','disabled'=>'disabled', 'class'=>'input-medium')).'</td>';
        echo '<td>'.TbHtml::textField('prependedInput',number_format($totalCost),array('prepend'=>'₦', 'disabled'=>'disabled','class'=>'input-medium')).'</td>';
        echo '<td>'.TbHtml::textField('prependedInput',number_format($totalRevenue),array('prepend'=>'₦', 'disabled'=>'disabled','class'=>'input-medium')).'</td>';
        echo '<td>'.TbHtml::textField('prependedInput',number_format($totalProfit),array('prepend'=>'₦', 'disabled'=>'disabled','class'=>'input-medium')).'</td>';
    echo '</tr>';

    echo '</table>';

}
if(count($dpk) > 0){

    $totalSold = 0.00;
    $totalCost = 0.00;
    $totalRevenue = 0.00;
    $totalProfit = 0.00;

    foreach($dpk as $dpk){
        $totalSold += $dpk['sold_qty'];
        $totalCost += $dpk['sold_qty_costprice'];
        $totalRevenue += $dpk['sold_qty_revenue'];
        $totalProfit += $dpk['sold_qty_profit'];
    }
    echo 'DPK<br/>';
    echo '<table>';
    echo '<tr>';
    echo '<td>Sold Quantity</td><td>Cost</td><td>Revenue</td><td>Profit</td>';
    echo '</tr>';

    echo '<tr>';
        echo '<td>'.TbHtml::textField('appendedInput', number_format($totalSold),array('append' => 'Litres','disabled'=>'disabled', 'class'=>'input-medium')).'</td>';
        echo '<td>'.TbHtml::textField('prependedInput',number_format($totalCost),array('prepend'=>'₦', 'disabled'=>'disabled','class'=>'input-medium')).'</td>';
        echo '<td>'.TbHtml::textField('prependedInput',number_format($totalRevenue),array('prepend'=>'₦', 'disabled'=>'disabled','class'=>'input-medium')).'</td>';
        echo '<td>'.TbHtml::textField('prependedInput',number_format($totalProfit),array('prepend'=>'₦', 'disabled'=>'disabled','class'=>'input-medium')).'</td>';
    echo '</tr>';

    echo '</table>';

}

?>
</div>

