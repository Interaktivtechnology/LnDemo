<?php
include('sf.php');
$idno = $_POST['id_no'];
$text = $_POST['text'];
$event_id = $_POST['event_id'];
$query = "SELECT Id, Name,Email FROM Contact WHERE id = '$idno' LIMIT 1";
$contact = $mySforceConnection->query(($query));
if(isset($contact->records[0]) AND isset($contact->records[0]->Email)){
	$query = "SELECT Id, Status__c FROM Programme_Event__c WHERE id = '$event_id' LIMIT 1";
	$programme = $mySforceConnection->query(($query));
	if(!isset($programme->records[0])){
		die('Event no error');
	}
	$query = "SELECT Id FROM Participant__c WHERE Participating_Programme_Event__c = '$event_id' AND Contact__c = '$idno' LIMIT 1";
	$return = $mySforceConnection->query(($query));
	if(isset($return->records[0]->Id)){
		die('Already in participant list');
	}
	$code = bin2hex(openssl_random_pseudo_bytes(4));
    $records = array();
    $records[0] = new stdclass();
    $records[0]->Code__c = $code;
    $records[0]->Accept__c = 'No';
    $records[0]->Contact__c = $idno;
    $records[0]->Date_Sent__c = date('Y-m-d');
    $records[0]->Programme_Event__c = $event_id;

    try {
        $response = $mySforceConnection->upsert('Id', $records, 'Invitation__c');
    } catch (Exception $e) {
        die($e->faultstring);
    }
    if(isset($response[0]->success) AND $response[0]->success == '1' ){
        $email = $contact->records[0]->Email;
		$emailFrom = 'admin@bcf.com.sg';

		$message = 'please click the link <a href="http://'.$_SERVER['HTTP_HOST'].'/bcf/php/invitation?code='.$code.'">Link</a>';
				

		$subject = "Invitation";

		$htmlContent = '
		    <html>
		    <head>
		        <title>Invitation</title>
		    </head>
		    <body>
		        <h1>'.$text.'</h1>
		        <table cellspacing="0" style="border: 2px dashed #FB4314; width: 300px; height: 200px;">
		            
		            <tr>
		              <td>'.$message.'</td>
		            </tr>
		        </table>
		    </body>
		    </html>';

		// Set content-type header for sending HTML email
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

		// Additional headers
		$headers .= 'From: BCF Admin<'.$emailFrom.'>' . "\r\n";
		// Send email
		if(mail($email,$subject,$htmlContent,$headers))
		{
		   echo 'An email already sent to : '.$email;
		}
		else{
		   echo 'Error, Please contact adminstrator.';
		}
		
    }
    else{
    	echo 'Error, Please contact adminstrator.';
    }
}
else
{ 
	echo 'Contact ID or Event ID not found or email is empty ';
}
?>