<?php
/**
 * Created by PhpStorm.
 * User: pengjixiang
 * Date: 17/4/8
 * Time: 下午2:21
 */

namespace backend\controllers;


use backend\models\WaterBrand;
use yii;
use yii\data\Pagination;
use yii\data\ActiveDataProvider;

class WaterBrandController extends BaseController
{

    public function getModel($id='')
    {
        return WaterBrand::findOne(["BrandNo"=>$id]);
    }
    public function getIndexData()
    {
        $query = WaterBrand::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return [
            'dataProvider' => $dataProvider,
        ];
    }
    public function actionList()
    {
        $datas =WaterBrand::allQuery();
        $pages = new Pagination(['totalCount' => $datas->count(), 'pageSize' => 5]);
        $querys =WaterBrand::pageQuery($pages->offset,$pages->limit);
        $model = $querys->asArray()->all();
        return $this->render('list', [
            'model' => $model,
            'pages' => $pages,
        ]);
    }
    public function actionDelete($brandno)
    {
        if(empty($brandno)){
                $this->jsonErrorReturn("参数错误");
            return;
        }
        $res=WaterBrand::deleteByBrandno($brandno);
        if($res===false){
            $this->jsonErrorReturn("操作错误,请稍后再试");
            return ;
        }
        $this->jsonReturn(["state"=>0]);

    }

    public function actionCreate()
    {
        $model = new WaterBrand();
        $model->setScenario('create');
        if ( Yii::$app->getRequest()->getIsPost() ) {

            if($model->load(yii::$app->getRequest()->post())&&$model->validate()&&$model->createData()){

                Yii::$app->getSession()->setFlash('success', yii::t('app', 'Success'));
                return $this->redirect(['list']);
            }else{
                $errors = $model->getErrors();
                $err = '';
                foreach($errors as $v){
                    $err .= $v[0].'<br>';
                }
                Yii::$app->getSession()->setFlash('error', $err);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }



}