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
        background-image:url("./static/images/search.jpg");
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

<header class="site" style="width:100%;height:40px;position: fixed;top:0px;left:0;z-index: 99;background: url('./static/images/search_background.png') no-repeat">
    <div style="margin-top: 10px;margin-left: 6%"><input type="text" placeholder="未定位" id="address" style="border: solid #B2B2B2 1px; color:#B2B2B2;width:100px;border-radius:6px;" readonly/><input type="text" placeholder="输入商家名称" style="width:150px;border-radius:6px;margin-left: 15px" id="search_content"/><input onclick="search()" type=button style="width:50px;border-radius:6px;margin-left: 15px" value="搜索" /></div>
</header>
<div class="content shop-content" style="margin-top: 30px;">

    <div class="list-block">


        <p class="shop-title">常用门店</p>
        <ul id="changyong">
            <!--常用门店信息-->
        </ul>

        <p class="shop-title">离我最近</p>
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

                        html += '<li class="item-content">\
                            <div class="item-media fl"><i class="icon icon-f7"><a href="index.php?r=shop/get-goods&id=' + v.Id + '"><img src="http://7xpcl7.com2.z0.glb.qiniucdn.com/o_1bm7fff414h8m8510ck14ac1laur.jpg"></a></i></div>\
                                <div class="item-inner item-inner2 fl">\
                                    <div class="item-title">\
                                        <a href="index.php?r=shop/get-goods&id=' + v.Id + '" class="item-name">' + v.Name + '</a>\
                                        <p class="item-info row_one">更优质的矿泉水</p>\
                                        <p class="item-info"><img src="./static/images/location2.png" alt=""/> &nbsp;' + v.distance + ' km</p>\
                                    </div>\
                            </div>\
                        </li>'

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

                    html += '<li class="item-content">\
                        <div class="item-media fl"><i class="icon icon-f7"><a href="index.php?r=shop/get-goods&id=' + v.Id + '"><img src="http://7xpcl7.com2.z0.glb.qiniucdn.com/o_1bm7fff414h8m8510ck14ac1laur.jpg"></a></i></div>\
                            <div class="item-inner item-inner2 fl">\
                                <div class="item-title">\
                                    <a href="index.php?r=shop/get-goods&id=' + v.Id + '" class="item-name" >' + v.Name + '</a>\
                                    <p class="item-info row_one">更优质的矿泉水</p>\
                                    <p class="item-info"><img src="./static/images/location2.png" alt=""/> &nbsp;' + v.distance + ' km</p>\
                                </div>\
                        </div>\
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


    //打电话弹框
    function callphone(num){

        //利用对话框返回的值 （true 或者 false）
        if (confirm("确定拨打"+num+"吗？")) {
            window.location.href = "tel:"+num;
        }
        else {

        }
    }




</script>



</body>
</html>