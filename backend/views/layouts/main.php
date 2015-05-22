<?php
use backend\assets\AdminLteAsset;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $content string */

//\backend\assets\AppAsset::register($this);
AdminLteAsset::register($this);
$user = Yii::$app->user->identity;
?>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body class="skin-blue">
    <?php $this->beginBody() ?>
    <header class="main-header">
        <a href="<?= Yii::$app->homeUrl ?>" class="logo"><?= Yii::$app->name ?></a>
        <nav class="navbar navbar-static-top" role="navigation">
            <a href="#" class="sidebar-toggle" data-toggle="tooltip" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <div class="navbar-custom-menu">
                <?= $this->render('//layouts/top-menu.php') ?>
            </div>
        </nav>
    </header>


    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="/images/user2-160x160.jpg" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p>
                        <?= Yii::t('app', 'Hello, {name}', ['name' => $user->username]) ?>
                    </p>

                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>
            <!-- search form -->
            <form action="#" method="get" class="sidebar-form">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
                </div>
            </form>
            <!-- /.search form -->
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <?= $this->render('//layouts/sidebar-menu') ?>
        </section>
        <!-- /.sidebar -->
    </aside>

    <div class="content-wrapper" style="min-height: 916px;">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <?= $this->title ?>
                <?php if (isset($this->params['subtitle'])) : ?>
                    <small><?= $this->params['subtitle'] ?></small>
                <?php endif; ?>
            </h1>
            <?= Breadcrumbs::widget(
                [
                    'homeLink' => [
                        'label' => '<i class="fa fa-dashboard"></i> ' . Yii::t('app', 'Home'),
                        'url' => ['/']
                    ],
                    'encodeLabels' => false,
                    'tag' => 'ol',
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : []
                ]
            ) ?>
        </section>

        <!-- Main content -->
        <section class="content">
            <?= \common\widgets\Alert::widget() ?>
            <?= $content ?>
        </section><!-- /.content -->
    </div>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>