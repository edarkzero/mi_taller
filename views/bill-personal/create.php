<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\BillPersonal */

$this->title = Yii::t('app', 'Create Bill Personal');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bill Personals'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bill-personal-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
