<?php

$stocks = Stock::model()->findAllByAttributes(array('user_id'=>$model->id));
$counter = 0;
if(count($stocks) != 0) {
    echo "<div class='row-fluid' style='font-size: 0.9em'>";
        echo "<div class='span3' style='background: #fff6ed; border: 1px dotted #f2c7bb; border-radius: 5px; padding: 5px;'>";
            $stockStat = Stock::getDailyStat();
            if(!empty($stockStat)){
                echo    "Today's Audit (".date('j F Y').")<br/><br/>&emsp;".
                        "Quantity Sold<br/>&emsp;&emsp;&emsp;";
                foreach($stocks as $stock){
                    $counter += 1;
                    echo $stock->getStockText().' : '.number_format($stockStat['soldQty'.$counter]).'1,333,333,333 Litres<br/>&emsp;&emsp;&emsp;';
                }
                $daily = $model->daily;
                echo    "<br/>&emsp;".
                        "Revenue:&nbsp;₦".number_format($daily['revenue'])."<br/>&emsp;".
                        "Expense:&nbsp;₦".number_format($daily['expense'])."<br/>&emsp;".
                        "Net Profit:&nbsp;₦".number_format($daily['netProfit'])
                ;

            }
            $dailyInvoice = Invoice::getDailyInvoice();
            if(!empty($dailyInvoice)){
                echo "<br/><br/>&emsp;&emsp;Invoices<br/>";
                if($dailyInvoice['quantity1'] != 0){
                    echo "&emsp;&emsp;&emsp;&emsp;PMS : ".number_format($dailyInvoice['quantity1'])." Litres, ".
                        "₦".number_format($dailyInvoice['amount1'])."br/>";
                }
                if($dailyInvoice['quantity2'] != 0){
                    echo "&emsp;&emsp;&emsp;&emsp;PMS : ".number_format($dailyInvoice['quantity2'])." Litres, ".
                        "₦".number_format($dailyInvoice['amount2'])."br/>";
                }
                if($dailyInvoice['quantity3'] != 0){
                    echo "&emsp;&emsp;&emsp;&emsp;PMS : ".number_format($dailyInvoice['quantity3'])." Litres, ".
                        "₦".number_format($dailyInvoice['amount3'])."br/>";
                }
            }
        echo "</div>";
        echo "<div class='span3' style='background: #f2ffdd; border: 1px dotted #c5d5ad; border-radius: 5px; padding: 5px;'>";
        $stockStat = Stock::getWeeklyStat();
        if(!empty($stockStat)){
            $counter = 0;
            echo    "Weekly Audit (Mon - Sun)<br/><br/>&emsp;".
                "Quantity Sold<br/>&emsp;&emsp;&emsp;";
            foreach($stocks as $stock){
                $counter += 1;
                echo $stock->getStockText().' : '.number_format($stockStat['soldQty'.$counter]).' Litres<br/>&emsp;&emsp;&emsp;';
            }
            $weekly = $model->weekly;
            echo    "<br/>&emsp;".
                "Revenue:&nbsp;₦".number_format($weekly['revenue'])."<br/>&emsp;".
                "Expense:&nbsp;₦".number_format($weekly['expense'])."<br/>&emsp;".
                "Net Profit:&nbsp;₦".number_format($weekly['netProfit'])
            ;

        }
        $weeklyInvoice = Invoice::getWeeklyInvoice();
        if(!empty($weeklyInvoice)){
            echo "<br/><br/>&emsp;&emsp;Invoices<br/>";
            if($weeklyInvoice['quantity1'] != 0){
                echo "&emsp;&emsp;&emsp;&emsp;PMS : ".number_format($weeklyInvoice['quantity1'])." Litres, ".
                    "₦".number_format($dailyInvoice['amount1'])."br/>";
            }
            if($weeklyInvoice['quantity2'] != 0){
                echo "&emsp;&emsp;&emsp;&emsp;PMS : ".number_format($weeklyInvoice['quantity2'])." Litres, ".
                    "₦".number_format($weeklyInvoice['amount2'])."br/>";
            }
            if($weeklyInvoice['quantity3'] != 0){
                echo "&emsp;&emsp;&emsp;&emsp;PMS : ".number_format($weeklyInvoice['quantity3'])." Litres, ".
                    "₦".number_format($weeklyInvoice['amount3'])."br/>";
            }
        }
        echo "</div>";
    echo "<div class='span3' style='background: #ecf2ff; border: 1px dotted #c2d5c7; border-radius: 5px; padding: 5px;'>";
    $stockStat = Stock::getMonthlyStat();
    if(!empty($stockStat)){
        $counter =0;
        echo    "Monthly Audit (".date('F').")<br/><br/>&emsp;".
            "Quantity Sold<br/>&emsp;&emsp;&emsp;";
        foreach($stocks as $stock){
            $counter += 1;
            echo $stock->getStockText().' : '.number_format($stockStat['soldQty'.$counter]).' Litres<br/>&emsp;&emsp;&emsp;';
        }
        $monthly = $model->monthly;
        echo    "<br/>&emsp;".
            "Revenue:&nbsp;₦".number_format($monthly['revenue'])."<br/>&emsp;".
            "Expense:&nbsp;₦".number_format($monthly['expense'])."<br/>&emsp;".
            "Net Profit:&nbsp;₦".number_format($monthly['netProfit'])
        ;

    }
    $monthlyInvoice = Invoice::getMonthlyInvoice();
    if(!empty($monthlyInvoice)){
        echo "<br/><br/>&emsp;&emsp;Invoices<br/>";
        if($monthlyInvoice['quantity1'] != 0){
            echo "&emsp;&emsp;&emsp;&emsp;PMS : ".number_format($monthlyInvoice['quantity1'])." Litres, ".
                "₦".number_format($monthlyInvoice['amount1'])."br/>";
        }
        if($monthlyInvoice['quantity2'] != 0){
            echo "&emsp;&emsp;&emsp;&emsp;PMS : ".number_format($monthlyInvoice['quantity2'])." Litres, ".
                "₦".number_format($monthlyInvoice['amount2'])."br/>";
        }
        if($monthlyInvoice['quantity3'] != 0){
            echo "&emsp;&emsp;&emsp;&emsp;PMS : ".number_format($monthlyInvoice['quantity3'])." Litres, ".
                "₦".number_format($monthlyInvoice['amount3'])."br/>";
        }
    }
    echo "</div>";
    echo "<div class='span3' style='background: #e2ffdd; border: 1px dotted #b2d5af; border-radius: 5px; padding: 5px;'>";
    $stockStat = Stock::getYearlyStat();
    if(!empty($stockStat)){
        $counter = 0;
        echo    "Yearly Audit (".date('Y').")<br/><br/>&emsp;".
            "Quantity Sold<br/>&emsp;&emsp;&emsp;";
        foreach($stocks as $stock){
            $counter += 1;
            echo $stock->getStockText().' : '.number_format($stockStat['soldQty'.$counter]).' Litres<br/>&emsp;&emsp;&emsp;';
        }
        $yearly = $model->yearly;
        echo    "<br/>&emsp;".
            "Revenue:&nbsp;₦".number_format($yearly['revenue'])."<br/>&emsp;".
            "Expense:&nbsp;₦".number_format($yearly['expense'])."<br/>&emsp;".
            "Net Profit:&nbsp;₦".number_format($yearly['netProfit'])
        ;

    }
    $yearlyInvoice = Invoice::getYearlyInvoice();
    if(!empty($yearlyInvoice)){
        echo "<br/><br/>&emsp;&emsp;Invoices<br/>";
        if($yearlyInvoice['quantity1'] != 0){
            echo "&emsp;&emsp;&emsp;&emsp;PMS : ".number_format($yearlyInvoice['quantity1'])." Litres, ".
                "₦".number_format($yearlyInvoice['amount1'])."br/>";
        }
        if($yearlyInvoice['quantity2'] != 0){
            echo "&emsp;&emsp;&emsp;&emsp;PMS : ".number_format($yearlyInvoice['quantity2'])." Litres, ".
                "₦".number_format($yearlyInvoice['amount2'])."br/>";
        }
        if($yearlyInvoice['quantity3'] != 0){
            echo "&emsp;&emsp;&emsp;&emsp;PMS : ".number_format($yearlyInvoice['quantity3'])." Litres, ".
                "₦".number_format($yearlyInvoice['amount3'])."br/>";
        }
    }
    echo "</div>";
    echo "</div>";

}
else{
    echo "<span class='muted'><em>...There are no Audit records available</em></span>";
}


