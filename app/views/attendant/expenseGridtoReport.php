
<?php if ($model !== null):?>
<table border="1" >

	<tr>
 		<th width="80px" style="font-weight: bold;">
		      first name		</th>
        <th width="80px" style="font-weight: bold; ">
		      middle name		</th>
        <th width="80px" style="font-weight: bold;">
		      last name		</th>
        <th width="80px" style="font-weight: bold; ">
		      gender		</th>
        <th width="80px" style="font-weight: bold;">
		      state of origin		</th>
        <th width="80px" style="font-weight: bold; ">
		      mobile number		</th>
        <th width="80px" style="font-weight: bold;">
		      date employed		</th>
 	</tr>
	<?php foreach($model as $row): ?>
	<tr>
       		<td style="text-align: center">
			<?php echo $row->first_name; ?>
		</td>
       		<td style="text-align: center">
			<?php echo $row->middle_name; ?>
		</td>
       		<td style="text-align: center">
			<?php echo $row->last_name; ?>
		</td>
       		<td style="text-align: center">
			<?php echo $row->genderText; ?>
		</td>
       		<td style="text-align: center">
			<?php echo $row->stateText; ?>
		</td>
       		<td style="text-align: center">
			<?php echo $row->mobile_number; ?>
		</td>
       		<td style="text-align: center">
			<?php echo $row->date_employed; ?>
		</td>
       	</tr>
     <?php endforeach; ?>
</table>
<?php endif; ?>
