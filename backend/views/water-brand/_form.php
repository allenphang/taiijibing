<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/25
 * Time: 11:15
 */
use feehi\widgets\ActiveForm;

$this->title = '水品牌';
?>
<div class="col-sm-12">
    <div class="ibox">
        <?= $this->render('/widgets/_ibox-title') ?>
        <div class="ibox-content">

            <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data','class'=>'form-horizontal']]); ?>
            <?= $form->field($model, 'BrandName')->textInput(['maxlength' => 64]) ?>

            <?= $form->defaultButtons() ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
