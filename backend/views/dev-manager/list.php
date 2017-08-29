<?php
use yii\widgets\LinkPager;
?>
<link rel="stylesheet" href="./static/js/jedate/skin/jedate.css"/>
<style>
    *{
        margin:0px;
        padding:0px;

    }
    .dialog_container{
        background:rgba(0,0,0,0.6)!important;background:#000;filter:Alpha(opacity=98);height: 100%;left: 0;
        position: fixed;
        top: 0;
        width: 100%;
        z-index:999;
        display:none;
    }

    #formContainer{
        width:60%;
        margin-left:20%;
        margin-top:60px;
        background:white;

    }
    #orderlistc ul li{
        float:left;
        margin-left:20px;
        list-style-type: none;
    }
    #water_fac_list  ul li{
        float:left;
        margin-left:20px;
        list-style-type: none;
    }
    .btn1{
        display:inline-block;
        background:#5f8eff;
        color:white;
        width:50px;
        heihgt:24px;
        border-radius: 4px;
        line-height:24px;
        font-size:14px;
        border:0px;
    }
</style>
<div class="wrapper wrapper-content">
    <form action="/index.php?r=dev-manager/list" method="post">
        <div style="margin-bottom:10px;">

            <span style="padding-left:5px;display:inline-block"><label>设备编号:</label><input type="text" name="devno" value="<?=$devno?>"/></span>
            <span style="padding-left:5px;display:inline-block"><label>设备手机号:</label><input type="text" name="mobile" value="<?=$mobile?>"/></span>
            <span style="padding-left:5px;display:inline-block"><label>用户手机号:</label><input type="text" name="tel" value="<?=$tel?>"/></span>
            <span style="padding-left:5px;display:inline-block"><label>厂家:</label><input type="text" name="devf" value="<?=$devf?>"/></span>
            <span style="padding-left:5px;display:inline-block"><label>社区服务中心:</label><input type="text" name="sname" value="<?=$sname?>"/></span>
            <span style="padding-left:5px;display:inline-block"><label>县区运营中心:</label><input type="text" name="xname" value="<?=$xname?>"/></span>
            <span style="padding-left:5px;display:inline-block">
                <label>地区:</label>
                 <select class="control-label" name="province"  id="province">
                     <option value="" selected>请选择</option>
                 </select>
                <select class="control-label" name="city" id="city">
                    <option value="">请选择</option>
                </select>
                <select class="control-label" name="area" id="area">
                    <option value="">请选择</option>
                </select>
            </span>
            <input type="submit" class="btn" value="查询" style="height:26px;line-height:14px;"/>
        </div>

        </form>
    <a href="javascript:batchOpenDialog();" style="color:white;display:inline-block;margin-bottom:10px;"><input type="button" class="btn" value="批量下发"/></a>
    <table class="table table-hover" style="background:white;">
        <thead>
        <th><input type="checkbox" id="selectAll"/></th>
        <th>设备编号</th>
        <th>设备手机号</th>
        <th>用户手机号</th>
        <th>厂家</th>
        <th>社区服务中心</th>
        <th>县区运营中心</th>
        <th>设备激活时间</th>
        <th>位置信息</th>
        <th>最近命令日志</th>
        <th>最近命令时间</th>
        <th>操作</th>
        </thead>
        <tbody>
        <?php
        $str='';
        foreach($model as $key=>$val)
        {
            $str.= "<tr>
                        <td><input type='checkbox' devno='".$val["DevNo"]."' class='devitem'/></td>
                        <td>".$val["DevNo"]."</td>
                        <td>".$val["DevBindMobile"]."</td>
                        <td>".$val["Tel"]."</td>
                        <td>".$val["DevFactory"]."</td>
                        <td>".$val["agentname"]."</td>
                        <td>".$val["agentpname"]."</td>
                        <td>".$val["Date"]."</td>
                        <td>".$val["Address"]."(".$val["Lat"].",".$val["Lng"].")</td>
                        <td>".$val["Cmd"]."</td>
                        <td>".$val["RowTime"]."</td>
                        <td><a href='javascript:void(0);' class='openDialogClass' devno='".$val["DevNo"]."'>下发命令</a></td>
                        </tr>";
        }
        echo $str;
        ?>
        </tbody>
    </table>
</div>
<div class="dialog_container">
    <div id="dialogcontent">
        <div id="formContainer">
           <div style="margin-left:20px;padding-top:10px;height:30px;">
               <label>控制类型</label>
               <select id="controlType">
                   <option value="1">控制命令</option>
                   <option value="2">数量余额</option>
                   <option value="3">水厂白名单</option>
                   <option value="4">出场初始化</option>
               </select>
           </div>
            <div id="orderlistc" >
                <ul>
                    <li><input type="checkbox" id="order_open"/><label for="order_open">开机</label></li>
                    <li><input type="checkbox" id="order_tem"/><label for="order_tem">调温</label></li>
                    <li><input type="checkbox" id="order_tea"/><label for="order_tea">泡茶</label></li>
                    <li><input type="checkbox" id="order_pick"/><label for="order_pick">抽水</label></li>
                    <li><input type="checkbox" id="order_clear"/><label for="order_clear">消毒</label></li>
                </ul>
            </div>
            <div style="clear:both;"></div>
            <div id="vol" style="font-size:14px;padding-left:20px;padding-top:10px;display:none;">
                <label>数量余额：</label><input type="text" placeholder="请输入余额" id="volinput"/>
            </div>
            <div id="water_fac_list" style="display:none;">
                <h2 style="font-size:14px;color:#676a6c;font-weight: bold;padding-left:20px;">水厂列表</h2>
                <ul>

                    <?php
                        foreach($waterFs as $val){
                            if(!empty(trim($val["Name"]))){
                                echo '<li><input id="'.$val["PreCode"].'" type="checkbox" class="fac" precode="'.$val["PreCode"].'"/><label for="'.$val["PreCode"].'">'.$val["Name"].'</label></li>';
                            }
                        }
                    ?>

                </ul>
            </div>
            <div style="clear:both;"></div>
            <div style="padding-left:20px;margin-top:10px;"><lable for="starttime">开始时间:</lable><input type="text" id="starttime"/>&nbsp;&nbsp;<lable for="endtime">结束时间:</lable><input type="text" id="endtime"/></div>
            <div></div>
            <div style="text-align:center;margin-top:20px;"><input type="button"  class="btn1" value="提交"  id="submitBtn"/>&nbsp;&nbsp;<input class="btn1" type="button" value="关闭" id="closeBtn"/></div>
            <div style="height:10px;"></div>
            <div style="clear:both;"></div>
        </div>
    </div>
</div>
<?= LinkPager::widget(['pagination' => $pages]); ?>
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/js/layer/layer.js"></script>
<script type="text/javascript" src="./static/js/jedate/jedate.js"></script>
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script>
    var data =<?=json_encode($address)?>;
    var province='<?=$province?>';
    var city='<?=$city?>';
    var area='<?=$area?>';
</script>
<script>
    var devList=new Array();
    $(function(){
        $("#selectAll").on("change",function(){
            var  checked=$(this).is(":checked");
            selectAll(checked);
        });
        $("#closeBtn").on("click",function(){
            $(".dialog_container").hide();
        });
        $("#submitBtn").on("click",function(){
            ordersSubmit();
        });
        $("#controlType").on("change",function(){
                var val=Number($(this).val());
                    switch(val){
                        case 1:showOrderList();break;
                        case 2:showVol();break;
                        case 3:showWaterFList();break;
                        case 4:hideAl();break;
                    }
        });
        $(".openDialogClass").on("click",function(){
            var devno=$(this).attr("devno");
            openDialog(devno);
        });
        jeDate({
            dateCell:"#endtime",
            isinitVal:true,
            isTime: true
        });
        jeDate({
            dateCell:"#starttime",
            isinitVal:true,
            isTime: true
        });
        initProvince();
        initListener();
        initAddress();
    });
    function initAddress() {
        $("#province").val(province);
        initCityOnProvinceChange();
        $("#city").val(city);
        initThree();
        $("#area").val(area);
    }
    function getAddressIdByName(_name) {
        _name = $.trim(_name);
        if (_name == "") {
            return 0;
        }
        for (var index = 0; index < data.length; index++) {
            var item = data[index];
            var name = $.trim(item.Name);
            if (name != "" && name == _name) {
                return item.Id;
            }
        }
        return 0;
    }
    function initListener() {
        $("#province").on("change", function () {
            initCityOnProvinceChange();
        });
        $("#city").on("change", function () {
            initThree();
        });
        $("#queryBtn").on("click",function(){
            query();
        });
    }
    function initCityOnProvinceChange() {
        var pid = getAddressIdByName($("#province").val());
        $("#city").empty();
        $("#city").append("<option value='' selected>请选择</option>");
        if (pid == 0) {
            return;
        }
        for (var index = 0; index < data.length; index++) {
            var item = data[index];
            if (item.PId != 0 && item.PId == pid) {
                $("#city").append("<option value='" + item.Name + "'>" + item.Name + "</option>");
                initThree()
            }
        }
    }
    function initThree() {
        var pid = getAddressIdByName($("#city").val());
        $("#area").empty();
        $("#area").append("<option value='' selected>请选择</option>");
        if (pid == 0) {
            return;
        }
        for (var index = 0; index < data.length; index++) {
            var item = data[index];
            if (item.PId != 0 && item.PId == pid) {
                $("#area").append("<option value='" + item.Name + "'>" + item.Name + "</option>");
            }
        }
    }
    function initProvince() {
        for (var index = 0; index < data.length; index++) {
            var item = data[index];
            if (item.PId == 0) {
                $("#province").append("<option value='" + item.Name + "'>" + item.Name + "</option>");
            }
        }

    }
    function ordersSubmit(){
        var val=Number($("#controlType").val());
        switch(val){
            case 1:orderSubmit();break;
            case 2:volSubmit();break;
            case 3:waterFSubmit();break;
            case 4:resetSubmit();break;
        }
    }
    function resetSubmit(){
        submit('');
    }
    function orderSubmit(){
        var orderArr=new Array();
        var order_open=$("#order_open").is(":checked");
        var order_tem=$("#order_tem").is(":checked");
        var order_tea=$("#order_tea").is(":checked");
        var order_pick=$("#order_pick").is(":checked");
        var order_clear=$("#order_clear").is(":checked");
        orderArr.push(order_open?1:0)
        orderArr.push(order_tem?1:0)
        orderArr.push(order_tea?1:0)
        orderArr.push(order_pick?1:0)
        orderArr.push(order_clear?1:0)
        orderStr=orderArr.join("");
        submit(orderStr);
    }
    function getStausByChecked(checked){
        return checked?1:0;
    }
    function volSubmit(){
            var vol=$("#volinput").val();
            if(isNaN(Number(vol))){
                layer.alert("数量余额填写错误");
                return;
            }
        submit(vol);
    }
    function waterFSubmit(){
        var listObj= $("input.fac:checked");
        var length=listObj.length;
        if(length>32){
            layer.alert("最多下发32个水厂白名单");
            return;
        }
        var precodeArr=new Array();
        for(var index=0;index<length;index++){
            var item=listObj[index];
            precodeArr.push($(item).attr("precode"));
        }
        var precodeListStr=precodeArr.join(",");
        submit(precodeListStr);

    }
    function submit(type){
        var data={
            CmdType:$("#controlType").val(),
            Cmd:type,
            StartTime:$("#starttime").val(),
            ExpiredTime:$("#endtime").val(),
            DevNo:devList.join(","),
        };
       var ii= layer.msg("处理中……");
        $.getJSON("/index.php?r=dev-manager/send-order&"+ $.param(data),function(data){
           layer.close(ii);
            closeDialog();
            layer.alert("操作成功");
        });
    }
    function showOrderList(){
        hideAl();
        $("#orderlistc").show();
    }
    function showVol(){
        hideAl();
        $("#vol").show();
    }
    function showWaterFList(){
        hideAl();
        $("#water_fac_list").show();
    }
    function hideAl(){
        $("#orderlistc").hide();
        $("#vol").hide();
        $("#water_fac_list").hide();
    }
    function selectAll(checked){
        var checkedList=$(".devitem");
        for(var index=0;index<checkedList.length;index++){
            var item=checkedList[index];
            if(checked){
                $(item).prop("checked",true);
            }else{
                $(item).prop("checked",false);
            }
        }
    }
    function openDialog(devno){
        devList=new Array();
        devList.push(devno)
        open(devList);
    }
    function batchOpenDialog(){
        var devnoArr=new Array();
       var devArr= $("input.devitem:checked");
        if(devArr.length==0){
            return;
        }
        for(var index=0;index<devArr.length;index++){
            var item=devArr[index];
            var devno=$(item).attr("devno");
            devnoArr.push(devno);
        }
        open(devnoArr);
    }
    function open(devnos){
        devList=devnos;
        $(".dialog_container").show();
    }
    function closeDialog(){
        $(".dialog_container").hide();
    }
</script>
