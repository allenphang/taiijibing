<?php
/**
 * Created by PhpStorm.
 * User: pengjixiang
 * Date: 17/5/18
 * Time: 下午6:47
 */

namespace backend\models;


use yii\db\ActiveRecord;

class DevLocation extends ActiveRecord
{


    public static function tableName()
    {
        return 'dev_location';
    }
    public function scenarios()
    {
        return [
            'default' => [''],
        ];
    }
    public function getDevsWithDevAddressInfo(){
          return self::find()->asArray()->all();
    }



}