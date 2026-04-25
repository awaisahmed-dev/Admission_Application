<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\admission\models\ParentModel */

$this->title = 'Create Parent Model';
$this->params['breadcrumbs'][] = ['label' => 'Parent Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parent-model-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
