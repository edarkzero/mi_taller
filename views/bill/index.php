<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BillSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Bills');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bill-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create {modelClass}: ', ['modelClass' => Yii::t('app','Bill')]), ['step1'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'vehicle_description',
                'label' => Yii::t('app','Vehicle'),
                'value' => function($model, $key, $index, $column)
                {
                    return $model->getVehicleDescription();
                }
            ],
            [
                'attribute' => 'customer_description',
                'label' => Yii::t('app','Customer'),
                'value' => function($model, $key, $index, $column)
                {
                    return $model->getCustomerDescription();
                }
            ],
            [
                'attribute' => 'price_total',
                'label' => $searchModel->getAttributeLabel('price_id'),
                'value' => function ($model, $key, $index, $column)
                {
                    return Yii::$app->formatter->asCurrency($model->getPriceTotal());
                }
            ],
            'discount:currency',
            'created_at:datetime',
            'updated_at:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
