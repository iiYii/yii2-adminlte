<?php 

/**
 * @title 权限基类
 * @auth wsq cboy868@163.com
 */

namespace backend\modules\srbac\controllers;

use Yii;
use yii\web\Controller;

class SrbacController extends Controller{

    public function ajaxReturn($data = null, $info = '', $success = true) {
        header('Content-type: application/json');
        $all = [
        	'status' => $success, 
        	'info' 	=> $info, 
        	'data'	=> $data,
        	'csrf'	=> Yii::$app->request->getCsrfToken()
        ];
        echo  json_encode($all);
        exit;
    }
    /**
     * @title 权限验证
     */
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {

            $ac = $this->getFullAction($action);
            $auth = Yii::$app->authManager;
            if (($auth->getPermission($ac) && !\Yii::$app->user->can($ac)) && !\Yii::$app->user->id==1) {
                throw new BadRequestHttpException(Yii::t('yii', '您无权进行此操作'));
            }
            return true;
        } else {
            return false;
        }
    }
    /**
     * @title 取得权限全名
     */
    private function getFullAction($action)
    {
        $namespace = str_replace('\controller', '', \Yii::$app->controllerNamespace);

        $mod = \Yii::$app->controller->module !== null ? \Yii::$app->controller->module->id : "";
        $controller = \Yii::$app->controller->id;
        $ac = $action->id;
        
        if (!empty($mod)) {
            return $mod.'@'.$controller.'-'.$ac;
        }
        return $namespace.'-'.$controller.'-'.$ac;
    }
}