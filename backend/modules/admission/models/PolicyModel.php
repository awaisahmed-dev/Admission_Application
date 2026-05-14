<?php

namespace backend\modules\admission\models;

use Yii;

/**
 * This is the model class for table "policy".
 *
 * @property int $id
 * @property int $parent_id
 * @property int $excursion_consent
 * @property int $photo_consent
 * @property int $data_usage_consent
 * @property int $fee_agreement
 * @property int $attendance_fee_agreement
 * @property int $volunteer_cleaning
 * @property int $volunteer_snacks
 * @property int $volunteer_supervision
 * @property int $volunteer_admin
 * @property int $volunteer_teaching_quran
 * @property int $volunteer_teaching_islamic
 * @property int $volunteer_teaching_urdu
 * @property int $arrival_on_time
 * @property int $toilet_responsibility
 * @property int $dress_code
 * @property int $after_class_responsibility
 * @property int $device_policy
 * @property int $information_correct
 * @property string $signature_name
 * @property string $signed_date
 * @property int $status
 * @property int $created_by
 * @property int $updated_by
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Parent $parent
 */
class PolicyModel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'policy';
    }

    /**
     * {@inheritdoc}
     */
    // public function rules()
    // {
    //     return [
    //         [['signature_name', 'signed_date'], 'required'],
    //         [['parent_id', 'excursion_consent', 'photo_consent', 'data_usage_consent', 'fee_agreement', 'attendance_fee_agreement', 'volunteer_cleaning', 'volunteer_snacks', 'volunteer_supervision', 'volunteer_admin', 'volunteer_teaching_quran', 'volunteer_teaching_islamic', 'volunteer_teaching_urdu', 'arrival_on_time', 'toilet_responsibility', 'dress_code', 'after_class_responsibility', 'device_policy', 'information_correct', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
    //         [['signed_date'], 'safe'],
    //         [['signature_name'], 'string', 'max' => 255],
    //         [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => ParentModel::className(), 'targetAttribute' => ['parent_id' => 'id']],
    //         [
    //         [
    //          'volunteer_cleaning',
    //          'volunteer_snacks',
    //          'volunteer_supervision',
    //          'volunteer_admin',
    //          'volunteer_teaching_quran',
    //          'volunteer_teaching_islamic',
    //          'volunteer_teaching_urdu'
    //         ],
    //         'validateVolunteer'
    //     ],
    //     ];
    // }

    public function rules()
{
    return [

        [
            [
                'excursion_consent',
                'photo_consent',
                'data_usage_consent',
                'fee_agreement',
                'attendance_fee_agreement',
                'arrival_on_time',
                'toilet_responsibility',
                'dress_code',
                'after_class_responsibility',
                'device_policy',
                'information_correct',
                'signature_name',
                'signed_date'
            ],
            'required'
        ],

        [[
            'parent_id',
            'excursion_consent',
            'photo_consent',
            'data_usage_consent',
            'fee_agreement',
            'attendance_fee_agreement',
            'volunteer_cleaning',
            'volunteer_snacks',
            'volunteer_supervision',
            'volunteer_admin',
            'volunteer_teaching_quran',
            'volunteer_teaching_islamic',
            'volunteer_teaching_urdu',
            'arrival_on_time',
            'toilet_responsibility',
            'dress_code',
            'after_class_responsibility',
            'device_policy',
            'information_correct'
        ], 'integer'],

        [['signed_date'],'safe'],

        [['signature_name'],'string','max'=>255],

        [
            [
                'volunteer_cleaning',
                'volunteer_snacks',
                'volunteer_supervision',
                'volunteer_admin',
                'volunteer_teaching_quran',
                'volunteer_teaching_islamic',
                'volunteer_teaching_urdu'
            ],
            'validateVolunteer'
        ],
    ];
}


public function validateVolunteer($attribute,$params)
{
    if(
        !$this->volunteer_cleaning &&
        !$this->volunteer_snacks &&
        !$this->volunteer_supervision &&
        !$this->volunteer_admin &&
        !$this->volunteer_teaching_quran &&
        !$this->volunteer_teaching_islamic &&
        !$this->volunteer_teaching_urdu
    ){
        $this->addError(
            'volunteer_cleaning',
            'At least one volunteer option must be selected.'
        );
    }
}


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'excursion_consent' => 'Excursion Consent',
            'photo_consent' => 'Photo Consent',
            'data_usage_consent' => 'Data Usage Consent',
            'fee_agreement' => 'Fee Agreement',
            'attendance_fee_agreement' => 'Attendance Fee Agreement',
            'volunteer_cleaning' => 'Volunteer Cleaning',
            'volunteer_snacks' => 'Volunteer Snacks',
            'volunteer_supervision' => 'Volunteer Supervision',
            'volunteer_admin' => 'Volunteer Admin',
            'volunteer_teaching_quran' => 'Volunteer Teaching Quran',
            'volunteer_teaching_islamic' => 'Volunteer Teaching Islamic',
            'volunteer_teaching_urdu' => 'Volunteer Teaching Urdu',
            'arrival_on_time' => 'Arrival On Time',
            'toilet_responsibility' => 'Toilet Responsibility',
            'dress_code' => 'Dress Code',
            'after_class_responsibility' => 'After Class Responsibility',
            'device_policy' => 'Device Policy',
            'information_correct' => 'Information Correct',
            'signature_name' => 'Signature Name',
            'signed_date' => 'Signed Date',
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
public function init()
{
parent::init();

if($this->isNewRecord){

$this->excursion_consent=1;
$this->photo_consent=1;
$this->data_usage_consent=1;
$this->fee_agreement=1;
$this->attendance_fee_agreement=1;

$this->arrival_on_time=1;
$this->toilet_responsibility=1;
$this->dress_code=1;
$this->after_class_responsibility=1;
$this->device_policy=1;

$this->information_correct=1;

$this->signed_date=date('Y-m-d');

}
}
}
