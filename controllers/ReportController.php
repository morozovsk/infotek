<?php

namespace app\controllers;

use Yii;
use app\models\Author;
use yii\web\Controller;
use yii\data\ActiveDataProvider;

class ReportController extends Controller
{
    public function actionIndex($year = null)
    {
        if ($year === null) {
            $year = date('Y');
        }

        $query = Author::find()
            ->select(['authors.*', 'COUNT(books.id) AS book_count'])
            ->joinWith('books')
            ->where(['books.year' => $year])
            ->groupBy('authors.id')
            ->orderBy(['book_count' => SORT_DESC])
            ->limit(10);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'year' => $year,
        ]);
    }
}
