<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\money\MaskMoney;
use yii\helpers\Url;
use app\assets\TotalFieldAsset;

TotalFieldAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\CarPart */
/* @var $modelPrice app\models\Price */
/* @var $form yii\widgets\ActiveForm */
/* @var $sizes array */
/* @var $colors array */
/* @var $damages array */

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

$sizeUrl = \yii\helpers\Url::to(['car-part/size']);
$colorUrl = \yii\helpers\Url::to(['car-part/color']);
$damageUrl = \yii\helpers\Url::to(['car-part/damage']);
?>

<script>
    var f_price = "#<?= Html::getInputId($modelPrice,'price'); ?>-disp";
    var f_tax = "#<?= Html::getInputId($modelPrice,'tax'); ?>-disp";
    var f_total = "#<?= Html::getInputId($modelPrice,'total'); ?>-disp";
    var URL_PRICE = "<?= Url::to(['car-part/price']); ?>";
</script>

<div class="car-part-form">

    <?php $form = ActiveForm::begin(); ?>

    <?=
    $form->field($model, 'size_id')->widget(Select2::classname(), [
        'options' => ['placeholder' => Yii::t('app','Select an option ...')],
        'data' => $sizes,
        'pluginOptions' => [
            'allowClear' => true,
            'ajax' => [
                'url' => $sizeUrl,
                'dataType' => 'json'
            ],
        ],
    ]);
    ?>

    <?=
    $form->field($model, 'color_id')->widget(Select2::classname(), [
        'options' => ['placeholder' => Yii::t('app','Select an option ...')],
        'data' => $colors,
        'pluginOptions' => [
            'allowClear' => true,
            'ajax' => [
                'url' => $colorUrl,
                'dataType' => 'json'
            ],
        ],
    ]);
    ?>

    <?=
    $form->field($model, 'damage_id')->widget(Select2::classname(), [
        'options' => ['placeholder' => Yii::t('app','Select an option ...')],
        'data' => $damages,
        'pluginOptions' => [
            'allowClear' => true,
            'ajax' => [
                'url' => $damageUrl,
                'dataType' => 'json'
            ],
        ],
    ]);
    ?>

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
