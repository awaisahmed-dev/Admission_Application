<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Application #' . $model->id;
?>

<h2>Parent Details</h2>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'father_first_name',
        'father_last_name',
        'father_mobile',
        'father_email',
        'mother_first_name',
        'mother_last_name',
        'address:ntext',
        'emergency_contact_name',
        'emergency_contact_number',
    ],
]); ?>

<hr>

<h3>Children</h3>

<table class="table table-bordered">
    <tr>
        <th>Name</th>
        <th>Gender</th>
        <th>School</th>
        <th>Class</th>
        <th>Status</th>
    </tr>

    <?php foreach($model->children as $child): ?>
    <tr>
        <td><?= $child->first_name . ' ' . $child->last_name ?></td>
        <td><?= $child->gender == 1 ? 'Male' : 'Female' ?></td>
        <td><?= $child->school_name ?></td>
        <td><?= $child->school_class ?></td>
        <td>
            <?= $child->student_enrolment == 1 ? 'Enrolled' : 'Not Enrolled' ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<hr>

<!-- 🔥 ADMIT BUTTON -->
<?php if($model->status == 0): ?>

<?= Html::a('Admit Student', ['admit', 'id' => $model->id], [
    'class' => 'btn btn-success',
    'data-confirm' => 'Are you sure you want to admit all children?',
]) ?>

<?php else: ?>

<button class="btn btn-secondary" disabled>Already Admitted</button>

<?php endif; ?>