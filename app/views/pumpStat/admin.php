

<h1>Pump Records</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<div class="top-mini-icons-div-container">
    <div class="top-mini-icons-div"><?php echo CHtml::link('<span class="hspan">Pumps</span>', array('//pump/admin'), array('class'=>'mini-icons-pump icon32')); ?></div>
    <div class="top-mini-icons-div">
        <?php
        $this->widget('ext.mPrint.mPrint', array(
            'title' => 'title',          //the title of the document. Defaults to the HTML title
            'tooltip' => 'Print',        //tooltip message of the print icon. Defaults to 'print'
            'text' => 'Print Results',   //text which will appear beside the print icon. Defaults to NULL
            'element' => '#pump-stat-grid',        //the element to be printed.
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
<div class="well gridview">
    <?php $this->widget('yiiwheels.widgets.grid.WhGridView', array(
	'id'=>'pump-stat-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    //'summaryText' => 'Yiiplayground is showing you {start} - {end} of {count} cool records',
	'columns'=>array(
		array('header'=>'Pump No.', 'name'=>'pump_id', 'value'=>'$data->pump->pump_no'),
        'tank',
		'attendant_name',
		array('name'=>'shift', 'value'=>'$data->shiftText',
            'filter'=>array(1=>'MORNING', 2=>'AFTERNOON',3=>'NIGHT')),
        array('name'=>'entry_reading','value'=>'Yii::app()->numberFormatter->format("#",$data->entry_reading)'),
        array('name'=>'closing_reading','value'=>'Yii::app()->numberFormatter->format("#",$data->closing_reading)'),
        array('name'=>'sold_qty', 'header'=>'Sold Litres'),
        array('name'=>'offset','value'=>'Yii::app()->numberFormatter->format("₦#,##0.00",$data->offset)'),
        'record_date',
	),

)); ?>
</div>

