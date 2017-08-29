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
    <link rel="stylesheet" href="/static/css/login.css?v=1.1"/>
    <link rel="stylesheet" href="/static/css/coderlu.css"/>
    <title>手机验证</title>

</head>
<body>
<div class="login_c" id="login_c">
    <!-- 手机号码   -->
    <div class="login_input_item">
        <img src="/static/images/sm_phone.png" class="login_icon fl" style="width:18px;margin-top:9px;margin-left:2px;" />
        <input type="text" id="username" class="login_input fl" maxlength="11" placeholder="请填写登录账号"  v-model="username"/>
    </div>
    <div class="clear"></div>
    <div class="divider_line"></div>
    <!-- 手机号码   -->
    <div class="login_input_item">
        <img src="/static/images/sm_msg.png" class="login_icon fl"  style="width:27px;margin-top:17px;" />
        <input type="password" id="password" class="login_input fl" maxlength="11" placeholder="请填写登录密码"  v-model="password"/>
    </div>

    <div class="clear"></div>
    <div class="divider_line"></div>
    <!--提交登录-->
    <input type="button" value="验 证" class="btn_blue submitBtn" v-on:click="submit()"/>
</div>
<script>
    var mobile='<<$mobile>>';
</script>
<script type="text/javascript" src="/static/js/vue.min.js"></script>
<script type="text/javascript" src="/static/js/zepto.min.js"></script>
<script type="text/javascript" src="/static/js/coderlu.js"></script>
<script type="text/javascript" src="/static/js/common.js" ></script>
<script type="text/javascript" src="/static/js/ctr_agent_login_page.js?v=1.3"></script>
</body>
</html>