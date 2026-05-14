<?php

namespace backend\modules\admission\controllers;

use Yii;
use backend\modules\admission\models\ParentModel;
use backend\modules\admission\models\search\ParentModelSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\modules\admission\models\Student;

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
    public function actionCreate()
    {
        $model = new ParentModel();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
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

//     foreach ($parent->children as $child) {

//         // Step 1: mark enrolled
//         $child->student_enrolment = 1;
//         $child->save(false);

//         // Step 2: insert into students table
//         $student = new Student();
//         $student->parent_id = $parent->id;
//         $student->child_id = $child->id;

//         $student->first_name = $child->first_name;
//         $student->last_name = $child->last_name;
//         $student->gender = $child->gender;
//         $student->date_of_birth = $child->date_of_birth;

//         $student->school_name = $child->school_name;
//         $student->school_class = $child->school_class;

//         $student->admission_type = $child->admission_type;
//         $student->created_at = time();

//         if (!$student->save()) {
//             print_r($student->errors);
//             die();
//         }
//     }

//     Yii::$app->session->setFlash('success', 'Students Enrolled Successfully');

//     return $this->redirect(['view', 'id' => $id]);
// }
public function actionAdmit($id)
{
    $parent = $this->findModel($id);

    foreach ($parent->children as $child) {

        // duplicate check
        if (\backend\modules\admission\models\Student::find()
            ->where(['child_id' => $child->id])->exists()) {
            continue;
        }

        // child enrolled
        $child->student_enrolment = 1;
        $child->save(false);

        // create student
        $student = new \backend\modules\admission\models\Student();

        $student->parent_id = $parent->id;
        $student->child_id = $child->id;

        $student->first_name = $child->first_name;
        $student->last_name = $child->last_name;
        $student->gender = $child->gender;
        $student->date_of_birth = $child->date_of_birth;

        $student->school_name = $child->school_name;
        $student->school_class = $child->school_class;

        $student->admission_type = $child->admission_type;
        $student->created_at = time();

        $student->save(false);
    }

    // parent status update
    $parent->status = 1;
    $parent->save(false);

    Yii::$app->session->setFlash('success', 'Students Enrolled Successfully');

    // return $this->redirect(['index']);
    return $this->redirect(['/admission/student/index']);
}


// public function actionUpdate($id)
// {
//     $parentModel = ParentModel::findOne($id);

//     if (!$parentModel) {
//         throw new \yii\web\NotFoundHttpException('Record not found');
//     }

//     // Load children
//     $children = ChildModel::find()
//         ->where(['parent_id'=>$id])
//         ->all();

//     if(empty($children)){
//         $children[] = new ChildModel();
//     }

//     // Load policy
//     $policyModel = PolicyModel::findOne([
//         'parent_id'=>$id
//     ]);

//     if(!$policyModel){
//         $policyModel = new PolicyModel();
//         $policyModel->parent_id=$id;
//     }


//     if (
//         $parentModel->load(Yii::$app->request->post())
//     ) {

//         $transaction=Yii::$app->db->beginTransaction();

//         try{

//             $parentModel->save(false);

//             /*
//              CHILDREN UPDATE
//             */
//             $childrenPost=
//                 Yii::$app->request
//                     ->post('ChildModel',[]);

//             foreach($childrenPost as $i=>$row){

//                 if(isset($children[$i])){
//                     $child=$children[$i];
//                 }else{
//                     $child=new ChildModel();
//                     $child->parent_id=$id;
//                 }

//                 $child->attributes=$row;

//                 $child->student_enrolment=
//                     isset($row['student_enrolment'])
//                         ?1:0;

//                 $child->allergy_to_medication=
//                     isset($row['allergy_to_medication'])
//                         ?1:0;

//                 $child->save(false);
//             }


//             /*
//              POLICY UPDATE
//             */
//             $policyModel->load(
//                 Yii::$app->request->post()
//             );

//             $policyModel->volunteer_cleaning =
//                 Yii::$app->request
//                     ->post('PolicyModel')['volunteer_cleaning'] ?? 0;

//             $policyModel->volunteer_snacks =
//                 Yii::$app->request
//                     ->post('PolicyModel')['volunteer_snacks'] ?? 0;

//             $policyModel->volunteer_supervision =
//                 Yii::$app->request
//                     ->post('PolicyModel')['volunteer_supervision'] ?? 0;

//             $policyModel->volunteer_admin =
//                 Yii::$app->request
//                     ->post('PolicyModel')['volunteer_admin'] ?? 0;

//             $policyModel->volunteer_teaching_quran =
//                 Yii::$app->request
//                     ->post('PolicyModel')['volunteer_teaching_quran'] ?? 0;

//             $policyModel->volunteer_teaching_islamic =
//                 Yii::$app->request
//                     ->post('PolicyModel')['volunteer_teaching_islamic'] ?? 0;

//             $policyModel->volunteer_teaching_urdu =
//                 Yii::$app->request
//                     ->post('PolicyModel')['volunteer_teaching_urdu'] ?? 0;


//             $policyModel->save(false);


//             $transaction->commit();

//             Yii::$app->session->setFlash(
//                 'success',
//                 'Application Updated Successfully'
//             );

//             return $this->redirect(['index']);

//         }
//         catch(\Exception $e){

//             $transaction->rollBack();
//             throw $e;
//         }
//     }

//     return $this->render('update',[
//         'parentModel'=>$parentModel,
//         'children'=>$children,
//         'policyModel'=>$policyModel
//     ]);
// }
}
