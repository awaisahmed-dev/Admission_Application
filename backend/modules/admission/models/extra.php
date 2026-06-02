<?php

namespace backend\modules\admission\models;

use Yii;

/**
 * This is the model class for table "student".
 */
class Student extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'students';
    }

    public function rules()
    {
        return [
            [['parent_id', 'child_id', 'created_at'], 'integer'],
            [['first_name', 'last_name', 'school_name', 'school_class', 'admission_type'], 'string', 'max' => 255],
            [['gender'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'child_id' => 'Child ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'gender' => 'Gender',
            'school_name' => 'School Name',
            'school_class' => 'School Class',
            'admission_type' => 'Admission Type',
            'created_at' => 'Created At',
        ];
    }

    public function getParent()
    {
        return $this->hasOne(ParentModel::class, ['id' => 'parent_id']);
    }

    public function getChild()
    {
        return $this->hasOne(ChildModel::class, ['id' => 'child_id']);
    }
}