<?php

namespace app\modules\api\controllers;

use app\modules\api\actions\CreateTicketAction;
use yii\rest\ActiveController;
use app\modules\api\models\Tickets;
use Yii;
use yii\web\ServerErrorHttpException;

class TicketsController extends ActiveController
{
    public $modelClass = Tickets::class;
    public $createScenario = Tickets::SCENARIO_CREATE_TICKET;

    public function actions()
    {
        $actions = parent::actions();
        $actions['create'] = [
            'class' => CreateTicketAction::class,
            'scenario' => Tickets::SCENARIO_CREATE_TICKET
        ];
        return $actions;
    }
}
