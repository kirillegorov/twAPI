<?php

namespace app\modules\api\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $login
 * @property string $name
 *
 * @property TicketComments[] $ticketComments
 * @property Tickets[] $tickets
 * @property Tickets[] $tickets0
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['login', 'name'], 'required'],
            [['login', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Login',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[TicketComments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTicketComments()
    {
        return $this->hasMany(TicketComments::class, ['author_id' => 'id']);
    }

    /**
     * Gets query for [[Tickets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTickets()
    {
        return $this->hasMany(Tickets::class, ['creator_id' => 'id']);
    }

    /**
     * Gets query for [[Tickets0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTickets0()
    {
        return $this->hasMany(Tickets::class, ['in_work_user_id' => 'id']);
    }
}
