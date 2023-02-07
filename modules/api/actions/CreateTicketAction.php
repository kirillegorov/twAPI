<?php

namespace app\modules\api\actions;

use Yii;
use app\modules\api\models\Tickets;
use app\modules\api\models\TicketComments;
use yii\web\ServerErrorHttpException;

class CreateTicketAction extends \yii\rest\Action
{

    public $modelClass = Tickets::class;
    public $scenario;

    public function run()
    {
        $response = Yii::$app->response;
        $params = Yii::$app->getRequest()->getBodyParams();

        $ticket = new Tickets();
        $ticket->scenario = $this->scenario;
        $ticket->setAttributes($params);

        $comment = new TicketComments();

        $transaction = Yii::$app->db->beginTransaction();

        if ($ticket->save()) {

            $comment->ticket_id = $ticket->id;
            $comment->author_id = $ticket->creator_id;
            $comment->comment   = $ticket->comment;

            if ($comment->save()) {
                $transaction->commit();
                $response->setStatusCode(200);
                return ['id' => $ticket->id];
            }

        }

        $transaction->rollBack();

        if ($ticket->errors || $comment->errors) {
            $response->setStatusCode(422);
            return ['errors' => array_merge($ticket->errors, $comment->errors)];
        }
        throw new ServerErrorHttpException('Не удалось создать по неизвестным причинам');
    }
}