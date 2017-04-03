<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this         yii\web\View */
/* @var $searchModel  app\models\search\TripSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Поездки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trip-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Показать записи', ['index', 'TripSearch[airport]' => 'Домодедово, Москва'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php if (Yii::$app->request->queryParams): ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'airport',
            'corporate_id',
            'number',
            'user_id',
            [
                'attribute' => 'created_at',
                'value'     => function ($model) {
                    return $model->created_at ? date('H:i:s d.m.Y', $model->created_at) : null;
                }
            ],
            [
                'attribute' => 'updated_at',
                'value'     => function ($model) {
                    return $model->updated_at ? date('H:i:s d.m.Y', $model->updated_at) : null;
                }
            ],
            [
                'attribute' => 'coordination_at',
                'value'     => function ($model) {
                    return $model->coordination_at ? date('H:i:s d.m.Y', $model->coordination_at) : null;
                }
            ],
            [
                'attribute' => 'saved_at',
                'value'     => function ($model) {
                    return $model->saved_at ? date('H:i:s d.m.Y', $model->saved_at) : null;
                }
            ],
            'tag_le_id',
            'trip_purpose_id',
            'trip_purpose_parent_id',
            'trip_purpose_desc:ntext',
            'status',
        ],
    ]) ?>
    <?php endif ?>
</div>