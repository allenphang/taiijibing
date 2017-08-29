<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/25
 * Time: 11:15
 */

use feehi\widgets\ActiveForm;

$this->title = "";
?>
<style>
    *{
        margin:0px;
        padding:0px;

    }


</style>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox">
            <?= $this->render('/widgets/_ibox-title') ?>
            <div class="ibox-content">
                <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data','class'=>'form-horizontal']]); ?>
                <?= $form->field($model["model"], 'Name')->textInput(['maxlength' => 64]) ?>
                <div class="hr-line-dashed"></div>
                <?= $form->field($model["model"], 'ContractTel')->textInput(['maxlength' => 11]) ?>
                <div class="hr-line-dashed"></div>
                <?= $form->field($model["model"], 'ContractUser')->textInput(['maxlength' => 64]) ?>
                <div class="hr-line-dashed"></div>
                <?= $form->field($model["model"], 'PreCode')->textInput(['maxlength' => 64]) ?>


                <div class="hr-line-dashed"></div>
                <div class="form-group field-adminroleuser-role_id required">
                    <label class="col-sm-2 control-label" for="adminroleuser-role_id">水品牌</label>
                    <div class="col-sm-10">
                        <div id="adminroleuser-role_id" class="radio" aria-required="true">
                            <select class="form-control" name="FactoryInfo[WaterBrandNo]" id="fac_brandno">
                               <?php
                                    foreach($model["waterlist"] as $val){
                                        echo "<option value='".$val["BrandNo"]."'>".$val["BrandName"]."</option>";
                                    }
                               ?>
                            </select>
                        </div>
                        <div class="help-block m-b-none"></div></div>
                </div>

                <div class="hr-line-dashed"></div>
                <div class="form-group field-adminroleuser-role_id required">
                    <label class="col-sm-2 control-label" for="adminroleuser-role_id">代理级别</label>
                    <div class="col-sm-10">
                        <div id="adminroleuser-role_id" class="radio" aria-required="true">
                            <select class="form-control" name="FactoryInfo[Level]" id="factory_level">
                                <option value="1">国际</option>
                                <option value="2">全国</option>
                                <option value="3">省级</option>
                                <option value="4">地区级</option>
                            </select>
                        </div>
                        <div class="help-block m-b-none"></div></div>
                </div>
                <!--地址-->
                <div class="hr-line-dashed"></div>
                <div class="form-group field-adminroleuser-role_id required">
                    <label class="col-sm-2 control-label" for="adminroleuser-role_id">地址</label>
                    <div class="col-sm-10">
                        <select class="control-label" name="FactoryInfo[Province]" id="province">
                            <option value="">请选择</option>
                        </select>
                        <select class="control-label" name="FactoryInfo[City]" id="city">
                            <option value="">请选择</option>
                        </select>
                        <select class="control-label" name="FactoryInfo[Area]" id="area">
                            <option value="">请选择</option>
                        </select>
                    </div>
                </div>
                <!--地址 end-->
                <div class="hr-line-dashed"></div>
                <div class="form-group field-adminroleuser-role_id required">
                    <div class="ftitle"><span class="col-sm-2 control-label"> 标记位置：</span></div>
                    <div class="fcontent">
                        <input id="address" type="text" class="baseinput" name="FactoryInfo[Address]">
                        <input type="button" class="btn select_btn" style="height: 26px;margin-bottom: 5px;line-height: 15px;margin-left: 15px" value="+标记位置" onclick="openMark()">
                        <span>经度：</span>
                        <input id="lng" type="text" class="baseinput" style="width: 80px" name="FactoryInfo[BaiDuLng]">
                        <span>纬度：</span>
                        <input id="lat" type="text" class="baseinput" style="width: 80px" name="FactoryInfo[BaiDuLat]">
                    </div>
                </div>
                <div  style="position:fixed;top:0px;left:0px;width:100%;height:100%;z-index:9999;display:none;" id="mapContainer">
                    <div style="position:fixed;right:10px;top:10px;z-index:999999;"><input type="button" class="btn btn-primary" value="确定" onclick="sureLocation();"/>&nbsp;&nbsp;<input type="button" class="btn btn-primary" value="取消" onclick="hideMark();"/></div>
                    <div id="map"></div>
                </div>

                <?= $form->defaultButtons() ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
    <input type="hidden" id="brandno" value="<?=$model["model"]["WaterBrandNo"]?>"/>
    <input type="hidden" id="fac_level" value="<?=$model["model"]["Level"]?>"/>
</div>


<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.4"></script>
<script>
    var data=<?=$model["data"]?>;
    var province='<?=$model["model"]["Province"]?>';
    var city='<?=$model["model"]["City"]?>';
    var area='<?=$model["model"]["Area"]?>';

    var geoc;
    var cur;
    var map;
    var address='<?=empty($model["model"]["Address"])?"":$model["model"]["Address"]?>';
    var baiDuLat='<?=empty($model["model"]["Address"])?"":$model["model"]["BaiDuLat"]?>';
    var baiDuLng='<?=empty($model["model"]["Address"])?"":$model["model"]["BaiDuLng"]?>';
</script>
<script type="text/javascript" src="./static/js/jquery.min.js"></script>
<script>
    $(function(){
        var brandno=$("#brandno").val();
        var fac_level=$("#fac_level").val();

        $("#fac_brandno").val(brandno);
        $("#factory_level").val(fac_level);
        initProvince();
        initListener();
        initAddress();
        initMap();
    });
    function openMark(){
        if ($("#address").val() != "") {
            geoc.getPoint($("#address").val(), function (point) {
                if (point) {
                    map.centerAndZoom(point, 13);
                    map.addOverlay(new BMap.Marker(point));
                    cur = point;
                } else {
                    alert("您选择地址没有解析到结果!");

                }
            }, "成都市");
        }
        //监听点击地图事件
        map.addEventListener("click", function (e) {
            cur= e.point;
            getCircle(cur);
        });


        //创建标注点函数
        function getCircle(point) {
            map.clearOverlays();
            marker = new BMap.Marker(point);
            map.addOverlay(marker);
        }

        $("#mapContainer").show();
    }
    function hideMark(){
        $("#mapContainer").hide();
    }
    function  sureLocation(){
        if(cur==null){
            alert("请先标注点！");
            return;
        }
        $("#lat").val(cur.lat);
        $("#lng").val(cur.lng);
        hideMark();
    }
    function initMap(){
       $("#address").val(address);
        $("#lat").val(baiDuLat);
        $("#lng").val(baiDuLng);


         map = new BMap.Map("map");
         geoc = new BMap.Geocoder();
        map.enableScrollWheelZoom(); //可滑动
        map.addControl(new BMap.NavigationControl()); //导航条
        var point = new BMap.Point(104.067923, 30.679943); //成都市(116.404, 39.915);
        map.centerAndZoom(point, 13);
        $("#map").css({"height":"100%"});
    }
    function initAddress(){
        $("#province").val(province);
        initCityOnProvinceChange();
        $("#city").val(city);
        initThree();
        $("#area").val(area);
    }
    function getAddressIdByName(_name){
        _name= $.trim(_name);
        if(_name==""){
            return 0;
        }
        for(var index=0;index<data.length;index++){
            var item=data[index];
            var name= $.trim(item.Name);
            if(name!=""&&name==_name){
                return item.Id;
            }
        }
        return 0;
    }
    function initListener(){
        $("#province").on("change",function(){
            initCityOnProvinceChange();
        });
        $("#city").on("change",function(){
            initThree();
        });
    }
    function initCityOnProvinceChange(){
        var pid=getAddressIdByName($("#province").val());
        $("#city").empty();
        $("#city").append("<option value=''>请选择</option>");
        if(pid==0){
            return;
        }
        for(var index=0;index<data.length;index++){
            var item=data[index];
            if(item.PId!=0&&item.PId==pid){
                $("#city").append("<option value='"+item.Name+"'>"+item.Name+"</option>");
                initThree()
            }
        }
    }
    function initThree(){
        var pid=getAddressIdByName($("#city").val());
        $("#area").empty();
        $("#area").append("<option value=''>请选择</option>");
        if(pid==0){
            return;
        }
        for(var index=0;index<data.length;index++){
            var item=data[index];
            if(item.PId!=0&&item.PId==pid){
                $("#area").append("<option value='"+item.Name+"'>"+item.Name+"</option>");
            }
        }
    }
    function initProvince(){
        for(var index=0;index<data.length;index++){
            var item=data[index];
            if(item.PId==0){
                $("#province").append("<option value='"+item.Name+"'>"+item.Name+"</option>");
            }
        }
    }


</script>
