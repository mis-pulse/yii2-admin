<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var mdm\admin\models\AuthItem $model
 */
$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac-admin', 'Rules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1 class="page-header"><?= Html::encode($this->params['label']) ?></h1>
<div class="panel panel-default">
    <div class="panel-heading">
        <h1 class="panel-title"><?= Html::encode($this->title) ?></h1>
        <div class="panel-heading-btn">
            <a href="#" class="btn btn-xs btn-icon btn-circle btn-primary" data-click="panel-expand"><i class="fa fa-expand"></i></a>
        </div>
    </div>
    <div class="panel-body">

    <p>
        <?= Html::a(Yii::t('rbac-admin', 'Update'), ['update', 'id' => $model->name], ['class' => 'btn btn-primary']) ?>
        <?php
        echo Html::a(Yii::t('rbac-admin', 'Delete'), ['delete', 'id' => $model->name], [
            'class' => 'btn btn-danger',
            'data-confirm' => Yii::t('rbac-admin', 'Are you sure to delete this item?'),
            'data-method' => 'post',
        ]);
        ?>
    </p>

    <?php
    echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'className',
        ],
    ]);
    ?>
</div>
</div>
