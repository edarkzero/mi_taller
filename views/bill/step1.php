<?php
use yii\helpers\Html;
use app\assets\BillingAsset;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use kartik\select2\Select2;
use kartik\money\MaskMoney;

/* @var $this yii\web\View */
/* @var $carPart app\models\CarPart */
/* @var $colors array */
/* @var $sizes array */
/* @var $damages array */

BillingAsset::register($this);

$this->title = Yii::t('app', 'Create {modelClass}: ', ['modelClass' => Yii::t('app', 'Bill')]);
$sizeUrl = \yii\helpers\Url::to(['car-part/size']);
$colorUrl = \yii\helpers\Url::to(['car-part/color']);
$damageUrl = \yii\helpers\Url::to(['car-part/damage']);

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

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Billing'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<script>
    var money_default_value = "<?= Yii::$app->formatter->asCurrency(0.00) ?>";
</script>
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-md-2">
            <a href="javascript:void(0)" class="btn btn-primary btn-raised car-slide-select" data-target="#car-slide" data-slide-to="0"><?= Yii::t('app', 'Left'); ?></a>
            <a href="javascript:void(0)" class="btn btn-primary btn-raised car-slide-select" data-target="#car-slide" data-slide-to="1"><?= Yii::t('app', 'Right'); ?></a>
            <a href="javascript:void(0)" class="btn btn-primary btn-raised car-slide-select" data-target="#car-slide" data-slide-to="2"><?= Yii::t('app', 'Rear'); ?></a>
            <a href="javascript:void(0)" class="btn btn-primary btn-raised car-slide-select" data-target="#car-slide" data-slide-to="3"><?= Yii::t('app', 'Front'); ?></a>
            <a href="javascript:void(0)" class="btn btn-primary btn-raised car-slide-select" data-target="#car-slide" data-slide-to="4"><?= Yii::t('app', 'Aerial'); ?></a>
            <a href="javascript:highlightAll($('area'),true,true)" class="btn btn-primary btn-raised car-slide-select"><?= Yii::t('app', 'All'); ?></a>
            <a href="javascript:highlightAll($('area'),false,true)" class="btn btn-primary btn-raised car-slide-select"><?= Yii::t('app', 'None'); ?></a>
        </div>
        <div class="col-md-10">
            <div class="panel panel-primary">
                <div class="panel-heading text-center">
                    <h3 class="panel-title"><?= Yii::t('app', 'Car parts selection'); ?></h3>
                </div>
                <div class="panel-body">
                    <?= \yii\bootstrap\Carousel::widget([
                        'items' => [
                            [
                                'content' => '<img data-view="left" class="img-responsive center-block" usemap="#map-left" src="' . Yii::getAlias('@web') . '/images/car-blueprint/medium-left.png"/><map name="map-left" id="map-left"></map>',
                                //'caption' => Yii::t('app','Left side view')
                            ],
                            [
                                'content' => '<img data-view="right" class="img-responsive center-block" usemap="#map-right" src="' . Yii::getAlias('@web') . '/images/car-blueprint/medium-right.png"/><map name="map-right" id="map-right"></map>',
                                //'caption' => Yii::t('app','Right side view')
                            ],
                            [
                                'content' => '<img data-view="back" class="img-responsive center-block" src="' . Yii::getAlias('@web') . '/images/car-blueprint/medium-back.png"/>',
                                //'caption' => Yii::t('app','Rear view')
                            ],
                            [
                                'content' => '<img data-view="front" class="img-responsive center-block" src="' . Yii::getAlias('@web') . '/images/car-blueprint/medium-front.png"/>',
                                //'caption' => Yii::t('app','Front view')
                            ],
                            [
                                'content' => '<img data-view="air" class="img-responsive center-block" src="' . Yii::getAlias('@web') . '/images/car-blueprint/medium-air.png"/>',
                                //'caption' => Yii::t('app','Aerial view')
                            ],
                        ],
                        'controls' => false,
                        'clientOptions' => ['interval' => false],
                        'options' => ['class' => 'slide', 'style' => 'background-color:#FFFFFF', 'id' => 'car-slide']
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-danger text-center">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Yii::t('app', 'Total'); ?></h3>
                </div>
                <div class="panel-body">
                    <strong id="total-disp"><?= Yii::$app->formatter->asCurrency(0.00); ?></strong>
                    <?= Html::submitButton('<i class="mdi-content-archive"></i>', ['class' => 'btn btn-fab btn-fab-mini btn-raised btn-sm btn-material-red', 'id' => 'bill-submit', 'title' => Yii::t('app', 'Save')]) ?>
                    <?= Html::submitButton('<i class="mdi-content-content-paste"></i>', ['class' => 'btn btn-fab btn-fab-mini btn-raised btn-sm btn-material-red', 'id' => 'bill-submit-print', 'title' => Yii::t('app', 'Save and print')]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading text-center">
                    <h3 class="panel-title"><?= Yii::t('app', '{size} Car', ['size' => Yii::t('app','Tiny')]); ?></h3>
                </div>
                <div class="panel-body car-select-option">
                    <img data-car-full="6" data-car="tiny" class="img-responsive center-block" src="<?= Yii::getAlias('@web') ?>/images/car-blueprint/tiny-front.png"/>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading text-center">
                    <h3 class="panel-title"><?= Yii::t('app', '{size} Car', ['size' => Yii::t('app','Medium')]); ?></h3>
                </div>
                <div class="panel-body car-select-option">
                    <img data-car-full="7" data-car="medium" class="img-responsive center-block" src="<?= Yii::getAlias('@web') ?>/images/car-blueprint/medium-front.png"/>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading text-center">
                    <h3 class="panel-title"><?= Yii::t('app', '{size} Car', ['size' => Yii::t('app','Big')]); ?></h3>
                </div>
                <div class="panel-body car-select-option">
                    <img data-car-full="8" data-car="big" class="img-responsive center-block" src="<?= Yii::getAlias('@web') ?>/images/car-blueprint/big-front.png"/>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading text-center">
                    <h3 class="panel-title"><?= Yii::t('app','Pickup'); ?></h3>
                </div>
                <div class="panel-body car-select-option">
                    <img data-car-full="9" data-car="pickup" class="img-responsive center-block" src="<?= Yii::getAlias('@web') ?>/images/car-blueprint/pickup-front.png"/>
                </div>
            </div>
        </div>
    </div>

<?php
Modal::begin([
    'header' => '<h2>' . Yii::t('app', 'Part details') . '</h2>',
    'options' => ['id' => 'part-detail-modal', 'tabindex' => false]
]);

$form = ActiveForm::begin([
    'id' => 'item-form-modal',
    'options' => ['class' => 'form-horizontal'],
]) ?>
<?=
$form->field($carPart, 'size_id')->widget(Select2::classname(), [
    'options' => ['placeholder' => Yii::t('app', 'Select an option ...')],
    'data' => $sizes,
    'theme' => Select2::THEME_BOOTSTRAP,
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
$form->field($carPart, 'color_id')->widget(Select2::classname(), [
    'options' => ['placeholder' => Yii::t('app', 'Select an option ...')],
    'data' => $colors,
    'theme' => Select2::THEME_BOOTSTRAP,
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
$form->field($carPart, 'damage_id')->widget(Select2::classname(), [
    'options' => ['placeholder' => Yii::t('app', 'Select an option ...')],
    'data' => $damages,
    'theme' => Select2::THEME_BOOTSTRAP,
    'pluginOptions' => [
        'allowClear' => true,
        'ajax' => [
            'url' => $damageUrl,
            'dataType' => 'json'
        ],
    ],
]);
?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Create'), ['class' => 'btn btn-success', 'id' => 'item-submit-modal']) ?>
    </div>

<?php
ActiveForm::end();
Modal::end();

Modal::begin([
    'header' => '<h2>' . Yii::t('app', '¿Do you want to apply a discount?') . '</h2>',
    'options' => ['id' => 'bill-discount-modal']
]);
?>

    <div class="row">
        <div class="col-md-12">
            <?=
            MaskMoney::widget([
                'id' => 'bill-discount',
                'name' => 'bill-discount',
                'value' => 0.00,
                'pluginOptions' => $maskMoneyOptions
            ]);
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= Html::submitButton(Yii::t('app', 'Accept'), ['class' => 'btn btn-success', 'id' => 'discount-submit-modal']); ?>
        </div>
        <div class="col-md-6">
            <?= Html::submitButton(Yii::t('app', 'Cancel'), ['data-dismiss' => 'modal','class' => 'btn btn-warning','id' => 'cancel-discount-submit-modal']); ?>
        </div>
    </div>

<?php
Modal::end();
?>