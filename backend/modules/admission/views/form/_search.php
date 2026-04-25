<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\admission\models\search\ParentModelSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="parent-model-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'father_title') ?>

    <?= $form->field($model, 'father_first_name') ?>

    <?= $form->field($model, 'father_last_name') ?>

    <?= $form->field($model, 'father_mobile') ?>

    <?php // echo $form->field($model, 'father_email') ?>

    <?php // echo $form->field($model, 'mother_title') ?>

    <?php // echo $form->field($model, 'mother_first_name') ?>

    <?php // echo $form->field($model, 'mother_last_name') ?>

    <?php // echo $form->field($model, 'mother_mobile') ?>

    <?php // echo $form->field($model, 'mother_email') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'home_phone') ?>

    <?php // echo $form->field($model, 'emergency_contact_name') ?>

    <?php // echo $form->field($model, 'emergency_contact_number') ?>

    <?php // echo $form->field($model, 'emergency_relationship') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
