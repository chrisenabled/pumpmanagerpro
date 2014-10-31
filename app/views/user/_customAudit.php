<p class="muted">
    You can customize your audit by selecting the date range for which to perform audit.
    You can also choose to either perform audit on the active records, or on archived records, or merge both records.
</p>
<p>   Select record type :</p>
<p>
    <input type="radio" checked name="recordType" value="0" id="active" /><label class="custom" for="active">
        <span class="first"></span><span class="second">Active</span></label>&emsp;&emsp;&emsp;
    <input type="radio" name="recordType" value="1" id="archive" /><label class="custom" for="archive">
        <span class="first"></span><span class="second">Archive</span></label>&emsp;&emsp;&emsp;&emsp;
    <input type="radio" name="recordType" value="2" id="both" /><label class="custom" for="both">
        <span class="first"></span><span class="second">Both</span></label>
</p>
<p>
    Select date range :
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
                                data:{ from: start.format("YYYY-MM-DD"), to: end.format("YYYY-MM-DD"), recordType: $("input[name=recordType]:checked").val() },
                                beforeSend: function(){$("#auditResult").html(\'<img src="/pmp/images/loading.gif">Loading...\').addClass("well");},
                                success: function(data)
                                {
                                      $("#auditResult").html("222");

                                }
                            });
                    }

                    '
            )
        );
        ?>
        <span class="add-on"><i class="icon-calendar"></i></span>
    </div>
</p>
<p id="auditResult" style="text-align: center"></p>