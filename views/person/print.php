<?php
/**
 * @var $person \app\models\Person;
 * @var $billPersonal \app\models\BillPersonal[];
 * @var $this \yii\base\View;
 */

$total = 0.00;
?>

<h1><?= Yii::t('app', 'Voucher'); ?></h1>

<p><?= Yii::t('app','Name').': '.$person->getFullName(); ?></p>
<br>

<?php foreach($billPersonal as $bp): ?>
    <?php $total += $bp->amount; ?>
    <p><?= Yii::t('app','Description').': '.$bp->description; ?></p>
    <p><?= Yii::t('app','Amount').': '.Yii::$app->formatter->asCurrency($bp->amount); ?></p>
    <br>
<?php endforeach; ?>

<p><b><?= Yii::t('app','Total').': '.Yii::$app->formatter->asCurrency($total); ?></b></p>