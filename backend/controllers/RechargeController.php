<?php
/**
 * Created by PhpStorm.
 * User: pengjixiang
 * Date: 17/4/10
 * Time: 上午10:44
 */

namespace backend\controllers;
use backend\models\OrderSuccess;
use yii;
use yii\data\Pagination;


class RechargeController extends BaseController
{
    public function actionIndex(){

    }
    public function actionCreate(){
        $model=new OrderSuccess();
        if(Yii::$app->request->getIsPost()){
            $model->setScenario("create");
            if($model->load(Yii::$app->request->post())&&$model->checkForm()&&$model->createOrder()){
                Yii::$app->getSession()->setFlash('success', "充值成功");
            }else{
                Yii::$app->getSession()->setFlash('error', "参数错误");
            }
        }
        $fid=Yii::$app->request->get("fid");
        if(empty($fid)){
            Yii::$app->getSession()->setFlash('error', "参数错误");
            $this->goBack();
        }
       return  $this->render("recharge",["fid"=>$fid,"model"=>$model]);
    }
    public function actionList(){
        $pid=Yii::$app->request->get("pid");
        if(empty($pid)){
            Yii::$app->getSession()->setFlash('error', "参数错误");
            $this->goBack();
            exit();
        }
        $datas=OrderSuccess::all($pid);
        $pages = new Pagination(['totalCount' => $datas->count(), 'pageSize' => 10]);
        $querys =OrderSuccess::pageQuery($pages->offset,$pages->limit,$pid);
        $model =$querys->asArray()->all();
        return $this->render('list', [
            'model' => $model,
            'pages' => $pages,

        ]);
    }

}