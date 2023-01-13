<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\SourceMessage $model */

$this->title = Yii::t('app', 'Update Source Message: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Source Messages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="source-message-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
	    'langs'=>$langs
    ]) ?>

</div>
