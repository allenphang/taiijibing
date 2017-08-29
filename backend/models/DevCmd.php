<?php
/**
 * Created by PhpStorm.
 * User: pengjixiang
 * Date: 17/5/18
 * Time: 下午6:47
 */

namespace backend\models;


use yii\db\ActiveRecord;

class DevCmd extends ActiveRecord
{


    public static function tableName()
    {
        return 'dev_cmd';
    }
    public function scenarios()
    {
        return [
            'default' => ['DevNo', 'StartTime','ExpiredTime','Cmd','RowTime','CmdType','State'],
        ];
    }
    public function add($DevNo,$StartTime,$ExpiredTime,$Cmd,$CmdType){
        date_default_timezone_set('PRC');
        $this->setAttribute("DevNo",$DevNo);
        $this->setAttribute("StartTime",$StartTime);
        $this->setAttribute("ExpiredTime",$ExpiredTime);
        $this->setAttribute("Cmd",$Cmd);
        $this->setAttribute("CmdType",$CmdType);
        $this->setAttribute("State",0);
        $this->setAttribute("RowTime",date("Y-m-d h:m:s"));
        return $this->save();
    }



}