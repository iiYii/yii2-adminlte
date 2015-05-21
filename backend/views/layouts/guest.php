<?php
use yii\helpers\Html;
use common\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */

\backend\assets\AdminLteAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <title><?= Html::encode($this->title); ?></title>
    <?= Html::csrfMetaTags(); ?>
    <?php $this->head(); ?>


</head>
<body class="bg-white" style="min-height: 790px">
<?php $this->beginBody() ?>
<?= Alert::widget() ?>
<?= $content ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

