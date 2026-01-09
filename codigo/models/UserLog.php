<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class UserLog extends ActiveRecord
{
    public static function tableName()
    {
        return 'user_log';
    }

    /**
     * Helper function to save a log entry
     * usage: \app\models\UserLog::add('Login Success');
     */
    public static function add($action)
    {
        $log = new self();
        
        // Check if user is logged in
        if (!Yii::$app->user->isGuest) {
            $log->user_id = Yii::$app->user->id;
            // We use email or username as identifier
            $log->user_identifier = Yii::$app->user->identity->email; 
        } else {
            $log->user_id = null;
            $log->user_identifier = 'Guest';
        }

        $log->action = $action;
        $log->ip_address = Yii::$app->request->userIP;
        $log->user_agent = Yii::$app->request->userAgent;
        $log->created_at = date('Y-m-d H:i:s');

        return $log->save();
    }
}
