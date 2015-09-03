<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Size */

$this->title = Yii::t('app', 'Create {modelClass}: ', ['modelClass' => Yii::t('app','Size')]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sizes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="size-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
