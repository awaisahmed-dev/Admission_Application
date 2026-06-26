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

    <h3 class="timeline-header bg-warning">

        <?= Yii::t('backend','You have ') .
            str_replace('-', ' ', $model->event)
            .' in '
            . ucfirst($model->category)
            .'#'.$thisData['id']
        ?>

    </h3>

    <div class="timeline-body">

        <dl>

            <dt>Event:</dt>
            <dd><?= ucfirst($model->event) ?></dd>

            <dt>Content:</dt>
            <dd>
                <?= $thisData['content'] ?>

                <a href="<?= $thisData['url'] ?>"
                   class="btn btn-primary btn-sm">
                    Check Now
                </a>
            </dd>

            <dt>Date:</dt>
            <dd>
                <?= Yii::$app->formatter->asDatetime($model->created_at) ?>
            </dd>

        </dl>

    </div>

</div>  