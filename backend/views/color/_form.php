<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Color $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="color-form">

    <?php $form = ActiveForm::begin(); ?>
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
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
