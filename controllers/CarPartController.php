<?php

namespace app\controllers;

use app\models\Color;
use app\models\Damage;
use app\models\Log;
use app\models\Price;
use app\models\Size;
use Yii;
use app\models\CarPart;
use app\models\CarPartSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * CarPartController implements the CRUD actions for CarPart model.
 */
class CarPartController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow'         => true,
                        'matchCallback' => function ($rule, $action)
                        {
                            return \Yii::$app->user->id == 100 || \Yii::$app->user->id == 99;
                        },
                        'denyCallback'  => function ($rule, $action)
                        {
                            throw new \Exception('You are not allowed to access this page');
                        }
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all CarPart models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CarPartSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CarPart model.
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
     * Creates a new CarPart model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CarPart();
        $modelPrice = new Price();
        $modelPrice->tax = 12;

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $modelPrice->load(Yii::$app->request->post()) && $modelPrice->validate()) {
            $transaction = $model->getDb()->beginTransaction();
            try
            {
                if(!$modelPrice->save(false)) throw new Exception(Yii::t('app','Error saving {model}: {msj}',['model' => Yii::t('app',ucfirst($modelPrice->tableName())),'msj' => print_r($modelPrice->getErrors(),true)]),500);
                $model->price_id = $modelPrice->id;
                if(!$model->save(false)) throw new Exception(Yii::t('app','Error saving {model}: {msj}',['model' => Yii::t('app',ucfirst($model->tableName())),'msj' => print_r($model->getErrors(),true)]),500);

                $transaction->commit();
            }
            catch(\Exception $e)
            {
                $transaction->rollBack();
                throw $e;
            }

            return $this->redirect(['index']);
        } else
        {
            $sizes = ArrayHelper::map(Size::find()->asArray()->all(),'id','name');
            $colors = ArrayHelper::map(Color::find()->asArray()->all(),'id','name');
            $damages = ArrayHelper::map(Damage::find()->asArray()->all(),'id','name');

            return $this->render('create', [
                'model'      => $model,
                'modelPrice' => $modelPrice,
                'sizes' => $sizes,
                'colors' => $colors,
                'damages' => $damages
            ]);
        }
    }

    /**
     * Updates an existing CarPart model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelPrice = $model->price;

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $modelPrice->load(Yii::$app->request->post()) && $modelPrice->validate()) {
            $transaction = $model->getDb()->beginTransaction();
            try
            {
                if(!$model->save(false)) throw new Exception(Yii::t('app','Error updating {model}: {msj}',['model' => Yii::t('app',ucfirst($model->tableName())),'msj' => print_r($model->getErrors(),true)]),500);
                if(!$modelPrice->save(false)) throw new Exception(Yii::t('app','Error updating {model}: {msj}',['model' => Yii::t('app',ucfirst($modelPrice->tableName())),'msj' => print_r($modelPrice->getErrors(),true)]),500);
                $transaction->commit();
            }
            catch(\Exception $e)
            {
                $transaction->rollBack();
                throw $e;
            }

            return $this->redirect(['index']);
        } else
        {
            $sizes = ArrayHelper::map(Size::find()->asArray()->all(),'id','name');
            $colors = ArrayHelper::map(Color::find()->asArray()->all(),'id','name');
            $damages = ArrayHelper::map(Damage::find()->asArray()->all(),'id','name');

            return $this->render('update', [
                'model'       => $model,
                'modelPrice' => $modelPrice,
                'sizes' => $sizes,
                'colors' => $colors,
                'damages' => $damages
            ]);
        }
    }

    /**
     * Deletes an existing CarPart model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $modelPrice = $model->price;

        $transaction = $model->getDb()->beginTransaction();
        try
        {
            $modelPrice->delete();
            $model->delete();
            $transaction->commit();
        }
        catch(\Exception $e)
        {
            $transaction->rollBack();
            throw $e;
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the CarPart model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return CarPart the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CarPart::findOne($id)) !== null)
        {
            return $model;
        } else
        {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionSize($q = null, $id = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (is_null($q)) $q = "";
        $out = ['results' => []];
        $jobs = Size::find()->where('name LIKE :q')->params([':q' => '%' . $q . '%'])->asArray()->all();
        foreach ($jobs as $job)
        {
            $out['results'][] = ['id' => $job['id'], 'text' => $job['name']];
        }
        return $out;
    }

    public function actionColor($q = null, $id = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (is_null($q)) $q = "";
        $out = ['results' => []];
        $jobs = Color::find()->where('name LIKE :q')->params([':q' => '%' . $q . '%'])->asArray()->all();
        foreach ($jobs as $job)
        {
            $out['results'][] = ['id' => $job['id'], 'text' => $job['name']];
        }
        return $out;
    }

    public function actionDamage($q = null, $id = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (is_null($q)) $q = "";
        $out = ['results' => []];
        $jobs = Damage::find()->where('name LIKE :q')->params([':q' => '%' . $q . '%'])->asArray()->all();
        foreach ($jobs as $job)
        {
            $out['results'][] = ['id' => $job['id'], 'text' => $job['name']];
        }
        return $out;
    }

    public function actionPrice()
    {
        if(isset($_POST['p']))
        {
            $modelPrice = new Price();
            $modelPrice->price = $_POST['p']['p_price'];
            $modelPrice->tax = $_POST['p']['p_tax'];
            $modelPrice->total = $_POST['p']['p_total'];
            $modelPrice->calculate();
            echo $modelPrice->getAjaxValue();
        }

        else
            throw new Exception(Yii::t('error','Bad request'));
    }
}
