<?php
$config = [
    'components' => [
        'assetManager' => [
            'class' => 'yii\web\AssetManager',
            'linkAssets' => env('LINK_ASSETS'),
            'appendTimestamp' => YII_ENV_DEV
        ],
        'formatter' => [
            'class' => '\common\components\CustomFormatter',
            // other settings for formatter
    //        'dateFormat' => 'yyyy-MM-dd',
        ], 
        'request' => [
    'parsers' => [
        'application/json' => 'yii\web\JsonParser',
    ]
]
    ],
//    'modules'=>[
//    'user-management' => [
//        'class' => 'webvimark\modules\UserManagement\UserManagementModule',
//            'controllerNamespace'=>'vendor\webvimark\modules\UserManagement\controllers', // To prevent yii help from crashing
//        ],
//    ],
    'as locale' => [
        'class' => 'common\behaviors\LocaleBehavior',
        'enablePreferredLanguage' => true
    ]
];

if (YII_DEBUG) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.33.1', '172.17.42.1', '172.17.0.1', '192.168.99.1'],
    ];
}

if (YII_ENV_DEV) {
    $config['modules']['gii'] = [
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}


return $config;
