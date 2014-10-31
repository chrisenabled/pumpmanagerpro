<?php if ($model !== null):?>
<table border="1">

	<tr>
 		<th width="80px" style="text-align: center;">
		      pump number		</th>
 		<th width="80px" style="text-align: center">
		      stock used		</th>
 		<th width="80px" style="text-align: center">
		      tank in use		</th>
 		<th width="80px" style="text-align: center">
		      Meter Reading		</th>
 	</tr>
	<?php foreach($model as $row): ?>
	<tr>

       		<td style="text-align: center">
			<?php echo $row->pump_no; ?>
		</td>
       		<td style="text-align: center">
			<?php echo $row->stock->stockText; ?>
		</td>
       		<td style="text-align: center">
			<?php echo $row->tank_in_use; ?>
		</td>
       		<td style="text-align: center">
			<?php echo $row->closing_reading; ?>
		</td>
       	</tr>
     <?php endforeach; ?>
</table>
<?php endif; ?>
