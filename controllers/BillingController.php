<?php

namespace app\controllers;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class BillingController extends \yii\web\Controller
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

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionStep1()
    {
        return $this->render('step1');
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
