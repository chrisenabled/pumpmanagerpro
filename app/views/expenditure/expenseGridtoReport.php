<?php if ($model !== null):?>
<table border="1">

	<tr>
		<th width="80px">
		      id		</th>
 		<th width="80px">
		      user_id		</th>
 		<th width="80px">
		      title		</th>
 		<th width="80px">
		      description		</th>
 		<th width="80px">
		      expense		</th>
 		<th width="80px">
		      initial_profit		</th>
 		<th width="80px">
		      final_profit		</th>
 		<th width="80px">
		      this_date		</th>
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
			<?php echo $row->title; ?>
		</td>
       		<td>
			<?php echo $row->description; ?>
		</td>
       		<td>
			<?php echo $row->expense; ?>
		</td>
       		<td>
			<?php echo $row->initial_profit; ?>
		</td>
       		<td>
			<?php echo $row->final_profit; ?>
		</td>
       		<td>
			<?php echo $row->this_date; ?>
		</td>
       		<td>
			<?php echo $row->date_created; ?>
		</td>
       	</tr>
     <?php endforeach; ?>
</table>
<?php endif; ?>
