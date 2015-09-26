<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\assets\GridViewSelectionAsset;
use \yii\bootstrap\Modal;
use \yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BillSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $itemSearchModel app\models\ItemSearch */
/* @var $itemDataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Bill Items');
$this->params['breadcrumbs'][] = $this->title;

GridViewSelectionAsset::register($this);

$billGridID = 'bill-grid';
$itemGridID = 'item-grid';

?>
<div class="bill-item-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div>
        <h1 class="pull-left"><?= Html::encode(Yii::t('app', 'Bills')) ?></h1>
        <p class="pull-right">
            <?= Html::a(Yii::t('app', 'Assign selected'), '#', ['class' => 'btn btn-success','onclick' => 'GridViewGetSelected("#'.$billGridID.'")']) ?>
        </p>
    </div>
    <div class="clearfix"></div>

    <?php Pjax::begin(['id' => $billGridID.'-wrapper']); ?>

    <?= GridView::widget([
        'id' => $billGridID,
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table-bordered table-hover table-select table-select-one'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'price_total',
                'label' => $searchModel->getAttributeLabel('price_id'),
                'value' => function ($model, $key, $index, $column)
                {
                    return Yii::$app->formatter->asCurrency($model->getPriceTotal());
                }
            ],
            'discount:currency',

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
                'tableOptions' => ['class' => 'table table-bordered table-hover table-select table-select-all'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'name',
                    'quantity',

                    ['class' => 'yii\grid\CheckboxColumn'],
                ],
            ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= Html::submitButton(Yii::t('app', 'Accept'), ['class' => 'btn btn-success', 'id' => 'item-submit-modal']); ?>
        </div>
        <div class="col-md-6">
            <?= Html::submitButton(Yii::t('app', 'Cancel'), ['data-dismiss' => 'modal','class' => 'btn btn-warning','id' => 'cancel-item-submit-modal']); ?>
        </div>
    </div>

<?php
Modal::end();
?>