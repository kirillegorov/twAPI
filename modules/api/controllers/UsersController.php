<?php

namespace app\modules\api\controllers;

use yii\rest\ActiveController;
use app\modules\api\models\Users;

class UsersController extends ActiveController
{
    public $modelClass = Users::class;
}
