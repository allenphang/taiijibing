<?php
/**
 * Created by PhpStorm.
 * User: pengjixiang
 * Date: 17/5/21
 * Time: 下午5:40
 */

namespace app\api;
use Yii;

class AgentApi extends BaseApi
{

    public function getUserInfoByOpenId($openid = null){
        if(empty($openid)){
            return;
        }
        $data["openid"]=$openid;
        return $this->ajaxPost('/agent/GetByOpenId',$data);
    }

    public function getUserStat(){
        return $this->ajaxAgentPost('/agent/GetUserStat',[]);
    }

    public function getTotalStat(){
        return $this->ajaxAgentPost('/agent/GetTotalStat',[]);
    }

    public function getWarning(){
        $data["take"]=100;
        $data["skip"]=0;
        return $this->ajaxAgentPost('/agent/GetWarning',$data);
    }

    public function getDayStat(){
        return $this->ajaxAgentPost('/agent/GetDayStat',[]);
    }
    public function getAgents(){
        return $this->ajaxAgentPost('/Agent/GetAgents',[]);
    }
    public function getUsers(){
        $data["take"]=100;
        $data["skip"]=0;
        return $this->ajaxAgentPost('/Agent/GetUsers',$data);
    }


}