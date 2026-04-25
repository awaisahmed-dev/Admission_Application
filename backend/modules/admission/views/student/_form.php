<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="student-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'first_name')->textInput() ?>

    <?= $form->field($model, 'last_name')->textInput() ?>

    <?= $form->field($model, 'gender')->dropDownList([
        1 => 'Male',
        2 => 'Female',
    ]) ?>

    <?= $form->field($model, 'school_name')->textInput() ?>

    <?= $form->field($model, 'school_class')->textInput() ?>

    <?= $form->field($model, 'admission_type')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>