<?php
/**
 * Created by PhpStorm.
 * User: pengjixiang
 * Date: 17/4/1
 * Time: 下午6:20
 */

namespace app\api;
use yii;
/**
 * Class AgentLoginApi
 * @package app\api
 * 登录
 */
class AgentLoginApi extends BaseApi
{

    private $path = '/agent/login';
    public function post($post = [])
    {
        $openid=yii::$app->session->get("openid");
        if(!empty($openid)){
            $post["openid"]=$openid;
        }
        return $this->ajaxPost($this->path,$post);
    }
}