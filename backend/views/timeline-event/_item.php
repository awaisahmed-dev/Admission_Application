<?php
/**
 * @author Eugene Terentev <eugene@terentev.net>
 * @var $model common\models\TimelineEvent
 */
if($model->category == 'announcement' || $model->category == 'alert' || $model->category == 'info') {$bg = "bg-blue-active";
$catIcon = "fa-bell";
}
if($model->category == 'student' ) {$bg = "bg-blue-active"; $catIcon = "fa-user";}
if($model->category == 'student' and $model->event == 'student_promotion') {$bg = "bg-blue-active"; $catIcon = "fa-user";}
if($model->category == 'student' and $model->event == 'student_promotion') {$bg = "bg-green-active"; $catIcon = "fa-user";}
if($model->category == 'student_fee') {$bg = "bg-olive-active"; $catIcon = "fa-money";}
if($model->category == 'student_fee' and $model->event == 'fee_process') {$bg = "bg-purple-active"; $catIcon = "fa-money";}
if($model->category == 'student_fee' and $model->event == 'outstanding_notification') {$bg = "bg-primary-active"; $catIcon = "fa-money";}
if($model->category == 'student_fee_receipt') {$bg = "bg-lime-active"; $catIcon = "fa-info";}
?>
<div class="timeline-item">
        <span class="time">
        <i class="fa fa-clock-o"></i>
        <?php echo Yii::$app->formatter->asRelativeTime($model->created_at) ?>
    </span>
    <h3 class="timeline-header <?php echo $bg;?>">
        <?php echo Yii::t('backend', 'You have new '.ucfirst($model->category)) ?> <i class="fa <?php echo $catIcon;?>" ></i>
    </h3>

    <div class="timeline-body">
        <dl>
<!--            <dt><?php echo Yii::t('backend', 'Application') ?>:</dt>
            <dd><?php echo $model->application ?></dd>-->

            <dt><?php echo Yii::t('backend', 'Category') ?>:</dt>
            <dd><?php echo ucfirst($model->category) ?> (<?php echo $model->data['title'].  $model->data['student_fee']. $model->data['student_fee_receipt']?>)</dd>

            <dt><?php echo Yii::t('backend', 'Event') ?>:</dt>
            <dd><?php echo $model->event ?> <?php if($model->data['url']){?>
                <a href="<?php echo $model->data['url']?>">View</a>
                <?php } ?>
            </dd>
            
            <dt><?php echo Yii::t('backend', 'Description') ?>:</dt>
            <dd><?php print $model->data['content']; ?></dd>
            
            <dt><?php echo Yii::t('backend', 'Date') ?>:</dt>
            <dd><?php echo Yii::$app->formatter->asDatetime($model->created_at) ?></dd>
        </dl>
    </div>
</div>