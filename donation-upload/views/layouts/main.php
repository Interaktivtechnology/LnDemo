<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap\Dropdown;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>InterAktiv Foundation - Donation Verification</title>

    <link href="<?php echo Url::to('@web/'); ?>css/datepicker.css" rel="stylesheet">
    <link rel="icon" href="<?php echo Url::to("@web/")?>static/images/logo.png" type="image/png" />
    <?php $this->head() ?>
</head>

<body>
<?php $this->beginBody() ?>

<div id="wrapper" class="wrapper container">
<div class="row">
    <div class="col-md-12">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0;height:100px">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php  echo Url::to('@web/');?>"><img src="<?php  echo Url::to('@web/');?>static/images/logo.png" height="50px"/></a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                <ul class="nav navbar-nav navbar-top-links" id="mainNav">
                <?php echo "<li>".Html::a("<i class='fa fa-cloud'></i>".' Importation Page', ['donation/import'])."</li>";?>
                <?php //echo "<li>".Html::a("<i class='fa fa-send-o'></i>".' Migration', ['migration/index'])."</li>";?>
                  <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class='fa fa-database'></i> Temporary Data<span class="caret"></span></a>
                      <ul class="dropdown-menu" >
                        <?php
                            echo "<li>".Html::a('Temporary Data - All', ['donation/index'], ['','class' => 'active']).'</li>';
                            echo "<li>".Html::a('Temporary Data - Give Asia', ['donation/index', 'DonationTemp[channel]' => "Give Asia"], ['class' => 'active']).'</li>';
                            echo "<li>".Html::a('Temporary Data - Simply Giving', ['donation/index', 'DonationTemp[channel]' => "Simply Giving"] , ['class' => 'active']).'</li>';
                            echo "<li>".Html::a('Temporary Data - Giving Sg', ['donation/index', 'DonationTemp[channel]' => "Giving Sg"] , ['class' => 'active']).'</li>';
                        ?>

                      </ul>

                  </li>
                  <li><?php echo Html::a("<i class='fa fa-sign-out'></i>".' Logout', ['site/logout']) ?></li>
                </ul>
                 <!-- /.navbar-header -->

                <div class="clearfix"></div>
            </div>

        </nav>


    <?php echo $content?>
    <!-- /#wrapper -->
    <div class="modal" id="modalLog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">Upload Log</h4>
          </div>
          <div class="modal-body">
            <?php $isJson = Yii::$app->session->getFlash('json');
            if($isJson):
            ?>
            <textarea class="form-control" rows="30" readonly="readonly"><?php echo Yii::$app->session->getFlash('log'); ?></textarea>
          <?php else:
            $log =  Yii::$app->session->getFlash('log');
            if(is_array($log)):
              foreach($log as $each):
                if(isset($each['_row'])):
                  echo 'Row = '.$each['_row'].' <br />';
                  echo $each['message'];
                  echo "<hr />";
                else:
                  print_r($each);echo '<br />';
                endif;
              endforeach;
            endif;

          ?>
          <?php endif;?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default btn-close" data-dismiss="modal">Close</button>
            <a href="<?php echo Url::to(['donation/index'])?>"><button type="button" class="btn btn-primary btn-date">View Data</button></a>
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
</div>
</div>
</div>


<?php $this->endBody() ?>
<!-- Custom Theme JavaScript -->
<script src="<?php echo Url::to('@web/'); ?>js/bootstrap-datepicker.js"></script>


<script type="text/javascript">
    var BASEURL = '<?php echo Yii::getAlias('@web')?>';
    $(document).ready(function(){
      $('.datepicker').datepicker({
        format: 'mm/dd/yyyy'
      })

      $('#mainNav li a').each(function(){
        console.log(BASEURL);
        if($(this).attr('href') == window.location.href){
            $(this).parent().addClass('active');
            console.log($(this));
        }

      });
    })
    </script>
</body>




</html>
<?php $this->endPage() ?>
