<?php

use yii\helpers\Html;
use yii\helpers\Url;
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\SearchUser $searchModel
 */

$this->title = '权限管理';
?>

<div class="breadcrumbs" id="breadcrumbs">
    <script type="text/javascript">
        try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){ }
    </script>

    <ul class="breadcrumb">
        <li>
            <a href="<?=Url::to(['default/index'])?>" class='btn btn-success btn-minier'>管理授权项</a>
            <a href="<?=Url::to(['default/assign'])?>" class='btn btn-success btn-minier'>分配授权</a>
            <a href="<?=Url::to(['role/index'])?>" class='btn btn-success btn-minier'>角色管理</a>
        </li>
    </ul><!-- /.breadcrumb -->
    <!-- /section:basics/content.searchbox -->
</div>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <?= Html::encode($this->title) ?>
                <small>
                    <i class="ace-icon fa fa-angle-double-right"></i>
                    在此列表可以对用户进行修改、删除等操作
                </small>
            </h1>
        </div><!-- /.page-header -->

        <!-- PAGE CONTENT BEGINS -->
        <div class="row">
            <div class="col-sm-2 widget-container-col ui-sortable">
                <h3>角色</h3>
                <select class="form-control" id="roleselect" size='18'>
                    <?php foreach ($roles as $k => $v):?>
                        <option value="<?=$v->name ?>"><?=$v->name?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-sm-4 widget-container-col ui-sortable">
                <h3>已分配</h3>
                <select class="form-control" id="yet" multiple="multiple" size='22'></select>
            </div>
            <div class="col-sm-1 widget-container-col ui-sortable">
                <h3>分配权限</h3>
                <div class="btn-group btn-group-vertical">
                    <button class="btn btn-info handel" rel="add"><i class='fa fa-angle-double-left'></i></button>
                    <button class="btn btn-info handel" rel="del"><i class='fa fa-angle-double-right'></i></button>
                </div>

            </div>
            <div class="col-sm-4 widget-container-col ui-sortable">
                <h3>未分配</h3>
                <select class="form-control" id="un" multiple="multiple" size='22'></select>
            </div>
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div><!-- /.page-content -->

<div class="urls hidden">
    <a href="<?=Url::toRoute('/srbac/role/permission');?>" class="permission"></a>
    <a href="<?=Url::toRoute('/srbac/default/assign-permission');?>" class="assign-permission"></a>
    <input name='csrf' value="<?=Yii::$app->request->getCsrfToken()?>">
</div>
<script type="text/javascript">
$(function(){
    $('#roleselect').change(function(){
        var role = $(this).val();
        selectRole(role)
    });

    $('.handel').click(function(){
        var rel = $(this).attr('rel');
        var url = $('.assign-permission').attr('href');
        var role = $('#roleselect').val();
        var csrf = $('input[name=csrf]').val();
        if (rel=='add') {
            var val = $('#un').val();
        } else {
            var val = $('#yet').val();
        };

        $.post(url, {method:rel, action:val, _csrf:csrf, role:role}, function(xhr){
            $('input[name=csrf]').val(xhr.csrf);
            if (xhr.status) {
                selectRole(role);
            };
        },'json');

    });
});

function selectRole(role){
    var url = $('.permission').attr('href')+'&rolename='+role;
    $.get(url, null, function(xhr){
        if (xhr.status) {
            $('#yet').html(xhr.data.yet);
            $('#un').html(xhr.data.un);
        };
    },'json');
}
</script>