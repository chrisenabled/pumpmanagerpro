<?php if ($model !== null):?>
    <table border="1">

        <tr>
            <th width="80px" style="text-align: center;">
                Tank number		</th>
            <th width="80px" style="text-align: center">
                stock used		</th>
            <th width="80px" style="text-align: center">
                Capacity		</th>
            <th width="80px" style="text-align: center">
                Previous Quantity		</th>
            <th width="80px" style="text-align: center">
                Current Quantity		</th>
            <th width="80px" style="text-align: center">
                Last Discharge		</th>
        </tr>
        <?php foreach($model as $row): ?>
            <tr>

                <td style="text-align: center">
                    <?php echo $row->tank_no; ?>
                </td>
                <td style="text-align: center">
                    <?php echo $row->stock->stockText; ?>
                </td>
                <td style="text-align: center">
                    <?php echo $row->capacity; ?>
                </td>
                <td style="text-align: center">
                    <?php echo $row->prev_qty; ?>
                </td>
                <td style="text-align: center">
                    <?php echo $row->current_qty; ?>
                </td>
                <td style="text-align: center">
                    <?php echo $row->last_added_date; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>
