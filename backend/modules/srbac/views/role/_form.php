<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\srbac\models\AuthItem */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'name')->textInput([
    'maxlength'   => true,
    'placeholder' => '只接受英文字母'
]) ?>

<?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'rule_name')->dropDownList(
    Yii::$app->authManager->getRules(),
    ['prompt' => '无']
) ?>

<?= $form->field($model, 'data')->textarea(['rows' => 6]) ?>

<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

