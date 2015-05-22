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
            <div class="col-sm-12 widget-container-col ui-sortable">
                <div class="widget-box transparent ui-sortable-handle">
                    <div class="widget-header">
                        <h4 class="widget-title lighter">controllers</h4>

                        <div class="widget-toolbar no-border">
                            <a href="#" data-action="collapse">
                                <i class="ace-icon fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="widget-body">
                        <div class="widget-main">
                            <?php foreach ($classes['other'] as $k => $v):?>
                            <dl class="col-sm-12 col-xs-12">
                                <dt><?php echo $k;?> <input name="action" value="" type="checkbox" class="ace"></dt>
                                <?php foreach ($v as $ke => $action):?>
                                <dd class="checkbox pull-left" style="min-width:300px;">
                                    <label class=''>
                                        <input name="action" value="<?=$k.'-'.$action['name']?>" type="checkbox" <?php if(isset($action['check'])) echo 'checked';?> class="action ace">
                                        <span class="lbl "><?php echo $action['name']?>
                                            <?php echo $action['des']?>
                                            <!--
                                            <input value="<?php echo $action['des']?>" class="action_des input-small" />
                                            -->
                                        </span>
                                    </label>
                                </dd>
                                <?php endforeach;?>
                            </dl>
                            <?php endforeach;?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 widget-container-col ui-sortable">
                <div class="widget-box transparent ui-sortable-handle">
                    <div class="widget-header">
                        <h4 class="widget-title lighter">modules</h4>

                        <div class="widget-toolbar no-border">
                            <a href="#" data-action="collapse">
                                <i class="ace-icon fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="widget-body">
                        <div class="widget-main">
                            <?php foreach ($classes['mod'] as $k => $v):?>
                            <dl class="col-sm-12 col-xs-12">
                                <dt><?=$k?> <input name="action" value="" type="checkbox" class="action ace"></dt>
                                <?php foreach ($v as $ke => $action):?>
                                <dd class="checkbox pull-left" style="min-width:300px;">
                                    <label class=''>
                                        <input name="action" value="<?=$k.'-'.$action['name']?>" type="checkbox" <?php if(isset($action['check'])) echo 'checked';?> class="action ace">
                                        <span class="lbl "><?php echo $action['name']?>
                                            <?php echo $action['des']?>
                                            <!--
                                            <input value="<?php echo $action['des']?>" class="action_des input-small" />
                                            -->
                                        </span>
                                    </label>
                                </dd>
                                <?php endforeach;?>
                            </dl>
                            <?php endforeach;?>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div><!-- /.page-content -->
<div class="urls hidden">
    <a href="<?=Url::toRoute('/srbac/default/create-permission');?>" class="permission"></a>
</div>
<div class="urls hidden">
    <a href="<?=Url::toRoute('/srbac/default/create-permission');?>" class="permission"></a>
    <a href="<?=Url::toRoute('/srbac/default/get-actions');?>" class="getactions"></a>
</div>
<script type="text/javascript">
$(function(){
    $('.action').click(function(e){
        var action = $(this).val();
        var check = $(this).is(":checked");
        var url= $('.permission').attr('href');
        var des = $(this).siblings('span').children('.action_des').val();
        createpermission(action, des, check);
    })

    $('.action_des').blur(function(){
        var action = $(this).parent().siblings('input').val();
        var des = $(this).val();
        $(this).parent().siblings('input').attr('checked', 'checked');
        createpermission(action, des, true);
    });

    function createpermission(action, des, check)
    {
        var url = $('.permission').attr('href');
        $.get(url,{permission:action,des:des,check:check},function(e){

        },'json');
    }

})  





</script>