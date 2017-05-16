<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\DonationTemp */
/* @var $form ActiveForm */
?>
<div class="formDonation">
<hr />
    <?php $form = ActiveForm::begin();

     $form->encodeErrorSummary = true;
     //$form->enableAjaxValidation = true;
     //echo $form->errorSummary($model->getErrors());

    ?>
    <div class="row">
        <div class="col-md-4 col-md-offset-4 text-center">
            <div class="form-group">
                <a href="<?php echo Url::to('@web/donation/index')?>" type="button" class="btn btn-default"><i class="fa fa-arrow-left"></i > Cancel</a>
                <?php if($model->sf_upload == 0):?>
                <a href="<?php echo Url::to(['donation/edit','id' => $model->id]);?>" type="button" class="btn btn-warning"><i class="fa fa-pencil"></i> Edit</a>
                <a href="<?php echo Url::to(['donation/delete','id' => $model->id]);?>" type="button" class="btn btn-danger" data-confirm="Please click 'OK' to proceed or 'Cancel' to stop"><i class="fa fa-trash"></i> Delete</a>
                <a href="<?php echo Url::to(['donation/upload-to-sf', 'id' => $model->id])?>" type="button" class="btn btn-primary"><i class="fa fa-cloud"></i > Upload to SF</a>
                <?php endif;?>

            </div>
        </div>
        <div class="col-md-2 text-center col-xs-12 pull-right col-sm-2">

                <?php if($model->sf_upload == 0):?>
                    <div class="alert alert-info"><i class="fa fa-2x fa-save"></i><br />
                     Not Uploaded</div>
                <?php else:?>
                    <div class="alert alert-success"><i class="fa fa-2x fa-cloud"></i><br />
                     Uploaded
                     To
                     Salesforce :
                     <?php echo "<a class='link-sf' target='_blank' href='".yii::$app->params['instance'].$model->salesforce_id."'>".$model->salesforce_id."</a>"?>
                     </div>

                <?php endif?>
            </span> </p>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-12 ">
            <div class="col-md-6">
                 <table class="table">
                    <caption><h4>Donation Detail</h4></caption>
                        <tbody>
                        <tr>
                            <th scope="row">Receipt No.</th>
                            <td>-</td>
                        </tr>
                        <tr>
                            <th scope="row">ID Type</th>
                            <td><?= $model->id_type; ?></td>
                        </tr>
                        <tr>
                            <th scope="row">ID No</th>
                            <td><?= $model->id_no; ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Valid NRIC</th>
                            <td><?= $model->valid_nric ? "Yes" : "No"; ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Donor Name</th>
                            <td><?= ucwords(strtolower($model->name)); ?></td>
                        </tr>
                        <?php if($model->id_type <> 'UEN'):?>
                        <tr>
                            <th scope="row">Contact Name</th>
                            <td><?= ucwords(strtolower($model->name)); ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Address</th>
                            <td><?= $model->address; ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Postcode</th>
                            <td><?= $model->postcode; ?></td>
                        </tr>
                        <?php endif;?>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                 <table class="table">
                    <caption><h4>&nbsp;</h4></caption>
                        <tbody>
                        <tr>
                            <th scope="row">Donation Date</th>
                                <td><?= Yii::$app->formatter->asDatetime($model->date_received, "php:d F Y"); ?>
                                </td>
                        </tr>
                        <tr>
                            <th scope="row">Donation Status</th>
                            <td><?=$model->Status__c?></td>
                        </tr>
                        <tr>
                            <th scope="row">Cleared Date</th>
                            <td><?=Yii::$app->formatter->asDatetime($model->date_cleared, "php:d F Y")?></td>
                        </tr>
                        <tr>
                            <th scope="row">Tax Deductible</th>
                            <td><?php if(isset($model->id_type)) {?>
                                <small><span aria-hidden="true" class="glyphicon glyphicon-check"></span></small>
                                <?php } else { ?>
                                <small><span aria-hidden="true" class="glyphicon glyphicon-unchecked"></span></small>
                                <?php } ?>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-12 ">
            <div class="col-md-6">
                 <table class="table">
                    <caption><h4>Additional Information</h4></caption>
                        <tbody>
                        <tr>
                            <th scope="row">Donation Purpose</th>
                            <td></td>
                        </tr>
                        <tr>
                            <th scope="row">Campaign Name</th>
                            <td><?= $model->event_name; ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Child Name</th>
                            <td></td>
                        </tr>
                        <tr>
                            <th scope="row">Programme Name</th>
                            <td><?= $model->charity_name; ?></td>
                        </tr>

                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                 <table class="table">
                    <caption><h4>&nbsp;</h4></caption>
                        <tbody>
                        <tr>
                            <th scope="row">Batch No</th>
                                <td>
                                </td>
                        </tr>
                        <tr>
                            <th scope="row">Pot Name</th>
                            <td></td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-12 ">
            <div class="col-md-6">
                 <table class="table">
                    <caption><h4>Payment Details</h4></caption>
                        <tbody>
                        <tr>
                            <th scope="row">Donation Amount</th>
                            <td>$ <?= number_format($model->amount,2,'.',','); ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Fees</th>
                            <td>$ <?= number_format($model->fees,2,'.',','); ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Gross Amount</th>
                            <td>$ <?= number_format($model->gross,2,'.',','); ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Payment Method</th>
                            <td><?= $model->payment_type; ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Bank</th>
                            <td><?= $model->Bank__c ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Card Type</th>
                            <td></td>
                        </tr>
                        <tr>
                            <th scope="row">Credit Card No.</th>
                            <td></td>
                        </tr>
                        <tr>
                            <th scope="row">Expiry Date</th>
                            <td></td>
                        </tr>
                        <tr>
                            <th scope="row">Transaction No.</th>
                            <td><?= $model->reference; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                 <table class="table">
                    <caption><h4>&nbsp;</h4></caption>
                        <tbody>
                        <tr>
                            <th scope="row">Channel of Donation</th>
                                <td><?= $model->channel; ?>
                                </td>
                        </tr>
                        <tr>
                            <th scope="row">Frequency Type</th>
                            <td></td>
                        </tr>
                        <tr>
                            <th scope="row">Frequency Period</th>
                            <td></td>
                        </tr>
                        <tr>
                            <th scope="row"></th>
                            <td></td>
                        </tr>
                        <tr>
                            <th scope="row">Tax Credit To Name</th>
                            <td></td>
                        </tr>
                        <tr>
                            <th scope="row">ID No. (Tax Credit To)</th>
                            <td></td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-12 ">
            <div class="col-md-6">
                 <table class="table">
                    <caption><h4>Remarks</h4></caption>
                        <tbody>
                        <tr>
                            <th scope="row">Dedication</th>
                            <td><?= $model->event_name; ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Remarks</th>
                            <td><?= $model->remarks; ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Created By</th>
                            <td>Interaktiv, <?= Yii::$app->formatter->asDatetime($model->created_date, "php:d/m/Y H:i"); ?> </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                 <table class="table">
                    <caption><h4>&nbsp;</h4></caption>
                        <tbody>
                        <tr>
                            <th scope="row">&nbsp;</th>
                            <td></td>
                        </tr>
                        <tr>
                            <th scope="row">&nbsp;</th>
                            <td></td>
                        </tr>
                        <tr>
                            <th scope="row">Last Modified By</th>
                            <td>Interaktiv, <?= Yii::$app->formatter->asDatetime($model->last_modified_date, "php:d/m/Y H:i"); ?> </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-4 col-md-offset-4 text-center">
            <div class="form-group">
                <?php if($model->sf_upload == 0):?>
                <a href="<?php echo Url::to(['donation/edit','id' => $model->id]);?>" type="button" class="btn btn-warning">Edit</a>
                <a href="<?php echo Url::to(['donation/delete','id' => $model->id]);?>" type="button" class="btn btn-danger" data-confirm="Please click 'OK' to proceed or 'Cancel' to stop">Delete</a>
                <?php endif;?>
                <a href="<?php echo Url::to('@web/donation/index')?>" type="button" class="btn btn-default">Cancel</a>
            </div>
        </div>
        <?php ActiveForm::end(); ?>

</div><!-- end of view detail  -->
<?php echo $this->render('channels/delete-modal-confirm')?>
