<?php

use yii\db\Migration;

/**
 * Seeds the user table with admin and demo users.
 */
class m251130_151000_seed_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $security = Yii::$app->security;

        $this->insert('{{%user}}', [
            'username' => 'admin',
            'password_hash' => $security->generatePasswordHash('admin'),
            'auth_key' => $security->generateRandomString(),
            'access_token' => '100-token',
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%user}}', [
            'username' => 'demo',
            'password_hash' => $security->generatePasswordHash('demo'),
            'auth_key' => $security->generateRandomString(),
            'access_token' => '101-token',
            'created_at' => time(),
            'updated_at' => time(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%user}}', ['username' => ['admin', 'demo']]);
    }
}
