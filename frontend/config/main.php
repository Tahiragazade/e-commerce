<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
	'language'=>'az',
    'components' => [

	    'user' => [
		    'identityClass' => 'common\models\User',
		    'enableAutoLogin' => true,
		    'on afterLogin' => ['common\models\Cart', 'updateCart'],
		    'on beforeLogin' => ['common\models\Cart', 'cartUpdate'],
		    'identityCookie' => [
			    'name' => '_frontendUser', // unique for frontend
		    ]
	    ],
	    'session' => [
		    'name' => 'PHPFRONTSESSID',
		    'savePath' => sys_get_temp_dir(),
	    ],
	    'request' => [
		    // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
		    'cookieValidationKey' => 'My key is some nanay nanay',
		    'csrfParam' => '_frontendCSRF',
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
	    'urlManager' => [
		    'class' => '\common\components\I18nUrlManager',
		    'enablePrettyUrl' => true,
		    'showScriptName' => false,
		    'enableStrictParsing' => false,
		    'rules' => [
			    [
				    'pattern' => '<lang:\w+>',
				    'route' => 'site/index',
				    'suffix' => '',
			    ],
			    [
				    'pattern' => '/',
				    'route' => 'site/index',
				    'suffix' => '',
			    ],
			    [
				    'pattern' => '<lang:(az|en|ru)>',
				    'route' => 'site/index',
				    'suffix' => '',
			    ],
			    [
				    'pattern' => '<lang:(az|en|ru)>/<action>',
				    'route' => 'site/<action>',
				    'suffix' => '.html',
			    ],
			    [
				    'pattern' => '<action>',
				    'route' => 'site/<action>',
				    'defaults' => ['action' => 'index'],
				    'suffix' => '.html',
			    ],

		    ],
	    ],
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
];
