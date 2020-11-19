<?php

use yii\helpers\Html;
use yii\grid\GridView;
use mdm\admin\components\RouteRule;
use mdm\admin\components\Configs;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel mdm\admin\models\searchs\AuthItem */
/* @var $context mdm\admin\components\ItemController */

$context = $this->context;
$labels = $context->labels();
$this->title = Yii::t('rbac-admin', $labels['Items']);
$this->params['breadcrumbs'][] = $this->title;

$rules = array_keys(Configs::authManager()->getRules());
$rules = array_combine($rules, $rules);
unset($rules[RouteRule::RULE_NAME]);
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
        <?= Html::a(Yii::t('rbac-admin', 'Create ' . $labels['Item']), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class'=>'table table-striped table-bordered table-td-valign-middle dataTable no-footer dtr-inline' ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'name',
                'label' => Yii::t('rbac-admin', 'Name'),
            ],
            [
                'attribute' => 'ruleName',
                'label' => Yii::t('rbac-admin', 'Rule Name'),
                'filter' => $rules
            ],
            [
                'attribute' => 'description',
                'label' => Yii::t('rbac-admin', 'Description'),
            ],
            [
                'class'          => 'yii\grid\ActionColumn',
                'template'       => '<div class="btn-group">{view} {update} {delete}</div>',
                'buttons'        => [
                    'view'   => function ($url, $model) {
                        return Html::a('<i class="fas fa-eye"></i>', $url, [
                            'title' => 'Посмотреть',
                            'class'=>'btn btn-sm btn-white'
                        ]);
                    },
                    'update' => function ($url, $model) {
                        return Html::a('<i class="fas fa-edit"></i>', $url, [
                            'title' => 'Редактировать',
                            'class'=>'btn btn-sm btn-primary'
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<span class="fas fa-trash"></span>', $url, [
                            'title'        => 'Удалить',
                            'data-confirm' => 'Вы уверены, что хотите удалить этот элемент?',
                            'data-method'  => 'post',
                            'data-pjax'    => '0',
                            'class'=>'btn btn-sm btn-danger',
                        ]);
                    }
                ]
            ],
        ],
    ])
    ?>

</div>
</div>
