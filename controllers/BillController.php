<?php

namespace app\controllers;

use app\models\CarPart;
use app\models\Damage;
use app\models\Price;
use app\models\Size;
use app\models\Color;
use Yii;
use app\models\Bill;
use app\models\BillSearch;
use yii\base\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * BillController implements the CRUD actions for Bill model.
 */
class BillController extends Controller
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
     * Lists all Bill models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BillSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Bill model.
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
     * Creates a new Bill model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Bill();

        if(Yii::$app->session['carPartTotal'] <= 0.00) return;

        if(isset($_POST['mode'],$_POST['discount']))
        {
            $result = [];

            if($_POST['mode'] == 0 || $_POST['mode'] == 1)
            {
                $transaction = $model->getDb()->beginTransaction();

                try
                {
                    $discount = (double)$_POST['discount'];

                    if($discount > Yii::$app->session['carPartTotal'])
                        $discount = 0.00;

                    $modelPrice = new Price();
                    $modelPrice->price = (double)Yii::$app->session['carPartTotal'] - (double)$discount;
                    $modelPrice->calculate();

                    if(!$modelPrice->save(false)) throw new Exception(Yii::t('app','Error saving {model}: {msj}',['model' => Yii::t('app',ucfirst($modelPrice->tableName())),'msj' => print_r($modelPrice->getErrors(),true)]),500);
                    $model->price_id = $modelPrice->id;
                    $model->discount = $discount; //TODO: need to modify this value by the user from a modal

                    if ($model->save())
                        $result['message'] = Yii::t('app', '{modelClass} saved', ['modelClass' => Yii::t('app', ucfirst($model->tableName()))]);
                    else
                        $result['message'] = Yii::t('app', 'Error saving {model}: {msj}', ['model' => Yii::t('app', ucfirst($model->tableName())), 'msj' => print_r($model->errors, true)]);

                    $transaction->commit();
                }
                catch(\Exception $e)
                {
                    $transaction->rollBack();
                    $result['message'] = Yii::t('app', 'Error saving {model}: {msj}', ['model' => Yii::t('app', ucfirst($model->tableName())), 'msj' => $e]);
                }
            }

            echo json_encode($result);
        }
        else
        {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model
                ]);
            }
        }
    }

    /**
     * Updates an existing Bill model.
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
     * Deletes an existing Bill model.
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
     * Finds the Bill model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Bill the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Bill::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionStoreChanges()
    {
        if(isset($_POST['CarPart']))
        {
            $result = [];
            $selectedParts = $_POST['CarPart'];
            $carPart = CarPart::getByParts($selectedParts['size_id'],$selectedParts['color_id'],$selectedParts['damage_id']);

            if(isset($carPart,$carPart->price)) {
                $total = (double)$carPart->price->total;

                if($_POST['mode'] == 0)
                    Yii::$app->session['carPartTotal'] += $total;
                elseif($_POST['mode'] == 1)
                    Yii::$app->session['carPartTotal'] -= $total;

                $result['total'] = Yii::$app->formatter->asCurrency(Yii::$app->session['carPartTotal']);
                $result['error'] = false;
            }

            else
            {
                $result['message'] = Yii::t('app','The requested car part need to be defined. You can do it <a href="{route}">here</a>',['route' => Url::to(['car-part/create']).'?'.http_build_query($_POST['CarPart'])]);
                $result['error'] = true;
            }

            echo json_encode($result);
        }

        else
            throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionStep1()
    {
        Yii::$app->session['carPartTotal'] = 0.00;
        $carPart = new CarPart();
        $sizes = ArrayHelper::map(Size::find()->asArray()->all(),'id','name');
        $colors = ArrayHelper::map(Color::find()->asArray()->all(),'id','name');
        $damages = ArrayHelper::map(Damage::find()->asArray()->all(),'id','name');

        return $this->render('step1',[
            'carPart' => $carPart,
            'sizes' => $sizes,
            'colors' => $colors,
            'damages' => $damages
        ]);
    }

    public function actionStep2()
    {
        return $this->render('step2');
    }

    public function actionStep3()
    {
        return $this->render('step3');
    }
}
