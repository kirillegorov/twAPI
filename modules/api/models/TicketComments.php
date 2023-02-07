<?php

namespace app\modules\api\models;

use Yii;

/**
 * This is the model class for table "ticket_comments".
 *
 * @property int $id
 * @property int $ticket_id
 * @property int $author_id
 * @property string|null $comment
 * @property string|null $created_at
 *
 * @property Users $author
 * @property Tickets $ticket
 */
class TicketComments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ticket_comments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ticket_id', 'author_id'], 'required'],
            [['ticket_id', 'author_id'], 'integer'],
            [['comment'], 'string'],
            [['created_at'], 'safe'],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['author_id' => 'id']],
            [['ticket_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tickets::class, 'targetAttribute' => ['ticket_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ticket_id' => 'Ticket ID',
            'author_id' => 'Author ID',
            'comment' => 'Comment',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Author]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Users::class, ['id' => 'author_id']);
    }

    /**
     * Gets query for [[Ticket]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTicket()
    {
        return $this->hasOne(Tickets::class, ['id' => 'ticket_id']);
    }

    public function beforeSave($insert)
    {
        if ($insert)
            $this->created_at = date('Y-m-d H:i:s');

        return parent::beforeSave($insert);
    }
}
