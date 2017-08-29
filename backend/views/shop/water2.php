<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="/favicon.ico">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <link rel="stylesheet" href="./static/css/sm.min.css">
    <link rel="stylesheet" href="./static/css/sm-extend.min.css">
    <link rel="stylesheet" href="./static/css/index.css">

        <style>
            *{
                margin:0px;
                padding:0px;
            }
            body{
                width:100%;
                height:100%;
                position:absolute;
            }
            .page1{
                position:relative;
                width:100%;
                /*height:100%;*/
                margin-top: 100px;
            }
            .container_left{
                /*background: green;*/
                width:100px;
                height:100%;
                left:0px;
                position: absolute;

            }
            .container_right{
                /*background: red;*/
                left:100px;
                position: absolute;
                right:0px;
                height:100%;

            }
            .header{
                position: fixed;
                top: 0;
                height: auto;
            }
        </style>




</head>
<body >
<div class="header" >
    <div class="header_img fl"><img src="images/tel.jpg" alt=""/></div>
    <div class="header_info fl">
        <p class="info_title row_one">̫����д�ŷ������ĵ�</p>
        <p class="row_two">��ַ����˹�ٷ����շ�ɳ��˹</p>
        <p class="row_two">��飺����ֻ������ˮ���ü��˺ȵ���ȫ���ĵ�ˮ</p>
    </div>
</div>
<div class="page">


    <div class="content list-content container_right">
        <!--�����б�-->
        <div class="list-block" id="hot" >
            <p class="list-title">����</p>
            <ul>
                <li class="item-content">
                    <div class="item-media fl"><i class="icon icon-f7"><img src="./static/images/tea.jpg"></i></div>
                    <div class="item-inner fl">
                        <div class="item-title">
                            <a href="#" class="item-name">��Ϊ̫��ˮ</a>
                            <p class="item-intro row_one">�����ʵĿ�Ȫˮ�����ʵĿ�Ȫˮ</p>
                            <p class="item-sell">���ۣ�<span>111</span></p>
                            <p class="item-money">��8 <span>��10</span></p>
                        </div>
                        <div class="item-after">����</div>
                    </div>
                </li>
                <li class="item-content">
                    <div class="item-media fl"><i class="icon icon-f7"><img src="./static/images/tea.jpg"></i></div>
                    <div class="item-inner fl">
                        <div class="item-title">
                            <a href="#" class="item-name">��Ϊ̫��ˮ</a>
                            <p class="item-intro row_one">�����ʵĿ�Ȫˮ</p>
                            <p class="item-sell">���ۣ�<span>111</span></p>
                            <p class="item-money">��8 <span>��10</span></p>
                        </div>
                        <div class="item-after">����</div>
                    </div>
                </li>
                <li class="item-content">
                    <div class="item-media fl"><i class="icon icon-f7"><img src="./static/images/tea.jpg"></i></div>
                    <div class="item-inner fl">
                        <div class="item-title">
                            <a href="#" class="item-name">��Ϊ̫��ˮ</a>
                            <p class="item-intro row_one">�����ʵĿ�Ȫˮ</p>
                            <p class="item-sell">���ۣ�<span>111</span></p>
                            <p class="item-money">��8 <span>��10</span></p>
                        </div>
                        <div class="item-after">����</div>
                    </div>
                </li>
                <li class="item-content">
                    <div class="item-media fl"><i class="icon icon-f7"><img src="./static/images/tea.jpg"></i></div>
                    <div class="item-inner fl">
                        <div class="item-title">
                            <a href="#" class="item-name">��Ϊ̫��ˮ</a>
                            <p class="item-intro row_one">�����ʵĿ�Ȫˮ</p>
                            <p class="item-sell">���ۣ�<span>111</span></p>
                            <p class="item-money">��8 <span>��10</span></p>
                        </div>
                        <div class="item-after">����</div>
                    </div>
                </li>
                <li class="item-content">
                    <div class="item-media fl"><i class="icon icon-f7"><img src="./static/images/tea.jpg"></i></div>
                    <div class="item-inner fl">
                        <div class="item-title">
                            <a href="#" class="item-name">��Ϊ̫��ˮ</a>
                            <p class="item-intro row_one">�����ʵĿ�Ȫˮ</p>
                            <p class="item-sell">���ۣ�<span>111</span></p>
                            <p class="item-money">��88 <span>��100</span></p>
                        </div>
                        <div class="item-after">����</div>
                    </div>
                </li>
            </ul>
        </div>
        <!--����ˮ�б�-->
        <div class="list-block hide" id="water" style="display: none">
            ����ˮ

            <p class="list-title">����ˮ</p>
            <ul>
                <li class="item-content">
                    <div class="item-media fl"><i class="icon icon-f7"><img src="./static/images/1.jpg"></i></div>
                    <div class="item-inner fl">
                        <div class="item-title">
                            <a href="#" class="item-name">��Ϊ̫��ˮ</a>
                            <p class="item-intro row_one">�����ʵĿ�Ȫˮ</p>
                            <p class="item-sell">���ۣ�<span>111</span></p>
                            <p class="item-money">��8 <span>��10</span></p>
                        </div>
                        <div class="item-after">����</div>
                    </div>
                </li>
            </ul>
        </div>

        <!--��ɻ��б�-->
        <div class="list-block hide" id="tea" style="display: none">
            <p class="list-title">��ɻ�</p>
            <ul>
                <li class="item-content">
                    <div class="item-media fl"><i class="icon icon-f7"><img src="./static/images/2.jpg"></i></div>
                    <div class="item-inner fl">
                        <div class="item-title">
                            <a href="#" class="item-name">��Ϊ̫��ˮ</a>
                            <p class="item-intro row_one">�����ʵĿ�Ȫˮ</p>
                            <p class="item-sell">���ۣ�<span>111</span></p>
                            <p class="item-money">��8 <span>��10</span></p>
                        </div>
                        <div class="item-after">����</div>
                    </div>
                </li>
            </ul>
        </div>


        <!--<div  style="position:fixed;width: 80px;bottom: 20px;right: 10px;">-->
        <!--<div class="item-inner">-->
        <!--<div class="col-50" style= "margin-right: 0;"><a href="tel:15008434161"  ><img src="images/tel.jpg" style="width: 100px"></a></div>-->
        <!--</div>-->
        <!--</div>-->

    </div>
    <!--�˵�-->
<!--    <div class="panel panel-left panel-reveal theme-dark container_left" id='panel-left-demo'>-->
<!--        <div class="content-block">-->
<!--            <p><a href="javascript:void(0);" id="h" onclick="hot()">����<img src="./static/images/hot.jpg"></a></p>-->
<!--            <p><a href="javascript:void(0);" id="w" onclick="water()">��װˮ<img src="./static/images/water.jpg"></a></p>-->
<!--            <p><a href="javascript:void(0);" id="t" onclick="tea()">��ɻ�<img src="./static/images/tea.jpg"></a></p>-->
<!---->
<!--        </div>-->
<!--    </div>-->

    <!--�˵�-->
    <div class="container_left panel panel-left panel-reveal theme-dark" id='panel-left-demo' style="display:block; background-color: black">
        <div class="content-block">
            <p><a href="javascript:void(0);" style="color: white;" id="w" onclick="water()">��װˮ<img src="./static/images/water.jpg" width="10px"></a></p>
            <p><a href="javascript:void(0);" style="color: slateblue"  id="t" onclick="tea()">��ɻ�<img src="./static/images/tea.jpg" width="15px"></a></p>

        </div>

    </div>
</div>


<script type='text/javascript' src='./static/js/zepto.min.js' charset='utf-8'></script>
<script type='text/javascript' src='./static/js/sm.min.js' charset='utf-8'></script>
<script type='text/javascript' src='./static/js/sm-extend.min.js' charset='utf-8'></script>
<script>
    function hot(){
        $('#hot').show();
        $('#water').hide();
        $('#tea').hide();
        $('#h').css('background','#fff');
        $('#w').css('background','#f8f8f8');
        $('#t').css('background','#f8f8f8');
    }
    function water(){
        $('#water').show();
        $('#hot').hide();
        $('#tea').hide();
        $('#w').css('background','#fff');
        $('#h').css('background','#f8f8f8');
        $('#t').css('background','#f8f8f8');
    }
    function tea(){
        $('#tea').show();
        $('#water').hide();
        $('#hot').hide();
        $('#t').css('background','#fff');
        $('#w').css('background','#f8f8f8');
        $('#h').css('background','#f8f8f8');
    }



    //    $(function(){
    //        var height=$(document.body).outerHeight(true);
    //        $(".list-block ul").css({"height":height-200});
    //        $(".panel").css({"height":height});
    //        $("#h").on("click",function(){
    //            $('#hot').show();
    //            $('#water').hide();
    //            $('#tea').hide();
    //            $('#h').css('background','#fff');
    //            $('#w').css('background','#f8f8f8');
    //            $('#t').css('background','#f8f8f8');
    //        })
    //        $("#w").on("click",function(){
    //            $('#water').show();
    //            $('#hot').hide();
    //            $('#tea').hide();
    //            $('#w').css('background','#fff');
    //            $('#h').css('background','#f8f8f8');
    //            $('#t').css('background','#f8f8f8');
    //        })
    //        $("#t").on("click",function(){
    //            $('#tea').show();
    //            $('#water').hide();
    //            $('#hot').hide();
    //            $('#t').css('background','#fff');
    //            $('#w').css('background','#f8f8f8');
    //            $('#h').css('background','#f8f8f8');
    //        })
    //    })
</script>
</body>
</html>