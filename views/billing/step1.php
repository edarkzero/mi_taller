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
        <a href="javascript:void(0)" class="btn btn-primary btn-raised car-slide-select" data-target="#car-slide" data-slide-to="0"><?= Yii::t('app','Left'); ?></a>
        <a href="javascript:void(0)" class="btn btn-primary btn-raised car-slide-select" data-target="#car-slide" data-slide-to="1"><?= Yii::t('app','Right'); ?></a>
        <a href="javascript:void(0)" class="btn btn-primary btn-raised car-slide-select" data-target="#car-slide" data-slide-to="2"><?= Yii::t('app','Rear'); ?></a>
        <a href="javascript:void(0)" class="btn btn-primary btn-raised car-slide-select" data-target="#car-slide" data-slide-to="3"><?= Yii::t('app','Front'); ?></a>
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
                            'content' => '<img class="img-responsive center-block" src="'.Yii::getAlias('@web').'/images/car-blueprint/sedan-left.png"/>',
                            //'caption' => Yii::t('app','Left side view')
                        ],
                        [
                            'content' => '<img class="img-responsive center-block" src="'.Yii::getAlias('@web').'/images/car-blueprint/sedan-right.png"/>',
                            //'caption' => Yii::t('app','Right side view')
                        ],
                        [
                            'content' => '<img class="img-responsive center-block" src="'.Yii::getAlias('@web').'/images/car-blueprint/sedan-back.png"/>',
                            //'caption' => Yii::t('app','Rear view')
                        ],
                        [
                            'content' => '<img class="img-responsive center-block" src="'.Yii::getAlias('@web').'/images/car-blueprint/sedan-front.png"/>',
                            //'caption' => Yii::t('app','Front view')
                        ],
                    ],
                    'controls' => [
                        '<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span><span class="sr-only">' . Yii::t('app', 'Previous') . '</span>',
                        '<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span><span class="sr-only">' . Yii::t('app', 'Next') . '</span>'
                    ],
                    'clientOptions' => ['interval' => false],
                    'options' => ['class' => 'slide','style' => 'background-color:#F0FFFF','id' => 'car-slide']
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
            <div class="panel-body">
                <img class="img-responsive center-block" src="<?= Yii::getAlias('@web') ?>/images/car-blueprint/sedan-front.png"/>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-primary">
            <div class="panel-heading text-center">
                <h3 class="panel-title"><?= Yii::t('app', '{n_door} doors {car_type}', ['n_door' => 4, 'car_type' => Yii::t('app','Truck')]); ?></h3>
            </div>
            <div class="panel-body">
                <img class="img-responsive center-block" src="<?= Yii::getAlias('@web') ?>/images/car-blueprint/sedan-front.png"/>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-primary">
            <div class="panel-heading text-center">
                <h3 class="panel-title"><?= Yii::t('app', '{n_door} doors {car_type}', ['n_door' => 4, 'car_type' => Yii::t('app','Compact')]); ?></h3>
            </div>
            <div class="panel-body">
                <img class="img-responsive center-block" src="<?= Yii::getAlias('@web') ?>/images/car-blueprint/sedan-front.png"/>
            </div>
        </div>
    </div>
</div>