<?php
/**
 * Created by PhpStorm.
 * User: pengjixiang
 * Date: 17/4/9
 * Time: 上午9:33
 */

namespace backend\controllers;


use backend\models\AgentInfo;
use backend\models\DevWaterScan;
use yii\data\Pagination;
use yii;
class SaomaController extends  BaseController
{
    public function actionList()
    {
        $selecttime=yii::$app->request->post("selecttime");
        $xname=yii::$app->request->post("xname");
        $sname=yii::$app->request->post("sname");
        $waterfname=yii::$app->request->post("waterfname");

        $datas = DevWaterScan::totalQuery($selecttime,$xname,$sname,$waterfname);
        $pages = new Pagination(['totalCount' => $datas->count(), 'pageSize' => 10]);
        $model =$this->listWrapData(DevWaterScan::pageQuery($pages->offset,$pages->limit,$selecttime,$xname,$sname,$waterfname)->asArray()->all());
        return $this->render('list', [
            'model' => $model,
            'pages' => $pages,
            'selecttime'=>$selecttime,
            'xname'=>$xname,
            'sname'=>$sname,
            'waterfname'=>$waterfname
        ]);
    }
    public function actionFlist()
    {
        $waterfname=yii::$app->request->get("waterfname");
        $datas = DevWaterScan::totalQuery('','','',$waterfname);
        $pages = new Pagination(['totalCount' => $datas->count(), 'pageSize' => 10]);
        $model =$this->listWrapData(DevWaterScan::pageQuery($pages->offset,$pages->limit,'','','',$waterfname)->asArray()->all());
        return $this->render('flist', [
            'model' => $model,
            'pages' => $pages,
        ]);
    }
    public function listWrapData($list){

        $listTemp=[];
        foreach($list as $val){
            $agentId=$val["agentId"];
            if(empty($agentId)){
                continue;
            }
            $agentInfo=(new AgentInfo())->getAgentInfoById($agentId);
            if(empty($agentInfo)){
                continue;
            }
            if($agentInfo["Level"]==4){
                $val["agentpname"]=$agentInfo["LoginName"];
                $val["agentname"]="-";
            }else{
                //社区
                $parentId=$agentInfo["ParentId"];
                $val["agentname"]=$agentInfo["LoginName"];
                if(empty($parentId)){
                    $val["agentpname"]="-";
                }else{
                    $agentpInfo=(new AgentInfo())->getAgentInfoById($parentId);
                    $val["agentpname"]=$agentpInfo["LoginName"];

                }
            }
            $listTemp[]=$val;
        }
        return $listTemp;
    }
}