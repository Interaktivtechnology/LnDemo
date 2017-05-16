<div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0;height:100px">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="dashboard.html"><img src="static/images/logo.png" height="50px"/> Boy's town</a>
            </div>
            <!-- /.navbar-header -->
        </nav>
        <ul class="nav navbar-top-links navbar-right">
                <li><a href="index.html"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
        </ul>
        <ul class="nav nav-tabs">
          <li><a href="dashboard.html">Data Imporatation</a></li>
         <?php
         if(!isset($_GET['channel'])){
            echo '
          <li class="active"><a href="data.php">Temporary Data - All</a></li>
          <li><a href="data.php?channel=1">Temporary Data - BT Website</a></li>
          <li><a href="data.php?channel=2">Temporary Data - Give Asia</a></li>
          <li><a href="data.php?channel=3">Temporary Data - SG Gives</a></li>';
         }
         else{
            $channel = $_GET['channel'];
            $menu = '
          <li><a href="data.php">Temporary Data - All</a></li>
          <li><a href="data.php?channel=1">Temporary Data - BT Website</a></li>
          <li><a href="data.php?channel=2">Temporary Data - Give Asia</a></li>
          <li><a href="data.php?channel=3">Temporary Data - SG Gives</a></li>';
          echo str_replace('<li><a href="data.php?channel='.$channel.'">', '<li class="active"><a href="data.php?channel='.$_GET['channel'].'">', $menu);
         }
         ?>
        </ul>
        <div id="page-wrapper" style="width:100%;padding:20px;margin-top:-10px">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <!-- /.col-lg-6 (nested) -->
                                <div class="col-lg-12">
                                    <?php
                                    if(isset($donation)){
                                        $data = $donation[0];

                                    ?>
                                    <form class="form-horizontal" method="post" action="index.php?r=donation/save">
                                        <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
                                        <fieldset>
                                        <!-- Form Name -->
                                        <legend>Edit Data</legend>
                                        <div class="col-lg-12">
                                        <!-- Button (Double) -->
                                        <div class="form-group">
                                          <label class="col-md-4 control-label" for="button_submit"></label>
                                          <div class="col-md-8">
                                            <button id="button_submit" name="button_submit" class="btn btn-success">Save</button>
                                            <button id="button_cancel" name="button_cancel" class="btn btn-danger">Cancel</button>
                                          </div>
                                        </div>
                                        </div>
                                        <div class="col-lg-6">

                                        <!-- Text input-->
                                        <div class="form-group">
                                          <label class="col-md-4 control-label" for="payment_type">Payment Type</label>
                                          <div class="col-md-4">
                                          <input id="payment_type" name="payment_type" placeholder="credit card, cash, eNets, mpayment etc" class="form-control input-md" required="" type="text" value="<?php echo $data['payment_type']; ?>">

                                          </div>
                                        </div>

                                        <!-- Text input-->
                                        <div class="form-group">
                                          <label class="col-md-4 control-label" for="date_received">Receive Date</label>
                                          <div class="col-md-4">
                                          <input id="date_received" name="date_received" placeholder="format : mm/dd/YYYY" class="form-control input-md datepicker" required="" type="text" value="<?php echo date("d/m/Y", strtotime($data['date_received'])); ?>" readonly="">

                                          </div>
                                        </div>

                                        <!-- Text input-->
                                        <div class="form-group">
                                          <label class="col-md-4 control-label" for="reference">Reference</label>
                                          <div class="col-md-4">
                                          <input id="reference" name="reference" placeholder="reference" class="form-control input-md" type="text" value="<?php echo $data['reference']; ?>">

                                          </div>
                                        </div>

                                         <!-- Text input-->
                                        <div class="form-group">
                                          <label class="col-md-4 control-label" for="trx_id">Transaction ID</label>
                                          <div class="col-md-4">
                                          <input id="trx_id" name="trx_id" placeholder="transaction id" class="form-control input-md" type="text" value="<?php echo $data['trx_id']; ?>">

                                          </div>
                                        </div>


                                        <!-- Text input-->
                                        <div class="form-group">
                                          <label class="col-md-4 control-label" for="remarks">Remarks</label>
                                          <div class="col-md-4">
                                          <input id="remarks" name="remarks" placeholder="remarks" class="form-control input-md"  type="text" value="<?php echo $data['remarks']; ?>">

                                          </div>
                                        </div>

                                        <!-- Select Basic -->
                                        <div class="form-group">
                                          <label class="col-md-4 control-label" for="salutation">Salutation</label>
                                          <div class="col-md-4">
                                            <select id="salutation" name="salutation" class="form-control">
                                            <?php $opt = '
                                              <option value="mr.">Mr.</option>
                                              <option value="ms.">Ms.</option>
                                              <option value="mrs.">Mrs</option>
                                              <option value="dr.">Dr.</option>
                                              <option value="prof.">Prof.</option>
                                              <option value="">None</option>';
                                                if(!isset($data['salutation'])) $data['salutation'] = '';
                                                $opt = str_replace('value="'.$data['salutation'].'"', 'value="'.$data['salutation'].'" selected="selected"',$opt);
                                                echo $opt;
                                              ?>
                                            </select>
                                          </div>
                                        </div>

                                        <!-- Text input-->
                                        <div class="form-group">
                                          <label class="col-md-4 control-label" for="name">Full Name</label>
                                          <div class="col-md-4">
                                          <input id="name" name="name" placeholder="Full name" class="form-control input-md"  type="text" value="<?php echo $data['name']; ?>">

                                          </div>
                                        </div>

                                        <!-- Select Basic -->
                                        <div class="form-group">
                                          <label class="col-md-4 control-label" for="id_type">ID Type</label>
                                          <div class="col-md-4">
                                            <select id="id_type" name="id_type" class="form-control">

                                              <?php $opt = '
                                              <option value="FIN">FIN</option>
                                              <option value="NRIC">NRIC</option>
                                              <option value="UEN">UEN</option>
                                              <option value="OTHERS">OTHERS</option>';
                                                if(!isset($data['id_type']) OR strlen($data['id_type']) < 2) $data['id_type'] = '-';
                                                $opt = str_replace('value="'.$data['id_type'].'"', 'value="'.$data['id_type'].'" selected="selected"',$opt);
                                                echo $opt;
                                              ?>
                                            </select>
                                          </div>
                                        </div>

                                        <!-- Text input-->
                                        <div class="form-group">
                                          <label class="col-md-4 control-label" for="id_no">ID Number</label>
                                          <div class="col-md-4">
                                          <input id="id_no" name="id_no" placeholder="id no." class="form-control input-md" type="text" value="<?php echo $data['id_no']; ?>">

                                          </div>
                                        </div>

                                        <!-- Text input-->
                                        <div class="form-group">
                                          <label class="col-md-4 control-label" for="email">Email Address</label>
                                          <div class="col-md-4">
                                          <input id="email" name="email" placeholder="name@domain.com" class="form-control input-md" type="text" value="<?php echo $data['email']; ?>">

                                          </div>
                                        </div>
                                        </div>
                                         <div class="col-lg-6">

                                        <!-- Textarea -->
                                        <div class="form-group">
                                          <label class="col-md-4 control-label" for="address">Address</label>
                                          <div class="col-md-4">
                                            <textarea class="form-control" id="address" name="address"><?php echo $data['address'];?></textarea>
                                          </div>
                                        </div>

                                        <!-- Text input-->
                                        <div class="form-group">
                                          <label class="col-md-4 control-label" for="postcode">Postcode</label>
                                          <div class="col-md-4">
                                          <input id="postcode" name="postcode" placeholder="postcode" class="form-control input-md" type="text" value="<?php echo $data['postcode']; ?>">

                                          </div>
                                        </div>

                                        <!-- Text input-->
                                        <div class="form-group">
                                          <label class="col-md-4 control-label" for="phone">Phone No.</label>
                                          <div class="col-md-4">
                                          <input id="phone" name="phone" placeholder="ex : 1112221" class="form-control input-md" type="text" value="<?php echo $data['phone']; ?>">

                                          </div>
                                        </div>

                                        <!-- Select Basic -->
                                        <div class="form-group">
                                          <label class="col-md-4 control-label" for="channel">Channel of Donation</label>
                                          <div class="col-md-4">
                                            <select id="channel" name="channel" class="form-control">

                                              <?php $opt = '
                                              <option value="BT Webiste">BT Webiste</option>
                                              <option value="Give Asia">Give Asia</option>
                                              <option value="SG Gives">SG Gives</option>';
                                                if(!isset($data['channel']) OR strlen($data['channel']) < 2) $data['channel'] = '-';
                                                $opt = str_replace('value="'.$data['channel'].'"', 'value="'.$data['channel'].'" selected="selected"',$opt);
                                                echo $opt;?>
                                            </select>
                                          </div>
                                        </div>

                                        <!-- Text input-->
                                        <div class="form-group">
                                          <label class="col-md-4 control-label" for="event_name">Event Name</label>
                                          <div class="col-md-4">
                                          <input id="event_name" name="event_name" placeholder="event name" class="form-control input-md" type="text" value="<?php echo $data['event_name']; ?>">

                                          </div>
                                        </div>

                                        <!-- Text input-->
                                        <div class="form-group">
                                          <label class="col-md-4 control-label" for="charity_name">Charity Name</label>
                                          <div class="col-md-4">
                                          <input id="charity_name" name="charity_name" placeholder="charity name" class="form-control input-md" type="text" value="<?php echo $data['charity_name']; ?>">

                                          </div>
                                        </div>

                                        <div class="form-group ">
                                          <label class="col-md-4 control-label" for="amount">Amount</label>
                                          <div class="col-md-4">
                                           <div class="input-group"> <span class="input-group-addon" id="basic-addon1">S$</span> <input id="amount" name="amount" placeholder="amount"  aria-describedby="basic-addon1"class="form-control input-md" type="text" value="<?php echo $data['amount']; ?>">
                                           </div>
                                          </div>
                                        </div>

                                        <div class="form-group ">
                                          <label class="col-md-4 control-label" for="tax_deductable">Tax Deductable</label>
                                          <div class="col-md-4">
                                           <input type="checkbox" value="Yes" name="tax_deductable" <?php if($data['tax_deductable'] == 'Yes'){
                                              echo 'checked=""';
                                            } ?>>
                                          </div>
                                        </div>
                                        </div>

                                        <input type="hidden" id="id" name="id" value="<?php echo $data['id']; ?>" />
                                        <input type="hidden" id="location" name="location" value="<?php echo $_SERVER['HTTP_REFERER'] ?>" />
                                        </fieldset>
                                        </form>
                                    <?php }

                                    else{
                                        echo 'ID not found';
                                    }
                                    ?>

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
    </div>
