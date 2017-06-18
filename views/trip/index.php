<?php
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\TripSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '旅游列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trip-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加旅游', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'desc:ntext',
            ['attribute'=>'img','format'=>['image',['width='>'100','height'=>'80']],],
            'is_stick',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
