<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/25
 * Time: 11:15
 */

use feehi\widgets\ActiveForm;

$this->title = "Admin";
?>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox">
            <?= $this->render('/widgets/_ibox-title') ?>
            <div class="ibox-content">
                <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data','class'=>'form-horizontal']]); ?>
                <?= $form->field($model, 'username')->textInput(['maxlength' => 64]) ?>
                <div class="hr-line-dashed"></div>
                <?= $form->field($model, 'email')->textInput(['maxlength' => 64]) ?>
                <div class="hr-line-dashed"></div>
                <?= $form->field($model, 'password')->passwordInput(['maxlength' => 512]) ?>
                <div class="hr-line-dashed"></div>
                <?= $form->field($rolesModel, 'role_id', ['labelOptions' => ['label' => yii::t('app', 'Roles'), 'class'=>"col-sm-2 control-label"]])->radioList($roles) ?>
                <div class="hr-line-dashed"></div>
                <?php  if( yii::$app->controller->action->id != 'update' ){  ?>

                    <div class="form-group field-adminroleuser-role_id required">
                        <label class="col-sm-2 control-label" for="adminroleuser-role_id">业务角色</label>
                        <div class="col-sm-10"><input type="hidden" name="User[role_id]" value="">
                            <div id="adminroleuser-role_id" class="radio" aria-required="true">
                                <div class="radio radio-info radio-inline"><input type="radio" id="User[role_id]1" name="User[logic_type]" value="1" <?=$model["logic_type"]==1?"checked":""?>><label for="User[role_id]1"> 水厂 </label></div>
                                <div class="radio radio-info radio-inline"><input type="radio" id="User[role_id]2" name="User[logic_type]" value="2" <?=$model["logic_type"]==2?"checked":""?>><label for="User[role_id]2"> 设备厂家 </label></div>
                                <div class="radio radio-info radio-inline"><input type="radio" id="User[role_id]3" name="User[logic_type]" value="3" <?=$model["logic_type"]==3?"checked":""?>><label for="User[role_id]3"> 县区代理商 </label></div>
                                <div class="radio radio-info radio-inline"><input type="radio" id="User[role_id]4" name="User[logic_type]" value="4" <?=$model["logic_type"]==4?"checked":""?>><label for="User[role_id]4"> 社区代理商 </label></div>
                            </div>
                            <div class="help-block m-b-none"></div></div>
                    </div>
                    <div class="hr-line-dashed"></div>
                <?php }?>


                <?php ?>
                <?= $form->defaultButtons() ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
