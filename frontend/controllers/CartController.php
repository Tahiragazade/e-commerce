<?php

namespace frontend\controllers;

use common\models\Address;
use common\models\Cart;
use common\models\Order;
use frontend\models\CartSearch;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CartController implements the CRUD actions for Cart model.
 */
class CartController extends Controller
{
	/**
	 * @inheritDoc
	 */
	public function behaviors()
	{
		return array_merge(
			parent::behaviors(),
			[
				'verbs' => [
					'class' => VerbFilter::className(),
					'actions' => [
						'delete' => ['GET'],
					],
				],
			]
		);
	}

	/**
	 * Lists all Cart models.
	 *
	 * @return string
	 */
	public function actionIndex()
	{
//        $searchModel = new CartSearch();
//        $dataProvider = $searchModel->search($this->request->queryParams);
		$products = Cart::find()->where(['session_id' => Yii::$app->session->id])->orWhere(['user_id' => Yii::$app->user->id])->all();
		$total_price = 0;
		foreach($products as $product) {
			$total_price += $product->product->price * $product->count;
		}
		$shipping_price = 10;
		return $this->render('/shop/cart', [
			'products' => $products,
			'total_price' => $total_price,
			'shipping_price' => $shipping_price
		]);
	}

	/**
	 * Displays a single Cart model.
	 * @param int $id ID
	 * @return string
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionView($id)
	{
		return $this->render('view', [
			'model' => $this->findModel($id),
		]);
	}

	public function actionCheckout()
	{
		$products = Cart::find()->orWhere(['session_id' => Yii::$app->session->id])->orWhere(['user_id' => Yii::$app->user->id])->all();

		$total_price = 0;
		$cart_ids = [];
		foreach($products as $product) {
			$total_price += $product->product->price * $product->count;
			$cart_ids[] = $product->id;
		}
		$session = Yii::$app->session;
		$session->set('products', $cart_ids);
		$shipping_price = 10;
		$model = new Address();
		$model1 = new Order();
		return $this->render('/shop/checkout', [
			'products' => $products,
			'total_price' => $total_price,
			'shipping_price' => $shipping_price,
			'model' => $model,
			'model1' => $model1,
		]);
	}

	/**
	 * Creates a new Cart model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return string|\yii\web\Response
	 */
	public function actionCreate()
	{
		$model = new Cart();

		if($this->request->isPost) {
			if($model->load($this->request->post())) {
				if(!Yii::$app->user->isGuest) {
					$model->user_id = Yii::$app->id;
				}
				$model->session_id = Yii::$app->session->id;
				$model->created_at = time();
				$model->updated_at = time();
				$model->save();
				return $this->redirect(['index']);
			}
		} else {
			$model->loadDefaultValues();
		}

		return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
	}

	/**
	 * Updates an existing Cart model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param int $id ID
	 * @return string|\yii\web\Response
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->id]);
		}

		return $this->render('update', [
			'model' => $model,
		]);
	}

	/**
	 * Deletes an existing Cart model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param int $id ID
	 * @return \yii\web\Response
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionDelete($id)
	{
		$cart =Cart::find()->where('id=:id',[':id' => $id])->andWhere(['session_id' => Yii::$app->session->id])->orWhere(['user_id' => Yii::$app->user->id])->one();
		if($cart!=null){
			$cart->delete();
		}


		return $this->redirect(['index']);
	}

	/**
	 * Finds the Cart model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param int $id ID
	 * @return Cart the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if(($model = Cart::find()->where('id=:id',[':id' => $id])) !== null) {
			return $model;
		}

		throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
	}
}
