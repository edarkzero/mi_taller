<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\assets\GridViewSelectionAsset;
use \yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BillSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Bill Items');
$this->params['breadcrumbs'][] = $this->title;

GridViewSelectionAsset::register($this);

$gridID = 'bill-grid';

?>
<div class="bill-item-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div>
        <h1 class="pull-left"><?= Html::encode(Yii::t('app', 'Bills')) ?></h1>
        <p class="pull-right">
            <?= Html::a(Yii::t('app', 'Assign selected'), '#', ['class' => 'btn btn-success','onclick' => 'GridViewGetSelected("#'.$gridID.'")']) ?>
        </p>
    </div>
    <div class="clearfix"></div>

    <?= GridView::widget([
        'id' => $gridID,
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
            'created_at:datetime',
            'updated_at:datetime',

            ['class' => 'yii\grid\ActionColumn'],
            ['class' => 'yii\grid\CheckboxColumn'],
        ],
    ]); ?>

</div>

<?php
Modal::begin([
    'header' => '<h2>' . 'test' . '</h2>',
    'options' => ['id' => 'modal-assignment']
]);
?>

    <div class="row">
        <div class="col-md-12">
            <?=
            'test'
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= Html::submitButton(Yii::t('app', 'Accept'), ['class' => 'btn btn-success', 'id' => 'discount-submit-modal']); ?>
        </div>
        <div class="col-md-6">
            <?= Html::submitButton(Yii::t('app', 'Cancel'), ['data-dismiss' => 'modal','class' => 'btn btn-warning','id' => 'cancel-discount-submit-modal']); ?>
        </div>
    </div>

<?php
Modal::end();
?>