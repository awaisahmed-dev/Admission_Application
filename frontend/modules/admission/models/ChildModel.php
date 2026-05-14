<?php

namespace frontend\modules\admission\models;

use Yii;

/**
 * This is the model class for table "child".
 *
 * @property int $id
 * @property int $parent_id
 * @property int $student_enrolment
 * @property string $admission_type
 * @property string $first_name
 * @property string $last_name
 * @property string $date_of_birth
 * @property int $gender
 * @property string $learning_difficulties
 * @property string $allergies
 * @property string $medications
 * @property int $allergy_to_medication
 * @property string $school_name
 * @property string $school_suburb
 * @property string $school_class
 * @property int $status
 * @property int $created_by
 * @property int $updated_by
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Parent $parent
 */
class ChildModel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'child';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['admission_type', 'first_name', 'last_name', 'date_of_birth', 'gender', 'school_name', 'school_suburb', 'school_class'], 'required'],
            [['parent_id', 'student_enrolment', 'gender', 'allergy_to_medication', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['admission_type', 'learning_difficulties', 'allergies', 'medications'], 'string'],
            [['date_of_birth'], 'safe'],
            [['first_name', 'last_name', 'school_name', 'school_suburb', 'school_class'], 'string', 'max' => 255],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => ParentModel::className(), 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'student_enrolment' => 'Student Enrolment',
            'admission_type' => 'Admission Type',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'date_of_birth' => 'Date Of Birth',
            'gender' => 'Gender',
            'learning_difficulties' => 'Learning Difficulties',
            'allergies' => 'Allergies',
            'medications' => 'Medications',
            'allergy_to_medication' => 'Allergy To Medication',
            'school_name' => 'School Name',
            'school_suburb' => 'School Suburb',
            'school_class' => 'School Class',
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
    public function getParent()
    {
        return $this->hasOne(ParentModel::className(), ['id' => 'parent_id']);
    }

    public function behaviors()
{
    return [
        \yii\behaviors\TimestampBehavior::class,
        [
            'class' => \yii\behaviors\BlameableBehavior::class,
            'createdByAttribute' => 'created_by',
            'updatedByAttribute' => 'updated_by',
        ],
    ];
}
}