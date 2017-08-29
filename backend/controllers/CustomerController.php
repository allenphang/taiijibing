<?php
/**
 * Created by PhpStorm.
 * User: pengjixiang
 * Date: 17/4/5
 * Time: 下午9:52
 */

namespace backend\controllers;

use backend\models\CustomSearch;
use yii;
use yii\data\Pagination;
use backend\models\Address;

class CustomerController extends BaseController
{

    public function actionList()
    {

        $username=$this->getParam("username");
        $mobile=$this->getParam("mobile");
        $province=$this->getParam("province");
        $city=$this->getParam("city");
        $area=$this->getParam("area");
        $address=(new Address())->allQuery()->asArray()->all();
        $datas = CustomSearch::pageQuery($username,$mobile,$province,$city,$area);
        $pages = new Pagination(['totalCount' => $datas->count(), 'pageSize' => 10]);
        $model = $datas->offset($pages->offset)->limit($pages->limit)->asArray()->all();
        return $this->render('list', [
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