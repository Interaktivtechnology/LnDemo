<?php
session_start();
include('sf.php');
$code = $_GET['code'];
$query = "SELECT Id, Programme_Event__c, Contact__c FROM Invitation__c WHERE Code__c = '$code' LIMIT 1";
$inv = $mySforceConnection->query(($query));

if(isset($inv->records[0])){
	$id = $inv->records[0]->Id;
	$records = array();
    $records[0] = new stdclass();
    $records[0]->Accept__c = 'Yes';
    $records[0]->Id = $id;
    try {
        $response = $mySforceConnection->upsert('Id', $records, 'Invitation__c');
    } catch (Exception $e) {
        die($e->faultstring);
    }
    if(isset($response[0]->success) AND $response[0]->success == '1' ){
    	unset($records);
    	
		$records = array();
		$records[0] = new stdclass();
		$records[0]->Contact__c = $_SESSION['contact'];
		$records[0]->Participating_Programme_Event__c = $_SESSION['programme'];
		try {
	        $response = $mySforceConnection->upsert('Id', $records, 'Participant__c');
	    } catch (Exception $e) {
	        die($e->faultstring);
	    }
    	echo 'Congratulation, you are now listed in participant';
    }
}
else{
	echo 'Code error';
}

session_destroy();
?>