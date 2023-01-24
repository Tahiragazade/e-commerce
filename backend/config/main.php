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
    'modules' => [
	    'gridview' =>  [
		    'class' => '\kartik\grid\Module'
		    // enter optional module parameters below - only if you need to
		    // use your own export download action or custom translation
		    // message source
		    // 'downloadAction' => 'gridview/export/download',
		    // 'i18n' => []
	    ]
    ],
    'components' => [
	    'user' => [
//			'class'=>'yii\web\User',
		    'identityClass' => 'common\models\Admin',
		    'enableAutoLogin' => true,
		    'identityCookie' => [
			    'name' => '_backendUser', // unique for backend
		    ]
	    ],
	    'session' => [
		    'name' => 'PHPBACKSESSID',
		    'savePath' => sys_get_temp_dir(),
	    ],
	    'request' => [
		    // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
		    'cookieValidationKey' => 'This is my another nanay nanay key',
		    'csrfParam' => '_backendCSRF',
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
