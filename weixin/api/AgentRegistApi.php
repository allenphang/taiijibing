<?php

/**
 * Created by PhpStorm.
 * User: pengjixiang
 * Date: 17/4/1
 * Time: 下午11:28
 */
namespace app\api;

class AgentRegistApi extends BaseApi
{
    private $path='/agent/regist';

    public function post($data){
      return  $this->ajaxAgentPost($this->path,$data);
    }
}