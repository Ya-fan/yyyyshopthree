<center>
<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>
<table>
	<th>姓名</th>
	<th>年龄</th>
	<th>邮箱</th>
	<?php  foreach($data as $val) {?>
	<tr>
		<td><?= $val['name'] ?></td>
		<td><?= $val['age'] ?></td>
		<td><?= $val['email'] ?></td>
		<td><a href="">删除</a></td>
		<td><a href="<?= Url::to(['hello/updata','id'=>base64_encode($val['id'])]) ?>">修改</a></td>
	</tr>
	<?php } ?>
</table>
<?=  LinkPager::widget(['pagination'=>$pagination])?>
</center>
