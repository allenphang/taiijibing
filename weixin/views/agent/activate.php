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
    <link rel="stylesheet" href="/static/css/agile.layout.css"/>
    <link rel="stylesheet" href="/static/css/seedsui.min.css"/>
    <link rel="stylesheet" href="/static/css/coderlu.css"/>

    <title>饮水机激活</title>
    <style>
    body{
        background:#313f4c;
    }
    .code_bg{
        text-align: center;
        margin-top:20px;
        background:white;
        height:280px;
        margin-left:20px;
        margin-right:20px;
        background:url("/static/images/code_bg.png");
        background-repeat:no-repeat;
        background-position: center;
        background-size: 100% 280px;
        margin-top:90px;
        padding-top:40px;
    }
    </style>
</head>
<body>
 <p class="code_bg"> <img id="barcode"/></p>




 <script type="text/javascript" src="/static/js/zepto.min.js"></script>
 <script type="text/javascript" src="https://cdn.jsdelivr.net/jsbarcode/3.5.8/barcodes/JsBarcode.code128.min.js"></script>
 <script type="text/javascript" src="/static/js/coderlu.js"></script>
 <script type="text/javascript" src="/static/js/common.js"></script>
<script>
    var vcode='';

$(function(){
    vcode= getQueryString("code");
    if(vcode==null){
        $.alert("无效链接",function(){
            window.history.go(-1);
        });
    }
    var barcode = document.getElementById('barcode'),
        str = "12345678",
        options = {
            format:"CODE128",
            displayValue:true,
            fontSize:18,
            height:100
        };
    JsBarcode(barcode, vcode, options);//原生
});


</script>
</body>

</html>
