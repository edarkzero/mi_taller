<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use app\assets\BillPersonAsset;
use kartik\editable\Editable;

/* @var $this yii\web\View */
/* @var $model app\models\Person */
/* @var $billSearchModel app\models\BillSearch */
/* @var $billDataProvider */

$this->title = $model->getFullName();
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'People'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$billGridId = 'bill-grid';
$billGridWrapper = $billGridId.'-wrapper';

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
                <?= Html::a(Yii::t('app', 'Print voucher'), null, ['id' => 'voucher-btn','class' => 'btn btn-primary','data-pjax' => '0']) ?>
            </p>
        </div>
        <div class="clearfix"></div>

        <?php Pjax::begin(['id' => $billGridWrapper]); ?>

        <?= \yii\grid\GridView::widget([
            'id' => $billGridId,
            'dataProvider' => $billDataProvider,
            'filterModel' => $billSearchModel,
            'tableOptions' => ['class' => 'table table-bordered table-hover table-select table-select-all'],
            'rowOptions' => function($model, $key, $index, $grid)
            {
                return $model->getBillPersonalPaid() == 1 ? ['class' => 'info'] : null;
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
                    'label' => Yii::t('app','Total'),
                    'value' => function ($model, $key, $index, $column)
                    {
                        return Yii::$app->formatter->asCurrency($model->getPriceTotal());
                    }
                ],
                [
                    'attribute' => 'bp_description',
                    'label' => Yii::t('app','Description'),
                    'format' => 'raw',
                    'value' => function ($model, $key, $index, $column) use (&$billGridWrapper)
                    {
                        //return $model->getBillPersonalAmount();
                        return Editable::widget([
                            'name'=>'bp_description',
                            'value' => $model->getBillPersonalDescription(),
                            'pjaxContainerId' => $billGridWrapper,
                            'asPopover' => true,
                            'header' => Yii::t('app','Description'),
                            'options' => ['placeholder'=>Yii::t('app','Enter a description')],
                            'beforeInput' => function ($form, $widget) use (&$model) {
                                echo Html::input('hidden','bill',$model->id);
                                echo Html::input('hidden','person',Yii::$app->request->queryParams['id']);
                            }
                        ]);
                    }
                ],
                [
                    'attribute' => 'bp_amount',
                    'label' => Yii::t('app','Amount'),
                    'format' => 'raw',
                    'value' => function ($model, $key, $index, $column) use (&$billGridWrapper)
                    {
                        //return $model->getBillPersonalAmount();
                        return Editable::widget([
                            'name'=>'bp_amount',
                            'value' => $model->getBillPersonalAmount(),
                            'pjaxContainerId' => $billGridWrapper,
                            'asPopover' => true,
                            'header' => Yii::t('app','Amount'),
                            'options' => ['placeholder'=>Yii::t('app','Enter a number')],
                            'beforeInput' => function ($form, $widget) use (&$model) {
                                echo Html::input('hidden','bill',$model->id);
                                echo Html::input('hidden','person',Yii::$app->request->queryParams['id']);
                            }
                        ]);
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
                    'filter' => Html::activeCheckbox($billSearchModel,'bp_paid',['label' => ''])
                ],
                /*[
                    'class' => 'yii\grid\ActionColumn',
                    'controller' => 'bill-personal',
                    'buttons' => [
                        'update' => function ($url, $model, $key) {
                            if($model->getBillPersonalId() != "")
                                return Html::a('Update', \yii\helpers\Url::to(['bill-personal/update','id' => $model->getBillPersonalId()]));
                        },
                    ],
                    'buttonOptions' => ['data-pjax' => '0']
                ],*/
                ['class' => 'yii\grid\CheckboxColumn'],
            ],
        ]); ?>

        <?php Pjax::end(); ?>

    </div>

</div>

<?php
\yii\bootstrap\Modal::begin([
    'header' => '<h2>' . Yii::t('app','Voucher') . '</h2>',
    'options' => ['id' => 'modal-voucher']
]);
?>

    <div class="row">
        <div class="col-md-12">
            <?php Pjax::begin(['id' => 'voucher-wrapper']); ?>
                <p><?= Yii::t('app','Total').': '.yii::$app->formatter->asCurrency($total) ?></p>
            <?php Pjax::end(); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= Html::submitButton(Yii::t('app', 'Accept'), ['class' => 'btn btn-success', 'id' => 'bp-submit-modal','name' => 'item-submit-modal']); ?>
        </div>
        <div class="col-md-6">
            <?= Html::submitButton(Yii::t('app', 'Cancel'), ['data-dismiss' => 'modal','class' => 'btn btn-warning pull-right','id' => 'cancel-bp-submit-modal','name' => 'cancel-item-submit-modal']); ?>
        </div>
    </div>

<?php
\yii\bootstrap\Modal::end();
?>