<?php

use backend\models\OrderProductSearch;
use backend\models\OrderSearch;
use common\models\Order;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;

//use yii\grid\GridView;
use kartik\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\OrderSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Orders');
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
		<?= Html::a(Yii::t('app', 'Create Order'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

	<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => [
                [
			'class' => 'kartik\grid\ExpandRowColumn',
			'value' => function($model, $key, $index, $column) {
				return GridView::ROW_COLLAPSED;
			},
			'detail' => function($model, $key, $index, $column) {
				$searchModel = new OrderProductSearch();
				$searchModel->order_id = $model->id;
				$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
				return Yii::$app->controller->renderPartial('_order-products', [
					'searchModel' => $searchModel,
					'dataProvider' => $dataProvider
				]);
			},
],
			'id',
			'user_id',
			'session_id',
			[
				'attribute' => 'created_at',
				'value' => function($data) {
					return date('Y-m-d',$data->created_at);
				}
			],
//			'updated_at',
			'payment_type',
			'total_price',
			'shipping_price',
//			[
//				'class' => ActionColumn::className(),
//				'urlCreator' => function($action, Order $model, $key, $index, $column) {
//					return Url::toRoute([$action, 'id' => $model->id]);
//				}
//			],
		],
	]); ?>


</div>
