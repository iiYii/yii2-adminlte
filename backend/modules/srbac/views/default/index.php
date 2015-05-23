<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '权限管理';
?>
<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">

        <div class="btn-group pull-right">
            <a href="<?=Url::to(['default/index'])?>" class='btn btn-info btn-sm'>管理授权项</a>
            <a href="<?=Url::to(['default/assign'])?>" class='btn btn-info btn-sm'>分配授权</a>
            <a href="<?=Url::to(['role/index'])?>" class='btn btn-info btn-sm'>角色管理</a>
        </div>
        <div class="alert alert-info">

            <h5>SRBAC使用分为几步:</h5>
            <p class="text-danger">1.选择需要接受权限控制的功能。</p>
            <p class="text-info">2.添加角色。<a href="<?=Url::to(['role/index'])?>" class='btn btn-info btn-xs'> go! </a></p>
            <p class="text-info">3.为角色添加可操作的功能(在第一步中选择的功能中选择)。<a href="<?=Url::to(['default/assign'])?>" class='btn btn-info btn-xs'> go! </a></p>
            <p class="text-info">4.为用户授权,在角色管理页面选择对应的角色行的"选择用户"。<a href="<?=Url::to(['role/index'])?>" class='btn btn-info btn-xs'> go! </a></p>
        </div>
        <!-- PAGE CONTENT BEGINS -->
        <div class="row">

            <div class="col-md-12">
                <?php foreach ($classes as $key => $value):?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title"><?php echo $key;?></h4>
                    </div>
                    <div class="panel-body">
                        <?php foreach ($value as $ke => $val):?>
                            <dl class="col-md-12 col-sm-12">
                                <dt><?php echo $ke;?> </dt>
                                <?php foreach ($val as $k => $v):?>
                                    <dd class="checkbox pull-left" style="min-width:300px;">
                                        <label class=''>
                                            <input name="action" value="<?=$k?>" type="checkbox" <?php if(isset($v['check'])) echo 'checked';?> class="action ace">
                                        <span class="lbl "><?php echo $v['action']?>
                                            <input value="<?php echo $v['des']?>" class="action_des input-small" />
                                        </span>
                                        </label>
                                    </dd>
                                <?php endforeach;?>
                            </dl>
                            <hr/>
                        <?php endforeach;?>
                    </div>
                </div>
                <?php endforeach;?>
            </div>
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div><!-- /.page-content -->

<div class="urls hidden">
    <a href="<?=Url::toRoute('/srbac/default/create-permission');?>" class="permission"></a>
</div>