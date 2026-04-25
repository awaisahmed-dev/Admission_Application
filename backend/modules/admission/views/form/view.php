<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\admission\models\ParentModel */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Parent Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="parent-model-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'father_title',
            'father_first_name',
            'father_last_name',
            'father_mobile',
            'father_email:email',
            'mother_title',
            'mother_first_name',
            'mother_last_name',
            'mother_mobile',
            'mother_email:email',
            'address:ntext',
            'home_phone',
            'emergency_contact_name',
            'emergency_contact_number',
            'emergency_relationship',
            'status',
            'created_by',
            'updated_by',
            'created_at',
            'updated_at',
        ],
    ]) ?>

    <h3>Children</h3>

<?php foreach ($model->children as $child): ?>
    <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
        <b>Name:</b> <?= $child->first_name . ' ' . $child->last_name ?><br>
        <b>Gender:</b> <?= $child->gender == 1 ? 'Male' : 'Female' ?><br>
        <b>School:</b> <?= $child->school_name ?><br>
        <b>Class:</b> <?= $child->school_class ?><br>
    </div>
<?php endforeach; ?>


<h3>Policy</h3>

<?php if ($model->policies): ?>
    <?php $policy = $model->policies[0]; ?>

    <b>Excursion Consent:</b> <?= $policy->excursion_consent ? 'Yes' : 'No' ?><br>
    <b>Photo Consent:</b> <?= $policy->photo_consent ? 'Yes' : 'No' ?><br>
    <b>Signature:</b> <?= $policy->signature_name ?><br>
<?php endif; ?>

    <?= Html::a('Enroll Student', ['admit', 'id' => $model->id], 
    [
    'class' => 'btn btn-success',
    'data-confirm' => 'Are you sure?',
    ]) ?>

</div>
