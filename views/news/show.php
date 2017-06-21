<?php 

use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;

 ?>
<a href="index.php?r=news/add">添加</a>
<a href="index.php?r=news/collect">采集</a>
 <table border="1">
 	<th>编号</th>
 	<th>标题</th>
 	<th>描述</th>
 	<th>分类</th>
 	<th>图片</th>
 	<th>操作</th>
 	<?php foreach($data as $val) {?>
		<tr>
			<td><?= $val['n_id'] ?></td>
			<td><?= $val['n_title'] ?></td>
			<td><?= $val['n_desc'] ?></td>
			<td><?= $val['c_name'] ?></td>
			<td><img src="<?= $val['i_img'] ?>" width="100"  height="100" alt=""></td>
			<td><a href="index.php?r=news/del&id=<?=$val['n_id'] ?>">删除</a>--<a href="index.php?r=news/upd&id=<?=$val['n_id'] ?>">修改</a></td>
		</tr>
 	<?php } ?>
 </table>
<?php  echo LinkPager::widget([      'pagination'=>$pagination,      'nextPageLabel'=>'下一页',      'firstPageLabel'=>'首页',      ]  )?>