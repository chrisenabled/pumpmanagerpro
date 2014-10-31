<?php

    $todayRecord = User::todaysRecord();

    echo '<span style="color:#3568a7">Daily Feeds  </span><br><br>';

    if(count($todayRecord['pumpStats']) > 0){

        echo '<span style="color: #b24332">Pump Records</span><br>';
        foreach($todayRecord['pumpStats'] as $pumpStat){
            $old = '';
            if($pumpStat->record_date !== date('Y-m-d')) {$old = '(old)';}
            echo '&emsp; Pump '. $pumpStat->pump->pump_no . ': '.
                number_format($pumpStat->sold_qty).' Litres sold <span class = "old"> by '. $pumpStat->attendant_name.' '. $old . '</span><br>';
        }
        echo '...............<br>';
    }

    if(count($todayRecord['tanks']) > 0){

        $added = $todayRecord['added'];
        echo '<span style="color: #b24332">Tank Update</span><br>';
        foreach($todayRecord['tanks'] as $tank){
            $old = '';
            if($tank['date_added'] !== date('Y-m-d')) {$old = '(old)';}
                echo '&emsp;Tank '. $tank['tank_no']. ': '. $tank['qty_added'] . 'L added <span class = "old">'. $old. '</span><br>';
        }
        echo '...............<br>';
    }

    if(count($todayRecord['expenditure']) > 0){

        echo '<span style="color: #b24332">Expenditures</span><br>';
        foreach($todayRecord['expenditure'] as $expenditure){
            $old = '';
            if($expenditure['this_date'] !== date('Y-m-d')) {$old = '(old)';}
            echo '&emsp; Expense <del>N</del>'. ceil($expenditure['expense']) . ' <span class = "old">'. $old . '</span><br> ';
        }
        echo '...............<br>';
    }

    if(count($todayRecord['invoices']) > 0){

        echo '<span style="color: #b24332">Invoices</span><br>';
        foreach($todayRecord['invoices'] as $invoice){
            $old = '';
            if($invoice['date_received'] !== date('Y-m-d')) {$old = '(old)';}
            echo '&emsp; Invoice ' .$invoice['id']. ' <br> ';
        }
    }


?>
