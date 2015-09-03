<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CarPartSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Car parts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="car-part-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create {modelClass}: ', ['modelClass' => Yii::t('app','Car part')]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'size_name',
                'label' => $searchModel->getAttributeLabel('size'),
                'value' => function ($model, $key, $index, $column)
                {
                    return $model->getSizeName();
                }
            ],
            [
                'attribute' => 'color_name',
                'label' => $searchModel->getAttributeLabel('color'),
                'value' => function ($model, $key, $index, $column)
                {
                    return $model->getColorName();
                }
            ],
            [
                'attribute' => 'damage_name',
                'label' => $searchModel->getAttributeLabel('damage'),
                'value' => function ($model, $key, $index, $column)
                {
                    return $model->getDamageName();
                }
            ],
            [
                'attribute' => 'price_total',
                'value' => function ($model, $key, $index, $column)
                {
                    return $model->getPriceTotal();
                },
                'format' => 'currency'
            ],
            'created_at:datetime',
            'updated_at:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
