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

                <!--地址-->
                <div class="hr-line-dashed"></div>
                <div class="form-group field-adminroleuser-role_id required">
                    <label class="col-sm-2 control-label" for="adminroleuser-role_id">地址</label>
                    <div class="col-sm-10">
                        <select class="control-label" name="AgentInfo[Province]" id="province">
                            <option value="">请选择</option>
                        </select>
                        <select class="control-label" name="AgentInfo[City]" id="city">
                            <option>请选择</option>
                        </select>
                        <select class="control-label" name="AgentInfo[Area]" id="area">
                            <option>请选择</option>
                        </select>
                    </div>
                </div>
                <!--地址 end-->
                <!--百度标注-->
                <div class="hr-line-dashed"></div>
                <div class="form-group field-adminroleuser-role_id required">
                    <div class="ftitle"><span class="col-sm-2 control-label"> 标记位置：</span></div>
                    <div class="fcontent">
                        <input id="address" type="text" class="baseinput" name="AgentInfo[Address]">
                        <input type="button" class="btn select_btn" style="height: 26px;margin-bottom: 5px;line-height: 15px;margin-left: 15px" value="+标记位置" onclick="openMark()">
                        <span>经度：</span>
                        <input id="lng" type="text" class="baseinput" style="width: 80px" name="AgentInfo[BaiDuLng]">
                        <span>纬度：</span>
                        <input id="lat" type="text" class="baseinput" style="width: 80px" name="AgentInfo[BaiDuLat]">
                    </div>
                </div>
                <div  style="position:fixed;top:0px;left:0px;width:100%;height:100%;z-index:9999;display:none;" id="mapContainer">
                    <div style="position:fixed;right:10px;top:10px;z-index:999999;"><input type="button" class="btn btn-primary" value="确定" onclick="sureLocation();"/>&nbsp;&nbsp;<input type="button" class="btn btn-primary" value="取消" onclick="hideMark();"/></div>
                    <div id="map"></div>
                </div>
                <!--百度标注-->
                <div class="hr-line-dashed"></div>
                <div class="form-group field-adminroleuser-role_id required">
                    <label class="col-sm-2 control-label" for="adminroleuser-role_id">代理类型</label>
                    <div class="col-sm-10">
                        <div id="adminroleuser-role_id" class="radio" aria-required="true">
                            <div class="radio radio-info radio-inline"><input id="User[role_id]1" type="radio"  name="AgentInfo[Level]" value="4" <?=$model["model"]["Level"]==4?"checked":""?>><label for="User[role_id]1">县区运营中心</label></div>
                            <div class="radio radio-info radio-inline"><input id=User[role_id]2" type="radio"  name="AgentInfo[Level]" value="5" <?=$model["model"]["Level"]!=4?"checked":""?>><label for="User[role_id]2">社区服务中心</label></div>
                        </div>
                        <div class="help-block m-b-none"></div></div>
                </div>
                <div id="lowerAgent" style="display:none;">
                    <div class="hr-line-dashed"></div>
                    <div class="form-group field-adminroleuser-role_id required">
                        <label class="col-sm-2 control-label" for="adminroleuser-role_id">下级代理商</label>
                        <div class="col-sm-10">
                            <div id="adminroleuser-role_id" class="radio" aria-required="true">
                                <select class="form-control" name="AgentInfo[childid]" id="childId">
                                    <?php
                                        foreach($model["sArr"] as $val){
                                            echo " <option value='".$val["Id"]."'>".$val["Name"]."</option>";
                                        }
                                    ?>

                                </select>
                            </div>
                            <div class="help-block m-b-none"></div></div>
                    </div>

                </div>
                <div id="upperAgent" style="display:none;">
                    <div class="hr-line-dashed"></div>
                    <div class="form-group field-adminroleuser-role_id required">
                        <label class="col-sm-2 control-label" for="adminroleuser-role_id">上级代理商</label>
                        <div class="col-sm-10">
                            <div id="adminroleuser-role_id" class="radio" aria-required="true">
                                <select class="form-control"  name="AgentInfo[ParentId]" id="parentId">
                                    <?php
                                    foreach($model["qArr"] as $val){
                                        echo " <option value='".$val["Id"]."'>".$val["Name"]."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="help-block m-b-none"></div></div>
                    </div>
                </div>
                <input type="hidden" id="mode_pid" value="<?= empty($model["model"]["ParentId"])?"":$model["model"]["ParentId"]?>"/>
                <input type="hidden" id="mode_cid" value="<?= empty($model["lower_agent"]["Id"])?"":$model["lower_agent"]["Id"] ?>"/>
            <div class="hr-line-dashed"></div>
                <?= $form->defaultButtons() ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="./static/js/jquery.min.js"></script>
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
<script type="text/javascript">
    $(function(){
        $("input[name='AgentInfo[Level]']").on("click",function(){
            updateWhenAgentTypeChange();
        });
        initMap();
        updateWhenAgentTypeChange();
        initSelect();
        initProvince();
        initListener();
        initAddress();
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

    function initSelect(){
        var value=  $("input[name='AgentInfo[Level]']:checked").val();
        if(value==5){
            var pid=$("#mode_pid").val();
            if(pid==""){
                return;
            }
            $("#parentId").val(pid);
            return;
        }
        var cid=$("#mode_cid").val();
        if(cid==""){
            return;
        }
        $("#childId").val(cid);

    }
    function updateWhenAgentTypeChange(){
        var value=  $("input[name='AgentInfo[Level]']:checked").val();
        if(value==4){
            showLowerAgent();
        }else{
            showUpperAgent();
        }
    }
    function showLowerAgent(){
        $("#lowerAgent").show();
        $("#upperAgent").hide();
    }
    function showUpperAgent(){
        $("#lowerAgent").hide();
        $("#upperAgent").show();
    }
</script>