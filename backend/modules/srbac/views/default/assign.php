<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\SearchUser $searchModel
 */

$this->title = Yii::t('app', 'Permissions Manage');
?>

<div class="page-content-area assign">
    <!-- PAGE CONTENT BEGINS -->
    <div class="row">
        <div class="col-md-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">角色</h3>
                </div>
                <div class="panel-body">
                    <select class="form-control" id="role-select" size='18'>
                        <?php foreach ($roles as $k => $v): ?>
                            <option value="<?= $v->name ?>"><?= $v->name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-10">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">分配权限
                        <div class="pull-right">
                            <span class="badge badge-danger">添加<<>>删除</span>
                        </div>
                    </h3>
                </div>
                <div class="panel-body">
                    <div class="col-sm-5">
                        <p>拥有的权限</p>
                        <select class="form-control" id="yet" multiple="multiple" size='22'></select>
                    </div>
                    <div class="col-sm-1" style="margin-top:100px;">
                        <div class="btn-group btn-group-vertical">
                            <button class="btn btn-info handel" rel="add"><i class='fa fa-angle-double-left'></i>
                            </button>
                            <button class="btn btn-info handel" rel="del"><i class='fa fa-angle-double-right'></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <p>未拥有的权限</p>
                        <select class="form-control" id="un" multiple="multiple" size='22'></select>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /.row -->
</div>

<div class="urls hidden">
    <a href="<?= Url::toRoute('/srbac/default/role-permission'); ?>" class="permission"></a>
    <a href="<?= Url::toRoute('/srbac/default/assign-permission'); ?>" class="assign-permission"></a>
    <input name='csrf' value="<?= Yii::$app->request->getCsrfToken() ?>">
</div>