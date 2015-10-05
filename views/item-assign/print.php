<?php
/**
 * @var $bill \app\models\Bill;
 * @var $this \yii\base\View;
 */
?>

<h1><?= Yii::t('app', 'Items'); ?></h1>

<?php if ($bill->billItems): ?>
    <?php $result = 0.00; ?>
    <?php foreach ($bill->billItems as $billItems): ?>
        <?php $result += (double)$billItems->item->getTotal() * (double)$billItems->quantity; ?>
        <p><?= $billItems->item->name . ': ' . Yii::$app->formatter->asCurrency($billItems->item->getTotal()) . ' x ' . $billItems->quantity . ' = ' . Yii::$app->formatter->asCurrency((double)$billItems->item->getTotal() * (double)$billItems->quantity); ?></p>
    <?php endforeach; ?>
<?php endif; ?>

<p><b><?= Yii::t('app', 'Total') . ': ' . Yii::$app->formatter->asCurrency($result); ?></b></p>

<h1><?= Yii::t('app', 'Personal'); ?></h1>

<?php if ($bill->billPersonals): ?>
    <?php $result2 = 0.00; ?>
    <?php foreach ($bill->billPersonals as $billPersonal): ?>
        <?php $result2 += $billPersonal->amount; ?>
        <p><?= $billPersonal->personal->getFullName() . ': ' . Yii::$app->formatter->asCurrency($billPersonal->amount); ?></p>
    <?php endforeach; ?>
<?php endif; ?>

<p><b><?= Yii::t('app', 'Total') . ': ' . Yii::$app->formatter->asCurrency($result2); ?></b></p>

<h1><?= Yii::t('app', 'Summary'); ?></h1>

<p><?= Yii::t('app','Items').': '.Yii::$app->formatter->asCurrency($result) ?></p>
<p><?= Yii::t('app','Personal').': '.Yii::$app->formatter->asCurrency($result2) ?></p>
<p><b><?= Yii::t('app', 'Total') . ': ' . Yii::$app->formatter->asCurrency($result+$result2); ?></b></p>
<br>
<p><b><?= Yii::t('app', 'Bill') . ': ' . Yii::$app->formatter->asCurrency($bill->getPriceTotal()); ?></b></p>
<p><b><?= Yii::t('app', 'Outgoings') . ': ' . Yii::$app->formatter->asCurrency($bill->getOutgoings()); ?></b></p>
<p><b><?= Yii::t('app', 'Gainings') . ': ' . Yii::$app->formatter->asCurrency($bill->getGainings()); ?></b></p>