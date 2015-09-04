<?php

/* @var $this yii\web\View */
/* @var $low_stock_items app\models\Item[] */
/* @var $empty_stock_items app\models\Item[] */

$this->title = Yii::$app->params['company'];
?>
<div class="site-index">

    <div class="jumbotron">
        <h1><?= Yii::t('app', 'Administrative System'); ?></h1>

        <p class="lead"><?= Yii::t('app', 'Inventory management and billing') ?>.</p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <div class="panel panel-warning">
                    <div class="panel-heading"><?= Yii::t('app', 'Low stock items') ?></div>
                    <div class="panel-body">
                        <ul>
                            <?php if (count($low_stock_items) > 0): ?>
                                <?php foreach ($low_stock_items as $item): ?>
                                    <li><?= $item->name; ?>: <?= $item->quantity ?></li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <li><?= Yii::t('app','No occurrences') ?></li>
                            <?php endif; ?>
                        </ul>

                        <p><a class="btn btn-default"
                              href="<?= \yii\helpers\Url::to(['item/index']) ?>"><?= Yii::t('app', 'See more') ?> &raquo;</a>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="panel panel-danger">
                    <div class="panel-heading"><?= Yii::t('app', 'Empty stock items') ?></div>
                    <div class="panel-body">
                        <ul>
                            <?php if (count($empty_stock_items) > 0): ?>
                                <?php foreach ($empty_stock_items as $item): ?>
                                    <li><?= $item->name; ?>: <?= $item->quantity ?></li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <li><?= Yii::t('app','No occurrences') ?></li>
                            <?php endif; ?>
                        </ul>

                        <p><a class="btn btn-default"
                              href="<?= \yii\helpers\Url::to(['item/index']) ?>"><?= Yii::t('app', 'See more') ?> &raquo;</a>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="panel panel-success">
                    <div class="panel-heading"><?= Yii::t('app', 'System alerts') ?></div>
                    <div class="panel-body">
                        <p><?= Yii::t('app', 'In developing') ?>...</p>

                        <p><a class="btn btn-default"
                              href="<?= \yii\helpers\Url::to(['log/index']) ?>"><?= Yii::t('app', 'See more') ?> &raquo;</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
