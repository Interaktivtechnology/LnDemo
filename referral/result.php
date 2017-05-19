<?php
/* No Direct Access */
session_start();
if($_SERVER['REQUEST_METHOD'] !== 'POST') {
    //header("Location: index.php");
    //die("No direct access !");
}
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
    <title>Breast Cancer Foundation Donation - Result</title>

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
    $response_message = "Thank you, we have recieved your donation data";
    $verify = responseFgkey(MCP_KEY, $_POST['mid'], $_POST['ref'], $_POST['cur'], $_POST['amt'], $_POST['rescode'], $_POST['transid']);
    $nano = 0;
    //Check Response
    if($verify == $_POST['fgkey']) {
        //Payment success
        if($_POST['rescode'] == "0000" || $_POST['rescode'] == "200") {
            $response_state = "success";
            $nano = 1;
            $response_message = 'Thank you for your kind donation. A tax receipt has been sent to your email '.$_SESSION['email'].' for your reference. In the mean time please click the links below if you want to sign up as a member or volunteer';
            $url = REGISTRATION_URL;
            if (strpos($url, '?') !== false) {
                $url .= '&name='.$_SESSION['name'].'&email='.$_SESSION['email'].'&id_no='.$_SESSION['id_no'].''; 
            }
            else{
                $url .= '?name='.$_SESSION['name'].'&email='.$_SESSION['email'].'&id_no='.$_SESSION['id_no'].'';
            }
            if(isset($_SESSION['phone'])){
                $url .= '&phone='.$_SESSION['phone'].'';
            }
            define("REGISTRATION_URL", $url);

        //Payment Error
        } else {
            $response_state = "warning";
            $response_message .= "<br>Unfortunately due to payment gateway error your payment is not completed. One of our team members will get in touch with you.";
        }
    //Response Error
    } else {
        $response_state = "danger";
        $response_message = "We're unable to validate your data.";
    }
    ?>

    <div class="container">

        <div class="card card-container" style="width:350px">

            <br />
            <div class="alert alert-<?=$response_state?>">
                <center><strong><?=$response_message?><br></strong></center>
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