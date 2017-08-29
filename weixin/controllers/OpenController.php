<?php
/**
 * Created by PhpStorm.
 * User: pengjixiang
 * Date: 17/5/21
 * Time: 下午5:58
 */

namespace app\controllers;


use yii\web\Controller;

class OpenController extends WxController
{
    public function toSetting(){
        $this->checkOpenid();
        $url="/index.php?r=personal-center/setting";
        header("Location:".$url);
        exit();
    }

}