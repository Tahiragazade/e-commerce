<?php

use common\models\OrderProduct;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
//use kartik\grid\GridView;
/** @var yii\web\View $this */
/** @var backend\models\OrderProductSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Order Products');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-product-index">


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'order_id',
	        [
		        'attribute' => 'photo',
		        'format' => 'html',
		        'value'=>function($data) {  return Html::img($data->product->small_photo,
			        ['width' => '70px']); },
	        ],
	        [
		        'attribute' => 'product_id',
		        'value' => function($data) {
			        return $data->product->title;
		        }
	        ],
	        [
		        'attribute' => 'size_id',
		        'value' => function($data) {
			        return $data->size->name;
		        }
	        ],
	        [
		        'attribute' => 'color_id',
		        'value' => function($data) {
			        return $data->color->name;
		        }
	        ],
	        [
		        'attribute' => 'link',
		        'format' => 'html',
		        'value'=>function($data) {  return Url::to('/frontend/web/az/detail.html?id='.$data->product_id.'',true);},
	        ],
            'discounted_price',
            'count',
            'price',

        ],
    ]); ?>


</div>
