<?php
/**
 * Created by PhpStorm.
 * User: pengjixiang
 * Date: 17/4/10
 * Time: 上午9:49
 */

namespace app\api;
use yii;


class AgentGetDevFactoryApi extends  BaseApi
{
    private $path = '/Agent/GetDevFactory';
    public function post($post = [])
    {
        return $this->ajaxAgentPost($this->path,$post);
    }
}