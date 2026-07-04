<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

class Notification extends ActiveRecord
{
    public static function tableName()
    {
        return 'notification';
    }

    public function rules()
    {
        return [
            [['title', 'contents', 'status'], 'required'],

            [[
                'school_id',
                'parent_id',
                'status',
                'created_by',
                'updated_by',
                'created_at',
                'updated_at'
            ], 'integer'],

            [['contents', 'api_response'], 'string'],

            [['parent_type', 'type', 'medium', 'to_number'], 'string', 'max' => 25],

            [['from_text'], 'string', 'max' => 35],

            [['title'], 'string', 'max' => 500],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'school_id' => 'School',
            'parent_id' => 'Parent',
            'parent_type' => 'Parent Type',
            'type' => 'Type',
            'medium' => 'Medium',
            'to_number' => 'To Number',
            'from_text' => 'From',
            'title' => 'Title',
            'contents' => 'Contents',
            'status' => 'Status',
            'api_response' => 'API Response',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,

            [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
                'defaultValue' => null,
            ],
        ];
    }
}