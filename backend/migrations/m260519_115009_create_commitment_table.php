<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%commitment}}`.
 */
class m260519_115009_create_commitment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
{
    $this->createTable('commitment', [

        'id' => $this->primaryKey(),

        'parent_id' => $this->integer()->notNull(),

        'amount' => $this->decimal(10,2)->notNull(),

        'payment_plan' => $this->text(),

        'date' => $this->date(),

        'due_date' => $this->date(),

        'details' => $this->text(),

        'status' => $this->smallInteger()->defaultValue(1),

        'created_by' => $this->integer(),
        'updated_by' => $this->integer(),
        'created_at' => $this->integer(),
        'updated_at' => $this->integer(),

    ]);

    $this->addForeignKey(
        'fk_commitment_parent',
        'commitment',
        'parent_id',
        'parent',
        'id',
        'CASCADE'
    );
}

    /**
     * {@inheritdoc}
     */
    public function down()
{
    $this->dropForeignKey(
        'fk_commitment_parent',
        'commitment'
    );

    $this->dropTable('commitment');
}
}
