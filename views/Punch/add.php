<?php 
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

 ?>


<div class="trip-form">

    <?php $form = ActiveForm::begin(['action'=>['punch/add'],'method'=>'post','options' => ['enctype' => 'multipart/form-data']]); ?>

		员工姓名:<input type="text" name="name" >

    <div class="form-group">
		<?= Html::submitButton('添加',['class' =>'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>