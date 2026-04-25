<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ListView;
use yii\jui\Accordion;
use yii\bootstrap\Tabs;
use webvimark\modules\UserManagement\models\UserProgress;
use yii\data\ActiveDataProvider;
/* @var $this yii\web\View */
/* @var $model app\models\UserProfile */

$this->title = $model->full_name;
$this->params['breadcrumbs'][] = ['label' => 'User Profiles',
    'url' => ['/user-management/user/index']];//'index'
$this->params['breadcrumbs'][] = $this->title;

 $userRole = $model->user->roles[0]->name;
?>
<div class="user-profile-view">

    <h1> <?= Html::encode($this->title) ?>'s Profile view</h1>

    <p>
        <?php  if (Yii::$app->user->role != "Instructor") {
            print Html::a('Update', ['update', 'user_id' => $model->user_id], ['class' => 'btn btn-primary']);?>
        
        <?= Html::a( 'Students List »', 
                ['/school-management/student/index', 'StudentSearch[parent_id]' => $model->user_id], 
                ['class' => 'btn btn-primary']) ?>
        <?= Html::a( 'Fee History »',
                ['/fee-management/student-fee/index', 'StudentFeeSearch[parent_id]' => $model->user_id], 
                ['class' => 'btn  btn-primary']) ;    
        }
          ?>
          <?php if ($userRole != "Manager"){
              Html::a('Delete', ['delete', 'user_id' => $model->user_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]); } ?>
    </p>
    <?php
   $detailView =  
    DetailView::widget([
        'model' => $model,
        'attributes' => [

//            'user_id',
//            'created_at',
//            'updated_at',
            'family_key',
            'full_name',
            'user.username',
            'user.email',
            'job_title',
            'information:ntext',
            'phone',
            'cell_number',
            'emergency_contact:ntext',
            'email_alternate:email',
          
        ],
    ]);
   if($userRole != 'Instructor'){
       echo $detailView;
   }else{
//    print $model->user->id;
       $instProgress = UserProgress::findAll(['user_id'=>$model->user->id]);
       $dataProvider = new ActiveDataProvider([
            'query' => UserProgress::find()->where(['user_id'=>$model->user->id])->orderBy('type'),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
       
       
       echo Tabs::widget([
    'items' => [
        [
            'label' => 'Profile',
            'content' => $detailView,
            'active' => true
        ],
        [
            'label' => 'Progress',
            'content' => ListView::widget([
                'dataProvider' => $dataProvider,
                'options' => [
                    'tag' => 'div',
                    'class' => 'list-wrapper',
                    'id' => 'list-wrapper',
                ],
                'itemView' => '_list_item',    
//                'layout' => "{pager}\n{items}\n{summary}",
                'layout' => "{items}",
                ]),
//            'headerOptions' => [...], 
            'options' => ['id' => 'myveryownID'],
        ],
        
        [
            'label' => 'Dropdown',
            'visible'=>FALSE,
            'items' => [
                 [
                     'label' => 'DropdownA',
                     'content' => 'DropdownA, Anim pariatur cliche...',
                 ],
                 [
                     'label' => 'DropdownB',
                     'content' => 'DropdownB, Anim pariatur cliche...',
                 ],
                 [
                     'label' => 'External Link',
                     'url' => 'http://www.example.com',
                     'content' => 'DropdownA, Anim pariatur cliche...',
                 ],
            ],
        ],
        
        ],
    ]);
   }
?>

</div>
