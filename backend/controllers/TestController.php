<?php
/**
 * Created by PhpStorm.
 * User: pengjixiang
 * Date: 17/4/5
 * Time: 下午6:36
 */

namespace backend\controllers;


use backend\models\DevActiveLog;
use yii;

class TestController extends  BaseController
{
    public function actionTest(){
//        $tablename=DevActiveLog::tableName();
        $res=DevActiveLog::findDayActiveNum();
        Yii::$app->response->content = json_encode($res);

    }
}