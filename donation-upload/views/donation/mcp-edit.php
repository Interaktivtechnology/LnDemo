<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\McpVerification */
/* @var $form ActiveForm */
?>
<div class="mcp-edit">

<h2>Edit MCP </h2>
<hr />
    <?php $form = ActiveForm::begin(); 

     $form->encodeErrorSummary = true;
     //$form->enableAjaxValidation = true;
     //echo $form->errorSummary($model->getErrors());

    ?>
<div class="row">
    <div class="col-md-4 col-md-offset-4 text-center">
        <div class="form-group">
            <a href="<?php echo Url::to('@web/mcp/index')?>" type="button" class="btn btn-default">Cancel</a>
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'trx_date') ?>
    </div>
    
    <div class="col-md-6">
        <?= $form->field($model, 'amount') ?>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-6">
        <?= $form->field($model, 'reference') ?>
    </div>
    
    <div class="col-md-6">
        <?= $form->field($model, 'auth_code') ?>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-6">
        <?= $form->field($model, 'payer_name') ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'card_no') ?>
    </div>
    <div class="clearfix"></div>

    <div class="col-md-6">
        <?= $form->field($model, 'response_message') ?>
    </div>
    <div class="clearfix"></div>    

    <div class="col-md-4 col-md-offset-4 text-center">
        <div class="form-group">
            <a href="<?php echo Url::to('@web/mcp/index')?>" type="button" class="btn btn-default">Cancel</a>
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- mcp-edit -->
