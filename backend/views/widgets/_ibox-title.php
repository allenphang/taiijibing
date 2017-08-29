<?php
/**
 * Ahthor: lf
 * Email: job@feehi.com
 * Blog: http://blog.feehi.com
 * Date: 2016/4/2014:03
 */
use yii\helpers\Url;
use yii\helpers\Html;

$action = strtolower( Yii::$app->controller->action->id );
$prefixTitle = '';
switch($action){
    case "index":
        if(!isset($buttons) && !isset($defaultButtons)) {
            $buttons = [
            ];
        }
        break;
    case "create":
        $prefixTitle = yii::t('app', 'Create');
        if(!isset($buttons) && !isset($defaultButtons)) {
            $buttons = [
                [
                    'name' => yii::t('app', 'Back'),
                    'url' => ['index'],
                    'options' => [
                        'class' => 'btn btn-primary btn-xs',
                    ]
                ],
            ];
        }
        break;
    case "update":
        $prefixTitle = yii::t('app', 'Update');
        if(!isset($buttons) && !isset($defaultButtons)) {
            $buttons = [
                [
                    'name' => yii::t('app', 'Back'),
                    'url' => ['index'],
                    'options' => [
                        'class' => 'btn btn-primary btn-xs',
                    ]
                ],
            ];
        }
        break;
    default:
        if(!isset($buttons) && !isset($defaultButtons)){
            $buttons = [
                [
                    'name' => yii::t('app', 'Back'),
                    'url' => ['index'],
                    'options' => [
                        'class' => 'btn btn-primary btn-xs',
                    ]
                ],
            ];
        }
        break;
}
?>
<div class="ibox-title">
    <h5><?=$prefixTitle.yii::t('app', $this->title)?></h5>
    <div class="ibox-tools">
        <?php
            foreach($buttons as $button){
                echo Html::a(yii::t('app', $button['name']), Url::to($button['url']), $button['options']);
            }
        ?>
    </div>
</div>