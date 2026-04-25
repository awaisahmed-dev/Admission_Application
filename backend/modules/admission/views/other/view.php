<?php

use yii\widgets\DetailView;

$this->title = 'Student #' . $model->id;
?>

<h2>Student Details</h2>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'first_name',
        'last_name',
        'school_name',
        'school_class',
        'admission_type',
        'gender',
        'created_at',
    ],
]); ?>