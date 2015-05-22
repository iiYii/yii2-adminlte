<?php
use common\widgets\Menu;

echo Menu::widget(
    [
        'options' => [
            'class' => 'sidebar-menu'
        ],
        'items' => [
            [
                'label' => Yii::t('app', 'Dashboard'),
                'url' => Yii::$app->homeUrl,
                'icon' => 'fa-dashboard',
                'active' => Yii::$app->request->url === Yii::$app->homeUrl
            ],
            [
                'label' => Yii::t('app', 'Settings'),
                'url' => ['#'],
                'icon' => 'fa fa-spinner',
                'options' => [
                    'class' => 'treeview',
                ],
                'items' => [
                    [
                        'label' => Yii::t('app', 'Basic'),
                        'url' => ['/basic/index'],
                        'icon' => 'fa fa-user',
                    ],
                    [
                        'label' => Yii::t('app', 'Advanced'),
                        'url' => ['/advanced/index'],
                        'icon' => 'fa fa-lock',
                    ],
                ],
            ],
            [
                'label' => Yii::t('app', 'System'),
                'url' => ['#'],
                'icon' => 'fa fa-cog',
                'options' => [
                    'class' => 'treeview',
                ],
                'items' => [
                    [
                        'label' => Yii::t('app', 'User'),
                        'url' => ['/user/index'],
                        'icon' => 'fa fa-user',
                        //'visible' => (Yii::$app->user->identity->username == 'admin'),
                    ],
                    [
                        'label' => Yii::t('app', 'Role'),
                        'url' => ['/role/index'],
                        'icon' => 'fa fa-lock',
                    ],
                ],
            ],
        ]
    ]
);