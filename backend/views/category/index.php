<?php

use common\models\Category;
use yii\bootstrap4\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use kartik\icons\Icon;

/** @var yii\web\View $this */
/** @var backend\models\CategorySearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Categories');
$this->params['breadcrumbs'][] = $this->title;
Modal::begin([
	'title' => 'Test',
	'id' => 'modal',
	'size' => 'modal-lg',
]);
echo "<div id='modalContent'></div>";
Modal::end();
?>
<div class="category-index">
    <p>
        <button type="button" class="btn btn-success modalButton" data-href="<?= Url::to(['category/create']) ?>"
                data-title="Create Category">Create Category
        </button>

    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'parent_id',
            'status',
            'created_at',
            'updated_at',
            //'sort_order',
	        [
		        'class' => \yii\grid\ActionColumn::className(),
		        'header' => 'Actions',
		        'template' => '{update} {view}{delete}',
		        'buttons' => [
			        'update' => function($url, $model) {
				        $icon = Icon::show('edit');
				        return Html::a($icon, $url, [
					        'data-href' => Url::to(['category/update', 'id' => $model->id]),
					        'data-title' => 'Update '.$model->name,
					        'class'=>'modalButton']);
			        },

			        'view' => function($url, $model) {
				        $icon = Icon::show('eye');
				        return Html::a($icon, $url, [
					        'data-href' => Url::to(['category/view', 'id' => $model->id]),
					        'data-title' => 'Update '.$model->name,
					        'class'=>'modalButton']);
			        },

			        'delete' => function($url, $model) {
				        $icon = Icon::show('trash');
				        return Html::a($icon, $url,
					        [
						        'data-confirm' => "Are you sure ?",
						        'data-method' => 'post',
					        ]);
			        },
		        ]
	        ],
        ],
    ]); ?>


</div>
