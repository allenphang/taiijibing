<?php
/**
 * Created by PhpStorm.
 * User: pengjixiang
 * Date: 17/4/8
 * Time: 下午1:59
 */

namespace backend\controllers;


use backend\models\AgentInfo;
use yii;
use backend\models\Address;

class AgentController extends BaseController
{


    public function getModel($id='')
    {
        return AgentInfo::findOne(["Id"=>$id]);
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
            if( $model->load(Yii::$app->getRequest()->post()) && $model->validate() ){
//                $model->save()
                $level=$model["Level"];
                $update=true;
                if($level==4){
                    //县区
                    $childid=yii::$app->request->post("AgentInfo")["childid"];
                    $Id=$model["Id"];
                    $model->setAttribute("ParentId",0);
                    //下属
                    $update =  AgentInfo::setParentId($childid,$Id);
                }
               if($update!==false&&$model->updateForm()){
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

            }else{
                $errors = $model->getErrors();
                $err = '';
                foreach($errors as $v){
                    $err .= $v[0].'<br>';
                }
                Yii::$app->getSession()->setFlash('error', $err);
            }
        }
        //获取所有的县区代理商及社区代理商
        $qArr=(new AgentInfo())->queryByLevel(4);
        $sArr=(new AgentInfo())->queryByLevel(5);
        $lowerAgent=(new AgentInfo())->findOneLowerAgent($id);
        $data=(new Address())->allQuery()->asArray()->all();
        return $this->render('update', [
            'model' => ["model"=>$model,
                'qArr'  =>$qArr,
                'sArr'  =>$sArr,
                'lower_agent'=>$lowerAgent,
                "data"=>json_encode($data)],
        ]);
    }
}