<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Campus Management Students and Fee Statistics</title>
        
    </head>
    <body>
        <?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\bootstrap\Modal;

$this->title = 'Campus Management Students and Fee Statistics';
$this->params['breadcrumbs'][] = $this->title;


$schoolid =Yii::$app->user->school->id;
$sett = (json_decode(Yii::$app->keyStorage->get("$schoolid@school.settings")));

$currency = $sett->currency ? Yii::$app->formatter->currencyCode = $sett->currency: "PKR";		
 \Yii::$app->formatter->currencyCode = $currency;  

// print_r($feeReport[4]);
//print ">>". $feeReport[1]['fee_sum']['total_due_amount'];
 if(is_array($feeReport) ){ 
foreach($feeReport as $index => $report){
   $dataDueAmount[] = ($feeReport[$index]['fee_sum']['total_due_amount'] > 20000)?(int) $feeReport[$index]['fee_sum']['total_due_amount']:
       (int) $feeReport[$index-1]['fee_sum']['total_due_amount']+$feeReport[$index]['fee_sum']['total_due_amount'];
   $dataDueAmountCr[] = (int) $feeReport[$index]['fee_sum']['current_due_amount'] ;
    
    $feeReport[$index]['remain'] = ($feeReport[$index]['remain'] > 20000) ? (int) $feeReport[$index]['remain'] 
            : (int) $feeReport[$index-1]['remain'] -(int) $feeReport[$index]['fee_sum']['total_paid'] ;
    ($feeReport[$index]['remain'] > 0) ? $feeReport[$index]['remain'] : $feeReport[$index]['remain'] = (int) $feeReport[$index-2]['remain'] -(int) $feeReport[$index]['fee_sum']['total_paid'] ;
    $feeReport[$index]['fee_sum']['arr'] = ($feeReport[$index]['fee_sum']['arr'] > 20000) ? (int) $feeReport[$index]['fee_sum']['arr'] : (int) $feeReport[$index-1]['remain'];
    if($feeReport[$index]['fee_sum']['total_due_amount'] > 20000) 
        $feeReport[$index]['paid_pr'] = round($feeReport[$index]['fee_sum']['total_paid'] /$feeReport[$index]['fee_sum']['total_due_amount'] *100, 2); 
    $dataRemain[] = ($feeReport[$index]['remain'] > 0) ? (int) $feeReport[$index]['remain'] : (int) $feeReport[$index-1]['remain'] ;
    $dataRemainCr[] = (int) $feeReport[$index]['remain_cr']; //($feeReport[$index]['remain_cr'] > 0) ? (int) $feeReport[$index]['remain_cr'] : (int) $feeReport[$index-1]['remain_cr'] ;
    $dataTotalPaid[] = (int) $feeReport[$index]['fee_sum']['total_paid'] ;
    $dataMonth[] =  date('F y', mktime(0, 0, 0, $feeReport[$index]['month'], 10, $feeReport[$index]['year'])); // March$feeReport[$index]['month']) ;
    
}}
//print_r($dataRemain);
//print $feeReport['fee_sum']['total_due_amount'];
?>
        
<div class="student-fee-summary " id="detail_report-grid">
    <style type="text/css">
            .table {width: 100%} 
            .table tr th{width: 12%; text-align: center; font-size: 18px} 
            .table tr td{ text-align: center; font-size: 22px; height: 35px} 
            .table tr td:first-child{width: 2%; text-align: center; font-size: 22px} 
            .table tr th:first-child{width: 2%; text-align: center; font-size: 22px} 
            .table tr td:last-child{width: 2%; text-align: center; font-size: 22px} 
            .table tr th:last-child{width: 2%; text-align: center; font-size: 22px} 
        </style>
<?php    $currentMonth =  date('n', strtotime("-1 month")) ; 
if(Yii::$app->request->get('month')!= "")$currentMonth =  date('n') ; 
echo Highcharts::widget([
    'scripts' => [
        'modules/exporting',
//        'themes/grid-light',
    ],
    'options' => [
        'title' => [
            'text' => 'Total fee collection',
        ],
        'xAxis' => [
            'categories' => $dataMonth,//['April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December', 'Janaury', 'February', 'March'],
        ],
        'labels' => [
            'items' => [
                [
                    'html' => 'Fee collection current % ('.date('M, Y').')',
                    'style' => [
                        'left' => '0px',
                        'top' => '-25px',
                        'color' => new JsExpression('(Highcharts.theme && Highcharts.theme.textColor) || "black"'),
                    ],
                ],
            ],
        ],
        
        'series' => [
            [
                'type' => 'column',
                'name' => 'Total Due Amount',
                
                'data' => $dataDueAmount,
            ],
            [
                'type' => 'column',
                'name' => 'Pending',
                'format' => 'currency',
                'data' => $dataRemain,
            ],
            [
                'type' => 'column',
                'name' => 'Paid',
                
                'data' => $dataTotalPaid,
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
            [
                'type' => 'pie',
                "dataLabels"=> [
				"enabled"=> true,
				"format"=> "<b>{point.name}</b>: {point.percentage:.1f} %",
				"style"=> [
					"color"=> "black"
				]
			],
                'name' => 'Fee Payment',
                'data' => [
                    [
                        'name' => 'Discount%',
                        'y' => $feeReport[$currentMonth]['discountpr'],
                        'color' => 'orange'//new JsExpression('Highcharts.getOptions().colors[0]'), // Jane's color
                    ],
                    [
                    
                      'name' => 'Pending%',
                        'y' => $feeReport[$currentMonth]['pendingpr_cr'],
                        'color' => new JsExpression('Highcharts.getOptions().colors[1]'), // John's color
                    ],
                    [
                        'name' => 'Paid%',
                        'y' => $feeReport[$currentMonth]['paidpr_cr'],
                        "sliced"=> true,
			"selected"=> true
                        
//                        'color' => new JsExpression('Highcharts.getOptions().colors[2]'), // Joe's color
                    ],
                ],
                'center' => [170, 50],
                'size' => 150,
                'showInLegend' => false,
//                'dataLabels' => [
//                    'enabled' => false,
//                ], //default
                "plotOptions"=> [
		"pie"=> [
			"allowPointSelect"=> true,
			"cursor"=> "pointer",
			"dataLabels"=> [
				"enabled"=> true,
				"format"=> "<b>{point.name}</b>: {point.percentage:.1f}%",
				"style"=> [
					"color"=> "black"
				]
			]
		]
                ]
                
            ],
        ],
    ]
]);
    ?>
    <?php 

    $dataProvider = new ArrayDataProvider([
            'key'=>'id',
            'allModels' => ($feeReport),
            'sort' => [
                'attributes' => ['id', 'name', 'email'],
            ],
    ]);
    ?>
    <div class="table-responsive">
   
   
        <div class="container">    
    <div class="row">  
         <div class="col-md-12 text-right non-print">
         <?php echo $this->render('report_options'); ?> 
         </div>    
    <?php 
    $fullView = Yii::$app->request->get('fullView')? Yii::$app->request->get('fullView'):FALSE;
    echo GridView::widget([
//    'id'=>'report-grid',    
    'id'=>'_detail_report-grid',    
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '', 'currencyCode' => $currency],    
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

//            'id',
        'month_name',
        ['label' => 'Left Student Count', 'format' =>"raw" , 'value' => function($model, $data){ return "-".$model['left_student_count'] ;}, 'visible' =>$fullView],
        
        'student_count',
        ['label' => 'Admission Count', 'format' =>"raw" , 'value' => function($model, $data){ return "+".$model['admission_count'] ;}, 'visible' =>$fullView],
        
//        ['label'=>'New Admissions', 'value' => 'admission_count'],
//        'student_count',
//        ['label' => 'Total Due amount', 'value' =>'fee_sum.total_due_amount:currency'],
        ['label' => 'Admission Fee', 'format' =>"currency" , 'value' => function($model, $data){ return $model['fee_sum']['adm_fee'] ;}, 'visible' =>$fullView],
        ['label' => 'Annual Fee', 'format' =>"currency" , 'value' => function($model, $data){ return $model['fee_sum']['ann_fee'] ;}, 'visible' =>$fullView],
        ['label' => 'Annual Exam Fee', 'format' =>"currency" , 'value' => function($model, $data){ return $model['fee_sum']['annual_exam_fee'] ;}, 'visible' =>$fullView],
        ['label' => 'Other Fee', 'format' =>"html" , 'value' => function($model, $data){ return Html::a('<i class="fa fa-xs fa-list" style="font-size: 15px;"></i>'. $model['fee_sum']['other'], 
                ($model['year']."--". $model['month']), ['class'=>'btn-action'])  ;}, 'visible' =>$fullView],
        ['label' => 'Curr Month Fee', 'format' =>"currency" , 'value' => function($model, $data){ return $model['fee_sum']['current_due_amount'] ;}],
        ['label' => 'Discount', 'format' =>"currency" , 'value' => function($model, $data){ return $model['fee_sum']['total_discount'] ;}, 'visible' =>$fullView],
        ['label' => 'Late Pay Fine', 'format' =>"currency" , 'value' => function($model, $data){ return $model['fee_sum']['late_payment_fine'] ;}],
        ['label' => 'Arr', 'format' =>"currency" , 'value' => function($model, $data){ return $model['fee_sum']['arr'] ;}],
        ['label' => 'Total Due Amount', 'format' =>"currency" , 'value' => function($model, $data){ return $model['fee_sum']['total_due_amount'] ;}, 'visible' =>$fullView],
        ['label' => 'Total Paid Amount', 'format' =>"currency" , 'value' => function($model, $data){ return $model['fee_sum']['total_paid'] ;}],
        ['label' => 'Paid % (Current)', 'value' => function($model, $data){ return round($model['fee_sum']['cr_paid_pr'], 2) ;}],        
        ['label' => 'Paid %', 'value' => 'paid_pr'],
        ['label' => 'Left Student Fee Sum', 'value' => 'left_student_fee_sum' , 'format' =>"currency"],
        'remain:currency',
        [] // in print last column will be eleminated.
        
        ]]);
    ?></div></div></div></div>
        
        <?php 
yii\bootstrap\Modal::begin([
            'header'=>'<h4>Job Created</h4>',
            'id'=>'modal',
            'size'=>'modal-lg',
         ]);

        echo "<div id='modalContent'></div>";
        Modal::end();
        ?>
    </body>
</html>
