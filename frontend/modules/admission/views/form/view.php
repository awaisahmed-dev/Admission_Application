<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\admission\models\ParentModel */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Parent Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="parent-model-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'father_title',
            'father_first_name',
            'father_last_name',
            'father_mobile',
            'father_email:email',
            'mother_title',
            'mother_first_name',
            'mother_last_name',
            'mother_mobile',
            'mother_email:email',
            'address:ntext',
            'home_phone',
            'emergency_contact_name',
            'emergency_contact_number',
            'emergency_relationship',
            'status',
            'created_by',
            'updated_by',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
