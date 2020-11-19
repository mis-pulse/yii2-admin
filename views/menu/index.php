<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel mdm\admin\models\searchs\Menu */

$this->title = Yii::t('rbac-admin', 'Menus');
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

    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

    <p>
        <?= Html::a(Yii::t('rbac-admin', 'Create Menu'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class'=>'table table-striped table-bordered table-td-valign-middle dataTable no-footer dtr-inline' ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            [
                'attribute' => 'menuParent.name',
                'filter' => Html::activeTextInput($searchModel, 'parent_name', [
                    'class' => 'form-control', 'id' => null
                ]),
                'label' => Yii::t('rbac-admin', 'Parent'),
            ],
            'route',
            'order',
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
<?php Pjax::end(); ?>

</div>
</div>
