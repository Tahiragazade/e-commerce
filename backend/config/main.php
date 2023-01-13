<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
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
//	    'view' => [
//		    'theme' => [
//			    'pathMap' => [
//				    '@app/views' => '@vendor/hail812/yii2-adminlte3/src/views'
//			    ],
//		    ],
//	    ],
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => $params,
	'controllerMap' => [
		'elfinder' => [
			'class' => 'mihaildev\elfinder\Controller',
			//'plugin' => ['\mihaildev\elfinder\plugin\Sluggable'],
			'plugin' => [
				[
					'class'=>'\mihaildev\elfinder\plugin\Sluggable',
					'lowercase' => true,
					'replacement' => '-'
				]
			],
			'roots' => [
				[
					'baseUrl'=>'@web',
					'basePath'=>'@webroot',
					'path' => 'uploads',
					'name' => 'Global',
					'plugin' => [
						'Sluggable' => [
							'lowercase' => false,
						]
					]
				],
			]
		]
	]
];
