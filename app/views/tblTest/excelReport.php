<?php if ($model !== null):?>
<table border="1">

	<tr>
		<th width="80px">
		      id		</th>
 		<th width="80px">
		      username		</th>
 		<th width="80px">
		      password		</th>
 		<th width="80px">
		      station_id		</th>
 		<th width="80px">
		      address		</th>
 		<th width="80px">
		      location_id		</th>
 		<th width="80px">
		      email		</th>
 		<th width="80px">
		      land_line		</th>
 		<th width="80px">
		      mobile_number		</th>
 	</tr>
	<?php foreach($model as $row): ?>
	<tr>
        		<td>
			<?php echo $row->id; ?>
		</td>
       		<td>
			<?php echo $row->username; ?>
		</td>
       		<td>
			<?php echo $row->password; ?>
		</td>
       		<td>
			<?php echo $row->station_id; ?>
		</td>
       		<td>
			<?php echo $row->address; ?>
		</td>
       		<td>
			<?php echo $row->location_id; ?>
		</td>
       		<td>
			<?php echo $row->email; ?>
		</td>
       		<td>
			<?php echo $row->land_line; ?>
		</td>
       		<td>
			<?php echo $row->mobile_number; ?>
		</td>
       	</tr>
     <?php endforeach; ?>
</table>
<?php endif; ?>
