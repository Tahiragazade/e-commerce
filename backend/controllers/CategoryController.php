<?php

namespace backend\controllers;

use common\models\Category;
use backend\models\CategorySearch;
use common\models\CategoryContent;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
{
    /**
     * @inheritDoc
     */
	public function init()
	{

		parent::init();
		$language = new \common\components\Language();
		$language->__init();
	}
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
     * Lists all Category models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Category model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Category();
	    $dataList = Category::find()->multilingual()->all();
	    $categories = ArrayHelper::map($dataList, 'id', 'name');
		$langs= Yii::$app->base->getLangList();


            if ($model->load($this->request->post()) ) {

					$model->created_at =time();
					$model->updated_at =time();
					$model->save();

	            $model->load($this->request->post());
	            foreach($langs as $key=> $value) {
		            $content = new CategoryContent();
		            $content->lang = $key;
		            $content->category_id = $model->id;
		            $content->name = $model->{'name_'.$key};
		            $model->link('categoryContents', $content);

	            }
	            return $this->redirect(['index']);
            }
         else {
            $model->loadDefaultValues();
        }

        return $this->renderAjax('create', [
            'model' => $model,
	        'langs'=>$langs,
	        'categories'=>$categories,
        ]);
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
	    $dataList = Category::find()->multilingual()->all();
	    $categories = ArrayHelper::map($dataList, 'id', 'name');
	    $langs= Yii::$app->base->getLangList();

	    if ($model->load($this->request->post()) ) {
		    $model->updated_at =time();
		    $model->save();

			CategoryContent::deleteAll(['category_id'=>$model->id]);
		    $model->load($this->request->post());
		    foreach($langs as $key=> $value) {
			    $content = new CategoryContent();
			    $content->lang = $key;
			    $content->category_id = $model->id;
			    $content->name = $model->{'name_'.$key};
			    $model->link('categoryContents', $content);

		    }
		    return $this->redirect(['index']);
	    }

        return $this->renderAjax('update', [
	        'model' => $model,
	        'langs'=>$langs,
	        'categories'=>$categories,
        ]);
    }

    /**
     * Deletes an existing Category model.
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
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
		$model=Category::find()->where('id=:id',[':id' => $id])->multilingual()->one();
        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
