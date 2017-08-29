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
    <title>数据总览</title>
    <style>
        .header {
            height: 240px;
            width: 100%;
            background: url("/static/images/bg.png");
            background-size: 100% 240px;
            background-position: center;
            background-repeat: no-repeat;
            padding-top: 20px;
        }

        #header_total {
            width: 132px;
            height: 132px;
            background: red;
            margin: 0 auto;
            background: url("/static/images/data_view_bg.png");
            background-size: 132px 132px;
            background-position: center;
            background-repeat: no-repeat;
            padding-top: 40px;

        }

        .table_header {
            display: inline-block;
            width: 25%;
            text-align: center;
            height: 40px;
            line-height: 40px;

        }

        .table-hr {
            border-bottom: 1px solid #f3f3f3;
        }

        .table_bd {
            border-bottom: 1px solid #f3f3f3;
            border-right: 1px solid #f3f3f3;
            display: inline-block;
            width: 25%;
            text-align: center;
            height: 40px;
            line-height: 40px;

        }

        .table_bd_fir {
            border-left: 1px solid #f3f3f3;
        }

        .icon_rise {
            background-image: url("/static/images/rise.png");
            background-size: 10px 10px;
            width: 10px;
            height: 10px;
            display: inline-block;
            background-repeat: no-repeat;
            background-position: center;;
        }

        .icon_drop {
            background-image: url("/static/images/drop.png");
            background-size: 10px 10px;
            width: 10px;
            height: 10px;
            display: inline-block;
            background-repeat: no-repeat;
            background-position: center;;
        }
    </style>
</head>
<body>
<div class="form">
    <div class="header">
        <div id="header_total">
            <p style="text-align:center;font-size:24px;color:#00d673;"><span class="sell_out">2000</span><span>袋</span>
            </p>

            <p style="font-size:14px;color:#666666;text-align:center;height:20px;font-size:13px;">累计销量</p>
        </div>
        <div style="position:relative;width:100%;margin-top:14px;">
            <div
                style="position:absolute;left:0px;display:inline-block;width:50%;text-align:right;padding-right:20px;border-right:1px solid #dbdbdb;">
                <p style="font-size:18px;color:#666666;">累计销量</p>

                <p style="color:#34a0f8" class="sell_out"></p>
            </div>
            <div style="position:absolute;right:0px;display:inline-block;width:50%;text-align:left;padding-left:20px;">
                <p style="font-size:18px;color:#666666;">累计用户</p>

                <p style="color:#34a0f8" class="regis_num">100000</p>
            </div>
        </div>
    </div>
    <div style="height:46px;float:left;width:100%;border-bottom:1px solid #f3f3f3;">
        <img src="/static/images/jysj.png" style="float:left;height:24px;margin-top:10px;padding:0 10px;"/><span
            style="height:46px;line-height: 46px;color:#666666;">经营数据</span>
    </div>
    <div class="table-hr">
        <p><span class="table_header">经营类型</span><span class="table_header">数量</span><span
                class="table_header">日增长</span><span class="table_header">月增长</span></p>
    </div>
    <div class="table-bd">
        <p><span class="table_bd table_bd_fir">销量(袋)</span><span class="table_bd sell_out"></span><span
                class="table_bd"><i class="icon"></i><span id="sell_day_per"></span></span><span class="table_bd"><i
                    class="icon"></i><span id="sell_month_per"></span></span></p>

        <p><span class="table_bd table_bd_fir">用户数量(台)</span><span class="table_bd regis_num"></span><span
                class="table_bd"><i class="icon"></i><span id="regis_day_per"></span></span><span class="table_bd"><i
                    class="icon"></i><span id="regis_month_per"></span></span></p>
    </div>
</div>

<script type="text/javascript" src="/static/js/zepto.min.js"></script>
<script type="text/javascript" src="/static/js/coderlu.js"></script>
<script type="text/javascript" src="/static/js/common.js"></script>
<script>
    var data =<?=json_encode($data)?>;
</script>
<script>
    $(function () {
        if (data.state != 0) {
            $.alert("数据读取错误");
            return;
        }
        initPage();
    });
    function initPage() {
        var watersale = data.result.watersale;
        var customer = data.result.customer;
        $(".sell_out").text(watersale.total);
        $(".regis_num").text(customer.total);
        var sell_day_per = Number(watersale.curdaycnt) - Number(watersale.prvdaycnt);
        var regis_day_per = Number(customer.curdaycnt) - Number(customer.prvdaycnt);
        $("#sell_day_per").text(Math.abs(sell_day_per));
        $("#regis_day_per").text(Math.abs(regis_day_per));
        updateRiseOrDropStatus($("#sell_day_per"), sell_day_per);
        updateRiseOrDropStatus($("#regis_day_per"), regis_day_per);

        var sell_month_per = Number(watersale.curmonthcnt) - Number(watersale.prvmonthcnt);
        var regis_month_per = Number(customer.curmonthcnt) - Number(customer.prvmonthcnt);
        $("#sell_month_per").text(Math.abs(sell_month_per));
        $("#regis_month_per").text(Math.abs(regis_month_per));
        updateRiseOrDropStatus($("#sell_month_per"), sell_month_per);
        updateRiseOrDropStatus($("#regis_month_per"), regis_month_per);

    }
    function updateRiseOrDropStatus(_obj, num) {
        $(_obj).parents(".table_bd").find(".icon").addClass(num >= 0 ? "icon_rise" : "icon_drop");
    }
</script>
</body>
</html>