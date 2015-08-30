<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\money\MaskMoney;
use yii\helpers\Url;
use app\assets\TotalFieldAsset;

TotalFieldAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\Item */
/* @var $modelPrice app\models\Price */
/* @var $form yii\widgets\ActiveForm */

$maskMoneyOptions = [
    'prefix' => 'Bs.',
    'suffix' => '',
    'affixesStay' => true,
    'thousands' => '.',
    'decimal' => ',',
    'precision' => 2,
    'allowZero' => true,
    'allowNegative' => false,
];

$maskPercentOptions = [
    'prefix' => '%',
    'suffix' => '',
    'affixesStay' => true,
    'thousands' => '.',
    'decimal' => ',',
    'precision' => 2,
    'allowZero' => true,
    'allowNegative' => false,
];

?>

<script>
    var f_price = "#<?= Html::getInputId($modelPrice,'price'); ?>-disp";
    var f_tax = "#<?= Html::getInputId($modelPrice,'tax'); ?>-disp";
    var f_total = "#<?= Html::getInputId($modelPrice,'total'); ?>-disp";
    var URL_PRICE = "<?= Url::to(['item/price']); ?>";
</script>

<div class="item-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'quantity')->textInput() ?>

    <?= $form->field($model, 'quantity_stock')->textInput() ?>

    <?= $form->field($modelPrice, 'price')->widget(MaskMoney::classname(), [
        'pluginOptions' => $maskMoneyOptions
    ]); ?>

    <?= $form->field($modelPrice, 'tax')->widget(MaskMoney::classname(), [
        'pluginOptions' => $maskPercentOptions
    ]); ?>

    <?= $form->field($modelPrice, 'total')->widget(MaskMoney::classname(), [
        'pluginOptions' => $maskMoneyOptions
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
