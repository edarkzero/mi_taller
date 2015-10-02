<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BillSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

\app\assets\BillingAsset::register($this);

$this->title = Yii::t('app', 'Bills');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="bill-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create {modelClass}: ', ['modelClass' => Yii::t('app', 'Bill')]), ['step1'], ['class' => 'btn btn-success']) ?>
    <fieldset>
        <div class="form-group">
            <label for="select" class="col-lg-2 control-label"><?= Yii::t('app', 'Show'); ?></label>

            <div class="col-lg-2">
                <?= Html::dropDownList('bill-type', 0, [Yii::t('app', 'All'), Yii::t('app', 'Bills'), Yii::t('app', 'Bill drafts'),Yii::t('app','Deleted2')], ['class' => 'form-control', 'id' => 'bill-type']); ?>
            </div>
        </div>
    </fieldset>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function ($model, $key, $index, $grid) {
            if($model->isDeleted())
                return ['class' => 'danger'];
            elseif($model->isDraft())
                return ['class' => 'warning'];
            else
                return null;
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'vehicle_description',
                'label' => Yii::t('app', 'Vehicle'),
                'value' => function ($model, $key, $index, $column) {
                    return $model->getVehicleDescription();
                }
            ],
            [
                'attribute' => 'customer_description',
                'label' => Yii::t('app', 'Customer'),
                'value' => function ($model, $key, $index, $column) {
                    return $model->getCustomerDescription();
                }
            ],
            [
                'attribute' => 'price_total',
                'label' => $searchModel->getAttributeLabel('price_id'),
                'value' => function ($model, $key, $index, $column) {
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
