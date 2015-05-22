

<?php

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;


//NavBar::begin([
//    'brandLabel' => 'My Company',
//    'brandUrl' => Yii::$app->homeUrl,
//    'options' => [
//        'class' => 'navbar-inverse navbar-fixed-top',
//    ],
//]);
$menuItems = [
    [
        'label' => Yii::t('app', 'Logout') . '(' . Yii::$app->user->identity->username . ')',
        'url' => ['/site/logout'],
        'linkOptions' => ['data-method' => 'post']
    ]
];
echo Nav::widget([
    'options' => ['class' => 'nav navbar-nav navbar-right'],
    'items' => $menuItems,
]);

$menuItemsMain = [
    [
        'label' => '<i class="fa fa-cog"></i> ' . Yii::t('app', 'Blog'),
        'url' => ['#'],
        'active' => false,
        'items' => [
            [
                'label' => '<i class="fa fa-user"></i> ' . Yii::t('app', 'Catalog'),
                'url' => ['/blog/blog-catalog'],
            ],
            [
                'label' => '<i class="fa fa-user-md"></i> ' . Yii::t('app', 'Post'),
                'url' => ['/blog/blog-post'],
            ],
            [
                'label' => '<i class="fa fa-user-md"></i> ' . Yii::t('app', 'Comment'),
                'url' => ['/blog/blog-comment'],
            ],
            [
                'label' => '<i class="fa fa-user-md"></i> ' . Yii::t('app', 'Tag'),
                'url' => ['/blog/blog-tag'],
            ],
        ],
    ],
    [
        'label' => '<i class="fa fa-cog"></i> ' . Yii::t('app', 'Cms'),
        'url' => ['#'],
        'active' => false,
        'items' => [
            [
                'label' => '<i class="fa fa-user"></i> ' . Yii::t('app', 'Catalog'),
                'url' => ['/blog/default/blog-catalog'],
            ],
            [
                'label' => '<i class="fa fa-user-md"></i> ' . Yii::t('app', 'Post'),
                'url' => ['/blog/default/blog-post'],
            ],
            [
                'label' => '<i class="fa fa-user-md"></i> ' . Yii::t('app', 'Comment'),
                'url' => ['/blog/default/blog-comment'],
            ],
            [
                'label' => '<i class="fa fa-user-md"></i> ' . Yii::t('app', 'Tag'),
                'url' => ['/blog/default/blog-tag'],
            ],
        ],
    ],
    [
        'label' => '<i class="fa fa-cog"></i> ' . Yii::t('app', 'System'),
        'url' => ['#'],
        'active' => false,
        'items' => [
            [
                'label' => '<i class="fa fa-user"></i> ' . Yii::t('app', 'User'),
                'url' => ['/user'],
            ],
            [
                'label' => '<i class="fa fa-lock"></i> ' . Yii::t('app', 'Role'),
                'url' => ['/role'],
            ],
        ],
    ],
];
echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-left'],
    'items' => $menuItemsMain,
    'encodeLabels' => false,
]);

//NavBar::end();

