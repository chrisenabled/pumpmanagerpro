
<p>&nbsp;</p>
<div>
<?php

    if(count($expenses) > 0){
        $totalExpense = 0.00;

        foreach($expenses as $expense){
            $totalExpense += $expense['expense'];
        }

        echo 'Total Expenditure<br/>';
        echo '<table>';
            echo '<tr>';
                echo '<td>Expenses</td>';
            echo '</tr>';

            echo '<tr>';
                echo '<td>'.CHtml::textField('','',array('disabled'=>'disabled','placeholder'=>Yii::app()->numberFormatter->format("₦#,##0.00",$totalExpense))).'</td>';
            echo '</tr>';

        echo '</table>';
    }

?>
</div>