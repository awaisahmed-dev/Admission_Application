<?php
date_default_timezone_set('Asia/Karachi');
/* 
 * School Admin
 * Dashboard
 */
$this->title = Yii::t('backend', 'Campus Management Dasboard');

$schoolid =Yii::$app->user->school->id;
$sett = (json_decode(Yii::$app->keyStorage->get("$schoolid@school.settings")));

$currency = $sett->currency ? Yii::$app->formatter->currencyCode = $sett->currency: "PKR";		
 \Yii::$app->formatter->currencyCode = $currency;  
?>
<div class="row">
    <div class="col-md-12"> <h1><?php echo Yii::$app->name ?> Dashboard<small>(<?php echo date('l, d F Y h:i')?>)</small></h1></div>
    
</div>
<div class="row ">
    <div class="col-md-3 b-left" ><a href="/school-management/student" class="text-success">
            <i class="fa fa-graduation-cap fa-5x"></i><span class=" Count" style="font-size: 48px;" ><?php print $dataCount['_student'] ?></span> Students<h3 >Students List</h3>
        </a></div>
    <div class="col-md-4 b-left" ><a href="/fee-management/student-fee" class="text-info"><i class="fa fa-money fa-5x"></i>
            <?php print $currency;?><span class=" Count" style="font-size: 48px; margin:20px;" ><?php print $dataCount['_student_fee'] ?></span> Due Fee(Pending)<h3>Student Fees</h3></a></div>
    <div class="col-md-4 b-left" ><a href="/fee-management/student-fee-payment-receipt" class="text-danger"><i class="fa fa-info fa-5x"></i>
            <?php print $currency; ?><span class=" Count" style="font-size: 48px; margin:20px;" ><?php print $dataCount['_student_fee_receipt'] ?></span> Received  <h3>Fee Receipts</h3></a></div>
    
</div>

<div class="row" >
    <div class="col-md-3 b-left" ><a href="/notification/notification" class="text-black"><i class="fa fa-envelope-o fa-5x"></i>
            <span class=" Count" style="font-size: 32px; margin:20px;" ><?php print $dataCount['_dashboard_notification_count'] ?></span>
            <span class="pull-right"> <?php echo date('M Y')?></span><h3>Notifications</h3> </a></div>
    <div class="col-md-2 b-left" ><a href="/school-management/examination/exam-board/" class="text-black"><i class="fa fa-calendar fa-5x"></i><h3>Examination Board</h3></a></div>
   <?php if(Yii::$app->user->role == 'school-admin' or Yii::$app->user->role == 'account-clerk'): ?>
    <div class="col-md-3 b-left"><a href="/dashboard/fee" class="text-navy"><i class="fa fa-bar-chart-o fa-5x "></i><h3> Fee Statistics</h3></a></div>
    <div class="col-md-2 b-left"><a href="/dashboard/student-stats" class="text-navy"><i class="fa fa-pie-chart fa-5x "></i><h3>Student Statistics</h3></a></div>
    <?php endif;?>
    <div class="col-md-2 b-left"><a href="/elearning/learning-content" class="text-navy"><i class="fa fa-globe fa-5x "></i><h3>E learning</h3></a></div>
</div>

