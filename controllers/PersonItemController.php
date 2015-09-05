<?php

namespace app\controllers;

use Yii;
use app\models\PersonItem;
use app\models\Person;
use app\models\Item;
use app\models\PersonItemSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * PersonItemController implements the CRUD actions for PersonItem model.
 */
class PersonItemController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return \Yii::$app->user->id == 100;
                        },
                        'denyCallback' => function ($rule, $action) {
                            throw new \Exception('You are not allowed to access this page');
                        }
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all PersonItem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PersonItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PersonItem model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PersonItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PersonItem();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            $people = \yii\helpers\ArrayHelper::map(Person::find()->asArray()->all(),'id','lastname');
            $items = \yii\helpers\ArrayHelper::map(Item::find()->asArray()->all(),'id','name');

            return $this->render('create', [
                'model' => $model,
                'items' => $items,
                'people' => $people
            ]);
        }
    }

    /**
     * Updates an existing PersonItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            $people = \yii\helpers\ArrayHelper::map($model->person->find()->asArray()->all(),'id','lastname');
            $items = \yii\helpers\ArrayHelper::map($model->item->find()->asArray()->all(),'id','name');

            return $this->render('update', [
                'model' => $model,
                'items' => $items,
                'people' => $people
            ]);
        }
    }

    /**
     * Deletes an existing PersonItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PersonItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PersonItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PersonItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionPerson($q = null, $id = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (is_null($q)) $q = "";
        $out = ['results' => []];
        $jobs = Person::find()->where('firstname LIKE :q OR lastname LIKE :q')->params([':q' => '%' . $q . '%'])->asArray()->all();
        foreach ($jobs as $job)
        {
            $out['results'][] = ['id' => $job['id'], 'text' => $job['firstname'].' '.$job['lastname']];
        }
        return $out;
    }

    public function actionItem($q = null, $id = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (is_null($q)) $q = "";
        $out = ['results' => []];
        $jobs = Item::find()->where('name LIKE :q OR code LIKE :q')->params([':q' => '%' . $q . '%'])->asArray()->all();
        foreach ($jobs as $job)
        {
            $out['results'][] = ['id' => $job['id'], 'text' => $job['name']];
        }
        return $out;
    }
}
