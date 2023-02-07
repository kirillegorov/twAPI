<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tickets}}`.
 *
 * Содержит внешние ключи на таблицы:
 *
 * - `users`
 *
 */
class m230207_123702_create_tickets_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tickets}}', [
            'id'                => $this->primaryKey(20),
            'creator_id'        => $this->integer(20)->notNull(),
            'in_work_user_id'   => $this->integer(20),
            'title'             => $this->string(255)->notNull(),
            'status'            => $this->string(255)->notNull(),
            'created_at'        => $this->dateTime()
        ]);

        // Индекс для поля creator_id
        $this->createIndex(
            'idx-tickets-creator_id',
            'tickets',
            'creator_id'
        );

        // Индекс для поля in_work_user_id
        $this->createIndex(
            'idx-tickets-in_work_user_id',
            'tickets',
            'in_work_user_id'
        );

        // Индекс для поля status
        $this->createIndex(
            'idx-tickets-status',
            'tickets',
            'status'
        );

        // Добавляем внешние ключи для таблицы `users`
        $this->addForeignKey(
            'fk-tickets-creator_id',
            'tickets',
            'creator_id',
            'users',
            'id',
            'RESTRICT'
        );

        $this->addForeignKey(
            'fk-tickets-in_work_user_id',
            'tickets',
            'in_work_user_id',
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
        $this->dropTable('{{%tickets}}');
    }
}
