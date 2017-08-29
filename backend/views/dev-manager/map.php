<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta itemprop="name" content="">
    <meta name="description" itemprop="description" content="">
    <style>
        body, html, #allmap {
            width: 100%;
            height: 100%;
            overflow: hidden;
            margin: 0;
            font-family: "微软雅黑";
        }
    </style>
</head>
<body>
<div
    style="position:fixed;right:10px;top:10px;z-index:999;background:#5f97ff;height:30px;line-height:30px;padding:0 10px;border-radius: 4px;opacity: 0.8;font-size:14px;">
    <span><input type="checkbox" class="usertype" usertype="1" id="water_f" checked/><label for="water_f">水厂</label></span>
    <span><input type="checkbox" class="usertype" usertype="2" id="agent_x" checked/><label
            for="agent_x">县区运营中心</label></span>
    <span><input type="checkbox" class="usertype" usertype="3" id="agent_f" checked/><label
            for="agent_f">社区服务中心</label></span>
    <span><input type="checkbox" class="usertype" usertype="4" id="dev_f" checked/><label for="dev_f">设备厂家</label></span>
    <span><input type="checkbox" class="usertype" usertype="5" id="custom_user" checked/><label for="custom_user">用户</label></span>
    <select class="control-label" name="DevFactory[Province]" id="province">
        <option value="" selected>请选择</option>
    </select>
    <select class="control-label" name="DevFactory[City]" id="city">
        <option value="">请选择</option>
    </select>
    <select class="control-label" name="DevFactory[Area]" id="area">
        <option value="">请选择</option>
    </select>
    <input type="button" class="btn" value="查询" style="margin-right:30px;" id="queryBtn"/>
    <a href="javascript:window.history.go(-1);" style="color:white;font-size:13px;text-decoration: none;">常规模式</a>
</div>
<div id="allmap"></div>
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=FCBpETlN4Snp2SfEl92y89WF"></script>
<script type="text/javascript" src="/static/js/layer/layer.js"></script>
<script>
    var data =<?=json_encode($address)?>;
    var map;

</script>
<script>
    $(function () {
        initMap();
        initProvince();
        initListener();
        initAddress();
        query();

    });
    function initMap(){
        map = new BMap.Map("allmap");
        var point = new BMap.Point(104.067923, 30.679943);
        map.centerAndZoom(point, 15);
    }
    function query() {
        var province = $("#province").val();
        var city = $("#city").val();
        var area = $("#area").val();
        if(province==null){
            province="";
        }
        if(city==null){
            city="";
        }
        if(area==null){
            area="";
        }
        var checkedTypes = $("input.usertype:checked");
        var arr = [];
        for (var index = 0; index < checkedTypes.length; index++) {
            var item = checkedTypes[index];
            arr.push($(item).attr("usertype"));
        }
        var usertype = arr.join(",");
        var ii=layer.msg("加载中……");
        $.getJSON("/index.php?r=dev-manager/get-markers&user_type=" + usertype + "&city=" + city + "&province=" + province + "&area=" + area, function (data) {
            layer.close(ii);
            map.clearOverlays();
            for (var index = 0; index < data.length; index++) {
                var item = data[index];
                var lat = Number(item.BaiDuLat);
                var lng = Number(item.BaiDuLng);
                if (index == 0) {
                    var point = new BMap.Point(lng, lat);
                    map.centerAndZoom(point, 15);
                }
                //创建小狐狸
                var pt = new BMap.Point(lng, lat);
                var img="";
                var myIcon = new BMap.Icon("/static/img/icon_"+item.user_type+".png", new BMap.Size(300, 157));
                var marker2 = new BMap.Marker(pt, {icon: myIcon});  // 创建标注

                map.addOverlay(marker2);
            }
        })
    }
    function initAddress() {
        initCityOnProvinceChange();
        initThree();
    }
    function getAddressIdByName(_name) {
        _name = $.trim(_name);
        if (_name == "") {
            return 0;
        }
        for (var index = 0; index < data.length; index++) {
            var item = data[index];
            var name = $.trim(item.Name);
            if (name != "" && name == _name) {
                return item.Id;
            }
        }
        return 0;
    }
    function initListener() {
        $("#province").on("change", function () {
            initCityOnProvinceChange();
        });
        $("#city").on("change", function () {
            initThree();
        });
        $("#queryBtn").on("click",function(){
            query();
        });
    }
    function initCityOnProvinceChange() {
        var pid = getAddressIdByName($("#province").val());
        $("#city").empty();
        $("#city").append("<option value='' selected>请选择</option>");
        if (pid == 0) {
            return;
        }
        for (var index = 0; index < data.length; index++) {
            var item = data[index];
            if (item.PId != 0 && item.PId == pid) {
                $("#city").append("<option value='" + item.Name + "'>" + item.Name + "</option>");
                initThree()
            }
        }
    }
    function initThree() {
        var pid = getAddressIdByName($("#city").val());
        $("#area").empty();
        $("#area").append("<option value='' selected>请选择</option>");
        if (pid == 0) {
            return;
        }
        for (var index = 0; index < data.length; index++) {
            var item = data[index];
            if (item.PId != 0 && item.PId == pid) {
                $("#area").append("<option value='" + item.Name + "'>" + item.Name + "</option>");
            }
        }
    }
    function initProvince() {
        for (var index = 0; index < data.length; index++) {
            var item = data[index];
            if (item.PId == 0) {
                $("#province").append("<option value='" + item.Name + "'>" + item.Name + "</option>");
            }
        }
    }
</script>
</body>
</html>

