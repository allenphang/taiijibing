<?php
/**
 * Created by PhpStorm.
 * User: pengjixiang
 * Date: 17/4/8
 * Time: 下午12:55
 */

namespace backend\models;


use yii\db\ActiveRecord;

class FactoryInfo extends  ActiveRecord
{
    public static function tableName()
    {
        return 'factory_info';
    }
    public  function insertBaseInfo($loginName='',$pwd=''){
        $this->setAttribute("LoginName",$loginName);
        $this->setAttribute("LoginPwd",md5($pwd));
        $this->setAttribute("RowTime",date("Y-m-d H:i:s"));
        $this->setAttribute("Level",1);
        $this->setAttribute("PreCode",$this->getMaxprecode());
        $this->setAttribute("Name",$loginName);
        $this->setScenario("create");
        return $this->save(false);
    }
    public function getMaxprecode(){
        $precodeRes=$this->findBySql("select max(factory_info.`PreCode`) as precode from `factory_info` ")->asArray()->one();
        $precode=intval($precodeRes["precode"])+1;
        $precode=str_pad($precode,3,"0",STR_PAD_LEFT);
        return $precode;
    }
    public function rules()
    {
        return [
            [['Name','ContractTel','ContractUser', 'PreCode','WaterBrandNo','Level'], 'required'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'Name' => '名称',
            'ContractTel' => '手机号',
            'ContractUser' => '联系人',
            'Address' => '地址',
            'LoginName' => '登录名',
            'LoginPwd'=>'密码',
            'PreCode'=>'厂家代码(数字代号)',
            'WaterBrandNo'=>'水品牌'
        ];
    }
    public function scenarios()
    {
        return [
            'default' => ['Name', 'ContractTel','ContractUser','Address','PreCode','WaterBrandNo','Level','Province','City','Area','BaiDuLat','BaiDuLng'],
            'create' => ['LoginName', 'LoginPwd','RowTime','WaterBrandNo','Level'],

        ];
    }
    public static function findByName($name=""){
       return self::findBySql("select * from factory_info where LoginName='$name'")->asArray()->one();
    }
    public static function findWithCondition($username,$mobile,$province,$city,$area){
            $where='';
            if(!empty($username)){
                $where.=" Name='$username'";
            }
            if(!empty($mobile)){
                if(!empty($where)){
                    $where.=" and ";
                }
                $where.="ContractTel='$mobile' ";
            }
        if(!empty($province)){
            if(!empty($where)){
                $where.=" and ";
            }
            $where.="Province='$province' ";
        }
        if(!empty($city)){
            if(!empty($where)){
                $where.=" and ";
            }
            $where.="City='$city' ";
        }
        if(!empty($area)){
            if(!empty($where)){
                $where.=" and ";
            }
            $where.="Area='$area' ";
        }
        return self::findBySql("select * from factory_info ".(empty($where)?"":" where ".$where));


    }
}