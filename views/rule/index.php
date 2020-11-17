<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this  yii\web\View */
/* @var $model mdm\admin\models\BizRule */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel mdm\admin\models\searchs\BizRule */

$this->title = Yii::t('rbac-admin', 'Rules');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="role-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('rbac-admin', 'Create Rule'), ['create'], ['class' => 'btn btn-success']) ?>
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
    ]);
    ?>

</div>
