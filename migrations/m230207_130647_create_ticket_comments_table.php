<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%ticket_comments}}`.
 */
class m230207_130647_create_ticket_comments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('ticket_comments', [
            'id'            => $this->primaryKey(20),
            'ticket_id'     => $this->integer(20)->notNull(),
            'author_id'     => $this->integer(20)->notNull(),
            'comment'       => $this->text(),
            'created_at'    => $this->dateTime()
        ]);

        // Индекс для поля ticket_id
        $this->createIndex(
            'idx-ticket_comments-ticket_id',
            'ticket_comments',
            'ticket_id'
        );

        // Индекс для поля author_id
        $this->createIndex(
            'idx-ticket_comments-author_id',
            'ticket_comments',
            'author_id'
        );

        // Добавляем внешние ключи для таблицы `tickets`
        $this->addForeignKey(
            'fk-ticket_comments-ticket_id',
            'ticket_comments',
            'ticket_id',
            'tickets',
            'id',
            'RESTRICT'
        );

        // Добавляем внешние ключи для таблицы `users`
        $this->addForeignKey(
            'fk-ticket_comments-author_id',
            'ticket_comments',
            'author_id',
            'users',
            'id',
            'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%ticket_comments}}');
    }
}
