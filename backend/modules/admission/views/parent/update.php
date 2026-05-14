<?php

use yii\helpers\Html;

$this->title = 'Update Application # ' . $parentModel->id;
?>

<h1><?= Html::encode($this->title) ?></h1>

<?= $this->render('/form/index',[
'parentModel'=>$parentModel,
'children'=>$children,
'policyModel'=>$policyModel
]) ?>