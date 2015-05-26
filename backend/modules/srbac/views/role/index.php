<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\SearchUser $searchModel
 */

$this->title = '角色管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-content">

    <div class="page-content-area">
        <p>
            <a href="#modal-form" role="button" class="blue btn btn-danger btn-minier" data-toggle="modal"> 添加角色 </a>
            <?= Html::a(Yii::t('app', 'Create Role'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?= \yii\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel'  => $searchModel,
            'columns'      => [
                'name',
                'description',
                'rule_name',
                'data',
                'created_at:datetime',
                'updated_at:datetime',
                [
                    'header'     => Yii::t('app', 'Actions'),
                    'class'      => 'yii\grid\ActionColumn',
                    'template'   => '{view} {update} {delete} {config} {add-child}',
                    'buttons'    => [
                        'config' => function ($url, $model) {
                            $customurl = Yii::$app->getUrlManager()->createUrl(['log/view']);
                            return \yii\helpers\Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $customurl,
                                ['title' => Yii::t('yii', 'View'), 'data-pjax' => '0']);
                        }
                    ],
                    'urlCreator' => function ($action, $model, $key, $index) {
                        $link = '#';
                        switch ($action) {
                            case 'view':
                                $link = Yii::$app->getUrlManager()->createUrl(['/srbac/role/view', 'name' => $model->name]);
                                break;
                            case 'update':
                                $link = Yii::$app->getUrlManager()->createUrl(['/srbac/role/update', 'name' => $model->name]);
                                break;
                            case 'delete':
                                $link = Yii::$app->getUrlManager()->createUrl(['/srbac/role/delete', 'name' => $model->name]);
                                break;
                            case 'config':
                                $link = Yii::$app->getUrlManager()->createUrl(['/srbac/role/delete', 'name' => $model->name]);
                                break;
                            case 'add-child':
                                $link = Yii::$app->getUrlManager()->createUrl(['/srbac/role/delete', 'name' => $model->name]);
                                break;
                        }
                        return $link;
                    },
                ],
                //['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>

        <div class="row">
            <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                <div class="row">
                    <div class="col-xs-12">
                        <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>角色名</th>
                                <th>描述</th>
                                <th class="hidden-480">规则名</th>

                                <th>
                                    <i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>
                                    数据
                                </th>
                                <th class="hidden-480">添加时间</th>
                                <th width="25%" class="hidden-480"></th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php foreach ($roles as $v): ?>
                                <tr>
                                    <td>
                                        <a href="#"><?= $v->name ?></a>
                                    </td>

                                    <td class="hidden-480"><?= $v->description ?></td>
                                    <td><?= $v->ruleName ?></td>

                                    <td class="hidden-480">
                                        <span class="label label-sm label-warning"><?= $v->data ?></span>
                                    </td>
                                    <td><?= date('Y/m/d', $v->createdAt) ?></td>
                                    <td class="hidden-480">
                                        <div class="hidden-sm hidden-xs btn-group">
                                            <a href="#edit-form" role="button" class="btn btn-xs btn-info editrole"
                                               data-toggle="modal"
                                               rel="<?= Url::to(['role/edit', 'role_name' => $v->name]); ?>">
                                                <i class="ace-icon fa fa-pencil bigger-120"></i>编辑
                                            </a>

                                            <a class="btn btn-xs btn-danger del"
                                               href="<?= Url::to(['role/delete', 'role_name' => $v->name]); ?>">
                                                <i class="ace-icon fa fa-trash-o bigger-120"></i>删除
                                            </a>
                                            <a href="<?= Url::to(['role/user', 'role_name' => $v->name]) ?>"
                                               class='btn btn-info btn-xs'>选择用户</a>
                                            <a href="<?= Url::to(['role/child', 'role_name' => $v->name]) ?>"
                                               class='btn btn-info btn-xs'>添加子角色</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.span -->
                </div>
                <!-- /.row -->
                <div class="hr hr-18 dotted hr-double"></div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.page-content-area -->
</div>
<div id="modal-form" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="blue bigger">请填写如下信息</h4>
            </div>

            <div class="modal-body">
                <form id="roleform">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">

                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right">中文名</label>

                                <div>
                                    <input name="role[description]" placeholder="角色中文名">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right">codename</label>

                                <div>
                                    <input name="role[name]" class="input-large" type="text" placeholder="角色名"/>
									<span class="help-inline">
										<span class="middle">只接受英文字母</span>
									</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right">选择规则</label>

                                <div>
                                    <select name="role[rule_name]">
                                        <option value="">无</option>
                                        <?php foreach ($rules as $k => $v): ?>
                                            <option value="<?= $k; ?>"><?= $k; ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right">规则数据 </label>

                                <div>
                                    <input name="role[data]" placeholder="data">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button class="btn btn-sm" data-dismiss="modal">
                    <i class="ace-icon fa fa-times"></i>
                    Cancel
                </button>

                <button class="btn btn-sm btn-primary add-role" type="button">
                    <i class="ace-icon fa fa-check"></i>
                    Save
                </button>
            </div>
        </div>
    </div>
</div><!-- PAGE CONTENT ENDS -->

<div id="edit-form" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="blue bigger">请填写如下信息</h4>
            </div>

            <div class="modal-body">
                <form id="roledit">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">

                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right">中文名</label>

                                <div>
                                    <input name="role[description]" placeholder="角色中文名">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right">codename</label>

                                <div>
                                    <input name="role[name]" class="input-large" type="text" placeholder="角色名"/>
									<span class="help-inline">
										<span class="middle">只接受英文字母</span>
									</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right">选择规则</label>

                                <div>
                                    <select name="role[rule_name]">
                                        <option value="">无</option>
                                        <?php foreach ($rules as $k => $v): ?>
                                            <option value="<?= $k; ?>"><?= $k; ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right">规则数据 </label>

                                <div>
                                    <input name="role[data]" placeholder="data">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button class="btn btn-sm" data-dismiss="modal">
                    <i class="ace-icon fa fa-times"></i>
                    Cancel
                </button>

                <button class="btn btn-sm btn-primary edit-role" type="button">
                    <i class="ace-icon fa fa-check"></i>
                    Save
                </button>
            </div>
        </div>
    </div>
</div><!-- PAGE CONTENT ENDS -->

<div class="urls hidden">
    <a href="<?= Url::toRoute('/srbac/role/create2'); ?>" class="create-role"></a>
</div>