<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Permissions List');
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- /section:settings.box -->
<div class="box-group" id="accordion">
    <div class="alert alert-info">
        <p>请勾选需要接受权限控制的功能。</p>
    </div>
    <!-- PAGE CONTENT BEGINS -->
    <div class="row">
        <div class="col-md-12">

            <?php foreach ($classes as $key => $value): ?>
                <div class="box box-solid box-default">
                    <div class="box-header with-border">
                        <h4 class="box-title"><?php echo $key; ?></h4>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div><!-- /.box-tools -->
                    </div>
                    <div class="box-body">

                        <?php foreach ($value as $ke => $val): ?>
                            <div class="box box-default">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><?php echo $ke; ?></h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                    </div><!-- /.box-tools -->
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="" >
                                        <?php foreach ($val as $k => $v): ?>
                                            <div class="col-xs-3">
                                                <div class="input-group">
                                                    <span class="input-group-addon bg-gray color-palette"><?= $v['action'] ?></span>
                                                    <input type="text" class="form-control action_des" value="<?= $v['des'] ?>">
                                            <span class="input-group-addon">
                                                <input name="action" value="<?= $k ?>" type="checkbox" <?= (isset($v['check'])) ? 'checked' : ''; ?> class="action">
                                            </span>
                                                </div>
                                                <br>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>

                                </div><!-- /.box-body -->
                            </div>
                        <?php endforeach; ?>

                    </div>
                </div>
            <?php endforeach; ?>

        </div>
    </div>
    <!-- /.row -->
</div>
<!-- /.page-content-area -->

<div class="urls hidden">
    <a href="<?=Url::toRoute('/srbac/default/create-permission');?>" class="permission"></a>
</div>
