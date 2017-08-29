<?php
/**
 * Created by PhpStorm.
 * User: pengjixiang
 * Date: 17/5/19
 * Time: 下午2:32
 */

namespace app\controllers;
use yii;

class WxController extends BaseController
{
    private static $appid="wx1e15a0f46e396e72";
    private static $appsecret="5109f667f7d762835cb082516a0d4086";


    public function checkOpenid(){

        $openid=yii::$app->session->get("openid");
        if(empty($openid)){
            $this->getOpenid();
        }
    }
    public function getOpenid(){
        if(!$this->is_weixin()){
            return;
        }
        yii::$app->session->set("openid_url",$this->module->requestedRoute);
        $APPID=WxController::$appid;
        $REDIRECT_URI='http://'.$_SERVER['SERVER_NAME'].($_SERVER['SERVER_PORT']==80?'':':'.$_SERVER['SERVER_PORT']).'/index.php/wx/get-wx-auth';
        $scope='snsapi_base';
        $state="weixin";
        $url='https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$APPID.'&redirect_uri='.$REDIRECT_URI.'&response_type=code&scope='.$scope.'&state='.$state.'#wechat_redirect';
        header("Location:".$url);
        exit();
    }
    public function actionGetWxAuth(){
        $appid = WxController::$appid;
        $secret = WxController::$appsecret;
        $code = $_GET["code"];
        if($code==null){
            $this->toError();
        }
        $get_token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$appid.'&secret='.$secret.'&code='.$code.'&grant_type=authorization_code';
        $res=file_get_contents($get_token_url);
        $json_obj = json_decode($res,true);
        if(!empty($json_obj["errcode"])){
            //微信授权失败
            $this->toError();
        }
        $openid = $json_obj['openid'];
        yii::$app->session->set("openid",$openid);
        //跳转至原路径
        $openid_url=yii::$app->session->get("openid_url");
        if(empty($openid_url)){
            $this->toError();
        }
        header("Location:/index.php/".$openid_url);
        exit();
    }
    public function actionError(){
        return $this->renderPartial("error");
    }
    public function toError(){
        header("Location:/index.php/wx/error");
        exit();
    }

}