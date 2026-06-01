<?php

namespace backend\modules\admission\controllers;

use Yii;
use backend\modules\admission\models\ParentModel;
use backend\modules\admission\models\search\ParentModelSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\modules\admission\models\Student;

use backend\modules\admission\models\ChildModel;
use backend\modules\admission\models\PolicyModel;

use common\models\User;
use common\models\UserProfile;

/**
 * ParentController implements the CRUD actions for ParentModel model.
 */
class ParentController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all ParentModel models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ParentModelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ParentModel model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ParentModel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    // public function actionCreate()
    // {
    //     $model = new ParentModel();

    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //         return $this->redirect(['view', 'id' => $model->id]);
    //     }

    //     return $this->render('create', [
    //         'model' => $model,
    //     ]);
    // }
    public function actionCreate()
{
    $model = new ParentModel();

    if ($model->load(Yii::$app->request->post())) {

        $model->status = 0;

        if($model->save()){
            return $this->redirect([
                'view',
                'id'=>$model->id
            ]);
        }
    }

    return $this->render('create',[
        'model'=>$model
    ]);
}

    /**
     * Updates an existing ParentModel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    // public function actionUpdate($id)
    // {
    //     $model = $this->findModel($id);

    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //         return $this->redirect(['view', 'id' => $model->id]);
    //     }

    //     return $this->render('update', [
    //         'model' => $model,
    //     ]);
    // }



    public function actionUpdate($id)
{
    $parentModel = $this->findModel($id);

    // children load
    $children = $parentModel->children;

    if(empty($children)){
        $children = [new ChildModel()];
    }

    // policy load
    $policyModel = $parentModel->policies
        ? $parentModel->policies[0]
        : new PolicyModel();



    if(
        $parentModel->load(Yii::$app->request->post()) &&
        $policyModel->load(Yii::$app->request->post())
    ){

        $childrenData = Yii::$app->request->post('ChildModel',[]);

        $valid=true;

        $parentModel->save(false);

        foreach($children as $i=>$child){

            if(isset($childrenData[$i])){
                $child->load(
                    ['ChildModel'=>$childrenData[$i]],
                    ''
                );

                if(!$child->save()){
                    $valid=false;
                }
            }
        }

        $policyModel->parent_id=$parentModel->id;
        $policyModel->save(false);

        if($valid){
            Yii::$app->session->setFlash(
                'success',
                'Updated successfully'
            );

            return $this->redirect([
                'view',
                'id'=>$parentModel->id
            ]);
        }

    }

    return $this->render('update',[
        'parentModel'=>$parentModel,
        'children'=>$children,
        'policyModel'=>$policyModel
    ]);
}


    /**
     * Deletes an existing ParentModel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ParentModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ParentModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ParentModel::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

// public function actionAdmit($id)
// {
//     $parent = $this->findModel($id);

//     if(!$parent->user_id){

//     $user = new User();

//     $user->username =
//         strtolower($parent->father_first_name)
//         . rand(100,999);

//     $user->email =
//         $parent->father_email;

//     $user->status =
//         User::STATUS_ACTIVE;

//     $user->setPassword('123456');

//     if(!$user->save()){

//         print_r($user->errors);
//         die();
//     }

//     $profile = new UserProfile();

//     $profile->user_id =
//         $user->id;

//     $profile->firstname =
//         $parent->father_first_name;

//     $profile->lastname =
//         $parent->father_last_name;

//     $profile->save(false);

//     $parent->user_id =
//         $user->id;

//     $parent->save(false);
// }

//     // agar already admit hai
//     if($parent->status==1){

//         Yii::$app->session->setFlash(
//             'warning',
//             'Already admitted'
//         );

//         return $this->redirect(['index']);
//     }

//     foreach($parent->children as $child){

//         $student = new Student();

//         // $student->parent_id = 1;
//         $student->parent_id = $parent->user_id;


//         $student->school_id=21;

//         $student->student_key=
//         'STD'.time().rand(100,999);

//         $student->full_name=
//         $child->first_name.' '.$child->last_name;

//         $student->surname=
//         $child->last_name;

//         // $student->gender=
//         // $child->gender;
//         $student->gender =
//         ($child->gender == 1)
//         ? 'Male'
//         : 'Female';

//         $student->father_name=
//         $parent->father_first_name.' '.
//         $parent->father_last_name;

//         $student->mother_name=
//         $parent->mother_first_name.' '.
//         $parent->mother_last_name;

//         $student->date_of_birth=
//         $child->date_of_birth;

//         $student->admission_date=
//         date('Y-m-d');

//         $student->address=
//         $parent->address;

//         $student->mobile=
//         $parent->father_mobile;

//         $student->email=
//         $parent->father_email;

//         $student->previous_school=
//         $child->school_name;

//         $student->admit_in_class=
//         $child->school_class;

//         $student->status=1;

//         // $student->save(false);
//         if(!$student->save()){
//     print_r($student->errors);
//     die();
// }

//         // child enrolled
//         $child->student_enrolment=1;
//         $child->save(false);
//     }

//     // parent admitted
//     $parent->status=1;
//     $parent->save(false);

//     Yii::$app->session->setFlash(
//         'success',
//         'Student admitted successfully'
//     );

//     return $this->redirect(['index']);
// }


    public function actionAdmit($id)
{
    $parent = $this->findModel($id);

    if($parent->status == 1){

        Yii::$app->session->setFlash(
            'warning',
            'Already Admitted'
        );

        return $this->redirect(['index']);
    }

    $transaction = Yii::$app->db->beginTransaction();

    try {

        if(!$parent->user_id){

            $user = new User();

            $user->school_id = 21;

            $user->branch_id = 1;

            $user->username =
            strtolower(
            $parent->father_first_name
            ).rand(100,999);

            $user->email =
            $parent->father_email;

            $user->status = 1;

            $user->email_confirmed = 1;

            $user->generateAuthKey();

            $user->generateAccessToken();

            $user->setPassword('123456');

            if(!$user->save()){
                throw new \Exception(
                    json_encode($user->errors)
                );
            }

            $profile = new UserProfile();

            $profile->user_id =
            $user->id;

            $profile->full_name =
            $parent->father_first_name.' '.
            $parent->father_last_name;

            $profile->firstname =
            $parent->father_first_name;

            $profile->lastname =
            $parent->father_last_name;

            $profile->father_name =
            $parent->father_first_name.' '.
            $parent->father_last_name;

            $profile->mother_name =
            $parent->mother_first_name.' '.
            $parent->mother_last_name;

            $profile->address =
            $parent->address;

            $profile->phone =
            $parent->home_phone;

            $profile->cell_number =
            $parent->father_mobile;

            $profile->emergency_contact =
            $parent->emergency_contact_number;

            $profile->email_alternate =
            $parent->father_email;

            $profile->address =
                $parent->address;

            $profile->phone =
                $parent->home_phone;

            $profile->cell_number =
                $parent->father_mobile;

            $profile->emergency_contact =
                $parent->emergency_contact_number;

            $profile->locale = 'en-US';

            $profile->save(false);

            $parent->user_id =
                $user->id;

            $parent->save(false);
        }


        foreach($parent->children as $child){

            $student = new Student();

             $lastStudent = Student::find()
    ->orderBy(['id'=>SORT_DESC])
    ->one();

    // $student->gr_number =
    // $lastStudent
    // ? $lastStudent->gr_number + 1
    // : 1001;
        $student->gr_number = (string)(
        $lastStudent
        ? ((int)$lastStudent->gr_number + 1)
        : 1001
    );

    $lastSeat = Student::find()
    ->max('seat_number');

    $student->seat_number =
    $lastSeat
    ? $lastSeat + 1
    : 1;

            $student->parent_id =
                $parent->user_id;
            // $student->parent_id = $parent->id;

            // $student->school_id = 21;
            $student->school_id = $user->school_id;
            // $student->school_id = $parent->school_id;

            $student->student_key =
                'STD'.time().rand(100,999);

            $student->full_name =
                $child->first_name.' '.$child->last_name;

            $student->surname =
                $child->last_name;

            $student->gender =
                $child->gender == 1
                ? 'Male'
                : 'Female';

            $student->father_name =
                $parent->father_first_name.' '.
                $parent->father_last_name;

            $student->mother_name =
                $parent->mother_first_name.' '.
                $parent->mother_last_name;

            $student->date_of_birth =
                $child->date_of_birth;

            $student->admission_date =
                date('Y-m-d');

            $student->address =
                $parent->address;

            $student->mobile =
                $parent->father_mobile;

            $student->email =
                $parent->father_email;

            $student->previous_school =
                $child->school_name;

            $student->admit_in_class =
                $child->school_class;

            $student->status = 1;

            if(!$student->save()){
                throw new \Exception(
                    json_encode($student->errors)
                );
            }

            $child->student_enrolment = 1;
            $child->save(false);
        }

        $parent->status = 1;
        $parent->save(false);

        $transaction->commit();

        Yii::$app->session->setFlash(
            'success',
            'Student Admitted Successfully'
        );

    } catch(\Exception $e){

        $transaction->rollBack();

        throw $e;
    }

    return $this->redirect(['index']);

    
}

}
