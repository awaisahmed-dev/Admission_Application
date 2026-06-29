<?php

use yii\helpers\Html;

/* @var $parent backend\modules\admission\models\ParentModel */

?>

<h2>Student Admission Confirmed</h2>

<p>
    Dear
    <?= Html::encode(
        $parent->father_first_name.' '.$parent->father_last_name
    ) ?>,
</p>

<p>
    Congratulations!
    Student admission has been completed successfully.
</p>

<p>
    Application ID:
    <strong><?= $parent->id ?></strong>
</p>

<p>
    Thank you.
</p>