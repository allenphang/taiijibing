<?php
/**
 * Created by PhpStorm.
 * User: pengjixiang
 * Date: 2017/6/21
 * Time: 下午11:15
 */

namespace app\api;


class GoodsApi extends BaseApi
{
    private $path = '/goods/detail';
    public function detail($id,$distid)
    {
        $postData["id"]=$id;
        if(!empty($distid)){
            $postData["distid"]=$distid;
        }
        return $this->ajaxPost('/goods/detail',$postData);
    }
    public function get($postData=[])
    {
        $url=$this->getUrl("/goods/get",$postData,'','0xOWPxOtXev3#$sCC4AxSoSJpr4LCY4b');
        $res=$this->curl($url,$postData);
        return json_decode($res);
    }

}