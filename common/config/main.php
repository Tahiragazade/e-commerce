<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
	    'i18n' => [
		    'class' => 'common\components\I18N',
		    'translations' => [
			    '*' => [
				    'class' => 'yii\i18n\DbMessageSource',
				    'enableCaching' => false,
				    'cachingDuration' => 3600,
				    'on missingTranslation' => ['common\components\I18N', 'handleMissingTranslation']
			    ]
		    ],
	    ],
	    'helper'=>[
		    'class' => 'common\components\Helpers',
	    ],
	    'base' => [
		    'class' => 'common\components\Base'
	    ],
    ],
];
