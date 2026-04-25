<?php
namespace frontend\controllers;

use Yii;

//use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
//use yii\web\ForbiddenHttpException;
//use yii\web\HttpException;

/**
 * Class ArticleController
 * @author Eugene Terentev <eugene@terentev.net>
 */
class ScanLogController extends ActiveController
{
//    public $modelClass = '\common\models\ScanLog';
    public $modelClass = '\backend\modules\scan\models\ScanLog';
    protected function verbs()
{
    return [
        'index' => ['GET', 'HEAD'],
        'view' => ['GET', 'HEAD'],
        'create' => ['POST'],
        'update' => ['PUT', 'PATCH'],
        'delete' => ['DELETE'],
    ];
}
    public function behaviors()
    {
        return 
        \yii\helpers\ArrayHelper::merge(parent::behaviors(), [
            'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
            ],
        ]);
    }
}
