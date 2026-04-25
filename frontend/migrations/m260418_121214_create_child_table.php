<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%child}}`.
 */
class m260418_121214_create_child_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
{
    $this->createTable('{{%child}}', [
        'id' => $this->primaryKey(),

        'parent_id' => $this->integer()->notNull(),

        // Admission
        'student_enrolment' => $this->boolean()->notNull()->defaultValue(0),
        'admission_type' => "ENUM('new','returning') NOT NULL",

        // Basic Info
        'first_name' => $this->string()->notNull(),
        'last_name' => $this->string()->notNull(),
        'date_of_birth' => $this->date()->notNull(),

        'gender' => $this->integer()->notNull(), // 1=Male,2=Female

        // Medical
        'learning_difficulties' => $this->text(),
        'allergies' => $this->text(),
        'medications' => $this->text(),
        'allergy_to_medication' => $this->boolean()->notNull()->defaultValue(0),

        // School Info
        'school_name' => $this->string()->notNull(),
        'school_suburb' => $this->string()->notNull(),
        'school_class' => $this->string()->notNull(),

        // Status
        'status' => $this->integer()->notNull()->defaultValue(1),

        // Audit
        'created_by' => $this->integer(),
        'updated_by' => $this->integer(),
        'created_at' => $this->integer(),
        'updated_at' => $this->integer(),
    ]);

    // FK
    $this->addForeignKey(
        'fk_child_parent',
        '{{%child}}',
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
        $this->dropTable('{{%child}}');
    }
}
