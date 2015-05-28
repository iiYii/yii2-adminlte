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
                //['attribute' => 'data', 'enableSorting' => false, 'filter' => false],
                'created_at:datetime',
                'updated_at:datetime',
                [
                    'header'     => Yii::t('app', 'Actions'),
                    'class'      => 'backend\modules\srbac\widgets\ActionColumn',
                    'template'   => '{view} {update} {assign-user} {delete}',
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
                            case 'assign-user':
                                $link = Yii::$app->getUrlManager()->createUrl(['/srbac/role/user', 'name' => $model->name]);
                                break;
                        }
                        return $link;
                    },
                ],
            ],
        ]); ?>


    </div>
    <!-- /.page-content-area -->
</div>

<div class="urls hidden">
    <a href="<?= Url::toRoute('/srbac/role/create2'); ?>" class="create-role"></a>
</div>