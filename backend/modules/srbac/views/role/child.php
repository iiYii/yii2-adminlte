<?php

use yii\helpers\Html;
use yii\helpers\Url;
$this->title = '添加子角色';
$this->params['breadcrumbs'][] = ['label' => '管理授权项', 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => '分配授权', 'url' => ['default/assign']];
$this->params['breadcrumbs'][] = ['label' => '角色管理', 'url' => ['role/index']];
//$this->params['breadcrumbs'][] = 'Update';
?>

<div class="page-content-area child">
    <!-- PAGE CONTENT BEGINS -->
    <div class="row">

        <div class="col-md-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">角色</h3>
                </div>
                <div class="panel-body">
                    <select class="form-control" id="role-select" size='18'>
                        <?php foreach ($roles as $k => $v):?>
                            <option value="<?=$v->name ?>"><?=$v->name?></option>
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
                        <select class="form-control" id="child" multiple="multiple" size='22'>

                        </select>
                    </div>
                    <div class="col-sm-1" style="margin-top:100px;">
                        <div class="btn-group btn-group-vertical">
                            <button class="btn btn-info handel" rel="add"><i class='fa fa-angle-double-left'></i></button>
                            <button class="btn btn-info handel" rel="del"><i class='fa fa-angle-double-right'></i></button>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <select class="form-control" id="other" multiple="multiple" size='22'>

                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.row -->
</div><!-- /.page-content-area -->

<div class="urls hidden">
    <a href="<?=Url::toRoute('/srbac/role/role-child');?>" class="role-child"></a>
    <a href="<?=Url::toRoute('/srbac/role/get-child');?>" class="get-child"></a>
    <input name='csrf' value="<?=Yii::$app->request->getCsrfToken()?>">
</div>