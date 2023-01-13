<?php

namespace common\components;

use common\models\Message;
use common\models\SourceMessage;
use Yii;
use yii\i18n\MissingTranslationEvent;

class I18N extends \yii\i18n\I18N
{

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		return parent::init();
	}

	public static function autoInsert($category, $message)
	{

		if($category != 'app' || $category != 'backend' || $category != 'frontend') {
			return true;
		}

		$check = SourceMessage::find()->where([
			'category' => $category,
			'message' => $message
		])->one();

		if(!$check) {
			$sm = new SourceMessage();
			$sm->category = $category;
			$sm->message = $message;
			$sm->save();
			$m = Message::find()->where(['id' => $sm->id])->all();
			if(!$m) {
				foreach(Yii::$app->params['languages'] as $key => $value) {
					$m = new Message();
					$m->id = $sm->id;
					$m->language = $key;
					$m->translation = $message;
					// if($key == 'az')
					//     $m->translation = $message;
					// else
					//     $m->translation = null;
					$m->save(false);
				}
			}
		}
	}

	public static function handleMissingTranslation(MissingTranslationEvent $event)
	{
		self::autoInsert($event->category, $event->message);
		//$event->translatedMessage = "@MISSING: {$event->category}.{$event->message} FOR LANGUAGE {$event->language} @";
	}

}