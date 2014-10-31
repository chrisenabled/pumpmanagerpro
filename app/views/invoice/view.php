<?php
/* @var $this InvoiceController */
/* @var $model Invoice */

$this->breadcrumbs=array(
	'Manage Invoices'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Update Invoice', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Manage Invoice', 'url'=>array('admin')),
);

?>
<br/>
<div class="invoice">
    <div>
        <span style="font-size: 8px; color: #d22b44; text-shadow: none">Date Created: <?php echo $model->date_created?></span>
        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
        <span>Invoice No. : <?php echo $model->id; ?></span></div><hr/><br/>
    <div style="text-shadow: 0px 1px 1px #efefef;">
        <table style="width: 70%; color: #414141; font-family: rockwell; font-size: 14px">
            <tr><td>Vehicle No.</td><td>:</td><td><?php echo $model->vehicle_no; ?></td></tr>
            <tr><td>Stock type</td><td>:</td><td>PMS</td></tr>
            <tr><td>Quantity</td><td>:</td><td><?php echo number_format($model->quantity).'L'; ?></td></tr>
            <tr><td>Price/L</td><td>:</td><td><del>N</del><?php echo number_format($model->price);?></td></tr>
            <tr><td>Amount</td><td>:</td><td><del>N</del><?php echo number_format($model->amount);?></td></tr>
            <tr><td>Date</td><td>:</td><td><?php echo $model->invoice_date?></td></tr>
            <tr><td>........</td><td>........</td><td>........</td></tr>
            <tr><td>Quantity Discharged</td><td>:</td><td><?php echo number_format($model->adjustment).'L'; ?></td><tr>
        </table>
    </div><hr/>
    <div style="text-align: center;">
        Invoice Type: <?php echo $model->typeText?>
        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
        Date Received : <?php echo $model->date_received?>
    </div>
</div>
