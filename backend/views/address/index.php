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
        <th>id</th>
        <th>地址名称</th>
        <th>添加时间</th>
        <th>操作</th>
        </thead>
        <tbody>
        <?php
        $str='';
        foreach($model as $key=>$val)
        {
            $str.= "<tr><td>".$val["Id"]."</td>
                        <td>".$val["Name"]."</td>
                        <td>".$val["RowTime"]."</td>
                        <td><a href=javascript:deleteAddress('".$val["Id"]."')>删除</a></td>
                        </tr>";
        }
        echo $str;
        ?>
        </tbody>
    </table>
    <select class="form-control"  id="addresses" >
    </select>
    <script type="text/javascript" src="./static/js/jquery.min.js"></script>
    <script type="text/javascript" src="./static/js/layer/layer.js"></script>
    <script>
        var data=<?=$data?>;
    </script>
<script>
    $(function(){
        initAddressSelect();
    });
    function deleteAddress(id){
        var ii=layer.msg("操作中……");
        $.getJSON("/index.php?r=address/delete&id="+id,function(data){
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

    function initAddressSelect(){
        for(var index=0;index<data.length;index++){
            var item=data[index];
            if(item.PId==0){
                $("#addresses").append("<option value='"+item.Id+"'>"+item.Name+"</option>");
                initSec(item.Id);
            }
        }
    }
    function initSec(pid){
        for(var index=0;index<data.length;index++){
            var item=data[index];
            if(item.PId!=0&&item.PId==pid){
                $("#addresses").append("<option value='"+item.Id+"'>------"+item.Name+"</option>");
                initThree(item.Id)
            }
        }
    }
    function initThree(pid){
        for(var index=0;index<data.length;index++){
            var item=data[index];
            if(item.PId!=0&&item.PId==pid){
                $("#addresses").append("<option value='"+item.Id+"'>-----------"+item.Name+"</option>");
            }
        }
    }


</script>

</div>
<?= LinkPager::widget(['pagination' => $pages]); ?>
