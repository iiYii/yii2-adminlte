<?php
\backend\modules\srbac\assets\SrbacAsset::register($this);

isset($this->params['breadcrumbs']) ?: $this->params['breadcrumbs'] = [];
array_unshift($this->params['breadcrumbs'], ['label' => '权限系统', 'url' => ['index']]);
?>
<?php $this->beginContent('@backend/views/layouts/main.php') ?>
    <?= $content ?>
<?php $this->endContent() ?>