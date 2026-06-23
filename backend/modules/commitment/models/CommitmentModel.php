<?php

namespace backend\modules\commitment\models;

use Yii;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use backend\modules\admission\models\ParentModel;

/**
 * This is the model class for table "commitment".
 *
 * @property int $id
 * @property int $parent_id
 * @property string $amount
 * @property string $payment_plan
 * @property string $date
 * @property string $due_date
 * @property string $details
 * @property int $status
 * @property int $created_by
 * @property int $updated_by
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Parent $parent
 */
class CommitmentModel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'commitment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'amount'], 'required'],
            [['parent_id', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['amount'], 'number'],
            [['payment_plan', 'details'], 'string'],
            [['date', 'due_date'], 'safe'],
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
            'amount' => 'Amount',
            'payment_plan' => 'Payment Plan',
            'date' => 'Date',
            'due_date' => 'Due Date',
            'details' => 'Details',
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

            TimestampBehavior::className(),

            BlameableBehavior::className(),

        ];
    }
}
