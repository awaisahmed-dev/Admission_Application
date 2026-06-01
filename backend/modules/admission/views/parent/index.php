<?php

use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Admission Applications';
?>

<h2>Applications List</h2>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [

        'id',

        [
            'label' => 'Father Name',
            'value' => function($model){
                return $model->father_first_name . ' ' . $model->father_last_name;
            }
        ],

        'father_mobile',
        'father_email',

        [
            'label' => 'Children Count',
            'value' => function($model){
                return count($model->children);
            }
        ],

        // [
        //     'attribute' => 'status',
        //     'value' => function($model){
        //         return $model->status == 1 ? 'Admitted' : 'Pending';
        //     }
        // ],

            [
            'attribute' => 'status',
            'format' => 'raw',
            'value' => function($model){

                if($model->status == 1){
                    return '<span class="label label-success">Admitted</span>';
                }

                return '<span class="label label-warning">Pending</span>';
            }
            ],

        'created_at:datetime',

        [
    'class' => 'yii\grid\ActionColumn',
    'template' => '{view} {update} {admit}',

    'buttons' => [

        'admit' => function ($url, $model) {

            if ($model->status == 0) {

                return Html::a(
                    'Admit',
                    ['admit', 'id' => $model->id],
                    [
                        'class' => 'btn btn-success btn-sm',
                        'data-confirm' => 'Admit student?',
                    ]
                );
            }

            return '';
        },
    ],
],
    ],
]); ?>