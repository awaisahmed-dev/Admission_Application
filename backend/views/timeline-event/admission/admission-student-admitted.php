<?php
/**
 * @var $model common\models\TimelineEvent
 */

$thisData = $model->data;
?>

<div class="timeline-item">

    <span class="time text-white">
        <i class="fa fa-clock-o"></i>
        <?= Yii::$app->formatter->asRelativeTime($model->created_at) ?>
    </span>

    <h3 class="timeline-header bg-success">

        <?= Yii::t('backend','You have ') .
            str_replace('-', ' ', $model->event)
            .' in '
            . ucfirst($model->category)
            .'#'.$thisData['parent_id']
        ?>

    </h3>

    <div class="timeline-body">

        <dl>

            <dt>Event:</dt>
            <dd><?= ucfirst($model->event) ?></dd>

            <dt>Email:</dt>
            <dd><?= $thisData['email'] ?? '' ?></dd>

            <dt>Date:</dt>
            <dd>
                <?= Yii::$app->formatter->asDatetime($model->created_at) ?>
            </dd>

        </dl>

    </div>

</div>