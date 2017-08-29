<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>附近服务店</title>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="/favicon.ico">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <link rel="stylesheet" href="./static/css/sm.min.css">
    <link rel="stylesheet" href="./static/css/sm-extend.min.css">
    <link rel="stylesheet" href="./static/css/index.css">
<style>

    #address{
        background-image:url("./static/images/location1.png");
        background-repeat: no-repeat;
        background-size:11px 15px ;
        background-position:4px center;
        padding-left:20px;
    }

    #search_content{
        background-image:url("./static/images/search.png");
        background-repeat:no-repeat;
        background-size:19px 21px ;
        background-position:2px center;
        padding-left:20px;
    }

    input::-webkit-input-placeholder { /* WebKit browsers */
        color:#B2B2B2;
    }


</style>

</head>
<body style="position: relative;overflow: auto;">

<header class="site" style=" width:100%;height:50px;position: fixed;top:0px;left:0;z-index: 99;background: url('./static/images/search_background.png') no-repeat">
    <div style="text-align:center;margin-top: 10px;margin-left: 6%"><input type="text" placeholder="未定位" id="address" style="height:30px;border: solid #B2B2B2 1px; color:#B2B2B2;width:100px;border-radius:6px;" readonly/><input type="text" placeholder="输入商家名称" style="height:30px;border: solid #B2B2B2 1px;width:150px;border-radius:6px;margin-left: 15px" id="search_content"/><input onclick="search()" type=button style="height:30px;border: solid #B2B2B2 1px;width:50px;border-radius:6px;margin-left: 15px" value="搜索" /></div>
</header>
<div class="content shop-content" style="margin-top: 30px;">
    
    <div class="list-block media-list">

        <p class="shop-title " style="margin-top:10px;border-bottom:solid #e6e6e6 1px">常用门店</p>
        <ul id="changyong">
            <!--常用门店信息-->
        </ul>

        <p class="shop-title" style="border-bottom:solid #e6e6e6 1px">离我最近</p>
        <ul id="list">
            <!--离我最近门店信息-->
        </ul>
    </div>

</div>

<script type='text/javascript' src='./static/js/zepto.min.js' charset='utf-8'></script>
<script type='text/javascript' src='./static/js/sm.min.js' charset='utf-8'></script>
<script type='text/javascript' src='./static/js/sm-extend.min.js' charset='utf-8'></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=FCBpETlN4Snp2SfEl92y89WF"></script>
<script type="text/javascript" src="http://developer.baidu.com/map/jsdemo/demo/convertor.js"></script>

<script>

    var lat='';
    var lng='';

    $(function(){




        //获取所在位置的坐标
        var geolocation = new BMap.Geolocation();

        geolocation.getCurrentPosition(function(r){
            if(this.getStatus() == BMAP_STATUS_SUCCESS){
                lng=r.point.lng;
                lat=r.point.lat;

            }

            if(lng==null || lat==null){
                alert('请开启定位功能');
            }else{
                //根据经纬度获取位置信息
                setTimeout(function () {
                    var gpsPoint = new BMap.Point(lng, lat);
                    BMap.Convertor.translate(gpsPoint, 0, function (point) {
                        var geoc = new BMap.Geocoder();
                        geoc.getLocation(point, function (rs) {

//                    map.addControl(new BMap.NavigationControl());
//                    map.addControl(new BMap.ScaleControl());
//                    map.addControl(new BMap.OverviewMapControl());
//                    map.centerAndZoom(point, 18);
//                    map.addOverlay(new BMap.Marker(point)) ;

                            var addComp = rs.addressComponents;
                            $('#address').val(addComp.district);
//                    alert(addComp.province + ", " + addComp.city + ", " + addComp.district + ", " + addComp.street + ", " + addComp.streetNumber);
//                    alert('您的位置：'+rs.point.lng+','+rs.point.lat);
                        });
                    });
                }, 1000);

//            alert('经度：'+lng+'维度：'+lat);

                initPage();
            }

        },{enableHighAccuracy: true});

    });


    //根据输入的商家名称获取数据
    function search(){
        var search_content=$('#search_content').val();

            //根据搜索内容获取数据
            $.get("index.php?r=shop/agent-list",{'search_content':search_content,'lng':lng,'lat':lat},function(data) {

                if (data.status == 0) {
                    alert(data.msg);
                    return;

                }
                if (data.status == -1) {
                    alert(data.msg);
                    return;

                }
                if (data.status == 1) {

                    //清空
                    $('#list').html('');

                    //将数据追加到页面
                    var html = '';
                    $.each(data.data, function (i, v) {

                        html += '<li">\
                                <a href="index.php?r=shop/get-goods&id=' + v.Id + '" class="item-link item-content" style="color:black；">\
                                <div class="item-media"><img src="http://7xpcl7.com2.z0.glb.qiniucdn.com/o_1bm7fff414h8m8510ck14ac1laur.jpg" style="width: 4rem;"></div>\
                                    <div id="fuhao" class="item-inner">\
                                        <span style="width: 5px;height: 9px; float: right;margin-top:20px"><img src="./static/images/go.png"></span>\
                                        <div class="item-title-row">\
                                            <div class="item-subtitle" style="font-size: 18px;color: #333">' + v.Name + '</div>\
                                        </div>\
                                            <div class="item-title" style="font-size: 14px;color: #6a6a6a">' + v.Address + '</div>\
                                        <div class="item-title" style="font-size: 14px"><img src="./static/images/location2.png" alt="" style="color: #6a6a6a;width: 11px;height: 14px"/> &nbsp;' + v.distance + 'km</div>\
                                    </div>\
                                </a>\
                        </li>';

                    });
                    $(html).appendTo('#list');

                }



            });

    }


    //初始化页面
    function initPage() {
//    alert('经度：'+lng+'维度：'+lat)
        //获取商家数据
        $.get("index.php?r=shop/agent-list",{'lat': lat ,'lng':lng}, function (data) {
            if(data.status==0){
                alert(data.msg);
                return;

            }
            if(data.status==-1){
                alert(data.msg);
                return;

            }
            if(data.status==1) {

                //将数据追加到页面
                var html = '';
                var num=1;
                $.each(data.data, function (i, v) {

                    html += '<li">\
                                <a href="index.php?r=shop/get-goods&id=' + v.Id + '" class="item-link item-content" style="color:black；">\
                                <div class="item-media"><img src="http://7xpcl7.com2.z0.glb.qiniucdn.com/o_1bm7fff414h8m8510ck14ac1laur.jpg" style="width: 4rem;"></div>\
                                    <div id="fuhao" class="item-inner">\
                                        <span style=" float: right;margin-top:20px"><img src="./static/images/go.png " style="width: 10px;height: 19px;"></span>\
                                        <div class="item-title-row">\
                                            <div class="item-subtitle" style="font-size: 18px;color: #333">' + v.Name + '</div>\
                                        </div>\
                                            <div class="item-title" style="font-size: 14px;color: #6a6a6a">' + v.Address + '</div>\
                                        <div class="item-title" style="font-size: 14px"><img src="./static/images/location2.png" alt="" style="color: #6a6a6a;width: 11px;height: 14px"/> &nbsp;' + v.distance + 'km</div>\
                                    </div>\
                                </a>\
                        </li>';

                    //添加一个常用门店（后面再改进）
                    if(num==1){
                        $(html).appendTo('#changyong');
                    }
                    num++;

                });

                $(html).appendTo('#list');
            }

        });
    }


</script>



</body>
</html>