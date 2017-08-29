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
    <title>数据报表</title>
    <style>
        #main {
            margin-left: 5%;
            width: 90%;
            height: 400px;
            border: 1px solid #f3f3f3;
            border-radius: 2px;
            box-shadow: 2px 2px 2px #dbdbdb;
        }
        #agent{
            margin-left: 5%;
            width: 90%;
            height: 400px;
            border: 1px solid #f3f3f3;
            border-radius: 2px;
            box-shadow: 2px 2px 2px #dbdbdb;
        }
    </style>
</head>
<body>
<div style="height:46px;float:left;width:100%;">
    <img  src="/static/images/chart_user_cnt.png" style="float:left;height:24px;margin-top:10px;padding:0 10px;"/><span style="height:46px;line-height: 46px;color:#666666;">用户数(人)</span>
</div>
<div style="clear:both;"></div>
<div id="agent"></div>
<div style="height:46px;float:left;width:100%;">
    <img  src="/static/images/chart_agent_cnt.png" style="float:left;height:24px;margin-top:10px;padding:0 10px;"/><span style="height:46px;line-height: 46px;color:#666666;">销售数量(袋)</span>
</div>
<div style="clear:both;"></div>
<div id="main"></div>
<script type="text/javascript" src="/static/js/zepto.min.js"></script>
<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/echarts-all-3.js?"></script>
<script type="text/javascript" src="http://echarts.baidu.com/asset/theme/macarons.js"></script>
<script type="text/javascript" src="/static/js/coderlu.js"></script>
<script type="text/javascript">
    var datax=<?=json_encode($datax)?>;
    var datay=<?=json_encode($datay)?>;
    var userdatax=<?=json_encode($userdatax)?>;
    var userdatay=<?=json_encode($userdatay)?>;
    // 基于准备好的dom，初始化echarts实例
    var userchart = echarts.init(document.getElementById('agent'), 'macarons');
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
            data: ['今日销量']
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
                    formatter: '{value} 袋'
                }
            }
        ],
        series: [
            {
                name: '销售数量',
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
    var useroption = {
        title: {
//            text: '今日饮水记录',
//            subtext: '纯属虚构'
        },
        tooltip: {
            trigger: 'axis'
        },
        legend: {
            data: ['今日新增用户数']
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
                data: userdatax
            }
        ],
        yAxis: [
            {
                type: 'value',
                axisLabel: {
                    formatter: '{value} 人'
                }
            }
        ],
        series: [
            {
                name: '新增用户数',
                type: 'line',
                data: userdatay,
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
    userchart.setOption(useroption);
</script>
</body>
</html>