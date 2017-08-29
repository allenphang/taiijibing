<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title><?=$title?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta itemprop="name" content="">
    <meta name="description" itemprop="description" content="">
    <link rel="stylesheet" href="/css/weui.css"/>
    <link rel="stylesheet" href="/static/css/globo.css"/>
    <link rel="stylesheet" href="/css/weui2.css"/>
    <link rel="stylesheet" href="/static/css/coderlu.css"/>
    <script src="/static/js/common.js?v=1.2"></script>
    <script src="/static/js/jquery-2.1.4.min.js"></script>
    <script src="/static/js/coderlu.js"></script>
    <script>
        var _washDetails=<?=json_encode($data)?>;
        var _controlsAll=_washDetails.controls;
        var distid='<?=$distid?>';
        var _carnos=<?=json_encode($carnos)?>;
    </script>
    <style>
        .dialog_container{
            position:fixed;
            left:0px;
            top:0px;
            width: 100%;
            height:100%;
            background:rgba(0,0,0,0.5)!important;background:#000;filter:Alpha(opacity=60);
        }
        .arrow_img {
            width: 90px;
            position: absolute;
            left:50%;
            margin-left:20px;
            top:20px;
            background:transparent;
        }
        .share_img
        {
            height:70px;
            position:absolute;
            top:110px;
            left:50%;
            margin-left:-40px;
            background:transparent;

        }
        .share_tips
        {
            position:absolute;
            top:200px;
            font-size:20px;
            color:White;
            text-align:center;
            width:100%;
            font-weight:bolder;
            background:transparent;
        }
        .share_tips1
        {
            position:absolute;
            top:240px;
            font-size:16px;
            color:White;
            text-align:center;
            width:100%;
            background:transparent;
        }

    </style>
</head>
<body>
<!--自驾游详情页-->
<div class="product-drive"  id="washcar">
    <!--banner-->
    <div class="banner">
        <img v-bind:src="washDetails.img"/>
        <i class="icon icon-fanhui" onclick="history.go(-1)"></i>
    </div>
    <!--详情页简介-->
    <div class="details-all">
        <div class="product-details">
            <h2>{{washDetails.title}}</h2>
            <p><span class="new-money" v-text="price_range"></span><span class="long-money">￥{{washDetails.orgprice}}</span></p>
        </div>
        <div class="product-num">
            <span class="yunfei">运费：
                <span v-if="washDetails.express == 0">免运费</span>
                <span v-else>运费到付</span>
            </span>
            <span class="xiaoliang">销量：<span>{{washDetails.sold}}</span></span>
        </div>
    </div>
    <!--购买时间-->
    <div class="pay-num clearfix" style="display:none;">
        <div class="weui-cell weui-cell_access" v-on:click="showControlsFromPage()">
            <div class="weui-cell__bd">
                <p>选择：商品类型</p>
            </div>
            <div class="weui-cell__ft"></div>
        </div>
    </div>
    <!--公告-->
    <div class="product-notice" v-show="showTips">
        <p class="notice-msg"><i class="icon icon-notice"></i>{{washDetails.tips}}</p>
    </div>
    <!--图片-->
    <div class="product-img" style="padding-bottom:80px;">
        <ul v-for="img in washDetails.descimgs">
            <li><img v-bind:src="img" alt=""/></li>
        </ul>
        <ul v-for="img in washDetails.featureimgs">
            <li><img v-bind:src="img" alt=""/></li>
        </ul>
    </div>
    <!--底部-->
    <div class="product-notice" style="position:fixed;left:0px;bottom:45px;width:100%;height:30px;" v-show="hasSellOut">
        <p class="notice-msg" style="text-align:center;"> 商品已售罄,看看其他商品吧!</p>
    </div>
    <div class="product-foot line-top" style="display:none;">

        <div class="fenxiang">
            <a v-bind:href="callStr"><i class="icon icon-call"></i></a>
            <i class="icon icon-fenxiang" v-on:click="clickShare()" v-show="showShare"></i>
        </div>
        <div class="product-btn"  v-on:click="showControls()" v-text="btnLabel"></div>
    </div>
    <!--上门洗车弹窗-->
    <div class="mask-1" id="controlContainer" v-show="showContainer">
        <div class="mask-product">
            <!--标题-->
            <div id="title" class="title">
                <img v-bind:src="washDetails.img"/>
                <div class="msg">
                    <p>{{washDetails.title}}</p>
                    <span v-text="price_range"></span>
                </div>
                <i class="icon icon-error" v-on:click="closeContainer"></i>
            </div>
                <div id="product">
                    <!--出行时间-->
                    <div id="cx_sj" class="cx-time controlitem" ctype="10101" v-show="showTotalLimit">
                        <p id="cx_sj_name" v-text="cx_sj_name"></p>
                    </div>
                    <!--出行时间1-->
                    <div id="chexing1" class="weui-cell weui-cell_access controlitem"  ctype="10101" v-show="showDayLimit" v-on:click="selectSingleDay();">
                        <div class="weui-cell__bd">
                            <p  v-text="cx_sj_name"></p>
                        </div>
                        <div class="weui-cell__ft" v-text="singleSelectedDate"></div>
                    </div>
                    <!--车牌-->
                    <div id="plate" class="weui-cell weui-cell_access controlitem"  ctype="10205" v-on:click="showCarnoInput();">
                        <div class="weui-cell__hd"><label class="weui-label" style="padding:0;" v-text="kj_cp_name">车牌</label></div>
                        <div class="weui-cell__bd"><p id="plate_text"></p></div>
                        <div class="weui-cell__ft"></div>
                    </div>
                    <!--车型-->
                    <div id="chexing" class="weui-cell weui-cell_access controlitem"  ctype="10206" v-on:click="selectCarType();">
                        <div class="weui-cell__bd">
                            <p v-text="kj_cx_name">车型</p>
                        </div>
                        <div class="weui-cell__ft" id="chexingText"></div>

                    </div>
                    <!--e泊特价-->
                    <div id="ebo_tj" class="cx-time controlitem" ctype="10102">
                        <b id="ebo_tj_name" v-text="ebo_tj_name"></b>
                    </div>
                    <!--商品描述-->
                    <div id="sp_ms" class="cx-time controlitem" ctype="10209">
                        <p id="sp_ms_name" v-text="sp_ms_name"></p>
                    </div>
                    <!--取票方式-->
                    <div id="qp_fs" class="cx-time controlitem" ctype="10211">
                        <p id="qp_fs_name" v-text="qp_fs_name"></p>
                    </div>
                    <!--购买数量-->
                    <div id="gm_sl" class="gm-sl controlitem" ctype="10201">
                        <div style="flex: 1"><p id="gm_name" v-text="gm_sl"></p><p v-show="showAmountLimit">每人限购<span class="js_copies1" id="gm_num" v-text="maxBuyLimit"></span>件,还可购买<span v-text="canBuy"></span>件</p></div>
                        <div class="pay-addDetele">
                            <button class="jian" id="js_jian1" v-on:click="amountDel();" v-show="showAmountDelBtn">-</button>
                            <button class="add-num" id="js_num1" v-text="buyAmount"></button>
                            <button class="jia" id="js_jia1" v-show="showAmountAddBtn" v-on:click="amountAdd();">+</button>
                        </div>
                    </div>
                    <!--你的名字-->
                    <div id="name" class="weui-cell controlitem" ctype="10202">
                        <div class="weui-cell__bd">
                            <p v-text="kj_name_name">你的名字</p>
                        </div>
                        <div class="weui-cell__ft">
                            <input id="js_name" style="text-align: right" class="weui-input" type="text"  placeholder="你的名字">
                        </div>
                    </div>
                    <!--身份证-->
                    <div id="idcard" class="weui-cell controlitem" ctype="10204">
                        <div class="weui-cell__bd">
                            <p v-text="kj_idcard_name">身份证</p>
                        </div>
                        <div class="weui-cell__ft">
                            <input id="js_idCard" style="text-align: right" class="weui-input" type="text"  placeholder="身份证">
                        </div>
                    </div>
                    <!--车位信息-->
                    <div id="chewei" class="weui-cell controlitem" ctype="10207">
                        <div class="weui-cell__bd">
                            <p v-text="kj_carport_name">车位信息</p>
                        </div>
                        <div class="weui-cell__ft">
                            <input id="js_cwxx" style="text-align: right" class="weui-input" type="text"  placeholder="车位信息">
                        </div>
                    </div>
                    <!--你的手机号-->
                    <div id="phone" class="weui-cell controlitem" ctype="10203">
                        <div class="weui-cell__bd">
                            <p v-text="kj_tel_name">你的手机号</p>
                        </div>
                        <div class="weui-cell__ft">
                            <input id="js_phone" style="text-align: right" class="weui-input" type="text"  placeholder="你的手机号">
                        </div>
                    </div>

                </div>
        </div>
        <button class="next-btn" id="js_next_btn" v-on:click="submit();">下一步</button>
    </div>



</div>
<!--车牌-->
<div class="Mask">
    <!--汉字键盘-->
    <div class="key" id="_keyboardChinese">
        <div class="keyboard">
            <span class="keyboard_item" data-id="">京</span>
            <span class="keyboard_item" data-id="">津</span>
            <span class="keyboard_item" data-id="">冀 </span>
            <span class="keyboard_item" data-id="">鲁</span>
            <span class="keyboard_item" data-id="">晋</span>
            <span class="keyboard_item" data-id="">蒙</span>
            <span class="keyboard_item" data-id="">辽</span>
            <span class="keyboard_item" data-id="">吉</span>
            <span class="keyboard_item" data-id="">黑</span>
            <span class="keyboard_item" data-id="">沪</span>
            <span class="keyboard_item" data-id="">苏</span>
            <span class="keyboard_item" data-id="">浙</span>
            <span class="keyboard_item" data-id="">皖</span>
            <span class="keyboard_item" data-id="">闽</span>
            <span class="keyboard_item" data-id="">赣</span>
            <span class="keyboard_item" data-id="">豫</span>
            <span class="keyboard_item" data-id="">鄂</span>
            <span class="keyboard_item" data-id="">湘</span>
            <span class="keyboard_item" data-id="">粤</span>
            <span class="keyboard_item" data-id="">桂</span>
            <span class="keyboard_item" data-id="">渝</span>
            <span class="keyboard_item" data-id="">川</span>
            <span class="keyboard_item" data-id="">贵</span>
            <span class="keyboard_item" data-id="">台</span>
            <span class="keyboard_item" data-id="">宁</span>
            <span class="keyboard_item" data-id="">云</span>
            <span class="keyboard_item" data-id="">藏</span>
            <span class="keyboard_item" data-id="">陕</span>
            <span class="keyboard_item" data-id="">甘</span>
            <span class="keyboard_item" data-id="">青</span>
            <span class=" keyboard_on" id="clear" style="width: 20%;display:none;">清空</span>
            <span class="keyboard_item" data-id="">琼</span>
            <span class="keyboard_item" data-id="">新</span>
            <span class="keyboard_item" data-id="">港</span>
            <span class="keyboard_item" data-id="">澳</span>
            <span class=" keyboard_on" id="cancel" style="width: 20%">取消</span>
        </div>
    </div>
    <!--字母数字键盘-->
    <div class="key" id="_keyboardEnglish">
        <div class="keyboard">
            <span class="keyboard_item" data-id="">1</span>
            <span class="keyboard_item" data-id="">2</span>
            <span class="keyboard_item" data-id="">3</span>
            <span class="keyboard_item" data-id="">4</span>
            <span class="keyboard_item" data-id="">5</span>
            <span class="keyboard_item" data-id="">6</span>
            <span class="keyboard_item" data-id="">7</span>
            <span class="keyboard_item" data-id="">8</span>
            <span class="keyboard_item" data-id="">9</span>
            <span class="keyboard_item" data-id="">0</span>
            <span class="keyboard_item" data-id="">Q</span>
            <span class="keyboard_item" data-id="">W</span>
            <span class="keyboard_item" data-id="">E</span>
            <span class="keyboard_item" data-id="">R</span>
            <span class="keyboard_item" data-id="">T</span>
            <span class="keyboard_item" data-id="">Y</span>
            <span class="keyboard_item" data-id="">U</span>
            <span class="keyboard_item" data-id="">P</span>
            <span class="keyboard_item" data-id="">A</span>
            <span class="keyboard_item" data-id="">S</span>
            <span class="keyboard_item" data-id="">D</span>
            <span class="keyboard_item" data-id="">F</span>
            <span class="keyboard_item" data-id="">G</span>
            <span class="keyboard_item" data-id="">H</span>
            <span class="keyboard_item" data-id="">J</span>
            <span class="keyboard_item" data-id="">K</span>
            <span class="keyboard_item" data-id="">L</span>
            <span class="keyboard_item" data-id="">Z</span>
            <span class="keyboard_item" data-id="">C</span>
            <span class="keyboard_item" data-id="">V</span>
            <span class="keyboard_item" data-id="">B</span>
            <span class="keyboard_item" data-id="">N</span>
            <span class="keyboard_item" data-id="">M</span>
            <span class="keyboard_item" data-id="">X</span>
            <span class="keyboard_item" data-id="">学</span>
            <span class="keyboard_item" data-id="">领</span>
            <span class="keyboard_on" data-id="" id="delete">删</span>
            <span class="keyboard_on" id="finish" style="width: 16%">完成</span>
        </div>
    </div>
    <!--默认车牌-->
    <div class="showPlate">默认车牌：<span id="_showPlate"></span></div>
</div>
<!--键盘-->
<iframe src="" style="position:fixed;top:0px;left:0px;width:100%;min-height: 100%;display:none;z-index:10000000;" frameborder="0" id="selectCarType"></iframe>
<div class="share_dialog dialog_container"  style="display:none;">
    <img src="/static/images/arrow.png" class="arrow_img"/>
    <img src="/static/images/share-pictures.png" class="share_img" style="display:none;"/>
    <p class="share_tips">点击右上角</p>
    <p class="share_tips1">发送给朋友&nbsp;&nbsp;&nbsp;&nbsp;或&nbsp;&nbsp;&nbsp;&nbsp;分享到朋友圈</p>
</div>
</body>
<script src="/static/js/vue.min.js"></script>
<script src="/static/js/lib.js"></script>
<script src="/static/js/detail.js?v=1.7"></script>
</html>