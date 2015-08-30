<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $jobModel app\models\Job */
/* @var $model app\models\Person */

$this->title = Yii::t('app', 'Create {modelClass}: ', ['modelClass' => Yii::t('app','Person')]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'People'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="person-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'jobModel' => $jobModel
    ]) ?>

</div>
