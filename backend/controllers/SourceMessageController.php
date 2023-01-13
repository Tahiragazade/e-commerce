<?php

namespace backend\controllers;

use common\models\Lang;
use common\models\Message;
use common\models\SourceMessage;
use backend\models\SourceMessageSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SourceMessageController implements the CRUD actions for SourceMessage model.
 */
class SourceMessageController extends Controller
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
     * Lists all SourceMessage models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SourceMessageSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SourceMessage model.
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
     * Creates a new SourceMessage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new SourceMessage();
	    $langs= Yii::$app->base->getLangList();
        if ($this->request->isPost) {
            if ($model->load($this->request->post()) ) {

	            $model->save();
	            foreach($langs as $lang=>$value){
		            $translate=new Message();
		            $translate->id=$model->id;
		            $translate->language=$lang;
		            $translate->translation=$model->{'title_'.$lang};
		            $translate->save();

	            }

                return $this->redirect(['index']);
            }
        } else {
            $model->loadDefaultValues();
        }


        return $this->renderAjax('create', [
            'model' => $model,
	        'langs'=>$langs
        ]);
    }

    /**
     * Updates an existing SourceMessage model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
	    $langs= Yii::$app->base->getLangList();
	    if ($this->request->isPost) {
		    if ($model->load($this->request->post()) ) {

			    $model->save();
				Message::deleteAll(['id'=>$model->id]);
			    foreach($langs as $lang=>$value){
				    $translate=new Message();
				    $translate->id=$model->id;
				    $translate->language=$lang;
				    $translate->translation=$model->{'title_'.$lang};
				    $translate->save();

			    }

			    return $this->redirect(['index']);
		    }
	    }

        return $this->renderAjax('update', [
            'model' => $model,
	        'langs'=>$langs
        ]);
    }

    /**
     * Deletes an existing SourceMessage model.
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
     * Finds the SourceMessage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return SourceMessage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
		$model = SourceMessage::find()->where('id=:id', [':id' => $id])->multilingual()->one();
        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
