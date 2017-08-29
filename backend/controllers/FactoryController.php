<?php
/**
 * Created by PhpStorm.
 * User: pengjixiang
 * Date: 17/4/8
 * Time: 下午2:21
 */

namespace backend\controllers;


use backend\models\FactoryInfo;
use backend\models\User;
use backend\models\WaterBrand;
use yii;
use backend\models\Address;

class FactoryController extends BaseController
{

    public function getModel($id='')
    {
        return FactoryInfo::findOne(["Id"=>$id]);
    }
    public function actionUpdate($id)
    {
        if(!$id) return $this->render('/error/error', [
            'code' => '403',
            'name' => 'Params required',
            'message' => yii::t('app', "Id doesn't exit"),
        ]);
        $model = $this->getModel($id);
        if(!$model) return $this->render('/error/error', [
            'code' => '403',
            'name' => 'Params required',
            'message' => yii::t('app', "Id doesn't exit"),
        ]);
        if ( Yii::$app->request->isPost ) {
            if($model->load(Yii::$app->getRequest()->post())&&$model->validate() && $model->save(false) ){
                Yii::$app->getSession()->setFlash('success', yii::t('app', 'Success'));
                return $this->redirect(['update', 'id'=>$model->getPrimaryKey()]);
            }else{
                $errors = $model->getErrors();
                $err = '';
                foreach($errors as $v){
                    $err .= $v[0].'<br>';
                }
                Yii::$app->getSession()->setFlash('error', $err);
            }
        }
        //获取所有的水品牌
        $data=(new Address())->allQuery()->asArray()->all();
        $waterList=WaterBrand::allQuery()->asArray()->all();
        return $this->render('update', [
            'model' => ["model"=>$model,'waterlist'=>$waterList,"data"=>json_encode($data)],
        ]);
    }
    public function actionRechargeLog(){
        $model = User::findOne(['id'=>yii::$app->getUser()->getIdentity()->getId()]);
        $logic_type=$model->getAttribute("logic_type");
        if($logic_type!=1){
            Yii::$app->getSession()->setFlash('error', "参数错误");
            $this->goBack();
            exit();
        }
        $username=$model->getAttribute("username");
        $model=(new FactoryInfo())->findByName($username);
        if(empty($model)){
            Yii::$app->getSession()->setFlash('error', "用户不存在");
            $this->goBack();
            exit();
        }
        $id=$model["Id"];
        $url="/index.php?r=recharge/list&pid=$id";
        header("Location:$url");
        exit();

    }
    public function actionFlist(){
        $model = User::findOne(['id'=>yii::$app->getUser()->getIdentity()->getId()]);
        $logic_type=$model->getAttribute("logic_type");
        if($logic_type!=1){
            Yii::$app->getSession()->setFlash('error', "参数错误");
            $this->goBack();
            exit();
        }
        $username=$model->getAttribute("username");
        $model=(new FactoryInfo())->findByName($username);
        if(empty($model)){
            Yii::$app->getSession()->setFlash('error', "用户不存在");
            $this->goBack();
            exit();
        }
        $name=$model["Name"];
        $url="/index.php?r=saoma/flist&waterfname=$name";
        header("Location:$url");
        exit();

    }


}