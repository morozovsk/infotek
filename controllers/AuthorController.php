<?php

namespace app\controllers;

use Yii;
use app\models\Author;
use app\models\Subscription;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * AuthorController implements the CRUD actions for Author model.
 */
class AuthorController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['create', 'update', 'delete', 'subscribe', 'unsubscribe'],
                'rules' => [
                    [
                        'actions' => ['create', 'update', 'delete', 'subscribe', 'unsubscribe'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                    'unsubscribe' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Author models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Author::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Author model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Author model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Author();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Author model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Author model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Subscribe to an author.
     * @param int $id Author ID
     * @return mixed
     */
    public function actionSubscribe($id)
    {
        $author = $this->findModel($id);

        // Check if user is already subscribed
        $existingSubscription = Subscription::findOne([
            'author_id' => $author->id,
            'user_id' => Yii::$app->user->id,
        ]);

        if ($existingSubscription) {
            Yii::$app->session->setFlash('info', 'You are already subscribed to ' . $author->full_name);
            return $this->redirect(['index']);
        }

        $model = new Subscription();
        $model->author_id = $author->id;
        $model->user_id = Yii::$app->user->id;

        if ($this->request->isPost) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'You have successfully subscribed to ' . $author->full_name);
                return $this->redirect(['index']);
            }
        }

        return $this->render('subscribe', [
            'model' => $model,
            'author' => $author,
        ]);
    }

    /**
     * Unsubscribe from an author.
     * @param int $id Author ID
     * @return mixed
     */
    public function actionUnsubscribe($id)
    {
        $author = $this->findModel($id);
        $subscription = Subscription::findOne([
            'author_id' => $author->id,
            'user_id' => Yii::$app->user->id,
        ]);

        if ($subscription) {
            $subscription->delete();
            Yii::$app->session->setFlash('success', 'You have successfully unsubscribed from ' . $author->full_name);
        } else {
            Yii::$app->session->setFlash('info', 'You are not subscribed to ' . $author->full_name);
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Author model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Author the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Author::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
