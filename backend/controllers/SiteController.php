<?php
namespace backend\controllers;

use backend\models\AgentInfo;
use backend\models\CustomSearch;
use backend\models\DevError;
use backend\models\DevWaterScan;
use Yii;
use yii\db\ActiveRecord;
use yii\filters\AccessControl;
use backend\models\LoginForm;
use yii\filters\VerbFilter;

/**
 * Site controller
 */
class SiteController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error','language', 'captcha'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'main'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post','get'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'backColor'=>0x66b3ff,//背景颜色
                'maxLength' => 4, //最大显示个数
                'minLength' => 4,//最少显示个数
                'padding' => 10,//间距
                'height'=>34,//高度
                'width' => 100,  //宽度
                'foreColor'=>0xffffff,     //字体颜色
                'offset'=>16,        //设置字符偏移量 有效果
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->renderPartial('index');
    }

    public function actionMain()
    {




        $dynamicAgentData=  AgentInfo::getLatestData();
        $dynamicUserData=CustomSearch::getLatestData();
        $dynamicDevErrData=DevError::getLatestData();

        $xagentTotal=AgentInfo::findBySql("select * from agent_info where Level = 4")->count();
        $sagentTotal=AgentInfo::findBySql("select * from agent_info where Level = 5")->count();
        $userinfoTotal=CustomSearch::findBySql("select * from user_info")->count();
        $devError=ActiveRecord::findBySql("select * from msg_notify_dev_error")->count();
        $sellout=DevWaterScan::getMonthSellAmount();
        $selloutPackage=DevWaterScan::getMonthSellPackageAmount();

        return $this->render("main",[
            "data"=>$sellout,
            "dynamicAgentData"=>$dynamicAgentData,
            "dynamicUserData"=>$dynamicUserData,
            "dynamicDevErrData"=>$dynamicDevErrData,
            "xagentTotal"=>$xagentTotal,
            "sagentTotal"=>$sagentTotal,
            "userinfoTotal"=>$userinfoTotal,
            "devError"=>$devError,
            "selloutPackage"=>$selloutPackage
        ]);
    }
    public function actionLogin()
    {
        if (!Yii::$app->getUser()->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->renderPartial('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->getUser()->logout(false);
        return $this->goHome();
    }
    public function actionLanguage(){
        $language=  Yii::$app->getRequest()->get('lang');
        if(isset($language)){
            Yii::$app->session['language'] = $language;
        }
        $this->goBack(Yii::$app->getRequest()->headers['referer']);
    }
}
