<?php

use yii\grid\GridView;

$this->title = 'Students';
?>

<h2>Students List</h2>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [

        'id',

        'first_name',
        'last_name',

        [
            'attribute' => 'gender',
            'value' => function($model){
                return $model->gender == 1 ? 'Male' : 'Female';
            }
        ],

        'school_name',
        'school_class',
        'admission_type',

        [
            'label' => 'Parent',
            'value' => function($model){
                return $model->parent 
                    ? $model->parent->father_first_name 
                    : '';
            }
        ],

        'created_at:datetime',

        // ['class' => 'yii\grid\ActionColumn'],
        [
        'class'=>'yii\grid\ActionColumn',
        'template'=>'{view} {update}'
        ],
    ],
]); ?>