<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%parent}}`.
 */
class m260418_121158_create_parent_table extends Migration
{
    /**
     * {@inheritdoc}
     */
   public function up()
{
    $this->createTable('{{%parent}}', [
        'id' => $this->primaryKey(),

        // Father Info
        'father_title' => $this->string(),
        'father_first_name' => $this->string()->notNull(),
        'father_last_name' => $this->string()->notNull(),
        'father_mobile' => $this->string()->notNull(),
        'father_email' => $this->string(),

        // Mother Info
        'mother_title' => $this->string(),
        'mother_first_name' => $this->string(),
        'mother_last_name' => $this->string(),
        'mother_mobile' => $this->string(),
        'mother_email' => $this->string(),

        // Address
        'address' => $this->text()->notNull(),
        'home_phone' => $this->string(),

        // Emergency
        'emergency_contact_name' => $this->string()->notNull(),
        'emergency_contact_number' => $this->string()->notNull(),
        'emergency_relationship' => $this->string()->notNull(),

        // Status
        'status' => $this->integer()->notNull()->defaultValue(0),

        // Audit Fields
        'created_by' => $this->integer(),
        'updated_by' => $this->integer(),
        'created_at' => $this->integer(),
        'updated_at' => $this->integer(),
    ]);
}

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%parent}}');
    }
}
