<?php
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use mdm\admin\ShowPasswordAsset;
ShowPasswordAsset::register($this);

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \mdm\admin\models\form\Login */

$this->title = Yii::t('rbac-admin', 'Login');
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
                <small>Войдите в систему используя свой логин и пароль</small>
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
                    <div class="checkbox checkbox-css m-b-20">
                        <?= $form->field($model, 'rememberMe')->checkbox()->label(Yii::t('rbac-admin', 'Remember me')) ?>
                        <!--<input type="checkbox" id="remember_checkbox" />
                        <label for="remember_checkbox">
                            Remember Me
                        </label>-->
                    </div>
                    <div class="login-buttons">
                        <?= Html::submitButton(Yii::t('rbac-admin', 'Login'), ['class' => 'btn btn-success btn-block btn-lg', 'name' => 'login-button']) ?>
                        <?= Html::a(Yii::t('rbac-admin', 'Create password'),['user/create-password'],['class' => 'btn btn-primary btn-block btn-lg', 'name' => 'login-button']) ?>
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
