<?php

/* @var $this yii\web\View */
/* @var $low_stock_items app\models\Item[] */
/* @var $empty_stock_items app\models\Item[] */

$this->title = Yii::$app->params['company'];
?>
<div class="site-index">

    <div class="jumbotron">
        <h1><?= Yii::t('app','Administrative System'); ?></h1>

        <p class="lead"><?= Yii::t('app','Inventory management and billing') ?>.</p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2><?= Yii::t('app','Low stock items') ?></h2>

                <?php foreach ($low_stock_items as $item): ?>
                    <p><?= $item->name; ?>: <?= $item->quantity ?></p>
                <?php endforeach; ?>

                <p><a class="btn btn-default" href="<?= \yii\helpers\Url::to(['item/index']) ?>"><?= Yii::t('app','See more') ?> &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2><?= Yii::t('app','Empty stock items') ?></h2>

                <?php foreach ($empty_stock_items as $item): ?>
                    <p><?= $item->name; ?>: <?= $item->quantity ?></p>
                <?php endforeach; ?>

                <p><a class="btn btn-default" href="<?= \yii\helpers\Url::to(['item/index']) ?>"><?= Yii::t('app','See more') ?> &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2><?= Yii::t('app','System alerts') ?></h2>

                <p><?= Yii::t('app','In developing') ?>...</p>

                <p><a class="btn btn-default" href="<?= \yii\helpers\Url::to(['log/index']) ?>"><?= Yii::t('app','See more') ?> &raquo;</a></p>
            </div>
        </div>

    </div>
</div>
