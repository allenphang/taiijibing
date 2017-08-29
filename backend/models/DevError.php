<?php
/**
 * Created by PhpStorm.
 * User: pengjixiang
 * Date: 17/5/18
 * Time: 下午6:47
 */

namespace backend\models;


use yii\db\ActiveRecord;

class DevError extends ActiveRecord
{


    public static function tableName()
    {
        return 'msg_notify_dev_error';
    }
    public static function getLatestData(){
        $dayData=self::getDatasBefore(2);
        $weekData=self::getWeekData(21);
        $monthData=self::getMonthData(60);
        return ["date"=>$dayData,"week"=>$weekData,"month"=>$monthData];
    }
    public static function getDatasBefore($dayNum){
        $dayData= self::findBySql("select count(Id) as count,DATE_FORMAT(`RowTime`,'%Y%m%d') as dt from msg_notify_dev_error where DATE_SUB(CURDATE(),INTERVAL $dayNum DAY)<=RowTime GROUP BY dt")->asArray()->all();
        $yesterday=0;
        $beforeYesday=0;
        $dateArr=explode("-",date("Y-m-d"));
        $yNum=intval($dateArr[2])-1;
        $yNumB=intval($dateArr[2])-2;
        foreach($dayData as $val){
            if($val["dt"]=="$dateArr[0]$dateArr[1]$yNum"){
                $yesterday=$val["count"];
            }
            if($val["dt"]=="$dateArr[0]$dateArr[1]$yNumB"){
                $beforeYesday=$val["count"];
            }
        }
        return $yesterday-$beforeYesday;
    }
    public static function getWeekData($weekNum){
        $weeknow=intval(date('W'));
        $week=0;
        $weekBefore=0;
        $weekData=   self::findBySql("select count(Id) as count,DATE_FORMAT(RowTime,'%v') as weeks  from msg_notify_dev_error where  DATE_SUB(CURDATE(),INTERVAL $weekNum DAY)<=RowTime GROUP BY weeks")->asArray()->all();
        foreach($weekData as $val){
            if(intval($val["weeks"])==$weeknow-1){
                $week=intval($val["count"]);
            }
            if(intval($val["weeks"])==$weeknow-2){
                $weekBefore=intval($val["count"]);
            }
        }
        return $week-$weekBefore;

    }
    public static function getMonthData($monthNum){
        $monthNow=intval(date("Ym"));
        $monthDay= self::findBySql("select count(Id) as count,DATE_FORMAT(RowTime,'%Y%m') as mh  from msg_notify_dev_error where DATE_SUB(CURDATE(),INTERVAL $monthNum DAY)<=RowTime GROUP BY mh")->asArray()->all();
        $month=0;
        $monthBefore=0;
        foreach($monthDay as $val){
            if(intval($val["mh"])==$monthNow-1){
                $month=intval($val["count"]);
            }
            if(intval($val["mh"])==$monthNow-2){
                $monthBefore=intval($val["count"]);
            }
        }
        return $month-$monthBefore;
    }


}