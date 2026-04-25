<?php
/**
 * @author Eugene Terentev <eugene@terentev.net>
 * @var $model common\models\TimelineEvent
 */
if($model->parent_type == 'announcement' || $model->parent_type == 'alert' || $model->parent_type == 'info') {$bg = "bg-blue-active";
$catIcon = "fa-bell";
}
 if(Yii::$app->user->role != 'Parent'): 
    if($model->parent_type == 'student' and $model->event == 'student_promotion') {$bg = "bg-blue-active"; $catIcon = "fa-student";}
    if($model->parent_type == 'student' and $model->event == 'student_promotion') {$bg = "bg-green-active"; $catIcon = "fa-student";}
    if($model->parent_type == 'student_fee') {$bg = "bg-olive-active"; $catIcon = "fa-money";}
    if($model->parent_type == 'student_fee' and $model->event == 'fee_process') {$bg = "bg-purple-active"; $catIcon = "fa-money";}
    if($model->parent_type == 'student_fee' and $model->event == 'outstanding_notification') {$bg = "bg-primary-active"; $catIcon = "fa-money";}
    if($model->parent_type == 'student_fee_receipt') {$bg = "bg-lime-active"; $catIcon = "fa-info";}
endif;
?>

<div class="timeline-item">
    <span class="time">
        <i class="fa fa-clock-o"></i>
        <?php echo Yii::$app->formatter->asRelativeTime($model->created_at) ?>
    </span>
    <h3 class="timeline-header <?php echo $bg ?> bg-">
        <?php 
        $notitype = ($model->type== '0' or $model->type== '1')? " Fee":$model->type;
        echo Yii::t('backend', 'You have new update in '). $notitype; ?>
        &nbsp;&nbsp;
        <i class="fa <?php echo $catIcon; ?>" title="<?php echo $model->parent_type?>"></i>
    </h3>

    <div class="timeline-body">
        <dl>
<!--            <dt><?php echo Yii::t('backend', 'Application') ?>:</dt>
            <dd><?php //echo $model->application ?></dd>-->

            <dt><?php echo Yii::t('backend', 'Title') ?>:</dt>
            <dd><?php echo ucfirst($model->parent_type) ?> (<?php echo $model->title;?>)</dd>
      
            <dt><?php echo Yii::t('Description', 'Contents') ?>:</dt>
            <dd><?php print $model->contents; ?></dd>
            
            <dt><?php echo Yii::t('backend', 'Date') ?>:</dt>
            <dd><?php echo Yii::$app->formatter->asDatetime($model->created_at) ?>,
			<small> Sent To: <?php echo $model->to_number?></small> </dd>
        </dl>
    </div>
</div>