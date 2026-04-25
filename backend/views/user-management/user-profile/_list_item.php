<?php
// _list_item.php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<article class="item" data-key="<?= $model->id; ?>">
    <h4 class="title">
    <?= Html::encode(Yii::$app->params['progressType'][$model->type]); ?>
    </h4>

    <div class="item-excerpt">
    <?= Html::encode($model->description); ?>
    </div>
</article>
