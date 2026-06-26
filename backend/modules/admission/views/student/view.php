<?php

use yii\widgets\DetailView;

$this->title = 'Student #' . $model->id;
?>

<h2>Student Details</h2>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'full_name',
        'father_name',
        'mother_name',
        'gender',
        'date_of_birth',
        'gr_number',
        'seat_number',
        'admit_in_class',
        'mobile',
        'email',
        'admission_date',
        'created_at:datetime',
        'updated_at:datetime',
    ],
]); ?>