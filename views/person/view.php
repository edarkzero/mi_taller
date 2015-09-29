<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Person */
/* @var $billPersonalSearchModel app\models\BillPersonalSearch */
/* @var $billPersonalDataProvider */

$this->title = $model->getFullName();
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'People'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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
            <h1 class="pull-left"><?= Html::encode(Yii::t('app', 'Bills')) ?></h1>
            <p class="pull-right">
                <?= Html::a(Yii::t('app', 'Assign selected'), '#', ['class' => 'btn btn-success','id' => 'select-button']) ?>
            </p>
        </div>
        <div class="clearfix"></div>

        <?php Pjax::begin(['id' => 'bill-grid-wrapper']); ?>

        <?= \yii\grid\GridView::widget([
            'id' => 'bill-grid',
            'dataProvider' => $billPersonalDataProvider,
            'filterModel' => $billPersonalSearchModel,
            'tableOptions' => ['class' => 'table table-bordered table-hover table-select table-select-one'],
            /*'rowOptions' => function($model, $key, $index, $grid)
            {
                return $model->haveItems() ? ['class' => 'info'] : null;
            },*/
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                [
                    'attribute' => 'personal_name',
                    'label' => $billPersonalSearchModel->getAttributeLabel('personal_id'),
                    'value' => function ($model, $key, $index, $column)
                    {
                        return $model->personal->getFullName();
                    }
                ],
                'description:text',
                'amount:currency',
                [
                    'attribute' => 'paid',
                    'label' => $billPersonalSearchModel->getAttributeLabel('paid'),
                    'format' => 'raw',
                    'value' => function ($model, $key, $index, $column)
                    {
                        return Html::checkbox('',$model->paid);
                    },
                    'filter' => Html::activeCheckbox($billPersonalSearchModel,'paid',['label' => ''])
                ],

                [
                    'class' => 'yii\grid\ActionColumn',
                    'controller' => 'bill',
                    'buttonOptions' => ['data-pjax' => '0']
                ],
                ['class' => 'yii\grid\CheckboxColumn'],
            ],
        ]); ?>

        <?php Pjax::end(); ?>

    </div>

</div>
