<?php

namespace app\controllers;

class BillingController extends \yii\web\Controller
{
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
