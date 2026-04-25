<?php
return [
    'class'=>'yii\web\UrlManager',
    'enablePrettyUrl'=>true,
    'showScriptName'=>false,
    'rules'=> [
        // Pages
        ['pattern'=>'page/<slug>', 'route'=>'page/view'],

        // Articles
        ['pattern'=>'article/index', 'route'=>'article/index'],
        ['pattern'=>'article/attachment-download', 'route'=>'article/attachment-download'],
        ['pattern'=>'article/<slug>', 'route'=>'article/view'],

        // Api
//        ['pattern'=>'scan-log/batch', 'route'=>'api/v1/scan-log'],
        ['class' => 'yii\rest\UrlRule', 'controller' => 'api/v1/scan-log', 'pluralize'=>false],
        ['class' => 'yii\rest\UrlRule', 'controller' => 'api/v1/device-registration', 'pluralize'=>false],
        ['class' => 'yii\rest\UrlRule', 'controller' => 'api/v1/notification', 'pluralize'=>false],
         
//        ['class' => 'yii\rest\UrlRule', 'controller' => ['api/v1/scan-log']],
        ['class' => 'yii\rest\UrlRule', 'controller' => 'api/v1/article', 'only' => ['index', 'view', 'options']],
		['class' => 'yii\rest\UrlRule', 'controller' => 'api/v1/articleapi', 'only' => ['index', 'view', 'options']],
        ['class' => 'yii\rest\UrlRule', 'controller' => 'api/v1/user', 'only' => ['index', 'view', 'options']]
    ]
];
