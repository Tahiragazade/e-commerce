<?php

use common\models\SourceMessage;
use kartik\icons\Icon;
use yii\bootstrap4\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\SourceMessageSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Source Messages');
$this->params['breadcrumbs'][] = $this->title;

Modal::begin([
	'title' => '',
	'id' => 'modal',
	'size' => 'modal-lg',
]);
echo "<div id='modalContent'></div>";
Modal::end();
?>
<div class="source-message-index">


    <p>
        <button type="button" class="btn btn-success modalButton"
                data-href="<?= Url::to(['source-message/create']) ?>"
                data-title="Create Project">Add Translation
        </button>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'category',
            'message:ntext',
	        [
		        'class' => \yii\grid\ActionColumn::className(),
		        'header' => 'Actions',
		        'template' => '{update} {view}{delete}',
		        'buttons' => [
			        'update' => function($url, $model) {
				        $icon = Icon::show('edit');
				        return Html::a($icon, $url, [
					        'data-href' => Url::to(['update', 'id' => $model->id]),
					        'data-title' => 'Update '.$model->message,
					        'class'=>'modalButton']);
			        },

			        'view' => function($url, $model) {
				        $icon = Icon::show('eye');
				        return Html::a($icon, $url, [
					        'data-href' => Url::to(['view', 'id' => $model->id]),
					        'data-title' => 'Update '.$model->message,
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
