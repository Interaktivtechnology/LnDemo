<?php
use yii\helpers\Html;
use yii\helpers\Url;

$log = Yii::$app->session->getFlash('log');
?>

<div id="page-wrapper" style="width:100%;padding:20px;margin-top:-10px">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Upload Data</h1>
        </div>
        <div class="clearfix"></div>
        <!-- /.col-lg-12 -->
        <?php if($log):?>
        <div class="log">
            <div class="alert alert-info alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                <h4>Channel: <?php echo Yii::$app->getSession()->getFlash('channel') ?></h4>
                    <p><?php echo Yii::$app->session->getFlash('successCount')?>  uploaded<br /></p>
                    <p><?php $error = Yii::$app->session->getFlash('errorCount');
                    if($error > 0)
                        echo '<strong class="label label-danger">'."No data inserted, since there are ".$error." row(s) error detected. </strong>"
                    ?>  <br /></p>
                <p><strong>Info:</strong> Please look at your upload log <a href="#" data-target="#modalLog" data-toggle="modal">here</a></p>
            </div>
        </div>
        <?php endif;?>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <!-- /.col-lg-6 (nested) -->
                        <div class="col-lg-6">
                            <form role="form" method="post" enctype="multipart/form-data" id="convertform"  action="<?php echo Url::to('@web/donation/upload')?>">
                                <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
                                <fieldset >
                                    <div class="form-group">
                                        <label for="dataupload">Choose File *)</label>
                                          <input id="input-24" type="file" name="file" multiple=true class="file-loading" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="channel">Channel</label>
                                        <select id="channel" name="channel" class="form-control">
                                            <option value="giveasia">Give Asia</option>
                                            <option value="simplygiving">Simply Giving</option>
                                            <option value="givingsg">Giving SG</option>
                                        </select>
                                    </div>
                                    <div class="form-group" style="font-size: 11px">
                                        *) Only accept CSV(Comma Separated Value), XLS (Excel 2003 or before) or XLSX (Excel 2007 or later)
                                    </div>
                                    <input type="submit" id="submit_btn" class="btn btn-primary" value="Submit"/>
                                </fieldset>
                            </form>
                        </div>
                        <!-- /.col-lg-6 (nested) -->
                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
