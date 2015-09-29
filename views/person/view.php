<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use app\assets\BillPersonAsset;

/* @var $this yii\web\View */
/* @var $model app\models\Person */
/* @var $billSearchModel app\models\BillSearch */
/* @var $billDataProvider */

$this->title = $model->getFullName();
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'People'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

BillPersonAsset::register($this);

?>
<div class="person-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'document',
            'firstname',
            'lastname',
            [
                'label' => Yii::t('app','Job'),
                'value' => $model->job->name
            ]
        ],
    ]) ?>

    <div class="bill-item-index">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <div>
            <h1><?= Html::encode(Yii::t('app', 'Bills')) ?></h1>
            <p>
                <?= Html::a(Yii::t('app', 'Create'), null, ['class' => 'btn btn-primary']) ?>
            </p>
        </div>
        <div class="clearfix"></div>

        <?php Pjax::begin(['id' => 'bill-grid-wrapper']); ?>

        <?= \yii\grid\GridView::widget([
            'id' => 'bill-grid',
            'dataProvider' => $billDataProvider,
            'filterModel' => $billSearchModel,
            'tableOptions' => ['class' => 'table table-bordered table-hover table-select table-select-all'],
            /*'rowOptions' => function($model, $key, $index, $grid)
            {
                return $model->haveItems() ? ['class' => 'info'] : null;
            },*/
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                [
                    'attribute' => 'price_total',
                    'label' => Yii::t('app','Price'),
                    'value' => function ($model, $key, $index, $column)
                    {
                        return Yii::$app->formatter->asCurrency($model->getPriceTotal());
                    }
                ],
                [
                    'attribute' => 'bp_description',
                    'label' => Yii::t('app','Description'),
                    'value' => function ($model, $key, $index, $column)
                    {
                        return $model->getBillPersonalDescription();
                    }
                ],
                [
                    'attribute' => 'bp_amount',
                    'label' => Yii::t('app','Amount'),
                    'value' => function ($model, $key, $index, $column)
                    {
                        return $model->getBillPersonalAmount();
                    }
                ],
                [
                    'attribute' => 'paid',
                    'label' => Yii::t('app','Paid'),
                    'format' => 'raw',
                    'value' => function ($model, $key, $index, $column)
                    {
                        return Html::checkbox('',$model->getBillPersonalPaid());
                    },
                    'filter' => Html::activeCheckbox($billSearchModel,'id',['label' => ''])
                ],

                [
                    'class' => 'yii\grid\ActionColumn',
                    'controller' => 'bill-personal',
                    'buttonOptions' => ['data-pjax' => '0']
                ],
                ['class' => 'yii\grid\CheckboxColumn'],
            ],
        ]); ?>

        <?php Pjax::end(); ?>

    </div>

</div>