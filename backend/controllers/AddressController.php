<?php
namespace backend\controllers;

use backend\models\Address;
use Yii;
use yii\data\ArrayDataProvider;
use backend\models\Menu;
use backend\models\MenuSearch;
use yii\data\Pagination;
/**
 * Menu controller
 */
class AddressController extends BaseController
{
    public $enableCsrfValidation = false;
    public function actionCreate(){

        if(Yii::$app->request->isPost){
            $model=new Address();
            if($model->load(Yii::$app->request->post())&&$model->add()){
                Yii::$app->getSession()->setFlash('success', yii::t('app', 'Success'));
                return $this->redirect(['index']);
            }else{
                Yii::$app->getSession()->setFlash('error', "操作失败");
                $this->goBack();
            }
        }
        //获取所有的地址
        $data=(new Address())->allQuery()->asArray()->all();
        return $this->render("create",["data"=>json_encode($data)]);
    }
    public function actionIndex()
    {
        $datas =Address::allQuery();
        $pages = new Pagination(['totalCount' => $datas->count(), 'pageSize' => 10]);
        $querys =Address::pageQuery($pages->offset,$pages->limit);
        $model = $querys->asArray()->all();
        $data=(new Address())->allQuery()->asArray()->all();
        return $this->render('index', [
            'model' => $model,
            'pages' => $pages,
            "data"=>json_encode($data)
        ]);
    }
    public function actionDelete($id)
    {
        if(empty($id)){
            $this->jsonErrorReturn("参数错误");
            return;
        }
        $res=Address::deleteAll("id=".$id);
        if($res==false){
            $this->jsonErrorReturn("操作失败");
            return;
        }
        $this->jsonReturn(["state"=>0]);
    }

}
