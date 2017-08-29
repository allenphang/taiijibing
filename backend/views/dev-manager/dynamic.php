<?php
use yii\widgets\LinkPager;
function getActType($type){
    $desc="";
    switch($type){
        case 1:$desc="开关机";break;
        case 2:$desc="调温";break;
        case 4:$desc="加热";break;
        case 8:$desc="消毒";break;
        case 16:$desc="抽水";break;
    }
    return $desc;
}
?>
<div class="wrapper wrapper-content">
        <div class="form-group" >

            <div class="col-sm-10" style="margin-bottom:20px;">
               <span><label>设备手机号:</label> <input name="tel" type="text" id="tel" placeholder="设备手机号" value="<?=$tel?>"/></span>
                <span style="padding-left:5px;"><label>设备编号:</label><input name="devno" type="text"  id="devno" placeholder="设备编号" value="<?=$devno?>"/></span>
                <span style="padding-left:5px;">所属地区</span>
                <select id="province">
                    <option value="">请选择所属省</option>
                </select>
                <select id="city">
                    <option value="">请选择所属城市</option>
                </select>
                <select id="area">
                    <option value="">请选择所属区</option>
                </select>
                <button style="padding-left:10px;" class="btn-primary btn form-label" type="button" style="padding:0px;line-height:26px;height:26px;width:60px;" id="query">查询</button>
            </div>
        </div>

    <table class="table table-hover" style="background:white;">
        <thead>
        <th>设备编号</th>
        <th>设备手机号</th>
        <th>操作日志</th>
        <th>用水量</th>
        <th>剩余水量</th>
        <th>TDS</th>
        <th>水温</th>
        <th>上传时间</th>
        <th>所属地区</th>
        <th>位置信息</th>
        </thead>
        <tbody>
        <?php
        $str='';
        foreach($model as $key=>$val)
        {
            $str.= "<tr><td>".$val["DevNo"]."</td>
                        <td>".$val["DevBindMobile"]."</td>
                        <td>".(getActType($val["ActType"]))."</td>


                         <td>".(empty($val["WaterUse"])?"——":$val["WaterUse"])."</td>
                          <td>".(empty($val["WaterRest"])?"——":round($val["WaterRest"] ,2))."</td>
                             <td>".(empty($val["Dts"])?"——":$val["Dts"])."</td>
                                <td>".(empty($val["Degrees"])?"":$val["Degrees"])."</td>
                                 <td>".$val["ActEndTime"]."</td>
                                 <td>".($val["Province"].$val["City"].$val["Area"])."</td>
                                 <td>".$val["Address"]."(".$val["Lat"].",".$val["Lng"].")</td>
                        </tr>";

        }
        echo $str;

        ?>
        </tbody>
    </table>
    <table>
        <th
    </table>


</div>
<script type="text/javascript" src="./static/js/jquery.min.js"></script>
<script type="text/javascript" src="./static/js/layer/layer.js"></script>
<script>
    var areas=<?=json_encode($areas)?>;
</script>
<script>
    $(function(){
      $("#query").on("click",function(){
          var tel=$("#tel").val();
          var devno=$("#devno").val();
          var province=$("#province").val();
          var city=$("#city").val();
          var area=$("#area").val();
          window.location.href="/index.php?r=dev-manager/dynamic&tel="+tel+"&devno="+devno+"&province="+province+"&city="+city+"&area="+area;
      });
        $("#province").on("change",function(){
            onProvinceChange();
        });
        $("#city").on("change",function(){

            onCityChange();
        });
        initProvince(0,$("#province"));
        $("#province").val('<?=$province?>');
        $("#city").val('<?=$city?>');
        $("#area").val('<?=$area?>');
        onProvinceChange();
        onCityChange();

    });
    function initProvince(){
        for(var index=0;index<areas.length;index++){
            var item=areas[index];
            if(item.PId==0){
                $("#province").append("<option value='"+item.Name+"'>"+item.Name+"</option>");
            }
        }
    }
    function onProvinceChange(){
        var areaId=getAreaIdByName($("#province").val());
        emptySelect($("#city"),"请选择所属城市");
        initAddress(areaId,$("#city"));
    }
    function onCityChange(){
        var areaId=getAreaIdByName($("#city").val());
        emptySelect($("#area"),"请选择所属地区");
        initAddress(areaId,$("#area"));
    }
    function initAddress(_pid,_obj){
        if(areas.length==0){
            return;
        }
        for(var areaIndex=0;areaIndex<areas.length;areaIndex++){
            var area=areas[areaIndex];
            if(area.PId==_pid){
                $(_obj).append('<option value="'+area.Name+'">'+area.Name+'</option>');
            }

        }
    }
    function emptySelect(_obj,_emptyLabel){
        $(_obj).empty();
        $(_obj).append('<option value="">'+_emptyLabel+'</option>');
    }
    function getAreaIdByName(_name){
        for(var areaIndex=0;areaIndex<areas.length;areaIndex++) {
            var area = areas[areaIndex];
            if(area.Name==_name){
                return area.Id;
            }
        }
        return -1;
    }
</script>
<?= LinkPager::widget(['pagination' => $pages]); ?>
