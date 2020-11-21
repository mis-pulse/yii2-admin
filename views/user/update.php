<?php

use mdm\admin\models\User;
use pulse\worker\models\WorkerSearch;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model mdm\admin\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput() ?>
    <?= $form->field($model, 'worker_id')->dropDownList(WorkerSearch::selectWorkersAll(),['prompt' => 'Выберите сотрудника, если необходимо'])?>

    <?= $form->field($model, 'password')->input('password',['data-toggle'=>'password']) ?>
    <?= $form->field($model, 'retypePassword')->input('password',['data-toggle'=>'password']) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('rbac-admin', 'Change'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
