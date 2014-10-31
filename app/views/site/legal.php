<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Legal';
?>
<div class="row-fluid">
    <div class="span2" style="height: 80px; line-height: 100px; border-right: 1px solid #dadada; padding-right: 15px;">
        <h2 class="pull-right">LEGAL <img src=<?php echo Yii::app()->request->baseUrl.'/images/gavel.png' ?>  ></h2>
    </div>
    <div class="span3" style="padding-top: 20px;">
        <span class="btTP">
            Terms & Policies
        </span>
    </div>
</div>
<div class="row-fluid">
    <div class="span10 offset1" style="padding-top: 50px;">
        <ul class="nav nav-tabs" id="myTab">
            <li><a href="#terms">Terms</a></li>
            <li><a href="#privacy">Privacy</a></li>
            <li><a href="#csp">Civil Subpoena Policy</a></li>
            <li><a href="#keyTerms">Key Terms</a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane" id="terms"><?php echo $this->renderPartial('//site/terms',null,true); ?></div>
            <div class="tab-pane" id="privacy"><?php echo $this->renderPartial('//site/privacy',null,true); ?></div>
            <div class="tab-pane" id="csp"><?php echo $this->renderPartial('//site/csp',null,true); ?></div>
            <div class="tab-pane" id="keyTerms">...</div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#myTab a').click(function (e) {
            e.preventDefault();
            $(this).tab('show');
        })
        $('#myTab a[href=<?php echo $active; ?>]').tab('show');
    });

</script>