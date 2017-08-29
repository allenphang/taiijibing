<?php
/**
 * Created by PhpStorm.
 * User: pengjixiang
 * Date: 2017/6/20
 * Time: 下午6:32
 */

namespace backend\models;


use yii\db\ActiveRecord;

class GoodsMerchantUser extends ActiveRecord
{
    public static function tableName()
    {
        return 'goods_merchant_user';
    }

}
