<?php

namespace backend\modules\admission\models;

use Yii;

class Student extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'student';
    }

    public function rules()
    {
        return [

            [['school_id','parent_id','class_id',
            'section_id','seat_number',
            'is_private','status',
            'created_by','updated_by',
            'created_at','updated_at'
            ],'integer'],

            [['previous_recored_date',
            'date_of_birth',
            'admission_date',
            'left_date'
            ],'safe'],

            [['full_name'],'required'],

            [['fee_discount'],'number'],

            [['address','other_details'],'string'],

            [['student_key','surname',
            'gr_number','locality',
            'phone','mobile',
            'cnic_number','b_form',
            'vaccination',
            'religion',
            'nationality',
            'seat_number_ninth',
            'seat_number_tenth'
            ],'string','max'=>25],

            [['full_name',
            'father_name',
            'mother_name',
            'native_place',
            'left_reason',
            'email',
            'allergies',
            'previous_school',
            'progress',
            'conduct'
            ],'string','max'=>50],

            [['gender',
            'admit_in_class',
            'left_in_class',
            'garde_in_tenth',
            'certificate_number'
            ],'string','max'=>11]

        ];
    }

    public function behaviors()
    {
        return [

            \yii\behaviors\TimestampBehavior::class,

            [
                'class'=>\yii\behaviors\BlameableBehavior::class,
                'createdByAttribute'=>'created_by',
                'updatedByAttribute'=>'updated_by',
            ]

        ];
        // die('Student.php');
    }

    public function getParentUser()
    {
        return $this->hasOne(
            \common\models\User::class,
            ['id' => 'parent_id']
        );
    }

    public function getParentProfile()
    {
        return $this->hasOne(
            \common\models\UserProfile::class,
            ['user_id' => 'parent_id']
        );
    }
    
}