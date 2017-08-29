<?php
/**
 * Created by PhpStorm.
 * User: pengjixiang
 * Date: 17/4/1
 * Time: 下午6:08
 */

namespace backend\api;
use yii;


class BaseApi
{
    //接口公网地址
    private  $serverUrl='lpn.ebopark.com';
    //请求路径
    private  $path='';
    public   function ajaxPost($path,$post){
        $this->path=$path;
        $session=yii::$app->session;
        $token=$session->get("token");
        $privatekey=$session->get("key");
        if(empty($token)){
            $token='';
            $privatekey='0xOWPxOtXev3#$sCC4AxSoSJpr4LCY4b';
        }
        $url=$this->getUrl($path,$post,$token,$privatekey);
        $res=$this->curl($url,$post);
        return json_decode($res);
    }
    /**
     * @param string $url
     * @param string $posts post请求参数
     * @return mixed
     */
    function curl($url="",$posts=""){
        $ch = curl_init();
        $jsonData="";
        if($posts){
            $jsonData=json_encode($posts);
        }
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS,$jsonData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($jsonData))
        );
        curl_setopt($ch, CURLOPT_ENCODING, "gzip");
        $res = curl_exec($ch);
        curl_close($ch);
        return $res;
    }
    /**
     * @param string $path
     * @param $postData
     * @param $token
     * @param $privatekey
     * @return string
     */
     function getUrl($path='',$postData,$token,$privatekey){
        $url=$this->serverUrl.$path;
        return $this->getMd5Url($url,$postData,$token,$privatekey);

    }

    /**
     * @param $url
     * @param $postData
     * @param string $token
     * @param string $privatekey
     * @return string
     */
     function getMd5Url($url,$postData,$token='',$privatekey=''){

        $jsonStr=json_encode($postData);
        $md5Str=$jsonStr.$privatekey;
        $sign=md5($md5Str);
        $finalUrl= $url.'?'.'token='.$token.'&sign='.$sign;
        return $finalUrl;

    }

}