<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Permissions Manage');
?>
<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="alert alert-info">
            <p>请勾选需要接受权限控制的功能。</p>
        </div>
        <!-- PAGE CONTENT BEGINS -->
        <div class="row">

            <div class="col-md-12">
                <?php foreach ($classes as $key => $value): ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title"><?php echo $key; ?></h4>
                        </div>
                        <div class="panel-body">
                            <?php foreach ($value as $ke => $val): ?>
                                <dl class="col-md-12 col-sm-12">
                                    <dt><?php echo $ke; ?> </dt>
                                    <?php foreach ($val as $k => $v): ?>
                                        <dd class="checkbox pull-left" style="min-width:300px;">

                                            <input name="action" value="<?= $k ?>"
                                                   type="checkbox" <?php if (isset($v['check'])) echo 'checked'; ?>
                                                   >
                                        <span class="lbl "><?php echo $v['action'] ?>
                                            <input value="<?php echo $v['des'] ?>" class="action_des input-small"/>
                                        </span>

                                        </dd>
                                    <?php endforeach; ?>
                                </dl>
                                <hr/>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.page-content-area -->
</div><!-- /.page-content -->

<div class="urls hidden">
    <a href="<?= Url::toRoute('/srbac/default/create-permission'); ?>" class="permission"></a>
</div>