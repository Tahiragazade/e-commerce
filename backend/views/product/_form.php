<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\InputFile;
use mihaildev\elfinder\ElFinder;
use kartik\select2\Select2;

/** @var yii\web\View $this */
/** @var common\models\Product $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="product-form">

	<?php $form = ActiveForm::begin(); ?>
    <div class="tab">
		<?php foreach($langs as $key => $value): ?>
			<?php if($key == 'az') {
				echo '<button type="button" class="tablinks active" onclick="changeLang(event, \''.$key.'\')">'.$value.'</button>';
			} else {

				echo '<button type="button"  class="tablinks" onclick="changeLang(event, \''.$key.'\')">'.$value.'</button>';
			} ?>
		<?php endforeach; ?>
    </div>
	<?php foreach($langs as $key => $value): ?>
		<?php if($key == 'az') {
			echo '	<div id='.$key.' class="tabcontent" style="display:block">';
			echo $form->field($model, 'title_'.strtolower($key))->textInput();
			echo $form->field($model, 'small_description_'.strtolower($key))->textarea();
			echo $form->field($model, 'description_'.strtolower($key))->widget(CKEditor::className(), [
				'editorOptions' => ElFinder::ckeditorOptions('elfinder',
					['preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
						'inline' => false, //по умолчанию false]),

					]),]);
			echo $form->field($model, 'information_'.strtolower($key))->widget(CKEditor::className(), [
				'editorOptions' => ElFinder::ckeditorOptions('elfinder',
					['preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
						'inline' => false, //по умолчанию false]),

					]),]);
			echo '</div>';
		} else {
			echo '	<div id='.$key.' class="tabcontent">';
			echo $form->field($model, 'title_'.strtolower($key))->textInput();
			echo $form->field($model, 'small_description_'.strtolower($key))->textarea();
			echo $form->field($model, 'description_'.strtolower($key))->widget(CKEditor::className(), [
				'editorOptions' => ElFinder::ckeditorOptions('elfinder',
					['preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
						'inline' => false, //по умолчанию false]),

					]),]);
			echo $form->field($model, 'information_'.strtolower($key))->widget(CKEditor::className(), [
				'editorOptions' => ElFinder::ckeditorOptions('elfinder',
					['preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
						'inline' => false, //по умолчанию false]),

					]),]);
			echo '</div>';
		} ?>

	<?php endforeach; ?>


	<?= $form->field($model, 'category_id')->dropDownList(
		[$categories],
		['prompt' => 'Select Category']) ?>
	<?= $form->field($model, 'size[]')->widget(Select2::classname(), [

		'data' => $sizes,
		'options' => ['placeholder' => 'Select Sizes', 'value' => $model->size, 'multiple' => true],
		'pluginOptions' => [
			'tags' => true,
			'tokenSeparators' => [',', ' '],
//			'maximumInputLength' => 10
		],
	])->label('Select Sizes'); ?>
	<?= $form->field($model, 'color[]')->widget(Select2::classname(), [

		'data' => $colors,
		'options' => ['placeholder' => 'Select Colors', 'value' => $model->color, 'multiple' => true],
		'pluginOptions' => [
			'tags' => true,
			'tokenSeparators' => [',', ' '],
//			'maximumInputLength' => 10
		],
	])->label('Select Colors'); ?>

	<?= $form->field($model, 'photo')->widget(InputFile::className(), [
		'language' => 'en',
		'controller' => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
		'filter' => 'image',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
		'template' => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
		'options' => ['class' => 'form-control'],
		'buttonOptions' => ['class' => 'btn btn-default'],
		'multiple' => true       // возможность выбора нескольких файлов
	]); ?>
	<?= $form->field($model, 'price')->textInput() ?>


    <div class="form-group">
		<?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

	<?php ActiveForm::end(); ?>

</div>
