<?php

namespace backend\controllers;

use common\models\Color;
use backend\models\ColorSearch;
use common\models\ColorContent;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ColorController implements the CRUD actions for Color model.
 */
class ColorController extends Controller
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
	 * Lists all Color models.
	 *
	 * @return string
	 */
	public function actionIndex()
	{
		$searchModel = new ColorSearch();
		$dataProvider = $searchModel->search($this->request->queryParams);

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays a single Color model.
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
	 * Creates a new Color model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return string|\yii\web\Response
	 */
	public function actionCreate()
	{
		$model = new Color();
		$langs = Yii::$app->base->getLangList();

		if($model->load($this->request->post())) {
			if(!$model->save()) {
				$model->created_by = Yii::$app->user->id;
				$model->created_at = time();
				$model->updated_at = time();
				if(!$model->save()) {
					print_r($model->errors);
					die();
				}

			}
			$model->load($this->request->post());
			foreach($langs as $key => $value) {
				$content = new ColorContent();
				$content->lang = $key;
				$content->color_id = $model->id;
				$content->name = $model->{'name_'.$key};
				$model->link('colorContents', $content);

			}
			return $this->redirect(['index']);
		} else {
			$model->loadDefaultValues();
		}

		return $this->renderAjax('create', [
			'model' => $model,
			'langs' => $langs
		]);
	}

	/**
	 * Updates an existing Color model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param int $id ID
	 * @return string|\yii\web\Response
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$langs = Yii::$app->base->getLangList();
		$model = $this->findModel($id);

		if($model->load($this->request->post())) {
			$model->updated_at = time();
			$model->save();

			ColorContent::deleteAll(['color_id' => $model->id]);
			$model->load($this->request->post());
			foreach($langs as $key => $value) {
				$content = new ColorContent();
				$content->lang = $key;
				$content->color_id = $model->id;
				$content->name = $model->{'name_'.$key};
				$model->link('colorContents', $content);

			}
			return $this->redirect(['index']);
		}

		return $this->renderAjax('update', [
			'model' => $model,
			'langs' => $langs
		]);
	}

	/**
	 * Deletes an existing Color model.
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
	 * Finds the Color model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param int $id ID
	 * @return Color the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if(($model = Color::find()->where('id=:id', [':id' => $id])->multilingual()->one()) !== null) {
			return $model;
		}

		throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
	}
}
