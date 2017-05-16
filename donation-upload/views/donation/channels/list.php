<?php
use yii\helpers\Url;
use yii\base\View;
use yii\helpers\Html;
use yii\grid\GridView;

$log = Yii::$app->session->getFlash('log');
?>


<div class="donation-index">
    <h2>Donation </h2>

    <div class="row">

        <div class="col-md-4 col-md-offset-4">
            <div class="text-center">
                <a href="#" data-toggle="modal" data-target="#modalConfirmUploadSf"type="button" class="btn btn-success" ><i class="fa fa-cloud-upload"></i> Upload to Salesforce</a>
            </div>
        </div>
    </div>
     <div class="row">
        <div class="col-md-4">
            <div class="form-group select-radio">
                <div class="btn-group" data-toggle="buttons">
                    <label class="btn btn-primary btn-sm">
                        <input type="radio" name="options" value="1" checked> Select All
                    </label>
                    <label class="btn btn-warning btn-sm">
                        <input type="radio" name="options" value="0"> UnSelect All
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
     <?php if(Yii::$app->session->getFlash('notification')):?>
        <div class="log">
            <div class="alert alert-info alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <strong>Info:</strong>
                  <?php echo Yii::$app->session->getFlash('notification')?> <br />
            </div>
        </div>
        <?php endif;?>
        <?php if($log):?>
        <div class="log">
            <div class="alert alert-info alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <strong>Info:</strong>
                  <?php echo Yii::$app->session->getFlash('success')?> <br />
                  Please look at your upload log <a href="#" data-target="#modalLog" data-toggle="modal">here</a>
            </div>
        </div>
        <?php endif;?>
    <div class="table-responsive">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $donation,
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
                'header' => 'Upload',
                'checkboxOptions' => function ($model, $key, $index, $column) {
                    return ['value' => $model->id, 'readonly' => $model->sf_upload == 0 ? 'readonly' : ''];
                }
            ],
            [
                'attribute' => 'id',
                'label' => "#Record Id",
                'format' => 'html',
                'value' => function($model, $key) {
                  return '<a href="'.Url::to(['donation/view','id' => $model->id]).'">'.sprintf("%05d", $model->id).'</a>';
                }
            ],
            [
                'attribute' => 'sf_upload',
                'label' => "UploadedToSalesForce",
                "format" => 'raw',
                "filter" => ["0" => "No", "1" => "Yes"],
                "value" => function($model, $key, $index, $column){
                    return $model->sf_upload == 1 ? "<a class='link-sf' target='_blank' href='".yii::$app->params['instance'].$model->salesforce_id."'>".$model->salesforce_id."</a>" : "NO";

                }
            ],
            [
                'attribute' => 'name',
                "value" => function($model, $key, $index, $column){
                    return ucwords(strtolower($model->name));
                }
            ],
            [
                'attribute' => 'id_type',
                'label' => 'ID Type'
            ],
            [
                'attribute' => 'id_no',
                'label' => 'ID No'
            ],
            [
                'attribute' =>  'payment_type',
                'filter' => $donation->getDistinctPaymentType()
            ],
            [
                'attribute' => 'date_received',
                'format' => ['date', 'php:d F Y']
            ],
            [
                'attribute' => 'channel',
                'filter' =>  ['Sg Gives' => 'Sg Gives', 'Give Asia' => 'Give Asia','MySQLCMS' => 'MySQLCMS', 'BT Website' => 'BT Website', 'Giving Sg' => 'Giving Sg']
            ],
            [
                'attribute' => 'amount',
                'label' => 'Donation Amount',
                'format' => ['decimal'],
                'options' => [
                    'class' => 'text-right'
                ]
            ],
            [
                'attribute' => 'data_source',
                'format' => 'raw',
                'value' => function($model, $key, $index, $column){
                    return '<a href="'.Url::to(['donation/download','file' => $model->data_source]).'"><i class="fa fa-download"></i> Download</a>';
                }
            ],
            [
                'attribute' => 'reference',
                'label' => 'Transaction No'
            ],
            [
                'label' => 'Action',
                'format' => 'raw',
                'value' => function($model, $key, $index, $column){
                    return '<div class="btn-group">
                          <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action <span class="caret"></span>
                          </button>
                          <ul class="dropdown-menu">'.
                            ($model->sf_upload == 0 ?
                            '<li><a href="'.Url::to(['donation/edit','id' => $model->id]).'"><i class="fa fa-pencil"></i> Edit</a></li>
                            <li><a href="'.Url::to(['donation/delete','id' => $model->id]).'" data-confirm="Please click \'OK\' to proceed or \'Cancel\' to stop"><i class="fa fa-trash"></i> Delete</a></li>' : '').
                            '<li><a href="'.Url::to(['donation/view','id' => $model->id]).'"><i class="fa fa-eye"></i> View Details</a></li>
                          </ul>
                    </div>';
                }
            ]
        ]
    ]); ?>
    </div>
</div>
<?php echo Yii::$app->controller->renderPartial('channels/delete-modal-confirm')?>
<?php echo Yii::$app->controller->renderPartial('channels/modal-confirm')?>
