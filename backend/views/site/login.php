<?php

/* @var $this yii\web\View */
/* @var $form feehi\widgets\ActiveForm */
/* @var $model \common\models\LoginForm */

use backend\assets\AppAsset;
use yii\helpers\Html;
use feehi\widgets\ActiveForm;
use yii\helpers\Url;
use feehi\components\Captcha;

AppAsset::register($this);
$this->title = yii::t('app', 'Login');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <?= $this->render("/widgets/_language-js")?>
    <style>
        div.form-group div.help-block{
            position: absolute;
            left: 305px;
            width: 170px;
            top: 4px;
            text-align: left;
        }
        img#captchaimg{
                     cursor: pointer;
                     position: absolute;
                     top: 0px;
                     left: 199px;
         }
        .form-horizontal .form-group{
            width: 300px;
            margin-left: 0px;
        }
        body{
            background-image: url("./static/img/login_bg.png");
            -webkit-background-size:100% 100%;;
            background-size:100% 100%;
            background-repeat: no-repeat;
            background-position: center;
        }
        .middle-box{
            float:right;
           margin-right:80px;
            background:white;
            opacity: 0.8;
            margin-top:300px;
        }
        .form-control, .single-line{
            width:90%;
            margin-left:5%
        }

        button.btn.btn-primary.block.m-b{
            width:90%;
            margin-left:5%;
            margin-bottom:60px;
        }
        .help-block {
            display:none;
        }
    </style>
</head>
<body class="gray-bg"><style>.m-t-md{margin-top:0px}</style>
<?php $this->beginBody() ?>
<div style="position:fixed;width:100%;height:45px;background:#5f97ff;line-height:45px;">
    <span style="font-size:16px;color:white;padding-left:20px;">太极兵饮水云平台</span>
</div>
<div class="middle-box text-center loginscreen  animated fadeInDown">
    <?=$this->render('/widgets/_flash') ?>
    <div>
        <h3>登录</h3>
        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
        <?= $form->field($model, 'username',['template'=>"<div style='position:relative'>{input}\n{error}\n{hint}</div>"])->textInput(['autofocus' => true,'placeholder'=>yii::t("app", "Username")]) ?>

        <?= $form->field($model, 'password',['template'=>"<div style='position:relative'>{input}\n{error}\n{hint}</div>"])->passwordInput(['placeholder'=>yii::t("app", "Password")]) ?>


        <?= Html::submitButton('登录', ['class' => 'btn btn-primary block  m-b', 'name' => 'login-button']) ?>

<!--        <p class="text-muted text-center"> <a href="--><?//=Url::to(['user/request-password-reset'])?><!--"><small>--><?//=yii::t('app', 'Forgot password')?><!--</small></a> |-->
            <?php
            if(yii::$app->language == 'en-US') {
                echo "<a href = ".Url::to(['site/language', 'lang'=>'zh-CN'])." > 简体中文</a >";
            }else{
//                echo "<a href=".Url::to(['site/language', 'lang'=>'en-US']).">English</a>";
            }
            ?>
        </p>

        <?php ActiveForm::end(); ?>
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>