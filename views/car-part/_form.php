<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CarPart */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="car-part-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'size_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'color_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'damage_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
