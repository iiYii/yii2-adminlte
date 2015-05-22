<?php
use yii\helpers\Html;
use common\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */

\backend\assets\AdminLteAsset::register($this);
\backend\assets\BowerAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <title><?= Html::encode($this->title); ?></title>
    <?= Html::csrfMetaTags(); ?>
    <?php $this->head(); ?>


</head>
<body class="login-page" style="min-height: 790px">
    <?php $this->beginBody() ?>
        <div class="login-box">
            <div class="login-logo">
                <a href="../../index2.html"><b>Admin</b>LTE</a>
            </div>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

