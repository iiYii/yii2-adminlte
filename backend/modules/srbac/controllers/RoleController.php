<?php

namespace backend\modules\srbac\controllers;

use backend\modules\srbac\helpers\Pinyin;
use backend\modules\srbac\models\AuthItem;
use backend\modules\srbac\models\AuthItemSearch;
use Yii;
use common\models\User;
use yii\rbac\Role;


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

        $searchModel = new AuthItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get(), AuthItem::TYPE_ROLE);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'roles'=>$roles, 'rules'=>$rules
        ]);

		$roles = $this->auth->getRoles();
		$rules = $this->auth->getRules();
		return $this->render('index', ['roles'=>$roles, 'rules'=>$rules]);
	}

    /**
     * 添加角色
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AuthItem();
        $model->type = AuthItem::TYPE_ROLE;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $role = $this->auth->createRole($model->name);
            !empty($model->description) && $role->description = $model->description;
            !empty($model->rule_name) && $role->rule_name = $model->rule_name;
            !empty($model->data) && $role->data = $model->data;

            if($this->auth->add($role)){
                return $this->redirect('index');
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->name]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

	/**
	 * @title 添加子角色
	 */
	public function actionChild()
	{
		$roles = $this->auth->getRoles();
		return $this->render('child', ['roles'=>$roles]);
	}

	/**
	 * @title 添加删除子角色
	 */
	public function actionRoleChild()
	{
		$request = Yii::$app->request;
		$role_name = $request->post('role', '');
		$childs = $request->post('child');
		$method = $request->post('method', 'add');
		$role = $this->auth->getRole($role_name);

		$m = $method == 'add' ? 'addChild' : 'removeChild';

		foreach ($childs as $v) {
			$child = $this->auth->getRole($v);
			$this->auth->$m($role, $child);

		}

		$this->actionGetChild($role_name);
	}

	/**
	 * @title 取得一个角色的所有子角色
	 */
	public function actionGetChild($rolename)
	{

		if (!Yii::$app->request->isAjax) {
			echo 'wrong';die;
		}
		$roles = $this->auth->getRoles();
		unset($roles[$rolename]);
		$all_roles = array_keys($roles);

		$option = ' <option value="%s">%s</option>';

		$children = $this->auth->getChildren($rolename);
		$childs = [];
		$child = '';
		foreach ($children as $k => $v) {
			if($v instanceof Role) {
				array_push($childs, $v->name);
				$child .= sprintf($option, $v->name, $v->name);
			}
		}

		$no_child = array_diff($all_roles, $childs);

		$main_role = $this->auth->getRole($rolename);
		foreach ($no_child as $k => $v) {
			$role = $this->auth->getRole($v);
			if ($this->auth->hasChild($role, $main_role)) {
				unset($no_child[$k]);
			}
		}
		$other = '';
		foreach ($no_child as $k => $v) {
			$other .= sprintf($option, $v, $v);
		}

		$this->ajaxReturn(['child'=>$child, 'other'=>$other], null, 1);
	}

	/**
	 * @title 角色下的 所有用户
	 */
	public function actionUser($role_name)
	{

		$users = User::find()->where(['status' => 10])
							 //->andWhere('id>1')
                             ->orderBy('username')
							 ->all();
		$users_info = [];
		foreach ($users as $k => $v) {
			$pin = strtoupper(substr(Pinyin::pinyin($v['username']), 0, 1));
			$users_info[$pin][$v['id']] = [
				'username' => $v['username'],
				'pinyin' => Pinyin::pinyin($v['username']),
				'is_sel' => $this->auth->getAssignment($role_name, $v['id']) ? 1 : 0
			];
		}

		//print_r($users_info);die;
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

    protected function findModel($id)
    {
        if (($model = AuthItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

	/**
	 * @title 添加角色
	 */
	public function actionCreate2()
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
            print_r($role);
			if($this->auth->add($role))
			{
                die;
				//$this->ajaxReturn(null, null, 200);
			}
		} else {
			if ($this->auth->update($info['name'], $role)) {
				//$this->ajaxReturn(null, null, 200);
			}
		}
		return 0;
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