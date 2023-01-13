<?php

namespace backend\controllers;

use common\models\Size;
use backend\models\SizeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SizeController implements the CRUD actions for Size model.
 */
class SizeController extends Controller
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
	 * Lists all Size models.
	 *
	 * @return string
	 */
	public function actionIndex()
	{
		$searchModel = new SizeSearch();
		$dataProvider = $searchModel->search($this->request->queryParams);

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays a single Size model.
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
	 * Creates a new Size model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return string|\yii\web\Response
	 */
	public function actionCreate()
	{
		$model = new Size();

		if($model->load($this->request->post())) {
			$model->created_at = time();
			$model->updated_at = time();
			$model->save();
			return $this->redirect(['index']);
		} else {
			$model->loadDefaultValues();
		}

		return $this->renderAjax('create', [
			'model' => $model,
		]);
	}

	/**
	 * Updates an existing Size model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param int $id ID
	 * @return string|\yii\web\Response
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if($model->load($this->request->post())) {
			$model->updated_at = time();
			$model->save();
			return $this->redirect(['index']);
		}

		return $this->renderAjax('update', [
			'model' => $model,
		]);
	}

	/**
	 * Deletes an existing Size model.
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
	 * Finds the Size model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param int $id ID
	 * @return Size the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{

		if(($model = Size::find()->where('id=:id',[':id' => $id])->one()) !== null) {
			return $model;
		}

		throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
	}
}
