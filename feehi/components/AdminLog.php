<?php
/**
 * Created by PhpStorm.
 * User: lf
 * Date: 16/4/1
 * Time: 19:50
 */
namespace feehi\components;

use yii;
use yii\helpers\Url;
use backend\models\AdminLog as AdminLogModel;

class AdminLog
{

    public static function create($event)
    {
        if($event->sender->className() !== AdminLogModel::className()) {
            $desc = '<br>';
            foreach ($event->sender->getAttributes() as $name => $value) {
                $desc .= $event->sender->getAttributeLabel($name) . '(' .  $name . ') => ' . $value . ',<br>';
            }
            $desc = substr($desc, 0, -5);
            $model = new AdminLogModel();
            $class = $event->sender->className();
            $id_des = '';
            if(isset($event->sender->id)) $id_des = '{{%ID%}} ' . $event->sender->id;
            $model->description = '{{%ADMIN_USER%}} [ ' . yii::$app->user->identity->username . ' ] {{%BY%}} ' . $class .' [ ' .$class::tableName(). ' ] ' ." {{%CREATED%}} {$id_des} {{%RECORD%}}: " . $desc;
            $model->route = Yii::$app->controller->id.'/'.Yii::$app->controller->action->id;
            $model->user_id = yii::$app->user->id;
            $model->save();
        }
    }

    public static function update($event)
    {
        if(!empty($event->changedAttributes)){
            $desc = '<br>';
            foreach ($event->changedAttributes as $name => $value) {
                $desc .= $event->sender->getAttributeLabel($name) . '(' .  $name . ') : ' . $value . '=>' . $event->sender->oldAttributes[$name] . ',<br>';
            }
            $desc = substr($desc, 0, -5);
            $model = new AdminLogModel();
            $class = $event->sender->className();
            $id_des = '';
            if(isset($event->sender->id)) $id_des = '{{%ID%}} ' . $event->sender->id;
            $model->description = '{{%ADMIN_USER%}} [ ' . yii::$app->user->identity->username . ' ] {{%BY%}} ' . $class .' [ ' .$class::tableName(). ' ] ' ." {{%UPDATED%}} {$id_des} {{%RECORD%}}: " . $desc;
            $model->route = Yii::$app->controller->id.'/'.Yii::$app->controller->action->id;
            $model->user_id = yii::$app->user->id;
            $model->save();
        }
    }

    public static function delete($event)
    {
        $desc = '<br>';
        foreach ($event->sender->getAttributes() as $name => $value) {
            $desc .= $event->sender->getAttributeLabel($name) . '(' .  $name . ') => ' . $value . ',<br>';
        }
        $desc = substr($desc, 0, -5);
        $model = new AdminLogModel();
        $class = $event->sender->className();
        $id_des = '';
        if(isset($event->sender->id)) $id_des = '{{%ID%}} ' . $event->sender->id;
        $model->description = '{{%ADMIN_USER%}} [ ' . yii::$app->user->identity->username . ' ] {{%BY%}} ' . $class .' [ ' .$class::tableName(). ' ] ' ." {{%DELETED%}} {$id_des} {{%RECORD%}}: " . $desc;
        $model->route = Yii::$app->controller->id.'/'.Yii::$app->controller->action->id;
        $model->user_id = yii::$app->user->id;
        $model->save();
    }
}