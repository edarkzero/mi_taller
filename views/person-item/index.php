<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PersonItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Assignment');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Item'), 'url' => ['item/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="person-item-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create {modelClass}: ', ['modelClass' => Yii::t('app','Assignment')]), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Admin {modelClass}: ', ['modelClass' => Yii::t('app','Items')]), ['item/index'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'item_name',
                'label' => $searchModel->getAttributeLabel('item'),
                'value' => function ($model, $key, $index, $column)
                {
                    return $model->getItemName();
                }
            ],
            [
                'attribute' => 'person_name',
                'label' => $searchModel->getAttributeLabel('person'),
                'value' => function ($model, $key, $index, $column)
                {
                    return $model->getPersonName();
                }
            ],
            'amount',
            'created_at:datetime',
            'updated_at:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
