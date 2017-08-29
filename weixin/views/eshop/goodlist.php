<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta itemprop="name" content="">
    <meta name="description" itemprop="description" content="">
    <link rel="stylesheet" href="/css/reset.css"/>
    <link rel="stylesheet" href="/css/swiper.min.css"/>
    <link rel="stylesheet" href="/css/page1.css"/>
    <link rel="stylesheet" href="/static/css/coderlu.css"/>
    <script src="/static/js/zepto.min.js"></script>
    <style>
        a{
            color:black;
            text-decoration: none;
        }
    </style>
    <title><?=$title?></title>
</head>
<body>
<!--content-->
<div class="content" id="wash"  style="display: none;">
    <div class="nav-re active" v-for="(washlist,index) in washListAll" >
        <div class="list"  v-on:click="toOrderDetai(index,washlist.existsdetail,washlist.id);">
            <div class="list-1"><img v-bind:src="washlist.img" alt=""/></div>
            <div class="list-2"><p>{{washlist.title}}<span>￥{{washlist.price}}</span></p></div>
        </div>

    </div>

</div>
</body>
<script src="/static/js/zepto.min.js"></script>
<script src="/static/js/common.js"></script>
<script src="/static/js/vue.min.js"></script>
<script src="/static/js/coderlu.js"></script>
<script>
    var cid='<?=$cid?>';
    var disid='<?=$distid?>';
    var lat='';
    var lng='';
</script>
<script>
    /**
     * Created by X.gao on 2017/3/14.
     */

    $(function(){
        initPage();
    });


    function initPage(){

        /*声明变量*/
        var _washListAll = [];
        var _washitems =[];
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
            for(var i = 0;i<_washListAll.length;i++){
                _washitems.push(_washListAll[i].items);
            }
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
                    //index:商品序号;index1:商品型号序号
                    simpleBuy:function(index,index1){
                        window.sessionStorage.setItem("detail",JSON.stringify(_washListAll[index]));
                        var _controls=[];
                        var numItem={};
                        numItem.label ="数量";
                        numItem.controltype =10201;
                        numItem.value = 1;
                        _controls.push(numItem);
                        //车牌号
                        var cpItem={};
                        cpItem.label ="车牌信息";
                        cpItem.controltype = 10205;
                        cpItem.value = "";
                        _controls.push(cpItem);
                        //商品规格
                        var item=_washListAll[index].items[index1];
                        var spItem={};
                        spItem.label ="e泊特价";
                        spItem.controltype = 10102;
                        spItem.itemid=item.id;
                        spItem.value = item.name+"/￥"+item.price;
                        spItem.price=item.price;
                        _controls.push(spItem);
                        window.sessionStorage.setItem("fields",JSON.stringify(_controls));
                        window.sessionStorage.setItem("distid",disid);
                        window.location.href="/index.php/Eshop/Open/toPay";
                    },
                    toOrderDetai:function(index,existDetail,_id){
                        window.location.href = "/index.php/eshop/detail?id=" + _id + "&distid=" + disid;
                    }



                }
            });
        }

    }
</script>
</html>