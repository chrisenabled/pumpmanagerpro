<?php if ($model !== null):?>
<table border="1">

	<tr>
		<th width="80px">
		      id		</th>
 		<th width="80px">
		      pump_no		</th>
 		<th width="80px">
		      user_id		</th>
 		<th width="80px">
		      stock_id		</th>
 		<th width="80px">
		      attendant		</th>
 		<th width="80px">
		      shift		</th>
 		<th width="80px">
		      tank_in_use		</th>
 		<th width="80px">
		      money_received		</th>
 		<th width="80px">
		      record_date		</th>
 		<th width="80px">
		      entry_reading		</th>
 		<th width="80px">
		      closing_reading		</th>
 	</tr>
	<?php foreach($model as $row): ?>
	<tr>
        		<td>
			<?php echo $row->id; ?>
		</td>
       		<td>
			<?php echo $row->pump_no; ?>
		</td>
       		<td>
			<?php echo $row->user_id; ?>
		</td>
       		<td>
			<?php echo $row->stock_id; ?>
		</td>
       		<td>
			<?php echo $row->attendant; ?>
		</td>
       		<td>
			<?php echo $row->shift; ?>
		</td>
       		<td>
			<?php echo $row->tank_in_use; ?>
		</td>
       		<td>
			<?php echo $row->money_received; ?>
		</td>
       		<td>
			<?php echo $row->record_date; ?>
		</td>
       		<td>
			<?php echo $row->entry_reading; ?>
		</td>
       		<td>
			<?php echo $row->closing_reading; ?>
		</td>
       	</tr>
     <?php endforeach; ?>
</table>
<?php endif; ?>
