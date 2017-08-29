<?php
/**
 * Created by PhpStorm.
 * User: pengjixiang
 * Date: 2017/7/8
 * Time: 上午11:32
 */

namespace app\controllers;


use yii\web\Controller;

class IndexController extends  Controller
{
        public function actionIndex(){
            return $this->renderPartial("index");
        }
}