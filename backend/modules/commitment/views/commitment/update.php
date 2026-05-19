<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\commitment\models\CommitmentModel */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Commitment',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Commitment Models'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="commitment-model-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
