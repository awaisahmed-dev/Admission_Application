<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;

class AdmissionController extends Controller
{
    public function actionApply()
    {
        return $this->render('apply');
    }
}
?>