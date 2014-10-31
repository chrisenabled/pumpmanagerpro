<html>
<head>
	<meta content="text/html; charset=UTF-8" http-equiv="content-type">
</head>
<table cellspacing="0" cellpadding="10" style="color:#3a3a3a;font:13px Arial;line-height:1.4em;width:100%;border: 1px solid #aeaeaa;">
	<tbody>
		<tr>
            <td style="color:#ffffff;font-size:22px; background-color: #1e4177">
				<?php echo CHtml::encode(Yii::app()->name); ?>
            </td>
		</tr>
		<tr>
            <td>
                <div style="color:#fff;background: limegreen; font-size: 11px; padding-left: 10px;">
            	    <?php if(isset($data['description'])) echo $data['description'];  ?>
                </div>
            </td>
		</tr>
		<tr>
            <td>
				<?php echo $content ?>
            </td>
		</tr>
		<tr>
            <td style="padding:15px 20px;text-align:right;padding-top:5px;border-top:solid 1px #dfdfdf">
				<a href="http://www.pumpmanagerpro.com/"><img alt="pumpmanagerpro.com" src="logo.jpg" /></a>
			</td>
		</tr>
	</tbody>
</table>
</body>
</html>