<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%policy}}`.
 */
class m260418_121223_create_policy_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
{
    $this->createTable('{{%policy}}', [
        'id' => $this->primaryKey(),

        'parent_id' => $this->integer()->notNull(),

        'excursion_consent' => $this->boolean()->notNull()->defaultValue(0),
        'photo_consent' => $this->boolean()->notNull()->defaultValue(0),
        'data_usage_consent' => $this->boolean()->notNull()->defaultValue(0),
        'fee_agreement' => $this->boolean()->notNull()->defaultValue(0),
        'attendance_fee_agreement' => $this->boolean()->notNull()->defaultValue(0),
        'volunteer_cleaning' => $this->boolean()->notNull()->defaultValue(0),
        'volunteer_snacks' => $this->boolean()->notNull()->defaultValue(0),
        'volunteer_supervision' => $this->boolean()->notNull()->defaultValue(0),
        'volunteer_admin' => $this->boolean()->notNull()->defaultValue(0),
        'volunteer_teaching_quran' => $this->boolean()->notNull()->defaultValue(0),
        'volunteer_teaching_islamic' => $this->boolean()->notNull()->defaultValue(0),
        'volunteer_teaching_urdu' => $this->boolean()->notNull()->defaultValue(0),
        'arrival_on_time' => $this->boolean()->notNull()->defaultValue(0),
        'toilet_responsibility' => $this->boolean()->notNull()->defaultValue(0),
        'dress_code' => $this->boolean()->notNull()->defaultValue(0),
        'after_class_responsibility' => $this->boolean()->notNull()->defaultValue(0),
        'device_policy' => $this->boolean()->notNull()->defaultValue(0),
        'information_correct' => $this->boolean()->notNull()->defaultValue(0),
        'signature_name' => $this->string()->notNull(),
        'signed_date' => $this->date()->notNull(),

        'status' => $this->integer()->notNull()->defaultValue(1),

        'created_by' => $this->integer(),
        'updated_by' => $this->integer(),
        'created_at' => $this->integer(),
        'updated_at' => $this->integer(),
    ]);

    // FK
    $this->addForeignKey(
        'fk_policy_parent',
        '{{%policy}}',
        'parent_id',
        '{{%parent}}',
        'id',
        'CASCADE'
    );
}

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%policy}}');
    }
}
