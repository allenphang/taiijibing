<?php
/**
 * Created by PhpStorm.
 * User: pengjixiang
 * Date: 2017/6/20
 * Time: 下午6:05
 */

namespace backend\controllers;


use backend\api\BaseApi;
use backend\models\GoodsCategory;
use backend\models\GoodsMerchant;
use yii\base\Exception;
use yii\db\ActiveRecord;
use yii;

class GoodsController extends BaseController
{
    public function actionList()
    {

        $data = $this->getCategoryAndMerchant();
        return $this->renderPartial("list", [
            "category" => $data["cate"],
            "merchant" => $data["mer"],
            "preview" => "http://wx.ebopark.com/index.php/Home/Eshop/gooddetail_"
        ]);
    }

    public function actionListNouse()
    {
        $data = $this->getCategoryAndMerchant();
        return $this->renderPartial("nouse", [
            "category" => $data["cate"],
            "merchant" => $data["mer"],
            "preview" => "http://wx.ebopark.com/index.php/Home/Eshop/gooddetail_"
        ]);
    }

    public function actionListForsale()
    {
        $data = $this->getCategoryAndMerchant();
        return $this->renderPartial("forsale", [
            "category" => $data["cate"],
            "merchant" => $data["mer"],
            "preview" => "http://wx.ebopark.com/index.php/Home/Eshop/gooddetail_"
        ]);
    }

    private function getCategoryAndMerchant()
    {
        $categoryarray = (new GoodsCategory())->query();
        $merchantarray = (new GoodsMerchant())->query();
        $category = array();
        $merchant = array();
        foreach ($categoryarray as $key => $value) {
            $category[] = array("name" => $value["name"], "id" => $value["id"]);
        }
        foreach ($merchantarray as $key => $value) {
            $merchant[] = array("name" => $value["name"], "id" => $value["id"]);
        }
        return ["cate" => $categoryarray, "mer" => $merchant];

    }

    /**
     * 创建商品
     * @return string
     */
    public function actionAddgood()
    {
        $data = $this->getPageDataWhenAddOrUpdate();

        return $this->renderPartial("create", [
            "category" => $data["category"],
            "merchant" => $data["merchant"],
            "sms" => $data["sms"]

        ]);
    }

    private function getPageDataWhenAddOrUpdate()
    {

        $categoryarray = ActiveRecord::findBySql("select id,name from goods_category")->asArray()->all();
        $merchantarray = ActiveRecord::findBySql("select id,name from goods_merchant")->asArray()->all();
        $sms = ActiveRecord::findBySql("select `name`,`id` from msg_smstemp")->asArray()->all();
        $category = array();
        $merchant = array();
        $array = array();
        foreach ($categoryarray as $key => $value) {
            $category[] = array("name" => $value["name"], "id" => $value["id"]);
        }
        foreach ($merchantarray as $key => $value) {
            $merchant[] = array("name" => $value["name"], "id" => $value["id"]);
        }
        foreach ($sms as $key => $value) {
            $array[] = array("name" => $value["name"], "id" => $value["id"]);
        }
        return ["category" => $category, "merchant" => $merchant, "sms" => $array];
    }

    public function actionWaittingsale()
    {
        $id = $this->getParam("id");
        try {
            $result = yii::$app->db->createCommand("update goods_info_base set starttime='2099-01-01',EndTime='2099-01-01' where id='$id'")->execute();
//            $result= D("GoodsMerchantUser")->execute("update goods_info_base set starttime='2099-01-01',EndTime='2099-01-01' where id='%s'",$id);
            $data["state"] = ($result >= 0 ? 0 : -1);
            $this->jsonReturn($data);
        } catch (Exception $e) {
            $data["state"] = -1;
            $data["msg"] = $e->getMessage();
            $this->jsonReturn($data);
        }
    }

    /**
     * 商品下架
     */
    public function actionShelf()
    {
        $id = $this->getParam("id");
        try {
            $result = yii::$app->db->createCommand("update goods_info_base set EndTime=date_add(now(), interval -1 second) where id='$id'")->execute();
            $data["state"] = ($result >= 0 ? 0 : -1);
            $this->jsonReturn($data);
        } catch (Exception $e) {
            $data["state"] = -1;
            $data["msg"] = $e->getMessage();
            $this->jsonReturn($data);
        }
    }

    /**
     * 商品上架
     */
    public function actionUnshelf()
    {
        $id = $this->getParam("id");
        try {
            $sql = "select 1 as count from goods_info_base where id='$id' and endtime<now() or endtime<starttime";
            $res = ActiveRecord::findBySql($sql)->asArray()->all();
            $total = 0;
            foreach ($res as $key => $value) {
                $total = $value["count"];
            }
            if ($total == 1) {
                $data["state"] = -2;
                $data["msg"] = "商品下架时间小于上架时间！";
                $this->jsonReturn($data);
                return;
            }
            $result = yii::$app->db->createCommand("update goods_info_base set starttime=now() where id='$id'")->execute();
            $data["state"] = ($result >= 0 ? 0 : -1);
            $this->jsonReturn($data);
        } catch (Exception $e) {
            $data["state"] = -1;
            $data["msg"] = $e->getMessage();
            $this->jsonReturn($data);
        }
    }

    public function actionDel()
    {
        $id = $this->getParam("id");
        try {
            $executeresult = true;
            $trans = (new ActiveRecord())->getDb()->beginTransaction();
            //销售状态 分享链接 消息定义 商品型号 商品图片 商品控件属性值 基本信息
            $array = array("goods_stat_sale", "goods_info_share", "goods_info_msgdef", "goods_info_item", "goods_info_img", "goods_info_control", "goods_info_base");
            foreach ($array as $key => $value) {
                $r = false;
                if ($value == "goods_info_base") {
                    $r = yii::$app->db->createCommand("delete from $value where id='$id'")->execute();
                } else {
                    $r = yii::$app->db->createCommand("delete from $value where GoodsId='$id'")->execute();
                }

                if (!$r && $r !== 0) {
                    $trans->rollback();
                    $executeresult = false;
                    break;
                }
            }
            if ($executeresult) {
                $trans->commit();
            }

            $data["state"] = ($executeresult ? 0 : -1);
            $this->jsonReturn($data);
        } catch (Exception $e) {
            $data["state"] = -1;
            $data["msg"] = $e->getMessage();
            $this->jsonReturn($data);
        }

    }

    /**
     * 商品复制到待售
     */
    public function actionCopytounshelf()
    {
        $id = $this->getParam("id");
        try {
            $executeresult = true;
            $suffix = time();
            $goodid = "copy" . $suffix;
            //销售状态 分享链接 消息定义 商品型号 商品图片 商品控件属性值 基本信息
            $array = array(
                "insert into goods_info_item(GoodsId,Name,Total,CostPrice) select '" . $goodid . "',Name,Total,CostPrice from goods_info_item where GoodsId='" . $id . "'",
//                "insert into goods_stat_sale(ItemId,Date,GoodsId,Amount) select LAST_INSERT_ID(),Date,'".$goodid."',0 from goods_stat_sale where GoodsId='".$id."'",
                "insert into goods_info_share(GoodsId,`Title`,`Content`,Img) select '" . $goodid . "',`Title`,`Content`,Img from goods_info_share where GoodsId='" . $id . "'",
                "insert into goods_info_msgdef(GoodsId,MsgTailOfMerchant,MsgTailOfUser) select '" . $goodid . "',MsgTailOfMerchant,MsgTailOfUser from goods_info_msgdef where GoodsId='" . $id . "'",
                "insert into goods_info_img(GoodsId,`Type`,`Order`,`Url`) select '" . $goodid . "',`Type`,`Order`,`Url` from goods_info_img where GoodsId='" . $id . "'",
                "insert into goods_info_control(GoodsId,`ControlType`,`Data`,`Order`) select '" . $goodid . "',`ControlType`,`Data`,`Order` from goods_info_control where GoodsId='" . $id . "'",
                "insert into goods_info_base(`Id`,`MerchantId`,`CategoryId`,`LogicType`,`Name`,`Title`,`ExpressType`,`InitAmount`,`OriginalPrice`,`SalePrice`,`ShopHours`,`Tel`,`Lat`,`lng`,`Address`,`Tips`,`RowTime`,`LastOpUser`,`LastOpTime`,`OrderDescTemp`,`StartTime`,`EndTime`,`MemberDiscountType`,`MemberDiscountVal`,`ExistsDetail`,`total`) select '" . $goodid . "',`MerchantId`,`CategoryId`,`LogicType`,CONCAT_WS('','copy',`Name`),`Title`,`ExpressType`,`InitAmount`,`OriginalPrice`,`SalePrice`,`ShopHours`,`Tel`,`Lat`,`lng`,`Address`,`Tips`,now(),`LastOpUser`,now(),`OrderDescTemp`,'2099-1-1','2099-1-1',`MemberDiscountType`,`MemberDiscountVal`,`ExistsDetail`,`total` from goods_info_base where id='" . $id . "'"
            );
            $trans = (new ActiveRecord())->getDb()->beginTransaction();
            foreach ($array as $key => $value) {
                $r = yii::$app->db->createCommand($value)->execute();
                if ($r != 0 && !$r) {
                    $trans->rollback();
                    $executeresult = false;
                    break;
                }
            }
            if ($executeresult) {
                $trans->commit();
            }
            //更新e泊特价itemid
            $updateSuccess = $this->updatePricesControlAfterCopy($goodid);
            $data["state"] = ($updateSuccess && $executeresult ? 0 : -1);
            $this->jsonReturn($data);
        } catch (Exception $e) {
            $data["state"] = -1;
            $data["msg"] = $e->getMessage();
            $this->jsonReturn($data);
        }
    }

    public function updatePricesControlAfterCopy($goodid = "")
    {
        $res = ActiveRecord::findBySql("select Id from goods_info_item where GoodsId='$goodid'")->asArray()->all();
        if (!$res) {
            return false;
        }
        $control = ActiveRecord::findBySql("select Data from goods_info_control where GoodsId='$goodid' and ControlType=10102")->asArray()->all();
        if (!$control) {
            return false;
        }
        $controlObj = json_decode($control[0]["Data"]);
        if (count($controlObj->Items) != count($res)) {
            return false;
        }
        foreach ($res as $key => $val) {
            $controlObj->Items[$key]->ItemId = $val["Id"];
        }
        $json = json_encode($controlObj);
        $res = yii::$app->db->createCommand("update goods_info_control set Data='$json' where GoodsId='$goodid' and ControlType=10102")->execute();
        return !!$res;


    }

    /**
     * 获取商品列表
     */
    public function actionGetSales()
    {
        $pageIndex = $this->getParam("pageIndex") + 1;
        $pageSize = $this->getParam("pageSize");
        $goodid = $this->getParam("goodid");
        $name = $this->getParam("name");
        $categoryid = $this->getParam("categoryid");
        $merchantid = $this->getParam("merchantid");
        $starttime = $this->getParam("starttime");
        $endtime = $this->getParam("endtime");
        $saling = $this->getParam("saling");
        $shelfstarttime = $this->getParam("shelfstarttime");
        $shelfendtime = $this->getParam("shelfendtime");
        try {
            $where = "";
            if ($saling == "1") {
                $where = " where StartTime>now() and EndTime>now()";//待售
            } else if ($saling == "0") {
                $where = " where EndTime>now() and startTime<=now() ";//上架
            } else {
                $where = " where EndTime<now() and startTime<now()";//失效
            }

            if (!empty($merchantid)) {
                $where .= " and merchantid = '" . $merchantid . "'";
            }
            if (!empty($categoryid)) {
                $where .= " and categoryid = '" . $categoryid . "'";
            }
            if (!empty($name)) {
                $where .= " and `name` like '%" . $name . "%'";
            }
            if (!empty($starttime) && !empty($endtime)) {
                $where .= " and starttime between '" . $starttime . "' and '" . $endtime . "'";
            }
            if (!empty($shelfstarttime) && !empty($shelfendtime)) {
                $where .= " and endtime between '" . $shelfstarttime . "' and '" . $shelfendtime . "'";
            }
            if (!empty($goodid)) {
                $where .= " and Id='$goodid'";
            }
            $categoryarray = ActiveRecord::findBySql("select id,name from goods_category")->asArray()->all();
            $merchantarray = ActiveRecord::findBySql("select id,name from goods_merchant")->asArray()->all();
            $category = array();
            $merchant = array();
            foreach ($categoryarray as $key => $value) {
                $category[$value["id"]] = $value["name"];
            }
            foreach ($merchantarray as $key => $value) {
                $merchant[$value["id"]] = $value["name"];
            }

            //2017/04/06 添加商品类型
            $typesarray = ActiveRecord::findBySql("select i.id as itemid, i.GoodsId,i.costprice,i.name,sum(s.amount) as amount ,goods_info_control.Data from goods_info_item i
                                                      left join goods_stat_sale s on i.id=s.itemid
                                                      left join goods_info_control on goods_info_control.GoodsId=i.GoodsId and goods_info_control.ControlType='10102'
                                                      group by i.costprice,i.name,i.GoodsId order by i.GoodsId desc")->asArray()->all();
            $types = array();
            foreach ($typesarray as $key => $value) {
                $goodsid = $value["GoodsId"];
                $temp = array();
                if (array_key_exists($goodsid, $types)) {
                    $temp = $types[$goodsid];
                }
                $temp[] = ["itemid" => $value["itemid"], "name" => $value["name"], "sale" => empty($value["amount"]) ? 0 : $value["amount"], "costprice" => $value["costprice"], "data" => $value["Data"]];
                $types[$goodsid] = $temp;
            }

            //total
            $total = 0;
            $totalarray = ActiveRecord::findBySql("select count(1) as count from goods_info_base  " . $where)->asArray()->all();
            $sql = "select *, (select ifnull(sum(amount),0) from goods_stat_sale where GoodsId=goods_info_base.id) as amount from goods_info_base " . $where . " order by id desc limit " . ($pageIndex - 1) * $pageSize . "," . $pageSize;


            $res = ActiveRecord::findBySql($sql)->asArray()->all();
            //获取商品id
            $ids = [];
            foreach ($res as $val) {
//                $ids.="'".$val["id"]."',";
                array_push($ids, "'" . $val["Id"] . "'");
            }
            $sellData=[];
            if(!empty($ids)){
                $sql = "select goods_stat_sale.* from goods_stat_sale  left join goods_info_base on `goods_stat_sale`.`GoodsId`=goods_info_base.`Id` where goods_stat_sale.`GoodsId`  in  (" . implode(",", $ids) . ")";
                $sellData = ActiveRecord::findBySql($sql)->asArray()->all();
            }

            $data = array();
            $i = 1;
            foreach ($totalarray as $key => $value) {
                $total = $value["count"];
            }
            foreach ($res as $key => $value) {
                $item = array();
                $item["num"] = $i;
                $item["id"] = is_null($value["Id"]) ? "" : $value["Id"];
                $item["name"] = is_null($value["Name"]) ? "" : $value["Name"];
                $item["merchantname"] = "";
                if (array_key_exists($value["MerchantId"], $merchant)) {
                    $item["merchantname"] = $merchant[$value["MerchantId"]];
                }
                $item["categoryname"] = "";
                if (array_key_exists($value["CategoryId"], $category)) {
                    $item["categoryname"] = $category[$value["CategoryId"]];
                }
                $item["total"] = array_key_exists("total", $value) ? $value["total"] : "";
                $item["amount"] = array_key_exists("amount", $value) ? $value["amount"] : "";
                $item["lastopuser"] = array_key_exists("lastopuser", $value) ? $value["lastopuser"] : "";
                $item["starttime"] = array_key_exists("starttime", $value) ? $value["starttime"] : "";
                $item["endtime"] = array_key_exists("endtime", $value) ? $value["endtime"] : "";


                if (array_key_exists($item["id"], $types)) {
                    $temp = $types[$item["id"]];
                    $item["data"] = $temp;
                } else {
                    $item["data"] = array();
                }
                array_push($data, $item);
                $i++;
            }
            $result["total"] = $total;
            $result["data"] = $data;
            $result["goods_sell_data"] = empty($sellData) ? [] : $sellData;
            $result["state"] = 0;
            $this->jsonReturn($result);
        } catch (Exception $e) {
            $data["state"] = -1;
            $data["msg"] = $e->getMessage();
            $data["total"] = 0;
            $this->jsonReturn($data);
        }
    }

    /**
     * 获取七牛key
     */
    public function actionGetqiniukey()
    {
        $token = "";
        $privatekey = '0xOWPxOtXev3#$sCC4AxSoSJpr4LCY4b';//session("privatekey");
        $api = new BaseApi();
        $url = $api->getUrl("/resource/token", [], $token, $privatekey);
        $res = $api->curl($url, []);
        $this->jsonReturn(json_decode($res));
    }

    public function actionSavegood()
    {
        $id = urldecode($this->getParam("id"));
        $merchantid = urldecode($this->getParam("merchantid"));
        $categoryid = urldecode($this->getParam("categoryid"));
        $logictype = urldecode($this->getParam("logictype"));
        $name = urldecode($this->getParam("name"));
        $title = urldecode($this->getParam("title"));
        $expresstype = urldecode($this->getParam("expresstype"));
        $initamount = urldecode($this->getParam("initamount"));
        $originalprice = urldecode($this->getParam("originalprice"));
        $saleprice = urldecode($this->getParam("saleprice"));
        $shophours = urldecode($this->getParam("shophours"));
        $tel = urldecode($this->getParam("tel"));
        $lat = urldecode($this->getParam("lat"));
        $lng = urldecode($this->getParam("lng"));
        $address = urldecode($this->getParam("address"));
        $tips = urldecode($this->getParam("tips"));
        $orderdesctemp = urldecode($this->getParam("orderdesctemp"));
        $starttime = urldecode($this->getParam("starttime"));
        if (!$starttime) {
            $starttime = "2099-1-1";
        }
        $endtime = urldecode($this->getParam("endtime"));
        if (!$endtime) {
            $endtime = "2099-1-1";
        }
        $memberdiscounttype = urldecode($this->getParam("memberdiscounttype"));
        $memberdiscountval = $memberdiscounttype == "0" ? 0 : urldecode($this->getParam("memberdiscountval"));
        $existsdetail = urldecode($this->getParam("existsdetail"));
        $lb = urldecode($this->getParam("lb"));
        $xj = urldecode($this->getParam("xj"));
        $spxq = urldecode($this->getParam("spxq"));
        $cpts = urldecode($this->getParam("cpts"));
        $subgoodtypes = urldecode($this->getParam("subgoodtypes"));
        try {
            $res = ActiveRecord::findBySql("select * from goods_info_base where `id`='$id' or `name`='$name'")->asArray()->all();
            if ($res) {
                foreach ($res as $key => $value) {
                    $_id = $value["Id"];
                    $_name = $value["Name"];
                    if ($_id == $id) {
                        $data["state"] = -1;
                        $data["msg"] = "商品ID号重复！";
                        $this->jsonReturn($data);
                        return;
                    }
                    if ($_name == $name) {
                        $data["state"] = -1;
                        $data["msg"] = "商品名称重复！";
                        $this->jsonReturn($data);
                        return;
                    }
                }
            }
            $user = Yii::$app->getUser()->getId();
            $sql = "insert into goods_info_base(`id`,MerchantId,CategoryId,LogicType,`name`,`title`,ExpressType,InitAmount,OriginalPrice,SalePrice,ShopHours,Tel,Lat,lng,Address,Tips,RowTime,LastOpUser,LastOpTime,OrderDescTemp,StartTime,EndTime,MemberDiscountType,MemberDiscountVal,ExistsDetail,Total)
                                         values('$id','$merchantid','$categoryid','$logictype','$name','$title','$expresstype','$initamount','$originalprice','$saleprice','$shophours','$tel','$lat','$lng','$address','$tips',now(),'$user',now(),'$orderdesctemp','$starttime','$endtime','$memberdiscounttype','$memberdiscountval','$existsdetail',0)";
            $r = yii::$app->getDb()->createCommand($sql)->execute();
            if ($r) {
                yii::$app->getDb()->createCommand("insert into goods_info_img(`GoodsId`,`Type`,`Order`,`Url`) values('$id','1','1','$lb')")->execute();
                yii::$app->getDb()->createCommand("insert into goods_info_img(`GoodsId`,`Type`,`Order`,`Url`) values('$id','2','2','$xj')")->execute();
                yii::$app->getDb()->createCommand("insert into goods_info_img(`GoodsId`,`Type`,`Order`,`Url`) values('$id','3','3','$spxq')")->execute();
                yii::$app->getDb()->createCommand("insert into goods_info_img(`GoodsId`,`Type`,`Order`,`Url`) values('$id','4','4','$cpts')")->execute();
                //保存商品型号
                $GoodsTypeArr = json_decode($subgoodtypes);
                for ($index = 0; $index < count($GoodsTypeArr); $index++) {
                    $item = $GoodsTypeArr[$index];
                    yii::$app->getDb()->createCommand("insert into goods_info_item(`GoodsId`,`Name`,`Total`,`CostPrice`) values('$id','$item->typename','0','$item->realPrice')")->execute();
                }
            }
            $data["state"] = ($r ? 0 : -1);
            $data["id"] = $r;
            $this->jsonReturn($data);
        } catch (Exception $e) {
            $data["state"] = -1;
            $data["msg"] = $e->getMessage();
            $this->jsonReturn($data);
        }

    }

    /**
     *
     */
    public function actionUpdate()
    {

        $id =$this->getParam("id");
        $res = ActiveRecord::findBySql("select * from goods_info_base where id='$id'")->asArray()->all();
        if (empty($res)) {
            return "该商品,不存在";
        }
        $data = $this->getPageDataWhenAddOrUpdate();
        return $this->renderPartial("update", [
            "data" => $res,
            "category" => $data["category"],
            "merchant" => $data["merchant"],
            "sms" => $data["sms"]

        ]);
    }
    public function actionListgood(){
        $id =$this->getParam("id");
        try {
             $r=   ActiveRecord::findBySql("select * from goods_info_base where id='$id'")->asArray()->all();
            $msg= ActiveRecord::findBySql("select * from goods_info_msgdef where GoodsId='$id'")->asArray()->all();
            $itemList=ActiveRecord::findBySql("select * from goods_info_item where GoodsId='$id'")->asArray()->all();
            $imgList=ActiveRecord::findBySql("select * from goods_info_img where GoodsId='$id'")->asArray()->all();
            $share=ActiveRecord::findBySql("select * from goods_info_share where GoodsId='$id'")->asArray()->all();
            $controls=ActiveRecord::findBySql("select * from goods_info_control where GoodsId='$id'")->asArray()->all();

            $data["state"] = !$r?-1:0;
            $data["data"]=$r;
            $data["msg"]=$msg;
            $data["share"]=empty($share)?"":$share;
            $data["item_list"]=empty($itemList)?[]:$itemList;
            $data["img_list"]=empty($imgList)?[]:$imgList;
            $data["controls"]=empty($controls)?[]:$controls;
            $this->jsonReturn($data);
        } catch (Exception $e) {
            return  $e->getMessage();
        }
    }
    public function actionUpdatebasenfo(){

        $id = urldecode($this->getParam("id"));
        $merchantid = urldecode($this->getParam("merchantid"));
        $categoryid = urldecode($this->getParam("categoryid"));
        $logictype = urldecode($this->getParam("logictype"));
        $name = urldecode($this->getParam("name"));
        $title = urldecode($this->getParam("title"));
        $expresstype = urldecode($this->getParam("expresstype"));
        $initamount = urldecode($this->getParam("initamount"));
        $originalprice = urldecode($this->getParam("originalprice"));
        $saleprice = urldecode($this->getParam("saleprice"));
        $shophours = urldecode($this->getParam("shophours"));
        $tel = urldecode($this->getParam("tel"));
        $lat = urldecode($this->getParam("lat"));
        $lng = urldecode($this->getParam("lng"));
        $address = urldecode($this->getParam("address"));
        $tips = urldecode($this->getParam("tips"));
        $orderdesctemp = urldecode($this->getParam("orderdesctemp"));
        $memberdiscounttype = urldecode($this->getParam("memberdiscounttype"));
        $memberdiscountval = $memberdiscounttype=="0"?0:urldecode($this->getParam("memberdiscountval"));
        $existsdetail = urldecode($this->getParam("existsdetail"));
        $lb=urldecode($this->getParam("lb"));
        $xj=urldecode($this->getParam("xj"));
        $spxq=urldecode($this->getParam("spxq"));
        $cpts=urldecode($this->getParam("cpts"));
        $subgoodtypes=urldecode($this->getParam("subgoodtypes"));
        try {
            $res=ActiveRecord::findBySql("select * from goods_info_base where `id`='$id'")->asArray()->all();
            if (!$res) {
                $data["state"] = -1;
                $data["msg"] = "商品不存在！";
                $this->jsonReturn($data);
                return;

            }
            $user =  Yii::$app->getUser()->getId();
            $r=Yii::$app->getDb()->createCommand("update goods_info_base set MerchantId='$merchantid',CategoryId='$categoryid',LogicType='$logictype',`name`='$name',title='$title',ExpressType='$expresstype',
                                                  InitAmount='$initamount',OriginalPrice='$originalprice',SalePrice='$saleprice',
                                                  ShopHours='$shophours',Tel='$tel',Lat='$lat',lng='$lng',
                                                  Address='$address',Tips='$tips',RowTime=now(),LastOpUser='$user',
                                                  LastOpTime=now(),OrderDescTemp='$orderdesctemp',MemberDiscountType='$memberdiscounttype',
                                                  MemberDiscountVal='$memberdiscountval',ExistsDetail='$existsdetail'
                                                  where id='$id'")->execute();

            Yii::$app->getDb()->createCommand("update goods_info_img set Url='$lb' where GoodsId='$id' and Type='1'")->execute();
            //保存图片
            Yii::$app->getDb()->createCommand("update goods_info_img set Url='$xj' where GoodsId='$id' and Type='2'")->execute();
            Yii::$app->getDb()->createCommand("update goods_info_img set Url='$spxq' where GoodsId='$id' and Type='3'")->execute();
            Yii::$app->getDb()->createCommand("update goods_info_img set Url='$cpts' where GoodsId='$id' and Type='4'")->execute();
            //保存商品型号
            //清空商品型号
            Yii::$app->getDb()->createCommand("delete from goods_info_item where GoodsId='$id'")->execute();
            $GoodsTypeArr=json_decode($subgoodtypes);
            for($index=0;$index<count($GoodsTypeArr);$index++){
                $item=$GoodsTypeArr[$index];
                if(is_numeric($item->itemId)){
                    Yii::$app->getDb()->createCommand("insert into goods_info_item(`Id`,`GoodsId`,`Name`,`Total`,`CostPrice`) values('$item->itemId','$id','$item->typename','0','$item->realPrice')")->execute();
                }else{
                    Yii::$app->getDb()->createCommand("insert into goods_info_item(`GoodsId`,`Name`,`Total`,`CostPrice`) values('$id','$item->typename','0','$item->realPrice')");
                }
            }
            $data["state"] = 0;
            $this->jsonReturn($data);
        } catch (Exception $e) {
            $data["state"] = -1;
            $data["msg"] = $e->getMessage();
            $this->jsonReturn($data);
        }
    }
    public function actionUpdategood(){
        try {
            $this->updateOrderDescTemp();
            $this->updateMsgAndPublishTime();
            $this->updateShareContent();
            $this->updateControls();
            $data["state"] =0;
            $this->jsonReturn($data);
        } catch (Exception $e) {
            $data["state"] = -1;
            $data["msg"] = $e->getMessage();
            $this->jsonReturn($data);
        }
    }
    private function updateOrderDescTemp(){
        $id = urldecode($this->getParam("id"));
        $descTemp=$this->getParam("orderdesctemp");
        yii::$app->getDb()->createCommand("update goods_info_base set OrderDescTemp='$descTemp' where id='$id'")->execute();

    }
    private function updateControls(){
        $id = urldecode($this->getParam("id"));
        $controls=json_decode($this->getParam("control"));
        if(!is_array($controls)){
            return;
        }
        //清空控件
        yii::$app->getDb()->createCommand("delete from goods_info_control where GoodsId='$id'")->execute();
        for($index=0;$index<count($controls);$index++){
            $item=$controls[$index];
            $ControlType=$item->ControlType;
            $Data=json_encode($item,JSON_UNESCAPED_UNICODE);
            $Order=$item->Order;
            yii::$app->getDb()->createCommand("insert into goods_info_control(`GoodsId`,`ControlType`,`Data`,`Order`) values('$id','$ControlType','$Data','$Order')")->execute();
            $this->handlerControl($id,$item);
        }
    }
    private function handlerControl($id,$item){
        if($item->ControlType=="10102"){
            //计算总库存
            $total=0;
            foreach($item->Items as $val){
                if(count($val->Prices)==0){
                    $total+=$val->DefaultTotal;
                    continue;
                }
                $tempTotal=$this->getTotal($val);
                $total+=$tempTotal;
            }
            yii::$app->getDb()->createCommand("update goods_info_base set Total=$total where Id='$id'")->execute();
        }

    }
    private function getTotal($val){
        $total=0;
        foreach($val->Prices as $price){
            $total+=$price->Total;
        }
        return $total;
    }
    private function updateMsgAndPublishTime(){
        $id = urldecode($this->getParam("id"));
        $starttime = urldecode($this->getParam("starttime"));
        $endtime = urldecode($this->getParam("endtime"));
        $msgtailofmerchant=urldecode($this->getParam("msgtailofmerchant"));
        $msgtailofuser=urldecode($this->getParam("msgtailofuser"));
        $smstempid=urldecode($this->getParam("smstempid"));
        $user =  Yii::$app->getUser()->getId();
        $r=Yii::$app->getDb()->createCommand("update goods_info_base set starttime='$starttime',endtime='$endtime',LastOpUser='$user',LastOpTime=now() where id='$id'")->execute();
        $msgarray= ActiveRecord::findBySql("select count(1) as `count` from goods_info_msgdef where goodsid='$id'")->asArray()->all();
        foreach ($msgarray as $key => $value) {
            if($value["count"]==0){
                Yii::$app->getDb()->createCommand("insert into goods_info_msgdef(GoodsId,MsgTailOfMerchant,MsgTailOfUser) values('$id','$msgtailofmerchant','$msgtailofuser') ")->execute();
            }
            else{
                Yii::$app->getDb()->createCommand("update goods_info_msgdef set MsgTailOfMerchant='$msgtailofmerchant',MsgTailOfUser='$msgtailofuser',SmsTempId='$smstempid' where goodsid='$id'")->execute();
            }
            break;
        }
    }
    private function updateShareContent(){
        $id = urldecode($this->getParam("id"));
        $shareimg=$this->getParam("shareimg");
        $sharetitle=$this->getParam("sharetitle");
        $sharecontent=$this->getParam("sharecontent");
        //清空分享内容
        Yii::$app->getDb()->createCommand("delete from goods_info_share where GoodsId='$id'")->execute();
        Yii::$app->getDb()->createCommand("insert into goods_info_share(`GoodsId`,`Title`,`Content`,`Img`) values('$id','$sharetitle','$sharecontent','$shareimg')")->execute();
    }
    public  function actionControl(){
        return $this->renderPartial("control");
    }
    public function actionCategory(){
        return $this->renderPartial("category");
    }
    /**
     * 类目管理
     */
    public function actionSavecategory(){
        $id=urldecode($this->getParam("id"));
        $name=urldecode($this->getParam("name"));
        try{
            $res=ActiveRecord::findBySql("select * from goods_category where `Id`='$id' or `Name`='$name'")->asArray()->all();
            if($res){
                $_id= "";
                $_name="";
                foreach ($res as $key => $value) {
                    $_id=$value["Id"];
                    $_name=$value["Name"];
                }
                if($_id==$id) {
                    $data["state"]=-1;
                    $data["msg"]="频道ID重复！";
                    $this->ajaxReturn($data);
                    return;
                }
                if($_name==$name) {
                    $data["state"]=-1;
                    $data["msg"]="频道名称重复！";
                    $this->ajaxReturn($data);
                    return;
                }
            }

            $user=yii::$app->getUser()->getId();
           $r= yii::$app->getDb()->createCommand("insert into goods_category(`id`,`name`,RowTime,LastOpUser,LastOpTime) values('$id','$name',now(),'$user',now())")->execute();
            $data["state"]=($r ? 0 : -1);
            $this->jsonReturn($data);
        }catch(Exception $e){
            $data["state"]=-1;
            $data["msg"]=$e->getMessage();
            $this->jsonReturn($data);
        }
    }
    public function actionMark(){
        return $this->renderPartial("mark");
    }
}