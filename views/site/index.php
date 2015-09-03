<?php

/* @var $this yii\web\View */

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

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="<?= \yii\helpers\Url::to(['item/index']) ?>"><?= Yii::t('app','See more') ?> &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2><?= Yii::t('app','Empty stock items') ?></h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="<?= \yii\helpers\Url::to(['item/index']) ?>"><?= Yii::t('app','See more') ?> &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2><?= Yii::t('app','System alerts') ?></h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="<?= \yii\helpers\Url::to(['log/index']) ?>"><?= Yii::t('app','See more') ?> &raquo;</a></p>
            </div>
        </div>

    </div>
</div>
