<?php

namespace app\controllers;

use app\models\ItemPrice;
use app\models\Price;
use Yii;
use app\models\Item;
use app\models\ItemSearch;
use yii\base\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ItemController implements the CRUD actions for Item model.
 */
class ItemController extends Controller
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
        ];
    }

    /**
     * Lists all Item models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Item model.
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
     * Creates a new Item model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Item();
        $modelPrice = new Price();

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $modelPrice->load(Yii::$app->request->post()) && $modelPrice->validate()) {
            $transaction = $model->getDb()->beginTransaction();
            try
            {
                if(!$model->save(false)) throw new Exception(Yii::t('app','Error saving {model}: {msj}',['model' => Yii::t('app',ucfirst($model->tableName())),'msj' => print_r($model->getErrors(),true)]),500);
                if(!$modelPrice->save(false)) throw new Exception(Yii::t('app','Error saving {model}: {msj}',['model' => Yii::t('app',ucfirst($modelPrice->tableName())),'msj' => print_r($modelPrice->getErrors(),true)]),500);
                $modelItemPrice = new ItemPrice();
                $modelItemPrice->item_id = $model->id;
                $modelItemPrice->price_id = $modelPrice->id;
                if(!$modelItemPrice->save(false)) throw new Exception(Yii::t('app','Error saving {model}: {msj}',['model' => Yii::t('app',ucfirst($modelItemPrice->tableName())),'msj' => print_r($modelItemPrice->getErrors(),true)]),500);
                $transaction->commit();
            }
            catch(\Exception $e)
            {
                $transaction->rollBack();
                throw $e;
            }
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'modelPrice' => $modelPrice
            ]);
        }
    }

    /**
     * Updates an existing Item model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelItemPrice = $model->itemPrices;
        $modelPrice = $modelItemPrice[0]->price;

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
        } else {
            return $this->render('update', [
                'model' => $model,
                'modelPrice' => $modelPrice
            ]);
        }
    }

    /**
     * Deletes an existing Item model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $modelItemPrice = $model->itemPrices;
        $modelPrice = $modelItemPrice[0]->price;

        $transaction = $model->getDb()->beginTransaction();
        try
        {
            $modelItemPrice[0]->delete();
            $model->delete();
            $modelPrice->delete();
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
     * Finds the Item model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Item the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Item::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
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
