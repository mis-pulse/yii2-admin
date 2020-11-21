<?php

use mdm\admin\models\form\Signup;
use pulse\worker\models\WorkerSearch;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;
use mdm\admin\ShowPasswordAsset;
ShowPasswordAsset::register($this);

/* @var $this yii\web\View */
/* @var $form \yii\bootstrap4\ActiveForm */
/* @var $model Signup */

$this->title = Yii::t('rbac-admin', 'Create user');
$this->params['breadcrumbs'][] = $this->title;
?>
<h1 class="page-header"><?= Html::encode($this->params['label']) ?></h1>
<?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h1 class="panel-title"><?= Html::encode($this->title) ?></h1>
        <div class="panel-heading-btn">
            <a href="#" class="btn btn-xs btn-icon btn-circle btn-primary" data-click="panel-expand"><i class="fa fa-expand"></i></a>
        </div>
    </div>
    <div class="panel-body">
        <p>Введите логин для новой учетной записи и сообщите его сотруднику</p>
        <p>Пароль вводить не обязательно. Пользователь сам сможет создать его при входе в систему</p>
        <?= Html::errorSummary($model)?>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'username')?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'worker_id')->dropDownList(WorkerSearch::selectWorkersActive(),['prompt' => 'Выберите сотрудника, если необходимо'])?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'password')->input('password',['data-toggle'=>'password','autocomplete'=>"new-password"]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'retypePassword')->input('password',['data-toggle'=>'password','autocomplete'=>"new-password"]) ?>
            </div>
        </div>
    </div>
    <div class="panel-footer">
        <?= Html::a('Назад', ['index'], ['class' => 'btn btn-white']) ?>
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
