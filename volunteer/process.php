<?php
error_reporting(E_ALL);
session_start();
include 'sf.php';
ob_start();
if(isset($_SESSION['error_message'])){
    unset($_SESSION['error_message']);

}

function checkEmail($email){
    global $mySforceConnection;
    try{
        $query = "select id from Account where Email__c = '$email' LIMIT 1";
        $data = $mySforceConnection->query(($query));
        if(isset($data->records[0]->Id)){
            return 'duplicate';
        }
        else{
            return 'available';
        }
    } catch (Exception $e) {
        return 'error';
    }
}
function checkIdno($idno){
    global $mySforceConnection;
    try{
        $query = "select id from Account where ID_NO__C = '$idno' LIMIT 1";
        $data = $mySforceConnection->query(($query));
        if(isset($data->records[0]->Id)){
            return 'duplicate';
        }
        else{
            return 'available';
        }
    } catch (Exception $e) {
        return 'error';
    }
}

if (empty($_POST["form-email"])) {
    $error_message[] = "Email is required";
  } else {
    $cekemail = checkEmail($_POST["form-email"]);
    if($cekemail == 'available'){
        // check if e-mail address is well-formed
        if (!filter_var($_POST["form-email"], FILTER_VALIDATE_EMAIL)) {
          $error_message[] = "Invalid email format";
        }
    }
    else{
        //$error_message[] = "Email address already in use";
    }
  }

if (empty($_POST["form-nric"])) {
    $error_message[] = "Id No is required";
}

if (empty($_POST["form-id-type"])) {
    $error_message[] = "Id Type is required";
}


if (empty($_POST["form-first-name"])) {
    $error_message[] = "Name is required";
}

if (empty($_POST["form-gender"])) {
    //$error_message[] = "Gender is required";
     $_POST["form-gender"] = 'Male'; 
}



if (empty($_POST["form-postal-code"])) {
    $_POST["form-postal-code"] = '00000';
    //$error_message[] = "Postcode is required";
}

if (empty($_POST["form-birth-year"])) {
    //$_POST["form-birth-year"] = '1901';
}

if (empty($_POST["Race__c"])) {
    //$error_message[] = "Race option is required";
}

if (empty($_POST["form-about-address"])) {
   // $error_message[] = "Address is required";
}


if (empty($_POST["agree"])) {
    $error_message[] = "Agreement is need to be checked";
}
$idno = $_POST['form-nric'];
$email = $_POST['form-email'];
$is_member = 0;
$is_volunteer = 0;
$query = "SELECT Id, Email, ID_NO__C , Volunteer_Status__c, Membership_Application_date__c FROM Contact WHERE ID_NO__C = '$idno' OR Email  = '$email' LIMIT 1";
$contact = $mySforceConnection->query(($query));
if(isset($contact->records[0]->Membership_Application_date__c)){
    $is_member = '1';
    if($_POST["inputvolunteer"] != '1'){
        $error_message[] = "Already joined as a member";
    }
}
if(isset($contact->records[0]->Volunteer_Status__c)){
    $is_volunteer = '1';
    $error_message[] = "You may already be a member / volunteer in our system, Please contact Interaktiv for assistance";
}

if(!isset($error_message[0])){

    try{
        $query = "select id, name, SObjectType from recordtype where SObjectType IN ('Account', 'Contact')";
        $data = $mySforceConnection->query(($query));
    } catch (Exception $e) {
        die($e->faultstring);
    }

    if(is_array($data->records)){
        foreach($data->records as $record){
            if($record->Name == 'Individual Donors' && $record->SobjectType == 'Account'){
                $rectypeAcc = $record->Id;
            }
            if($record->Name == 'Individual Donor' && $record->SobjectType == 'Contact'){
                $rectypeCon = $record->Id;
            }
        }
    }
            
    
    //test global

    $idno = $_POST['form-nric'];
    $name = $_POST['form-first-name'];
    if(isset($_POST['form-last-name'])){
        $name .= ' '.$_POST['form-last-name'];
    }
    
    if($_POST['form-gender'] == 'Male'){
    $salutation = 'Mr.';
    }
    else{
        $salutation = 'Ms.';
    }
    $street = $_POST['form-about-address'];
    
    if(!isset($_POST['form-postal-code'])){
        $_POST['form-postal-code'] = '00000';
    }
    $idtype = $_POST["form-id-type"];
    $city = 'singapore';
    $country = 'Singapore';
    $gender = $_POST['form-gender'];
    $date = $_POST['form-birth-year'].'-01-01';
    $email = $_POST['form-email'];
    $postcode = $_POST['form-postal-code'];
    $year = $_POST['form-birth-year'];
    $pref = $_POST['form-preferred-name'];
    $cat = $_POST['form-category'];
    
    if(isset($_POST['diag'])){
        $diag = 'been diagnosed with Breast Cancer';
    }

    $mode = 'new';

    $query = "SELECT Id, ID_NO__C, Email__c FROM Account WHERE ID_NO__C = '$idno' OR Email__c  = '$email' LIMIT 1";
    $account = $mySforceConnection->query(($query));
    if(isset($account->records[0]->Id)){
        $idx = $account->records[0]->Id;
        $mode = 'update';
        if($is_member == 0){
            $mode = 'new';
        }
    }
    echo $mode;
    if($mode == 'new'){
        if(isset($rectypeAcc)){

            $records = array();
            $records[0] = new stdclass();
            $records[0]->Name = ucwords(strtolower($name));
            $records[0]->RecordTypeId = $rectypeAcc;
            $records[0]->Email__c = $email;
            $records[0]->ID_NO__C = $idno;
            $records[0]->ID_TYPE__C = $idtype;
            $records[0]->BILLINGSTREET = $street;
            $records[0]->Donation_Form__c = 'TRUE';
            if(isset($pref) AND strlen($pref) > 1){
                $records[0]->Preferred_Name__c = ucwords(strtolower($pref));
            }
            if(isset($_POST['form-birth-year'])){
                $datebirth = explode('/', $_POST['form-birth-year']);
                $date1 = $datebirth[2].'-'.$datebirth[1].'-'.$datebirth[0];
                $records[0]->Year_of_Birth__c = $datebirth[2];
                $records[0]->Date_of_Birth__c = $date1;
            }
            $records[0]->GENDER__C = $gender;
            $records[0]->Email__c = $email;
            $records[0]->Postal_Code__c = $postcode;
            if(isset($idx)){
                $records[0]->Id = $idx;
            }
        

            /*
            if(is_array($_POST['interest'])){
                $interest = implode(';', $_POST['interest']);
                $request .= 'VOLUNTEER AREA OF INTERESTS : '.$interest."\n";
            }
            */
            try {
                $response = $mySforceConnection->upsert('Id', $records, 'Account');
            } catch (Exception $e) {
                die($e->faultstring);

            }
        }

        if(isset($response[0]->success) AND $response[0]->success == '1' ){
            $accid = $response[0]->id;

        }
        if(isset($response[0]->errors)){
        
        }
        unset($response);
    }else{
        $note = array();

        if(isset($name)){
            $request .= 'Name : '.ucwords(strtolower($name))."\n";
        }

        if(isset($idno)){
            $request .= 'ID No : '.$idno."\n";
        }

        if(isset($idtype)){
            $request .= 'ID Type : '.$idtype."\n";
        }

        if(isset($street)){
            $request .= 'BILLINGSTREET : '.$street."\n";
        }

        if(isset($_POST['form-birth-year'])){
            $datebirth = explode('/', $_POST['form-birth-year']);
            $date1 = $datebirth[2].'-'.$datebirth[1].'-'.$datebirth[0];
            $request .= 'Year of Birth : '.$datebirth[2]."\n";
            $request .= 'Date of Birth : '.$date1."\n";
        }

        if(isset($gender)){
            $request .= 'GENDER : '.$gender."\n";
        }

        if(isset($email)){
            $request .= 'EMAIL : '.$email."\n";
        }

        if(isset($postcode)){
            $request .= 'Postal Code : '.$postcode."\n";
        }

        $note[0]->Title = 'Request Account Data Change';
        $note[0]->Body = $request;
        $note[0]->ParentId = $idx;
        try {
            $response = $mySforceConnection->upsert('Id', $note, 'Note');
        } catch (Exception $e) {
            die($e->faultstring);
        }
        $accid = $idx;
    }

    $mode = 'new';

    $query = "SELECT Id, Email, ID_NO__C FROM Contact WHERE ID_NO__C = '$idno' OR Email  = '$email' LIMIT 1";
    $contact = $mySforceConnection->query(($query));
    if(isset($contact->records[0]->Id)){
        $idc = $contact->records[0]->Id;
        $mode = 'update';
        if($is_member == 0){
            $mode = 'new';
        }

    }

    if($mode == 'new'){
        if(isset($accid) && isset($rectypeCon)){
            
                $contact = array();
                $contact[0] = new stdclass();
                if(isset($idc)){
                    $contact[0]->Id = $idc;
                }
                $contact[0]->Lastname = ucwords(strtolower($name));
                $contact[0]->Salutation = $salutation;
                $contact[0]->Accountid = $accid;
                $contact[0]->ID_No__c = $idno;
                $contact[0]->RecordTypeId = $rectypeCon;
                $contact[0]->ID_Type__c = $idtype;
                $contact[0]->EMAIL = $email;
                //$contact[0]->Email__c = $email;
                if($_POST['diag'] == 'diag'){
                    $contact[0]->I_have__c = 'been diagnosed with Breast Cancer';
                }

                if(isset($pref) AND strlen($pref) > 1){
                    $contact[0]->Preferred_Name__c = ucwords(strtolower($pref));
                }

                if($_POST['form-diag-when']){
                    //$contact[0]->Completed_Treatment__c = $_POST['form-diag-when'];
                }

                if(isset($_POST['form-birth-year'])){
                    $datebirth = explode('/', $_POST['form-birth-year']);
                    $date1 = $datebirth[2].'-'.$datebirth[1].'-'.$datebirth[0];
                    $contact[0]->Year_of_Birth__c = $datebirth[2];
                    $contact[0]->Date_of_Birth__c = $date1;
                }

                if($_POST['form-phone']){
                    $contact[0]->Phone = $_POST['form-phone'];
                }

                if($_POST['form-gender']){
                    $contact[0]->Gender__c = $_POST['form-gender'];
                }
                
                if(isset($diag)){
                    $contact[0]->I_have__c = $diag;
                }
                if(isset($_POST['form-diag-when'])){
                    //$contact[0]->Completed_Treatment__c = $_POST['form-diag-when'];
                }  

                if(isset($_POST['form-have-role'])){
                    $contact[0]->Previous_Volunteer_Role__c = $_POST['form-have-role'];
                } 

                if(isset($_POST['form-have-period'])){
                    $contact[0]->Previous_Volunteer_Period__c = $_POST['form-have-period'];
                }

                if(isset($_POST['agree']) AND $_POST['agree'] == 'agree'){
                    $contact[0]->PDPA_Signed__c = TRUE;
                }

                if(isset($_POST['form-org-name'])){
                    $contact[0]->Other_Organization_Volunteered__c = $_POST['form-org-name'];
                }

                if(isset($_POST['form-org-role'])){
                    $contact[0]->Other_Organization_Volunteered_Role__c = $_POST['form-org-role'];
                }

                if(isset($_POST['form-org-period'])){
                    $contact[0]->Other_Organization_Volunteered_Period__c = $_POST['form-org-period'];
                } 

                if(isset($_POST['form-qualities'])){
                    $contact[0]->Volunteer_Skill__c = $_POST['form-qualities'];
                }

                /*
                if(isset($_POST['inputvolunteer']) && $_POST['inputvolunteer'] == '1'){
                    $contact[0]->Volunteer_Application_Date__c = date('Y-m-d');
                    $contact[0]->Volunteer_Status__c = 'Prospect';
                } 
                */
                $contact[0]->Volunteer_Application_Date__c = date('Y-m-d');
                $contact[0]->Volunteer_Status__c = 'Prospect';

                if(isset($_POST['inputmember']) && $_POST['inputmember'] == '1' ){
                    $contact[0]->Membership_Application_date__c = date('Y-m-d');
                } 

                if(isset($_POST['form-phone'])){
                    $contact[0]->Phone = $_POST['form-phone'];
                }

                if(isset($_POST['vsource']) AND strlen($_POST['vsource']) > 2){
                    $contact[0]->Vsource__c = rawurldecode($_POST['vsource']);
                }
                else{
                    $contact[0]->Vsource__c = 'Web Site';
                }

                if(isset($_POST['msource']) AND strlen($_POST['msource']) > 2){
                    //$contact[0]->Msource__c = rawurldecode($_POST['msource']);
                }
                else{
                    //$contact[0]->Msource__c = 'Web Site';
                }

                if(isset($_POST['form-via']) AND strlen($_POST['form-via']) > 2){
                    $contact[0]->How_I_know_Interaktiv_Membership__c = rawurldecode($_POST['form-via']);
                }

                if(isset($_POST['form-category']) AND strlen($_POST['form-category']) > 2){
                    //$contact[0]->Membership_Category__c = rawurldecode($_POST['form-category']);
                }
                //
                
                try {
                $response = $mySforceConnection->upsert('Id', $contact, 'Contact');
                } catch (Exception $e) {
                    die($e->faultstring);
                }
        }


        if(isset($response[0]->errors)){
      
        }
        if(isset($response[0]->success) AND $response[0]->success == '1' ){
            

        }
    }
    else{
        $note = array();

        $request = '';

        if(isset($name)){
            $request .= 'Name : '.ucwords(strtolower($name))."\n";
        }

        if(isset($idno)){
            $request .= 'ID No : '.$idno."\n";
        }

        if(isset($idtype)){
            $request .= 'ID Type : '.$idtype."\n";
        }

        if(isset($street)){
            $request .= 'BILLINGSTREET : '.$street."\n";
        }

        if(isset($_POST['form-birth-year'])){
            $datebirth = explode('/', $_POST['form-birth-year']);
            $date1 = $datebirth[2].'-'.$datebirth[1].'-'.$datebirth[0];
            $request .= 'Year of Birth : '.$datebirth[2]."\n";
            $request .= 'Date of Birth : '.$date1."\n";
        }

        if(isset($gender)){
            $request .= 'GENDER : '.$gender."\n";
        }

        if(isset($email)){
            $request .= 'EMAIL : '.$email."\n";
        }

        if(isset($postcode)){
            $request .= 'Postal Code : '.$postcode."\n";
        }

        if($_POST['diag'] == 'diag'){
            $request .= 'I Have : been diagnosed with Breast Cancer'."\n";
        }

        if($_POST['form-diag-when']){
            $request .= 'Completed Treatment : '.$_POST['form-diag-when']."\n";
        }

        if($_POST['form-phone']){
            $request .= 'Phone : '.$_POST['form-phone']."\n";
        }
        
        if(isset($diag)){
            $request .= 'I_have__c : '.$diag."\n";
        }

        if(isset($_POST['form-diag-when'])){
            $request .= 'Completed_Treatment__c : '.$_POST['form-diag-when']."\n";
        }  

        if(isset($_POST['form-have-role'])){
            $request .= 'Previous_Volunteer_Role__c : '.$_POST['form-have-role']."\n";
        } 

        if(isset($_POST['form-have-period'])){
            $request .= 'Previous_Volunteer_Period__c : '.$_POST['form-have-period']."\n";
        }

        if(isset($_POST['form-org-name'])){
            $request .= 'Other_Organization_Volunteered__c : '.$_POST['form-org-name']."\n";
        }

        if(isset($_POST['form-org-role'])){
            $request .= 'Other_Organization_Volunteered_Role__c : '.$_POST['form-org-role']."\n";
        }

        if(isset($_POST['form-org-period'])){
            $request .= '$contact[0]->Other_Organization_Volunteered_Period__c : '.$_POST['form-org-period']."\n";
        } 

        if(isset($_POST['form-qualities'])){
            $request .= 'Volunteer_Skill__c : '.$_POST['form-qualities']."\n";
        }

        if(isset($_POST['inputvolunteer']) && $_POST['inputvolunteer'] == '1'){
            $request .= 'Volunteer_Application_Date__c : '.date('Y-m-d')."\n";
            $request .= 'Volunteer_Status__c : Prospect'."\n";
        } 

        if(isset($_POST['inputmember']) && $_POST['inputmember'] == '1' ){
            $request .= 'Membership_Application_date__c : '.date('Y-m-d')."\n";
        } 

        $request = str_replace('__c', '', $request);
        $request = str_replace('_', '', $request);
        
        $note[0]->Title = 'Request Contact Data Change';
        $note[0]->Body = $request;
        $note[0]->ParentId = $idc;
        try {
            $response = $mySforceConnection->upsert('Id', $note, 'Note');
        } catch (Exception $e) {
            die($e->faultstring);
        }
        $accid = $idc;
    }
    header('Location:success.php');
    exit;
}
else{
    $_SESSION['error_message'] = $error_message;
    header('Location:error.php');
    exit;
}
    

?>