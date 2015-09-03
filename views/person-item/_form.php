<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\PersonItem */
/* @var $form yii\widgets\ActiveForm */
/* @var $items array */
/* @var $people array */

$personUrl = \yii\helpers\Url::to(['person-item/person']);
$itemUrl = \yii\helpers\Url::to(['person-item/item']);
?>

<div class="person-item-form">

    <?php $form = ActiveForm::begin(); ?>

    <?=
    $form->field($model, 'item_id')->widget(Select2::classname(), [
        'options' => ['placeholder' => Yii::t('app','Select an option ...')],
        'data' => $items,
        'pluginOptions' => [
            'allowClear' => true,
            'ajax' => [
                'url' => $itemUrl,
                'dataType' => 'json'
            ],
        ],
    ]);
    ?>

    <?=
    $form->field($model, 'person_id')->widget(Select2::classname(), [
        'options' => ['placeholder' => Yii::t('app','Select an option ...')],
        'data' => $people,
        'pluginOptions' => [
            'allowClear' => true,
            'ajax' => [
                'url' => $personUrl,
                'dataType' => 'json'
            ],
        ],
    ]);
    ?>

    <?= $form->field($model,'amount'); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
