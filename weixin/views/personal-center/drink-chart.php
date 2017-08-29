<!DOCTYPE html>
<html>
<head lang="en">
    <meta http-equiv="Content-Type" content="textml; charset=UTF-8">
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <meta HTTP-EQUIV="pragma" CONTENT="no-cache">
    <meta HTTP-EQUIV="Cache-Control" CONTENT="no-cache, must-revalidate">
    <meta HTTP-EQUIV="expires" CONTENT="0">
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="/static/css/common.css"/>
    <link rel="stylesheet" href="/static/css/coderlu.css"/>
    <title>个人中心</title>
    <style>
        #main {
            margin-left: 5%;
            width: 90%;
            height: 400px;
            margin-top: 40px;
            border: 1px solid #f3f3f3;
            border-radius: 2px;
            box-shadow: 2px 2px 2px #dbdbdb;
        }
        #data-log{
            margin-left: 5%;
            width: 90%;
            position:relative;

        }
        .drink_icon{
            display:inline-block;
            width:14px;
            height:14px;
            background-image: url("/static/images/drink_icon.png");
            background-size: 16px 16px;
            background-position: center;
            background-repeat: no-repeat;
        }
        .data-log-item{
                height:50px;
                line-height:50px;
        }
        .drinktime{
            padding-left:9px;
            color:#87a5be;
        }
        .drink_vol{
            font-size:18px;
            color:#87a5be;
            position:absolute;
            right:0px;
        }
        #data_container{
            margin-top:20px;
            margin-bottom:20px;
            margin-bottom:80px;
        }
        .divider_line{
            width:2px;
            height:100%;
            background:#f3f3f3;
            position:absolute;
            left:5px;
            top:0px;
            z-index:-1;
        }
        .footer{
            position:fixed;
            width:100%;
            bottom:20px;
            height:60px;
            padding-left:10px;
            padding-right:10px;
        }
    </style>
</head>
<body>
<div id="main"></div>
<div id="data-log">
    <div id="data_container">
        <?php
            for($index=0;$index<count($datax);$index++){
                echo '<div class="data-log-item"><i class="drink_icon"></i><span class="drinktime">'.$datax[$index].'</span> <span class="drink_vol">+'.$datay[$index].'ml</span></div>';
            }
        ?>

    </div>
    <div class="divider_line"></div>

</div>
<div class="footer">
    <div style=" position:relative; width:320px;margin:0 auto;height:100%;line-height:60px;">
        <a href="/index.php/personal-center/setting"><img src="/static/images/person.png" style="position:absolute;height:44px;left:0px;top:8px;"/></a>
            <a href="/index.php/personal-center/drink-chart"><img src="/static/images/chart.png" style="height:60px;position:absolute;left:130px;"/></a>
            <a href="/index.php/personal-center/drink-monitor"><img src="/static/images/drink.png" style="height:44px;position:absolute;right:0px;top:8px;"/></a>

    </div>

</div>
<script type="text/javascript" src="/static/js/zepto.min.js"></script>
<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/echarts-all-3.js?"></script>
<script type="text/javascript" src="http://echarts.baidu.com/asset/theme/macarons.js"></script>
<script type="text/javascript" src="/static/js/coderlu.js"></script>
<script type="text/javascript">
    var datax=<?=json_encode($datax)?>;
    var datay=<?=json_encode($datay)?>;
    if(datax.length==0){
        $.toast("暂无数据");
    }
    // 基于准备好的dom，初始化echarts实例
    var chart = echarts.init(document.getElementById('main'), 'macarons');
    option = {
        title: {
//            text: '今日饮水记录',
//            subtext: '纯属虚构'
        },
        tooltip: {
            trigger: 'axis'
        },
        legend: {
            data: ['今日饮水记录']
        },
        toolbox: {
            show: true,
            feature: {
                mark: {show: true},
                dataView: {show: true, readOnly: false},
                magicType: {show: true, type: ['line', 'bar']},
                restore: {show: true},
                saveAsImage: {show: true}
            }
        },
        calculable: true,
        xAxis: [
            {
                type: 'category',
                boundaryGap: false,
                data: datax
            }
        ],
        yAxis: [
            {
                type: 'value',
                axisLabel: {
                    formatter: '{value} ml'
                }
            }
        ],
        series: [
            {
                name: '饮水量',
                type: 'line',
                data: datay,
                markPoint: {
                    data: [
                        {type: 'max', name: '最大值'},
                    ]
                },
                markLine: {
                    data: [
                        {type: 'average', name: '平均值'}
                    ]
                }
            }
        ]
    };
    // 使用刚指定的配置项和数据显示图表。
    chart.setOption(option);
</script>
</body>
</html>