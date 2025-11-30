<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Subscription $model */
/** @var app\models\Author $author */

$this->title = 'Subscribe to ' . $author->full_name;
$this->params['breadcrumbs'][] = ['label' => 'Authors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="author-subscribe">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="author-form">

        <?php $form = ActiveForm::begin(); ?>

        <p>Are you sure you want to subscribe to new books by <strong><?= Html::encode($author->full_name) ?></strong>?
        </p>

        <div class="form-group">
            <?= Html::submitButton('Confirm Subscription', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>