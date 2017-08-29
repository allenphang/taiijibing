<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/31
 * Time: 14:17
 */
?>
<div class="row">


</div>
<div class="row">

    <div class="col-sm-6">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>今日数据</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content no-padding">
                    <ul class="list-group">
                        <style>.list-group-item>.badge{float:left} li.list-group-item strong{margin-left: 15px;}</style>
                        <li class="list-group-item">
                            <span class="badge badge-primary">&nbsp;&nbsp;</span><strong>硬件激活数量</strong>: <?=$info["amount"]?>
                        </li>
                        <li class="list-group-item ">
                            <span class="badge badge-info">&nbsp;&nbsp;</span> <strong>水袋销量</strong>: <?=$info["water_sell"]?>
                        </li>
                        <li class="list-group-item">
                            <span class="badge badge-success">&nbsp;&nbsp;</span> <strong>硬件异常数量</strong>: <?=0?>
                        </li>
                        <li class="list-group-item">
                            <span class="badge badge-success">&nbsp;&nbsp;</span> <strong>水袋库存</strong>: <?=0?>
                        </li>
                        <li class="list-group-item">
                            <span class="badge badge-success">&nbsp;&nbsp;</span> <strong>利润</strong>:<?=0?>
                        </li>
                        <li class="list-group-item">
                            <span class="badge badge-success">&nbsp;&nbsp;</span> <strong>流水</strong>: <?=$info["today_income"]?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        </div>
    <div class="col-sm-6">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>累计数据</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content no-padding">
                    <ul class="list-group">
                        <style>.list-group-item>.badge{float:left} li.list-group-item strong{margin-left: 15px;}</style>
                        <li class="list-group-item">
                            <span class="badge badge-primary">&nbsp;&nbsp;</span><strong>硬件激活数量</strong>:  <?=$info["total_water_sell"]?>
                        </li>
                        <li class="list-group-item ">
                            <span class="badge badge-info">&nbsp;&nbsp;</span> <strong>水袋销量</strong>: <?=$info["all_active_devs"]?>
                        </li>
                        <li class="list-group-item">
                            <span class="badge badge-success">&nbsp;&nbsp;</span> <strong>硬件异常数量</strong>: <?=0?>
                        </li>
                        <li class="list-group-item">
                            <span class="badge badge-success">&nbsp;&nbsp;</span> <strong>水袋库存</strong>:<?=0?>
                        </li>
                        <li class="list-group-item">
                            <span class="badge badge-success">&nbsp;&nbsp;</span> <strong>利润</strong>: <?=0?>
                        </li>
                        <li class="list-group-item">
                            <span class="badge badge-success">&nbsp;&nbsp;</span> <strong>流水</strong>:  <?=$info["total_income"]?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
    </div>
</div>


