<?php
/**
 * Created by PhpStorm.
 * User: pengjixiang
 * Date: 17/4/1
 * Time: 下午10:53
 */

namespace app\api;

/**
 * 发送验证码
 * Class SmsSendApi
 * @package app\api
 */
class SmsSendApi extends BaseApi
{
    private $path='/Sms/Send';

    public function post($tel=''){
        $data["mobile"]=$tel;
       return $this->ajaxPost($this->path,$data);

    }
}