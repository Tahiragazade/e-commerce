<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Vendor $model */

$this->title = Yii::t('app', 'Create Vendor');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Vendors'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vendor-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
