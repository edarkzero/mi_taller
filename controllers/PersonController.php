<?php

namespace app\controllers;

use app\models\BillPersonal;
use app\models\BillPersonalSearch;
use app\models\BillSearch;
use app\models\Job;
use Yii;
use app\models\Person;
use app\models\PersonSearch;
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
        $billSearchModel = new BillSearch();
        $billDataProvider = $billSearchModel->searchWithPerson(Yii::$app->request->queryParams);

        return $this->render('view', [
            'billSearchModel' => $billSearchModel,
            'billDataProvider' => $billDataProvider,
            'model' => $this->findModel($id),
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
}
