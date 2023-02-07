<?php

namespace app\modules\api\models;

use Yii;

/**
 * This is the model class for table "tickets".
 *
 * @property int $id
 * @property int $creator_id
 * @property int|null $in_work_user_id
 * @property string $title
 * @property string $status
 * @property string|null $created_at
 *
 * @property Users $creator
 * @property Users $inWorkUser
 * @property TicketComments[] $ticketComments
 */
class Tickets extends \yii\db\ActiveRecord
{

    const SCENARIO_CREATE_TICKET = 'create_ticket';

    public $comment;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tickets';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['creator_id', 'title', 'status'], 'required'],
            ['comment', 'required', 'on' => self::SCENARIO_CREATE_TICKET],
            [['creator_id', 'in_work_user_id'], 'integer'],
            [['created_at'], 'safe'],
            [['title'], 'string', 'max' => 255],

            [['status'], 'in', 'range' => ['new', 'in_work', 'wait_answer', 'closed']],

            [['creator_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['creator_id' => 'id']],
            [['in_work_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['in_work_user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'creator_id' => 'Creator ID',
            'in_work_user_id' => 'In Work User ID',
            'title' => 'Title',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Creator]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreator()
    {
        return $this->hasOne(Users::class, ['id' => 'creator_id']);
    }

    /**
     * Gets query for [[InWorkUser]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInWorkUser()
    {
        return $this->hasOne(Users::class, ['id' => 'in_work_user_id']);
    }


    /**
     * Gets query for [[TicketComments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTicketComments()
    {
        return $this->hasMany(TicketComments::class, ['ticket_id' => 'id']);
    }

    public function beforeSave($insert)
    {
        if ($insert)
            $this->created_at = date('Y-m-d H:i:s');

        return parent::beforeSave($insert);
    }
}
