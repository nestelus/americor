<?php

declare(strict_types=1);

use yii\db\Migration;

/**
 * Handles the creation of table `{{%loans}}`.
 */
class m240616_155040_create_loans_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%loans}}', [
            'id'        => $this->primaryKey(),
            'title'     => $this->string()->notNull(),
            'term'      => $this->integer(),
            'rate'      => $this->float(2),
            'number'    => $this->string()->notNull(),
            'amount'    => $this->float(2),
            'status'    => $this->boolean()->defaultValue(false),
            'client_id' => $this->integer()->notNull(),
        ]);
        $this->addForeignKey('fk_loans_client_id', '{{%loans}}', 'client_id', '{{%clients}}', 'id', 'restrict');
        $this->createIndex('ind_loans_number', '{{%loans}}', 'number', true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%loans}}');
    }
}
