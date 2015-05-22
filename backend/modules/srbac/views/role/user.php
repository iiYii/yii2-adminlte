<?php

use yii\helpers\Html;
use yii\helpers\Url;
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\SearchUser $searchModel
 */

$this->title = '用户角色管理';
?>

<div class="breadcrumbs" id="breadcrumbs">
    <ul class="breadcrumb">
    	<li>
            <a href="<?=Url::to(['default/index'])?>" class='btn btn-info btn-xs'>管理授权项</a>
            <a href="<?=Url::to(['default/assign'])?>" class='btn btn-info btn-xs'>分配授权</a>
            <a href="<?=Url::to(['role/index'])?>" class='btn btn-info btn-xs'>角色管理</a>
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
					选择用户时，用户名底色变化之后表示已选中
				</small>
			</h1>
		</div><!-- /.page-header -->

		<div class="row">
    		<div class="col-xs-12">
    			<?php foreach($user as $k=>$v): ?>
					<h5> <a href="#" class="btn btn-xs pinyin" title="全选"><?=$k?></a></h5>
					<ul class="u-list">
						<?php foreach($v as $key=>$val): ?>
					    <li rel="user-id" data-user_id="<?=$key?>" class="user<?php if($val['is_sel'] == 1) echo ' selected';?>">
					    	<?=$val['username']?>
					    </li>
					    <?php endforeach;?>
					    <div style="clear:both"></div>
					</ul>
				<?php endforeach;?>
            <input type="hidden" name='csrf' value="<?=Yii::$app->request->getCsrfToken()?>">
            <input type="hidden" name="role_name" value="<?=Yii::$app->request->get('role_name');?>">
		</div>
</div>
	</div><!-- /.page-content-area -->
</div>

<div class="urls hidden">
    <a href="<?=Url::toRoute('/srbac/role/assign');?>" class="role-assign"></a>
</div>