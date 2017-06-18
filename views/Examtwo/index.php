<?php 
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
 ?>

 <center>
 	<a href="<?= url::to(['examtwo/add'])?>">创建</a>
 	<table border="1">
 		<?php foreach($data as $val) {?>
 			<tr>
 				<td><?= $val['id'] ?></td>
 				<td><?= $val['title'] ?></td>
 				<td><?= $val['img'] ?></td>
 				<td><?= $val['desc'] ?></td>
 				<td><?= $val['is_stick'] ?></td>
 				<td><a href="<?= Url::to(['examtwo/delete','id'=>$val['id']]) ?>">删除</a><a href="<?= Url::to(['examtwo/updata','id'=>$val['id']]) ?>">修改</a></td>
 			</tr>
 		<?php 
 		}
 		?>
 	</table>
 </center>