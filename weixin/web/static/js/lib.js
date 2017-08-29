/**
 * Created by pengjixiang on 17/3/29.
 */
var carnoInputBoard={
    _mask:null,
    _license:null,
    _KeyChiness:null,
    _KeyEnghlsh:null,
    _addPlate:null,
    _plate_text:null,
    _clear:null,
    _addNewPlate:null,
    _finish:null,
    _delete:null,
    _showPlate:null,
    show:function(inputObj){
        this._mask = $(".Mask"); //遮罩
        this._license = $("#license"); //弹出车牌
        this._KeyChiness = $("#_keyboardChinese"); //中文键盘
        this._KeyEnghlsh = $("#_keyboardEnglish"); //英文键盘
        this._addPlate = $("#addPlate"); //增加车牌按钮
        this._plate_text = inputObj; // 车牌显示位置
        this._clear = $("#clear"); //清空
        this._addNewPlate = $(inputObj).text().split("");   //添加车牌
        this._finish = $("#finish"); //完成按钮
        this._delete = $("#delete"); //删除
        this._showPlate = $("#_showPlate").text($(inputObj).text()); //输入车牌显示
        $(this._showPlate).text($(inputObj).text());
        this.initListeners();
        this.showKeyBoard();
    },
    showKeyBoard:function(){
        /*显示输入框*/
            if(carnoInputBoard._plate_text.text().length == 0){
                $(carnoInputBoard._mask).show();
                $(carnoInputBoard._KeyChiness).addClass("in").show();
            }else if(carnoInputBoard._plate_text.text().length == 1){
                carnoInputBoard._mask.show();
                carnoInputBoard._KeyEnghlsh.addClass("in").show();
            }else if(1<this._plate_text.text().length< 7){
                carnoInputBoard._mask.show();
                carnoInputBoard._KeyEnghlsh.addClass("in").show();
            }
    },
    initListeners:function(){
        this._clear.on("click",function(){
            carnoInputBoard._addNewPlate = [];
        });
        /*已有车牌*/
        $(".weui-actionsheet__cell").unbind();
        $(".weui-actionsheet__cell").on("click",function(){
            var _this = $(this).text();
            carnoInputBoard._plate_text.text(_this);
            carnoInputBoard._mask.hide();
        });
        /*添加车牌*/
        this._addPlate.unbind();
        this._addPlate.on("click",function(){
            carnoInputBoard._license.hide();
            carnoInputBoard._KeyChiness.show();
        });
        /*取消*/
        $("#cancel").unbind();
        $("#cancel").on("click",function(){
            carnoInputBoard._mask.hide();
            carnoInputBoard._KeyChiness.hide();
        });
        /*中文键盘*/
        this._KeyChiness.find(".keyboard_item").unbind();
        this._KeyChiness.find(".keyboard_item").on("click",function(){
            var _itemText = $(this).text();
            carnoInputBoard._addNewPlate.push(_itemText);
            carnoInputBoard._showPlate.text(carnoInputBoard._addNewPlate.join(""));
            carnoInputBoard._KeyChiness.hide();
            carnoInputBoard._KeyEnghlsh.show();
        });
        /*英文键盘*/
        this._KeyEnghlsh.find(".keyboard_item").unbind();
        this._KeyEnghlsh.find(".keyboard_item").on("click",function(){
            var _itemText = $(this).text();
            if(carnoInputBoard._addNewPlate.length<7){
                carnoInputBoard._addNewPlate.push(_itemText);
                carnoInputBoard._showPlate.text(carnoInputBoard._addNewPlate.join(""));
            }else{
                return false;
            }
        });
        /*完成按钮操作*/
        this._finish.unbind();
        this._finish.on("click",function(){
            var _strNewPlate = carnoInputBoard._addNewPlate.join("");
            carnoInputBoard._mask.hide();
            carnoInputBoard._KeyEnghlsh.hide();
            carnoInputBoard._KeyChiness.hide();
            carnoInputBoard._plate_text.text(_strNewPlate);
        });
        /*删除按钮操作*/
        this._delete.unbind();
        this._delete.on("click",function(){
            var _detelePlate = carnoInputBoard._addNewPlate.pop();
            if(carnoInputBoard._addNewPlate.length == 0){
                carnoInputBoard._KeyEnghlsh.hide();
                carnoInputBoard._KeyChiness.show();
            }if(carnoInputBoard._addNewPlate.length<7){
                carnoInputBoard._showPlate.text(carnoInputBoard._addNewPlate.join(""));
            }
        });
        /*车牌显示操作*/
        //var ShowFirstPlate =this._license.find(".weui-actionsheet__menu").children('.weui-actionsheet__cell').eq(0).text();
        //this._showPlate.text(ShowFirstPlate)

    }
};

function isIdCardNo(idcardno){

    var reg = /(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/;
    if(reg.test(idcardno) === false)
    {
        return  false;
    }
    return true;
}