<?php $this->pageTitle = Yii::app()->name . ' -Inbox' ?>

<div class="row-fluid">
    <div class="span8 offset2">
<h1><?php echo 'Inbox('.Yii::app()->user->name.')'; ?></h1>
    </div>
</div>

<div class="row-fluid">
<div class="span8 offset2">
<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'dataProvider'=>$model->search(),
    'template'=>"{items}",
    'columns'=>array(
        'title',
        'date_created',
        array(
            'class'=>'CButtonColumn',
        ),
    ),
));
?>
    </div>
    </div>

