<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/31
 * Time: 14:17
 */
?>
<style>
    .wdc_item {
        float: left;
        width: 270px;
        height: 100px;
    }

    .wdc_left {
        width: 130px;
        height: 100%;

        float: left;
    }

    .wdc_right {
        width: 140px;
        height: 100%;
        border: 1px solid #f3f3f3;
        float: left;
    }
    .wdc_right p{
        text-align:center;
        height:20px;
        line-height:20px;
        margin:0px;
        padding:0px;

    }
    .icon_rise{
        background-image: url("./static/img/rise.png");
        background-size: 10px 10px;
        width:10px;
        height:10px;
        display:inline-block;
        background-repeat: no-repeat;
        background-position: center;;
    }
    .icon_drop{
        background-image: url("./static/img/drop.png");
        background-size: 10px 10px;
        width:10px;
        height:10px;
        display:inline-block;
        background-repeat: no-repeat;
        background-position: center;;
    }
</style>
<a href="/index.php?r=dev-manager/map"><span style="float:right;font-size:13px;color:black;">地图模式</span></a>
<p>今日数据发布<span id="now">2017-05-13 17:08:05</span></p>
<div class="w_data_container">
        <div class="wdc_item">
            <div class="wdc_left" style=" background: #ff5e3a;">
                <p style="text-align:center;margin-top:16px;"><img src="./static/img/today_1.png" style="height:40px;"/></p>
                <p style="color:white;text-align:center;">县区经销商数量</p>
            </div>
            <div class="wdc_right">
                <p style="font-size:18px;height:30px;line-height:30px;"><?=$xagentTotal?></p>
                <p id="xagent_day">日 <i class="icon"></i><span></span></p>
                <p id="xagent_week">周 <i class="icon"></i><span></span></p>
                <p id="xagent_month">月 <i class="icon"></i><span></span></p>
            </div>
        </div>
        <div class="wdc_item" style="margin-left:40px;">
            <div class="wdc_left" style=" background: #ff9500;">
                <p style="text-align:center;margin-top:16px;"><img src="./static/img/today_2.png" style="height:40px;"/></p>
                <p style="color:white;text-align:center;">社区经销商数量</p>
            </div>
            <div class="wdc_right">
                <p style="font-size:18px;height:30px;line-height:30px;"><?=$sagentTotal?></p>
                <p  id="sagent_day">日 <i class="icon"></i><span></span></p>
                <p id="sagent_week">周 <i class="icon"></i><span></span></p>
                <p id="sagent_month">月 <i class="icon"></i><span></span></p>
            </div>
        </div>
    <div style="clear:both;"></div>
        <div class="wdc_item" style="margin-top:40px;">
            <div class="wdc_left" style=" background: #76c80e;">
                <p style="text-align:center;margin-top:16px;"><img src="./static/img/today_3.png" style="height:40px;"/></p>
                <p style="color:white;text-align:center;">用户数量</p>
            </div>
            <div class="wdc_right">
                <p style="font-size:18px;height:30px;line-height:30px;"><?=$userinfoTotal?></p>
                <p id="user_day">日 <i class="icon"></i><span></span></p>
                <p id="user_week">周 <i class="icon"></i><span></span></p>
                <p id="user_month">月 <i class="icon"></i><span></span></p>
            </div>
        </div>
        <div class="wdc_item" style="margin-top:40px;margin-left:40px;">
            <div class="wdc_left" style="background: #1fbba6;">
                <p style="text-align:center;margin-top:16px;"><img src="./static/img/today_4.png" style="height:40px;"/></p>
                <p style="color:white;text-align:center;">异常硬件数量</p>
            </div>
            <div class="wdc_right">
                <p style="font-size:18px;height:30px;line-height:30px;"><?=$devError?></p>
                <p id="dev_day">日 <i class="icon"></i><span></span></p>
                <p id="dev_week">周 <i class="icon"></i><span></span></p>
                <p id="dev_month">月 <i class="icon"></i><span></span></p>
            </div>
        </div>

</div>
<div style="clear:both;"></div>
<p style="background:#e6eefb;height:40px;line-height:40px;margin-top:20px;">饮用水量</p>
<div id="charts"   style="width: 100%;height:400px;"></div>
<div style="clear:both;"></div>
<p style="background:#e6eefb;height:40px;line-height:40px;margin-top:20px;">销售量</p>
<div id="charts1"   style="width: 100%;height:400px;"></div>
<script type="text/javascript" src="./static/js/jquery.min.js"></script>
<script type="text/javascript" src="./static/js/lib.js"></script>
<script type="text/javascript" src="./static/js/echarts/echarts.min.js"></script>
<script>
    var data=<?= json_encode($data) ?>;
    var dynamicAgentData=<?=json_encode($dynamicAgentData)?>;
    var dynamicUserData=<?=json_encode($dynamicUserData)?>;
    var dynamicDevErrData=<?=json_encode($dynamicDevErrData)?>;
    var selloutPackage=<?=json_encode($selloutPackage)?>;
    $(function () {

        $("#xagent_day").find(".icon").addClass(getIcon(dynamicAgentData.date));
        $("#xagent_week").find(".icon").addClass(getIcon(dynamicAgentData.week));
        $("#xagent_month").find(".icon").addClass(getIcon(dynamicAgentData.month));
        $("#xagent_day").find("span").text(Math.abs(dynamicAgentData.date));
        $("#xagent_week").find("span").text(Math.abs(dynamicAgentData.week));
        $("#xagent_month").find("span").text(Math.abs(dynamicAgentData.month));


        $("#sagent_day").find(".icon").addClass(getIcon(dynamicAgentData.dates));
        $("#sagent_week").find(".icon").addClass(getIcon(dynamicAgentData.weeks));
        $("#sagent_month").find(".icon").addClass(getIcon(dynamicAgentData.months));

        $("#sagent_day").find("span").text(Math.abs(dynamicAgentData.dates));
        $("#sagent_week").find("span").text(Math.abs(dynamicAgentData.weeks));
        $("#sagent_month").find("span").text(Math.abs(dynamicAgentData.months));

        $("#user_day").find(".icon").addClass(getIcon(dynamicUserData.date));
        $("#user_week").find(".icon").addClass(getIcon(dynamicUserData.week));
        $("#user_month").find(".icon").addClass(getIcon(dynamicUserData.month));

        $("#user_day").find("span").text(Math.abs(dynamicUserData.date));
        $("#user_week").find("span").text(Math.abs(dynamicUserData.week));
        $("#user_month").find("span").text(Math.abs(dynamicUserData.month));


        $("#dev_day").find(".icon").addClass(getIcon(dynamicDevErrData.date));
        $("#dev_week").find(".icon").addClass(getIcon(dynamicDevErrData.week));
        $("#dev_month").find(".icon").addClass(getIcon(dynamicDevErrData.month));

        $("#dev_day").find("span").text(Math.abs(dynamicDevErrData.date));
        $("#dev_week").find("span").text(Math.abs(dynamicDevErrData.week));
        $("#dev_month").find("span").text(Math.abs(dynamicDevErrData.month));

        function getIcon(_val){
            return _val>=0?"icon_rise":"icon_drop";
        }
        $("#now").text("("+(new Date()).Format("yyyy-MM-dd")+")");
        var myChart = echarts.init(document.getElementById('charts'));
        var myChart1 = echarts.init(document.getElementById('charts1'));
        // 指定图表的配置项和数据
        var option = {

            title : {
                //text: '未来一周气温变化',
                //subtext: '纯属虚构'
            },
            tooltip : {
                trigger: 'axis'
            },
            legend: {
                data:['饮用量']
            },
            toolbox: {
                show : true,
                feature : {
                    mark : {show: true},
                    dataView : {show: true, readOnly: false},
                    magicType : {show: true, type: ['line', 'bar']},
                    restore : {show: true},
                    saveAsImage : {show: true}
                }
            },
            calculable : true,
            xAxis : [
                {
                    type : 'category',
                    boundaryGap : false,
                    data : data.x,
                    axisLabel:{
                        //X轴刻度配置
                        interval:2 //0：表示全部显示不间隔；auto:表示自动根据刻度个数和宽度自动设置间隔个数
                    }
                }

            ],
            yAxis : [
                {
                    type : 'value',
                    axisLabel : {
                        //formatter: '{value} °C'
                        formatter: '{value} '
                    },
                    name:'L'
                }
            ],

            series : [

                {
                    name:'饮用量',
                    type:'line',
                    data:data.y,
                    markPoint : {
                        data : [
                            {name : '周最低', value : -2, xAxis: 1, yAxis: -1.5}
                        ]
                    },
                    markLine : {
                        data : [
                            {type : 'average', name : '平均值'}
                        ]
                    }
                }
            ],
            color:["#62c87f","#f15755"]
        };
        var option1 = {

            title : {
                //text: '未来一周气温变化',
                //subtext: '纯属虚构'
            },
            tooltip : {
                trigger: 'axis'
            },
            legend: {
                data:['销售量']
            },
            toolbox: {
                show : true,
                feature : {
                    mark : {show: true},
                    dataView : {show: true, readOnly: false},
                    magicType : {show: true, type: ['line', 'bar']},
                    restore : {show: true},
                    saveAsImage : {show: true}
                }
            },
            calculable : true,
            xAxis : [
                {
                    type : 'category',
                    boundaryGap : false,
                    data : selloutPackage.x,
                    axisLabel:{
                        //X轴刻度配置
                        interval:2//0：表示全部显示不间隔；auto:表示自动根据刻度个数和宽度自动设置间隔个数
                    }
                }

            ],
            yAxis : [
                {
                    type : 'value',
                    axisLabel : {
                        //formatter: '{value} °C'
                        formatter: '{value} '
                    },
                    name:'袋'
                }
            ],

            series : [

                {
                    name:'销售量',
                    type:'line',
                    data:selloutPackage.y,
                    markPoint : {
                        data : [
                            {name : '周最低', value : -2, xAxis: 1, yAxis: -1.5}
                        ]
                    },
                    markLine : {
                        data : [
                            {type : 'average', name : '平均值'}
                        ]
                    }
                }
            ],
            color:["#62c87f","#f15755"]
        };
        myChart.setOption(option);
        myChart1.setOption(option1);
    });
</script>

