<?php

$stock1 = null;
$stock2 = null;
$stock3 = null;
$male = array();
$female = array();
$stocks = Stock::Model()->findAllByAttributes(array('user_id'=>$model->id));
$attendants = Attendant::sqlAttendants($model->id);

foreach($stocks as $stock){
    if($stock->stock_type == 1){$stock1 = $stock;}
    if($stock->stock_type == 2){$stock2 = $stock;}
    if($stock->stock_type == 3){$stock3 = $stock;}

}
foreach($attendants as $attendant)
{
    if($attendant['gender'] == 1){$male[] = $attendant;}
    if($attendant['gender'] == 2){$female[] = $attendant;}

}

$capacity = 0;
foreach($model->tanks as $tank){
    $capacity += $tank->capacity;
}
$arr = array();
?>

<div id="account" class="well">
    <div style="text-align: center; width: 100%; padding-bottom: 10px;">
        <?php echo '<b>'.Yii::app()->user->station.'</b>'; ?><br/>
        <span>Address: <?php echo empty($arr) ? $model->address : $arr[0]; ?></span>&bull;
        <span>Mobile: <?php echo $model->mobile_number; ?></span>&bull;
        <?php
        if($model->land_line !== null && $model->land_line !== 'XXXXXXXXX'){
            echo '<span>Landline: ' .$model->land_line. '</span>';
        }
        ?>
        <span>Email: <?php echo $model->email; ?></span>
    </div>
    <hr/>
    <div class="row-fluid">
    <div class="span4 offset2">
        <h5>DETAILS:</h5>

        <?php if(!empty($stocks)): ?>
            <h6>&emsp;&nbsp;Stocks;</h6>
        <?php endif; ?>
        <?php if($stock1->available_qty !== null): ?>
            <span>&emsp;&emsp;PMS : </span><span> <?php echo 'Cost ₦'.$stock1->cost_price.' / Selling ₦'.$stock1->selling_price; ?></span><br/>
        <?php endif; ?>
        <?php if($stock2->available_qty !== null): ?>
            <span>&emsp;&emsp;AGO : </span><span> <?php echo 'Cost ₦'.$stock2->cost_price.' / Selling ₦'.$stock2->selling_price; ?></span><br/>
        <?php endif; ?>
        <?php if($stock3->available_qty !== null): ?>
            <span>&emsp;&emsp;DPK : </span><span><?php echo 'Cost ₦'.$stock3->cost_price.' / Selling ₦'.$stock3->selling_price; ?></span>
        <?php endif; ?>
        <?php if(!empty($stocks)): ?>
            <h6>&emsp;&nbsp;Available Stocks;</h6>
        <?php endif; ?>
        <?php if($stock1->available_qty !== null): ?>
            <span>&emsp;&emsp;PMS : </span><span><?php echo number_format($stock1->available_qty).' Litres'?></span><br/>
        <?php endif; ?>
        <?php if($stock2->available_qty !== null): ?>
            <span>&emsp;&emsp;AGO : </span><span><?php echo number_format($stock2->available_qty).' Litres'?></span><br/>
        <?php endif; ?>
        <?php if($stock3->available_qty !== null): ?>
            <span>&emsp;&emsp;DPK : </span><span><?php echo number_format($stock3->available_qty).' Litres'?></span>
        <?php endif; ?>
        <h6>&emsp;&nbsp;Number of Attendants;</h6>
        <span>&emsp;&emsp;Males : </span><span><?php echo count($male)?></span><br/>
        <span>&emsp;&emsp;Females : </span><span><?php echo count($female)?></span>
    </div>

    <div class="span4 offset1">
        <h5>CAPACITY:</h5>
        <?php  $pumps = Pump::sqlPumps(Yii::app()->user->id); ?>
        <?php $tanks = Tank::sqlTanks(Yii::app()->user->id); ?>
        <h6>&emsp;&nbsp;Number of Pumps;</h6>
        <span>&emsp;&emsp;PMS : </span><span><?php  $count = 0; foreach($pumps as $pump){if($pump['stock_id'] == $stock1->id){$count += 1;}} echo $count;  ?></span><br/>
        <span>&emsp;&emsp;AGO : </span><span><?php $count = 0; foreach($pumps as $pump){if($pump['stock_id'] == $stock2->id){$count += 1;}} echo $count; ?></span><br/>
        <span>&emsp;&emsp;DPK : </span><span><?php $count = 0; foreach($pumps as $pump){if($pump['stock_id'] == $stock3->id){$count += 1;}} echo $count; ?></span>
        <h6>&emsp;&nbsp;Number of Tanks;</h6>
        <span>&emsp;&emsp;PMS : </span><?php $count = 0; foreach($tanks as $tank){if($tank['stock_id'] == $stock1->id){$count += 1;}} echo $count; ?><br/>
        <span>&emsp;&emsp;AGO : </span><?php $count = 0; foreach($tanks as $tank){if($tank['stock_id'] == $stock2->id){$count += 1;}} echo $count; ?><br/>
        <span>&emsp;&emsp;DPK : </span><?php $count = 0; foreach($tanks as $tank){if($tank['stock_id'] == $stock3->id){$count += 1;}} echo $count; ?>
        <h6>&emsp;&nbsp;Avg Tank Capacity : <?php if(count($tanks) == 0){echo 'NiL';} else{ echo number_format($capacity/count($tanks)).' Litres';} ?></h6>
    </div>
    </div>
</div>