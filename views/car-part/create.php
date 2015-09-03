<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CarPart */

$this->title = Yii::t('app', 'Create {modelClass}: ', ['modelClass' => Yii::t('app','Car part')]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Car parts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="car-part-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
