<?php
use yii\widgets\LinkPager;
use feehi\widgets\Bar;
?>

<div class="wrapper wrapper-content">
    <?= Bar::widget([
        'template' => '{create}'
    ])?>
    <table class="table table-hover" style="background:white;">
        <thead>
        <th>品牌编号</th>
        <th>品牌名称</th>
        <th>添加时间</th>
        <th>操作</th>
        </thead>
        <tbody>
        <?php
        $str='';
        foreach($model as $key=>$val)
        {
            $str.= "<tr><td>".$val["BrandNo"]."</td>
                        <td>".$val["BrandName"]."</td>
                        <td>".$val["RowTime"]."</td>
                        <td><a href=javascript:deleteWaterBrand('".$val["BrandNo"]."')>删除</a></td>
                        </tr>";
        }
        echo $str;
        ?>
        </tbody>
    </table>
    <table>
        <th
    </table>
    <script type="text/javascript" src="./static/js/jquery.min.js"></script>
    <script type="text/javascript" src="./static/js/layer/layer.js"></script>
<script>
    function deleteWaterBrand(brandno){
        var ii=layer.msg("操作中……");
        $.getJSON("/index.php?r=water-brand/delete&brandno="+brandno,function(data){
            layer.close(ii);
            if(data.state!=0){
                layer.alert(data.desc);
                return;
            }
            layer.alert("操作成功",function(){
                window.location.reload(true);
            });
        });
    }
    function updateWaterBrand(brandno){
       window.location.href="/index.php?r=water-brand/update&brandno="+brandno;
    }
</script>

</div>
<?= LinkPager::widget(['pagination' => $pages]); ?>
