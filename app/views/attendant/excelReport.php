<?php if ($model !== null):?>
<table border="1">

	<tr>

 		<th width="80px">
		      first name		</th>
 		<th width="80px">
		      middle name		</th>
 		<th width="80px">
		      last name		</th>
 		<th width="80px">
		      gender		</th>
 		<th width="80px">
		      state of origin		</th>
 		<th width="80px">
		      mobile number		</th>
 		<th width="80px">
		      date employed		</th>
 	</tr>
	<?php foreach($model as $row): ?>
	<tr>

       		<td>
			<?php echo $row->first_name; ?>
		</td>
       		<td>
			<?php echo $row->middle_name; ?>
		</td>
       		<td>
			<?php echo $row->last_name; ?>
		</td>
       		<td>
			<?php echo $row->genderText; ?>
		</td>
       		<td>
			<?php echo $row->stateText; ?>
		</td>
       		<td>
			<?php echo $row->mobile_number; ?>
		</td>
       		<td>
			<?php echo $row->date_employed; ?>
		</td>
       	</tr>
     <?php endforeach; ?>
</table>
<?php endif; ?>
