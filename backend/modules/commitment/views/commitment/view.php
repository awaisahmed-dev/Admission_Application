<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\commitment\models\CommitmentModel */

// $this->title = 'View Commitment';
// $this->title = $model->id;
$this->title = Yii::t('backend', 'view {modelClass}: ', [
    'modelClass' => 'Commitment',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Commitment Models'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="commitment-model-view">

    <p>
        <?php echo Html::a(Yii::t('backend', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php echo Html::a(Yii::t('backend', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('backend', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'parent_id',
            'amount',
            'payment_plan:ntext',
            'date',
            'due_date',
            'details:ntext',
            'status',
            'created_by',
            'updated_by',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
