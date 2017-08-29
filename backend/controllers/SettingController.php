<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/23
 * Time: 12:08
 */
namespace backend\controllers;

use Yii;
use backend\models\SettingWebsiteForm;
use backend\models\SettingSmtpForm;
use common\models\Options;
use feehi\libs\Constants;
use yii\base\Model;
use yii\web\Response;
use feehi\widgets\ActiveForm;

/**
 * Setting controller
 */
class SettingController extends BaseController
{

    public function actionWebsite()
    {
        $model = new SettingWebsiteForm();
        if ( Yii::$app->getRequest()->getIsPost() )
        {
            if( $model->validate() && $model->load(Yii::$app->getRequest()->post()) && $model->setWebsiteConfig() ){
                Yii::$app->getSession()->setFlash('success', yii::t('app', 'Success'));
            }else{
                $errors = $model->getErrors();
                $err = '';
                foreach($errors as $v){
                    $err .= $v[0].'<br>';
                }
                Yii::$app->getSession()->setFlash('error', $err);
            }
        }

        $model->getWebsiteSetting();
        return $this->render('website', [
            'model'=>$model
        ]);

    }



    public function getModel($id='')
    {
        return Options::findOne(['id'=>$id, 'type'=>Options::TYPE_CUSTOM]);
    }



}
