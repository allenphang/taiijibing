<?php
/**
 * Created by PhpStorm.
 * User: pengjixiang
 * Date: 17/4/5
 * Time: 下午10:05
 */

namespace backend\models;


use yii\db\ActiveRecord;
use yii;
class CustomSearch extends ActiveRecord
{

    public static  function tableName()
    {
        return "user_info";
    }
    public static function pageQuery($username,$mobile,$province,$city,$area)
    {
        $where='';
        if(!empty($username)){
            $where.=" Name='$username'";
        }
        if(!empty($mobile)){
            if(!empty($where)){
                $where.=" and ";
            }
            $where.="Tel='$mobile' ";
        }
        if(!empty($province)){
            if(!empty($where)){
                $where.=" and ";
            }
            $where.="Province='$province' ";
        }
        if(!empty($city)){
            if(!empty($where)){
                $where.=" and ";
            }
            $where.="City='$city' ";
        }
        if(!empty($area)){
            if(!empty($where)){
                $where.=" and ";
            }
            $where.="Area='$area' ";
        }
        $model = User::findOne(['id' => yii::$app->getUser()->getIdentity()->getId()]);
        $logic_type = $model->getAttribute("logic_type");
        if ($logic_type == 3||$logic_type == 4) {
            //代理商
            $username=$model->getAttribute("username");
            return CustomSearch::pageQueryByname($where,$username);
        }
        return self::findBySql("select * from user_info ".(empty($where)?"":" where ".$where));


    }
    public static function pageQueryByname($where,$loginName)
    {

        $sql ="select user_info.* from user_info
left join (select distinct dev_regist.UserId from dev_regist inner join agent_info where agent_info.`Id`=`dev_regist`.`AgentId` or agent_info.`ParentId`= `dev_regist`.`AgentId` and  agent_info.`LoginName`='$loginName') as temp
on user_info.`Id`=temp.UserId".(empty($where)?"":$where);
            return CustomSearch::findBySql($sql);
    }
    public static function getLatestData(){
        $dayData=self::getDatasBefore(2);
        $weekData=self::getWeekData(21);
        $monthData=self::getMonthData(60);
        return ["date"=>$dayData,"week"=>$weekData,"month"=>$monthData];
    }
    public static function getDatasBefore($dayNum){
        $dayData= self::findBySql("select count(Id) as count,DATE_FORMAT(`RowTime`,'%Y%m%d') as dt from user_info where DATE_SUB(CURDATE(),INTERVAL $dayNum DAY)<=RowTime GROUP BY dt")->asArray()->all();
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
        $weekData=   self::findBySql("select count(Id) as count,DATE_FORMAT(RowTime,'%v') as weeks  from user_info where  DATE_SUB(CURDATE(),INTERVAL $weekNum DAY)<=RowTime GROUP BY weeks")->asArray()->all();
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
        $monthDay= self::findBySql("select count(Id) as count,DATE_FORMAT(RowTime,'%Y%m') as mh  from user_info where DATE_SUB(CURDATE(),INTERVAL $monthNum DAY)<=RowTime GROUP BY mh")->asArray()->all();
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