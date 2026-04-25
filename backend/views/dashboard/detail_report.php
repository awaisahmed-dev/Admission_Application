<?php $this->title = Yii::t('backend', 'Campus Management Dashboard'); ?><!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

// print_r($feeReport); 
//print ">>". $feeReport[5][1]['fee_sum']['total_due_amount'];
 if(is_array($feeReport) ){ 
    foreach($feeReport as $index => $report){
        foreach ($typeData as $class){
       $dataDueAmount[] = (int) $feeReport[$index][$class->id]['fee_sum']['current_due_amount'];// +(int) $feeReport[$index][$class->id]['fee_sum']['arr'];
       $dataArrearsAmount[] = (int) $feeReport[$index][$class->id]['fee_sum']['arr'] ;
        $dataRemain[] = (int) $feeReport[$index][$class->id]['remain'] ;
        $dataRemainCr[] = (int) $feeReport[$index][$class->id]['remain_cr'] ;
        $dataTotalPaid[] = (int) $feeReport[$index][$class->id]['fee_sum']['total_paid'] ;
//        $dataTotalPaidPer[] = (int) ($feeReport[$index][$class->id]['fee_sum']['total_paid'] / (int) $feeReport[$index][$class->id]['fee_sum']['current_due_amount']) * 100 ;
        $dataMonth[] = ($feeReport[$index][$class->id]['month'])  ?   date('F', mktime(0, 0, 0, $feeReport[$index][$class->id]['month'], 10))."(".$class->title.")"
        : "(".$class->title.")";
        }
    }

}
//die;
//print_r($dataRemain);
//print $feeReport['fee_sum']['total_due_amount'];

echo Highcharts::widget([
    'scripts' => [
        'modules/exporting',
//        'themes/grid-light',
    ],
    'options' => [
        'title' => [
            'text' => Yii::$app->request->get('t')? 'Total fee collection ( Monthly Fee - '.Yii::$app->request->get('t').")": "Total fee collection (Current Month)",
        ],
        'xAxis' => [
            'categories' => $dataMonth,//['April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December', 'Janaury', 'February', 'March'],
        ],
        'labels' => [
            'items' => [
                [
//                    'html' => 'Fee collection current %',
                    'style' => [
                        'left' => '0px',
                        'top' => '15px',
                        'color' => new JsExpression('(Highcharts.theme && Highcharts.theme.textColor) || "black"'),
                    ],
                ],
            ],
        ],
        'plotOptions'=> [
            'column' => [
                'stacking' => 'normal'
            ]
        ],        
        
        'series' => [
            
            [
                'type' => 'column',
                'name' => 'Arrears',
                'color' => '#434348',
                
                'data' => $dataArrearsAmount,
                
                'stack'=> 'male'
            ],
            [
                'type' => 'column',
                'name' => 'Current Month Fee',
                
                'data' => $dataDueAmount,
                 'stack'=> 'male'
            ],
            [
                'type' => 'column',
                'name' => 'Pending',
                'format' => 'currency',
                'data' => $dataRemain,
                'color'=> 'maroon',
                'stack'=> 'female'
            ],
            [
                'type' => 'column',
                'name' => 'Paid',
                'color' => '#A9FF96',
                'data' => $dataTotalPaid,
                'stack'=> 'female'
                 
            ],
            
            
//            [
//                'type' => 'spline',
//                'name' => 'Average',
//                'data' => [3, 2.67, 3, 6.33, 3.33],
//                'marker' => [
//                    'lineWidth' => 2,
//                    'lineColor' => new JsExpression('Highcharts.getOptions().colors[3]'),
//                    'fillColor' => 'white',
//                ],
//            ],
//            [
//                'type' => 'pie',
//                "dataLabels"=> [
//				"enabled"=> true,
//				"format"=> "<b>{point.name}</b>: {point.percentage:.1f} %",
//				"style"=> [
//					"color"=> "black"
//				]
//			],
//                'name' => 'Fee Payment',
//                'data' => [
//                    [
//                        'name' => 'Discount',
//                        'y' => $feeReport[4]['discountpr'],
//                        'color' => 'orange'//new JsExpression('Highcharts.getOptions().colors[0]'), // Jane's color
//                    ],
//                    [
//                    
//                      'name' => 'Pending',
//                        'y' => $feeReport[4]['pendingpr'],
//                        'color' => new JsExpression('Highcharts.getOptions().colors[1]'), // John's color
//                    ],
//                    [
//                        'name' => 'Paid',
//                        'y' => $feeReport[4]['paidpr'],
//                        "sliced"=> true,
//			"selected"=> true
//                        
////                        'color' => new JsExpression('Highcharts.getOptions().colors[2]'), // Joe's color
//                    ],
//                ],
//                'center' => [50, 120],
//                'size' => 150,
//                'showInLegend' => false,
////                'dataLabels' => [
////                    'enabled' => false,
////                ], //default
//                "plotOptions"=> [
//		"pie"=> [
//			"allowPointSelect"=> true,
//			"cursor"=> "pointer",
//			"dataLabels"=> [
//				"enabled"=> true,
//				"format"=> "<b>{point.name}</b>: {point.percentage:.1f}%",
//				"style"=> [
//					"color"=> "black"
//				]
//			]
//		]
//                ]
//                
//            ],
        ],
    ]
]);
    ?>
    
    <div class="student-fee-index "><div class="table-responsive">
   
   
        <div class="container">    
    <div class="row">  
         <div class="col-md-12 text-right">
         <?php echo $this->render('report_options'); ?>    
         
         </div>
    <?php Pjax::begin(['timeout' => 5000 ]); ?>    <?php 

    $dataProvider = new ArrayDataProvider([
            'key'=>'id',
            'allModels' => $feeReport[date('n')],
            'sort' => [
                'attributes' => ['title', 'student_count', 'monthly_fee', 'fee_sum.total_paid', 'fee_sum.total_paid_pr', 'remain'],
            ],
            'pagination' => [
                'pageSize' => 50,
            ],
    ]);
    ?>
    <?php 
    $fullView = Yii::$app->request->get('fullView')? Yii::$app->request->get('fullView'):FALSE;
    echo GridView::widget([
    'id'=>'detail_report-grid',        
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '', 'currencyCode' => 'PKR',],            
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

//        'title',
        ['label'=>'Class', 'value' => 'title', 'headerOptions' => ['style' => 'width:7%;']],
        ['label'=>'Left:', 'value' => 'left_student_count', 'visible' =>$fullView],
        'student_count',
        ['label'=>'New Adm:', 'value' => 'admission_count', 'visible' =>$fullView],
        'monthly_fee',
        ['label' => 'Voucher Count', 'format' =>"raw" , 'value' => function($model, $data){ return $model['fee_sum']['voucher_count'] ;}, 'visible' =>$fullView],
        ['label'=>'Month', 'value' => 'month_name', 'headerOptions' => ['style' => 'width:10%;'] ],
        ['label' => 'Admission Fee', 'format' =>"currency" , 'value' => function($model, $data){ return $model['fee_sum']['adm_fee'] ;}, 'visible' =>$fullView],
        ['label' => 'Annual Fee', 'format' =>"currency" , 'value' => function($model, $data){ return $model['fee_sum']['ann_fee'] ;}, 'visible' =>$fullView],
        ['label' => 'Curr Month Fee', 'format' =>"currency" , 'value' => function($model, $data){ return $model['fee_sum']['current_due_amount'] ;}],
        ['label' => 'Late Py Fine', 'format' =>"currency" , 'value' => function($model, $data){ return $model['fee_sum']['late_payment_fine'] ;}, 'visible' =>$fullView],
        ['label' => 'Discount', 'format' =>"currency" , 'value' => function($model, $data){ return $model['fee_sum']['total_discount'] ;}],
        ['label' => 'Arr', 'format' =>"currency" , 'value' => function($model, $data){ return $model['fee_sum']['arr'] ;}],
        ['label' => 'Total Due Amount', 'format' =>"currency" , 'value' => function($model, $data){ return $model['fee_sum']['total_due_amount'] ;} , 'visible' =>$fullView],
        ['label' => 'Total Paid Amount', 'format' =>"currency" , 'value' => function($model, $data){ return $model['fee_sum']['total_paid'] ;}],
        ['label' => 'Paid % (Current)', 'value' => function($model, $data){ return round($model['fee_sum']['cr_paid_pr'], 2) ;}],
        ['label' => 'Paid %', 'value' => function($model, $data){ return round($model['fee_sum']['total_paid_pr'], 2) ;}],
        'remain:currency',[]
        ]]);
    ?>
    <?php Pjax::end(); ?>    
    </div>
    </div>
    </div>
</div>
    </body>
</html>
