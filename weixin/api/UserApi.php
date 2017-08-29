<?php
/**
 * Created by PhpStorm.
 * User: pengjixiang
 * Date: 17/5/21
 * Time: 下午5:40
 */

namespace app\api;
use Yii;

class UserApi extends BaseApi
{
    public function post($mobile='',$vcode=''){
        $data["mobile"]=$mobile;
        $data["vcode"]=$vcode;
        $openid=Yii::$app->session->get("openid");
        if(!empty($openid)){
            $data["openid"]=$openid;
        }
        return $this->ajaxPost('/user/login',$data);

    }
    public function getUserInfoByOpenId($openid = null){
        if(empty($openid)){
            return;
        }
        $data["openid"]=$openid;
        return $this->ajaxPost('/user/GetByOpenId',$data);
    }
    public function saveWaterPlan($ml){
        $data["ml"]=$ml;
        return $this->ajaxPost("/user/SaveWaterPlan",$data);
    }
    public function todayInfo(){
        return $this->ajaxPost("/user/GetTodayInfo",[]);
    }
    public function getLogs(){
       $data["dt"]=date("Y-m-d");
        // $data["dt"]="2017-05-21";
        return $this->ajaxPost("/user/GetLogs",$data);
    }

}