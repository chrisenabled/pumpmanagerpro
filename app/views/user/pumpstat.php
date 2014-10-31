
<div class="allblue viewstat">
<?php

    $dataprovider =  new CActiveDataProvider('PumpStat', array(
        'criteria'=>array(
            'condition'=>'user_id=:userId',
            'params'=>array(':userId'=>Yii::app()->user->id),
            'order'=>'record_date DESC',
        ),

    ));


$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'pump-stat-preview-grid',
    'dataProvider'=>$dataprovider,
    'columns'=>array(
        array('header'=>'Pump No.', 'value'=>'$data->pump->pump_no'),
        array('header'=>'Attendant','name'=>'attendant_name'),
        array('name'=>'shift','value'=>'$data->shiftText'),
        array('header'=>'Sold', 'value'=>'Yii::app()->numberFormatter->format("#,##0L",$data->sold_qty)'),
        array('header'=>'Profit','value'=>'Yii::app()->numberFormatter->format("₦#,##0.00",$data->profit)'),
        array('header'=>'Reading Date','name'=>'record_date'),

    ),
)); ?>
</div>