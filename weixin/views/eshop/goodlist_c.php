<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta itemprop="name" content="">
    <meta name="description" itemprop="description" content="">
    <link rel="stylesheet" href="/css/weui.css"/>
    <link rel="stylesheet" href="/css/weui2.css"/>
    <link rel="stylesheet" href="/static/css/globo.css"/>
    <link rel="stylesheet" href="/static/css/coderlu.css"/>
    <style>
        a{
            color:black;
            text-decoration: none;
        }
    </style>
    <title>附近服务店</title>
</head>
<body>
<!--洗车-->
<div class="wash"  id="wash" style="display:none">
    <!--洗车列表 结构一致-->
    <div class="wash-list">
        <div class="wash-details" v-for="(washlist,index) in washListAll" >
            <div class="wash-all" v-on:click="toOrderDetai(washlist.existsdetail,washlist.id);">
                <div class="wash-img">
                    <img class="lazy" v-bind:src="washlist.img" alt=""/>
                </div>
                <div class="wash-name">
                    <h2>{{washlist.title}}</h2>
                    <p class="wash-time">{{washlist.shophours}}</p>
                    <p class="wash-address">{{washlist.address}}</p>
                </div>
                <div class="wash-far">
                    <span class="far-num">{{Number(washlist.interval/1000).toFixed(2)}}km</span>
                    <a v-bind:href="getTelOfGood(washlist)">
                        <i class="icon icon-tel"></i>
                    </a>
                </div>
            </div>
            <div class="wash-type" data-id="{{washlist.existsdetail}}">
                <div class="type-money" v-for="(item,index1) in washlist.items"  data-id="{{item.id}}">
                    <div class="type-details">
                        <span class="details-car">{{item.name}}</span>
                        <!--<span class="money-long">￥{{item.orgprice}}</span>-->
                        <span class="money-new">￥{{item.orgprice}}</span>
                        <div class="type-btn" v-on:click="simpleBuy(index,index1);">购买</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--呼叫电话弹窗-->
    <div class="mask">
        <div class="weui-dialog">
            <div class="weui-dialog__bd"><span id="tel"></span></div>
            <div class="weui-dialog__ft">
                <a href="javascript:;" class="weui-dialog__btn weui-dialog__btn_default">取消</a>
                <a href="tel:$('#tel').text()" class="weui-dialog__btn weui-dialog__btn_primary">呼叫</a>
            </div>
        </div>
    </div>
</div>
</body>
<script src="/static/js/zepto.min.js"></script>
<script src="/static/js/common.js"></script>
<script src="/static/js/vue.min.js"></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=FCBpETlN4Snp2SfEl92y89WF"></script>
<script src="/static/js/coderlu.js"></script>
<script>
    var cid='<?=$cid?>';
    var disid='<?=$distid?>';
    var lat='';
    var lng='';
</script>
<script>
    $(function(){

        var geolocation = new BMap.Geolocation();

        geolocation.getCurrentPosition(function(r){
            if(this.getStatus() == BMAP_STATUS_SUCCESS){
                lng=r.point.lng;
                lat=r.point.lat;

            }
            initPage();
        },{enableHighAccuracy: true});

    });


    function initPage(){

        /*声明变量*/
        var _washListAll = [];
        var _wash; // 多线程
        /*数据拉取*/
        $.showIndicator();

        $.getJSON("/index.php/eshop/goods-get?disid="+disid+"&categoryid="+cid+"&lat="+lat+"&lng="+lng+"&skip=0&take=20",function(data){
            $.hideIndicator();
            if(data.state!=0){
                $.alert(data.msg,function(){
                    window.history.go(-1);
                });
                return;
            }
            $("#wash").show();
            var _msg = data.result;
            _washListAll = _msg;
            wash();
        });

        /*列表渲染*/
        function wash(){
            _wash = new Vue({
                el:"#wash",
                data:{
                    washListAll:_washListAll //全部
                },
                ready:function(){

                    $(".icon-tel").on("click",function(){
                        $("#tel").html($(this).parent().data("phone"));
                        $(".mask").show();
                    });
                    $(".weui-dialog__btn").on("click",function(){
                        $(".mask").hide();
                    });
                },
                methods:{
                    getTelOfGood:function(item){
                        return "tel:"+item.tel;
                    },
                    //index:商品序号;index1:商品型号序号
                    simpleBuy:function(index,index1){

                        window.location.href = "/index.php/eshop/detail?id="+_washListAll[index].id+"&distid="+disid;
                        return;
//                        window.sessionStorage.setItem("detail",JSON.stringify(_washListAll[index]));
//                        var _controls=[];
//                        var numItem={};
//                        numItem.label ="数量";
//                        numItem.controltype =10201;
//                        numItem.value = 1;
//                        _controls.push(numItem);
//                        //车牌号
//                        var cpItem={};
//                        cpItem.label ="车牌信息";
//                        cpItem.controltype = 10205;
//                        cpItem.value = "";
//                        _controls.push(cpItem);
//                        //商品规格
//                        var item=_washListAll[index].items[index1];
//                        var spItem={};
//                        spItem.label ="e泊特价";
//                        spItem.controltype = 10102;
//                        spItem.value = item.name+"/￥"+item.orgprice;
//                        spItem.price=item.orgprice;
//                        spItem.itemid=item.id;
//                        _controls.push(spItem);
//                        window.sessionStorage.setItem("fields",JSON.stringify(_controls));
//                        window.sessionStorage.setItem("distid",distid);
//                        window.location.href="/index.php/Eshop/Open/toPay";
                    },
                    toOrderDetai:function(existsdetail,_id){
////                        if(existsdetail == 1){
////                            window.location.href = "/index.php/Eshop/Goods/gooddetail?id="+_id+"&distid="+distid;
////                        }
//                        window.location.href = "/index.php/eshop/detail?id="+_id+"&distid="+disid;
                    }



                }
            });
        }

    }
</script>
</html>