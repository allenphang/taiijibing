<?php
/**
 * Created by PhpStorm.
 * User: pengjixiang
 * Date: 17/4/1
 * Time: 下午9:41
 */

namespace app\controllers;


use app\api\AgentApi;
use app\api\UserApi;
use yii;

class BaseController extends yii\web\Controller
{
    protected function jsonReturn($res)
    {
        if ($res->state != 0 && empty($res->msg)) {
            $res->msg = $this->getMsgByErrorCode($res->state);
        }
        Yii::$app->response->content = json_encode($res);
    }

    protected function getMsgByErrorCode($code)
    {
        $desc = '';
        switch ($code) {
            case -1001001:
                $desc = '系统错误';
                break;
            case -1001002:
                $desc = '数据库错误';
                break;
            case -1001003:
                $desc = '参数错误';
                break;
            case -1001007:
                $desc = '签名不正确';
                break;
            case -1102008:
                $desc = '密码错误';
                break;
            case -1102003:
                $desc = '账号系统异常';
                break;
            case -1115001:
                $desc = '数量不足';
                break;
            case -1001016:
                $desc = '验证码错误';
                break;
            case -1102001:
                $desc = '用户会话异常';
                break;
        }
        return $desc;
    }

    protected function saveUser($user)
    {
        yii::$app->session->set("user", $user);
        yii::$app->session->set("token", $user->token);
        yii::$app->session->set("key", $user->key);
    }

    protected function saveAgentUser($user)
    {
        yii::$app->session->set("agent_user", $user);
        yii::$app->session->set("agent_token", $user->token);
        yii::$app->session->set("agent_key", $user->key);
    }

    protected function saveCustomerInfo($info)
    {
        $this->saveUser($info);
    }

    /**
     * 判断浏览器是否在微信环境
     * @return bool
     */
    public function is_weixin()
    {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $isWeixin = false;
        if (stripos($user_agent, "micromessenger")) {
            $isWeixin = true;
        }
        return $isWeixin;

    }

    /**
     * 检验终端用户.是否登录
     * @return bool
     */
    protected function checkCustomerLogin()
    {
        $info = yii::$app->session->get("user");
        if (!$this->is_weixin()) {
            if (empty($info)) {
                return false;
            }
            return true;
        }
        $openid = yii::$app->session->get("openid");
        if (empty($openid)) {
            return false;
        }
        $res = (new UserApi())->getUserInfoByOpenId($openid);
        if ($res->state != 0) {
            return false;
        }
        $this->saveCustomerInfo($res->result);
        return true;
    }

    protected function checkAgentLogin()
    {
//        $info=yii::$app->session->get("agent_user");
//        if (empty($info)) {
//            if (!$this->is_weixin()) {
//                return false;
//            }
//            $openid = yii::$app->session->get("openid");
//            if (empty($openid)) {
//                return false;
//            }
//            $res = (new AgentApi())->getUserInfoByOpenId($openid);
//            if ($res->state != 0) {
//                return false;
//            }
//            $this->saveAgentUser($res->result);
//            return true;
//        }
//        return true;

            if (!$this->is_weixin()) {
                return false;
            }
            $openid = yii::$app->session->get("openid");
            if (empty($openid)) {
                return false;
            }
            $res = (new AgentApi())->getUserInfoByOpenId($openid);
            if ($res->state != 0) {
                return false;
            }
            $this->saveAgentUser($res->result);
            return true;
    }

    /**
     * @param string $name
     * @return array|mixed
     */
    protected function getParam($name = '')
    {
        if (Yii::$app->request->isPost) {
            return Yii::$app->request->post($name);
        }
        return Yii::$app->request->get($name);
    }


}