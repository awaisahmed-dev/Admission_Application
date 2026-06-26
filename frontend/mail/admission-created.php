<?php

use yii\helpers\Html;

?>

<h2>New Admission Application</h2>

<p>
A new admission application has been submitted.
</p>

<p>
Application ID:
<?= $parent->id ?>
</p>

<p>
Father:
<?= Html::encode(
    $parent->father_first_name.' '.
    $parent->father_last_name
) ?>
</p>