<?php
/**
 * Created by PhpStorm.
 * User: pengjixiang
 * Date: 17/4/8
 * Time: 下午1:59
 */

namespace backend\controllers;


use backend\models\DevFactory;
use backend\models\Address;
use Yii;
class DevFactoryController extends BaseController
{


    public function getModel($id='')
    {
        return DevFactory::findOne(["Id"=>$id]);
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
            if($model->load(Yii::$app->getRequest()->post())&&$model->validate() && $model->save() ){
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
        return $this->render('update', [
            'model' => ["model"=>$model,"data"=>json_encode($data)],
        ]);
    }
}