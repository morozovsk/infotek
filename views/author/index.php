<?php

use app\models\Author;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Authors';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="author-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!Yii::$app->user->isGuest): ?>
        <p>
            <?= Html::a('Create Author', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php endif; ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'full_name',
            [
                'class' => ActionColumn::class,
                'template' => '{view} {update} {delete} {subscribe}',
                'buttons' => [
                    'subscribe' => function ($url, $model, $key) {
                            if ($model->isSubscribed(Yii::$app->user->id)) {
                                return Html::a('Unsubscribe', ['unsubscribe', 'id' => $model->id], ['class' => 'btn btn-xs btn-danger']);
                            } else {
                                return Html::a('Subscribe', ['subscribe', 'id' => $model->id], ['class' => 'btn btn-xs btn-info']);
                            }
                        },
                ],
                'visibleButtons' => [
                    'update' => !Yii::$app->user->isGuest,
                    'delete' => !Yii::$app->user->isGuest,
                    'subscribe' => !Yii::$app->user->isGuest,
                ],
            ],
        ],
    ]); ?>


</div>