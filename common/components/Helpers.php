<?php

namespace common\components;

use common\models\Lang;
use yii\helpers\ArrayHelper;

class Helpers
{
	public static function getLangList()
	{
		$language = ArrayHelper::map(Lang::find()->all(), 'name', function($model, $defaultValue) {
			return strtolower($model->key);
		});
	return $language;
	}
}