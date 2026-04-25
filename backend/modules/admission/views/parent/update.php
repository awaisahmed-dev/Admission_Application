<?php

use yii\helpers\Html;

$this->title = 'Update Parent: ' . $model->father_first_name;
?>

<h1><?= Html::encode($this->title) ?></h1>

<?= $this->render('_form', [
    'model' => $model,
]) ?>