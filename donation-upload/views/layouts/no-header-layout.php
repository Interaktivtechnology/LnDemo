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

<?php echo $content?>
<?php $this->endBody() ?>
<!-- Custom Theme JavaScript -->
<script src="<?php echo Url::to('@web/'); ?>js/bootstrap-datepicker.js"></script>


<script type="text/javascript">
    $(document).ready(function(){
      $('.datepicker').datepicker({
        format: 'mm/dd/yyyy'
      })

      $('#mainNav li a').each(function(){
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
