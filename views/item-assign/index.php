<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\assets\BillItemAsset;
use \yii\bootstrap\Modal;
use \yii\widgets\Pjax;
use kartik\editable\Editable;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BillSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $itemSearchModel app\models\ItemSearch */
/* @var $itemDataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Bill Items');
$this->params['breadcrumbs'][] = $this->title;

BillItemAsset::register($this);

$billGridID = 'bill-grid';
$itemGridID = 'item-grid';

?>
<div class="bill-item-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div>
        <h1 class="pull-left"><?= Html::encode(Yii::t('app', 'Bills')) ?></h1>
        <p class="pull-right">
            <?= Html::a(Yii::t('app', 'Assign selected'), '#', ['class' => 'btn btn-success','id' => 'select-button']) ?>
        </p>
    </div>
    <div class="clearfix"></div>

    <?php Pjax::begin(['id' => $billGridID.'-wrapper']); ?>

    <?= GridView::widget([
        'id' => $billGridID,
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table-bordered table-hover table-select table-select-one'],
        'rowOptions' => function($model, $key, $index, $grid)
        {
            return $model->haveItems() ? ['class' => 'info'] : null;
        },
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
                'label' => Yii::t('app','Bill'),
                'value' => function ($model, $key, $index, $column)
                {
                    return Yii::$app->formatter->asCurrency($model->getPriceTotal());
                }
            ],
            [
                'attribute' => 'bill_item_outgoings',
                'label' => Yii::t('app','Outgoings'),
                'value' => function ($model, $key, $index, $column)
                {
                    return Yii::$app->formatter->asCurrency($model->getOutgoings());
                }
            ],
            [
                'attribute' => 'bill_item_gain',
                'label' => Yii::t('app','Gainings'),
                'value' => function ($model, $key, $index, $column)
                {
                    return Yii::$app->formatter->asCurrency($model->getGainings());
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'controller' => 'bill',
                'buttons' => [
                    'print' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-print"></span>',['item-assign/print','id' => $model->id],['title' => Yii::t('app','Print'),'data-pjax' => '0','aria-label' => Yii::t('app','Print'),'target' => '_blank']);
                    },
                ],
                'template' => '{view} {update} {delete} {print}',
                'buttonOptions' => ['data-pjax' => '0']
            ],
            ['class' => 'yii\grid\CheckboxColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>

<?php
Modal::begin([
    'header' => '<h2>' . Yii::t('app','Items') . '</h2>',
    'options' => ['id' => 'modal-assignment']
]);
?>

    <div class="row">
        <div class="col-md-12">
            <?php Pjax::begin(['id' => $itemGridID.'-wrapper']); ?>
            <?= GridView::widget([
                'id' => $itemGridID,
                'dataProvider' => $itemDataProvider,
                'filterModel' => $itemSearchModel,
                'rowOptions' => function($model, $key, $index, $grid)
                {
                    return $model->haveItems() ? ['class' => 'info'] : null;
                },
                'tableOptions' => ['class' => 'table table-bordered table-hover table-select table-select-all'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'id',
                    'name',
                    'quantity',
                    [
                        'attribute' => 'quantity_user',
                        'label' => Yii::t('app','Quantity to use'),
                        'format' => 'raw',
                        'value' => function($model, $key, $index, $column) use (&$itemGridID)
                        {
                            return Editable::widget([
                                'name'=>'quantity_user',
                                'value' => !isset(Yii::$app->session['item'][$model->id]) ? $model->getItemQuantity() : Yii::$app->session['item'][$model->id],
                                'pjaxContainerId' => $itemGridID.'-wrapper',
                                'asPopover' => true,
                                'header' => Yii::t('app','Quantity'),
                                'options' => ['placeholder'=>Yii::t('app','Enter a number')],
                                'beforeInput' => function ($form, $widget) use (&$model) {
                                    echo Html::input('hidden','item',$model->id);
                                }
                            ]);
                        }
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'controller' => 'item',
                        'buttonOptions' => ['data-pjax' => '0']
                    ],
                    ['class' => 'yii\grid\CheckboxColumn'],
                ],
            ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= Html::submitButton(Yii::t('app', 'Accept'), ['class' => 'btn btn-success', 'id' => 'item-submit-modal','name' => 'item-submit-modal']); ?>
        </div>
        <div class="col-md-6">
            <?= Html::submitButton(Yii::t('app', 'Cancel'), ['data-dismiss' => 'modal','class' => 'btn btn-warning pull-right','id' => 'cancel-item-submit-modal','name' => 'cancel-item-submit-modal']); ?>
        </div>
    </div>

<?php
Modal::end();
?>