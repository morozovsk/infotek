<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%subscriptions}}`.
 */
class m251130_152000_create_subscriptions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%subscriptions}}', [
            'id' => $this->primaryKey(),
            'author_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            '{{%idx-subscriptions-author_id}}',
            '{{%subscriptions}}',
            'author_id'
        );

        $this->addForeignKey(
            '{{%fk-subscriptions-author_id}}',
            '{{%subscriptions}}',
            'author_id',
            '{{%authors}}',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            '{{%idx-subscriptions-user_id}}',
            '{{%subscriptions}}',
            'user_id'
        );

        $this->addForeignKey(
            '{{%fk-subscriptions-user_id}}',
            '{{%subscriptions}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            '{{%fk-subscriptions-user_id}}',
            '{{%subscriptions}}'
        );

        $this->dropIndex(
            '{{%idx-subscriptions-user_id}}',
            '{{%subscriptions}}'
        );

        $this->dropForeignKey(
            '{{%fk-subscriptions-author_id}}',
            '{{%subscriptions}}'
        );

        $this->dropIndex(
            '{{%idx-subscriptions-author_id}}',
            '{{%subscriptions}}'
        );

        $this->dropTable('{{%subscriptions}}');
    }
}
