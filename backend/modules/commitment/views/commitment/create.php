<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\commitment\models\CommitmentModel */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Commitment',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Commitment Models'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="commitment-model-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
