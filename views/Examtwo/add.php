<?php 
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
 ?>


<div class="trip-form">

    <?php $form = ActiveForm::begin(['action'=>['examtwo/add'],'method'=>'post','options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'desc')->textarea(['rows' => 6]) ?>

    <?= $form->field($model,'img')->textInput() ?>

    <?= $form->field($model, 'is_stick')->textInput() ?>

    <div class="form-group">
		<?= Html::submitButton('添加',['class' =>'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>