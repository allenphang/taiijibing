<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use backend\models\Menu;
use yii\helpers\Url;
use backend\assets\IndexAsset;

IndexAsset::register($this);
$this->title = yii::t('app', 'Backend Manage System');
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
    <link rel="icon" href="<?=yii::$app->getRequest()->hostInfo?>/favicon.ico" type="image/x-icon" />
    <style>


    </style>
</head>
<body class="fixed-sidebar full-height-layout gray-bg" style="overflow:hidden">
<?php $this->beginBody() ?>
<div id="wrapper">
    <!--左侧导航开始-->
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="nav-close"><i class="fa fa-times-circle"></i>
        </div>
        <div class="sidebar-collapse" style="background:#5f97ff;">
            <ul class="nav" id="side-menu">
                <li class="nav-header" style="background:#5f97ff;">
                    <div class="dropdown profile-element">
<!--                        <span><img alt="image" class="img-circle" width="64px" height="64px" src="--><?php //if(yii::$app->getUser()->getIdentity()->avatar){echo yii::$app->params['site']['url'].yii::$app->getUser()->getIdentity()->avatar;}else{echo 'static/img/profile_small.jpg';} ?><!--" /></span>-->
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="clear">
                                    <span class="block m-t-xs"><strong class="font-normal" style="color:white;font-size:20px;">太极兵饮水云平台</strong></span>
                                <span class="text-muted text-xs block" style="color:white;margin-top:10px;"><?= yii::t('menu', yii::$app->rbac->roleName)?>&nbsp;&nbsp;<?=\yii::$app->getUser()->getIdentity()->username ?><b class="caret"></b></span>
                                </span>
                        </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs" >
                            <li><a class="J_menuItem" href="<?=Url::to(['admin-user/update-self'])?>"><?=yii::t('app', 'Profile')?></a>
                            </li>

                            <li class="divider"></li>
                            <li><a href="<?=Url::toRoute('site/logout')?>"><?=yii::t('app', 'Logout')?></a>
                            </li>
                        </ul>
                    </div>
                    <div class="logo-element">W+
                    </div>
                </li>
                <?php
                    $cacheDependencyObject = yii::createObject([
                        'class' => 'feehi\helpers\FileDependencyHelper',
                        'fileName' => 'backend_menu.txt',
                    ]);
                    $dependency = [
                        'class' => 'yii\caching\FileDependency',
                        'fileName' => $cacheDependencyObject->createFile(),
                    ];
                    if ($this->beginCache('backend_menu', ['variations' => [Yii::$app->language, yii::$app->rbac->getRoleId()], 'dependency' => $dependency])) {
                ?>
                <?= Menu::getBackendMenu(); ?>
                <?php
                    $this->endCache();
                    }
                ?>
            </ul>
        </div>
    </nav>
    <!--左侧导航结束-->
    <!--右侧部分开始-->
    <div id="page-wrapper" class="gray-bg dashbard-1">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header" style="width: 50%;"><a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>

                </div>
                <ul class="nav navbar-top-links navbar-right">
                    <li class="hidden-xs">
                        <a href="javascript:void(0)" onclick="reloadIframe()"><i class="fa fa-refresh"></i> <?=yii::t('app', 'Refresh')?></a>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="row content-tabs">
            <button class="roll-nav roll-left J_tabLeft"><i class="fa fa-backward"></i>
            </button>
            <nav class="page-tabs J_menuTabs">
                <div class="page-tabs-content">
                    <a href="javascript:;" class="active J_menuTab" data-id="<?=Url::to(['site/main']) ?>"><?=yii::t('app', 'Home')?></a>
                </div>
            </nav>
            <button class="roll-nav roll-right J_tabRight"><i class="fa fa-forward"></i>
            </button>
            <div class="btn-group roll-nav roll-right">
                <button class="dropdown J_tabClose" data-toggle="dropdown"><?=yii::t('app', 'Close')?><span class="caret"></span>

                </button>
                <ul role="menu" class="dropdown-menu dropdown-menu-right">
                    <li class="J_tabShowActive"><a><?=yii::t('app', 'Locate Current Tab')?></a>
                    </li>
                    <li class="divider"></li>
                    <li class="J_tabCloseAll"><a><?=yii::t('app', 'Close All Tab')?></a>
                    </li>
                    <li class="J_tabCloseOther"><a><?=yii::t('app', 'Close Other Tab')?></a>
                    </li>
                </ul>
            </div>
            <a href="<?=Url::toRoute('site/logout')?>" class="roll-nav roll-right J_tabExit"><i class="fa fa fa-sign-out"></i> <?=yii::t('app', 'Logout')?></a>
        </div>
        <div class="row J_mainContent" id="content-main">
            <iframe class="J_iframe" name="iframe0" width="100%" height="100%" src="<?=Url::to(['site/main']) ?>" frameborder="0" data-id="<?=Url::to(['site/main']) ?>" seamless></iframe>
        </div>
        <div class="footer">
            <div class="pull-right">&copy; 2015-2016 <a href="http://blog.feehi.com/" target="_blank">feehi</a>
            </div>
        </div>
    </div>
    <!--右侧部分结束-->



</div>
<?php $this->endBody() ?>
</body>
<script>
    function reloadIframe(){
        var current_iframe=$("iframe:visible");
        current_iframe[0].contentWindow.location.reload();
        return false;
    }
</script>
</html>
<?php $this->endPage() ?>
