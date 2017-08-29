<?php
/**
 * Created by PhpStorm.
 * User: pengjixiang
 * Date: 17/4/6
 * Time: 下午5:00
 */

namespace backend\models;


use yii\base\Exception;
use yii\db\ActiveRecord;
use yii\db\Transaction;

class OrderSuccess extends ActiveRecord
{

    public static function tableName()
    {
        return 'orders_success';
    }

    /**
     * 累计流水
     */
    public static function getTotalIncome(){

        return static::findBySql("select sum(OrderMoney) as amount from orders_success")->asArray()->one();
    }
    /**
     * 今日流水
     */
    public static function getIncomeOfToday(){
        $now= date("Y-m-d");
        $starttime=$now."00:00:00";
        $endtime=$now."23:59:59";
        return static::findBySql("select sum(OrderMoney)  as amount from orders_success where RowTime<'$endtime' and RowTime>'$starttime'")->asArray()->one();
    }
    public function scenarios()
    {
        return [
            'create' => ['OrderNo', 'Fid','TotalMoney',
                         'OrderMoney','CouponMoney',
                         'Amount','Volume',],
        ];
    }
    public function attributeLabels()
    {
        return [
            'Fid' => '厂家',
            'TotalMoney' => '应付金额',
            'OrderMoney' => '支付金额',
            'CouponMoney' => '优惠金额',
            'Volume' => '购买容量(L)',
            'Amount'=>'购买数量'
        ];
    }

    /**
     * 验证充值表单
     */
    public function checkForm(){
        $Fid=$this->getAttribute("Fid");
        $TotalMoney=$this->getAttribute("TotalMoney");
        $CouponMoney=$this->getAttribute("CouponMoney");
        $OrderMoney=$this->getAttribute("OrderMoney");
        $Volume=$this->getAttribute("Volume");
        $Amount=$this->getAttribute("Amount");
        if(!is_numeric($OrderMoney)||!is_numeric($Fid)||!is_numeric($TotalMoney)||!is_numeric($CouponMoney)||!is_numeric($Volume)||!is_numeric($Amount)){
            return false;
        }
        return true;
    }
    /**
     * 水厂充值
     */
    public  function createOrder(){
        try{

            $transaction =$this->beginTransaction();
            $sql1=$this->getCreateOrderSql();
            $sql2=$this->getUpdateFactoryWcodeSql();
            $this->getDb()->createCommand($sql1)->execute();
            $this->getDb()->createCommand($sql2)->execute();
            $transaction->commit();
            return true;
        }catch(Exception $e){
            $transaction->rollBack();
            return false;
        }
    }

    /**
     * 同步厂商数据
     */
    public function getUpdateFactoryWcodeSql(){
        $Fid=$this->getAttribute("Fid");
        $Volume=$this->getAttribute("Volume");
        $OriAmount=intval($this->getAttribute("Amount"));
        $sql='';
        $data=static::findBySql("select * from factory_wcode where Fid=$Fid and Volume=$Volume")->asArray()->one();
        if(empty($data)){
            //插入
            $now=date("Y-m-d H:i:s");
            $sql="insert into factory_wcode(Fid,Volume,Amount,RowTime,PrintAmount,LeftAmount,LastUpTime) VALUES($Fid,$Volume,$OriAmount,'$now',0,$OriAmount,'$now')";

        }else{
            $Amount=intval($data["Amount"])+$OriAmount;
            $LeftAmount=intval($data["LeftAmount"])+$OriAmount;
            //更新
            $sql="update factory_wcode set Amount=$Amount , LeftAmount=$LeftAmount where  Fid=$Fid and Volume=$Volume";
        }
        return $sql;
    }
    /**
     *  获取创建订单号查询语句
     */
    public function getCreateOrderSql(){
        $Fid=$this->getAttribute("Fid");
        $TotalMoney=$this->getAttribute("TotalMoney");
        $CouponMoney=$this->getAttribute("CouponMoney");
        $OrderMoney=$this->getAttribute("OrderMoney");
        $Volume=$this->getAttribute("Volume");
        $Amount=$this->getAttribute("Amount");
        $OrderNo=$this->getOrderNo();
        $now=date("Y-m-d H:i:s");
        $sql="insert into orders_success(OrderNo,Fid,TotalMoney,CouponMoney,OrderMoney,Volume,Amount,RowTime,State)
              VALUES ('$OrderNo',$Fid,$TotalMoney,$CouponMoney,$OrderMoney,$Volume,$Amount,'$now',1)";
        return $sql;
    }
    public function getOrderNo(){
        $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
        $orderSn = $yCode[intval(date('Y')) - 2011] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));
        return $orderSn;
    }
    public function beginTransaction()
    {
         return  $this->getDb()->beginTransaction();
    }
    public static function all($pid){
        return self::findBySql("select * from orders_success where Fid=$pid");
    }
    public static function pageQuery($offset=0,$limit=10,$pid){
        return self::findBySql("select * from orders_success where Fid=$pid limit $offset , $limit");
    }
}