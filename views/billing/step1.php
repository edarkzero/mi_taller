<?php
use yii\helpers\Html;
use app\assets\BillingAsset;

/* @var $this yii\web\View */

BillingAsset::register($this);

$this->title = Yii::t('app', 'Billing') . ' ' . Yii::t('app', 'Step {n}', ['n' => 1]);

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Billing'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<h1><?= Html::encode($this->title) ?></h1>

<div class="row">
    <div class="col-md-2">
        <a href="javascript:loadImage()" class="btn btn-primary btn-raised car-slide-select" data-target="#car-slide" data-slide-to="0"><?= Yii::t('app','Left'); ?></a>
        <a href="javascript:void(0)" class="btn btn-primary btn-raised car-slide-select" data-target="#car-slide" data-slide-to="1"><?= Yii::t('app','Right'); ?></a>
        <a href="javascript:void(0)" class="btn btn-primary btn-raised car-slide-select" data-target="#car-slide" data-slide-to="2"><?= Yii::t('app','Rear'); ?></a>
        <a href="javascript:void(0)" class="btn btn-primary btn-raised car-slide-select" data-target="#car-slide" data-slide-to="3"><?= Yii::t('app','Front'); ?></a>
        <a href="javascript:void(0)" class="btn btn-primary btn-raised car-slide-select" data-target="#car-slide" data-slide-to="4"><?= Yii::t('app','Aerial'); ?></a>
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
                            'content' => '<img data-view="left" class="img-responsive center-block" usemap="#sedan-left-map" src="'.Yii::getAlias('@web').'/images/car-blueprint/sedan-left.png"/>
        <map name="sedan-left-map">
        <area id="asd" shape="poly" coords="761,130,749,118,697,115,670,104,608,77,554,61,496,55,428,55,390,59,353,68,303,90,241,125,251,133,302,101,343,79,398,63,459,60,518,65,567,76,607,93,625,105,626,108,607,121,614,136"  alt="" />
        <area shape="poly" coords="543,224,559,225,588,184,620,174,653,180,671,193,688,220,691,240,690,255,733,248,763,247,793,239,795,195,800,193,796,184,784,180,774,168,772,155,762,130,716,129,681,132,646,134,610,136,590,166,562,197,543,224"  alt="" />
        <area shape="poly" coords="232,247,231,263,557,261,558,223,544,225,525,240,507,243,232,247"  alt="" />
        <area shape="poly" coords="20,171,33,160,68,148,148,132,181,128,214,128,174,135,114,145,80,153,41,167,37,171"  alt="" />
        <area shape="poly" coords="232,245,223,207,205,185,179,175,155,172,132,181,114,197,101,226,98,240,99,252,97,259,9,249,10,243,35,241,52,239,66,213,10,217,10,208,5,206,23,185,46,164,98,147,168,135,242,126,251,133,243,146,238,167,238,203,249,244"  alt="" />
        <area shape="poly" coords="461,60,533,68,599,89,625,107,606,123,612,138,525,242,435,243,435,180,437,165,444,126,461,60"  alt="" />
        <area shape="poly" coords="249,243,238,207,238,163,244,138,344,75,404,61,459,59,438,151,435,242,249,243"  alt="" />
        </map>',
                            //'caption' => Yii::t('app','Left side view')
                        ],
                        [
                            'content' => '<img data-view="right" class="img-responsive center-block" src="'.Yii::getAlias('@web').'/images/car-blueprint/sedan-right.png"/>',
                            //'caption' => Yii::t('app','Right side view')
                        ],
                        [
                            'content' => '<img data-view="back" class="img-responsive center-block" src="'.Yii::getAlias('@web').'/images/car-blueprint/sedan-back.png"/>',
                            //'caption' => Yii::t('app','Rear view')
                        ],
                        [
                            'content' => '<img data-view="front" class="img-responsive center-block" src="'.Yii::getAlias('@web').'/images/car-blueprint/sedan-front.png"/>',
                            //'caption' => Yii::t('app','Front view')
                        ],
                        [
                            'content' => '<img data-view="air" class="img-responsive center-block" src="'.Yii::getAlias('@web').'/images/car-blueprint/sedan-air.png"/>',
                            //'caption' => Yii::t('app','Aerial view')
                        ],
                    ],
                    'controls' => false,
                    'clientOptions' => ['interval' => false],
                    'options' => ['class' => 'slide','style' => 'background-color:#FFFFFF','id' => 'car-slide']
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
                <h3 class="panel-title"><?= Yii::t('app', '{n_door} doors {car_type}', ['n_door' => 4, 'car_type' => Yii::t('app','Sedan')]); ?></h3>
            </div>
            <div class="panel-body car-select-option">
                <img data-car="sedan" class="img-responsive center-block" src="<?= Yii::getAlias('@web') ?>/images/car-blueprint/sedan-front.png"/>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-primary">
            <div class="panel-heading text-center">
                <h3 class="panel-title"><?= Yii::t('app', '{n_door} doors {car_type}', ['n_door' => 4, 'car_type' => Yii::t('app','Truck')]); ?></h3>
            </div>
            <div class="panel-body car-select-option">
                <img data-car="wagon" class="img-responsive center-block" src="<?= Yii::getAlias('@web') ?>/images/car-blueprint/wagon-front.png"/>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-primary">
            <div class="panel-heading text-center">
                <h3 class="panel-title"><?= Yii::t('app', '{n_door} doors {car_type}', ['n_door' => 4, 'car_type' => Yii::t('app','Compact')]); ?></h3>
            </div>
            <div class="panel-body car-select-option">
                <img data-car="sedan" class="img-responsive center-block" src="<?= Yii::getAlias('@web') ?>/images/car-blueprint/sedan-front.png"/>
            </div>
        </div>
    </div>
</div>