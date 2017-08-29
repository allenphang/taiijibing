<?php
/**
 * 设备厂家
 * Created by PhpStorm.
 * User: pengjixiang
 * Date: 17/4/8
 * Time: 下午1:07
 */

namespace backend\models;


use yii\db\ActiveRecord;

class WaterBrand extends ActiveRecord
{

    public static function tableName()
    {
        return 'water_brand';
    }

    public function attributeLabels()
    {
        return [
            'BrandNo' => '品牌编号',
            'BrandName' => '品牌名称',
            'RowTime'=>'操作时间'
        ];
    }
    public function scenarios()
    {
        return [
            'default' => ['BrandNo', 'BrandName'],
            'create' => ['BrandNo', 'BrandName'],
        ];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['BrandName'], 'required'],
        ];
    }

    public static function allQuery()
    {
        return WaterBrand::findBySql("select * from water_brand");
    }
    public static function pageQuery($offset = 0, $limit = 0)
    {
        return WaterBrand::findBySql("select * from water_brand limit $offset , $limit");
    }
    public function createData(){
        $this->setAttribute("BrandNo",md5($this["BrandName"]));
        $this->setAttribute("RowTime",date("Y-m-d h:m:s"));
        return $this->save();
    }
    public static function deleteByBrandno($brandno){
            return WaterBrand::deleteAll("BrandNo = '$brandno'");
    }
}
