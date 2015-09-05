<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PersonItem */

$this->title = Yii::t('app', 'Reassign {modelClass}: ', ['modelClass' => Yii::t('app','Item')]) . ' ' . $model->item->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Item'), 'url' => ['item/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Assignment'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->item->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="person-item-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'items' => $items,
        'people' => $people
    ]) ?>

</div>
