<?php 

use yii\widgets\ActiveForm;

 ?>
<?php $form = ActiveForm::begin(['action'=>
"/web/index.php?r=news/upd&id=".$new_data['n_id'],'options' => ['enctype' => 'multipart/form-data']]) ?>

新闻标题:<input type="text" name="title" value="<?= $new_data['n_title'] ?>">
<br>
新闻分类：
<select name="c_id" id="">
	<?php foreach($cate_data as $Cval) {?>
	<option selected="<?php if(in_array($new_data['c_id'],$Cval)){echo 'selected';} ?>" value="<?=  $Cval['c_id'] ?>"><?= $Cval['c_name'] ?></option>
	<?php } ?>
</select>
<br>
<input type="hidden" value="<?= $new_data['n_img'] ?>" name="img_hidden">	
<img src="<?= $new_data['img'] ?>" width="100" height="100" alt="">
<?= $form->field($uploadModel, 'img')->fileInput() ?>
<br>
新闻描述:
	<textarea name="n_desc" id="" cols="30" rows="10"><?= $new_data['n_desc'] ?></textarea>
	<br>
	<input type="submit" value="修改">
<?php ActiveForm::end() ?>