<?php

namespace backend\controllers;

use Yii;
use backend\models\search\TimelineEventSearch;
use backend\modules\notification\models\NotificationSearch;
use backend\modules\SchoolManagement\models\Student;
use yii\web\Controller;

/**
 * Application timeline controller
 */
class TimelineEventController extends Controller
{
    public $layout = 'common';
    /**
     * Lists all TimelineEvent models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TimelineEventSearch();
        $queryParams = array_merge(array(),Yii::$app->request->getQueryParams());
         
        	
        $dataProvider = $searchModel->search($queryParams);
        
        $dataProvider->sort = [
            'defaultOrder'=>['created_at'=>SORT_DESC]
        ];
		
		

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'notificationProvider' => $notificationProvider,
        ]);
    }
}
