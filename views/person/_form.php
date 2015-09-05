<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Person */
/* @var $jobModel app\models\Job */
/* @var $jobs array */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $jobsUrl = \yii\helpers\Url::to(['person/jobs']) ?>

<div class="person-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'document')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'firstname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lastname')->textInput(['maxlength' => true]) ?>

    <?=
    $form->field($jobModel, 'name')->widget(Select2::classname(), [
        'options' => ['placeholder' => Yii::t('app','Select an option ...')],
        'theme' => Select2::THEME_BOOTSTRAP,
        'pluginOptions' => [
            'allowClear' => true,
            'ajax' => [
                'url' => $jobsUrl,
                'dataType' => 'json'
            ],
        ],
    ])->label($model->getAttributeLabel('job_id'));
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
