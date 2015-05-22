<?php
/**
 * author     : forecho <caizh@snsshop.com>
 * createTime : 2015/5/20 15:59
 * description:
 */

namespace backend\assets;

use yii\web\AssetBundle;

class AdminLteAsset extends AssetBundle
{
    public $sourcePath = '@vendor/bower/adminlte';
    public $css = [
        'dist/css/AdminLTE.css',
        'plugins/morris/morris.css',
        'dist/css/skins/_all-skins.min.css'
    ];
    public $js = [
        'plugins/morris/morris.js',
        'plugins/iCheck/icheck.js',
        'plugins/slimScroll/jquery.slimscroll.js',
        'dist/js/app.js'
    ];
    public $depends = [
        'backend\assets\AppAsset',
        'rmrevin\yii\fontawesome\AssetBundle',
    ];
}