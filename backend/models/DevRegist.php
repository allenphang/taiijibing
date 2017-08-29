<?php
/**
 * Created by PhpStorm.
 * User: pengjixiang
 * Date: 17/4/6
 * Time: 下午5:59
 */

namespace backend\models;


use yii\db\ActiveRecord;
use yii;
use backend\models\User;

class DevRegist extends ActiveRecord
{
    public static function tableName()
    {
        return 'dev_regist';
    }

    /**
     * 设备列表分页查询
     */
    public static function pageQuery($offset = 0, $limit = 0,$devno,$xname,$sname,$mobile,$devf,$tel,$province,$city,$area)
    {
        $model = User::findOne(['id'=>yii::$app->getUser()->getIdentity()->getId()]);
        $logic_type=$model->getAttribute("logic_type");
        $where ="";

        if(!empty($devno)){
            $where.=" dev_regist.DevNo='$devno'";
        }
        if(!empty($xname)){
            //县区
            if(!empty($where)){
                $where.=" and ";
            }
            $where.=" agent_info.Level=4 and agent_info.LoginName='$xname'";
        }
        if(!empty($sname)){
            //社区
            if(!empty($where)){
                $where.=" and ";
            }
            $where.=" agent_info.Level=5 and agent_info.LoginName='$sname'";

        }
        if(!empty($mobile)){
            //设备手机号
            if(!empty($where)){
                $where.=" and ";
            }
            $where.=" dev_regist.DevBindMobile='$mobile'";
        }
        if(!empty($devf)){
            //设备手机号
            if(!empty($where)){
                $where.=" and ";
            }
            $where.=" dev_regist.DevFactory='$devf'";
        }
        if(!empty($tel)){
            //设备手机号
            if(!empty($where)){
                $where.=" and ";
            }
            $where.=" user_info.Tel='$tel'";
        }
        if(!empty($province)){
            //设备手机号
            if(!empty($where)){
                $where.=" and ";
            }
            $where.=" user_info.Province='$province'";
        }
        if(!empty($city)){
            //设备手机号
            if(!empty($where)){
                $where.=" and ";
            }
            $where.=" user_info.City='$city'";
        }
        if(!empty($area)){
            //设备手机号
            if(!empty($where)){
                $where.=" and ";
            }
            $where.=" user_info.Area='$area'";
        }
        if($logic_type==3||$logic_type==4){
            //代理商
            $username=$model->getAttribute("username");
            return DevRegist::pageQueryByName($offset,$limit,$username,$where);
        }
        $url="select user_info.Tel,  dev_regist.DevNo,dev_regist.AgentId,dev_regist.`DevBindMobile`,dev_regist.DevFactory,
`dev_active`.`Date`,
`dev_location`.`Lat`,dev_location.`Lng`,dev_location.`Address` ,dev_location.`BaiDuLat`,dev_location.`BaiDuLng`,
dev_cmd_tb.`Cmd`,dev_cmd_tb.`RowTime`,
`agent_info`.Name
 from dev_regist
 left join `dev_active` on dev_regist.`DevNo`=dev_active.`DevNo`
 left join `dev_location` on dev_regist.`DevNo`=dev_location.`DevNo`
 left join agent_info on agent_info.`Id`=dev_regist.`AgentId`
 left join user_info on dev_regist.UserId=user_info.`Id`
 left join 	(select * from dev_cmd ) as dev_cmd_tb on dev_regist.`DevNo`=dev_cmd_tb.`DevNo` ".(empty($where)?"":" where $where")." group by dev_regist.`DevNo` order by dev_cmd_tb.`RowTime` desc   limit $offset , $limit ";
        return static::findBySql($url);
    }

    /**
     * 设备列表分页查询
     */
    public static function pageQueryByName($offset = 0, $limit = 0,$username,$where)
    {
        return static::findBySql("select user_info.Tel, dev_regist.DevNo,dev_regist.AgentId,dev_regist.`DevBindMobile`,dev_regist.DevFactory,
`dev_active`.`Date`,
`dev_location`.`Lat`,dev_location.`Lng`,dev_location.`Address` ,
`dev_cmd_tb`.`Cmd`,dev_cmd_tb.`RowTime`,
`agent_info`.Name
 from dev_regist
 left join `dev_active` on dev_regist.`DevNo`=dev_active.`DevNo`
 left join `dev_location` on dev_regist.`DevNo`=dev_location.`DevNo`
 left join agent_info on agent_info.`Id`=dev_regist.`AgentId` or  agent_info.`ParentId`=dev_regist.`AgentId`
left join user_info on dev_regist.UserId=user_info.`Id`
 left join 	(select * from dev_cmd) as dev_cmd_tb on dev_regist.`DevNo`=dev_cmd_tb.`DevNo`
  where ".(empty($where)?"":$where." and ")." agent_info.LoginName='$username' group by dev_regist.`DevNo` order by dev_cmd_tb.`RowTime` desc limit $offset , $limit");
    }
    public static function allQuery($devno,$xname,$sname,$mobile,$devf,$tel,$province,$city,$area)
    {
        $model = User::findOne(['id'=>yii::$app->getUser()->getIdentity()->getId()]);
        $logic_type=$model->getAttribute("logic_type");
        $where ="";

        if(!empty($devno)){
            $where.=" dev_regist.DevNo='$devno'";
        }
        if(!empty($xname)){
            //县区
            if(!empty($where)){
                $where.=" and ";
            }
            $where.=" agent_info.Level=4 and agent_info.LoginName='$xname'";
        }
        if(!empty($sname)){
            //社区
            if(!empty($where)){
                $where.=" and ";
            }
            $where.=" agent_info.Level=5 and agent_info.LoginName='$sname'";

        }
        if(!empty($mobile)){
            //设备手机号
            if(!empty($where)){
                $where.=" and ";
            }
            $where.=" dev_regist.DevBindMobile='$mobile'";
        }
        if(!empty($devf)){
            //设备手机号
            if(!empty($where)){
                $where.=" and ";
            }
            $where.=" dev_regist.DevFactory='$devf'";
        }
        if(!empty($tel)){
            //设备手机号
            if(!empty($where)){
                $where.=" and ";
            }
            $where.=" user_info.Tel='$tel'";
        }
        if(!empty($province)){
            //设备手机号
            if(!empty($where)){
                $where.=" and ";
            }
            $where.=" user_info.Province='$province'";
        }
        if(!empty($city)){
            //设备手机号
            if(!empty($where)){
                $where.=" and ";
            }
            $where.=" user_info.City='$city'";
        }
        if(!empty($area)){
            //设备手机号
            if(!empty($where)){
                $where.=" and ";
            }
            $where.=" user_info.Area='$area'";
        }
        if($logic_type==3||$logic_type==4){
            //代理商
            $username=$model->getAttribute("username");
            return DevRegist::allQueryByName($username,$where);
        }
            $sql="select user_info.Tel, dev_regist.DevNo,dev_regist.`DevBindMobile`,dev_regist.DevFactory,
`dev_active`.`Date`,
`dev_location`.`Lat`,dev_location.`Lng`,dev_location.`Address` ,
`dev_cmd_tb`.`Cmd`,dev_cmd_tb.`RowTime`,
`agent_info`.Name
 from dev_regist
 left join `dev_active` on dev_regist.`DevNo`=dev_active.`DevNo`
 left join `dev_location` on dev_regist.`DevNo`=dev_location.`DevNo`
 left join agent_info on agent_info.`Id`=dev_regist.`AgentId`
  left join user_info on dev_regist.UserId=user_info.`Id`
 left join 	(select * from dev_cmd order by dev_cmd.`RowTime` desc) as dev_cmd_tb on dev_regist.`DevNo`=dev_cmd_tb.`DevNo` ".(empty($where)?"":"where $where")." group by dev_regist.`DevNo`";
        return static::findBySql($sql);
    }

    public static function allQueryByName($username,$where)
    {


        return static::findBySql("select dev_regist.DevNo,dev_regist.`DevBindMobile`,dev_regist.DevFactory,
`dev_active`.`Date`,
`dev_location`.`Lat`,dev_location.`Lng`,dev_location.`Address` ,
`dev_cmd_tb`.`Cmd`,dev_cmd_tb.`RowTime`,
`agent_info`.Name
 from dev_regist
 left join `dev_active` on dev_regist.`DevNo`=dev_active.`DevNo`
 left join `dev_location` on dev_regist.`DevNo`=dev_location.`DevNo`
   left join user_info on dev_regist.UserId=user_info.`Id`
 left join agent_info on agent_info.`Id`=dev_regist.`AgentId` or  agent_info.`ParentId`=dev_regist.`AgentId`
 left join 	(select * from dev_cmd order by dev_cmd.`RowTime` desc) as dev_cmd_tb on dev_regist.`DevNo`=dev_cmd_tb.`DevNo`
  where agent_info.LoginName='$username' and $where group by dev_regist.`DevNo`");

    }






    public static function dynamicAllQuery($tel,$devno,$province,$city,$area){
        $model = User::findOne(['id'=>yii::$app->getUser()->getIdentity()->getId()]);
        $logic_type=$model->getAttribute("logic_type");
        $where="";
        if(!empty($tel)){
            $where.="dev_regist.`DevBindMobile` like '%$tel'";
        }
        if(!empty($devno)){
            if(!empty($where)){
                $where.=" and ";
            }
            $where.="dev_regist.DevNo='$devno'";
        }
        if(!empty($province)){
            if(!empty($where)){
                $where.=" and ";
            }
            $where.="dev_regist.Province='$province'";
        }
        if(!empty($city)){
            if(!empty($where)){
                $where.=" and ";
            }
            $where.="dev_regist.City='$city'";
        }
        if(!empty($area)){
            if(!empty($where)){
                $where.=" and ";
            }
            $where.="dev_regist.Area='$area'";
        }
        if ($logic_type == 3||$logic_type == 4) {
            //代理商
            $username=$model->getAttribute("username");
            return DevRegist::dynamicAllQueryWithName($where,$username);
        }

        $sql="select user_info.Tel, dev_regist.Province,dev_regist.City,dev_regist.Area, dev_action_log.*,dev_location.`Address`,dev_location.`Lat`,dev_location.`Lng` from dev_action_log
                    left join dev_location on dev_action_log.`DevNo`=dev_location.`DevNo`
                    left join dev_regist on dev_regist.DevNo=dev_action_log.`DevNo`
                    left join user_info on dev_regist.UserId=user_info.`Id`
                    ".(empty($where)?"":"where $where") ;
        return static::findBySql($sql);
    }

    /**
     * 账户管理查询
     * @param $tel
     * @param $userid
     * @return yii\db\ActiveQuery
     */
    public static function dynamicAllQueryWithName($where,$username){
        if(!empty($username)){
            if(!empty($where)){
                $where.=" and ";
            }
            $where.="agent_info.LoginName='$username'";
        }
        $sql="select  user_info.Tel, dev_regist.Province,dev_regist.City,dev_regist.Area,dev_action_log.*,dev_location.`Address`,dev_location.`Lat`,dev_location.`Lng` from dev_action_log
                    left join dev_location on dev_action_log.`DevNo`=dev_location.`DevNo`
                    left join dev_regist on dev_regist.DevNo=dev_action_log.`DevNo`
                    left join user_ino on dev_regist.UserId=user_info.`Id`
                     left join agent_info on  agent_info.Id=dev_regist.AgentId  or  agent_info.`ParentId`=dev_regist.`AgentId` where ".$where ;
        return static::findBySql($sql);
    }
    public static function dynamicPageQuery($tel,$offset=0,$limit=0,$devno,$province,$city,$area){
        $model = User::findOne(['id'=>yii::$app->getUser()->getIdentity()->getId()]);
        $logic_type=$model->getAttribute("logic_type");
        $where="";
        if(!empty($tel)){
            $where.="dev_regist.`DevBindMobile` like '%$tel'";
        }
        if(!empty($devno)){
            if(!empty($where)){
                $where.=" and ";
            }
            $where.="dev_regist.DevNo='$devno'";
        }
        if(!empty($province)){
            if(!empty($where)){
                $where.=" and ";
            }
            $where.="dev_regist.Province='$province'";
        }
        if(!empty($city)){
            if(!empty($where)){
                $where.=" and ";
            }
            $where.="dev_regist.City='$city'";
        }
        if(!empty($area)){
            if(!empty($where)){
                $where.=" and ";
            }
            $where.="dev_regist.Area='$area'";
        }

        if ($logic_type == 3||$logic_type == 4) {
            //代理商
            $username=$model->getAttribute("username");
            return DevRegist::dynamicPageQueryWithName($where,$username,$offset,$limit);
        }
        $sql="select dev_regist.Province,dev_regist.City,dev_regist.Area,dev_regist.DevBindMobile, dev_action_log.*,dev_location.`Address`,dev_location.`Lat`,dev_location.`Lng` from dev_action_log
              left join dev_location on dev_action_log.`DevNo`=dev_location.`DevNo`
              left join dev_regist on dev_regist.DevNo=dev_action_log.`DevNo`
              ".(empty($where)?"":"where $where")." order by dev_action_log.ActEndTime desc  limit $offset , $limit";
        return static::findBySql($sql);
    }
    public static function dynamicPageQueryWithName($where,$username,$offset=0,$limit=0){
        if(!empty($username)){
            if(!empty($where)){
                $where.=" and ";
            }
            $where.="agent_info.LoginName='$username'";
        }


        $sql="select dev_regist.Province,dev_regist.City,dev_regist.Area, dev_regist.DevBindMobile, dev_action_log.*,dev_location.`Address`,dev_location.`Lat`,dev_location.`Lng` from dev_action_log
              left join dev_location on dev_action_log.`DevNo`=dev_location.`DevNo`
              left join dev_regist on dev_regist.DevNo=dev_action_log.`DevNo`
              left join agent_info on agent_info.Id=dev_regist.AgentId or  agent_info.`ParentId`=dev_regist.`AgentId` where
              " .(empty($where)?"":"where $where")." order by dev_action_log.ActEndTime desc limit $offset , $limit";
        return static::findBySql($sql);
    }



}
