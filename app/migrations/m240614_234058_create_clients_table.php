<?php

declare(strict_types=1);

use yii\db\Migration;

/**
 * Handles the creation of table `{{%clients}}`.
 */
class m240614_234058_create_clients_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%clients}}', [
            'id'         => $this->primaryKey(),
            'first_name' => $this->string(),
            'last_name'  => $this->string(),
            'age'        => $this->integer(),
            'city'       => $this->string(),
            'state'      => $this->string(),
            'zip'        => $this->string(),
            'ssn'        => $this->string()->notNull(),
            'income'     => $this->integer(),
            'fico'       => $this->integer(),
            'email'      => $this->string()->notNull(),
            'phone'      => $this->string(),
        ]);

        $this->createIndex('ind_client_ssn', '{{%clients}}', 'ssn', true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%clients}}');
    }
}
