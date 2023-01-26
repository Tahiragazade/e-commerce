<?php

use common\models\Vendor;
use kartik\icons\Icon;
use yii\bootstrap4\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\VendorSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Vendors');
$this->params['breadcrumbs'][] = $this->title;
Modal::begin([
	'title' => 'Test',
	'id' => 'modal',
	'size' => 'modal-lg',
]);
echo "<div id='modalContent'></div>";
Modal::end();
?>
<div class="vendor-index">
    <p>
        <button type="button" class="btn btn-success modalButton" data-href="<?= Url::to(['vendor/create']) ?>"
                data-title="Create Category">Create Vendor
        </button>
    </p>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
	        [
		        'attribute' => 'photo',
		        'format' => 'html',
		        'value'=>function($data) {  return Html::img($data->photo,
			        ['width' => '70px']); },
	        ],
            'status',
            //'updated_at',
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
