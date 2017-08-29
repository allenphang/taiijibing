<?php
/**
 * Created by PhpStorm.
 * User: lf
 * Date: 16/4/11
 * Time: 22:02
 */
?>
        <div class="col-sm-12">
            <div class="ibox">
                <div class="ibox-title">
                    <div class="ibox-tools">
                        <a class="btn btn-primary btn-xs" href="/index.php?r=address%2Findex">返回</a></div>
                </div>
                <div class="ibox-content">
                    <form id="w0" class="form-horizontal" action="/index.php?r=address/create" method="post">

                        <div class="form-group field-user-username required ">
                            <label class="col-sm-2 control-label" for="user-username">上级地区</label>
                            <div class="col-sm-10"> <select class="form-control" name="Address[PId]" id="addresses" >
                                <option value="0">请选择</option>
                            </select>
                        </div>
                        </div>
                        <div class="form-group field-user-username required ">
                            <label class="col-sm-2 control-label" for="user-username">名称</label>
                            <div class="col-sm-10">
                                <input name="Address[Name]" type="text" class="form-control"/>

                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-primary" type="submit">保存</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
<script type="text/javascript" src="./static/js/jquery.min.js"></script>
<script>
    var data=<?=$data?>;
</script>
<script>
    $(function(){
        initAddressSelect();
    });
    function initAddressSelect(){

            for(var index=0;index<data.length;index++){
                var item=data[index];
                if(item.PId==0){
                    $("#addresses").append("<option value='"+item.Id+"'>"+item.Name+"</option>");
                    var childAddress=getListByPid(item.Id);
                    for(var cindex=0;cindex<childAddress.length;cindex++){
                        var citem=childAddress[cindex];
                        $("#addresses").append("<option value='"+citem.Id+"'>----"+citem.Name+"</option>");
                    }
                }
            }
    }
    function getListByPid(pid){
            var temp=[];
            for(var index=0;index<data.length;index++){
                var item=data[index];
                if(item.PId!=0&&item.PId==pid){
                    temp.push(item);
                }
            }
        return temp;
    }
</script>
