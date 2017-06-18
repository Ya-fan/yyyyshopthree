<?php 
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
 ?>

 <?php $form = ActiveForm::begin(['action' => ['examtwo/updata'],'method'=>'post']); ?>
	标题:<input type="text" value="<?= $data['title'] ?>" name="title"><br>
	简介:<input type="text" value="<?= $data['desc'] ?>" name="desc"><br>
	no：<input type="text" value="<?= $data['img'] ?>" name="img"><br>
	状态:<input type="text" value="<?= $data['is_stick']?>" name="is_stick"><br>
	<input type="hidden" value="<?= $data['id'] ?>" name="id">
	<input type="submit" value="修改">
<?php ActiveForm::end(); ?>