<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<div class="student-form">

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'first_name') ?>
<?= $form->field($model, 'last_name') ?>

<?= $form->field($model, 'gender')->dropDownList([
    1 => 'Male',
    2 => 'Female'
]) ?>

<?= $form->field($model, 'school_name') ?>
<?= $form->field($model, 'school_class') ?>
<?= $form->field($model, 'admission_type') ?>

<div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>

</div>