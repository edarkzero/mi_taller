<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="shortcut icon" href="<?= Yii::getAlias('@web') ?>/images/favicon.ico">
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->params['company'],
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => \Yii::t('app','Home'), 'url' => ['/site/index']],
            ['label' => \Yii::t('app','Billing'), 'url' => ['/bill/index'],'active' => Yii::$app->controller->id == 'bill'],
            [
                'label' => Yii::t('app','Item'),
                'items' => [
                    ['label' => \Yii::t('app','Admin'), 'url' => ['/item/index'],'active' => Yii::$app->controller->id == 'item'],
                    ['label' => \Yii::t('app','Assign'), 'url' => ['/person-item/index'],'active' => Yii::$app->controller->id == 'person-item'],
                ],
                'active' =>  Yii::$app->controller->id == 'item' || Yii::$app->controller->id == 'person-item'
            ],
            [
                'label' => Yii::t('app','Employed'),
                'items' => [
                    ['label' => \Yii::t('app','Job'), 'url' => ['/job/index'],'active' => Yii::$app->controller->id == 'job'],
                    ['label' => \Yii::t('app','Person'), 'url' => ['/person/index'],'active' => Yii::$app->controller->id == 'person'],
                ],
                'active' =>  Yii::$app->controller->id == 'job' || Yii::$app->controller->id == 'person'
            ],
            [
                'label' => Yii::t('app','Configuration'),
                'items' => [
                    ['label' => \Yii::t('app','Part'), 'url' => ['/car-part/index'],'active' => Yii::$app->controller->id == 'car-part'],
                    ['label' => \Yii::t('app','Size'), 'url' => ['/size/index'],'active' => Yii::$app->controller->id == 'size'],
                    ['label' => \Yii::t('app','Damage'), 'url' => ['/damage/index'],'active' => Yii::$app->controller->id == 'damage'],
                    ['label' => \Yii::t('app','Color'), 'url' => ['/color/index'],'active' => Yii::$app->controller->id == 'color'],
                ],
                //'active' =>  Yii::$app->controller->id == 'job' || Yii::$app->controller->id == 'person'
            ],
            ['label' => \Yii::t('app','Log'), 'url' => ['/log/index'],'active' => Yii::$app->controller->id == 'log'],
            /*['label' => \Yii::t('app','About'), 'url' => ['/site/about']],
            ['label' => \Yii::t('app','Contact'), 'url' => ['/site/contact']],*/
            Yii::$app->user->isGuest ?
                ['label' => 'Login', 'url' => ['/site/login']] :
                [
                    'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ],
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Yii::$app->params['creator'].' '.date('Y') ?></p>
        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
