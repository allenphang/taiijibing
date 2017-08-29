<?php
use yii\widgets\LinkPager;
?>
<link rel="stylesheet" href="/static/js/datepicker/dateRange.css"/>
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
    <script type="text/javascript" src="/static/js/datepicker/dateRange.js"></script>
<div class="wrapper wrapper-content">
    <div style="margin-bottom:10px;">
        <form method="post" action="/index.php?r=saoma/list">
        <span><label>水厂:</label><input type="text" placeholder="请输入水厂名称" name="waterfname" value="<?=$waterfname?>"/></span>
        <span style="padding-left:10px;"><label>县区运营中心:</label><input type="text" placeholder="请输入水厂名称" name="xname" value="<?=$xname?>"/></span>
        <span style="padding-left:10px;"><label>社区服务中心:</label><input type="text" placeholder="请输入水厂名称" name="sname" value="<?=$sname?>"/></span>
        <span style="padding-left:10px;"><label>时间段:</label><input type="text" placeholder="" name="selecttime" id="selecttime" /></span>
        <input style="padding-left:10px;" type="submit" value="查询" id="btn"/>
        </form>
    </div>
        <table class="table table-hover" style="background:white;">
            <thead>
            <th>条码</th>
            <th>设备编码</th>
            <th>姓名</th>
            <th>手机号</th>
            <th>社区服务中心</th>
            <th>县区运营中心</th>
            <th>水厂</th>
            <th>设备厂家</th>
            <th>地址</th>
            <th>操作时间</th>
            </thead>
            <tbody>
            <?php
            $str='';
            foreach($model as $key=>$val)
            {
                $str.= "<tr><td>".$val["BarCode"]."</td><td>".$val["DevNo"]."</td><td>".$val["Name"]."</td><td>".$val["Tel"]."</td><td>".$val["agentname"]."</td><td>".$val["agentpname"]."</td><td>".$val["factoryName"]."</td><td>".$val["DevFactory"]."</td><td>".$val["Address"]."</td><td>".$val["RowTime"]."</td></tr>";
            }
            echo $str;
            ?>
            </tbody>
        </table>
        <table>
            <th
        </table>
<script type="text/javascript">
    $(function(){
        var dateRange = new pickerDateRange('selecttime', {
            aRecent7Days : '', //最近7天
            isTodayValid : true,
            //startDate : '2013-04-14',
            //endDate : '2013-04-21',
            //needCompare : true,
            //isSingleDay : true,
            //shortOpr : true,
            defaultText : '至',
            inputTrigger : 'selecttime',
            theme : 'ta',
            success : function(obj) {
//                startTimeStr = obj.startDate;
//                endTimeStr = obj.endDate;
            }
        });
        $("#selecttime").val('<?=$selecttime?>');
    });
</script>

</div>

<?= LinkPager::widget(['pagination' => $pages]); ?>