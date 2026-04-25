<?php

use yii\grid\GridView;
use yii\helpers\Html;

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [

        'id',

        [
            'label' => 'Father Name',
            'value' => function($model){
                return $model->father_first_name . ' ' . $model->father_last_name;
            }
        ],

        [
            'label' => 'Children',
            'value' => function($model){
                return count($model->children);
            }
        ],

        [
            'label' => 'Status',
            'value' => function($model){
                return $model->status == 1 ? 'Admitted' : 'Pending';
            }
        ],

        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view} {admit}',
            'buttons' => [

                'admit' => function ($url, $model) {
                    if ($model->status == 0) {
                        return Html::a('Admit Students', ['admit', 'id' => $model->id], [
                            'class' => 'btn btn-success btn-sm',
                            'data-confirm' => 'Are you sure?',
                        ]);
                    } else {
                        return '<span class="label label-success">Admitted</span>';
                    }
                },

            ],
        ],
    ],
]);