<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Damage */

$this->title = Yii::t('app', 'Create {modelClass}: ', ['modelClass' => Yii::t('app','Damage')]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Damages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="damage-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
