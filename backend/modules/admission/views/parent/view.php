<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title='Application #'.$model->id;

$policy=$model->policies ? $model->policies[0] : null;
?>

<?php if($model->status==0):?>

<?= Html::a('Admit Student',
['admit','id'=>$model->id],
[
'class'=>'btn btn-success',
'data-method'=>'post'
]);?>


<?php else: ?>

<button class="btn btn-success" disabled>
Already Admitted
</button>

<?php endif;?>

<h2>Parent Information</h2>

<?= DetailView::widget([
'model'=>$model,
'attributes'=>[
'father_first_name',
'father_last_name',
'father_mobile',
'father_email',


'mother_first_name',
'mother_last_name',
'mother_mobile',
'mother_email',

'address:ntext',
'home_phone',
'emergency_contact_name',
'emergency_contact_number',
'emergency_relationship',
],
]);?>

<hr>

<h2>Children Information</h2>

<?php foreach($model->children as $child): ?>

<table class="table table-bordered">
<tr>
<th colspan="2">
Child #<?= $child->id ?>
</th>
</tr>

<tr>
<td>First Name</td>
<td><?= $child->first_name ?></td>
</tr>

<tr>
<td>Last Name</td>
<td><?= $child->last_name ?></td>
</tr>

<tr>
<td>DOB</td>
<td><?= $child->date_of_birth ?></td>
</tr>

<tr>
<td>Gender</td>
<td><?= $child->gender==1?'Male':'Female' ?></td>
</tr>

<tr>
<td>Admission Type</td>
<td><?= $child->admission_type ?></td>
</tr>

<tr>
<td>School</td>
<td><?= $child->school_name ?></td>
</tr>

<tr>
<td>Suburb</td>
<td><?= $child->school_suburb ?></td>
</tr>

<tr>
<td>Class</td>
<td><?= $child->school_class ?></td>
</tr>

<tr>
<td>Learning Difficulties</td>
<td><?= $child->learning_difficulties ?></td>
</tr>

<tr>
<td>Allergies</td>
<td><?= $child->allergies ?></td>
</tr>

<tr>
<td>Medications</td>
<td><?= $child->medications ?></td>
</tr>

</table>

<?php endforeach; ?>

<hr>

<h2>Policies</h2>

<?php if($policy): ?>

<table class="table table-bordered">

<tr>
<td>Excursion Consent</td>
<td><?= $policy->excursion_consent?'Yes':'No' ?></td>
</tr>

<tr>
<td>Photo Consent</td>
<td><?= $policy->photo_consent?'Yes':'No' ?></td>
</tr>

<tr>
<td>Data Usage</td>
<td><?= $policy->data_usage_consent?'Yes':'No' ?></td>
</tr>

<tr>
<td>Fee Agreement</td>
<td><?= $policy->fee_agreement?'Yes':'No' ?></td>
</tr>

<tr>
<td>Attendance Fee Agreement</td>
<td><?= $policy->data_usage_consent?'Yes':'No' ?></td>
</tr>


<tr>
<td>Volunteer Areas</td>
<td>

<?php
$v=[];

if($policy->volunteer_cleaning) $v[]='Cleaning up / vacuuming';
if($policy->volunteer_snacks) $v[]='Snack preparation';
if($policy->volunteer_supervision) $v[]='Outdoor supervision of students';
if($policy->volunteer_admin) $v[]='Admin assistance';
if($policy->volunteer_teaching_quran) $v[]='Teaching: Quran (Tajweed and Makharij)';
if($policy->volunteer_teaching_islamic) $v[]='Teaching: Islamic Studies';
if($policy->volunteer_teaching_urdu) $v[]='Teaching: Urdu'; 

echo implode(', ',$v);
?>

</td>
</tr>

<tr>
<td>Arrival On Time</td>
<td><?= $policy->arrival_on_time?'Yes':'No' ?></td>
</tr>

<tr>
<td>Toilet Responsibility</td>
<td><?= $policy->toilet_responsibility?'Yes':'No' ?></td>
</tr>

<tr>
<td>Dress Code</td>
<td><?= $policy->dress_code?'Yes':'No' ?></td>
</tr>

<tr>
<td>After Class Responsibility</td>
<td><?= $policy->after_class_responsibility?'Yes':'No' ?></td>
</tr>

<tr>
<td>Device Policy</td>
<td><?= $policy->device_policy?'Yes':'No' ?></td>
</tr>

<tr>
<td>Correct Information</td>
<td><?= $policy->information_correct?'Yes':'No' ?></td>
</tr>

<tr>
<td>Signature</td>
<td><?= $policy->signature_name ?></td>
</tr>

<tr>
<td>Signed Date</td>
<td><?= $policy->signed_date ?></td>
</tr>

</table>

<?php endif; ?>


<?php if($model->status==0):?>

<?= Html::a('Admit Student',
['admit','id'=>$model->id],
[
'class'=>'btn btn-success',
'data-method'=>'post'
]);?>


<?php else: ?>

<button class="btn btn-success" disabled>
Already Admitted
</button>

<?php endif;?>