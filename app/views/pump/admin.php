<div>
<h1>Pumps</h1>

<p>
    You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p></div>

<div class="top-mini-icons-div-container">
    <div class="top-mini-icons-div">
        <?php echo TbHtml::link('<span class="hspan">Pump&nbsp;Records</span>',array('//pumpStat/admin'), array('class'=>'mini-icons-pump icon32')); ?>
    </div>
    <div class="top-mini-icons-div"><?php echo TbHtml::link('<span class="hspan">Add&nbsp;Pump</span>',array('//pump/create'), array( 'class'=>'mini-icons-add icon32')); ?></div>
    <div class="top-mini-icons-div">
        <?php
        $this->widget('ext.mPrint.mPrint', array(
            'title' => 'Pump List',          //the title of the document. Defaults to the HTML title
            'tooltip' => 'Print',        //tooltip message of the print icon. Defaults to 'print'
            'text' => 'Print Results',   //text which will appear beside the print icon. Defaults to NULL
            'element' => '#pump-grid',        //the element to be printed.
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
    'id'=>'pump-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(
        array('name'=>  'pump_no'),
        array('name'=>'stock_id', 'value'=>'$data->stock->stockText', 'filter'=>array('PMS'=>'PMS','AGO'=>'AGO','DPK'=>'DPK')),
        array('name'=> 'tank_in_use'),
        array('header'=>'Meter Reading', 'name'=>'closing_reading','value'=>'Yii::app()->numberFormatter->format("#",$data->closing_reading)','filter'=>false),
        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template' => '{view} {update} {delete}',
        )

    ),
)); ?>
        </div>
    </div>
</div>






