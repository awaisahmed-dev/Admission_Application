<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Student Statistics</title>
        
    </head>
    <body>
        <?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = ' Students Statistics';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="row">  
         <div class="col-md-12 text-right non-print">
         <?php //echo $this->render('report_options'); ?> 
         </div> 
  </div>        
<div class="student-fee-summary " id="detail_report-grid">
    <style type="text/css">
/*            .table {width: 100%} 
            .table tr th{width: 12%; text-align: center; font-size: 18px} 
            .table tr td{ text-align: center; font-size: 22px; height: 35px} 
            .table tr td:first-child{width: 2%; text-align: center; font-size: 22px} 
            .table tr th:first-child{width: 2%; text-align: center; font-size: 22px} 
            .table tr td:last-child{width: 2%; text-align: center; font-size: 22px} 
            .table tr th:last-child{width: 2%; text-align: center; font-size: 22px} */
        </style>
        
                <br />
    <div class="row" >
<?php    $currentMonth =  date('n', strtotime("-1 month")) ; 
if(Yii::$app->request->get('month')!= "")$currentMonth =  date('n') ;
//print_r($report[1]);


foreach ($studentStats as $primekey => $report) {

    $data = [];
    foreach ($report as $key => $record) {
        
        
        
        if($primekey == 'class_id' || $primekey == 'staff'){
         $data[$key]['name'] = $record->studentClass->title ?  $record->studentClass->title:"Unknown Class";
         
        }else{
            $data[$key]['name'] = $record->$primekey ?  $record->$primekey :"Unknown";
        }
         $data[$key]['y'] =  (int)$record->student_count;

    }
//     $amountData = [];
//    foreach ($report as $key => $record) {
//        
//        $amountData[$key]['id'] = $record->$primekey->id;
//        
////        if($primekey == 'doctor' || $primekey == 'staff'){
////         $amountData[$key]['name'] = $record->$primekey->userProfile->full_name ?  $record->$primekey->userProfile->full_name:"Unknown";
////         $amountData[$key]['share'] =  (int) $record->commission;
////         
////        }else{
//            $amountData[$key]['name'] = $record->$primekey; //->title ?  $record->$primekey->title:"Unknown";
////        }
//        $amountData[$key]['student'] =  (int)$record->student_count; 
//        $amountData[$key]['y'] =  (int)$record->paid_amount_sum;
//
//    }
    
$primekey = ucfirst($primekey);
$dataProvider = new ArrayDataProvider([
    'allModels' => $amountData,
    'sort' => [
        'attributes' => ['id', 'username', 'email'],
    ],
    'pagination' => [
        'pageSize' => 10,
    ],
]);
?>
        

        <div class="col-md-4">
<?php
echo Highcharts::widget([
    'scripts' => [
        'modules/exporting',
//        'themes/grid-light',
    ],
    'options' => [
        'title' => [
            'text' => $primekey.' Based Student Distribution',
        ],
//        'xAxis' => [
//            'categories' => $dataMonth,//['April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December', 'Janaury', 'February', 'March'],
//        ],
//        'labels' => [
//            'items' => [
//                [
//                    'html' => 'Fee collection current % ('.date('M, Y').')',
//                    'style' => [
//                        'left' => '0px',
//                        'top' => '-25px',
//                        'color' => new JsExpression('(Highcharts.theme && Highcharts.theme.textColor) || "black"'),
//                    ],
//                ],
//            ],
//        ],
//        
        'series' => [
            [
                'type' => 'pie',
                "dataLabels"=> [
				"enabled"=> true,
				"format"=> "<b>{point.name}</b>: {point.percentage:.1f} %",
				"style"=> [
					"color"=> "black"
				]
			],
                'name' => 'Students',
                'data' => $data,
//                'center' => [170, 50],
                'size' => 150,
//                'showInLegend' => true,
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
]); ?>
        </div>
         
   
        <?php
        }
    ?> </div>
    </div>
    </body>
</html>
