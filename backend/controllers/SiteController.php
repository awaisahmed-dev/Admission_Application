<?php
namespace backend\controllers;

use common\components\keyStorage\FormModel;
use Yii;
use common\models\Notification;
/**
 * Site controller
 */
class SiteController extends \yii\web\Controller
{
    public $freeAccessActions  = ['privacy'];
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    public function beforeAction($action)
    {
        $this->layout = Yii::$app->user->isGuest || !Yii::$app->user->can('loginToBackend') ? 'base' : 'common';
        return parent::beforeAction($action);
    }

    public function actionSettings()
    {
        $model = new FormModel([
            'keys' => [
//                'frontend.maintenance' => [
//                    'label' => Yii::t('backend', 'Frontend maintenance mode'),
//                    'type' => FormModel::TYPE_DROPDOWN,
//                    'items' => [
//                        'disabled' => Yii::t('backend', 'Disabled'),
//                        'enabled' => Yii::t('backend', 'Enabled')
//                    ]
//                ],
                'backend.theme-skin' => [
                    'label' => Yii::t('backend', 'Backend theme'),
                    'type' => FormModel::TYPE_DROPDOWN,
                    'items' => [
                        'skin-black' => 'skin-black',
                        'skin-blue' => 'skin-blue',
                        'skin-green' => 'skin-green',
                        'skin-purple' => 'skin-purple',
                        'skin-red' => 'skin-red',
                        'skin-yellow' => 'skin-yellow'
                    ]
                ],
                'backend.layout-fixed' => [
                    'label' => Yii::t('backend', 'Fixed backend layout'),
                    'type' => FormModel::TYPE_CHECKBOX
                ],
                'backend.layout-boxed' => [
                    'label' => Yii::t('backend', 'Boxed backend layout'),
                    'type' => FormModel::TYPE_CHECKBOX
                ],
                'backend.layout-collapsed-sidebar' => [
                    'label' => Yii::t('backend', 'Backend sidebar collapsed'),
                    'type' => FormModel::TYPE_CHECKBOX
                ]
            ]
        ]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('alert', [
                'body' => Yii::t('backend', 'Settings was successfully saved'),
                'options' => ['class' => 'alert alert-success']
            ]);
            return $this->refresh();
        }

        return $this->render('settings', ['model' => $model]);
    }
    
    public function actionPrivacy() {
        Print "Privacy Policy Here";
    }
    public function actionTerms() {
        Print "Terms";
    }

    public function actionBrowserNotification()
{
    Yii::$app->response->format=\yii\web\Response::FORMAT_JSON;

    $notifications=Notification::find()
        ->where([
            'medium'=>'browser',
            'status'=>0
        ])
        ->all();

    if(empty($notifications))
    {
        return [
            'success'=>false
        ];
    }

    
    if(count($notifications)>=5){

    foreach($notifications as $notification)
    {
        $notification->status=1;
        $notification->save(false);
    }


        return [

            'success'=>true,

            'title'=>'Admission Notification',

            'body'=>count($notifications).' New Application Forms Submitted'

        ];
    }

    $notification=$notifications[0];

    $data=json_decode($notification->contents,true);

    $notification->status = 1;
    $notification->save(false);

    return [

        'success'=>true,

        'title'=>'New Admission Application',

        'body'=>

        "Parent Name : ".$data['parent_name']."\n".

        "Student Name : ".$data['student_name']."\n".

        "Class : ".$data['class']."\n".

        "Submission Date : " . $data['date']

    ];

}

}
