<?php

use yii\grid\GridView;

$this->title = 'Students';
?>

<h2>Students List</h2>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [

        'id',

        'full_name',

        'father_name',

        'mother_name',

        'gender',

        'gr_number',

        'seat_number',

        'admit_in_class',

        'mobile',

        'email',

        [
            'attribute' => 'admission_date',
            'format' => ['date','php:d-m-Y']
        ],

        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view} {update}'
        ],
    ],
]); ?>