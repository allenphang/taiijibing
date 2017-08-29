<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>商品信息</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="/favicon.ico">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <link rel="stylesheet" href="./static/css/sm.min.css">
    <link rel="stylesheet" href="./static/css/sm-extend.min.css">
    <link rel="stylesheet" href="./static/css/index.css">

    <style>
        .wrapper{
            padding:0;
            position: fixed;
            left: 0;
            top: 0;
        }
        .wrapper-content{
            padding:0;
        }
    </style>

</head>
<body >
<div class="header" style="background: url('./static/images/background.png') no-repeat">
    <div class="header_img fl"><img src="http://7xpcl7.com2.z0.glb.qiniucdn.com/o_1bm7fff414h8m8510ck14ac1laur.jpg" alt=""/></div>
    <div class="header_info fl">
        <p class="info_title row_one" style="color: #f2f0f0;"><?=$agent_info[0]['Name']?></p>
        <p class="row_two" style="color: #f2f0f0;">地址：<?=$agent_info[0]['Address']?></p>
        <p class="row_two" style="color: #f2f0f0;">简介：我们只做优质水，让家人喝到安全放心的水</p>
    </div>
</div>
<div class="page">


    <div class="content list-content" style="width: 66%;">
        <!--热销列表-->
        <div class="list-block" id="hot" style="width: 96%;overflow: hidden;" >
            <p class="list-title">热销</p>
            <ul style="width: 103%;overflow: auto;">
                <li class="item-content">
                    <div class="item-media fl"><i class="icon icon-f7"><img src="./static/images/water1.gif"></i></div>
                    <div class="item-inner fl">
                        <div class="item-title">
                            <a href="#" class="item-name">无为太极水</a>
                            <p class="item-intro row_two">更优质的矿泉水</p>
                            <p class="item-sell">已售：<span>111</span></p>
                            <p class="item-money">￥8 <span>￥10</span></p>
                        </div>
                        <div class="item-after" style="background-color: #f3652d; margin-right: .2rem;"><a href="javascript:void(0);" onclick="callphone()" style="color: #f2f0f0;">购买</a></div>
                    </div>
                </li>
                <li class="item-content">
                    <div class="item-media fl"><i class="icon icon-f7"><img src="./static/images/water3.jpg"></i></div>
                    <div class="item-inner fl">
                        <div class="item-title">
                            <a href="#" class="item-name">太极冰</a>
                            <p class="item-intro row_two">更优质的矿泉水</p>
                            <p class="item-sell">已售：<span>368</span></p>
                            <p class="item-money">￥15 <span>￥20</span></p>
                        </div>
                        <div class="item-after" style="background-color: #f3652d; margin-right: .2rem;"><a href="javascript:void(0);" onclick="callphone()" style="color: #f2f0f0;">购买</a></div>
                    </div>
                </li>
                <li class="item-content">
                    <div class="item-media fl"><i class="icon icon-f7"><img src="./static/images/water4.jpg"></i></div>
                    <div class="item-inner fl">
                        <div class="item-title">
                            <a href="#" class="item-name">冰山水</a>
                            <p class="item-intro row_two">更优质的矿泉水</p>
                            <p class="item-sell">已售：<span>235</span></p>
                            <p class="item-money">￥12 <span>￥15</span></p>
                        </div>
                        <div class="item-after" style="background-color: #f3652d; margin-right: .2rem;"><a href="javascript:void(0);" onclick="callphone()" style="color: #f2f0f0;">购买</a></div>
                    </div>
                </li>
                <li class="item-content">
                    <div class="item-media fl"><i class="icon icon-f7"><img src="./static/images/water2.jpg"></i></div>
                    <div class="item-inner fl">
                        <div class="item-title">
                            <a href="#" class="item-name">富矿太极水</a>
                            <p class="item-intro row_two">更优质的矿泉水</p>
                            <p class="item-sell">已售：<span>111</span></p>
                            <p class="item-money">￥18 <span>￥23</span></p>
                        </div>
                        <div class="item-after" style="background-color: #f36b35; margin-right: .2rem;"><a href="javascript:void(0);" onclick="callphone()" style="color: #f2f0f0;">购买</a></div>
                    </div>
                </li>
            </ul>
        </div>
        <!--饮用水列表-->
        <div class="list-block " id="water" style="width: 96%;overflow: hidden; display: none;" >
            <p class="list-title">饮用水</p>
            <ul style="width: 103%;overflow: auto;">
                <!--没有商品时显示一个空箱子图片-->
                <?php if(empty($waters)){?>
                    <li class="item-content">
                        <div class="item-inner fl">
                           <img src="./static/images/empty.png">
                        </div>
                    </li>
                <?php }else{?>



                <?php foreach($waters as $water){
                 echo ' <li class="item-content">
                        <div class="item-media fl"><i class="icon icon-f7"><img src="'.$water["url"].'"></i></div>
                        <div class="item-inner fl">
                            <div class="item-title">
                                <a href="#" class="item-name">'.$water["Name"].'</a>
                                <p class="item-intro row_two">更优质的矿泉水</p>
                                <p class="item-sell">已售：<span>'.rand(100,999).'</span></p>
                                <p class="item-money">￥'.$water["OriginalPrice"].' <span>￥'.($water["OriginalPrice"]+5).'</span></p>
                            </div>
                            <div class="item-after" style="background-color: #f36b35; margin-right: .2rem;"><a href="javascript:void(0);" onclick="callphone()" style="color: #f2f0f0;">购买</a></div>
                        </div>
                    </li>';
                }
                }?>
            </ul>
        </div>

        <!--茶吧机列表-->
        <div class="list-block" id="tea" style="width: 96%;overflow: hidden; display: none;" >
            <p class="list-title">茶吧机</p>
            <ul style="width: 103%;overflow: auto;">
                <li class="item-content">
                    <div class="item-media fl"><i class="icon icon-f7"><img src="./static/images/tea4.jpg"></i></div>
                    <div class="item-inner fl">
                        <div class="item-title">
                            <a href="#" class="item-name">太极茶吧机</a>
                            <p class="item-intro row_two" style="color: #666">更优质的矿泉水</p>
                            <p class="item-sell" style="color: #666">已售：<span>368</span></p>
                            <p class="item-money" style="color: #666">￥299 <span>￥399</span></p>
                        </div>
                        <div class="item-after" style="background-color: #f36b35; margin-right: .5rem;"><a href="javascript:void(0);" onclick="callphone()" style="color: #f2f0f0;">购买</a></div>
                    </div>
                </li>
            </ul>
        </div>


    </div>
    <!--菜单-->
    <div class="panel panel-left panel-reveal theme-dark container_left" id='panel-left-demo'>
        <div class="content-block">
            <p style="height: 50px;"><a href="javascript:void(0);" id="h">热销<img src="./static/images/hot.png"></a></p>
            <p style="height: 50px;"><a href="javascript:void(0);" id="w">袋装水<img src="./static/images/water.png"></a></p>
            <p style="height: 50px;"><a href="javascript:void(0);" id="t">茶吧机<img src="./static/images/tea.png"></a></p>

        </div>
    </div>
</div>


<script type='text/javascript' src='./static/js/zepto.min.js' charset='utf-8'></script>
<script type='text/javascript' src='./static/js/sm.min.js' charset='utf-8'></script>
<script type='text/javascript' src='./static/js/sm-extend.min.js' charset='utf-8'></script>
<script>


    $(function(){
        var height=$(document.body).outerHeight(true);
        $(".list-block ul").css({"height":height-200});
        $(".panel").css({"height":height});
        $("#h").on("click",function(){
            $('#hot').show();
            $('#water').hide();
            $('#tea').hide();
            $('#h').css('background','#fff');
            $('#w').css('background','#f8f8f8');
            $('#t').css('background','#f8f8f8');
        });
        $("#w").on("click",function(){
            $('#water').show();
            $('#hot').hide();
            $('#tea').hide();
            $('#w').css('background','#fff');
            $('#h').css('background','#f8f8f8');
            $('#t').css('background','#f8f8f8');
        });
        $("#t").on("click",function(){
            $('#tea').show();
            $('#water').hide();
            $('#hot').hide();
            $('#t').css('background','#fff');
            $('#w').css('background','#f8f8f8');
            $('#h').css('background','#f8f8f8');
        });

    });

    //打电话弹框
    function callphone(){

        //利用对话框返回的值 （true 或者 false）
        if (confirm("确定拨打<?=$agent_info[0]['ContractTel']?>吗？")) {
            window.location.href = "tel:<?=$agent_info[0]['ContractTel']?>";
        }
        else {

        }
    }

</script>
</body>
</html>