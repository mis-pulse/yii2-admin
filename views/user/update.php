<?php

use mdm\admin\models\User;
use pulse\worker\models\WorkerSearch;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;
use mdm\admin\ShowPasswordAsset;
ShowPasswordAsset::register($this);

$this->title = Yii::t('rbac-admin', 'Update user');
$this->params['breadcrumbs'][] = $this->title;

/* @var $this yii\web\View */
/* @var $model mdm\admin\models\User */
/* @var $form yii\widgets\ActiveForm */
//TODO:: Можно ли изменять сотрудника?
//TODO:: Gpassword

?>
<h1 class="page-header"><?= Html::encode($this->params['label']) ?></h1>
<?php $form = ActiveForm::begin(); ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h1 class="panel-title"><?= Html::encode($this->title) ?></h1>
        <div class="panel-heading-btn">
            <a href="#" class="btn btn-xs btn-icon btn-circle btn-primary" data-click="panel-expand"><i class="fa fa-expand"></i></a>
        </div>
    </div>
    <div class="panel-body">
        <?= Html::errorSummary($model)?>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'username')?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'worker_id')->dropDownList(WorkerSearch::selectWorkersAll(),['prompt' => 'Выберите сотрудника, если необходимо'])?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'password')->input('password',['data-toggle'=>'password','autocomplete'=>"new-password"]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'retypePassword')->input('password',['data-toggle'=>'password','autocomplete'=>"new-password"]) ?>
            </div>
            <div class="col-md-12">
                <?= $form->field($model, 'gpassword')->input('text') ?>
            </div>
        </div>

    </div>
    <div class="panel-footer">
        <?= Html::a('Назад', ['index'], ['class' => 'btn btn-white']) ?>
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
