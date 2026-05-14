<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
// modules/admission/views/parent/_admission_form.php
// use backend/modules/admission/views/parent/_admission_form.php

?>

<div class="parent-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'father_first_name')->textInput() ?>
    <?= $form->field($model, 'father_last_name')->textInput() ?>
    <?= $form->field($model, 'father_mobile')->textInput() ?>
    <?= $form->field($model, 'father_email')->textInput() ?>
    <?= $form->field($model, 'mother_first_name')->textInput() ?>
    <?= $form->field($model, 'mother_last_name')->textInput() ?>
    <?= $form->field($model, 'mother_mobile')->textInput() ?>
    <?= $form->field($model, 'mother_email')->textInput() ?>
        
    <?= $form->field($model, 'address')->textarea(['rows' => 3]) ?>

    <?= $form->field($model, 'emergency_contact_name')->textInput() ?>
    <?= $form->field($model, 'emergency_contact_number')->textInput() ?>
    <?= $form->field($model, 'emergency_relationship')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>