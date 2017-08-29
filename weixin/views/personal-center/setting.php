<!DOCTYPE html>
<html>
<head lang="en">
    <meta http-equiv="Content-Type" content="textml; charset=UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <meta HTTP-EQUIV="pragma" CONTENT="no-cache">
    <meta HTTP-EQUIV="Cache-Control" CONTENT="no-cache, must-revalidate">
    <meta HTTP-EQUIV="expires" CONTENT="0">
    <meta charset="utf-8" />
    <link rel="stylesheet" href="/static/css/common.css" />
    <link rel="stylesheet" href="/static/css/coderlu.css"/>
    <title>个人中心</title>
    <style>
        body{
            background:#f3f3f3;
        }
        .item{
            height:40px;
            line-height:40px;
            border-bottom: 1px solid #f3f3f3;
            position:relative;
        }
        .container{
            background:white;
            padding-left:20px;
            padding-right: 20px;
            margin-top:20px;
        }
        .line-val{
            display:inline-block;
            font-size:16px;
            color:#cccccc;
            height:40px;
            line-height: 40px;
            right:14px;
            position:absolute;
        }
        .line-title{
            display:inline-block;
        }
        .arrow-gray_right{
            display:inline-block;
            width:8px;
            height:16px;
            background-size:8px 16px;
            background-repeat:no-repeat;
            background-position: center;
            background-image: url("/static/images/arrow_right.png");
            position: absolute;
            right:0px;
            top:11px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="item">
        <span class="line-title">名字</span>
        <span class="line-val"><?=$info->name?></span>
    </div>
    <div class="item">
        <span class="line-title">手机号码</span>
        <span class="line-val"><?=$info->mobile?></span>
    </div>
    <div class="item">
        <span class="line-title">地址</span>
        <span class="line-val"><?=$info->addr?></span>

    </div>
    <div class="item" id="drink_c">
        <span class="line-title">我的饮水计划</span>
        <span class="line-val"><span id="plan_vl"><?=$info->waterplan?></span>ml</span>
        <i class="arrow-gray_right"></i>
    </div>
</div>


<script type="text/javascript" src="/static/js/vue.min.js"></script>
<script type="text/javascript" src="/static/js/zepto.min.js"></script>
<script type="text/javascript" src="/static/js/coderlu.js"></script>
<script type="text/javascript" src="/static/js/common.js" ></script>
<script>
    var volArr=["2100","1800","1500","1300","1100","900"];
    $(function(){
        $("#drink_c").on("click",function(){

            $.showActionSheet(volArr,function(index){
                $("#plan_vl").text(volArr[index]);
                $.showIndicator();
                $.getJSON("/index.php/personal-center/savewaterplan?ml="+volArr[index],function(data){
                    $.hideIndicator();
                    if(data.state!=0){
                        $.toast(data.desc);
                        return;
                    }
                });
            })
        });
    });
</script>
</body>
</html>