<?php

use mdm\admin\models\User;
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
        <p>
            <?= Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ?>
            <?= Html::a('Сотрудники', ['/worker/index'], ['class' => 'btn btn-info']) ?>
        </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function($model, $index, $widget, $grid){
            return ['class'=>'table-'.$model->statusClass];
        },

        'tableOptions' => ['class'=>'table table-striped table-bordered table-td-valign-middle dataTable no-footer dtr-inline' ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'username',
            //'email:email',
            [
                'attribute' => 'worker_id',
                'format'=>'raw',
                'value' => function($model) {
                    if (!$model->worker){
                        return '';
                    }
                    return Html::a($model->worker->fullName,['/worker/update','id'=>$model->worker->id]);
                },
                'filter' => \pulse\worker\models\WorkerSearch::selectWorkersAll(),
            ],
            [
                'attribute' => 'status',
                'value' => function($model) {
                    return $model->statusTitle;
                },
                'filter' => User::getStatusList(),
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
                'template' => '{update} {activate} {reset} {delete}',
                'buttons' => [
                    'activate' => function($url, $model) {
                        if ($model->status !== 0) {
                            return '';
                        }
                        $options = [
                            'title' => Yii::t('rbac-admin', 'Activate'),
                            'aria-label' => Yii::t('rbac-admin', 'Activate'),
                            'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
                            'data-method' => 'post',
                            'data-pjax' => '0',
                            'class'=>'btn btn-sm btn-success'
                        ];
                        return Html::a('<span class="fas fa-check"></span>', $url, $options);
                    },
                    //View убрал, т.к. хз что в нём смотреть...
//                    'view'   => function ($url, $model) {
//                        return Html::a('<i class="fas fa-eye"></i>', $url, [
//                            'title' => 'Посмотреть',
//                            'class'=>'btn btn-sm btn-white'
//                        ]);
//                    },
                    'update'   => function ($url, $model) {
                        return Html::a('<i class="fas fa-edit"></i>', $url, [
                            'title' => 'Изменить',
                            'class'=>'btn btn-sm btn-primary'
                        ]);
                    },
                    'reset' => function ($url, $model) {
                        if ($model->status !== 10) {
                            return '';
                        }
                        return Html::a('<span class="fas fa-redo"></span>', $url, ['title' => 'Сбросить пароль','data-confirm' => 'Вы уверены, что хотите сбросить пароль?','data-method' => 'post','class'=>'btn btn-sm btn-warning']);
                    },
                    'delete' => function ($url, $model) {
                        if ($model->status === 0) {
                            return '';
                        }
                        return Html::a('<span class="fas fa-trash"></span>', $url, ['title' => 'Удалить','data-confirm' => 'Вы уверены, что хотите удалить этот элемент?','data-method' => 'post','class'=>'btn btn-sm btn-danger']);
                    },
                    ]
                ],
            ],
        ]);
        ?>
</div>
</div>
