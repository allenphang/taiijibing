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
    <title>硬件告警</title>
    <style>

        .table_header{
            display:inline-block;
            width:25%;
            text-align:center;
            height:40px;
            line-height:40px;
            border-left:1px solid #f3f3f3;

        }
        .table-hr{
            border-bottom:1px solid #f3f3f3;
        }
        body{
            background:#f3f3f3;
        }
        .blud_line{
            background:white;border:1px solid #f3f3f3;border-radius: 4px;height:80px;border-top:2px solid #34a0f8;
            margin-top:10px;
            line-height:80px;
        }
        .red_line{
            background:white;border:1px solid #f3f3f3;border-radius: 4px;height:80px;border-top:2px solid #f37a82;
            margin-top:10px;
            line-height:80px;
        }

    </style>
</head>
<body>
<div class="form">

    <div class="table-hr">
        <p style="background:white;"><span class="table_header">用户姓名</span><span class="table_header">手机号</span><span class="table_header">告警类型</span><span class="table_header">告警时间</span></p>
    </div>
    <div class="table_bd" style="padding:0 8px;">

        <p class="red_line"><span class="table_header">用户姓名</span><span class="table_header">手机号</span><span class="table_header">告警类型</span><span class="table_header">告警时间</span></p>
    </div>

</div>

<script type="text/javascript" src="/static/js/zepto.min.js"></script>
<script type="text/javascript" src="/static/js/coderlu.js"></script>
<script type="text/javascript" src="/static/js/common.js" ></script>
<script>

</script>
<script>
    $(function(){
        var res=<?=json_encode($data)?>;
        if(res.state!=0){
            return;
        }
        var list=res.result;
        $(".table_bd").empty();
        for(var index=0;index<list.length;index++){
            var item=list[index];
            var tr=' <p class="table_tr '+(index%2==0?"blud_line":"red_line")+'"><span class="table_header">'+item.name+'</span><span class="table_header">'+item.mobile+'</span><span class="table_header">'+item.type+'</span><span class="table_header">'+getTime(item.interval)+'</span></p>';
            $(".table_bd").append($(tr));
        }
    });
    function getTime(_val){
        var val=Number(_val);
        if(val<60){
            return val+"分钟前";
        }
        var hours=(val/60).toFixed(0);
        if(hours<24){
            return hours+"小时前"
        }
        var days=(hours/24).toFixed(0);
        return days+"天前";

    }
</script>
</body>
</html>