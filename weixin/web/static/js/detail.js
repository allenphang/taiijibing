/**
 */
var detailVue = null;
$(function () {
    //主页面
    initDetailVue();
});

function initDetailVue() {
    $(".controlitem").hide();
    detailVue = new Vue({
        el: "#washcar",
        data: {
            carnos:[],
            washDetails: _washDetails,
            controlsAll: _controlsAll,
            //share:shares,
            callStr:"tel:"+_washDetails.tel,
            //控件id数组
            controltypeArr: [],
            showContainer: false,
            //购买数量
            buyAmount: 0,
            //购买数量数据
            limitNumObj: null,
            //e泊特价数据
            eboPriceObj: null,
            //出行日期数据
            outDateObj: null,
            //商品描述数据
            goodDescsObj: null,
            //取票方式
            ticketsTypeObj: null,
            //已选择的出行日期
            selectedOutDateIndex: 0,
            //选择的单日出行日期
            singleSelectedDate: '',
            //取票方式
            selectedTicketsType: 0,
            //商品描述
            selectedGoodDesc: 0,
            //商品型号-e泊特价
            selectedGoodsType: 0,
            //出行日期控件名称
            cx_sj_name: '',
            //e泊特价控件名称
            ebo_tj_name: '',
            //商品描述控件名称
            sp_ms_name: '',
            //购买数量控件名称
            gm_sl: '',
            //取票方式控件名称
            qp_fs_name: '',

            //车牌号控件名称
            kj_cp_name: '',
            //车型控件名称
            kj_cx_name: '',
            //姓名控件名称
            kj_name_name: '',
            //身份证
            kj_idcard_name: '',
            //车位信息
            kj_carport_name: '',
            //手机号控件名称
            kj_tel_name: '',
            //是否已售罄
            hasSellOut: _washDetails.issellout == 1,
            btnLabel: _washDetails.issellout == 1 ? "查看其他商品" : "立即购买",
            first_control_name: "",
            price_range: "",
            maxprice: 0,
            minprice: 99999
        },
        computed: {
            showShare:function(){
                //return this.share.state==0&&isWeixin();
                return false;
            },
            showTips:function(){
              return  $.trim(this.washDetails.tips)!="";
            },
            //显示区间出行时间控件
            showTotalLimit: function () {
                if (this.outDateObj == null) {
                    return false;
                }
                return this.outDateObj.Items[0].EnableTotalLimit;
            },
            //显示单日出行时间控件
            showDayLimit: function () {
                var show = this.outDateObj != null && !this.showTotalLimit;
                return show;
            },
            showAmountDelBtn: function () {
                return this.buyAmount > 0;
            },
            showAmountAddBtn: function () {
                return this.buyAmount < this.maxBuyLimit || this.maxBuyLimit < 0;
            },
            showAmountLimit: function () {

               return this.limitNumObj.EnableLimitUser&&this.canBuy<1000;
            },
            //购买数量限制
            maxBuyLimit: function () {
                return this.maxLimitOfTheOne(this.selectedGoodsType, this.selectedOutDateIndex)
            },
            //还可购买数量
            canBuy: function () {
                if(!this.limitNumObj.EnableLimitUser){
                    return this.maxBuyLimit;
                }
                var canBuyAmount = Number(this.maxBuyLimit) - Number(_washDetails.buycount);
                return canBuyAmount<0?0:canBuyAmount;
            }

        },
        methods: {
            initwxShare:function(){
                if(!this.showShare){
                    return;
                }
                initShare();
            },
            clickShare:function(){
                $(".share_dialog").show();
                $(".share_dialog").unbind();
                $(".share_dialog").on("click", function () {
                    $(this).hide();
                });
            },
            maxLimitOfTheOne: function (goodTypeIndex, outdateIndex) {
                var personLimit =!this.limitNumObj.EnableLimitUser?-1: Number(this.limitNumObj.LimitUserCnt);

                var dateLimit = -1;

                if (this.outDateObj != null&&outdateIndex>=0) {
                    //e泊特价限购
                    dateLimit = this.eboPriceObj.Items[goodTypeIndex].Prices[outdateIndex].Total;
                    if (!this.showTotalLimit) {
                        var item = this.eboPriceObj.Items[goodTypeIndex];
                        var days=this.getDaysOfOneGoodAndOneDay(item, outdateIndex);
                        dateLimit = parseInt(dateLimit / (days.length));
                    }

                } else {
                    //没有填出行日期
                    dateLimit = this.eboPriceObj.Items[goodTypeIndex].DefaultTotal;
                }
                if (personLimit < 0) {
                    return dateLimit;
                }
                if (dateLimit < 0) {
                    return dateLimit;
                }
                //是否
                return personLimit < dateLimit ? personLimit : dateLimit;
            },
            priceOfOneGoodItem: function (i) {
                var prices = this.eboPriceObj.Items[i].Prices;
                if (prices.length == 0) {
                    return this.eboPriceObj.Items[i].DefaultPrice;
                }
                return this.eboPriceObj.Items[i].Prices[this.selectedOutDateIndex].Price;
            },
            //获取某一商品型号可出行的时间
            getDaysOfOneGood: function (goodtype) {
                var singleDateArr = [];
                for (var index = 0; index < goodtype.Prices.length; index++) {
                    singleDateArr.addAll(this.getDaysOfOneGoodAndOneDay(goodtype, index));
                }
                return singleDateArr;
            },
            getDaysOfOneGoodAndOneDay: function (goodtype, outdateIndex) {
                var singleDateArr = [];
                var item = goodtype.Prices[outdateIndex];
                var starttime = item.StartTime;
                var endttime = item.EndTime;
                singleDateArr.push(starttime);
                var starttimeArr = starttime.split("-");
                var startDate = new Date();
                startDate.setDate(Number(starttimeArr[2]));
                startDate.setYear(Number(starttimeArr[0]));
                startDate.setMonth(Number(starttimeArr[1]) - 1);
                var starttimeTemp = '';
                do {
                    starttimeTemp = (startDate.addDays(1)).Format("yyyy-MM-dd");
                    if (starttimeTemp <= endttime) {
                        singleDateArr.push(starttimeTemp);
                    }
                } while (starttimeTemp < endttime);
                return singleDateArr;
            },
            //选择单个出行时间
            selectSingleDay: function () {
                var item = this.eboPriceObj.Items[this.selectedGoodsType];
                var days = this.getDaysOfOneGood(item);
                this.showActionSheet(days, function (index) {
                    detailVue.singleSelectedDate = days[index];
                    detailVue.refreshOutDateSelectedIndex();
                });
            },
            //刷新出行时间选择
            refreshOutDateSelectedIndex: function () {
                //var prices = this.eboPriceObj.Items[0].Prices;
                //if (prices.length == 0) {
                //    return;
                //}
                //for (var index = 0; index < prices.length; index++) {
                //    var item = prices[index];
                //    var starttime = item.StartTime;
                //    var endttime = item.EndTime;
                //    if (this.singleSelectedDate <= endttime && this.singleSelectedDate >= starttime) {
                //        this.selectedOutDateIndex = index;
                //        break;
                //    }
                //}
                if(this.singleSelectedDate==""){
                    return;
                }
                var index=this.getOutdateIndexBySingleDate(this.singleSelectedDate);
                this.selectedOutDateIndex = index;
            },
            //获取所属出行时间序号
            getOutdateIndexBySingleDate:function(dt){
                var prices = this.eboPriceObj.Items[0].Prices;
                var outdateindex=-1;
                for (var index = 0; index < prices.length; index++) {
                    var item = prices[index];
                    var starttime = item.StartTime;
                    var endttime = item.EndTime;
                    if (dt <= endttime && dt >= starttime) {
                        outdateindex = index;
                        break;
                    }
                }
                return outdateindex;
            },
            priceOfSingleGood: function () {
                var item = this.eboPriceObj.Items[this.selectedGoodsType];
                if (item.Prices.length == 0) {
                    return item.DefaultPrice;
                }
                return item.Prices[this.selectedOutDateIndex].Price;
            },
            itemidOfSingleGood: function () {
                return this.eboPriceObj.Items[this.selectedGoodsType].ItemId;
            },
            selectCarType: function () {
                $(window.document).find("#selectCarType").attr("src", "/eshop/selectCarType.html");
                $("#selectCarType").show();
            },
            showCarnoInput: function () {
                $.showActionSheet(detailVue.carnos, function (index) {
                    if (detailVue.carnos[Number(index)] == "添加车牌") {
                        carnoInputBoard.show($("#plate_text"));
                        return;
                    }
                    $("#plate_text").text(detailVue.carnos[Number(index)]);
                });


            },
            //减少购买数量
            amountDel: function () {
                if (this.buyAmount <= 0) {
                    return;
                }
                this.buyAmount--;
            },
            //增加购买数量
            amountAdd: function () {
                if (this.buyAmount >= this.canBuy && this.canBuy != -1 && this.maxBuyLimit != -1) {
                    return;
                }
                this.buyAmount++;
            },
            //e泊特价
            onSelectGoodItem: function (index) {
                //var maxLimit = this.maxLimitOfTheOne(index, this.selectedOutDateIndex);
                //if (maxLimit <= 0) {
                //    return;
                //}
                this.selectedGoodsType = index;
            },
            selectGoodItemClass: function (index) {
                //var maxLimit = this.maxLimitOfTheOne(index, this.selectedOutDateIndex);
                //if (maxLimit <= 0) {
                //    return "eboTj_btn unable_class";
                //}
                return index == this.selectedGoodsType ? "eboTj_btn selected_class" : "eboTj_btn unselected_class";
            },
            //商品描述
            onSelectGoodDesc: function (index) {
                this.selectedGoodDesc = index;
            },
            selectGoodDescClass: function (index) {
                return this.selectedGoodDesc == index ? "btn selected_class" : "btn unselected_class";
            },
            //出行日期
            onSelectOutDate: function (index) {
                this.buyAmount = 1;
                this.selectedOutDateIndex = index;
            },
            outDateClass: function (index) {
                return this.selectedOutDateIndex == index ? "qp_btn selected_class" : "qp_btn unselected_class";

            },
            //取票方式
            selectTicketsTypeClass: function (index) {
                return this.selectedTicketsType == index ? "qp_btn selected_class" : "qp_btn unselected_class";
            },
            onSelectTicketsType: function (index) {
                this.selectedTicketsType = index;
            },
            showControls: function () {
                if (this.hasSellOut) {
                    //已售罄
                    window.history.go(-1);
                    return;
                }
                this.showContainer = true;
            },
            showControlsFromPage: function () {
                if (this.hasSellOut) {
                    //已售罄
                    return;
                }
                this.showContainer = true;
            },
            closeContainer: function () {
                this.showContainer = false;
            },
            appendControls: function (_obj) {
                $(_obj).remove();
                $(_obj).prependTo("#product");
                $(_obj).show();
            },
            //初始化出行日期
            initOutDate: function (data) {
                this.outDateObj = data;
                var enableTotalLimit = data.Items[0].EnableTotalLimit;
                this.cx_sj_name = data.Name;
                if (enableTotalLimit) {
                    for (var k = 0; k < data.Items.length; k++) {
                        var str = '';
                        /*多个时间*/
                        str = "<p><button v-bind:class='outDateClass(" + k + ")' v-on:click='onSelectOutDate(" + k + ")'>" +
                            data.Items[k].StartTime + "至" + data.Items[k].EndTime +
                            "</button></p>";
                        $("#cx_sj").append(str);
                    }
                    return;
                }

            }
            ,
            //初始化e泊特价
            initEboPrice: function (data) {
                this.eboPriceObj = data;
                for (var i = 0; i < data.Items.length; i++) {
                    //name遍历
                    var _name = _washDetails.items[i].name;
                    //Pirce的数组
                    var str = "<p><button v-bind:class='selectGoodItemClass(" + i + ")' v-on:click='onSelectGoodItem(" + i + ")'>" +
                        _name + "/" +
                        "<i class='eboTj_money' v-text='priceOfOneGoodItem(" + i + ")'></i>" + "元</button></p>";
                    $("#ebo_tj").append(str)
                }
                this.ebo_tj_name = data.Name;
            },
            initPriceRange: function () {

                if (this.eboPriceObj.Items[0].Prices.length == 0) {
                    for (var i = 0; i < this.eboPriceObj.Items.length; i++) {
                        var price = this.eboPriceObj.Items[i].DefaultPrice;
                        this.refreshPriceRange(price);
                    }
                } else {
                    for (var index = 0; index < this.eboPriceObj.Items.length; index++) {
                        var prices = this.eboPriceObj.Items[index].Prices;
                        for (var priceIndex = 0; priceIndex < prices.length; priceIndex++) {
                            var price = prices[priceIndex].Price;
                            this.refreshPriceRange(price);
                        }
                    }
                }


                this.price_range = this.minprice == this.maxprice ? "￥" + this.minprice : "￥" + this.minprice + "—￥" + this.maxprice;
            },
            refreshPriceRange: function (price) {

                if (Number(price) < Number(this.minprice)) {
                    this.minprice = price;
                }
                if (Number(price) > Number(this.maxprice)) {
                    this.maxprice = price;
                }
            },
            //初始化商品描述
            initGoodDesc: function (data) {
                this.goodDescsObj = data;
                for (var i = 0; i < data.FieldValues.length; i++) {
                    var str = "<p><button v-bind:class='selectGoodDescClass(" + i + ")' v-on:click='onSelectGoodDesc(" + i + ")'>" + data.FieldValues[i] + "</button></p>";
                    $("#sp_ms").append(str);
                }
                this.sp_ms_name = data.Name;

            },
            //初始化购买数量
            initBuyNumLimit: function (data) {
                this.limitNumObj = data;
                this.gm_sl = data.Name;

            },
            initGetTicketsType: function (data) {
                this.ticketsTypeObj = data;
                for (var i = 0; i < data.FieldValues.length; i++) {
                    var str = "<p><button v-bind:class='selectTicketsTypeClass(" + i + ")' v-on:click='onSelectTicketsType(" + i + ")'>" + data.FieldValues[i] + "</button></p>";
                    $("#qp_fs").append(str)
                }
                this.qp_fs_name = data.Name;

            },
            initControls: function () {
                var reverseArr = _controlsAll;
                for (var index = 0; index < reverseArr.length; index++) {
                    var item = reverseArr[index];
                    var dataObj = JSON.parse(item.data);
                    dataObj.ControlType = item.type;
                    if (this.initControlByType(dataObj)) {
                        var obj = $("div[ctype=" + dataObj.ControlType + "]");
                        this.appendControls(obj);
                        if (index == reverseArr.length - 1) {
                            //第一个控件显示在首页
                            //$(".pay-num").empty();
                            //$(obj).clone(true).prependTo(".pay-num");
                            this.first_control_name = dataObj.Name;
                        }
                    }

                }

            },
            initControlByType: function (dataObj) {
                var isValid = false;
                this.controltypeArr.push(dataObj.ControlType);
                switch (dataObj.ControlType) {
                    //出行日期
                    case 10101:
                        isValid = true;
                        this.initOutDate(dataObj);
                        break;
                    //e泊特价
                    case 10102:
                        isValid = true;
                        this.initEboPrice(dataObj);
                        break;
                    //商品描述
                    case 10209:
                        isValid = true;
                        this.initGoodDesc(dataObj);
                        break;
                    //购买数量
                    case 10201:
                        isValid = true;
                        this.initBuyNumLimit(dataObj);
                        break;
                    //名字
                    case 10202:
                        this.kj_name_name = dataObj.Name;
                        isValid = true;
                        break;
                    //手机号
                    case 10203:
                        this.kj_tel_name = dataObj.Name;
                        isValid = true;
                        break;
                    //身份证
                    case 10204:
                        this.kj_idcard_name = dataObj.Name;
                        isValid = true;
                        break;
                    //车牌号
                    case 10205:
                        this.kj_cp_name = dataObj.Name;
                        isValid = true;
                        break;
                    //车型
                    case 10206:
                        this.kj_cx_name = dataObj.Name;
                        isValid = true;
                        break;
                    //车位
                    case 10207:
                        this.kj_carport_name = dataObj.Name;
                        isValid = true;
                        break;
                    //取票方式
                    case 10211:
                        isValid = true;
                        this.initGetTicketsType(dataObj);
                        break;
                }
                return isValid;
            },
            initSelectedGoodTypeIndex: function () {
                for (var itemIndex = 0; itemIndex < this.eboPriceObj.Items.length; itemIndex++) {
                    var maxNum = this.maxLimitOfTheOne(itemIndex, this.selectedOutDateIndex);
                    if (maxNum > 0) {
                        this.selectedGoodsType = itemIndex;
                        break;
                    }

                }
            },
            showActionSheet: function (arr, callback) {
                if (!isArray(arr) || arr.length == 0) {
                    return;
                }
                var tplObjStr = '<div class="dialog_container">' +
                    '<div class="list_dialog_content">' +
                    '<ul>';

                if (arr.length == 1) {
                    var  enable_click=this.enableClickOutdate(arr[0]);
                    var color=enable_click?"color:gray":"";
                    tplObjStr += '<li class="list_dialog_firstli list_dialog_bottomli" index="0" style="'+color+'">' + arr[0] + '</li>';
                } else {
                    for (var i = 0; i < arr.length; i++) {
                        var  enable_click=this.enableClickOutdate(arr[i]);
                        var color=enable_click?"":"color:gray";
                        if (i == 0) {
                            tplObjStr += '<li class="list_dialog_firstli" index="' + i + '" style="'+color+'">' + arr[i] + '</li>';
                        } else if (i == arr.length - 1) {
                            tplObjStr += '<li class="list_dialog_bottomli" index="' + i + '" style="'+color+'">' + arr[i] + '</li>';
                        } else {
                            tplObjStr += '<li index="' + i + '" style="'+color+'">' + arr[i] + '</li>';
                        }
                    }
                }
                tplObjStr += '</ul>' +
                    '<p class="list_dialog_cancle">取消</p>' +
                    '</div>' +
                    '</div>';
                var telObj = $(tplObjStr);
                $(telObj).find("li").on('click', function () {
                    var index = $(this).attr("index");
                    if(!detailVue.enableClickOutdate(arr[index])){
                        return;
                    }
                    $(".dialog_container").remove();
                    callback(index);
                });
                $(telObj).find(".list_dialog_cancle").on("click", function () {
                    $(".dialog_container").remove();
                });
                $("body").append(telObj);


            },
            enableClickOutdate:function(dt){
                var now= (new Date()).Format("yyyy-MM-dd");
                if(dt<now){
                    return false;
                }
               var outdateindex= this.getOutdateIndexBySingleDate(dt);
                if(outdateindex<0){
                    return false;
                }
                var maxNum = this.maxLimitOfTheOne(this.selectedGoodsType,outdateindex);
                return maxNum>0;
            },
            //提交数据
            submit: function () {
                //var buyout = _washDetails.buycount;
                //if (this.limitNumObj != null && this.limitNumObj.EnableLimitUser) {
                //    //用户id限购
                //    globalLimit = this.limitNumObj.LimitUserCnt;
                //    if (buyout >= globalLimit) {
                //        $.alert("已超出允许的购买数量");
                //        return;
                //    }
                //}
                var _controls = [];
                var controltypeArrStr = this.controltypeArr.toString()
                if (controltypeArrStr.indexOf("10101") != -1) {
                    var cxsjItem = {};
                    cxsjItem.label = this.cx_sj_name;
                    cxsjItem.controltype = 10101;
                    var dateItem = this.outDateObj.Items[this.selectedOutDateIndex]
                    cxsjItem.value = this.showTotalLimit ? (dateItem.StartTime + "至" + dateItem.EndTime) : this.singleSelectedDate;
                    if (cxsjItem.value == "") {
                        $.alert("请选择" + this.cx_sj_name + "!");
                        return;
                    }
                    _controls.push(cxsjItem);
                }
                if (controltypeArrStr.indexOf("10209") != -1) {
                    var GoodDescItem = {};
                    GoodDescItem.label = this.sp_ms_name;
                    GoodDescItem.controltype = 10209;
                    GoodDescItem.value = this.goodDescsObj.FieldValues[this.selectedGoodDesc];
                    _controls.push(GoodDescItem);
                }
                if (controltypeArrStr.indexOf("10201") != -1) {
                    var buyAmountItem = {};
                    buyAmountItem.label = this.gm_sl;
                    buyAmountItem.controltype = 10201;
                    buyAmountItem.value = this.buyAmount;
                    if(buyAmountItem.value==0){
                        $.alert("请选择购买数量!");
                        return;
                    }
                    _controls.push(buyAmountItem);
                }
                if (controltypeArrStr.indexOf("10202") != -1) {
                    var nameItem = {};
                    nameItem.label = this.kj_name_name;
                    nameItem.controltype = 10202;
                    nameItem.value = $("#js_name").val();
                    if ($.trim(nameItem.value) == "") {
                        $.alert(this.kj_name_name + "不能为空!");
                        return;
                    }
                    _controls.push(nameItem);
                }
                if (controltypeArrStr.indexOf("10203") != -1) {
                    var telItem = {};
                    telItem.label = this.kj_tel_name;
                    telItem.controltype = 10203;
                    telItem.value = $("#js_phone").val();
                    if (!validateTel(telItem.value)) {
                        $.alert("请输入格式正确的手机号!");
                        return;
                    }
                    _controls.push(telItem);
                }
                if (controltypeArrStr.indexOf("10204") != -1) {
                    var idCardItem = {};
                    idCardItem.label = this.kj_idcard_name;
                    idCardItem.controltype = 10204;
                    idCardItem.value = $("#js_idCard").val();
                    if (!isIdCardNo(idCardItem.value)) {
                        $.alert("请输入格式正确的身份证号码");
                        return;
                    }
                    _controls.push(idCardItem);
                }
                if (controltypeArrStr.indexOf("10205") != -1) {
                    var carnoItem = {};
                    carnoItem.label = this.kj_cp_name;
                    carnoItem.controltype = 10205;
                    carnoItem.value = $("#plate_text").text();
                    if (carnoItem.value.length != 7) {
                        $.alert("请输入格式正确的车牌号");
                        return;
                    }
                    _controls.push(carnoItem);
                }
                if (controltypeArrStr.indexOf("10206") != -1) {
                    var cartypeItem = {};
                    cartypeItem.label = this.kj_cx_name;
                    cartypeItem.controltype = 10206;
                    cartypeItem.value = $("#chexingText").text();
                    if (cartypeItem.value == "") {
                        $.alert("请选择车型");
                        return;
                    }
                    _controls.push(cartypeItem);
                }
                if (controltypeArrStr.indexOf("10207") != -1) {
                    var cartypeItem = {};
                    cartypeItem.label = this.kj_carport_name;
                    cartypeItem.controltype = 10207;
                    cartypeItem.value = $("#js_cwxx").val();
                    if ($.trim(cartypeItem.value) == "") {
                        $.alert("请输入车位信息");
                        return;
                    }
                    _controls.push(cartypeItem);
                }
                if (controltypeArrStr.indexOf("10211") != -1) {
                    var ticketsTypeItem = {};
                    ticketsTypeItem.label = this.qp_fs_name;
                    ticketsTypeItem.controltype = 10211;
                    ticketsTypeItem.value = this.ticketsTypeObj.FieldValues[this.selectedTicketsType];
                    _controls.push(ticketsTypeItem);
                }
                if (controltypeArrStr.indexOf("10102") != -1) {
                    var goodTypeItem = {};
                    goodTypeItem.label = this.ebo_tj_name;
                    goodTypeItem.controltype = 10102;
                    goodTypeItem.itemid = this.itemidOfSingleGood();
                    goodTypeItem.value = this.priceOfSingleGood();
                    goodTypeItem.price = goodTypeItem.value;
                    _controls.push(goodTypeItem);
                }
                window.sessionStorage.setItem("fields", JSON.stringify(_controls));
                window.sessionStorage.setItem("detail", JSON.stringify(_washDetails));
                window.sessionStorage.setItem("distid", distid);
                window.location.href = "/index.php/Eshop/Open/toPay";


            }
        },
        created: function () {
            this.initControls();

            if (this.showDayLimit) {
                var item = this.eboPriceObj.Items[this.selectedGoodsType];
                var days = this.getDaysOfOneGood(item);
                for(var index=0;index<days.length;index++){
                    var dt=days[index];
                    if(this.enableClickOutdate(dt)){
                        this.singleSelectedDate = dt;
                        break;
                    }
                }
                this.refreshOutDateSelectedIndex();
            }
            this.initPriceRange();
            this.initSelectedGoodTypeIndex();
            //this.initwxShare();
            _carnos.push("添加车牌");
            this.carnos=_carnos;

        }

    });
}
function onSelectCarType(vehicleType) {
    $("#chexingText").text(vehicleType);
    $("#selectCarType").hide();
}
//初始化微信分享
function initShare() {
    var url = window.location.href.split('#')[0];
    var encodeurl=url.replace(new RegExp("&","gm"),"@-");
    $.getJSON("/index.php/Home/Weixin/getSignPackage?url=" + encodeURI(encodeurl), function (data) {
        wxConfig(data);
    });
}
function wxConfig(data) {
    // 注意：所有的JS接口只能在公众号绑定的域名下调用，公众号开发者需要先登录微信公众平台进入“公众号设置”的“功能设置”里填写“JS接口安全域名”。
    // 如果发现在 Android 不能分享自定义内容，请到官网下载最新的包覆盖安装，Android 自定义分享接口需升级至 6.0.2.58 版本及以上。
    // 完整 JS-SDK 文档地址：http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html
    wx.config({
        debug: false,
        appId: data.appId,
        timestamp: data.timestamp,
        nonceStr: data.nonceStr,
        signature: data.signature,
        jsApiList: ['onMenuShareTimeline', 'onMenuShareAppMessage'
            // 所有要调用的 API 都要加到这个列表中
        ]
    });
    wx.ready(function () {
        var url = window.location.href.split('#')[0];
        // 在这里调用 API
        //朋友圈
        wx.onMenuShareTimeline({
            title: shares.result.title, // 分享标题
            link: url, // 分享链接
            imgUrl: shares.result.img, // 分享图标
            success: function () {
                // 用户确认分享后执行的回调函数
                WeixinJSBridge.call('closeWindow');
            },
            cancel: function () {
                // 用户取消分享后执行的回调函数

            }
        });
        //朋友
        wx.onMenuShareAppMessage({
            title: shares.result.title, // 分享标题
            desc:  shares.result.content, // 分享描述
            link: url, // 分享链接
            imgUrl: shares.result.img, // 分享图标
            type: '', // 分享类型,music、video或link，不填默认为link
            dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
            success: function () {
                // 用户确认分享后执行的回调函数
                WeixinJSBridge.call('closeWindow');
            },
            cancel: function () {
                // 用户取消分享后执行的回调函数
            }
        });

    });
}

