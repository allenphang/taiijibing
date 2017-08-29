<?php
/**
 * Created by PhpStorm.
 * User: pengjixiang
 * Date: 17/4/5
 * Time: 下午6:21
 */

namespace backend\models;


use yii\db\ActiveRecord;

class DevActiveLog extends ActiveRecord
{

    public static function tableName()
    {
        return 'dev_active_log';
    }
    /**
     *硬件日激活量
     * @inheritdoc
     */
    public static function findDayActiveNum()
    {
       $now= date("Y-m-d");
        $starttime=$now."00:00:00";
        $endtime=$now."23:59:59";
        return static::findBySql("select * from dev_active_log where RowTime>'".$starttime."' and RowTime<'".$endtime."'")->asArray()->count();

    }

    /**
     * 总激活数量
     */
    public static function allActiveNum(){
        return static::findBySql("select * from dev_active_log")->asArray()->count();
    }
}