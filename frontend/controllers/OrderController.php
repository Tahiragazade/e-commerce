<?php

namespace frontend\controllers;

use common\models\Address;
use common\models\Cart;
use common\models\Order;
use common\models\OrderProduct;
use frontend\models\OrderSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller
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
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Order models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Order model.
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

    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
//    public function actionCreate()
//    {
//        $model = new Order();
//
//        if ($this->request->isPost) {
//            if ($model->load($this->request->post()) && $model->save()) {
//                return $this->redirect(['view', 'id' => $model->id]);
//            }
//        } else {
//            $model->loadDefaultValues();
//        }
//
//        return $this->render('create', [
//            'model' => $model,
//        ]);
//    }

	public function actionCreate()
	{
		$model = new Address();
				print_r($model->payment_type);
				die();
		if ($this->request->isPost) {
			if ($model->load($this->request->post())) {
//				print_r($model);
//				die();
				$order=new Order();
				$order->session_id=Yii::$app->session->id;
				$order->user_id=Yii::$app->user->id;
				$order->payment_type=$model->payment_type;
				$order->total_price=$model->total_price;
				$order->shipping_price=$model->shipping_price;
				$order->created_at=time();
				$order->updated_at=time();
				if(!$order->save()){
					print_r($order->errors);
					die();
				}
				$session = Yii::$app->session;
				$products=$session->get('products');
				foreach($products as $product_id) {
					$order_product = new OrderProduct();
					$product=Cart::findOne($product_id);
					$order_product->order_id=$order->id;
					$order_product->product_id=$product->product_id;
					$order_product->size_id=$product->size->id;
					$order_product->color_id=$product->color->id;
					$order_product->count=$product->count;
					$order_product->price=$product->product->price;
					if(!$order_product->save()){
						print_r($order_product->errors);
						die();
					}
				}
				$model->save();
				return $this->redirect(['view', 'id' => $model->id]);
			}
		} else {
			$model->loadDefaultValues();
		}

		return $this->render('create', [
			'model' => $model,
		]);
	}

    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Order model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
