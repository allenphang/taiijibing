/**
 * Created by pengjixiang on 15/12/9.
 */
var pageController=null;
$(function(){

    pageController=new Vue({

            'el':'#login_c',
            data:{
                mobile:'',
                vcode:'',
                enableGetValidateBtn:true,
                amount:60,
                getValidateBtnLabel:'获取',


            },
            methods:{
                getValidateCode:function(){
                    //调用请求
                    //更新状态
                    if(!validateTel(this.mobile)){
                        //手机号输入错误
                        $.toast("手机格式错误，请重新输入");
                        return;
                    }
                    sendSms(this.mobile);
                    this.enableGetValidateBtn=true;
                    this.getValidateBtnLabel=this.amount+"秒";
                    var t=setInterval(function(){

                        pageController.amount--;
                        if(pageController.amount<0){
                            clearInterval(t);
                            reset();
                            return;
                        }
                        pageController.getValidateBtnLabel=pageController.amount+"秒";
                    },1000);
    },
                submit:function(){
                    if(!isValid()){
                        return;
                    }
                    $.showIndicator();
                    $.getJSON("/index.php/personal-center/login?mobile="+this.mobile+"&vcode="+this.vcode,function(data){
                        $.hideIndicator();
                        if(data.state!=0){
                            $.toast(data.desc);
                            return;
                        }
                        window.location.replace("/index.php/personal-center/skip");
                    });
                }
            },
            computed:{

            }

    });

});
//发送短信
    function sendSms(tel){
        $.showIndicator();
        $.getJSON("/index.php/personal-center/get-sms?mobile="+tel,function(data){
            $.hideIndicator();
            if(data.state!='0'){
                pageController.amount =-1;
                $.toast('验证码发送失败,请重试!');
                return;
            }
            $.toast('验证码已发送到您的手机!');
        });

    }
    function isValid(){
        if(!validateTel(pageController.mobile)){
            //手机号输入错误
            $.toast('手机格式错误，请重新输入');
            return false;
        }
        //验证码
        if (isNaN(pageController.vcode) || pageController.vcode.length != 4) {
            $.toast('验证码输入错误');
            return false;
        }
        return true;

    }
var reset=function(){
    pageController.amount=60;
    pageController.getValidateBtnLabel="获取";
    pageController.enableGetValidateBtn=false;
}