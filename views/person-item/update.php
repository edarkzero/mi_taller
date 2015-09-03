<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PersonItem */

$this->title = Yii::t('app', 'Update {modelClass}: ', ['modelClass' => Yii::t('app','Assignment')]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Item'), 'url' => ['item/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Assignment'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="person-item-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
