<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/31
 * Time: 17:01
 */
namespace backend\controllers;

use backend\models\Address;
use backend\models\AgentInfo;
use backend\models\DevFactory;
use backend\models\FactoryInfo;
use yii;
use yii\data\Pagination;

class LogicUserController extends BaseController
{


    /**
     * 设备厂家列表
     */
     public function actionDevfactoryList(){

         $username=$this->getParam("username");
         $mobile=$this->getParam("mobile");
         $province=$this->getParam("province");
         $city=$this->getParam("city");
         $area=$this->getParam("area");

         $datas = DevFactory::findWithCondition($username,$mobile,$province,$city,$area);
         $pages = new Pagination(['totalCount' => $datas->count(), 'pageSize' => 10]);
         $model = $datas->offset($pages->offset)->limit($pages->limit)->asArray()->all();
         $address=(new Address())->allQuery()->asArray()->all();
         return $this->render('devfactoryList', [
             'model' => $model,
             'pages' => $pages,
             'address'=>$address,
             'username'=>empty($username)?"":$username,
             'mobile'=>empty($mobile)?"":$mobile,
             'province'=>empty($province)?"":$province,
             'city'=>empty($city)?"":$city,
             'area'=>empty($area)?"":$area,
         ]);
     }
    public function actionAgentList(){

        $datas = AgentInfo::find();
        $pages = new Pagination(['totalCount' => $datas->count(), 'pageSize' => 10]);
        $model = $datas->offset($pages->offset)->limit($pages->limit)->asArray()->all();
        return $this->render('agentList', [
            'model' => $model,
            'pages' => $pages,
        ]);
    }
    public function actionAgentxlist(){
        $username=$this->getParam("username");
        $mobile=$this->getParam("mobile");
        $province=$this->getParam("province");
        $city=$this->getParam("city");
        $area=$this->getParam("area");
        $level=4;
        $datas = AgentInfo::pageQueryWithCondition($username,$mobile,$province,$city,$area,$level);
        $pages = new Pagination(['totalCount' => $datas->count(), 'pageSize' => 10]);
        $model = $datas->offset($pages->offset)->limit($pages->limit)->asArray()->all();
        $address=(new Address())->allQuery()->asArray()->all();
        //县级代理
        return $this->render('agentList', [
            'model' => $model,
            'pages' => $pages,
            'level'=>$level,
            'address'=>$address,
            'username'=>empty($username)?"":$username,
            'mobile'=>empty($mobile)?"":$mobile,
            'province'=>empty($province)?"":$province,
            'city'=>empty($city)?"":$city,
            'area'=>empty($area)?"":$area,
        ]);
    }
    public function actionAgentslist(){
        $username=$this->getParam("username");
        $mobile=$this->getParam("mobile");
        $province=$this->getParam("province");
        $city=$this->getParam("city");
        $area=$this->getParam("area");
        $level=5;
        $datas =AgentInfo::pageQueryWithCondition($username,$mobile,$province,$city,$area,$level);
        $pages = new Pagination(['totalCount' => $datas->count(), 'pageSize' => 10]);
        $model = $datas->offset($pages->offset)->limit($pages->limit)->asArray()->all();
        $address=(new Address())->allQuery()->asArray()->all();
        //县级代理
        return $this->render('agentList', [
            'model' => $model,
            'pages' => $pages,
            'level'=>$level,
            'address'=>$address,
            'username'=>empty($username)?"":$username,
            'mobile'=>empty($mobile)?"":$mobile,
            'province'=>empty($province)?"":$province,
            'city'=>empty($city)?"":$city,
            'area'=>empty($area)?"":$area,
        ]);
    }
    public function actionFactoryList(){
        $username=$this->getParam("username");
        $mobile=$this->getParam("mobile");
        $province=$this->getParam("province");
        $city=$this->getParam("city");
        $area=$this->getParam("area");
        $datas = FactoryInfo::findWithCondition($username,$mobile,$province,$city,$area);
        $pages = new Pagination(['totalCount' => $datas->count(), 'pageSize' => 10]);
        $model = $datas->offset($pages->offset)->limit($pages->limit)->asArray()->all();
        $address=(new Address())->allQuery()->asArray()->all();
        return $this->render('factoryList', [
            'model' => $model,
            'pages' => $pages,
            'address'=>$address,
            'username'=>empty($username)?"":$username,
            'mobile'=>empty($mobile)?"":$mobile,
            'province'=>empty($province)?"":$province,
            'city'=>empty($city)?"":$city,
            'area'=>empty($area)?"":$area,

        ]);
    }


}