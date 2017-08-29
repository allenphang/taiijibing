<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/25
 * Time: 11:15
 */

use feehi\widgets\ActiveForm;
$this->title = "";
?>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox">
            <?= $this->render('/widgets/_ibox-title') ?>
            <div class="ibox-content">
                <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data','class'=>'form-horizontal']]); ?>
                <?= $form->field($model, 'TotalMoney')->textInput(['maxlength' => 10]) ?>
                <input type="hidden" name="OrderSuccess[Fid]" value="<?=$fid ?>"/>
                <div class="hr-line-dashed"></div>
                <?= $form->field($model, 'OrderMoney')->textInput(['maxlength' => 11]) ?>
                <div class="hr-line-dashed"></div>
                <?= $form->field($model, 'CouponMoney')->textInput(['maxlength' => 64]) ?>
                <div class="hr-line-dashed"></div>
                <?= $form->field($model, 'Volume')->textInput(['maxlength' => 64]) ?>
                <div class="hr-line-dashed"></div>
                <?= $form->field($model, 'Amount')->textInput(['maxlength' => 64]) ?>
                <div class="hr-line-dashed"></div>
                <?= $form->defaultButtons() ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
