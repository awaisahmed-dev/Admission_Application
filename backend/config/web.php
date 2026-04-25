<?php

$params = require(__DIR__ . '/params.php');


$config = [
    'id'=> 'school_management', 
    'name'=> 'Campus Management', 
    'homeUrl'=>Yii::getAlias('@backendUrl'),
    'controllerNamespace' => 'backend\controllers',
    'defaultRoute'=>'timeline-event/index',
    'timeZone' => 'Asia/Karachi',
    'controllerMap'=>[
        'file-manager-elfinder' => [
            'class' => 'mihaildev\elfinder\Controller',
            'access' => ['manager'],
            'disabledCommands' => ['netmount'],
            'roots' => [
                [
                    'baseUrl' => '@storageUrl',
                    'basePath' => '@storage',
                    'path'   => '/',
                    'access' => ['read' => 'manager', 'write' => 'manager']
                ]
            ]
        ]
    ],
    'components'=>[
        'formatter' => [
//            'dateFormat' => 'dd.MM.yyyy',
            'decimalSeparator' => '.',
            'thousandSeparator' => ',',
            'currencyCode' => 'PKR',
            'defaultTimeZone' => 'UTC',
            'timeZone' => 'Asia/Karachi',
       ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'request' => [
            'cookieValidationKey' => env('BACKEND_COOKIE_VALIDATION_KEY'),
            
        ],
        /*'cache' => [
            'class' => 'yii\caching\ApcCache',
            'keyPrefix' => 'schoolmanagement',       // a unique cache key prefix
            'useApcu' => true,
        ],*/
         'user' => [
//        'class' => 'webvimark\modules\UserManagement\components\UserConfig',
        'class' => 'webvimark\modules\UserManagement\components\UserConfig',
        'loginUrl'=>['user-management/auth/login'],     

        // Comment this if you don't want to record user logins
        'on afterLogin' => function($event) {
                \webvimark\modules\UserManagement\models\UserVisitLog::newVisitor($event->identity->id);
            }
        ],
        'fcm' => [
        'class' => 'understeam\fcm\Client',
        'apiKey' => 'AIzaSyD-odBMAhsWLO2niwX7hEQ3F0YPh_oEg-k', // Server API Key (you can get it here: https://firebase.google.com/docs/server/setup#prerequisites) 
    ],        
//        'user' => [
//            'class'=>'yii\web\User',
//            'identityClass' => 'common\models\User',
//            'loginUrl'=>['sign-in/login'],
//            'enableAutoLogin' => true,
//            'as afterLogin' => 'common\behaviors\LoginTimestampBehavior'
//        ],
//    'commandBus' => [
//        'class' => '\trntv\tactician\Tactician',
//        'commandNameExtractor' => '\League\Tactician\Handler\CommandNameExtractor\ClassNameExtractor',
//        'methodNameInflector' => '\League\Tactician\Handler\MethodNameInflector\HandleInflector',
//        'commandToHandlerMap' => [
//            'app\commands\command\SendEmailCommand' => 'app\commands\handler\SendEmailHandler'
//        ],]            
    ],
    'modules'=>[
        'i18n' => [
            'class' => 'backend\modules\i18n\Module',
            'defaultRoute'=>'i18n-message/index'
        ],
    'user-management' => [
        'class' => 'webvimark\modules\UserManagement\UserManagementModule',
        'viewPath' => '@app/views/user-management',

        // 'enableRegistration' => true,

        // Add regexp validation to passwords. Default pattern does not restrict user and can enter any set of characters.
        // The example below allows user to enter :
        // any set of characters
        // (?=\S{8,}): of at least length 8
        // (?=\S*[a-z]): containing at least one lowercase letter
        // (?=\S*[A-Z]): and at least one uppercase letter
        // (?=\S*[\d]): and at least one number
        // $: anchored to the end of the string

        //'passwordRegexp' => '^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$',


        // Here you can set your handler to change layout for any controller or action
        // Tip: you can use this event in any module
        'on beforeAction'=>function(yii\base\ActionEvent $event) {
                if ( $event->action->uniqueId == 'user-management/auth/login' )
                {
                    $event->action->controller->layout = 'loginLayout.php';
                };
            },
    ],
    'admission' => [
    'class' => 'backend\modules\admission\Module',
    ],
    'notification' => [
            'class' => 'backend\modules\notification\NotificationModule',
        ],
    'school-management' => [
            'class' => 'backend\modules\SchoolManagement\SchoolManagementModule',
        ],
    'fee-management' => [
        'class' => 'backend\modules\fee\FeeModule',
    ],                
    'property-management' => [
            'class' => 'backend\modules\property\PropertyModule',
        ],  
    'reports' => [
            'class' => 'backend\modules\reports\ReportsModule',
        ],
    'inventory-management' => [
            'class' => 'backend\modules\inventory\InventotyModule',
        ],                
    'scan' => [
            'class' => 'backend\modules\scan\ScanModule',
        ],                
    'attendance' => [
            'class' => 'backend\modules\attendance\AttendanceModule',
        ],  
    'timetable' => [
            'class' => 'backend\modules\timetable\TimetableModule',
        ],                
    'elearning' => [
            'class' => 'backend\modules\elearning\Module',
        ],                
    ],
//    'as ghost-access'=> [
//            'class' => 'webvimark\modules\UserManagement\components\GhostAccessControl',
//            ],            
    'as globalAccess'=>[
        'class'=>'\common\behaviors\GlobalAccessBehavior',
        'rules'=>[
            [
                'controllers'=>['user-management/auth', 'sign-in'],
                'allow' => true,
                'roles' => ['?', '@'],
                'actions'=>['login']
            ],
            [
                'controllers'=>['user-management/auth', 'sign-in'],
                'allow' => true,
                'roles' => ['@'],
                'actions'=>['logout']
            ],
            [
                'controllers'=>['timeline-event'],
                'allow' => true,
                'roles' => ['@'],
                'actions'=>['index']
            ],
            [
                'controllers'=>['site'],
                'allow' => true,
                'roles' => ['?', '@'],
                'actions'=>['error']
            ],
            [
                'controllers'=>['debug/default'],
                'allow' => true,
                'roles' => ['?'],
            ],
            [
                'controllers'=>['gii'],
                'allow' => true,
                'roles' => ['?'],
            ],
            [
                'controllers'=>['user-management/user', 'user-management/role',
                    'user-management/user-permission', 'user-management/permission'],
                'allow' => true,
                'roles' => ['Admin'],
            ],
            [
                'controllers'=>['user-management/user', 'user-management/role',
                    'user-management/user-permission', 'user-management/permission'],
                'allow' => true,
                'roles' => ['Manager'],
            ],
            [
                'controllers'=>['user-management/user'],
                'allow' => false,
            ],
            [
                'allow' => true,
                'roles' => ['Manager'],
            ]
        ]
    ],
    'params' => $params,                
    'aliases' => [
    '@uploads' => '/uploads/',
    '@thumbs' => '/uploads/thumbs',
    ],                               
];

if (YII_ENV_DEV) {
	$config['modules']['debug'] = ['class' => 'yii\debug\Module',
        'allowedIPs' => ['1.2.3.4', '127.0.0.1', '182.182.111.239', '::1']
        ];
    $config['modules']['gii'] = [
        'class'=>'yii\gii\Module',
        'generators' => [
            'crud' => [
                'class'=>'yii\gii\generators\crud\Generator',
                'templates'=>[
                    'yii2-starter-kit' => Yii::getAlias('@backend/views/_gii/templates')
                ],
                'template' => 'yii2-starter-kit',
                'messageCategory' => 'backend'
            ]
        ]
    ];
}

return $config;
