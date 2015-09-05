<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Person */
/* @var $jobModel app\models\Job */
/* @var $jobs array */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => Yii::t('app','Person'),
]) . ' ' . $model->getFullName();
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'People'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->getFullName(), 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="person-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'jobModel' => $jobModel
    ]) ?>

</div>
