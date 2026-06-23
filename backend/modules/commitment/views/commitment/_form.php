<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\modules\admission\models\ParentModel;
// use yii\widgets\ActiveForm;
// use yii\helpers\DateTimePicker;


/* @var $this yii\web\View */
/* @var $model backend\modules\commitment\models\CommitmentModel */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="commitment-model-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model); ?>

    <!-- <?php echo $form->field($model, 'parent_id')->textInput() ?> -->
     <?= $form->field($model, 'parent_id')->dropDownList(

            ArrayHelper::map(
            ParentModel::find()->all(),
            'id',
            'father_first_name'
            ),
            
            ['prompt'=>'Select Parent']

        ) ?>

    <?php echo $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'payment_plan')->textarea(['rows' => 6]) ?>

    <!-- <?php echo $form->field($model, 'date')->textInput() ?> -->

        <?= $form->field($model,'date')
            ->input('date',[
            'value'=>date('Y-m-d'),
            'onfocus'=>'this.showPicker()'
            ])->label('Date') ?>

    <!-- <?php echo $form->field($model, 'due_date')->textInput() ?> -->

    <?= $form->field($model,'due_date')
            ->input('date',[
                'onfocus'=>'this.showPicker()'
            ]) ?>

    <?php echo $form->field($model, 'details')->textarea(['rows' => 6]) ?>

    <!-- <?php echo $form->field($model, 'status')->textInput() ?>

    <?php echo $form->field($model, 'created_by')->textInput() ?>

    <?php echo $form->field($model, 'updated_by')->textInput() ?>

    <?php echo $form->field($model, 'created_at')->textInput() ?>

    <?php echo $form->field($model, 'updated_at')->textInput() ?> -->

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
