<?php

namespace backend\modules\srbac;

use Yii;
use yii\base\module;
use yii\web\BadRequestHttpException;

class SrbacModule extends Module
{
    public $layout = 'column';
	public function init()
	{
		parent::init();
        \Yii::configure($this, require(__DIR__ . '/config.php'));
	}
}