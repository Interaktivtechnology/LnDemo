<?php
use yii\helpers\Html;
?>

<div id="page-wrapper" style="width:100%;padding:20px;margin-top:-10px">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Upload Data</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">                                
                        <!-- /.col-lg-6 (nested) -->
                        <div class="col-lg-6">
                            <form role="form" method="post" enctype="multipart/form-data" id="convertform"  action="donation/upload">
                                <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
                                <fieldset >
                                    <div class="form-group">
                                        <label for="dataupload">Choose File</label>
                                          <input id="input-24" type="file" name="file" multiple=true class="file-loading" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="select1">Source Type</label>
                                        <select id="select1" class="form-control">
                                            <option value="csv">CSV File</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="channel">Channel</label>
                                        <select id="channel" name="channel" class="form-control">
                                            <option value="btwebsite">BT Website</option>
                                            <option value="giveasia">Give Asia</option>
                                            <option value="sggives">SG Gives</option>
                                        </select>
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
<!-- /#page-wrapper -->
    

<div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Import data done!</h4>
      </div>
      <div class="modal-body">
        File : <span id="filename"></span>
        <table class="table">
            <tr class="odd">
                <td width="100px">Total Records Imported</td>
                <td width="100px" id="totalrecords">0</td>
            </tr>
            <tr class="odd">
                <td width="100px">Number of Successful Records</td>
                <td width="100px" id="successrecords">0</td>
            </tr>
            <tr class="even">
                <td width="100px">Number of Error Records</td>
                <td width="100px" id="errorrecords">0</td>
            </tr>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-close" data-dismiss="modal">Close</button>
        <a href="index.php?r=donation/index"><button type="button" class="btn btn-primary btn-date">View Data</button></a>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<div class="modal hide" id="pleaseWaitDialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-header">
        <h1>Processing...</h1>
    </div>
    <div class="modal-body">
        <div class="progress progress-striped active">
            <div class="bar" style="width: 100%;"></div>
        </div>
    </div>
</div>


