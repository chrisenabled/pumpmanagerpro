<?php
Yii::app()->clientScript->registerScriptFile(
    Yii::app()->baseUrl . '/js/display_content.js',
    CClientScript::POS_END
);
?>

<?php $this->beginContent('//layouts/main'); ?>
<div class="container contents">
    <div class="row-fluid">
        <div class="span2">
            <div class="side-icons-div">
                <?php echo CHtml::link("Daily&nbsp;Feeds",'', array('class'=>'icons-feeds operations-icons icon64 side-icons','data-toggle'=>'modal', 'data-target'=>'#feeds')); ?>
                <a class="icon64 icons-rollback side-icons admin" href="Javascript:serveContent('daily'); ">Roll&nbsp;Back</a>
                <?php echo CHtml::link('Station&nbsp;Info', array('//user/viewprofile'), array('class'=>'icons-station-info operations-icons icon64 side-icons')); ?>
                <a class="icon64 icons-calculator side-icons" onclick="serveContent('daily'); ">Calculator</a>
                <br class="break" />
            </div>
        </div>

        <div class="span10">
            <div class="row-fluid">
                <div class="span7 offset1">
                    <div id="station-name" class="row-fluid">
                        <div>
                            <img src="/pmp/images/logo3.png" alt=""/>
                        </div>
                        <div class="second"><span class="badge badge-info"><?php echo Yii::app()->user->station; ?></span></div>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span11 offset1" id="page">
                    <?php echo $content; ?>
                </div>
            </div>
        </div>
    </div>
    <?php
        $todayHasRecord = Yii::app()->user->model->todayHasRecord();
    if($todayHasRecord){
        $this->widget('bootstrap.widgets.TbModal', array(
            'id' => 'feeds',
            'header' => '<span class="label label-info">'. Yii::app()->user->station.'</span>&nbsp;<span class="label label-success">'.date('j F Y').'</span>',
            'content' => $this->renderPartial('//user/feeds',array('model'=>Yii::app()->user->model),true),
            'footer' => array(
            ),
        ));
    }
    ?>
</div>

<?php $this->endContent(); ?>


<script type="text/javascript">

    $(document).ready(function(){
        <?php if(Yii::app()->user->tableName != "tbl_station_admin"): ?>
            $(".admin").removeAttr("href").addClass("disabled");
        <?php endif; ?>
        <?php $url = Yii::app()->user->getState('operationUrl'); if( $url != null): ?>
            $('#page').html("");
            serveContent(<?php echo Yii::app()->user->getState('operationUrl'); ?>);
        <?php endif; ?>
        <?php if($todayHasRecord): ?>
        $(".icons-feeds").removeClass('icons-feeds').addClass('icons-feeds-on');
        <?php endif; ?>
    });
</script>

