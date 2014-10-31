<?php
$stocks = Stock::sqlStock();
?>

<h1>Stocks</h1>

<div class="top-mini-icons-div-container">
    <div class="top-mini-icons-div">
        <?php echo TbHtml::link('<span class="hspan">Stock&nbsp;Records</span>',array('//stockStat/admin'), array('class'=>'mini-icons-stock icon32')); ?>
    </div>
    <?php if(count($stocks) < 3): ?>
        <div class="top-mini-icons-div"><?php echo TbHtml::link('<span class="hspan">Add&nbsp;Stock</span>',array('//stock/create'), array( 'class'=>'mini-icons-add icon32')); ?></div>
    <?php endif;  ?>
    <div class="top-mini-icons-div">
        <?php
        $this->widget('ext.mPrint.mPrint', array(
            'title' => 'Stock List',          //the title of the document. Defaults to the HTML title
            'tooltip' => 'Print',        //tooltip message of the print icon. Defaults to 'print'
            'text' => 'Print Results',   //text which will appear beside the print icon. Defaults to NULL
            'element' => '#stock-grid',        //the element to be printed.
            'exceptions' => array(       //the element/s which will be ignored
                '.summary',
                '.search-form','.pagination'
            ),
            'publishCss' => true,       //publish the CSS for the whole page?
            'alt' => 'print',       //text which will appear if image can't be loaded
            'id' => 'print-div'         //id of the print link
        ));
        ?>
    </div>

    <div class="top-mini-icons-div"><?php echo CHtml::link('<span class="hspan">Export&nbsp;to&nbsp;PDF</span>', array('GeneratePdf'), array('class'=>'mini-icons-pdf icon32','target'=>'_blank')); ?></div>

    <div class="top-mini-icons-div"><?php echo CHtml::link('<span class="hspan">Export&nbsp;to&nbsp;Excel</span>', array('GenerateExcel'), array('class'=>'mini-icons-excel icon32')); ?></div>
    <br class="break" />
</div>

<div class="row-fluid">
    <div class="span10">
        <div class="well gridview">
            <?php $this->widget('yiiwheels.widgets.grid.WhGridView', array(
                'id'=>'stock-grid',
                'dataProvider'=>$model->search(),
                'columns'=>array(
                    array('header'=>'Stock Type', 'value'=>'$data->getStockText()'),
                    array('header'=>'Quantity', 'value'=>'Yii::app()->numberFormatter->format("#,##0L",$data->available_qty)'),
                    array('header'=>'Cost Price', 'value'=>'Yii::app()->numberFormatter->format("₦#,##0.00",$data->cost_price)'),
                    array('header'=>'Selling Price', 'value'=>'Yii::app()->numberFormatter->format("₦#,##0.00",$data->selling_price)'),
                    array('name'=>'last_record', 'value'=>'$data->last_record'),
                    array(
                        'class'=>'bootstrap.widgets.TbButtonColumn',
                        'template' => '{view} {update}',
                    )

                ),
            )); ?>
        </div>
    </div>
</div>
