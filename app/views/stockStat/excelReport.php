<?php if ($model !== null):?>
<table border="1">

	<tr>
		<th width="80px">
		      id		</th>
 		<th width="80px">
		      stock_id		</th>
 		<th width="80px">
		      user_id		</th>
 		<th width="80px">
		      prev_qty		</th>
 		<th width="80px">
		      current_qty		</th>
 		<th width="80px">
		      sold_qty		</th>
 		<th width="80px">
		      sold_qty_costprice		</th>
 		<th width="80px">
		      sold_qty_revenue		</th>
 		<th width="80px">
		      sold_qty_profit		</th>
 		<th width="80px">
		      sales_date		</th>
 		<th width="80px">
		      date_created		</th>
 	</tr>
	<?php foreach($model as $row): ?>
	<tr>
        		<td>
			<?php echo $row->id; ?>
		</td>
       		<td>
			<?php echo $row->stock_id; ?>
		</td>
       		<td>
			<?php echo $row->user_id; ?>
		</td>
       		<td>
			<?php echo $row->prev_qty; ?>
		</td>
       		<td>
			<?php echo $row->current_qty; ?>
		</td>
       		<td>
			<?php echo $row->sold_qty; ?>
		</td>
       		<td>
			<?php echo $row->sold_qty_costprice; ?>
		</td>
       		<td>
			<?php echo $row->sold_qty_revenue; ?>
		</td>
       		<td>
			<?php echo $row->sold_qty_profit; ?>
		</td>
       		<td>
			<?php echo $row->sales_date; ?>
		</td>
       		<td>
			<?php echo $row->date_created; ?>
		</td>
       	</tr>
     <?php endforeach; ?>
</table>
<?php endif; ?>
