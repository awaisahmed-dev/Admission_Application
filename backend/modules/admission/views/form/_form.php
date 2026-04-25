<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="admission-form">

<?php $form = ActiveForm::begin(); ?>

<!-- ================= PARENT SECTION ================= -->

<h3>Parent Information</h3>

<?= $form->field($parentModel, 'father_title')->dropDownList([
    'Mr' => 'Mr',
    'Dr' => 'Dr',
    'Other' => 'Other'
], ['prompt' => 'Select Title']) ?>

<?= $form->field($parentModel, 'father_first_name') ?>
<?= $form->field($parentModel, 'father_last_name') ?>
<?= $form->field($parentModel, 'father_mobile') ?>
<?= $form->field($parentModel, 'father_email') ?>

<?= $form->field($parentModel, 'mother_title')->dropDownList([
    'Mrs' => 'Mrs',
    'Miss' => 'Miss',
    'Ms' => 'Ms',
    'Dr' => 'Dr'
], ['prompt' => 'Select Title']) ?>

<?= $form->field($parentModel, 'mother_first_name') ?>
<?= $form->field($parentModel, 'mother_last_name') ?>
<?= $form->field($parentModel, 'mother_mobile') ?>
<?= $form->field($parentModel, 'mother_email') ?>

<?= $form->field($parentModel, 'address')->textarea() ?>
<?= $form->field($parentModel, 'home_phone') ?>

<h4>Emergency Contact</h4>
<?= $form->field($parentModel, 'emergency_contact_name') ?>
<?= $form->field($parentModel, 'emergency_contact_number') ?>
<?= $form->field($parentModel, 'emergency_relationship') ?>


<hr>

<!-- ================= CHILD SECTION ================= -->

<h3>Children Information</h3>

<div id="children-wrapper">

<?php foreach ($children as $i => $child): ?>

<div class="child-item panel panel-default" style="padding:15px; margin-bottom:15px;">

    <h4>Child <?= ($i+1) ?></h4>

    <?= $form->field($child, "[$i]first_name") ?>
    <?= $form->field($child, "[$i]last_name") ?>
    <?= $form->field($child, "[$i]date_of_birth")->input('date') ?>

    <?= $form->field($child, "[$i]gender")->dropDownList([
        1 => 'Male',
        2 => 'Female'
    ]) ?>

    <?= $form->field($child, "[$i]admission_type")->dropDownList([
        'new' => 'New',
        'returning' => 'Returning'
    ]) ?>

    <?= $form->field($child, "[$i]student_enrolment")->checkbox() ?>

    <?= $form->field($child, "[$i]school_name") ?>
    <?= $form->field($child, "[$i]school_suburb") ?>
    <?= $form->field($child, "[$i]school_class") ?>

    <?= $form->field($child, "[$i]learning_difficulties")->textarea() ?>
    <?= $form->field($child, "[$i]allergies")->textarea() ?>
    <?= $form->field($child, "[$i]medications")->textarea() ?>
    <?= $form->field($child, "[$i]allergy_to_medication")->checkbox() ?>

</div>

<?php endforeach; ?>

</div>

<button type="button" class="btn btn-success" id="add-child">+ Add Child</button>

<hr>

<!-- ================= POLICY SECTION ================= -->

<!-- <h3>Policy Agreement</h3> -->
<!-- 
<?= $form->field($policyModel, 'excursion_consent')->checkbox() ?>
<?= $form->field($policyModel, 'photo_consent')->checkbox() ?>
<?= $form->field($policyModel, 'data_usage_consent')->checkbox() ?>
<?= $form->field($policyModel, 'fee_agreement')->checkbox() ?>
<?= $form->field($policyModel, 'attendance_fee_agreement')->checkbox() ?>

<h4>Volunteer Options</h4>
<?= $form->field($policyModel, 'volunteer_cleaning')->checkbox() ?>
<?= $form->field($policyModel, 'volunteer_snacks')->checkbox() ?>
<?= $form->field($policyModel, 'volunteer_supervision')->checkbox() ?>
<?= $form->field($policyModel, 'volunteer_admin')->checkbox() ?>
<?= $form->field($policyModel, 'volunteer_teaching_quran')->checkbox() ?>
<?= $form->field($policyModel, 'volunteer_teaching_islamic')->checkbox() ?>
<?= $form->field($policyModel, 'volunteer_teaching_urdu')->checkbox() ?>

<h4>Agreements</h4>
<?= $form->field($policyModel, 'arrival_on_time')->checkbox() ?>
<?= $form->field($policyModel, 'toilet_responsibility')->checkbox() ?>
<?= $form->field($policyModel, 'dress_code')->checkbox() ?>
<?= $form->field($policyModel, 'after_class_responsibility')->checkbox() ?>
<?= $form->field($policyModel, 'device_policy')->checkbox() ?>
<?= $form->field($policyModel, 'information_correct')->checkbox() ?>

<?= $form->field($policyModel, 'signature_name') ?>
<?= $form->field($policyModel, 'signed_date')->input('date') ?> -->

<h3>Policies</h3>
<p>Please read the following school policies carefully and indicate your consent.</p>

<!-- YES / NO QUESTIONS -->

<?= $form->field($policyModel, 'excursion_consent')->radioList([
    1 => 'Yes',
    0 => 'No'
])->label('I consent for my child/children to go on supervised excursion/trips outside school and indemnify school of all liabilities.') ?>

<?= $form->field($policyModel, 'photo_consent')->radioList([
    1 => 'Yes',
    0 => 'No'
])->label('I agree to permit the school to take photographs of my child/children and to publish the photographs/work of child on different occasions such as school newsletter, school website etc.') ?>

<?= $form->field($policyModel, 'data_usage_consent')->radioList([
    1 => 'Yes',
    0 => 'No'
])->label('I agree to permit the school to use the provided information about my child/children for the purpose of applying for and monitoring funding under the NSW Community Languages Schools Program.') ?>

<?= $form->field($policyModel, 'fee_agreement')->radioList([
    1 => 'Yes',
    0 => 'No'
])->label('I agree to pay term fees during the first two weeks of the term.') ?>

<?= $form->field($policyModel, 'attendance_fee_agreement')->radioList([
    1 => 'Yes',
    0 => 'No'
])->label('I agree to pay term fees regardless of however many classes my child(/ren) attend or is/are absent from.') ?>
<hr>

<!-- VOLUNTEER (MULTI SELECT ✔) -->

<!-- <h6>Volunteer Options (Select at least one)</h6> -->
<h4>I  agree to contribute to any other volunteer roster as requested by School. Please select AT LEAST ONE or more areas you can volunteer.</h4>

<!-- 
<?= $form->field($policyModel, 'volunteer_cleaning')->checkbox()->label('Cleaning up / vacuuming') ?>
<?= $form->field($policyModel, 'volunteer_snacks')->checkbox()->label('Snack preparation') ?>
<?= $form->field($policyModel, 'volunteer_supervision')->checkbox()->label('Outdoor supervision of students') ?>
<?= $form->field($policyModel, 'volunteer_admin')->checkbox()->label('Admin assistance') ?>
<?= $form->field($policyModel, 'volunteer_teaching_quran')->checkbox()->label('Teaching: Quran (Tajweed and Makharij)') ?>
<?= $form->field($policyModel, 'volunteer_teaching_islamic')->checkbox()->label('Teaching: Islamic Studies') ?>
<?= $form->field($policyModel, 'volunteer_teaching_urdu')->checkbox()->label('Teaching: Urdu') ?> -->


<div class="checkbox">
    <label>
        <input type="checkbox" name="PolicyModel[volunteer_cleaning]" value="1">
        Cleaning up / vacuuming
    </label>
</div>

<div class="checkbox">
    <label>
        <input type="checkbox" name="PolicyModel[volunteer_snacks]" value="1">
        Snack preparation
    </label>
</div>

<div class="checkbox">
    <label>
        <input type="checkbox" name="PolicyModel[volunteer_supervision]" value="1">
        Outdoor supervision of students
    </label>
</div>

<div class="checkbox">
    <label>
        <input type="checkbox" name="PolicyModel[volunteer_admin]" value="1">
        Admin assistance
    </label>
</div>

<div class="checkbox">
    <label>
        <input type="checkbox" name="PolicyModel[volunteer_teaching_quran]" value="1">
        Teaching: Quran (Tajweed and Makharij)
    </label>
</div>

<div class="checkbox">
    <label>
        <input type="checkbox" name="PolicyModel[volunteer_teaching_islamic]" value="1">
        Teaching: Islamic Studies
    </label>
</div>

<div class="checkbox">
    <label>
        <input type="checkbox" name="PolicyModel[volunteer_teaching_urdu]" value="1">
        Teaching: Urdu
    </label>
</div>

<!-- MORE YES / NO -->
 <hr>

<?= $form->field($policyModel, 'arrival_on_time')->radioList([
    1 => 'Yes',
    0 => 'No'
])->label('I agree that I shall bring the child to the school on time.') ?>

<?= $form->field($policyModel, 'toilet_responsibility')->radioList([
    1 => 'Yes',
    0 => 'No'
])->label('I agree that I am responsible to ensure that the child is not najis while at the school. If the child needs assistance to use the toilet I will be available to help my child.. Although it might be part of the curriculum it is not the schools duty to ensure your child follows Islamic toilet manners.') ?>

<?= $form->field($policyModel, 'dress_code')->radioList([
    1 => 'Yes',
    0 => 'No'
])->label('I agree that the child shall always attend the school in the proper Islamic Dress Code (long sleeves and long pants for all children above 9 years, hijab for all girls).') ?>

<?= $form->field($policyModel, 'after_class_responsibility')->radioList([
    1 => 'Yes',
    0 => 'No'
])->label('I agree and understand that I shall look after the child after classes.') ?>

<?= $form->field($policyModel, 'device_policy')->radioList([
    1 => 'Yes',
    0 => 'No'
])->label('I understand that if the child is found to be using/displaying video games, consoles, iPods, mobile phones or similar devices during the school hours the devices might be confiscated and may not be returned.') ?>

<!-- AGREE / DISAGREE -->

<?= $form->field($policyModel, 'information_correct')->radioList([
    1 => 'Agree',
    0 => 'Disagree'
])->label('I state that all the details provided on this form are correct.') ?>

<!-- SIGNATURE -->

<?= $form->field($policyModel, 'signature_name')->textInput()->label('Signature (Full Name)') ?>

<?= $form->field($policyModel, 'signed_date')->input('date')->label('Date') ?>


<hr>

<div class="form-group">
    <?= Html::submitButton('Submit Application', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

</div>


<script>
let childIndex = <?= count($children) ?>;

document.getElementById('add-child').addEventListener('click', function () {
    let wrapper = document.getElementById('children-wrapper');

    let html = `
    <div class="child-item panel panel-default" style="padding:15px; margin-bottom:15px;">
        <h4>Child ${childIndex + 1}</h4>

        <input type="text" name="ChildModel[${childIndex}][first_name]" class="form-control" placeholder="First Name"><br>
        <input type="text" name="ChildModel[${childIndex}][last_name]" class="form-control" placeholder="Last Name"><br>
        <input type="date" name="ChildModel[${childIndex}][date_of_birth]" class="form-control"><br>

        <select name="ChildModel[${childIndex}][gender]" class="form-control">
            <option value="">Select Gender</option>
            <option value="1">Male</option>
            <option value="2">Female</option>
        </select><br>

        <select name="ChildModel[${childIndex}][admission_type]" class="form-control">
            <option value="new">New</option>
            <option value="returning">Returning</option>
        </select><br>

        <label>
        <input type="checkbox" name="ChildModel[${childIndex}][student_enrolment]" value="1">
        Student Enrolment
        </label><br><br>

        <input type="text" name="ChildModel[${childIndex}][school_name]" class="form-control" placeholder="School Name"><br>
        <input type="text" name="ChildModel[${childIndex}][school_suburb]" class="form-control" placeholder="School Suburb"><br>
        <input type="text" name="ChildModel[${childIndex}][school_class]" class="form-control" placeholder="School Class"><br>

        <textarea name="ChildModel[${childIndex}][learning_difficulties]" class="form-control" placeholder="Learning Difficulties"></textarea><br>
        <textarea name="ChildModel[${childIndex}][allergies]" class="form-control" placeholder="Allergies"></textarea><br>
        <textarea name="ChildModel[${childIndex}][medications]" class="form-control" placeholder="Medications"></textarea><br>
        <label>
        <input type="checkbox" name="ChildModel[${childIndex}][allergy_to_medication]" value="1">
        Allergy to Medication
        </label>



    </div>`;

    wrapper.insertAdjacentHTML('beforeend', html);
    childIndex++;
});
</script>