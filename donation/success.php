<?php
session_start();
error_reporting(0);
require_once "library/config.php";
require_once "library/gump.class.php";
require_once 'library/FunctionLib.php';

//Get payment information from PayPal
$item_number = $_GET['item_number']; 
$txn_id = $_GET['tx'];
$payment_gross = $_GET['amt'];
$currency_code = $_GET['cc'];
$payment_status = $_GET['st'];
$response_state = '';
//Get product price from database


if(!empty($txn_id) && $payment_gross == $_SESSION['amount']){
    //need to update Salesforce data using TXN ID.
    $response_state = 'success';
    $message = 'Your payment has been successful.';
    }
    else{
        $response_state = 'danger';
        $message = 'Your payment has failed.';
    }
?>

<!doctype html>
<html lang="en-US">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no" />
    <title>InterAktiv Donation - Result</title>

    <!-- Optional - Google font -->
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Gafata" />

    <!-- Required - Icon font -->
    <link rel="stylesheet" href="css/font-awesome.min.css" />

    <!-- Required - Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />

    <!-- Required - Form style -->
    <link rel="stylesheet" href="css/flat-form.css" />

    <link rel="stylesheet" href="css/page-style.css" />
    <link rel="stylesheet" type="text/css" href="css/jquery-ui-1.10.3.flat.css">
    <link rel="stylesheet" type="text/css" href="css/login.css">


</head>

<body>


    <div class="container">

        <div class="card card-container" style="width:350px">

            <br />
            <div class="alert alert-<?=$response_state?>">
                <center><strong><?=$message?><br></strong></center>
            </div>
            <?php
            if($nano == 1){
                print '<button class="btn btn-lg btn-primary btn-block btn-signin" type="button" onclick="window.location.replace(\''.$url.'\')">Click here</button>';
            }
            else{
                if($response_state == "danger") {
                    print '<button class="btn btn-lg btn-primary btn-block btn-signin" type="button" onclick="window.location.replace(\'index.php\')">Back</button>';
                } else {
                    print '<button class="btn btn-lg btn-primary btn-block btn-signin" type="button" onclick="window.location.replace(\'index.php\')">Return to homepage</button>';
                }
            }
            ?>
        </div><!-- /card-container -->
    </div><!-- /container -->
    <!-- Required - jQuery -->
    <script src="js/jquery-2.1.1.min.js"></script>
    <!-- Required - Bootstrap JS -->
    <script src="js/bootstrap.min.js"></script>
</body>
</html>