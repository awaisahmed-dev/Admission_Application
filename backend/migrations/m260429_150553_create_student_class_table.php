<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%student_class}}`.
 */
class m260429_150553_create_student_class_table extends Migration
{
    /**
     * {@inheritdoc}
     */
   public function up()
    {
        $this->createTable('student_class', [

            'id'=>$this->primaryKey(),

            'parent_class_id'=>$this->integer()
                ->notNull()
                ->defaultValue(0),

            'title'=>$this->string(25)
                ->notNull()
                ->comment('Class Name'),

            'school_id'=>$this->integer()->notNull(),

            'promote_section_id'=>$this->integer(),

            'staff_id'=>$this->integer()
                ->notNull()
                ->comment('Class Incharge'),

            'annual_registration_fee'=>$this->float()
                ->defaultValue(0),

            'monthly_tution_fee'=>$this->float()
                ->defaultValue(0),

            'annual_exam_fee'=>$this->float()
                ->defaultValue(0),

            'monthly_test_fee'=>$this->float()
                ->defaultValue(0),

            'terminal_exam_fee'=>$this->float()
                ->defaultValue(0),

            'security_fee'=>$this->float()
                ->defaultValue(0),

            'id_card_fee'=>$this->float()
                ->defaultValue(0),

            'details'=>$this->text(),

            'status'=>$this->integer()
                ->notNull()
                ->defaultValue(0),

            'list_order'=>$this->integer()
                ->defaultValue(0),

            'attendance_note'=>$this->integer()
                ->defaultValue(0),

            'created_by'=>$this->integer(),

            'updated_by'=>$this->integer(),

            'created_at'=>$this->integer(),

            'updated_at'=>$this->integer(),

        ]);

        $this->createIndex(
            'idx-student_class-school',
            'student_class',
            'school_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('student_class');
    }
}
