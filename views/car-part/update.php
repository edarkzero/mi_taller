<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CarPart */
/* @var $modelPrice app\models\Price */

$this->title = Yii::t('app', 'Update {modelClass}: ', ['modelClass' => Yii::t('app','Car part')]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Car parts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="car-part-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelPrice'  => $modelPrice
    ]) ?>

</div>
