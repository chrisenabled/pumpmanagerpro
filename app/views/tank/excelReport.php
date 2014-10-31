<?php if ($model !== null):?>
<table border="1">

	<tr>
		<th width="80px">
		      id		</th>
 		<th width="80px">
		      tank_no		</th>
 		<th width="80px">
		      user_id		</th>
 		<th width="80px">
		      stock_id		</th>
 		<th width="80px">
		      capacity		</th>
 		<th width="80px">
		      prev_qty		</th>
 		<th width="80px">
		      added_qty		</th>
 		<th width="80px">
		      current_qty		</th>
 		<th width="80px">
		      last_added_date		</th>
 		<th width="80px">
		      last_record		</th>
 		<th width="80px">
		      updated		</th>
 	</tr>
	<?php foreach($model as $row): ?>
	<tr>
        		<td>
			<?php echo $row->id; ?>
		</td>
       		<td>
			<?php echo $row->tank_no; ?>
		</td>
       		<td>
			<?php echo $row->user_id; ?>
		</td>
       		<td>
			<?php echo $row->stock_id; ?>
		</td>
       		<td>
			<?php echo $row->capacity; ?>
		</td>
       		<td>
			<?php echo $row->prev_qty; ?>
		</td>
       		<td>
			<?php echo $row->added_qty; ?>
		</td>
       		<td>
			<?php echo $row->current_qty; ?>
		</td>
       		<td>
			<?php echo $row->last_added_date; ?>
		</td>
       		<td>
			<?php echo $row->last_record; ?>
		</td>
       		<td>
			<?php echo $row->updated; ?>
		</td>
       	</tr>
     <?php endforeach; ?>
</table>
<?php endif; ?>
