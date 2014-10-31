<?php if ($model !== null):?>
<table border="1">

	<tr>
		<th width="80px">
		      id		</th>
 		<th width="80px">
		      pump_id		</th>
 		<th width="80px">
		      tank		</th>
 		<th width="80px">
		      user_id		</th>
 		<th width="80px">
		      attendant_name		</th>
 		<th width="80px">
		      shift		</th>
 		<th width="80px">
		      entry_reading		</th>
 		<th width="80px">
		      closing_reading		</th>
 		<th width="80px">
		      sold_qty		</th>
 		<th width="80px">
		      sold_qty_cost		</th>
 		<th width="80px">
		      sold_qty_revenue		</th>
 		<th width="80px">
		      profit		</th>
 		<th width="80px">
		      offset		</th>
 		<th width="80px">
		      record_date		</th>
 		<th width="80px">
		      date_created		</th>
 	</tr>
	<?php foreach($model as $row): ?>
	<tr>
        		<td>
			<?php echo $row->id; ?>
		</td>
       		<td>
			<?php echo $row->pump_id; ?>
		</td>
       		<td>
			<?php echo $row->tank; ?>
		</td>
       		<td>
			<?php echo $row->user_id; ?>
		</td>
       		<td>
			<?php echo $row->attendant_name; ?>
		</td>
       		<td>
			<?php echo $row->shift; ?>
		</td>
       		<td>
			<?php echo $row->entry_reading; ?>
		</td>
       		<td>
			<?php echo $row->closing_reading; ?>
		</td>
       		<td>
			<?php echo $row->sold_qty; ?>
		</td>
       		<td>
			<?php echo $row->sold_qty_cost; ?>
		</td>
       		<td>
			<?php echo $row->sold_qty_revenue; ?>
		</td>
       		<td>
			<?php echo $row->profit; ?>
		</td>
       		<td>
			<?php echo $row->offset; ?>
		</td>
       		<td>
			<?php echo $row->record_date; ?>
		</td>
       		<td>
			<?php echo $row->date_created; ?>
		</td>
       	</tr>
     <?php endforeach; ?>
</table>
<?php endif; ?>
