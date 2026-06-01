<?php

namespace backend\modules\admission\models;

use Yii;

/**
 * This is the model class for table "student".
 *
 * @property int $id
 * @property int $school_id
 * @property int $parent_id
 * @property int $class_id
 * @property int $section_id
 * @property string $student_key
 * @property string $previous_recored_date
 * @property string $full_name
 * @property string $gender
 * @property string $surname
 * @property string $father_name
 * @property string $mother_name
 * @property double $fee_discount
 * @property string $date_of_birth
 * @property string $native_place
 * @property string $admission_date
 * @property string $gr_number
 * @property int $seat_number
 * @property string $admit_in_class
 * @property string $left_in_class
 * @property string $left_date
 * @property string $left_reason
 * @property string $address
 * @property string $locality
 * @property string $phone
 * @property string $mobile
 * @property string $email
 * @property string $cnic_number
 * @property string $b_form
 * @property string $vaccination
 * @property string $allergies
 * @property string $religion
 * @property string $nationality
 * @property string $previous_school
 * @property string $seat_number_ninth
 * @property string $seat_number_tenth
 * @property string $garde_in_tenth
 * @property string $certificate_number
 * @property string $other_details
 * @property string $progress
 * @property string $conduct
 * @property int $is_private
 * @property int $status
 * @property int $created_by
 * @property int $updated_by
 * @property int $created_at
 * @property int $updated_at
 *
 * @property StudentClass $section
 * @property StudentClass $class
 * @property User $parent
 * @property School $school
 * @property StudentAttendance[] $studentAttendances
 */
class StudentModel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'student';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['school_id', 'parent_id', 'class_id', 'section_id', 'seat_number', 'is_private', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['previous_recored_date', 'date_of_birth', 'admission_date', 'left_date'], 'safe'],
            [['full_name'], 'required'],
            [['fee_discount'], 'number'],
            [['address', 'other_details'], 'string'],
            [['student_key', 'surname', 'gr_number', 'locality', 'phone', 'mobile', 'cnic_number', 'b_form', 'vaccination', 'religion', 'nationality', 'seat_number_ninth', 'seat_number_tenth'], 'string', 'max' => 25],
            [['full_name', 'father_name', 'mother_name', 'native_place', 'left_reason', 'email', 'allergies', 'previous_school', 'progress', 'conduct'], 'string', 'max' => 50],
            [['gender', 'admit_in_class', 'left_in_class', 'garde_in_tenth', 'certificate_number'], 'string', 'max' => 11],
            [['section_id'], 'exist', 'skipOnError' => true, 'targetClass' => StudentClass::className(), 'targetAttribute' => ['section_id' => 'id']],
            [['class_id'], 'exist', 'skipOnError' => true, 'targetClass' => StudentClass::className(), 'targetAttribute' => ['class_id' => 'id']],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['parent_id' => 'id']],
            [['school_id'], 'exist', 'skipOnError' => true, 'targetClass' => School::className(), 'targetAttribute' => ['school_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'school_id' => 'School ID',
            'parent_id' => 'Parent ID',
            'class_id' => 'Class ID',
            'section_id' => 'Section ID',
            'student_key' => 'Student Key',
            'previous_recored_date' => 'Previous Recored Date',
            'full_name' => 'Full Name',
            'gender' => 'Gender',
            'surname' => 'Surname',
            'father_name' => 'Father Name',
            'mother_name' => 'Mother Name',
            'fee_discount' => 'Fee Discount',
            'date_of_birth' => 'Date Of Birth',
            'native_place' => 'Native Place',
            'admission_date' => 'Admission Date',
            'gr_number' => 'Gr Number',
            'seat_number' => 'Seat Number',
            'admit_in_class' => 'Admit In Class',
            'left_in_class' => 'Left In Class',
            'left_date' => 'Left Date',
            'left_reason' => 'Left Reason',
            'address' => 'Address',
            'locality' => 'Locality',
            'phone' => 'Phone',
            'mobile' => 'Mobile',
            'email' => 'Email',
            'cnic_number' => 'Cnic Number',
            'b_form' => 'B Form',
            'vaccination' => 'Vaccination',
            'allergies' => 'Allergies',
            'religion' => 'Religion',
            'nationality' => 'Nationality',
            'previous_school' => 'Previous School',
            'seat_number_ninth' => 'Seat Number Ninth',
            'seat_number_tenth' => 'Seat Number Tenth',
            'garde_in_tenth' => 'Garde In Tenth',
            'certificate_number' => 'Certificate Number',
            'other_details' => 'Other Details',
            'progress' => 'Progress',
            'conduct' => 'Conduct',
            'is_private' => 'Is Private',
            'status' => 'Status',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSection()
    {
        return $this->hasOne(StudentClass::className(), ['id' => 'section_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClass()
    {
        return $this->hasOne(StudentClass::className(), ['id' => 'class_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(User::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSchool()
    {
        return $this->hasOne(School::className(), ['id' => 'school_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentAttendances()
    {
        return $this->hasMany(StudentAttendance::className(), ['student_id' => 'id']);
    }
}
