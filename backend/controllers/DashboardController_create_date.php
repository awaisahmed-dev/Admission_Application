<?php

namespace backend\controllers;

use Yii;
use backend\models\search\TimelineEventSearch;
use yii\web\Controller;

/**
 * Application dashboard controller
 */
class DashboardController extends Controller
{
    public $layout = 'common';
    /**
     * Lists all TimelineEvent models.
     * @return mixed
     */
    
    public function actionIndex() {
        
        return $this->render('index', []);
    }
    public function actionFee($month = null, $year=null)
    {
        $searchModel = new TimelineEventSearch();
        
        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = [
            'defaultOrder'=>['created_at'=>SORT_DESC]
        ];
        
        $feeReport = $this->calculateFeeSummary($month, $year);

        return $this->render('fee_stats', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'feeReport' => $feeReport,
        ]);
    }
    public function actionDetailReport($t = 'class', $month = null, $year = null)
    {
        $searchModel = new TimelineEventSearch();
        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = [
            'defaultOrder'=>['created_at'=>SORT_DESC],
            
        ];
        $dataProvider->pagination->pageSize = 50;
        $typeData = ($t == 'class' ? Yii::$app->user->school->studentClasses : Yii::$app->user->school->classSections);
        
        $feeReport = $this->calculateDetailReport($t, $typeData, $month, $year);
//        $feeReport = $this->calculateMonthDetailReport($t, $typeData);

        return $this->render('detail_report', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'feeReport' => $feeReport,
            'typeData' => $typeData
        ]);
    }
    public function calculateReport() {
        $feeReperot; $paymentReport; $pending;
    }
    private function calculateFeeReport(){

        if(!is_null($this->calculateMonthlyFeeReport(date('n', strtotime("-$m month") ), date('Y', strtotime("-$m month")) ))){
        $feeReport[ date('n', strtotime("-$m month") ) ] =  $this->calculateMonthlyFeeReport(date('n', strtotime("-$m month") ), date('Y', strtotime("-$m month")) );}
        return $feeReport;

    }
    private function calculatePaymentReport(){

        if(!is_null($this->calculateMonthlyPaymentReport(date('n', strtotime("-$m month") ), date('Y', strtotime("-$m month")) ))){
        $feeReport[ date('n', strtotime("-$m month") ) ] =  $this->calculateMonthlyFeeReport(date('n', strtotime("-$m month") ), date('Y', strtotime("-$m month")) );}
        return $feeReport;

    }
    private function calculateFeeSummary($month = null, $year = null){

        if(!isset($month) || $month == ''){
            for($m = 0 ; $m < 12; $m++){
                $lm = $m-1;
                if($m > 2 and Yii::$app->request->get('past_months_view') != 1) break;

                $currentM= date('n', strtotime("-$lm month") ); $currentY= date('Y', strtotime("-$lm month") ); 

                if(!is_null($this->calculateMonthlyFeeReport($currentM, $currentY, $lastM, $lastY) )){
                $feeReport[ date('n', strtotime("-$m month") ) ] =  $this->calculateMonthlyFeeReport($currentM, $currentY);
                $feeReport[ date('n', strtotime("-$m month") ) ]['student_count'] 
                        =  Yii::$app->user->school->getStudents(1, ['startDate' => $currentY.'-'.$currentM."-31",])->count();
                $feeReport[ date('n', strtotime("-$m month") ) ]['admission_count'] 
                        =  Yii::$app->user->school->getSchoolAdmissions( ['startDate' => $currentY.'-'.$currentM."-01",
                            'endDate' => $currentY.'-'.$currentM."-31"]);
                
                }
            }
        
        }else{ 
            
            $feeReport[ date_parse($month)['month'] ] =  $this->calculateMonthlyFeeReport(date_parse($month)['month'], 2017);
            $feeReport[ date_parse($month)['month'] ]['student_count'] 
                        =  Yii::$app->user->school->getStudents(1, ['startDate' => $year.'-'.date_parse($month)['month']."-31",])->count();
            $feeReport[ date_parse($month)['month']]['admission_count'] 
                        =  Yii::$app->user->school->getSchoolAdmissions( ['startDate' => $year.'-'.date_parse($month)['month']."-01",
                            'endDate' => $year.'-'.date_parse($month)['month']."-31"]);
        }
        
        return $feeReport;

    }
    
    private function calculateDetailReport($t, $typeData, $month = null, $year= null){

//        for($m = 0 ; $m < 12; $m++){
            $lm = $m-1;
            
             $currentM= date('n' ); $currentY= date('Y' ); //die;
             if(!is_null($month)) 
                 $currentM = date_parse($month)['month']; 
             if(!is_null($year)) $currentY = $year;
            
            foreach ($typeData as $section){
//                print $currentM.$class->id.">>".$class->title."<br>";;
                if($t == 'class' ){ 
                    $cal = $this->calculateMonthlyFeeReport($currentM, $currentY, $section->id);}
                else if($t == 'section' ){ 
                    $cal = $this->calculateMonthlyFeeReport($currentM, $currentY, $section->parent_class_id, $section->id);}
                else{$cal = $this->calculateMonthlyFeeReport($currentM, $currentY);}
                
                if(!is_null($cal )){
                $feeReport[ date('n' ) ][$section->id] =  $cal;
                $feeReport[ date('n' ) ][$section->id]['title'] =  $section->title;
                if($t == 'section'){
                    $feeReport[ date('n' ) ][$section->id]['student_count'] =  count($section->getSectionStudents(['startDate' => $currentY.'-'.$currentM."-31"])->all()); // please calculate on provided params 
                    $feeReport[ date('n' ) ][$section->id]['admission_count'] =  
                            ($section->getSectionAdmissions(['startDate' => $currentY.'-'.$currentM."-01", 'endDate' => $currentY.'-'.$currentM."-31"]));
                    $feeReport[ date('n' ) ][$section->id]['monthly_fee'] =  $section->parent->monthly_tution_fee;
                
                }else if($t == 'class'){
                    $feeReport[ date('n' ) ][$section->id]['student_count'] =  count($section->getClassStudents(['startDate' => $currentY.'-'.$currentM."-31"])->all());
                    $feeReport[ date('n' ) ][$section->id]['admission_count'] =  ($section->getclassAdmissions(['startDate' => $currentY.'-'.$currentM."-01", 'endDate' => $currentY.'-'.$currentM."-31"]));
                    $feeReport[ date('n' ) ][$section->id]['monthly_fee'] =  $section->monthly_tution_fee;
                }

                }   
            }
//        }
        return $feeReport;

    }

    private function calculateMonthlyFeeReport($currentM, $currentY, $class_id = null, $section_id = null){

        if(strlen($currentM) <2 ) $currentM = "0".$currentM;
         $start_date = $currentY.'-'.$currentM.'-01';
         $end_date = $currentY.'-'.$currentM.'-31';
        $feereportData = [];
        $feeSum = [];
        $q = \backend\modules\fee\models\StudentFee::find()
                ->select('SUM(fee_amount+fee_addon_sum) total_due_amount, SUM(fee_amount) current_due_amount,
                    count(student_fee.id) as voucher_count,
                SUM(discount_amount) total_discount, SUM(sfadd.admission_fee) adm_fee, SUM(sfadd.arrears) arr,
                SUM(sfadd.annual_fee) ann_fee, SUM(sfp.paid_amount) total_paid,
                (SUM(sfp.paid_amount)/SUM(fee_amount)*100)  cr_paid_pr,
                (SUM(sfp.paid_amount)/SUM(fee_amount+fee_addon_sum)*100)  total_paid_pr')
                ->leftJoin('student_fee_addon sfadd', '`sfadd`.`student_fee_id` = `student_fee`.`id`')
                ->leftJoin('student_fee_payment_receipt sfp', '`sfp`.`student_fee_id` = `student_fee`.`id`')
                ->where([">=", 'student_fee.created_at', strtotime($start_date)] )
                ->andWhere(["<=", 'student_fee.created_at', strtotime($end_date)] )
                ->orWhere(['student_fee.fee_month'=> date('F' ,strtotime($start_date))])
                ->andFilterWhere([ 'student_fee.class_id' =>$class_id ])
                ->andFilterWhere([ 'student_fee.section_id' =>$section_id ])
                ->andWhere([ 'student_fee.school_id' => \Yii::$app->user->school->id ])
                ->andWhere(["!=",  'student_fee.fee_month' ,'default' ])->asArray()->all();
//                ->sum('fee_amount+fee_addon_sum');
//        print_r($q[0]);
//        
//        die;
//        $feeSum = Yii::$app->db->createCommand($sql)
//           ->queryOne();
        $feeSum = $q[0];
       
        if($feeSum['total_due_amount'] > 0 ){
//             print $currentM.$class_id.'<br>'."feetotal".$feeSum['total_due_amount']."<br />"."p".$feeSum['total_paid']." >> ";
//            print strtotime($start_date); print ">> ".strtotime($end_date); die;
            $remain =  $feeSum['total_due_amount'] - $feeSum['total_paid'];
            $remain_cr =  $feeSum['current_due_amount'] - $feeSum['total_paid'];
            $paidpr = ($feeSum['total_paid'] * 100) / $feeSum['total_due_amount'];
            $paidpr_cr = ($feeSum['total_paid'] * 100) / $feeSum['current_due_amount'];
            $discountpr = ($feeSum['total_discount'] * 100) / $feeSum['total_due_amount'];
            $pendingpr = ($remain * 100) / $feeSum['total_due_amount'];
            $pendingpr_cr = ($remain_cr * 100) / $feeSum['current_due_amount'];
            
        
        }
        else{ //for month have no fee processed due to vacations or any reason. (like June and July) 
            $q = \backend\modules\fee\models\StudentFee::find()
                ->select('SUM(sfp.paid_amount) total_paid')
                ->leftJoin('student_fee_addon sfadd', '`sfadd`.`student_fee_id` = `student_fee`.`id`')
                ->leftJoin('student_fee_payment_receipt sfp', '`sfp`.`student_fee_id` = `student_fee`.`id`')
                ->where([">=", 'sfp.created_at', strtotime($start_date)] )
                ->andWhere(["<=", 'sfp.created_at', strtotime($end_date)] )
                ->orWhere(['student_fee.fee_month'=> date('F' ,strtotime($start_date))])    
                ->andFilterWhere([ 'student_fee.class_id' =>$class_id ])
                ->andFilterWhere([ 'student_fee.section_id' =>$section_id ])
                ->andWhere([ 'student_fee.school_id' => \Yii::$app->user->school->id ])
                ->andWhere(["!=",  'student_fee.fee_month' ,'default' ])->asArray()->all();
            
             $feeSum = $q[0];
        } 
//        print ">>".$remain;
        $feereportData = [ 
            'month_name' => date('F', mktime(0, 0, 0,$currentM, 10))." ".$currentY,
            'month' => $currentM, 'year' => $currentY,
            'fee_sum' =>$feeSum, 'remain' => $remain, 'remain_cr' => $remain_cr, 'pendingpr' => round($pendingpr), 'pendingpr_cr' => round($pendingpr_cr),
            'paidpr' => round($paidpr, 2),'paidpr_cr' => round($paidpr_cr, 2),
            'discountpr' => round($discountpr),
                'pendingpr' =>round($pendingpr)];
        
        return ($feeSum['total_due_amount']>0 or $feeSum['total_paid']>0) ? $feereportData : NULL;
        // implement calculate monthly report and return array of months
    }
    
    function test(){
         $sql = "SELECT SUM(fee_amount+fee_addon_sum) total_due_amount,
                SUM(discount_amount) total_discount, SUM(sfadd.admission_fee) adm_fee, SUM(sfadd.arrears) arr,
                SUM(sfadd.annual_fee) ann_fee, SUM(sfp.paid_amount) total_paid
                FROM student_fee sf
                LEFT JOIN student_fee_addon sfadd ON(sf.id = sfadd.student_fee_id)
                LEFT JOIN student_fee_payment_receipt sfp ON(sf.id = sfp.student_fee_id)	
                WHERE ( DATE_FORMAT(FROM_UNIXTIME(sf.created_at), '%Y-%c-%d') >= '"
                .$last_year."-".$last_month."-28'
                AND DATE_FORMAT(FROM_UNIXTIME(sf.created_at), '%Y-%c-%d') <= '"
                .$current_year."-".$current_month."-30')
                AND sf.fee_year = ".$current_year.
                " AND sf.school_id = '".Yii::$app->user->school->id."' and sf.fee_month != 'default' ";
        
        //not in use
        $sql_ = "SELECT SUM(fee_amount+fee_addon_sum) total_due_amount,SUM(fee_addon_sum),
        SUM(discount_amount) total_discount, SUM(sfadd.admission_fee) adm_fee
        FROM student_fee sf
        JOIN student_fee_addon sfadd ON(sf.id = sfadd.student_fee_id)
        WHERE ( DATE_FORMAT(FROM_UNIXTIME(sf.created_at), '%Y-%c-%d') >= '$year-$month-01'
        AND DATE_FORMAT(FROM_UNIXTIME(sf.created_at), '%Y-%c-%d') <= '$year-$month-30')
        AND sf.fee_year = $year AND sf.school_id = '".Yii::$app->user->school->id. "' and fee_month != 'default' ";
        
    }
}
