<?php 

namespace backend\modules\srbac\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;

class DefaultController extends SrbacController
{
	//很有用的东西
	// echo Yii::$app->controllerNamespace;
	//echo $this->action->id;die;
	//echo $this->id;die;


	/**
	 * @title 权限列表
	 */
	public function actionIndex()
	{
		$actions = $this->_getAllMethods();
		return $this->render('index', ['classes'=>$actions]);
		
	}

	/**
	 * @title 分配权限
	 */
	public function actionAssign()
	{
		$auth = Yii::$app->authManager;
		$roles = $auth->getRoles();
		return $this->render('assign', ['roles'=>$roles]);
	}

	/**
	 * @title 配置角色权限 
	 */
	public function actionAssignPermission()
	{
		// p($_POST);
		//$this->ajaxReturn(null, null, 1);
		$auth = Yii::$app->authManager;

		$request = Yii::$app->request;
		$role_name = $request->post('role', '');
		$actions = $request->post('action', '');
		$method = $request->post('method', 'add');

		// $actions = explode(',', $action);
		$role = $auth->getRole($role_name);

		$m = $method == 'add' ? 'addChild' : 'removeChild';


		foreach ($actions as $v) {
			$permision = $auth->getPermission($v);
			$auth->$m($role, $permision);
		}
		$this->actionRolePermission($role_name[0]);
		
	}

	/**
	 * 创建许可
	 * @title 创建许可
	 */
	public function actionCreatePermission()
	{
		if (Yii::$app->request->isAjax) {
			$request = Yii::$app->request;
			$permision = $request->get('permission');
			$des = $request->get('des', '');
			$check = $request->get('check');
			if (empty($permision)) {
				return 0;
			}
			// p($check);die;
			$auth = Yii::$app->authManager;

	        
	        if ($check==='true') {
	        	$inDb = $auth->getPermission($permision);
	        	if ($inDb) {
	        		$inDb->description = $des;
	        		if ($auth->update($permision, $inDb)) {
	        			return 200;
	        		}
	        	} else {
	        		$createPermission = $auth->createPermission($permision);
		        	$createPermission->description = $des;
		        	if ($auth->add($createPermission)) {
			        	return 200;
			        }
	        	}
	        	
	        } else {
	        	$per = $auth->getPermission($permision);
	        	if ($auth->remove($per)) {
		        	return 200;
		        }
	        }
		}
	}

	/**
	 * @title 取得所有 controller
	 */
	private function _getClasses()
	{
		$sys_module = ['debug', 'gii'];
		$modules = Yii::$app->getModules();
		foreach ($modules as $k => $v) {
			if (in_array($k, $sys_module)) {
				continue;
			}
			$mod = Yii::$app->getModule($k);
			$namespace = str_replace('\\', '/', $mod->controllerNamespace);
			$dir = Yii::getAlias('@'.$namespace);
			$classes['mod'][$k] = $this->_scan($dir);
		}

		$module = \Yii::$app->controller->module;

		//在配置中添加的要接受控制的命名空间
		$namespaces = $module->params['srbacPath'];

		//当前所在命名空间的控制器
		$currentNamespace = str_replace('\\', '/', \Yii::$app->controllerNamespace);
		array_push($namespaces, $currentNamespace);

		$module = \Yii::$app->controller->module;
		foreach ($namespaces as $k=>$v) {
			$namespace = str_replace('\\', '/', $v);
			$dir = Yii::getAlias('@'.$namespace);
			$key = str_replace('/controllers', '', $namespace);
			$classes['other'][$key] = $this->_scan($dir);
		}
		return $classes;
	}

	/**
	 * @title 取得所有方法
	 */
	private function _getAllMethods()
	{
		$namespaces = $this->_getClasses();

		$module_controllers = $namespaces['mod'];
		$other_controllers = $namespaces['other'];

		foreach ($module_controllers as $k => $v) {
			$mod = \Yii::$app->getModule($k);
			$namespace = $mod->controllerNamespace;
			if (!is_array($v)) {
				continue;
			}
			foreach ($v as $key => $val) {
				$controller_namespace = $namespace .'\\'.$val.'Controller';
				$action = $this->_getMethods($controller_namespace);
				!empty($action) && $actions['mod'][$k.'@'.$val] = $action;
			}
		}

		foreach ($other_controllers as $k => $v) {
			if (!is_array($v)) {
				continue;
			}
			$namespace = $k.'\\controllers';
			foreach ($v as $key => $val) {
				$controller_namespace = $namespace .'\\'.$val.'Controller';
				$actions['other'][$k.'-'.$val] = $this->_getMethods($controller_namespace);
			}
		}

		$actions = $this->_isInDb($actions);
		return $actions;
	}

	
	/**
	 * @title 取得一个类的所有公共方法
	 */
	private function _getMethods($controller_namespace)
	{

		$actions = [];
		$class = new \ReflectionClass($controller_namespace);//建立反射类
		$methods  = $class->getMethods(\ReflectionMethod::IS_PUBLIC);
		$filter = ['actions', 'behaviors'];
		foreach ($methods as $method) {
			if ($method->class ==$controller_namespace && !in_array($method->name, $filter)) {
				preg_match('/\* @title(.*)/', $method->getDocComment(), $matches); 
				$actions[$method->name] = [
					'des' => isset($matches[1]) ? $matches[1] : '',
					'name'=> substr($method->name, 0, 6) == 'action' ? substr($method->name,6) : $method->name
				];
			}
		}
		return $actions;
	}

	/**
	 * @title 判断数组中的动作是否存在数据库中
	 */
	private function _isInDb($control_actions)
	{
		$auth = Yii::$app->authManager;
		$model_actions = $auth->getPermissions();
		$action_k_v = ArrayHelper::getColumn($model_actions, 'description');

		foreach ($control_actions as $k => $value) {
			foreach ($value as $key => $val) {
				foreach ($val as $ac=>$v) {
					$action = $key.'-'.$v['name'];
					if (array_key_exists($action, $action_k_v) !== false) {
						$control_actions[$k][$key][$ac]['check']=true;
						!empty($action_k_v[$key.'-'.$v['name']]) && 
							$control_actions[$k][$key][$ac]['des'] = $action_k_v[$key.'-'.$v['name']];
					}
				}
			}
		}
		return $control_actions;
	}

	
	/**
	 * @title 扫描指定目录下文件
	 */
	private function _scan($dir)
	{
		$classes = array_diff(\scandir($dir), ['.','..']);
		foreach ($classes as $k => &$v) {
			if (substr($v, -14) != 'Controller.php') {
				unset($classes[$k]);
			}
			$v = substr($v, 0, -14);
		}unset($v);
		return $classes;
	}
}