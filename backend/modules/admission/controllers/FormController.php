<?php

namespace backend\modules\admission\controllers;

use Yii;
use yii\web\Controller;
use backend\modules\admission\models\ParentModel;
use backend\modules\admission\models\ChildModel;
use backend\modules\admission\models\PolicyModel;

use common\models\User;
use common\models\UserProfile;

class FormController extends Controller
{
    public function actionIndex()
    {
        $parentModel = new ParentModel();
        $policyModel = new PolicyModel();

        // at least 1 child
        $children = [new ChildModel()];

        if ($parentModel->load(Yii::$app->request->post())) {

    $policyModel->load(Yii::$app->request->post());

    $childrenData = Yii::$app->request->post('ChildModel', []);
    $children = [];

    foreach ($childrenData as $childData) {

        $child = new ChildModel();
        $child->attributes = $childData;

        $child->student_enrolment =
            isset($childData['student_enrolment']) ? 1 : 0;

        $child->allergy_to_medication =
            isset($childData['allergy_to_medication']) ? 1 : 0;

        $children[] = $child;
    }

    $post = Yii::$app->request->post('PolicyModel', []);

    $policyModel->volunteer_cleaning =
        isset($post['volunteer_cleaning']) ? 1 : 0;

    $policyModel->volunteer_snacks =
        isset($post['volunteer_snacks']) ? 1 : 0;

    $policyModel->volunteer_supervision =
        isset($post['volunteer_supervision']) ? 1 : 0;

    $policyModel->volunteer_admin =
        isset($post['volunteer_admin']) ? 1 : 0;

    $policyModel->volunteer_teaching_quran =
        isset($post['volunteer_teaching_quran']) ? 1 : 0;

    $policyModel->volunteer_teaching_islamic =
        isset($post['volunteer_teaching_islamic']) ? 1 : 0;

    $policyModel->volunteer_teaching_urdu =
        isset($post['volunteer_teaching_urdu']) ? 1 : 0;


    $transaction = Yii::$app->db->beginTransaction();

    // try {

        // $parentModel->status = 0;

        // $parentModel->save(false);

        // $user = new User();

        //     $user->username = strtolower(
        //         str_replace(' ', '', $parentModel->father_first_name)
        //     ) . rand(100,999);

        //     $user->email = $parentModel->father_email;

        //     $password = Yii::$app->security->generateRandomString(8);

        //     $user->setPassword($password);

        //     $user->status = User::STATUS_ACTIVE;

        //     if(!$user->save()){
        //         throw new \Exception(json_encode($user->errors));
        //     }

        //     $user->afterSignup();

        //     $parentModel->user_id = $user->id;
        //     $parentModel->save(false);

        //     $profile = new UserProfile();

        //     $profile->user_id = $user->id;

        //     $profile->firstname =
        //         $parentModel->father_first_name;

        //     $profile->lastname =
        //         $parentModel->father_last_name;

        //     $profile->save(false);

        try {

    $parentModel->status = 0;

    if(!$parentModel->save()){
        throw new \Exception(json_encode($parentModel->errors));
    }

    foreach ($children as $child) {

        $child->parent_id = $parentModel->id;
        $child->status = 0;

        if(!$child->save()){
            throw new \Exception(json_encode($child->errors));
        }
    }

    $policyModel->parent_id = $parentModel->id;
    $policyModel->status = 0;

    if(!$policyModel->save()){
        throw new \Exception(json_encode($policyModel->errors));
    }

    $transaction->commit();

        Yii::$app->session->setFlash(
            'browserNotification',
            [
                'title' => 'Application Submitted Successfully',
                'body'  =>
                    'Parent ID : '.$parentModel->id." ".
                    // 'Student ID : Pending'."\n".
                    'Parent Name : '.$parentModel->father_first_name.' '.$parentModel->father_last_name."\n".
                    'Student Name : '.$children[0]->first_name.' '.$children[0]->last_name."\n".
                    'Student Class : '.$children[0]->school_class."\n".
                    'Submission Date : '.date('d-m-Y h:i A', $parent->created_at)
            ]
        );
        
        Yii::$app->session->setFlash(
            'success',
            'Application Submitted Successfully'
        );
        
        return $this->refresh();

    } catch (\Exception $e) {

        $transaction->rollBack();

        echo $e->getMessage();
        die();
    }
}

        return $this->render('index', [
            'parentModel' => $parentModel,
            'children' => $children,
            'policyModel' => $policyModel,
        ]);
    }
}