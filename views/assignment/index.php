<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel mdm\admin\models\searchs\Assignment */
/* @var $usernameField string */
/* @var $extraColumns string[] */

$this->title = Yii::t('rbac-admin', 'Assignments');
$this->params['breadcrumbs'][] = $this->title;
$columns = [
    ['class' => 'yii\grid\SerialColumn'],
    $usernameField,
];
if (!empty($extraColumns)) {
    $columns = array_merge($columns, $extraColumns);
}
$columns[] = [
        'class'          => 'yii\grid\ActionColumn',
        'template'       => '<div class="btn-group">{view} </div>',
        'buttons'        => [
            'view'   => function ($url, $model) {
                return Html::a('<i class="fas fa-eye"></i>', $url, [
                    'title' => 'Посмотреть',
                    'class'=>'btn btn-sm btn-white'
                ]);
            },
        ]

];
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

    <?php Pjax::begin(); ?>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class'=>'table table-striped table-bordered table-td-valign-middle dataTable no-footer dtr-inline' ],
        'columns' => $columns,
    ]);
    ?>
    <?php Pjax::end(); ?>

</div>
</div>
