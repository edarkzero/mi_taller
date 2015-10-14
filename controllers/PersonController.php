<?php

namespace app\controllers;

use app\models\Bill;
use app\models\BillPersonal;
use app\models\BillPersonalSearch;
use app\models\BillSearch;
use app\models\Job;
use kartik\mpdf\Pdf;
use Yii;
use app\models\Person;
use app\models\PersonSearch;
use yii\base\Exception;
use yii\base\Model;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * PersonController implements the CRUD actions for Person model.
 */
class PersonController extends Controller
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
     * Lists all Person models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PersonSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Person model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        if(isset($_POST['hasEditable']) && $_POST['hasEditable'] == 1)
        {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            $bill = $_POST['bill'];
            $person = $_POST['person'];

            $billPerson = BillPersonal::find()->where(['bill_id' => $bill,'personal_id' => $person])->one();

            if($billPerson == null)
            {
                $billPerson = new BillPersonal();
                $billPerson->bill_id = $bill;
                $billPerson->personal_id = $person;
                $billPersonAmount = isset($_POST['bp_amount']) ? $_POST['bp_amount'] : 0.00;
                $billPersonDescription = isset($_POST['bp_description']) ? $_POST['bp_description'] : "";
            }

            else
            {
                $billPersonAmount = isset($_POST['bp_amount']) ? $_POST['bp_amount'] : $billPerson->amount;
                $billPersonDescription = isset($_POST['bp_description']) ? $_POST['bp_description'] : $billPerson->description;
            }

            $billPerson->description = $billPersonDescription;
            $billPerson->amount = $billPersonAmount;

            if(!$billPerson->save())
                return ['output'=>'', 'message'=>print_r($billPerson->errors,true)];
            else
            {
                if(isset($_POST['bp_amount']))
                    return ['output' => $billPersonAmount, 'message' => ''];
                elseif(isset($_POST['bp_description']))
                    return ['output' => $billPersonDescription, 'message' => ''];
            }

            return ['output'=>'', 'message'=>'Validation error'];
        }

        $total = 0.00;

        if(isset($_POST['selected'],$_GET['id']))
        {
            $bill_ids = $_POST['selected'];
            $billPersonals = BillPersonal::find()->where(['bill_id' => $bill_ids,'personal_id' => $_GET['id']])->all();

            if(isset($billPersonals))
            {
                $saveMode = isset($_POST['mode']) && $_POST['mode'] == 1;

                if($saveMode)
                    $transaction = BillPersonal::getDb()->beginTransaction();

                try
                {
                    foreach($billPersonals as $billPersonal)
                    {
                        $total += $billPersonal->amount;

                        if($saveMode) {
                            if ($billPersonal->paid == 0)
                                $billPersonal->paid = 1;
                            else
                                $billPersonal->paid = 1;

                            if (!$billPersonal->save())
                                throw new Exception(print_r($billPersonal->errors, true));
                        }
                    }

                    if($saveMode)
                        $transaction->commit();
                }
                catch(\Exception $e)
                {
                    if($saveMode)
                        $transaction->rollBack();
                }
            }
        }

        $billSearchModel = new BillSearch();
        $billDataProvider = $billSearchModel->searchWithPerson(Yii::$app->request->queryParams);

        return $this->render('view', [
            'billSearchModel' => $billSearchModel,
            'billDataProvider' => $billDataProvider,
            'model' => $this->findModel($id),
            'total' => $total
        ]);
    }

    /**
     * Creates a new Person model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Person();
        $jobModel = new Job();

        if ($jobModel->load(Yii::$app->request->post()) && $jobModel->validate() && $model->load(Yii::$app->request->post()) && $model->validate()) {
            $transaction = $model->getDb()->beginTransaction();
            try
            {
                if(is_numeric($jobModel->name))
                    $jobModel = $jobModel->findOne($jobModel->name);
                else {
                    $jobModel = new Job();
                    $jobModel->load(Yii::$app->request->post());
                    if (!$jobModel->save(false))
                        throw new Exception(Yii::t('app', 'Error saving {model}: {msj}', ['model' => Yii::t('app', ucfirst($jobModel->tableName())), 'msj' => print_r($jobModel->getErrors(), true)]), 500);
                }

                $model->job_id = $jobModel->id;

                if(!$model->save(false))
                    throw new Exception(Yii::t('app','Error saving {model}: {msj}',['model' => Yii::t('app',ucfirst($model->tableName())),'msj' => print_r($model->getErrors(),true)]),500);
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
                'jobModel' => $jobModel
            ]);
        }
    }

    /**
     * Updates an existing Person model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $jobModel = $model->job;

        if ($jobModel->load(Yii::$app->request->post()) && $jobModel->validate() && $model->load(Yii::$app->request->post()) && $model->validate()) {
            $transaction = $model->getDb()->beginTransaction();
            try
            {
                if(is_numeric($jobModel->name))
                    $jobModel = $jobModel->findOne($jobModel->name);
                else {
                    $jobModel = new Job();
                    $jobModel->load(Yii::$app->request->post());
                    if (!$jobModel->save(false))
                        throw new Exception(Yii::t('app', 'Error saving {model}: {msj}', ['model' => Yii::t('app', ucfirst($jobModel->tableName())), 'msj' => print_r($jobModel->getErrors(), true)]), 500);
                }

                if($model->job_id != $jobModel->id)
                    $model->job_id = $jobModel->id;

                if(!$model->save(false))
                    throw new Exception(Yii::t('app','Error saving {model}: {msj}',['model' => Yii::t('app',ucfirst($model->tableName())),'msj' => print_r($model->getErrors(),true)]),500);
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
                'jobModel' => $jobModel
            ]);
        }
    }

    /**
     * Deletes an existing Person model.
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
     * Finds the Person model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Person the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Person::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionJobs($q = null, $id = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(is_null($q)) $q = "";
        $out = ['results' => []];
        $occurrence = false;
        $jobs = Job::find()->where('name LIKE :q')->params([':q' => '%'.$q.'%'])->asArray()->all();
        foreach($jobs as $job)
        {
            if ($job['name'] == $q)
                $occurrence = true;

            $out['results'][] = ['id' => $job['id'],'text' => $job['name']];
        }

        if(!$occurrence && $q != "")
            $out['results'][] = ['id' => $q, 'text' => $q];
        return $out;
    }

    public function actionPrint()
    {
        $person = null;
        $billPersonal = null;

        if(isset($_GET['p'],$_GET['s']))
        {
            $ids = explode(',',$_GET['s']);
            $person = Person::findOne($_GET['p']);
            $billPersonal = BillPersonal::getAsociated($_GET['p'],$ids);

            if ($person !== null && count($billPersonal) > 0) {
                $content = $this->renderPartial('print', [
                    'person' => $person,
                    'billPersonal' => $billPersonal
                ]);

                $pdf = new Pdf([
                    // set to use core fonts only
                    'mode' => Pdf::MODE_UTF8,
                    // A4 paper format
                    'format' => Pdf::FORMAT_A4,
                    // portrait orientation
                    'orientation' => Pdf::ORIENT_PORTRAIT,
                    // stream to browser inline
                    'destination' => Pdf::DEST_BROWSER,
                    // your html content input
                    'content' => $content,
                    // format content from your own css file if needed or use the
                    // enhanced bootstrap css built by Krajee for mPDF formatting
                    'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
                    // any css to be embedded if required
                    'cssInline' => '.kv-heading-1{font-size:18px}',
                    // set mPDF properties on the fly
                    'options' => ['title' => Yii::t('app','Bill').' '.Yii::t('app','Report')],
                    // call mPDF methods on the fly
                    'methods' => [
                        'SetHeader'=>[Yii::t('app','Summary')],
                        'SetFooter'=>['{PAGENO}'],
                    ]
                ]);

                return $pdf->render();
            }
        }

        else
            throw new NotFoundHttpException('The requested page does not exist.');
    }
}
