<?php
session_start();
error_reporting(E_ALL);
/* No Direct Access */

if(empty($_POST['referral_token']) || ($_POST['referral_token'] != $_SESSION['referral_token'])) {
    header("Location: index.php");
    die("");
}

if(empty($_POST['referral_token'])) {
    header("Location: index.php");
    die();
}

//Reset Token Session
$donation_token = uniqid();
$_SESSION['referral_token'] = $referral_token;

//header('Content-Type: application/json');
require_once "library/config.php";
require_once "library/gump.class.php";
require_once 'library/FunctionLib.php';
?>

<!doctype html>
<html lang="en-US">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no" />
        <title>Interaktiv Donation - Result</title>

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

<?php    
$response_state = "danger";
$response_message = "Error while creating account.";
$form = $_POST;
$edr = explode('/',$form['Earliest_Date_of_Release_EDR__c']);
$form['Earliest_Date_of_Release_EDR__c'] = $edr['2'].'-'.$edr[1].'-'.$edr[0];
$dob = explode('/',$form['Date_of_birth__c']);
$form['Date_of_birth__c'] = $dob['2'].'-'.$dob[1].'-'.$dob[0];
$keys = array_keys($form);

    $records = array();
    $records[0] = new stdclass();
    foreach($keys as $key){
        if($key != 'referral_token'){
            if(strlen($form[$key]) > 0){
                $records[0]->$key = $form[$key];
            }
        }
    }    
    $records[0]->Number_of_Years_in_Prison__c = '1.00';
try {
    $createReferral = $mySforceConnection->upsert('Id', $records, 'Admission_Orientation__c');
    print_r($createReferral);
    if($createReferral[0]->success == 1)
    {
        $response_state = "success";
        $response_message = "Your record successfully saved.";
    }
    else{
        $response_state = "danger";
        $response_message = "Error while creating account.";
    }
} catch (Exception $e) {
    die($e->faultstring);
}


    
?>

        <div class="container">

            <div class="card card-container">

                <br />
                <div class="alert alert-<?=$response_state?>">
                    <center><strong><?=$response_message?></strong></center>
                </div>
                <button class="btn btn-lg btn-primary btn-block btn-signin" type="button" onclick="window.location.replace('index.php')">Return to homepage</button>

            </div><!-- /card-container -->
        </div><!-- /container -->
        <!-- Required - jQuery -->
        <script src="js/jquery-2.1.1.min.js"></script>
        <!-- Required - Bootstrap JS -->
        <script src="js/bootstrap.min.js"></script>



    </body>
</html>
