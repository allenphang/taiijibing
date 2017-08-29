<?php
use yii\widgets\LinkPager;
?>
<link rel="stylesheet" href="/static/js/datepicker/dateRange.css"/>
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
    <script type="text/javascript" src="/static/js/datepicker/dateRange.js"></script>
<div class="wrapper wrapper-content">

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

</div>

<?= LinkPager::widget(['pagination' => $pages]); ?>