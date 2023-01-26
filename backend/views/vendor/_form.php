<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\elfinder\InputFile;

/** @var yii\web\View $this */
/** @var common\models\Vendor $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="vendor-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'photo')->widget(InputFile::className(), [
		'language' => 'en',
		'controller' => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
		'filter' => 'image',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
		'template' => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
		'options' => ['class' => 'form-control'],
		'buttonOptions' => ['class' => 'btn btn-default'],
		'multiple' => false       // возможность выбора нескольких файлов
	]); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
