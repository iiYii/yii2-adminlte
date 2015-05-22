<?php 

namespace backend\modules\srbac\controllers;

use Yii;
use yii\web\Controller;
use backend\modules\srbac\helpers\Pinyin;
use common\models\User;


class RoleController extends SrbacController
{

	public $auth;


	public function init()
	{
		parent::init();
		$this->auth = Yii::$app->authManager;
	}

	/**
	 * @title 权限列表
	 */
	public function actionIndex()
	{
		$roles = $this->auth->getRoles();
		$rules = $this->auth->getRules();
		return $this->render('role', ['roles'=>$roles, 'rules'=>$rules]);
	}

	/**
	 * @title 角色下的 所有用户
	 */
	public function actionUser($role_name)
	{
		$users = User::findAll(['status' => 10]);

		$users_info = [];
		foreach ($users as $k => $v) {
			$pin = strtoupper(substr(Pinyin::pinyin($v['username']), 0, 1));
			$users_info[$pin][$v['id']] = [
				'username' => $v['username'],
				'pinyin' => Pinyin::pinyin($v['username']),
				'is_sel' => $this->auth->getAssignment($role_name, $v['id']) ? 1 : 0
			];
		}

		// p($users_info);die;
		return $this->render('user', ['user'=>$users_info]);
	}

	/**
	 * @title 分配用户角色
	 */
	public function actionAssign()
	{
		$request = Yii::$app->request;
		$role_name = $request->post('role', '');
		$user_id = $request->post('user_id', '');
		$is_sel = $request->post('is_sel');



		$role = $this->auth->getRole($role_name);
		
		if (is_array($user_id)) {
			foreach ($user_id as $k => $v) {
				$this->auth->assign($role, $v);
			}
			$this->ajaxReturn(null, null, 1);
		}
		
		if ($is_sel=='true') { //删除 删除 的方法 是啥 
			if ($this->auth->revoke($role, $user_id)) {
				$this->ajaxReturn(null, null, 1);
			}
		} else { //增加
			if ($this->auth->assign($role, $user_id)) {
				$this->ajaxReturn(null, null, 1);
			}
		}
	}

	/**
	 * @title 添加角色
	 */
	public function actionCreate()
	{

		$info = $_GET['role'];
		if (empty($info['name'])) {
			return 0;
		}

		$role = $this->auth->getRole($info['name']);
		$new = false;
		if (empty($role)) {
			$role = $this->auth->createRole($info['name']);
			$new = true;
		}
		!empty($info['description']) && $role->description = $info['description'];
		!empty($info['rule_name']) && $role->ruleName = $info['rule_name'];
		!empty($info['data']) && $role->data = $info['data'];

		if ($new) {
			if($this->auth->add($role))
			{
				$this->ajaxReturn(null, null, 200);
			}
		} else {
			if ($this->auth->update($info['name'], $role)) {
				$this->ajaxReturn(null, null, 200);
			}
		}

	
		return 0;

	}

		/**
	 * @title 按角色取权限
	 */
	public function actionPermission($rolename='')
	{
		$permisions = $this->auth->getPermissions();
		$all = [];
		foreach ($permisions as $k => $v) {
			$all[] = $v->name;
		}
		$rolepermission = $this->auth->getPermissionsByRole($rolename);


		$assigned = [];
		$yet = $un = '';
		$option = ' <option value="%s">%s</option>';
		foreach ($rolepermission as $k => $v) {
			$assigned[] = $v->name;
			$yet .= sprintf($option, $v->name, $v->name);
		}

		$unassigned = array_diff($all, $assigned);
		foreach ($unassigned as $k =>$v) {
			$un .= sprintf($option, $v, $v);
		}
		$this->ajaxReturn(['yet'=>$yet, 'un'=>$un], null,  200);
	}
	/**
	 * @title 删除角色
	 */
	public function actionDelete($role_name)
	{
		$role = $this->auth->getRole($role_name);
		if ($this->auth->remove($role)) {
			$this->ajaxReturn(null, null, 1);
		}
		$this->ajaxReturn(null, '删除失败，请重试', 0);
	}

	/**
	 * @title 编辑角色
	 */
	public function actionEdit($role_name)
	{
		$role = $this->auth->getRole($role_name);
		if ($role) {
			$this->ajaxReturn($role, null, 1);
		} else {
			$this->ajaxReturn(null, '角色不存在', 0);
		}
		
	}
}