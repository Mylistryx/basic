<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%identity}}`.
 */
class m210325_163501_create_identity_table extends Migration
{
    private string $table = '{{%identity}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(
            $this->table,
            [
                'id'                       => $this->primaryKey(),
                'email'                    => $this->string()->notNull()->unique(),
                'auth_key'                 => $this->string()->notNull()->unique(),
                'password_hash'            => $this->string()->notNull(),
                'current_status'           => $this->smallInteger()->notNull()->defaultValue(10),
                'access_token'             => $this->string()->null()->unique(),
                'password_reset_token'     => $this->string()->null()->unique(),
                'email_confirmation_token' => $this->string()->null()->unique(),
                'created_at'               => $this->integer()->notNull(),
                'updated_at'               => $this->integer()->notNull(),
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->table);
    }
}
