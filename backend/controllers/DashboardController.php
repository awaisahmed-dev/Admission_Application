<?php

namespace backend\controllers;

use Yii;
use backend\models\search\TimelineEventSearch;
use yii\web\Controller;
use backend\modules\SchoolManagement\models\Student;
/**
 * Application dashboard controller
 */
 
$schoolid =Yii::$app->user->school->id;
$sett = (json_decode(Yii::$app->keyStorage->get("$schoolid@school.settings")));

$currency = $sett->currency ? Yii::$app->formatter->currencyCode = $sett->currency: "PKR";		
 \Yii::$app->formatter->currencyCode = $currency;  
class DashboardController extends Controller
{
    public $layout = 'common';
    /**
     * Lists all TimelineEvent models.
     * @return mixed
     */
    
    public function actionIndex() {
        
        $dataCount = [];
        
        if(Yii::$app->user->role == 'Parent') {
        
            $dataCount['_student'] = \backend\modules\SchoolManagement\models\Student::find()->parentStudents()->count();
        $dataCount['_student_fee'] = \backend\modules\fee\models\StudentFee::find()->parentDueFee()->sum('fee_amount');
        $dataCount['_student_fee_receipt'] = \backend\modules\fee\models\StudentFeePaymentReceipt::find()->parentFeePayment()->sum('paid_amount');
        $dataCount['_dashboard_notification_count'] = Yii::$app->user->school->getNotifications()
        ->where(['MONTH(FROM_UNIXTIME(created_at))'=>date('m')])
        ->andWhere(['to_number'=>Student::find()->where(['parent_id'=>Yii::$app->user->id])->andWhere('mobile IS NOT NULL')->one()->mobile])
        ->count();
        }else{
        
        $dataCount['_student'] = \backend\modules\SchoolManagement\models\Student::find()->schoolStudents()->count();
        $dataCount['_student_fee'] = \backend\modules\fee\models\StudentFee::find()->schoolDueFee()->sum('fee_amount');
        $dataCount['_student_fee_receipt'] = \backend\modules\fee\models\StudentFeePaymentReceipt::find()->schoolFeePayment()->sum('paid_amount');
        $dataCount['_dashboard_notification_count'] = Yii::$app->user->school->getNotifications()->where(['MONTH(FROM_UNIXTIME(created_at))'=>date('m'), 'YEAR(FROM_UNIXTIME(created_at))'=>date('Y')])->count();
        }
        
        return $this->render('index', ['dataCount' =>$dataCount]);
    }
    
    public function actionFee($month = null, $year=null, $reload=0)
            
    {
        ini_set('mysql.connect_timeout', 8000);
        ini_set('mysql.memory_limit ', '128M');
        ini_set('default_socket_timeout', 6000);

        $searchModel = new TimelineEventSearch();
        
        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = [
            'defaultOrder'=>['created_at'=>SORT_DESC]
        ];
        
        $feeReport = $this->calculateFeeSummary($month, $year, $reload);

        return $this->render('fee_stats', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'feeReport' => $feeReport,
        ]);
    }
    public function actionStudentStats($month = null, $year=null)            
    {
        $studentStats = $this->generateStudentStats($month, $year);

        return $this->render('student_stats', [
            'studentStats' => $studentStats,
            'reportTypes' => ['gender', 'class_id', 'status']
        ]);
    }
    public function actionDetailReport($t = 'class', $month = null, $year = null)
            
    {
//        ini_set('mysql.connect_timeout', 8000);
//        ini_set('mysql.memory_limit ', '128M');
//        ini_set('default_socket_timeout', 6000);
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
    
    private function calculateFeeSummary($month = null, $year = null, $reload=0){
        
        if($reload!=0) {Yii::$app->cache->flush();}
        if(( !isset($month) || $month == '' or Yii::$app->request->get('past_months_view') == 1) and ($year == "" or $year == date('Y')) ){
            for($m = 0 ; $m < 12; $m++){
                $lm = $m-1;
                if($m > 2 and Yii::$app->request->get('past_months_view') != 1) break;
                
                $cacheid    = 'fee_report_'.Yii::$app->user->school->id."_".date('nY', strtotime("-$m month") );
                $currentM= date('n', strtotime("-$lm month") ); $currentY= date('Y', strtotime("-$lm month") ); 
                Yii::$app->cache->get($cacheid);
                // $monthlyFeeReport = Yii::$app->cache->get($cacheid) ? Yii::$app->cache->get($cacheid) : $this->calculateMonthlyFeeReport($currentM, $currentY);
                if($m > 0 )
                    $monthlyFeeReport =  $this->calculateMonthlyFeeReport($currentM, $currentY);
                else 
                    $monthlyFeeReport = Yii::$app->cache->get($cacheid);

                if(!is_null( $monthlyFeeReport) && $m > 0){
                $feeReport[ date('n', strtotime("-$m month") ) ] =  $monthlyFeeReport; //$this->calculateMonthlyFeeReport($currentM, $currentY);
                $feeReport[ date('n', strtotime("-$m month") ) ]['student_count'] 
                        =  Yii::$app->user->school->getStudents(1, ['startDate' => $currentY.'-'.$currentM."-31",])->count();
                $feeReport[ date('n', strtotime("-$m month") ) ]['admission_count'] 
                        =  Yii::$app->user->school->getSchoolAdmissions( ['startDate' => $currentY.'-'.$currentM."-01",
                            'endDate' => $currentY.'-'.$currentM."-31"]);
                $feeReport[ date('n', strtotime("-$m month") ) ]['left_student_count'] 
                        =  Yii::$app->user->school->getLeftStudents( ['startDate' => $currentY.'-'.$currentM."-01",
                            'endDate' => $currentY.'-'.$currentM."-31"]);
                $feeReport[ date('n', strtotime("-$m month") ) ]['left_student_fee_sum'] 
                        =  Yii::$app->user->school->getLeftStudentsFeeSum( ['startDate' => $currentY.'-'.$currentM."-01",
                            'endDate' => $currentY.'-'.$currentM."-31"]);
                
                }
                if($m != 0 and !Yii::$app->cache->get($cacheid)){
                                // Storing $value in Cache
                $value = $feeReport[ date('n', strtotime("-$m month") ) ];
//                $cacheid    = 'fee_report_'.date('n', strtotime("-$m month") );
                $time  = 3600*24*60; // in seconds
                $dep = new \yii\caching\DbDependency();
                $dep->sql = 'SELECT MAX(updated_at) FROM student_fee where Month(date) = '.date('nY', strtotime("-$m month") );

                Yii::$app->cache->set($cacheid, $value, $time, $dep);}
//                 Yii::$app->cache->delete($id);
//                 Yii::$app->cache->flush();
            }
        
        }else{ 
           // die("in else");
           if($month !='' and $year > 0){
            $feeReport[ date_parse($month)['month'] ] =  $this->calculateMonthlyFeeReport(date_parse($month)['month'], $year);
            $feeReport[ date_parse($month)['month'] ]['student_count'] 
                        =  Yii::$app->user->school->getStudents(1, ['startDate' => $year.'-'.date_parse($month)['month']."-31",])->count();
            $feeReport[ date_parse($month)['month']]['admission_count'] 
                        =  Yii::$app->user->school->getSchoolAdmissions( ['startDate' => $year.'-'.date_parse($month)['month']."-01",
                            'endDate' => $year.'-'.date_parse($month)['month']."-31"]);
                        }
            if($month == '' and $year > 0){

                for($m = 1 ; $m <= 12; $m++){        

                    $feeReport[ $m ] =  $this->calculateMonthlyFeeReport($m, $year);
                    $feeReport[ $m ]['student_count'] 
                                =  Yii::$app->user->school->getReportStudents( ['startDate' => $year.'-'.$m."-31", 'endDate' => $year.'-'.$m."-01"])->count();
                    $feeReport[ $m]['admission_count'] 
                                =  Yii::$app->user->school->getSchoolAdmissions( ['startDate' => $year.'-'.$m."-01",
                                    'endDate' => $year.'-'.$m."-31"]);     
                    $feeReport[ $m ]['left_student_count'] 
                                    =  Yii::$app->user->school->getLeftStudents( ['startDate' => $year.'-'.$m."-01",
                                        'endDate' => $year.'-'.$m."-31"]);
                    $feeReport[ $m ]['left_student_fee_sum'] 
                                    =  Yii::$app->user->school->getLeftStudentsFeeSum( ['startDate' => $year.'-'.$m."-01",
                                        'endDate' => $year.'-'.$m."-31"]);                           
                }        
            }        
        }
        // print_r($feeReport); die;
        
        return $feeReport;

    }
    
    private function calculateDetailReport($t, $typeData, $month = null, $year= null){

//        for($m = 0 ; $m < 12; $m++){
            $lm = $m-1;
            
             $currentM= date('n' ); $currentY= date('Y' ); //die;
             if(!is_null($month)) 
                 $currentM = date_parse($month)['month']; 
             if(!is_null($year)) $currentY = $year;
            
            foreach ($typeData as $key => $section){
//                print $currentM.$class->id.">>".$class->title."<br>";;
                if($t == 'class' ){ 
                    $cal = $this->calculateMonthlyFeeReport($currentM, $currentY, $section->id);
//                    $cal = $this->calculateSectionFeeReport($currentM, $currentY, $section->id);
//                    print_r($cal);die;
//                    if($key > 12)break;
                }
                else if($t == 'section' ){ 
                    $cal = $this->calculateMonthlyFeeReport($currentM, $currentY, $section->parent_class_id, $section->id);}
                else{$cal = $this->calculateMonthlyFeeReport($currentM, $currentY);}
                
                if(!is_null($cal )){
                $feeReport[ date('n' ) ][$section->id] =  $cal;
                $feeReport[ date('n' ) ][$section->id]['title'] =  $section->title;
                if($t == 'section'){
                    $feeReport[ date('n' ) ][$section->id]['student_count'] =  count($section->getSectionStudents(['startDate' => $currentY.'-'.$currentM."-31"])->all()); // please calculate on provided params 
                    if(Yii::$app->request->get('fullView') == 1) {
                        $feeReport[ date('n' ) ][$section->id]['admission_count'] =  
                            ($section->getSectionAdmissions(['startDate' => $currentY.'-'.$currentM."-01", 'endDate' => $currentY.'-'.$currentM."-31"]));
                        $feeReport[ date('n' ) ][$section->id]['left_student_count'] =  
                            ($section->getSectionLeftStudents(['startDate' => $currentY.'-'.$currentM."-01", 'endDate' => $currentY.'-'.$currentM."-31"]));
                    
                    }
                    $feeReport[ date('n' ) ][$section->id]['monthly_fee'] =  $section->parent->monthly_tution_fee;
                
                }else if($t == 'class'){
                    $feeReport[ date('n' ) ][$section->id]['student_count'] =  count($section->getClassStudents(['startDate' => $currentY.'-'.$currentM."-31"])->all());
                    if(Yii::$app->request->get('fullView') == 1){
                        $feeReport[ date('n' ) ][$section->id]['admission_count'] =  ($section->getclassAdmissions(['startDate' => $currentY.'-'.$currentM."-01", 'endDate' => $currentY.'-'.$currentM."-31"]));
                        $feeReport[ date('n' ) ][$section->id]['left_student_count'] =  ($section->getClassLeftStudents(['startDate' => $currentY.'-'.$currentM."-01", 'endDate' => $currentY.'-'.$currentM."-31"]));
                    
                    }
                    $feeReport[ date('n' ) ][$section->id]['monthly_fee'] =  $section->monthly_tution_fee;
                }

                }   
            }
//        }
         return $feeReport;

    }

    private function calculateMonthlyFeeReport($currentM, $currentY, $class_id = null, $section_id = null){
        /**
         * CALL fee_stats_group(10, 2018, 22);
            CALL fee_stats_IN(09, 2018, 31);
            CALL fee_stat_IN(09, 2018, 22);
         */
        if(strlen($currentM) <2 ) $currentM = "0".$currentM;
       $start_date = $currentY.'-'.$currentM.'-01';
       $end_date = $currentY.'-'.$currentM.'-31';
        $feereportData = [];
        $feeSum = [];
        $reportField = 'created_at';
        $reportField = 'date';
        if(\backend\modules\SchoolManagement\models\Student::find()->where(['school_id'=>Yii::$app->user->school->id,'status'=>1])->count() <1000 ):
        $q = \backend\modules\fee\models\StudentFee::find()
                ->select('SUM(fee_amount+fee_addon_sum) total_due_amount, SUM(fee_amount) current_due_amount,
                    count(student_fee.id) as voucher_count,
                SUM(late_payment_fine) late_payment_fine, SUM(discount_amount) total_discount, SUM(sfadd.admission_fee) adm_fee, 
                SUM(sfadd.annual_exam_fee) annual_exam_fee, SUM(other) other, SUM(sfadd.arrears) arr,
                SUM(sfadd.annual_fee) ann_fee,
                ')
                ->leftJoin('student_fee_addon sfadd', '`sfadd`.`student_fee_id` = `student_fee`.`id`')
                // ->leftJoin('student_fee_payment_receipt sfp', '`sfp`.`student_fee_id` = `student_fee`.`id`')
                ->where([ 'Month(student_fee.'.$reportField.')'=> ($currentM)] )
                ->andwhere([ 'Year(student_fee.'.$reportField.')'=> ($currentY)] )
//                ->where([">=", 'student_fee.'.$reportField, ($start_date)] )
//                ->andWhere(["<=", 'student_fee.'.$reportField, ($end_date)] )
//                ->orWhere(['student_fee.fee_month'=> date('F' ,strtotime($start_date)), 'student_fee.fee_year'=> date('Y' ,strtotime($start_date))])
                ->andFilterWhere([ 'student_fee.class_id' =>$class_id ])
                ->andFilterWhere([ 'student_fee.section_id' =>$section_id ])
                ->andWhere([ 'student_fee.school_id' => \Yii::$app->user->school->id ])
                ->andWhere(["!=",  'student_fee.fee_month' ,'default' ])->andWhere(["!=",  'student_fee.status' ,'-1' ])->asArray()->all();
//                ->sum('fee_amount+fee_addon_sum');
//        print_r($q[0]);
//        
//        die;
            $reportField = 'payment_date';
            $qPayment = \backend\modules\fee\models\StudentFeePaymentReceipt::find()
                ->select('SUM(paid_amount) total_paid,')
                ->where([ 'Month(student_fee_payment_receipt.'.$reportField.')'=> ($currentM)] )
                ->andwhere([ 'Year(student_fee_payment_receipt.'.$reportField.')'=> ($currentY)] )
                // ->andFilterWhere([ 'student_fee_payment_receipt.class_id' =>$class_id ])
                ->andFilterWhere([ 'student_fee_payment_receipt.section_id' =>$section_id ])
                ->andWhere([ 'student_fee_payment_receipt.school_id' => \Yii::$app->user->school->id ])
                ->andWhere(["!=",  'student_fee_payment_receipt.status' ,'-1' ])->asArray()->all();
        else :
        $q = \backend\modules\fee\models\StudentFee::find()
                ->select('SUM(fee_amount+fee_addon_sum) total_due_amount, SUM(fee_amount) current_due_amount,
                    count(student_fee.id) as voucher_count,
                SUM(discount_amount) total_discount, SUM(sfadd.admission_fee) adm_fee, 
                SUM(sfadd.arrears) arr,
                SUM(sfadd.annual_fee) ann_fee, SUM(sfp.paid_amount) total_paid,
                (SUM(sfp.paid_amount)/SUM(fee_amount)*100)  cr_paid_pr,
                (SUM(sfp.paid_amount)/SUM(fee_amount+fee_addon_sum)*100)  total_paid_pr')
                ->leftJoin('student_fee_addon sfadd', '`sfadd`.`student_fee_id` = `student_fee`.`id`')
                ->leftJoin('student_fee_payment_receipt sfp', '`sfp`.`student_fee_id` = `student_fee`.`id`')
                ->where([ 'Month(student_fee.'.$reportField.')'=> ($currentM)] )
                ->andwhere([ 'Year(student_fee.'.$reportField.')'=> ($currentY)] )
//                ->where([">=", 'student_fee.'.$reportField, ($start_date)] )
//                ->andWhere(["<=", 'student_fee.'.$reportField, ($end_date)] )
//                ->orWhere(['student_fee.fee_month'=> date('F' ,strtotime($start_date)), 'student_fee.fee_year'=> date('Y' ,strtotime($start_date))])
                ->andFilterWhere([ 'student_fee.class_id' =>$class_id ])
                ->andFilterWhere([ 'student_fee.section_id' =>$section_id ])
                ->andWhere([ 'student_fee.school_id' => \Yii::$app->user->school->id ])
                ->andWhere(["!=",  'student_fee.fee_month' ,'default' ])->andWhere(["!=",  'student_fee.status' ,'-1' ])->asArray()->all();
        endif;
//        $feeSum = Yii::$app->db->createCommand($sql)
//           ->queryOne();
        $feeSum = $q[0]; $paymentSum = $qPayment[0];
       
        if($feeSum['total_due_amount'] > 0 ){ $feeSum['total_paid']= $paymentSum['total_paid']; 
//             print $currentM.$class_id.'<br>'."feetotal".$feeSum['total_due_amount']."<br />"."p".$feeSum['total_paid']." >> ";
//            print strtotime($start_date); print ">> ".strtotime($end_date); die;
            $remain =  $feeSum['total_due_amount'] - $feeSum['total_paid'];
            $remain_cr =  $feeSum['current_due_amount'] - $feeSum['total_paid'];
            $paidpr = $feeSum['total_due_amount'] > 0 ? ($feeSum['total_paid'] * 100) / $feeSum['total_due_amount']: 0;
            $paidpr_cr = $feeSum['current_due_amount'] > 0 ? ($feeSum['total_paid'] * 100) / $feeSum['current_due_amount']: 0;
            $discountpr = ($feeSum['total_discount'] * 100) / $feeSum['total_due_amount'];
            $pendingpr = ($remain * 100) / $feeSum['total_due_amount'];
            $pendingpr_cr = $remain_cr > 0?  ($remain_cr * 100) / $feeSum['current_due_amount']: 0;
            $feeSum['cr_paid_pr']= $paidpr_cr;
            // if($paidpr < 0) $paidpr = 0;
            // if($pendingpr_cr < 0) $pendingpr_cr = 0;
            
        
        }
        else{ //for month have no fee processed due to vacations or any reason. (like June and July) 
            $q = \backend\modules\fee\models\StudentFee::find()
                ->select('SUM(sfp.paid_amount) total_paid')
                ->leftJoin('student_fee_addon sfadd', '`sfadd`.`student_fee_id` = `student_fee`.`id`')
                ->leftJoin('student_fee_payment_receipt sfp', '`sfp`.`student_fee_id` = `student_fee`.`id`')
                ->where([">=", 'sfp.created_at', strtotime($start_date)] )
                ->andWhere(["<=", 'sfp.created_at', strtotime($end_date)] )
                //->orWhere(['student_fee.fee_month'=> date('F' ,strtotime($start_date))])    
                ->andFilterWhere([ 'student_fee.class_id' =>$class_id ])
                ->andFilterWhere([ 'student_fee.section_id' =>$section_id ])
                ->andWhere([ 'student_fee.school_id' => \Yii::$app->user->school->id ])
                ->andWhere(["!=",  'student_fee.fee_month' ,'default' ])->andWhere(["!=",  'student_fee.status' ,'-1' ])->asArray()->all();
            
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
    
    function generateStudentStats($month, $year){
        $reportTypes = ['gender', 'class_id'];//, 'status', 'Year(admission_date)', 'Month(admission_date)'
        
        foreach($reportTypes as  $reportType){
        
        $report[$reportType] = \backend\modules\SchoolManagement\models\Student::find()
                ->select($reportType.',  count(id) student_count ')
                ->andWhere(['not', [$reportType => null] ])
                ->andWhere([ 'status'=>1, 'school_id' => Yii::$app->user->school->id])
               // ->andWhere(['MONTH(DATE)' => $month, 'Year(DATE)' => $year] )
                ->groupBy($reportType)->all();
        
        }
        $report['admission_year'] = \backend\modules\SchoolManagement\models\Student::find()
                ->select(' Year(admission_date) admission_year ,  count(id) student_count ')
                ->andWhere(['not', [$reportType => null] ])
                ->andWhere([ 'status'=>1, 'school_id' => Yii::$app->user->school->id])
               // ->andWhere(['MONTH(DATE)' => $month, 'Year(DATE)' => $year] )
                ->groupBy('admission_year')->all();
        return $report;
    }
    
    private function calculateSectionFeeReport($currentM, $currentY, $class_id = null, $section_id = null){

        if(strlen($currentM) <2 ) $currentM = "0".$currentM;
       $start_date = $currentY.'-'.$currentM.'-01';
       $end_date = $currentY.'-'.$currentM.'-31';
        $feereportData = [];
        $feeSum = [];
        $reportField = 'created_at';
        $reportField = 'date';
//        if(\backend\modules\SchoolManagement\models\Student::find()->count() <1000 ):
        $q = \backend\modules\fee\models\StudentFee::find()
                ->select('SUM(fee_amount+fee_addon_sum) total_due_amount, SUM(fee_amount) current_due_amount,
                    count(student_fee.id) as voucher_count,
                SUM(late_payment_fine) late_payment_fine, SUM(discount_amount) total_discount, SUM(sfadd.admission_fee) adm_fee, 
                SUM(sfadd.annual_exam_fee) annual_exam_fee, SUM(other) other, SUM(sfadd.arrears) arr,
                SUM(sfadd.annual_fee) ann_fee, SUM(sfp.paid_amount) total_paid,
                (SUM(sfp.paid_amount)/SUM(fee_amount)*100)  cr_paid_pr,
                (SUM(sfp.paid_amount)/SUM(fee_amount+fee_addon_sum)*100)  total_paid_pr')
                ->leftJoin('student_fee_addon sfadd', '`sfadd`.`student_fee_id` = `student_fee`.`id`')
                ->leftJoin('student_fee_payment_receipt sfp', '`sfp`.`student_fee_id` = `student_fee`.`id`')
                ->where([ 'Month(student_fee.'.$reportField.')'=> ($currentM)] )
                ->andwhere([ 'Year(student_fee.'.$reportField.')'=> ($currentY)] )
//                ->where([">=", 'student_fee.'.$reportField, ($start_date)] )
//                ->andWhere(["<=", 'student_fee.'.$reportField, ($end_date)] )
//                ->orWhere(['student_fee.fee_month'=> date('F' ,strtotime($start_date)), 'student_fee.fee_year'=> date('Y' ,strtotime($start_date))])
                ->andFilterWhere([ 'student_fee.class_id' =>$class_id ])
                ->andFilterWhere([ 'student_fee.section_id' =>$section_id ])
                ->andWhere([ 'student_fee.school_id' => \Yii::$app->user->school->id ])
                ->andWhere(["!=",  'student_fee.fee_month' ,'default' ])->andWhere(["!=",  'student_fee.status' ,'-1' ])
//                ->groupBy(['student_fee.class_id'])
                ->asArray()->all();
    }
    
}
