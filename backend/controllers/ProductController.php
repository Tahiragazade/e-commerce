<?php

namespace backend\controllers;

use common\models\Category;
use common\models\Color;
use common\models\Product;
use backend\models\ProductSearch;
use common\models\ProductColor;
use common\models\ProductContent;
use common\models\ProductSize;
use common\models\Size;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
{
	public function init()
	{

		parent::init();
		$language = new \common\components\Language();
		$language->__init();
	}
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
     * Lists all Product models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
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
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Product();
	    $langs= Yii::$app->base->getLangList();
		$sizes=ArrayHelper::map(Size::find()->all(),'id', 'name');
		$colors=ArrayHelper::map(Color::find()->multilingual()->all(),'id', 'name');
		$categories=ArrayHelper::map(Category::find()->multilingual()->all(),'id', 'name');


	    if ($model->load($this->request->post()) ) {

		    $model->created_by = Yii::$app->user->id;
		    $model->created_at =time();
		    $model->updated_at =time();
		    if(!$model->save()){
				print_r($model->errors);
				echo Yii::$app->user->id;
				die();
		    }
		    $model->load($this->request->post());
		    foreach($langs as $key=> $value) {
			    $content = new ProductContent();
			    $content->lang = $key;
			    $content->product_id = $model->id;
			    $content->title = $model->{'title_'.$key};
			    $content->small_description = $model->{'small_description_'.$key};
			    $content->description = $model->{'description_'.$key};
			    $content->information = $model->{'information_'.$key};
			    $model->link('productContents', $content);
		    }

			foreach($model->size as $size){
				$sizes=new ProductSize();
				$sizes->product_id=$model->id;
				$sizes->size_id=$size;
				$sizes->save();
			}
		    foreach($model->color as $color){
			    $colors=new ProductColor();
			    $colors->product_id=$model->id;
			    $colors->color_id=$color;
			    $colors->save();
		    }
		    return $this->redirect(['index']);
	    }
         else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
			'langs'=>$langs,
	        'sizes'=>$sizes,
	        'colors'=>$colors,
	        'categories'=>$categories,
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
	    $langs= Yii::$app->base->getLangList();
	    $sizes=ArrayHelper::map(Size::find()->all(),'id', 'name');
	    $colors=ArrayHelper::map(Color::find()->multilingual()->all(),'id', 'name');
	    $categories=ArrayHelper::map(Category::find()->multilingual()->all(),'id', 'name');

	    if ($model->load($this->request->post()) ) {

		    $model->created_by =Yii::$app->user->id;
		    $model->created_at =time();
		    $model->updated_at =time();
		    $model->save();
		    $model->load($this->request->post());
		    ProductContent::deleteAll(['product_id'=>$model->id]);
		    foreach($langs as $key=> $value) {
			    $content = new ProductContent();
			    $content->lang = $key;
			    $content->product_id = $model->id;
			    $content->title = $model->{'title_'.$key};
			    $content->small_description = $model->{'small_description_'.$key};
			    $content->description = $model->{'description_'.$key};
			    $content->information = $model->{'information_'.$key};
			    $model->link('productContents', $content);
		    }
//		    print_r($model->size);
//		    die();
			ProductSize::deleteAll(['product_id'=>$model->id]);
		    foreach($model->size as $size){
			    $sizes=new ProductSize();
			    $sizes->product_id=$model->id;
			    $sizes->size_id=$size;
			    $sizes->save();
		    }
			ProductColor::deleteAll(['product_id'=>$model->id]);
		    foreach($model->color as $color){
			    $colors=new ProductColor();
			    $colors->product_id=$model->id;
			    $colors->color_id=$color;
			    $colors->save();
		    }
		    return $this->redirect(['index']);
	    }

        return $this->render('update', [
            'model' => $model,
	        'langs'=>$langs,
	        'sizes'=>$sizes,
	        'colors'=>$colors,
	        'categories'=>$categories,
        ]);
    }

    /**
     * Deletes an existing Product model.
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
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::find()->where(['id' => $id])->multilingual()->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
