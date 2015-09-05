<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PersonItem */
/* @var $items array */
/* @var $people array */

$this->title = Yii::t('app', 'Assign {modelClass}: ', ['modelClass' => Yii::t('app','Item')]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Assignment'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="person-item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'items' => $items,
        'people' => $people
    ]) ?>

</div>
