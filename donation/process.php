<?php
session_start();
error_reporting(0);
/* No Direct Access */
if(empty($_POST['donation_token']) || ($_POST['donation_token'] != $_SESSION['donation_token'])) {
    header("Location: index.php");
    die("");
}
/* Prevent double post */
if(empty($_POST['donation_token'])) {
    header("Location: index.php");
    die();
}
//Reset Token Session
$donation_token = uniqid();
$_SESSION['donation_token'] = $donation_token;

//header('Content-Type: application/json');
require_once "library/config.php";
require_once "library/gump.class.php";
require_once "library/CreditCard.php";
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
$form = $_POST;
$cardType = "";
$ccnumber = $form['cc_num'];
$ccexp = str_replace('/','',$form['cardExpiry']);
$ccexp = explode('/',$form['cardExpiry']);
$ccexp = $ccexp[0].($ccexp[1]-2000);
$_SESSION['amount'] = $form['amount'];
function cardType($number)
{
    $number=preg_replace('/[^\d]/','',$number);
    /*
    if (preg_match('/^3[47][0-9]{13}$/',$number))
    {
        return 'American Express';
    }
    elseif (preg_match('/^3(?:0[0-5]|[68][0-9])[0-9]{11}$/',$number))
    {
        return 'Diners Club';
    }
    elseif (preg_match('/^6(?:011|5[0-9][0-9])[0-9]{12}$/',$number))
    {
        return 'Discover';
    }
    elseif (preg_match('/^(?:2131|1800|35\d{3})\d{11}$/',$number))
    {
        return 'JCB';
    }
    */
    if (preg_match('/^5[1-5][0-9]{14}$/',$number))
    {
        return 'MasterCard';
    }
    elseif (preg_match('/^4[0-9]{12}(?:[0-9]{3})?$/',$number))
    {
        return 'Visa';
    }
    else
    {
        return '';
    }
}

if (isset($_POST)) {
    $mode = "new"; //Set default mode
    if((isset($form['id_no']) AND strlen($form['id_no']) > 3)){
    $userAccount = checkId($form['id_no']);
    }
    else{
        if((isset($form['email']) AND strlen($form['email']) > 3)){
            $userAccount = checkEmail($form['email']);
        }
    }
    if(!isset($userAccount)) {
        //Donor RecordType ID
        try {
            $query = "SELECT Id, Name, SObjectType from recordtype WHERE SObjectType IN ('Account', 'Contact')";
            $data = $mySforceConnection->query(($query));
        } catch (Exception $e) {
            die($e->faultstring);
        }

        if(is_array($data->records)){
            foreach($data as $record){
                if($record->Name == 'Individual Donors'){
                    $rectypeAcc = $record->Id;
                }
                if($record->Name == 'Individual Donor'){
                    $rectypeCon = $record->Id;
                }
            }
        }
        $records = array();
        $records[0] = new stdclass();
        $records[0]->Name = ucwords(strtolower($form['name']));
        $records[0]->RecordTypeId = $rectypeAcc;
        $records[0]->ID_No__c = strtoupper($form['id_no']);
        $records[0]->ID_Type__c = $form['id_type'];
        $records[0]->Donor__c = 'true';
        $records[0]->Email__c = $form['email'];
        $records[0]->Phone = $form['phone'];
        $records[0]->BILLINGSTREET = $form['street'];
        $records[0]->BILLINGCITY = $form['city'];
        $records[0]->BILLINGSTATE = $form['city'];
        $records[0]->BILLINGCOUNTRY = 'Singapore';
        $records[0]->BILLINGPOSTALCODE = $form['postcode'];
        //$records[0]->Donor_Status__c = "Active";
        $records[0]->Type_of_Donor__c = "New Donor";
        $records[0]->Donation_form__c = 'true';
        

    } else {
        $mode = "update";
        $records = array();
        $records[0] = new stdclass();
        $records[0]->Id = $userAccount;
        //$records[0]->Donor_Status__c = "Active";
        //$records[0]->Type_of_Donor__c = "Repeat Donor";
        $records[0]->Donor__c = 'true';
    }

    if(isset($form['phone'])){
        $records[0]->Phone = $form['phone'];
    }

    try {
        $createAccount = $mySforceConnection->upsert('Id', $records, 'Account');
        $accid = $createAccount[0]->id;
    } catch (Exception $e) {
        die($e->faultstring);
    }

    //If Insert/Update Account success
    if($createAccount[0]->success) {
        $_SESSION['email'] = $form['email'];
        $_SESSION['name'] = $form['name'];
        if(isset($form['phone'])){
            $_SESSION['phone'] = $form['phone'];
        }
        
        $_SESSION['id_no'] = $form['id_no'];
        if($mode == "new") {
            $contact = array();
            $contact[0] = new stdclass();
            $contact[0]->Lastname = ucwords(strtolower($form['name']));
            $contact[0]->Accountid = $accid;
            $contact[0]->ID_No__c = strtoupper($form['id_no']);
            $contact[0]->RecordTypeId = $rectypeCon;
            $contact[0]->MAILINGCOUNTRY = 'Singapore';
            $contact[0]->EMAIL = $form['email'];
            $records[0]->Donor__c = 'true';
            
            if(isset($form['phone'])){
                $records[0]->Phone = $form['phone'];
            }

            try {
                $createContact = $mySforceConnection->upsert('Id', $contact, 'Contact');
                $contactId = $createContact[0]->id;
            } catch (Exception $e) {
                die($e->faultstring);
            }

        } else {
            if(isset($form['phone'])){
                $records[0]->Phone = $form['phone'];
            }
            try {
                $query = "SELECT Id FROM Contact WHERE Accountid = '$userAccount'";
                $data = $mySforceConnection->query(($query));
                $contactId = $data->records[0]->Id;
            } catch (Exception $e) {
                die($e->faultstring);
            }
        }
        
        //Create Donation
        try {
            $query = "SELECT Id, Name, SObjectType from recordtype WHERE SObjectType = 'Donation__c'";
            $data = $mySforceConnection->query(($query));
        } catch (Exception $e) {
            die($e->faultstring);
        }

        if(is_array($data->records)){
            foreach($data as $record){
                if($record->Name == 'Cash'){
                    $rectypeDonation = $record->Id;
                }
            }
        }
        $donation = array();
        $donation[0] = new stdclass();
        $donation[0]->RecordTypeId = $rectypeDonation;
        $donation[0]->ID_Type__c = $form['id_type'];
        //$donation[0]->ID_No__c = $form['id_no'];
        $donation[0]->Donor_Name__c = $accid;
        $donation[0]->Contact_Name__c = $contactId;
        $donation[0]->Donation_Date__c = date("Y-m-d", time());
        $donation[0]->Channel_of_Donation__c = "Web Site";
        $donation[0]->Donation_Status__c = "Received";
        $donation[0]->Amount__c = $form['amount'];
        $donation[0]->Payment_Method__c = "Credit Card";
        $donation[0]->Campaign_Name__c = $form['Campaign_Name__c'];
        $donation[0]->Donation_Purpose__c = $form['Donation_Purpose__c'];
        $donation[0]->Cleared_Date__c = date("Y-m-d", time());
        if(isset($form['channel']) AND strlen($form['channel']) > 3){
            $donation[0]->Channel_of_Donation__c = $form['channel'];
        }
        else{
            $donation[0]->Channel_of_Donation__c = "Web Site";
        }
        if(isset($form['leadsource']) AND strlen($form['leadsource']) > 3){
            $donation[0]->LeadSource__c = $form['leadsource'];
        }
        
        try {
            $createDonation = $mySforceConnection->upsert('Id', $donation, 'Donation__c');
        } catch (Exception $e) {
            die($e->faultstring);
        }
        if($createDonation[0]->success) {
            
            $response_state = "success";
            $response_message = "Please wait while redirecting to payment gateway";
            if($form['payment_method'] != 'paypal'){
                //MCP payment - create form post data to MCP
                $fgkey = generateFgkey(MCP_KEY, MCP_MID, $createDonation[0]->id, MCP_CURRENCY, $form['amount']);
                $dform = '<form action="'.MCP_URL.'" method="post" name="donation" id="donation">';
                $dform .= '<input type="hidden" name="mid" value="'.MCP_MID.'">';
                $dform .= '<input type="hidden" name="txntype" value="SALE">';
                $dform .= '<input type="hidden" name="reference" value="'.$createDonation[0]->id.'">';
                $dform .= '<input type="hidden" name="cur" value="'.MCP_CURRENCY.'">';
                $dform .= '<input type="hidden" name="amt" value="'.$form['amount'].'">';
                $dform .= '<input type="hidden" name="shop" value="Interaktiv Foundation">';
                $dform .= '<input type="hidden" name="buyer" value="'.$form['name'].'">';
                $dform .= '<input type="hidden" name="email" value="'.$form['email'].'">';
                $dform .= '<input type="hidden" name="tel" value="63526560">';
                $dform .= '<input type="hidden" name="product" value="Donation">';
                $dform .= '<input type="hidden" name="lang" value="EN">';
                $dform .= '<input type="hidden" name="statusurl" value="'.STATUS_URL.'">';
                $dform .= '<input type="hidden" name="returnurl" value="'.RETURN_URL.'">';
                $dform .= '<input type="hidden" name="fgkey" value="'.$fgkey.'">';
                $dform .= '</form>';
                $js = '<script type="text/javascript">document.donation.submit();</script>';
            }
            else{
                
            $dform = '<form action="'.PAYPAL_URL.'" method="post" name="donation" id="donation">';
            $dform .= '<input type="hidden" name="business" value="'.PAYPAL_SELLER_EMAIL.'">';
            $dform .= '<input type="hidden" name="cmd" value="_xclick">';
            $dform .= '<input type="hidden" name="item_name" value="InterAktiv Donation>">';
            $dform .= '<input type="hidden" name="item_number" value="'.$createDonation[0]->id.'">';
            $dform .= '<input type="hidden" name="amount" value="'.$form['amount'].'">';
            $dform .= '<input type="hidden" name="currency_code" value="SGD">';
            $dform .= '<input type="hidden" name="cancel_return" value="http://'.$_SERVER['HTTP_HOST'].'">';
            $dform .= '<input type="hidden" name="cancel_return" value="http://'.$_SERVER['HTTP_HOST'].'/success.php">';
            $dform .= '</form>';
            $js = '<script type="text/javascript">document.donation.submit();</script>';
            }
            
        } else {
            $response_state = "danger";
            $response_message = "Unable to create donation record.";
        }
        //$response = array('success' => $createDonation[0]->success, 'message' => $createDonation[0]);
        //echo json_encode($response);
    } else {
        $response_state = "danger";
        $response_message = "Error while creating account.";
        //http_response_code(500);
        //$response = array('success' => false, 'message' => $createAccount[0]);
        //echo json_encode($response);
    }
    
//Form Error
} else {
    $response_state = "danger";
    $response_message = "Input Was Not Valid.";
    //$response = array('success' => false, 'message' => 'Input Was Not Valid');
    //http_response_code(500);
    //echo json_encode($gump->get_errors_array());
    //echo json_encode($response);
}

?>

        <div class="container">

            <div class="card card-container">

                <br />
                <div class="alert alert-<?=$response_state?>">
                    <center><strong><?=$response_message?><br></strong></center>
                    <?=$dform?>
                    <ul>
                    <?php
                    foreach ($form_message as $key => $value) {
                        echo "<li>".$value."</li>";
                    }
                    ?>
                    </ul>
                </div>
                <?php
                if($response_state == "danger") {
                    print '<button class="btn btn-lg btn-primary btn-block btn-signin" type="button" onclick="window.location.replace(\'index.php\')">Back</button>';
                } else {
                    print '<button class="btn btn-lg btn-primary btn-block btn-signin" type="button" onclick="window.location.replace(\'index.php\')">Return to homepage</button>';
                }
                ?>
            </div><!-- /card-container -->
        </div><!-- /container -->
        <!-- Required - jQuery -->
        <script src="js/jquery-2.1.1.min.js"></script>
        <!-- Required - Bootstrap JS -->
        <script src="js/bootstrap.min.js"></script>
        <?=$js?>


    </body>
</html>
