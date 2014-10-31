
<h1>Attendants</h1>

<p>
    You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<div class="top-mini-icons-div-container">
    <div class="top-mini-icons-div">
    <?php echo TbHtml::tooltip('<span class="hspan">Attendants</span>',array('//attendant/admin'),'Attendant list', array('placement' => TbHtml::TOOLTIP_PLACEMENT_RIGHT,'class'=>'mini-icons-attendant icon32')); ?>
</div>
    <div class="top-mini-icons-div"><?php echo TbHtml::tooltip('<span class="hspan">Add&nbsp;Attendant</span>',array('//attendant/create'),'Create a new attendant', array('placement' => TbHtml::TOOLTIP_PLACEMENT_TOP,'class'=>'mini-icons-add icon32')); ?></div>
    <div class="top-mini-icons-div">
    <?php
    $this->widget('ext.mPrint.mPrint', array(
        'title' => 'Attendant List',          //the title of the document. Defaults to the HTML title
        'tooltip' => 'Print',        //tooltip message of the print icon. Defaults to 'print'
        'text' => 'Print Results',   //text which will appear beside the print icon. Defaults to NULL
        'element' => '#attendant-grid',        //the element to be printed.
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
	'id'=>'attendant-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'fixedHeader' => true,
    'type'=>'striped',

    'columns'=>array(
		'first_name',
		'middle_name',
		'last_name',
		array('name'=> 'gender', 'value'=> '$data->getGenderText()', 'filter'=>array(1=>'Male',2=>'Female')),
		array('name'=>'state_of_origin', 'value'=>'$data->getStateText()', 'filter' => array(
            1=>'Abia',2=>'Adamawa',3=>'Akwa Ibom',4=>'Anambra',5=>'Bauchi',6=>'Bayelsa',
            7=>'Benue',8=>'Borno',9=>'Cross River',10=>'Delta',11=>'Ebonyi',12=>'Edo',13=>'Ekiti',14=>'Enugu',15=>'F.C.T',16=>'Gombe',
            17=>'Imo',18=>'Jigawa',19=>'Kaduna',20=>'Kano',21=>'Katsina',22=>'Kebbi',23=>'Kogi',24=>'Kwara',
            25=>'Lagos',26=>'Nasarawa',27=>'Niger',28=>'Ogun',29=>'Ondo',30=>'Osun',31=>'Oyo',32=>'Plateau',
            33=>'Rivers',34=>'Sokoto',35=>'Taraba',36=>'Yobe',37=>'Zamfara',
        )),
		'mobile_number',
		'date_employed',
        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template' => '{view} {update} {delete}',
        )

	),
)); ?>
</div>
