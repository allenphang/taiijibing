<?php
/**
 * Created by PhpStorm.
 * User: pengjixiang
 * Date: 2017/6/20
 * Time: 下午6:32
 */

namespace backend\models;


use yii\db\ActiveRecord;

class GoodsCategory extends ActiveRecord
{
    public static function tableName()
    {
        return 'goods_category';
    }
    public function query(){
        return static::findBySql("select id,name from goods_category")->asArray()->all();

    }
    
}
