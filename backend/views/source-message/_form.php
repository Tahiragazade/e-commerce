<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\SourceMessage $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="source-message-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'message')->textarea(['rows' => 6]) ?>
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
			echo $form->field($model, 'translation_'.strtolower($key))->textInput(['maxlength' => 255])->label(ucfirst(strtolower($key)).'&nbsp;'.Yii::t('backend','Title'));
			echo '</div>';
		}else{
			echo '	<div id='.$key.' class="tabcontent">';
			echo $form->field($model, 'translation_'.strtolower($key))->textInput(['maxlength' => 255])->label(ucfirst(strtolower($key)).'&nbsp;'.Yii::t('backend','Title'));
			echo '</div>';
		}?>

	<?php endforeach; ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
