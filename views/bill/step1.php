<?php
use yii\helpers\Html;
use app\assets\BillingAsset;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $carPart app\models\CarPart */
/* @var $colors array */
/* @var $sizes array */
/* @var $damages array */

BillingAsset::register($this);

$this->title = Yii::t('app', 'Billing') . ' ' . Yii::t('app', 'Step {n}', ['n' => 1]);
$sizeUrl = \yii\helpers\Url::to(['car-part/size']);
$colorUrl = \yii\helpers\Url::to(['car-part/color']);
$damageUrl = \yii\helpers\Url::to(['car-part/damage']);

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Billing'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-md-2">
            <a href="javascript:void(0)" class="btn btn-primary btn-raised car-slide-select" data-target="#car-slide" data-slide-to="0"><?= Yii::t('app', 'Left'); ?></a>
            <a href="javascript:void(0)" class="btn btn-primary btn-raised car-slide-select" data-target="#car-slide" data-slide-to="1"><?= Yii::t('app', 'Right'); ?></a>
            <a href="javascript:void(0)" class="btn btn-primary btn-raised car-slide-select" data-target="#car-slide" data-slide-to="2"><?= Yii::t('app', 'Rear'); ?></a>
            <a href="javascript:void(0)" class="btn btn-primary btn-raised car-slide-select" data-target="#car-slide" data-slide-to="3"><?= Yii::t('app', 'Front'); ?></a>
            <a href="javascript:void(0)" class="btn btn-primary btn-raised car-slide-select" data-target="#car-slide" data-slide-to="4"><?= Yii::t('app', 'Aerial'); ?></a>
            <a href="javascript:highlightAll($('area'),true)" class="btn btn-primary btn-raised car-slide-select"><?= Yii::t('app', 'All'); ?></a>
            <a href="javascript:highlightAll($('area'),false)" class="btn btn-primary btn-raised car-slide-select"><?= Yii::t('app', 'None'); ?></a>
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
                                'content' => '<img data-view="left" class="img-responsive center-block" usemap="#map-left" src="' . Yii::getAlias('@web') . '/images/car-blueprint/sedan-left.png"/><map name="map-left" id="map-left"></map>',
                                //'caption' => Yii::t('app','Left side view')
                            ],
                            [
                                'content' => '<img data-view="right" class="img-responsive center-block" usemap="#map-right" src="' . Yii::getAlias('@web') . '/images/car-blueprint/sedan-right.png"/><map name="map-right" id="map-right"></map>',
                                //'caption' => Yii::t('app','Right side view')
                            ],
                            [
                                'content' => '<img data-view="back" class="img-responsive center-block" src="' . Yii::getAlias('@web') . '/images/car-blueprint/sedan-back.png"/>',
                                //'caption' => Yii::t('app','Rear view')
                            ],
                            [
                                'content' => '<img data-view="front" class="img-responsive center-block" src="' . Yii::getAlias('@web') . '/images/car-blueprint/sedan-front.png"/>',
                                //'caption' => Yii::t('app','Front view')
                            ],
                            [
                                'content' => '<img data-view="air" class="img-responsive center-block" src="' . Yii::getAlias('@web') . '/images/car-blueprint/sedan-air.png"/>',
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
        <div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading text-center">
                    <h3 class="panel-title"><?= Yii::t('app', '{n_door} doors {car_type}', ['n_door' => 4, 'car_type' => Yii::t('app', 'Sedan')]); ?></h3>
                </div>
                <div class="panel-body car-select-option">
                    <img data-car="sedan" class="img-responsive center-block" src="<?= Yii::getAlias('@web') ?>/images/car-blueprint/sedan-front.png"/>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading text-center">
                    <h3 class="panel-title"><?= Yii::t('app', '{n_door} doors {car_type}', ['n_door' => 4, 'car_type' => Yii::t('app', 'Truck')]); ?></h3>
                </div>
                <div class="panel-body car-select-option">
                    <img data-car="wagon" class="img-responsive center-block" src="<?= Yii::getAlias('@web') ?>/images/car-blueprint/wagon-front.png"/>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading text-center">
                    <h3 class="panel-title"><?= Yii::t('app', '{n_door} doors {car_type}', ['n_door' => 4, 'car_type' => Yii::t('app', 'Compact')]); ?></h3>
                </div>
                <div class="panel-body car-select-option">
                    <img data-car="sedan" class="img-responsive center-block" src="<?= Yii::getAlias('@web') ?>/images/car-blueprint/sedan-front.png"/>
                </div>
            </div>
        </div>
    </div>

<?php
Modal::begin([
    'header' => '<h2>' . Yii::t('app', 'Part details') . '</h2>',
    'options' => ['id' => 'part-detail-modal','tabindex' => false]
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
        <?= Html::submitButton(Yii::t('app', 'Create'), ['class' => 'btn btn-success']) ?>
    </div>

<?php
ActiveForm::end();
Modal::end();
?>