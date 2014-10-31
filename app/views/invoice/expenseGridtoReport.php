<?php if ($model !== null):?>
<table border="1">

	<tr>
		<th width="80px">
		      id		</th>
 		<th width="80px">
		      user_id		</th>
 		<th width="80px">
		      invoice_type		</th>
 		<th width="80px">
		      vehicle_no		</th>
 		<th width="80px">
		      stock_type		</th>
 		<th width="80px">
		      quantity		</th>
 		<th width="80px">
		      amount		</th>
 		<th width="80px">
		      price		</th>
 		<th width="80px">
		      adjustment		</th>
 		<th width="80px">
		      invoice_date		</th>
 		<th width="80px">
		      date_received		</th>
 		<th width="80px">
		      date_created		</th>
 	</tr>
	<?php foreach($model as $row): ?>
	<tr>
        		<td>
			<?php echo $row->id; ?>
		</td>
       		<td>
			<?php echo $row->user_id; ?>
		</td>
       		<td>
			<?php echo $row->invoice_type; ?>
		</td>
       		<td>
			<?php echo $row->vehicle_no; ?>
		</td>
       		<td>
			<?php echo $row->stock_type; ?>
		</td>
       		<td>
			<?php echo $row->quantity; ?>
		</td>
       		<td>
			<?php echo $row->amount; ?>
		</td>
       		<td>
			<?php echo $row->price; ?>
		</td>
       		<td>
			<?php echo $row->adjustment; ?>
		</td>
       		<td>
			<?php echo $row->invoice_date; ?>
		</td>
       		<td>
			<?php echo $row->date_received; ?>
		</td>
       		<td>
			<?php echo $row->date_created; ?>
		</td>
       	</tr>
     <?php endforeach; ?>
</table>
<?php endif; ?>
