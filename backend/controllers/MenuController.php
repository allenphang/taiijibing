<?php
namespace backend\controllers;

use Yii;
use yii\data\ArrayDataProvider;
use backend\models\Menu;
use backend\models\MenuSearch;

/**
 * Menu controller
 */
class MenuController extends BaseController
{

    public function getIndexData()
    {
        $data = Menu::getMenuArray(Menu::BACKEND_TYPE);
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'pageSize' => -1
            ]
        ]);
        return [
            'dataProvider' => $dataProvider
        ];
    }

    public function getModel($id="")
    {
        if($id == ''){
            $model = new Menu();
        }else {
            $model = Menu::findOne(['id' => $id]);
            if ($model == null) return null;
        }
        $model->setScenario('backend');
        return $model;
    }

    public function actionIndex()
    {
        $searchModel = new MenuSearch(['scenario'=>'backend']);
        $dataProvider = $searchModel->search(yii::$app->getRequest()->getQueryParams());
        $data = [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ];
        return $this->render('index', $data);
    }

}
