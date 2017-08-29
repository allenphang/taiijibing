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
    <title>运营中心系统</title>
    <style>
        #header{
            height:140px;
            width:100%;
            border-bottom:2px #f3f3f3 solid;
            background:url("/static/images/bg.png");
            background-size: 100% 140px;
            background-position: center;
            background-repeat: no-repeat;
        }
        .grid_item{
            float:left;
            width:50%;
            height:80px;
        }
        #gridContainer{
            border-bottom:4px #f3f3f3 solid;
            float:left;
            width:100%;
        }
        #footer_left{
            float:left;
            width:40%;
            margin-left:5%;
            height:100px;
        }
        #footer_right{
            float:right;
            width:40%;
            margin-right:5%;
            height:100px;
        }
        .footer_1{
            height:90px;
            padding-top:10px;

        }
        #footer{
            margin-top:40px;
        }
        .num_c{
            font-size:24px;
            text-align:center;
            height:50px;
            line-height:50px;
        }
        .icon_rise{
            background-image: url("/static/images/rise.png");
            background-size: 10px 10px;
            width:10px;
            height:10px;
            display:inline-block;
            background-repeat: no-repeat;
            background-position: center;;
        }
        .icon_drop{
            background-image: url("/static/images/drop.png");
            background-size: 10px 10px;
            width:10px;
            height:10px;
            display:inline-block;
            background-repeat: no-repeat;
            background-position: center;;
        }
        .stat_label{
            text-align:center;
            font-size:12px;
            height:26px;
            line-height:26px;
        }
        .footer_footer{
            border-left:1px solid #f3f3f3;
            border-right:1px solid #f3f3f3;
            border-bottom:1px solid #f3f3f3;
            padding-bottom:10px;
        }
    </style>
</head>
<body>
    <div id="container">
        <header id="header">
            <p style="text-align:center;padding-top:20px;">
                <img src="/static/images/person.png" style="width:80px;height:auto;"/>
            </p>
            <p style="text-align:center;"><?=$name?></p>
        </header>
        <div id="gridContainer">
            <div class="grid_item" style="position:relative;border-bottom: 1px #f3f3f3 solid;border-right:1px #f3f3f3 solid;">
                <a href="/index.php/agent/data-view">
                    <div style="left:50%;margin-left:-57px;position:relative;width:114px;">
                        <img src="/static/images/sjzl.png" style="display:inline-block;margin-top:20px;width:40px;height:40px;margin-right:10px;"/>
                        <span style="position:absolute;top:30px;">数据总览</span>
                    </div>
                </a>


            </div>
            <div class="grid_item" style=";position:relative;border-bottom: 1px #f3f3f3 solid;">
                <a href="/index.php/agent/register">
                    <div style="left:50%;margin-left:-57px;position:relative;width:114px;">
                        <img src="/static/images/dj.png" style="display:inline-block;margin-top:20px;width:40px;height:40px;margin-right:10px;"/>
                        <span style="position:absolute;top:30px;">登记</span>
                    </div>
                </a>
            </div>
            <div class="grid_item" style="position:relative;border-right: 1px #f3f3f3 solid;">
                <a href="/index.php/agent/hardware-warn">
                    <div style="left:50%;margin-left:-57px;position:relative;width:114px;">
                        <img src="/static/images/yjgj.png" style="display:inline-block;margin-top:20px;width:40px;height:40px;margin-right:10px;"/>
                        <span style="position:absolute;top:30px;">硬件告警</span>
                    </div>
                </a>
            </div>
            <div class="grid_item" style="position:relative;">
                <a href="/index.php/agent/chart">
                    <div style="left:50%;margin-left:-57px;position:relative;width:114px;">
                        <img src="/static/images/bb.png" style="display:inline-block;margin-top:20px;width:40px;height:40px;margin-right:10px;"/>
                        <span style="position:absolute;top:30px;">报表</span>
                    </div>
                </a>
            </div>
            <div class="grid_item" style="position:relative;border-right: 1px #f3f3f3 solid;">
                <a href="/index.php/agent/server-center">
                    <div style="left:50%;margin-left:-57px;position:relative;width:114px;">
                        <img src="/static/images/server_icon.png" style="display:inline-block;margin-top:20px;width:40px;height:40px;margin-right:10px;"/>
                        <span style="position:absolute;top:30px;">服务中心</span>
                    </div>
                </a>
            </div>
            <div class="grid_item" style="position:relative;">
                <a href="/index.php/agent/users">
                    <div style="left:50%;margin-left:-57px;position:relative;width:114px;">
                        <img src="/static/images/user_icon.png" style="display:inline-block;margin-top:20px;width:40px;height:40px;margin-right:10px;"/>
                        <span style="position:absolute;top:30px;">用户</span>
                    </div>
                </a>
            </div>
        </div>
        <div style="clear:both;"></div>
        <div id="footer">
            <div id="footer_left">
                <div class="footer_1" style="background:#ff3d18;">
                  <div class="footer_header" >
                      <p style="text-align:center;"> <img src="/static/images/jmssl.png" style="display:inline-block;margin-top:10px;width:30px;margin-right:10px;"/></p>
                      <p style="text-align:center;color:white;">水袋数量</p>
                  </div>
                </div>
                <div class="footer_footer">
                    <p class="num_c" id="agent_total">1000</p>
                    <p class="stat_label" id="agent_day_per">日 <i class="per_class"></i><span class="per_val">0%</span></p>
                    <p class="stat_label" id="agent_week_per">周 <i class="per_class"></i><span class="per_val">0%</span></p>
                    <p class="stat_label" id="agent_month_per">月 <i class="per_class"></i><span class="per_val">0%</span></p>
                </div>
            </div>
            <div id="footer_right">
                <div  class="footer_1" style="background:#0090ff">
                    <div class="footer_header" >
                        <p style="text-align:center;"> <img src="/static/images/yhsl.png" style="display:inline-block;margin-top:10px;width:30px;margin-right:10px;"/></p>
                        <p style="text-align:center;color:white;">用户数量</p>
                    </div>
                </div>
                <div class="footer_footer">
                    <p class="num_c" id="user_total">1000</p>
                    <p class="stat_label" id="user_day_per">日 <i class="per_class"></i><span class="per_val">0%</span></p>
                    <p class="stat_label" id="user_week_per">周 <i class="per_class"></i><span class="per_val">0%</span></p>
                    <p class="stat_label" id="user_month_per">月 <i class="per_class"></i><span class="per_val">0%</span></p>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript" src="/static/js/zepto.min.js"></script>
<script type="text/javascript" src="/static/js/coderlu.js"></script>
<script type="text/javascript" src="/static/js/common.js" ></script>
    <script>
        var totalData=<?=json_encode($totalData) ?>;
    </script>
    <script type="text/javascript">
        $(function(){
            initpage();
        });
        function initpage(){

            var agent=totalData.result.watersale;
            var customer=totalData.result.customer;
            $("#agent_total").text(agent.total);
            $("#user_total").text(customer.total);

            var agent_day=getPercent(agent.curdaycnt,agent.prvdaycnt);
            var agent_week=getPercent(agent.curweekcnt,agent.prvweekcnt);
            var agent_month=getPercent(agent.curmonthcnt,agent.prvmonthcnt);


            var user_day=getPercent(customer.curdaycnt,customer.prvdaycnt);
            var user_week=getPercent(customer.curweekcnt,customer.prvweekcnt);
            var user_month=getPercent(customer.curmonthcnt,customer.prvmonthcnt);
            $("#agent_day_per .per_class").addClass(getPerClass(agent_day));
            $("#agent_day_per .per_val").text((agent_day<0?-agent_day:agent_day));

            $("#agent_week_per .per_class").addClass(getPerClass(agent_week));
            $("#agent_week_per .per_val").text((agent_day<0?-agent_week:agent_week));

            $("#agent_month_per .per_class").addClass(getPerClass(agent_month));
            $("#agent_month_per .per_val").text((agent_day<0?-agent_month:agent_month));

            $("#user_day_per .per_class").addClass(getPerClass(user_day));
            $("#user_day_per .per_val").text((user_day<0?-user_day:user_day));

            $("#user_week_per .per_class").addClass(getPerClass(user_week));
            $("#user_week_per .per_val").text((user_week<0?-user_week:user_week));

            $("#user_month_per .per_class").addClass(getPerClass(user_month));
            $("#user_month_per .per_val").text((user_month<0?-user_month:user_month));



        }
        function getPerClass(_val){
            return _val<0?"icon_drop":"icon_rise";
        }
        function getPercent(_cur,_pre){
            var dif=Number(_cur)-Number(_pre);
            return dif;
        }
    </script>
</body>
</html>