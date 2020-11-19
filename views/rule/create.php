<?php

use yii\helpers\Html;

/* @var $this  yii\web\View */
/* @var $model mdm\admin\models\BizRule */

$this->title = Yii::t('rbac-admin', 'Create Rule');
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

    <?=
    $this->render('_form', [
        'model' => $model,
    ]);
    ?>

</div>
</div>
