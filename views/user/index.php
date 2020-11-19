<?php

use yii\helpers\Html;
use yii\grid\GridView;
use mdm\admin\components\Helper;

/* @var $this yii\web\View */
/* @var $searchModel mdm\admin\models\searchs\User */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('rbac-admin', 'Users');
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
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class'=>'table table-striped table-bordered table-td-valign-middle dataTable no-footer dtr-inline' ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'username',
            'email:email',
            [
                'attribute' => 'status',
                'value' => function($model) {
                    return $model->status === 0 ? 'Inactive' : 'Active';
                },
                'filter' => [
                    0 => 'Inactive',
                    10 => 'Active'
                ]
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
                'buttons' => [
                    'activate' => function($url, $model) {
                        if ($model->status === 10) {
                            return '';
                        }
                        $options = [
                            'title' => Yii::t('rbac-admin', 'Activate'),
                            'aria-label' => Yii::t('rbac-admin', 'Activate'),
                            'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ];
                        return Html::a('<span class="fas fa-ok"></span>', $url, $options);
                    },
                    'view'   => function ($url, $model) {
                        return Html::a('<i class="fas fa-eye"></i>', $url, [
                            'title' => 'Посмотреть',
                            'class'=>'btn btn-sm btn-white'
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<span class="fas fa-trash"></span>', $url, ['title' => 'Удалить','data-confirm' => 'Вы уверены, что хотите удалить этот элемент?','data-method' => 'post','class'=>'btn btn-sm btn-danger']);
                    },
                    ]
                ],
            ],
        ]);
        ?>
</div>
</div>
