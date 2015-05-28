<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\srbac\models\AuthItem */

$this->title = Yii::t('app', 'Update ') . Yii::t('app', '{name}', ['name' => $model->name]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Role Manage'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
echo $this->render('_form', [
    'model' => $model,
]);
