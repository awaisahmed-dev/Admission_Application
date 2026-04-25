<?php

use yii\widgets\DetailView;

$this->title = 'Student #' . $model->id;
?>

<h2>Student Details</h2>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'first_name',
        'last_name',
        'gender',
        'date_of_birth',
        'school_name',
        'school_class',
        'admission_type',
        'created_at:datetime',
    ],
]); ?>