<?php
/**
 * author     : forecho <caizh@snsshop.com>
 * createTime : 2015/5/21 16:50
 * description: 
 */

namespace backend\assets;

use yii\web\AssetBundle;

class BowerAsset extends AssetBundle
{
    public $sourcePath = '@bower';
    public $css = [
        'ionicons/css/ionicons.min.css',
    ];
    public $js = [

    ];
}
