
<div class="allblue viewstat">
<?php

        $criteria = new CDbCriteria;
        $criteria->compare('user_id',Yii::app()->user->id);
        $criteria->order = 'sales_date DESC';
        $dataprovider =  new CActiveDataProvider('StockStat', array('criteria'=>$criteria));

     $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'user-grid',
        'dataProvider'=>$dataprovider,
        'columns'=>array(
            array('name'=>'stock_id','header'=>'Type','value'=>'$data->stock->getStockText()'),
            array('header'=>'Sold','value'=>'Yii::app()->numberFormatter->format("#,##0L",$data->sold_qty)'),
            array('header'=>'Cost','value'=>'Yii::app()->numberFormatter->format("₦#,##0.00",$data->sold_qty_costprice)'),
            array('header'=>'Revenue','value'=>'Yii::app()->numberFormatter->format("₦#,##0.00",$data->sold_qty_revenue)'),
            array('header'=>'Profit','value'=>'Yii::app()->numberFormatter->format("₦#,##0.00",$data->sold_qty_profit)'),
            array('header'=>'Available','value'=>'Yii::app()->numberFormatter->format("#,##0L", $data->current_qty)'),
            'sales_date',

        ),
        'htmlOptions'=>array(

        ),
    ));

?>
</div>