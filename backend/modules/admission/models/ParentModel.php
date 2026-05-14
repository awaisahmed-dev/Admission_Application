<?php

namespace backend\modules\admission\models;

use Yii;

/**
 * This is the model class for table "parent".
 *
 * @property int $id
 * @property string $father_title
 * @property string $father_first_name
 * @property string $father_last_name
 * @property string $father_mobile
 * @property string $father_email
 * @property string $mother_title
 * @property string $mother_first_name
 * @property string $mother_last_name
 * @property string $mother_mobile
 * @property string $mother_email
 * @property string $address
 * @property string $home_phone
 * @property string $emergency_contact_name
 * @property string $emergency_contact_number
 * @property string $emergency_relationship
 * @property int $status
 * @property int $created_by
 * @property int $updated_by
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Child[] $children
 * @property Policy[] $policies
 */
class ParentModel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'parent';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // [['father_first_name', 'father_last_name', 'father_mobile', 'address', 'emergency_contact_name', 'emergency_contact_number', 'emergency_relationship'], 'required'],
            [
            [
                'father_title',
                'father_first_name',
                'father_last_name',
                'father_mobile',
                'father_email'
            ],
            'required'
            ],
            [
            [
                'mother_title',
                'mother_first_name',
                'mother_last_name',
                'mother_mobile',
                'mother_email'
            ],
            'required'
            ],
            [
            [
                'address',
                'emergency_contact_name',
                'emergency_contact_number',
                'emergency_relationship'
            ],
            'required'
            ],
            [['address'], 'string'],
            [['status', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['father_title', 'father_first_name', 'father_last_name', 'father_mobile', 'father_email', 'mother_title', 'mother_first_name', 'mother_last_name', 'mother_mobile', 'mother_email', 'home_phone', 'emergency_contact_name', 'emergency_contact_number', 'emergency_relationship'], 'string', 'max' => 255],
            ['status', 'default', 'value' => 0],
            [
            [
                'father_mobile',
                'mother_mobile',
                'home_phone',
                'emergency_contact_number'
            ],
            'match',
            'pattern'=>'/^[0-9]+$/',
            'message'=>'Numbers only allowed'
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'father_title' => 'Father Title',
            'father_first_name' => 'Father First Name',
            'father_last_name' => 'Father Last Name',
            'father_mobile' => 'Father Mobile',
            'father_email' => 'Father Email',
            'mother_title' => 'Mother Title',
            'mother_first_name' => 'Mother First Name',
            'mother_last_name' => 'Mother Last Name',
            'mother_mobile' => 'Mother Mobile',
            'mother_email' => 'Mother Email',
            'address' => 'Address',
            'home_phone' => 'Home Phone',
            'emergency_contact_name' => 'Emergency Contact Name',
            'emergency_contact_number' => 'Emergency Contact Number',
            'emergency_relationship' => 'Emergency Relationship',
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
    public function getChildren()
    {
        return $this->hasMany(ChildModel::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPolicies()
    {
        return $this->hasMany(PolicyModel::className(), ['parent_id' => 'id']);
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
        $this->father_title='Mr';
        $this->mother_title='Mrs';
    }
}
}
