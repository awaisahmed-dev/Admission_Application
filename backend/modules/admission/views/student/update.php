<?php

use yii\helpers\Html;

$this->title = 'Update Student: ' . $model->first_name;
?>

<h2><?= Html::encode($this->title) ?></h2>

<?= $this->render('_form', [
    'model' => $model,
]) ?>