<?php

use yii\helpers\Html;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var int $year */

$this->title = 'Top 10 Authors in ' . $year;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <form method="get" action="">
        <div class="form-group">
            <label>Select Year:</label>
            <?= Html::input('number', 'year', $year, ['class' => 'form-control', 'style' => 'width: 100px; display: inline-block;']) ?>
            <?= Html::submitButton('Show', ['class' => 'btn btn-primary']) ?>
        </div>
    </form>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'full_name',
            [
                'attribute' => 'book_count',
                'label' => 'Books Count',
                'value' => function ($model) {
                        return $model->book_count;
                    },
            ],
        ],
    ]); ?>

</div>