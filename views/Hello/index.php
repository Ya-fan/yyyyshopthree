<center>
<?php
use yii\helpers\Url;
?>
<form action="<?= Url::to(['hello/index']);?>" method="post">
	<table>
		<tr>
			<td>姓名；</td>
			<td><input type="text" name="username"></td>
		</tr>
		<tr>
			<td>年龄：</td>
			<td><input type="text" name="age"></td>
		</tr>
		<tr>
			<td>邮箱：</td>
			<td><input type="text" name="email"></td>
		</tr>
		<tr>
			<td><input type="submit" value="提交"></td>
			<td></td>
		</tr>
	</table>
</form>
</center>

