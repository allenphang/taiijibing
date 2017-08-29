var config={};
var paytypeParams={};
//微信缴停车费
paytypeParams.parkfee_wx=1;
//停车费e泊支付
paytypeParams.parkfee_e=2;
//微信充值
paytypeParams.recharge=3;
//翼支付
paytypeParams.parkfee_yi=5
config.paytype=paytypeParams;
var QINIU_ADDR="http://7xpcl7.com2.z0.glb.qiniucdn.com/";
var WX_URL="http://wx.ebopark.com";

//var QINIU_ADDR="http://7xodpu.com1.z0.glb.clouddn.com/";//test
//获取url参数
function getQueryString(name) {
			var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i"); 
			var r = window.location.search.substr(1).match(reg); 
			if (r != null) return r[2]; return null;
}
//验证手机号
function validateTel(tel){
	var reg = /^0?1[3|4|5|8|7][0-9]\d{8}$/;
	if (!reg.test(tel)) {

		return false;
	}
	return true;
}
function isIdCardNo(idcardno){
	var _regIdCard = /^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X)$/;
	if(!_regIdCard.test(idcardno)){
		return false;
	}
	return true;
}
//是否存在指定函数
function isExitsFunction(funcName) {
	try {
		if (typeof(eval(funcName)) == "function") {
			return true;
		}
	} catch(e) {}
	return false;
}
function setCookie(name, value) {
	var Days = 365;
	var exp = new Date();
	exp.setTime(exp.getTime() + Days * 24 * 60 * 60 * 1000);
	document.cookie = name + "=" + escape(value) + ";expires=" + exp.toGMTString()+";path=/";
}
//读取cookies
function getCookie(name) {
	var arr, reg = new RegExp("(^| )" + name + "=([^;]*)(;|$)");
	if (arr = document.cookie.match(reg))
		return unescape(arr[2]);
	else
		return null;
}

//删除cookies
function delCookie(name) {
	var exp = new Date();
	exp.setTime(exp.getTime() - 1);
	var cval = getCookie(name);
	if (cval != null)
		document.cookie = name + "=" + cval + ";expires=" + exp.toGMTString();
}
String.prototype.replaceAll = function(reallyDo, replaceWith, ignoreCase) {
    if (!RegExp.prototype.isPrototypeOf(reallyDo)) {
        return this.replace(new RegExp(reallyDo, (ignoreCase ? "gi": "g")), replaceWith);
    } else {
        return this.replace(reallyDo, replaceWith);
    }
}
// 对Date的扩展，将 Date 转化为指定格式的String
// 月(M)、日(d)、小时(h)、分(m)、秒(s)、季度(q) 可以用 1-2 个占位符，
// 年(y)可以用 1-4 个占位符，毫秒(S)只能用 1 个占位符(是 1-3 位的数字)
// 例子：
// (new Date()).Format("yyyy-MM-dd hh:mm:ss.S") ==> 2006-07-02 08:09:04.423
// (new Date()).Format("yyyy-M-d h:m:s.S")      ==> 2006-7-2 8:9:4.18
Date.prototype.Format = function (fmt) { //author: meizz
	var o = {
		"M+": this.getMonth() + 1,                 //月份
		"d+": this.getDate(),                    //日
		"h+": this.getHours(),                   //小时
		"m+": this.getMinutes(),                 //分
		"s+": this.getSeconds(),                 //秒
		"q+": Math.floor((this.getMonth() + 3) / 3), //季度
		"S": this.getMilliseconds()             //毫秒
	};
	if (/(y+)/.test(fmt))
		fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
	for (var k in o)
		if (new RegExp("(" + k + ")").test(fmt))
			fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
	return fmt;
}
Date.isLeapYear = function (year) {
	return (((year % 4 === 0) && (year % 100 !== 0)) || (year % 400 === 0));
};

Date.getDaysInMonth = function (year, month) {
	return [31, (Date.isLeapYear(year) ? 29 : 28), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][month];
};

Date.prototype.isLeapYear = function () {
	return Date.isLeapYear(this.getFullYear());
};

Date.prototype.getDaysInMonth = function () {
	return Date.getDaysInMonth(this.getFullYear(), this.getMonth());
};

Date.prototype.addMonths = function (value) {
	var n = this.getDate();
	this.setDate(1);
	this.setMonth(this.getMonth() + Number(value));
	this.setDate(Math.min(n, this.getDaysInMonth()));
	return this;
};
Array.prototype.del = function (index) {
	if (isNaN(index) || index >= this.length) {
		return false;
	}
	for (var i = 0, n = 0; i < this.length; i++) {
		if (this[i] != this[index]) {
			this[n++] = this[i];
		}
	}
	this.length -= 1;
}
Array.prototype.addAll=function(arr){
		if(!isArray(arr)){
			return;
		}
		for(var index=0;index<arr.length;index++){
			this.push(arr[index])
		}
	return this;

}
function isArray(arr){
	return arr instanceof Array;
}
function closeWxPage(){
    Window.location.href='/index.php/Home/Tips/closepage';
}

var browser = {
    versions: function () {
        var u = navigator.userAgent, app = navigator.appVersion;
        return {         //移动终端浏览器版本信息
            trident: u.indexOf('Trident') > -1, //IE内核
            presto: u.indexOf('Presto') > -1, //opera内核
            webKit: u.indexOf('AppleWebKit') > -1, //苹果、谷歌内核
            gecko: u.indexOf('Gecko') > -1 && u.indexOf('KHTML') == -1, //火狐内核
            mobile: !!u.match(/AppleWebKit.*Mobile.*/), //是否为移动终端
            ios: !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/), //ios终端
            android: u.indexOf('Android') > -1 || u.indexOf('Linux') > -1, //android终端或uc浏览器
            iPhone: u.indexOf('iPhone') > -1, //是否为iPhone或者QQHD浏览器
            iPad: u.indexOf('iPad') > -1, //是否iPad
            webApp: u.indexOf('Safari') == -1 //是否web应该程序，没有头部与底部
        };
    }(),
    language: (navigator.browserLanguage || navigator.language).toLowerCase()
}

/**
 * 判断浏览器是否为微信环境
 * @returns {boolean}
 */
function isWeixin(){
    if (browser.versions.mobile) {//判断是否是移动设备打开。browser代码在下面

        var ua = navigator.userAgent.toLowerCase();//获取判断用的对象
        if (ua.match(/MicroMessenger/i) == "micromessenger") {
            return true;

        }
         return false;

    }
}
function isIOS(){
    var u = navigator.userAgent;
    var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
    return isiOS;
}
function isAndroid(){
    var u = navigator.userAgent;
    var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Adr') > -1; //android终端
    return isAndroid;
}
function getDeviceName(){
	if(isWeixin()){
		return "微信";
	}
	if(isAndroid()){
		return "安卓";
	}
	if(isIOS()){
		return "IOS";
	}

	return "其他";

}
/**
 * 表单提交
 */
function postForm(url,jsonParam,formId){

    var htmlStr='<form action="'+url+'" id="'+formId+'" method="post">';


        $.each(jsonParam,function(key,value){
            htmlStr+='<input type="hidden" name="'+key+'" value="'+value+'"/>';
        });
    htmlStr+="</form>";
    $("body").append($(htmlStr));
    $("#"+formId).submit();

}
//get请求
function http_get(url,callback){
	$.showIndicator();
	$.getJSON(url,function(data){
		$.hideIndicator();
		if(data.state!=0){
			$.alert(data.msg);
			return;
		}
		callback(data);
	});
}
var EboBridge={

	callNativeFunction:function(funcstr){
		if(isIOS()){
			window.webkit.messageHandlers.Native.postMessage(funcstr);
			return;
		}
		var func=funcstr.replaceAll("&&",",",'g')
		eval("("+func+")");
	},
	callNativePayFunction:function(orderObj,purpose,paytype,callback){
		var methodStr="ebo.pay("+JSON.stringify(orderObj)+"&&"+paytype+"&&"+purpose+"&&"+callback+")";
		if(isIOS()){
			window.webkit.messageHandlers.Native.postMessage(methodStr);
			return;
		}
		ebo.handler(methodStr);


	}

};
        //window.onload=function(){
        //    document.addEventListener("WeixinJSBridgeReady",function(){
        //
        //                WeixinJSBridge.call('hideToolbar');
        //                WeixinJSBridge.call('hideOptionMenu');
        //
        //            }
        //
        //
        //    );
        //
        //}
