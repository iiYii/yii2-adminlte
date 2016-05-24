<?php

/**
 * author     : forecho <caizh@chexiu.cn>
 * createTime : 2015/12/22 11:55
 * description:
 */
use yii\web\Response;

if (!function_exists('app')) {
    /**
     * App或App的定义组件
     *
     * @param null $component Yii组件名称
     * @param bool $throwException 获取未定义组件是否报错
     * @return null|object|\yii\console\Application|\yii\web\Application
     * @throws \yii\base\InvalidConfigException
     */
    function app($component = null, $throwException = true)
    {
        if ($component === null) {
            return Yii::$app;
        }
        return Yii::$app->get($component, $throwException);
    }
}
if (!function_exists('t')) {
    /**
     * i18n 国际化
     * @param $category
     * @param $message
     * @param array $params
     * @param null $language
     * @return string
     */
    function t($category, $message, $params = [], $language = null)
    {
        return Yii::t($category, $message, $params, $language);
    }
}

if (!function_exists('user')) {
    /**
     * User组件或者(设置|返回)identity属性
     *
     * @param null|string|array $attribute idenity属性
     * @return \yii\web\User|string|array
     */
    function user($attribute = null)
    {
        if ($attribute === null) {
            return Yii::$app->getUser();
        }
        if (is_array($attribute)) {
            return Yii::$app->getUser()->getIdentity()->setAttributes($attribute);
        }
        return Yii::$app->getUser()->getIdentity()->{$attribute};
    }
}
if (!function_exists('request')) {
    /**
     * Request组件或者通过Request组件获取GET值
     *
     * @param string $key
     * @param mixed $default
     * @return \yii\web\Request|string|array
     */
    function request($key = null, $default = null)
    {
        if ($key === null) {
            return Yii::$app->getRequest();
        }
        return Yii::$app->getRequest()->getQueryParam($key, $default);
    }
}
if (!function_exists('response')) {
    /**
     * Response组件或者通过Response组织内容
     *
     * @param string $content 响应内容
     * @param string $format 响应格式
     * @return \yii\web\Response
     */
    function response($content = '', $format = Response::FORMAT_HTML, $status = null)
    {
        $response = Yii::$app->getResponse();
        if (func_num_args() !== 0) {
            $response->format = $format;
            if ($status !== null) {
                $response->setStatusCode($status);
            }
            if ($format === Response::FORMAT_HTML) {
                $response->content = $content;
            } else {
                $response->data = $content;
            }
        }
        return $response;
    }
}

if (!function_exists('params')) {
    /**
     * params 组件或者通过 params 组件获取GET值
     * @param $key
     * @return mixed|\yii\web\Session
     */
    function params($key)
    {
        return Yii::$app->params[$key];
    }
}

// 如果在注册一个全局函数, 将会更简便

if (!function_exists('storage')) {
    /**
     * Storage组件或Storage组件Disk实例
     *
     * @param null $disk
     * @return \weyii\filesystem\Manager|\weyii\filesystem\FilesystemInterface
     */
    function storage($disk = null)
    {
        if ($disk === null) {
            return Yii::$app->get('storage');
        }

        return Yii::$app->get('storage')->getDisk($disk);
    }
}

if (!function_exists('session')) {
    /**
     * Session组件或者通过Session组件获取GET值
     * @param null $key
     * @return mixed|\yii\web\Session
     */
    function session($key = null)
    {
        if ($key === null) {
            return Yii::$app->session;
        }
        return Yii::$app->getSession()->get($key);
    }
}

if (!function_exists('cache')) {
    /**
     * Cache组件或者通过Cache组件获取GET值
     * @param null $key
     * @return mixed|\yii\caching\Cache
     */
    function cache($key = null)
    {
        if ($key === null) {
            return Yii::$app->cache;
        }
        return Yii::$app->getCache()->get($key);
    }
}


/**
 * 调试专用
 * @param $message
 * @param bool|true $debug
 */
function pr($message, $debug = true)
{
    echo '<pre>';
    print_r($message);
    echo '</pre>';
    if ($debug) {
        die;
    }
}