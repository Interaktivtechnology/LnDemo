<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\helpers\Url;
use yii\web\View;
?>
        <div id="page-wrapper" style="width:100%;padding:20px;margin-top:-10px">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Recent Donations</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
                <div class="col-lg-10">
                </div>
                <div class="col-lg-2" style="float:right">
                    <a id="sf-upload" onclick="return confirmSfUpload()" href="<?= Url::to(['donation/upload-to-sf', 'Channel'=>$dbChannel]) ?>" class="btn btn-default">Upload to Salesforce</a>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <?php 
                if(isset($_SESSION['notif'])){
                    if($_SESSION['notif'] == 'true'){
                        echo '<div class="alert alert-success">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                Data updated.
                            </div>';
                    }
                    else{
                        echo '<div class="alert alert-danger">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                Data cant be saved.
                            </div>';
                    }
                    unset($_SESSION['notif']);
                }
            ?>
            <div class="row">
                <div class="col-lg-6">
                    <form role="form" method="post" class="form-horizontal" action="index.php?r=donation/index<?php if(isset($_GET['channel'])) echo '&channel='.$_GET['channel'].'';?>">
                        <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
                        <fieldset >
                            <div class="form-group">
                              <label class="col-md-4 control-label" for="start_date">Start Date</label>  
                              <div class="col-md-4">
                              <input id="start_date" name="start_date" placeholder="mm/dd/yyyy" class="form-control input-md datepicker" required="" type="text" value="" readonly="">
                                
                              </div>
                            </div>

                             <div class="form-group">
                              <label class="col-md-4 control-label" for="end_date">End Date</label>  
                              <div class="col-md-4">
                              <input id="end_date" name="end_date" placeholder="mm/dd/yyyy" class="form-control input-md datepicker" required="" type="text" value="<?php if(isset($_GET['enddate'])) echo date('d/m/Y',strtotime($_GET['enddate'])); ?>" readonly="">
                                
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="col-md-4 control-label" for="channel2">Channel of Donation</label>  
                              <div class="col-md-4">
                                    <select id="channel" name="channel2" class="form-control">
                                        <?php $c = '
                                        <option value="">All Data</option>
                                        <option value="1">BT Website</option>
                                        <option value="2">Give Asia</option>
                                        <option value="3">SG Gives</option>';
                                        if(isset($_GET['channel2'])){
                                            $c = str_replace('value="'.$_GET['channel2'].'"', 'value="'.$_GET['channel2'].'" selected="selected"', $c);
                                        }
                                        echo $c;
                                        ?>
                                    </select>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="col-md-4 control-label" for="submit"></label>  
                              <div class="col-md-4">
                                <input type="submit" id="submit_btn" class="btn btn-success"  value="Submit"/>
                              </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">                                
                                <!-- /.col-lg-6 (nested) -->
                                <div class="col-lg-12 datatable"  style="width:100%;overflow:auto">
                                    <table cellspacing="0" cellpadding="0" border="0" class="table table-striped">
                                    <thead>
                                        <th scope="col"></th>
                                        <th scope="col">Transaction Type</th>
                                        <th scope="col">Date Received</th>
                                        <th scope="col">Date Imported</th>
                                        <th scope="col">Channel</th>
                                        <th scope="col">Transaction ID</th>
                                        <th scope="col">Reference</th>
                                        <th scope="col">Remarks</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Tax Deductable</th>
                                        <th scope="col">Salutation</th>
                                        <th scope="col">Donor Name</th>
                                        <th scope="col">ID Type</th>
                                        <th scope="col">ID No.</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Address</th>
                                        <th scope="col">Postal Code</th>
                                    </thead>
                                    <tbody>

<!-- ListRow -->
<?php 

foreach($donations as $data){
?>
<tr>
    <td class=" dataCell  "><a href="edit.php?id=<?php echo $data['id'];?>" class="btn btn-warning">Edit</a></td>
    <td class=" dataCell  " scope="row"><?php echo $data['payment_type'];?></td>
    <td class=" dataCell  "><?php echo date('d/m/Y',strtotime($data['date_received']));  ?></td>
    <td class=" dataCell  "><?php echo date('d/m/Y h:i a',strtotime($data['imported_date']));  ?></td>
    <td class=" dataCell  "><?php echo $data['channel'];?></td>
    <td class=" dataCell  "><?php echo $data['trx_id'];?></td>
    <td class=" dataCell  "><?php echo $data['reference'];?></td>
    <td class=" dataCell  "><?php echo $data['remarks'];?></td>
    <td class=" dataCell "><?php echo number_format($data['amount'],2,'.',',') ?></td>
    <td class=" dataCell  "><?php echo $data['tax_deductable'];?></td>
    <td class=" dataCell  "><?php echo ucwords($data['salutation']);?></td>
    <td class=" dataCell  "><?php echo ucwords($data['name']); ?></td>
    <td class=" dataCell  "><?php echo $data['id_type'];?></td>
    <td class=" dataCell  "><?php echo strtoupper($data['id_no']);?></td>
    <td class=" dataCell  "><?php echo $data['email'];?></td>
    <td class=" dataCell  "><?php echo $data['address'];?></td>
    <td class=" dataCell  "><?php echo $data['postcode'];?></td>

</tr>
<?php } ?>
<!-- ListRow -->

</tbody></table>
                          
        <?php
        $js = "function confirmSfUpload() {
            conf = confirm('This will upload ". $sfCount ." data to salesforce.');"
                . "if(conf) { return true }"
                . "else { return false; } }";
        $this->registerJs($js, View::POS_END );