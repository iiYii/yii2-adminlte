<?php
/**
 * author     : forecho <caizh@snsshop.com>
 * createTime : 2015/5/21 16:50
 * description: 
 */

namespace backend\modules\srbac\assets;

use yii\web\AssetBundle;

class SrbacAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/common.css',
    ];
    public $js = [
        'js/srbac.js'
    ];
    public $depends = [
        'backend\assets\AdminlteAsset',
    ];
}
