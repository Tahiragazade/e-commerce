<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\InputFile;
use mihaildev\elfinder\ElFinder;

/** @var yii\web\View $this */
/** @var common\models\Category $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'parent_id')->dropDownList(
		[ $categories,        ],
		[ 'prompt'=>'Select Parent Group']) ?>
    <div class="tab">
		<?php foreach($langs as $key=>$value): ?>
			<?php if($key=='az'){
				echo  '<button type="button" class="tablinks active" onclick="changeLang(event, \''.$key.'\')">'.$value.'</button>';
			}else{

				echo  '<button type="button"  class="tablinks" onclick="changeLang(event, \''.$key.'\')">'.$value.'</button>';
			}?>
		<?php endforeach; ?>
    </div>
	<?php foreach($langs as $key=>$value): ?>
		<?php if($key=='az'){
			echo '	<div id='.$key.' class="tabcontent" style="display:block">';
			echo $form->field($model, 'name_'.strtolower($key))->textInput();
			echo '</div>';
		}else{
			echo '	<div id='.$key.' class="tabcontent">';
			echo $form->field($model, 'name_'.strtolower($key))->textInput();
			echo '</div>';
		}?>

	<?php endforeach; ?>
	<?= $form->field($model, 'photo')->widget(InputFile::className(), [
		'language' => 'en',
		'controller' => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
		'filter' => 'image',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
		'template' => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
		'options' => ['class' => 'form-control'],
		'buttonOptions' => ['class' => 'btn btn-default'],
		'multiple' => true       // возможность выбора нескольких файлов
	]); ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
