<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%book_authors}}`.
 */
class m251128_131601_create_book_authors_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%book_authors}}', [
            'id' => $this->primaryKey(),
            'book_id' => $this->integer()->notNull(),
            'author_id' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            '{{%idx-book_authors-book_id}}',
            '{{%book_authors}}',
            'book_id'
        );

        $this->addForeignKey(
            '{{%fk-book_authors-book_id}}',
            '{{%book_authors}}',
            'book_id',
            '{{%books}}',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            '{{%idx-book_authors-author_id}}',
            '{{%book_authors}}',
            'author_id'
        );

        $this->addForeignKey(
            '{{%fk-book_authors-author_id}}',
            '{{%book_authors}}',
            'author_id',
            '{{%authors}}',
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
            '{{%fk-book_authors-book_id}}',
            '{{%book_authors}}'
        );

        $this->dropIndex(
            '{{%idx-book_authors-book_id}}',
            '{{%book_authors}}'
        );

        $this->dropForeignKey(
            '{{%fk-book_authors-author_id}}',
            '{{%book_authors}}'
        );

        $this->dropIndex(
            '{{%idx-book_authors-author_id}}',
            '{{%book_authors}}'
        );

        $this->dropTable('{{%book_authors}}');
    }
}
