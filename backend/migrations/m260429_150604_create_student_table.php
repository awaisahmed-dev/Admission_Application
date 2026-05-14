<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%student}}`.
 */
class m260429_150604_create_student_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {

        $this->createTable('student',[

        'id'=>$this->primaryKey(),

        'school_id'=>$this->integer(),

        'parent_id'=>$this->integer(),

        'class_id'=>$this->integer(),

        'section_id'=>$this->integer(),

        'student_key'=>$this->string(25),

        'previous_recored_date'=>$this->date(),

        'full_name'=>$this->string(50)->notNull(),

        'gender'=>$this->string(11),

        'surname'=>$this->string(25),

        'father_name'=>$this->string(50),

        'mother_name'=>$this->string(50),

        'fee_discount'=>$this->float(),

        'date_of_birth'=>$this->date(),

        'native_place'=>$this->string(50),

        'admission_date'=>$this->date(),

        'gr_number'=>$this->string(25),

        'seat_number'=>$this->integer(),

        'admit_in_class'=>$this->string(11),

        'left_in_class'=>$this->string(11),

        'left_date'=>$this->date(),

        'left_reason'=>$this->string(50),

        'address'=>$this->text(),

        'locality'=>$this->string(25),

        'phone'=>$this->string(25),

        'mobile'=>$this->string(25),

        'email'=>$this->string(50),

        'cnic_number'=>$this->string(25),

        'b_form'=>$this->string(25),

        'vaccination'=>$this->string(25),

        'allergies'=>$this->string(50),

        'religion'=>$this->string(25),

        'nationality'=>$this->string(25),

        'previous_school'=>$this->string(50),

        'seat_number_ninth'=>$this->string(25),

        'seat_number_tenth'=>$this->string(25),

        'garde_in_tenth'=>$this->string(11),

        'certificate_number'=>$this->string(11),

        'other_details'=>$this->getDb()
        ->getSchema()
        ->createColumnSchemaBuilder('tinytext'),

        'progress'=>$this->string(50),

        'conduct'=>$this->string(50),

        'is_private'=>$this->integer(),

        'status'=>$this->integer()
        ->defaultValue(1),

        'created_by'=>$this->integer(),

        'updated_by'=>$this->integer(),

        'created_at'=>$this->integer(),

        'updated_at'=>$this->integer(),

        ]);



        $this->createIndex(
        'schoolid',
        'student',
        'school_id'
        );

        $this->createIndex(
        'parentid',
        'student',
        'parent_id'
        );

        $this->createIndex(
        'classid',
        'student',
        'class_id'
        );

        $this->createIndex(
        'section',
        'student',
        'section_id'
        );



        $this->addForeignKey(
        'FK_student',
        'student',
        'section_id',
        'student_class',
        'id',
        'NO ACTION',
        'NO ACTION'
        );


        $this->addForeignKey(
        'FK_student_class',
        'student',
        'class_id',
        'student_class',
        'id',
        'NO ACTION',
        'NO ACTION'
        );


        $this->addForeignKey(
        'FK_student_parent',
        'student',
        'parent_id',
        'user',
        'id',
        'NO ACTION',
        'NO ACTION'
        );


        $this->addForeignKey(
        'FK_student_school',
        'student',
        'school_id',
        'school',
        'id',
        'NO ACTION',
        'NO ACTION'
        );

        
    }

            /**
             * {@inheritdoc}
             */
     public function down()
    {

        $this->dropForeignKey(
        'FK_student',
        'student'
        );

        $this->dropForeignKey(
        'FK_student_class',
        'student'
        );

        $this->dropForeignKey(
        'FK_student_parent',
        'student'
        );

        $this->dropForeignKey(
        'FK_student_school',
        'student'
        );

        $this->dropTable('student');

    }
 }
