<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\DonationTemp */
/* @var $form ActiveForm */
?>
<div class="formDonation">

<h2>Edit Donation </h2>
<hr />
    <?php $form = ActiveForm::begin();

     $form->encodeErrorSummary = true;
     //$form->enableAjaxValidation = true;
     //echo $form->errorSummary($model->getErrors());

    ?>
    <div class="row">
        <div class="col-md-4 col-md-offset-4 text-center">
            <div class="form-group">
                <a href="<?php echo Url::to('@web/donation/index')?>" type="button" class="btn btn-default">Cancel</a>
                <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    <div class="col-md-6">
            <?= $form->field($model, 'salutation') ->dropDownList(['Mr' => 'Mr', 'Mrs' => 'Mrs','Miss' => 'Miss', 'Dr' => 'Dr']); ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'name') ?>
        </div>


        <div class="clearfix"></div>
        <div class="col-md-6">
            <?= $form->field($model, 'id_type')->dropDownList(['NRIC' => 'NRIC', 'FIN' => 'FIN', 'UEN' => 'UEN', '' => 'OTHERS']); ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'id_no'); ?>
        </div>


        <div class="clearfix"></div>
        <div class="col-md-6">
            <?= $form->field($model, 'payment_type') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'date_received')->
            widget(\yii\widgets\MaskedInput::className(), [
                'mask' => '9999-99-99',
            ]); ?>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-6">
            <?= $form->field($model, 'amount')->textInput()->label('Donation Amount'); ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'reference'); ?>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-6">
            <?= $form->field($model, 'fees') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'gross') ?>
        </div>



        <div class="clearfix"></div>
        <div class="col-md-6">
            <?= $form->field($model, 'channel')->dropDownList(['Sg Gives' => 'Sg Gives', 'Give Asia' => 'Give Asia','MySQLCMS' => 'MySQLCMS', 'BT Website' => 'BT Website']); ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'remarks') ?>
        </div>


        <div class="clearfix"></div>
        <div class="col-md-6">
            <?= $form->field($model, 'email');?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'phone') ?>
        </div>


        <div class="clearfix"></div>
        <div class="col-md-6">
            <?= $form->field($model, 'address')->textArea(['rows' => '3']);?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'postcode') ?>
        </div>
        <div class="clearfix"></div>
    </div>




    <div class="col-md-4 col-md-offset-4 text-center">
        <div class="form-group">
            <a href="<?php echo Url::to('@web/donation/index')?>" type="button" class="btn btn-default">Cancel</a>
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- formDonation -->
