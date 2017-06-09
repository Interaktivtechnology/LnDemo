<?php 
session_start();
if(isset($_GET['email']) && isset($_GET['code'])){
	include_once('sf.php');
	$email 	= $_GET['email'];
	$code 	= $_GET['code'];
	//Passcode__c
	$query = "SELECT Id FROM Contact WHERE Passcode__c = '$code' AND Email = '$email' LIMIT 1";
	$contact = $mySforceConnection->query(($query));
	if(isset($contact->records[0]->Id)){
		$contactid = $contact->records[0]->Id;
		$query = "Select Id, Asignee_Status__c from Assigned_Volunteers__c where Volunteer__c != '$contactid' LIMIT 1";
		$vol = $mySforceConnection->query(($query));
		print_r($vol);exit;
		if(isset($vol->records[0]->Id)){
			if($vol->records[0]->Asignee_Status__c == 'Selected'){
				//process update as accepted
				$voldata = array();
            	$voldata[0] = new stdclass();
            	$voldata[0]->Id = $vol->records[0]->Id;
            	$voldata[0]->Asignee_Status__c = 'Accepted';
            	$voldata[0]->Email_Verified__c = 'True';
            	try {
	            	$response = $mySforceConnection->upsert('Id', $voldata, 'Assigned_Volunteers__c');
	            } catch (Exception $e) {
	                die($e->faultstring);
	            }
	            if(isset($response[0]->errors)){
  					$title 		= 'Error';
					$content 	= '<p>Our server is have a problem, please try later';
			    }
			    if(isset($response[0]->success) AND $response[0]->success == '1' ){
			        $title 		= 'Thank you';
					$content 	= '<p>Your response have been recorded</p>';
			    }
				
			}
			else{
				$title 		= 'Invalid Link';
				$content 	= '<p>This link already processed</p>';
			}
		}
		else{
			$title 		= 'Invalid Link';
			$content 	= '<p>You are not proposed as a volunteer yet</p>';
		}
	}
	else{
		$title 		= 'Invalid Link';
		$content 	= '<p>Your link is invalid or already expired</p>';
	}
}
else{
	$title 		= 'Invalid Link';
	$content 	= '<p>Your link is invalid or already expired</p>';
}	
?>
<!DOCTYPE html>
<title>InterAktiv Foundation</title>
<style>
  body { text-align: center; padding: 150px; }
  h1 { font-size: 50px; }
  body { font: 20px Helvetica, sans-serif; color: #333; }
  article { display: block; text-align: left; width: 650px; margin: 0 auto; }
  a { color: #dc8100; text-decoration: none; }
  a:hover { color: #333; text-decoration: none; }
</style>

<article>
    <h1><?php echo $title;?></h1>
    <div>
        <?php echo $content; ?>
    </div>
</article>
