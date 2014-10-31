

<h1>Expenditures</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<div class="top-mini-icons-div-container">
    <div class="top-mini-icons-div"><?php echo CHtml::link('<span class="hspan">Add&nbsp;Expenditure</span>', array('//expenditure/create'), array('class'=>'mini-icons-add icon32')); ?></div>
    <div class="top-mini-icons-div">
        <?php
        $this->widget('ext.mPrint.mPrint', array(
            'title' => 'title',          //the title of the document. Defaults to the HTML title
            'tooltip' => 'Print',        //tooltip message of the print icon. Defaults to 'print'
            'text' => 'Print Results',   //text which will appear beside the print icon. Defaults to NULL
            'element' => '#expenditure-grid',        //the element to be printed.
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
        'id'=>'expenditure-grid',
        'dataProvider'=>$model->search(),
        'filter'=>$model,
        'columns'=>array(
            'title',
            array('name'=>'expense','value'=>'Yii::app()->numberFormatter->format("₦#,##0.00",$data->expense)'),
            array('name'=>'initial_profit','value'=>'Yii::app()->numberFormatter->format("₦#,##0.00",$data->initial_profit)'),
            array('name'=>'final_profit','value'=>'Yii::app()->numberFormatter->format("₦#,##0.00",$data->final_profit)'),
            'this_date',
            array(
                'class'=>'bootstrap.widgets.TbButtonColumn',
                'template' => '{view} {update} {delete}',
            )
        ),

    )); ?>
</div>

<br/><hr/><br/>

<?php echo TbHtml::muted('You can perform custom audit by selecting a range of dates below '); ?>
<div id="calculator">
    Select From and To dates:<br/><br/>
    <div class="input-append">
        <?php $this->widget(
            'yiiwheels.widgets.daterangepicker.WhDateRangePicker',
            array(
                'name' => 'daterange',
                'htmlOptions' => array(
                    'placeholder' => 'Select the date range'
                ),
                'pluginOptions'=>array('format'=> 'YYYY/MM/DD',),

                'callback'=>'function(start, end){

                        $.ajax({
                            type:"POST",
                            url:"calculate",
                            dataType:"json",
                            data:{ from: start.format("YYYY-MM-DD"), to: end.format("YYYY-MM-DD") },
                            success: function(data)
                            {
                                  $("#clay").html(data.status);
                                  $("#print").show();

                            }
                        });
                }

                '
            )
        );
        ?>
        <span class="add-on"><i class="icon-calendar"></i></span>
    </div>

    <br/><br/>

    <div id="print" style="display: none;">
        <div class="top-mini-icons-div">
            <?php
            $this->widget('ext.mPrint.mPrint', array(
                'title' => 'title',          //the title of the document. Defaults to the HTML title
                'tooltip' => 'Print',        //tooltip message of the print icon. Defaults to 'print'
                'printText' => 'Print&nbsp;Results',   //text which will appear beside the print icon. Defaults to NULL
                'element' => '#clay',        //the element to be printed.
                'exceptions' => array(       //the element/s which will be ignored
                    '.summary',
                    '.search-form','.pagination'
                ),
                'publishCss' => true,       //publish the CSS for the whole page?
                'alt' => 'print',       //text which will appear if image can't be loaded
                'id' => 'print-result'         //id of the print link
            ));
            ?>
        </div>
    </div><br/><br/><br/>
    <div id="clay"></div>
</div>
