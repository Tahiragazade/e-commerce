<?php

use common\models\Color;
use kartik\icons\Icon;
use yii\bootstrap4\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\ColorSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Colors');
$this->params['breadcrumbs'][] = $this->title;
Modal::begin([
	'title' => 'Test',
	'id' => 'modal',
	'size' => 'modal-lg',
]);
echo "<div id='modalContent'></div>";
Modal::end();
?>
<div class="color-index">
    <p>
        <button type="button" class="btn btn-success modalButton" data-href="<?= Url::to(['color/create']) ?>"
                data-title="Create Category">Create Color
        </button>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'created_by',
            'sort_order',
	        [
		        'attribute' => 'created_at',
		        'value' => function($data) {
			        return date('d.m.Y H:i', $data->created_at);
		        }
	        ],
	        [
		        'class' => \yii\grid\ActionColumn::className(),
		        'header' => 'Actions',
		        'template' => '{update} {view}{delete}',
		        'buttons' => [
			        'update' => function($url, $model) {
				        $icon = Icon::show('edit');
				        return Html::a($icon, $url, [
					        'data-href' => Url::to(['update', 'id' => $model->id]),
					        'data-title' => 'Update '.$model->name,
					        'class'=>'modalButton']);
			        },

			        'view' => function($url, $model) {
				        $icon = Icon::show('eye');
				        return Html::a($icon, $url, [
					        'data-href' => Url::to(['view', 'id' => $model->id]),
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
