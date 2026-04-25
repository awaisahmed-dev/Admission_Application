<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%students}}`.
 */
class m260425_110335_create_students_table extends Migration
{
    /**
     * {@inheritdoc}
     */
     public function up()
    {
    $this->createTable('students', [
    'id' => $this->primaryKey(),
    'parent_id' => $this->integer(),
    'child_id' => $this->integer(),

    'first_name' => $this->string(),
    'last_name' => $this->string(),
    'gender' => $this->integer(),
    'date_of_birth' => $this->date(),

    'school_name' => $this->string(),
    'school_class' => $this->string(),

    'admission_type' => $this->string(),

    'status' => $this->smallInteger()->defaultValue(1),

    'created_at' => $this->integer(),
]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%students}}');
    }
}
