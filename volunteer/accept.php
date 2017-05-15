<?php
session_start();
include_once('sf.php');
error_reporting(0);
$participant_id = $_POST['participant_id'];
$programme_id = $_POST['programme_id'];

	$query = "select id from participant__c where  Participating_Programme_Event__c  ='$programme_id' AND Id = '$participant_id' AND Status__c = 'Selected'";
	$data = $mySforceConnection->query(($query));
	if(isset($data->records[0]->Id)){
        $records = array();
        $records[0] = new stdclass();
        $records[0]->Id = $data->records[0]->Id;
        $records[0]->Status__c = 'Accepted';
        try {
            $response = $mySforceConnection->upsert('Id', $records, 'Participant__c');
        header('Location:participant_success.php');
        } catch (Exception $e) {
            die($e->faultstring);
        }
	}
	
?>