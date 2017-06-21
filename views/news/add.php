<?php 

use yii\widgets\ActiveForm;

 ?>
<?php $form = ActiveForm::begin(['action'=>'/web/index.php?r=news/add','options' => ['enctype' => 'multipart/form-data']]) ?>

新闻标题:<input type="text" name="title">
<br>
新闻分类：
<select name="c_id" id="">
	<?php foreach($cate_data as $Cval) {?>
	<option value="<?= $Cval['c_id'] ?>"><?= $Cval['c_name'] ?></option>
	<?php } ?>
</select>

<?= $form->field($uploadModel, 'img')->fileInput() ?>
<br>
新闻描述:
	<textarea name="n_desc" id="" cols="30" rows="10"></textarea>
	<br>
	<input type="submit" value="添加">
<?php ActiveForm::end() ?>