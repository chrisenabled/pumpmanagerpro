<?php if ($model !== null):?>
<table border="1">

	<tr>
		<th width="80px">
		      id		</th>
 		<th width="80px">
		      stock_type		</th>
 		<th width="80px">
		      user_id		</th>
 		<th width="80px">
		      available_qty		</th>
 		<th width="80px">
		      cost_price		</th>
 		<th width="80px">
		      selling_price		</th>
 		<th width="80px">
		      last_record		</th>
 	</tr>
	<?php foreach($model as $row): ?>
	<tr>
        		<td>
			<?php echo $row->id; ?>
		</td>
       		<td>
			<?php echo $row->stock_type; ?>
		</td>
       		<td>
			<?php echo $row->user_id; ?>
		</td>
       		<td>
			<?php echo $row->available_qty; ?>
		</td>
       		<td>
			<?php echo $row->cost_price; ?>
		</td>
       		<td>
			<?php echo $row->selling_price; ?>
		</td>
       		<td>
			<?php echo $row->last_record; ?>
		</td>
       	</tr>
     <?php endforeach; ?>
</table>
<?php endif; ?>
