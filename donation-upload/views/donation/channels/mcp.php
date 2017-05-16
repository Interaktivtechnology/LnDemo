<?php
use yii\helpers\Url;
use yii\base\View;
use yii\helpers\Html;
use yii\grid\GridView;

$log = Yii::$app->session->getFlash('log'); 
?>


<div class="donation-index">
    <h2>MCP Download Record </h2>
   
    <div class="row">

        <div class="col-md-4 col-md-offset-4">
            <div class="text-center">
                <a href="#" data-toggle="modal" data-target="#modalConfirmUploadSf"type="button" class="btn btn-success" data-url="/mcp/upload-to-sf" ><i class="fa fa-cloud-upload"></i> Upload to Salesforce</a>
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
        'filterModel' => $mcp,
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
                'header' => 'Upload',
                'checkboxOptions' => function ($model, $key, $index, $column) {
                    return ['value' => $model->id, 'readonly' => $model->salesforce_id == null ? 'readonly' : ''];
                }
            ],
            [
                'attribute' => 'reference',
                'label' => 'Transaction No'
            ],
            [
                'attribute' => 'salesforce_id',
                'label' => "Salesforce ID",
                "format" => 'raw',
                "value" => function($model, $key, $index, $column){

                    return $model->salesforce_id ? "<a class='link-sf' target='_blank' href='".yii::$app->params['instance'].$model->salesforce_id."'>".$model->salesforce_id."</a>" : "(not Set)";

                }
            ],
            [
                'attribute' => 'payer_name'
            ],
            [
                'attribute' => 'donation_id',
                'label' => 'BTWebsite Record',
                'filter' => '',
                'format' => 'raw',
                'value' => function($model, $key){
                    return $model->donation_id ? "<a class='' target='_blank' href='".Url::to(['donation/view', 'id' => $model->donation_id])."'>".
                    $model->donation_id."</a>" : "(not Set)";
                }
            ],
            
            [
                'attribute' => 'amount',
                'format' => ['decimal'],
                'options' => [
                    'class' => 'text-right'
                ]
            ],
            [
                'attribute' => 'file_name',
                'format' => 'raw',
                'value' => function($model, $key, $index, $column){
                    return '<a href="'.Url::to(['donation/download','file' => $model->file_name]).'"><i class="fa fa-download"></i> Download</a>';
                }
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
                            ($model->salesforce_id == null ? 
                            '<li><a href="'.Url::to(['mcp/edit','id' => $model->id]).'"><i class="fa fa-pencil"></i> Edit</a></li>' : '').
                          '</ul>
                    </div>';
                }
            ]
        ]
    ]); ?>
    </div>
</div>
<?php echo $this->render('modal-confirm')?>