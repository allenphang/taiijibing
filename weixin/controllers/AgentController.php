<?php
namespace app\controllers;
use app\api\AddressApi;
use app\api\AgentApi;
use yii;
use app\api\AgentLoginApi;
use app\api\AgentGetDevFactoryApi;
use app\api\AgentRegistApi;
use app\api\SmsSendApi;
/**
 * Created by PhpStorm.
 * User: pengjixiang
 * Date: 17/3/17
 * Time: 下午2:11
 */
class AgentController extends WxController
{
    public function beforeAction($action)
    {
        $this->checkOpenid();
        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    }

    /**
     * 登录
     * @return string
     */
    public function actionLoginPage()
    {
        return $this->renderPartial("login");
    }
    /**
     * 首页
     * @return string|yii\web\Responses
     */
    public function actionIndex(){
        if(!$this->checkAgentLogin()){
            //未登录
            yii::$app->session->set("last_url","/agent/index");
            return $this->redirect(["/agent/login-page"]);
        }

        $agent=Yii::$app->session->get("agent_user");
//        $data=(new AgentApi())->getUserStat();
        $totalData=(new AgentApi())->getTotalStat();
        if($totalData->state==-1102001){
            //未登录
            yii::$app->session->set("last_url","/agent/index");
            return $this->redirect(["/agent/login-page"]);
        }
        return $this->renderPartial("index",["name"=>$agent->name,"totalData"=>$totalData]);
    }
    public function actionServerCenter(){
        $data=(new AgentApi())->getAgents();
        return $this->renderPartial("server-center",["data"=>$data]);
    }
    public function actionUsers(){
        $data=(new AgentApi())->getUsers();
        return $this->renderPartial("users",["data"=>$data]);
    }
    /**
     * ajax 登录
     */
    public function actionLogin()
    {
        $username=Yii::$app->request->get("username");
        $pwd=Yii::$app->request->get("password");
        if(empty($username)||empty($pwd)){
            $data=json_decode("{}");
            $data->state=-1;
            $data->msg='用户名或密码不能为空';
            $this->jsonReturn($data);
            return;
        }
        $data['Account']=$username;
        $data['Pwd']=md5($pwd);
        $res=(new AgentLoginApi())->post($data);
        if($res->state==0){
            //登录成功,保存登录信息
            $this->saveAgentUser($res->result);
        }
        $this->jsonReturn($res);
    }
    public function actionSkip(){
        $last_url= yii::$app->session->get("last_url");
        if(empty($last_url)){
            exit();
        }
        $this->redirect([$last_url]);
    }

    /**
     * 登记
     * @return string
     */
    public function actionRegister(){
        $res=(new AgentGetDevFactoryApi())->post([]);
        $ares=(new AddressApi())->get();
        $data=[];
        $Adata=[];
        if($res->state==0){
            $data=$res->result;
        }
        if($ares->state==0){
            $Adata=$ares->result;
        }

        return $this->renderPartial("register",['data'=>$data,'adata'=>$Adata]);
    }
    /*
     * 用户登记
     */
    public function actionUserRegister(){
        $data=Yii::$app->request->get();
        $this->jsonReturn((new AgentRegistApi())->post($data));
    }

    /**
     * 数据总览
     * @return string|yii\web\Response
     */
    public function actionDataView(){
        if(!$this->checkAgentLogin()){
            yii::$app->session->set("last_url","/agent/data-view");
            return $this->redirect(["/agent/login-page"]);
        }
            $data=(new AgentApi())->getTotalStat();
        return $this->renderPartial("dataview",["data"=>$data]);
    }

    /**
     * 硬件告警
     * @return string|yii\web\Response
     */
    public function actionHardwareWarn(){
        if(!$this->checkAgentLogin()){
            yii::$app->session->set("last_url","/agent/hardware-warn");
            return $this->redirect(["/agent/login-page"]);
        }
        $data=(new AgentApi())->getWarning();

        return $this->renderPartial("hardware",["data"=>$data]);
    }
    /**
     * 获取手机验证码
     */
    public function actionGetVcode(){
        $tel=Yii::$app->request->get("tel");
        $this->jsonReturn((new SmsSendApi())->post($tel));
    }

    /**
     * 激活
     * @return string|yii\web\Response
     */
    public function actionActivate(){
        if(!$this->checkAgentLogin()){
            yii::$app->session->set("last_url","/agent/activate");
            return $this->redirect(["/agent/login-page"]);
        }
        return $this->renderPartial("activate");
    }

    /**
     * 报表
     * @return string|yii\web\Response
     */
    public function actionChart(){
        if(!$this->checkAgentLogin()){
            yii::$app->session->set("last_url","/agent/chart");
            return $this->redirect(["/agent/login-page"]);
        }
        $res=(new AgentApi())->getDayStat();
        if($res->state!=0){
            $this->toError();
        }
        $datax=[];
        $datay=[];
        foreach($res->result->watersale as $val){
            array_push($datax,$val->day);
            array_push($datay,$val->value);
        }
        $userdatax=[];
        $userdatay=[];
        foreach($res->result->customer as $val){
            array_push($userdatax,$val->day);
            array_push($userdatay,$val->value);
        }
        return $this->renderPartial("chart",["datax"=>$datax,"datay"=>$datay,"userdatax"=>$userdatax,"userdatay"=>$userdatay]);
    }

}