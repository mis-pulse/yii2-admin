<?php
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\web\View;
use mdm\admin\ShowPasswordAsset;
ShowPasswordAsset::register($this);

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \mdm\admin\models\form\ResetPassword */

$this->title = 'Create password';
$this->params['breadcrumbs'][] = $this->title;
?>



<!-- begin login -->
<div class="login login-v1">
    <!-- begin login-container -->
    <div class="login-container">
        <!-- begin login-header -->
        <div class="login-header">
            <div class="brand">
                <span class="logo"></span> <b>МИС</b> Пульс
                <small>Введите логин и придумайте надежный пароль</small>
            </div>
            <div class="icon">
                <i class="fa fa-lock"></i>
            </div>
        </div>
        <!-- end login-header -->
        <!-- begin login-body -->
        <div class="login-body">
            <!-- begin login-content -->
            <div class="login-content">
                <?php $form = ActiveForm::begin(['id' => 'login-form','class'=>'margin-bottom-0']); ?>

                <div class="form-group m-b-20">
                    <?= $form->field($model, 'username')
                        ->input('text',['class'=>'form-control form-control-lg inverse-mode','placeholder'=>Yii::t('rbac-admin', 'Username')])
                        ->label(false) ?>

                </div>
                <div class="form-group m-b-20">
                    <?= $form->field($model, 'password')
                        ->input('password',['class'=>'form-control form-control-lg inverse-mode','data-toggle'=>'password','placeholder'=>Yii::t('rbac-admin', 'Password')])
                        ->label(false) ?>
                </div>
                <div class="form-group m-b-20">
                    <?= $form->field($model, 'retypePassword')
                        ->input('password',['class'=>'form-control form-control-lg inverse-mode','data-toggle'=>'password','placeholder'=>Yii::t('rbac-admin', 'Retype password')])
                        ->label(false) ?>
                </div>

                <div class="login-buttons">
                    <?= Html::submitButton(Yii::t('rbac-admin', 'Create password'), ['class' => 'btn btn-success btn-block btn-lg', 'name' => 'login-button']) ?>
                    <?= Html::a(Yii::t('rbac-admin', 'Isset login'),['user/login'],['class' => 'btn btn-primary btn-block btn-lg', 'name' => 'login-button']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
            <!-- end login-content -->
        </div>
        <!-- end login-body -->
    </div>
    <!-- end login-container -->
</div>
<!-- end login -->
