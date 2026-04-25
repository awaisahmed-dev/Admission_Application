<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use webvimark\modules\UserManagement\models\rbacDB\Role;

/* @var $this yii\web\View */
/* @var $model app\models\UserProfile */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $userRoles = Role::getAvailableRoles();?>
<div class="user-profile-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'family_key')->textInput(['maxlength' => true]) ?>
   <div class="row">
                <div class="col-md-6">
    <?= $form->field($model, 'full_name')->textInput(['maxlength' => true]) ?>    
               </div>
                <div class="col-md-6">      
    <?= $form->field($model, 'surname')->textInput(['maxlength' => true]) ?>    
                </div>
   </div>
            <div class="row">
                <div class="col-md-6">
    <?= $form->field($model, 'firstname')->textInput(['maxlength' => true]) ?>    
                </div>
                <div class="col-md-6">    
    <?= $form->field($model, 'lastname')->textInput(['maxlength' => true]) ?>    
                </div>
   </div>
    
<div class="row">
                <div class="col-md-6">
    <?= $form->field($model, 'date_of_birth')->textInput(['maxlength' => true]) ?>    
                </div>
                <div class="col-md-6">
    <?= $form->field($model, 'CNIC')->textInput(['maxlength' => true]) ?>    
                </div>
   </div>
<div class="row">
                <div class="col-md-6">
    <?= $form->field($model, 'nationality')->textInput(['maxlength' => true]) ?>    
                </div>
                <div class="col-md-6">
    <?= $form->field($model, 'passport_number')->textInput(['maxlength' => true]) ?>    
                </div>
   </div>
    <div class="row">
                <div class="col-md-6">
    <?= $form->field($model, 'domicile')->textInput(['maxlength' => true]) ?>    
                </div>
                <div class="col-md-6">
    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>    
                </div>
   </div>
    <div class="row">
                <div class="col-md-6">
    <?= $form->field($model, 'qualification')->textInput(['maxlength' => true]) ?>    
                </div>
                <div class="col-md-6">
    <?= $form->field($model, 'profession')->textInput(['maxlength' => true]) ?>    
                </div>
   </div>
    <div class="row">
                <div class="col-md-6">
    <?= $form->field($model, 'job_title')->textInput(['maxlength' => true]) ?>    
                </div>
                <div class="col-md-6">
    <?= $form->field($model, 'join_date')->textInput(['maxlength' => true]) ?>    
                </div>
   </div>
    <div class="row">
                <div class="col-md-6">
    <?= $form->field($model, 'last_date')->textInput(['maxlength' => true]) ?>    
                </div>
                <div class="col-md-6">
    <?= $form->field($model, 'is_working')->textInput(['maxlength' => true]) ?>    
                </div>
   </div>
    <div class="row">
                <div class="col-md-6">
    <?= $form->field($model, 'disablity')->textInput(['maxlength' => true]) ?>    
                </div>
                <div class="col-md-6">
    <?= $form->field($model, 'medical_concern')->textInput(['maxlength' => true]) ?>    
                </div>
   </div>
    <div class="row">
                <div class="col-md-6">
    <?= $form->field($model, 'social_activity')->textInput(['maxlength' => true]) ?>    
                </div>
                <div class="col-md-6">
    <?= $form->field($model, 'languages')->textInput(['maxlength' => true]) ?>    
                </div>
   </div>
    <div class="row">
                <div class="col-md-6">
    <?= $form->field($model, 'emergency_contact')->textInput(['maxlength' => true]) ?>    
                </div>
                <div class="col-md-6">
    <?= $form->field($model, 'support_school_in')->textInput(['maxlength' => true]) ?>    
                </div>
   </div>
    <div class="row">
                <div class="col-md-6">
    <?= $form->field($model, 'visit_abroad')->textInput(['maxlength' => true]) ?>    
                </div>
                <div class="col-md-6">
    <?= $form->field($model, 'work_at')->textInput(['maxlength' => true]) ?>    
                </div>
   </div>
    <div class="row">
                <div class="col-md-6">
    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-6">
    <?= $form->field($model, 'cell_number')->textInput(['maxlength' => true]) ?>
                </div>
   </div>
    <div class="row">
                <div class="col-md-6">
    <?= $form->field($model, 'emergency_contact')->textarea(['rows' => 6]) ?>
                </div>
                <div class="col-md-6">
    <?= $form->field($model, 'email_alternate')->textInput(['maxlength' => true]) ?>
                </div>
   </div>
    <div class="row">
                
                <div class="col-md-6">
    <?= $form->field($model, 'information')->textarea(['rows' => 6]) ?>
                    </div>
   </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
