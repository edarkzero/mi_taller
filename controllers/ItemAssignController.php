<?php

namespace app\controllers;

use app\models\Bill;
use app\models\BillSearch;
use app\models\ItemSearch;
use Yii;
use app\models\BillItem;
use app\models\Item;
use app\models\BillItemSearch;
use yii\base\Exception;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ItemAssignController implements the CRUD actions for BillItem model.
 */
class ItemAssignController extends Controller
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
                            return \Yii::$app->user->id == 100 || \Yii::$app->user->id == 99;
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
     * Lists all BillItem models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(isset($_POST['hasEditable']) && $_POST['hasEditable'] == 1)
        {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if(isset($_POST['item'],$_POST['quantity_user']))
            {
                if(!isset(Yii::$app->session['item'])) Yii::$app->session['item'] = [];
                $item = Yii::$app->session['item'];
                $item[$_POST['item']] = $_POST['quantity_user'];
                Yii::$app->session['item'] = $item;
                return ['output' => $_POST['quantity_user'], 'message' => ''];
            }

            else
                return ['output'=>'', 'message'=>'Validation error'];
        }

        elseif(isset($_POST['iks'],$_POST['bks'],$_POST['assign_mode']))
        {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            //Create assignment
            if($_POST['assign_mode'] == 1)
            {
                $items = Item::findAll($_POST['iks']);
                $bill = Bill::findOne($_POST['bks'][0]);
                $billItem = null;

                $transaction = Bill::getDb()->beginTransaction();

                try {
                    foreach ($items as $item) {
                        $billItem = new BillItem();
                        $billItem->bill_id = $bill->id;
                        $billItem->item_id = $item->id;

                        $itemSession = Yii::$app->session['item'];
                        $billItem->quantity = $itemSession[$item->id];
                        if(!$billItem->save(false)) throw new Exception(Yii::t('app','Error saving {model}: {msj}',['model' => Yii::t('app',ucfirst($billItem->tableName())),'msj' => print_r($billItem->getErrors(),true)]),500);
                    }

                    $transaction->commit();
                    Yii::$app->session['item'] = [];
                    return ['error' => false,'message' => Yii::t('app','Saved')];
                }
                catch(\Exception $e)
                {
                    $transaction->rollBack();
                    return [
                        'error' => true,
                        'message' => print_r($e,true)
                    ];
                }
            }
        }

        $searchModel = new BillSearch();
        $dataProvider = $searchModel->searchWithItem(Yii::$app->request->queryParams);
        $itemSearchModel = new ItemSearch();
        $itemDataProvider = $itemSearchModel->searchWithItem(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'itemSearchModel' => $itemSearchModel,
            'itemDataProvider' => $itemDataProvider,
        ]);
    }

    /**
     * Displays a single BillItem model.
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
     * Creates a new BillItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BillItem();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing BillItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing BillItem model.
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
     * Finds the BillItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return BillItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BillItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
