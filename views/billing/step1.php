<?php
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = Yii::t('app', 'Billing') . ' ' . Yii::t('app', 'Step {n}', ['n' => 1]);

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Billing'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

<p>
    <?= Yii::t('app', 'Car parts selection'); ?>
</p>

<div class="col-xs-12">
    <?= \yii\bootstrap\Carousel::widget([
        'items' => [
            [
                'content' => '<img class="img-responsive center-block" src="http://placehold.it/400x200.png"/>',
                'caption' => '<h4>This is title</h4><p>This is the caption text</p>'
            ],
            [
                'content' => '<img class="img-responsive center-block" src="http://placehold.it/350x200.png"/>',
                'caption' => '<h4>This is the other title</h4>'
            ],
        ],
        'controls' => [
            '<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span><span class="sr-only">'.Yii::t('app','Previous').'</span>',
            '<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span><span class="sr-only">'.Yii::t('app','Next').'</span>'
        ],
        'clientOptions' => ['interval' => false],
        'options' => ['class' => 'slide']
    ]);
    ?>
</div>