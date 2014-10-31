<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="container contents">
    <div class="row-fluid">
        <div class="span1" style="text-align: center">
            <img src="/pmp/images/logo3.png">
        </div>
        <div class="span10">
            <div id="content" style="padding: 20px;">
                <?php echo $content; ?>
            </div><!-- content -->
        </div>

    </div>
</div>
<?php $this->endContent(); ?>



