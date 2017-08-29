<?php
use yii\widgets\LinkPager;
?>

<div class="wrapper wrapper-content">
    <form action="/index.php?r=dev-manager/list" method="post">
        <div style="margin-bottom:10px;">

            <span style="padding-left:5px;"><label>设备编号:</label><input type="text" name="devno" value="<?=$devno?>"/></span>
            <span style="padding-left:5px;"><label>社区服务中心:</label><input type="text" name="sname" value="<?=$sname?>"/></span>
            <span style="padding-left:5px;"><label>县区运营中心:</label><input type="text" name="xname" value="<?=$xname?>"/></span>
            <input type="submit" value="查询"/>
        </div>

        </form>
    <table class="table table-hover" style="background:white;">
        <thead>
        <th>设备编号</th>
        <th>设备手机号</th>
        <th>厂家</th>
        <th>社区服务中心</th>
        <th>县区运营中心</th>
        <th>设备激活时间</th>
        <th>位置信息</th>
        </thead>
        <tbody>
        <?php
        $str='';
        foreach($model as $key=>$val)
        {
            $str.= "<tr>
                        <td>".$val["DevNo"]."</td>
                        <td>".$val["DevBindMobile"]."</td>
                        <td>".$val["DevFactory"]."</td>
                        <td>".$val["agentname"]."</td>
                        <td>".$val["agentpname"]."</td>
                        <td>".$val["Date"]."</td>
                        <td>".$val["Address"]."(".$val["Lat"].",".$val["Lng"].")</td>
                        </tr>";
        }
        echo $str;
        ?>
        </tbody>
    </table>
</div>

<?= LinkPager::widget(['pagination' => $pages]); ?>
