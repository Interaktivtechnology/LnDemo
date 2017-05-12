<?php
/* No Direct Access */
if($_SERVER['REQUEST_METHOD'] !== 'POST') {
	die("No direct access !");
}
require_once "library/config.php";
require_once 'library/FunctionLib.php';
$verify = responseFgkey(MCP_KEY, $_POST['mid'], $_POST['ref'], $_POST['cur'], $_POST['amt'], $_POST['rescode'], $_POST['transid']);
//check status
if($verify == $_POST['fgkey']) {
        //Payment success
	if($_POST['rescode'] == "0000" || $_POST['rescode'] == "200") {
        //Update Donation
        $clearedDate = date_create($_POST['resdt']);
        $clearedDateFormat = date_format($clearedDate, 'Y-m-d');
		//$clearedDateFormat = date('Y-m-d');
		$udonation = array();
		$udonation[0] = new stdclass();
		$udonation[0]->Id = $_POST['ref'];
		$udonation[0]->Donation_Status__c = "Cleared";
		$udonation[0]->Transaction_No__c = $_POST['transid'];
		$udonation[0]->Auth_Code__c = $_POST['authcode'];
		$udonation[0]->Credit_Card_No__c = str_replace('X', '0', $_POST['cardno']);
		$udonation[0]->Cleared_Date__c = $clearedDateFormat;
		try {
			$updateDonation = $mySforceConnection->upsert('Id', $udonation, 'Donation__c');
		} catch (Exception $e) {
			die($e->faultstring);
		}
	}
}
else{
		//cc declined
		if(isset($_POST['ref']) && strlen($_POST['ref']) > 0 && strlen($_POST['resmsg']) > 0){
			if($_POST['rescode'] == '701'){
				
				$status = "Cancelled";
			}
			else{
				$status = 'CC Declined';
			}
	        $udonation = array();
			$udonation[0] = new stdclass();
			$udonation[0]->Id = $_POST['ref'];
			$udonation[0]->Donation_Status__c = $status;
			if(isset($_POST['cardno']) && $_POST['cardno'] != ''){
				$udonation[0]->Credit_Card_No__c = str_replace('X', '0', $_POST['cardno']);
			}
			$udonation[0]->Rejected_Date__c = date('Y-m-d');
			$udonation[0]->Remarks__c = 'Reasonnya: '.$_POST['resmsg'].', Error code: '.$_POST['rescode'];
			try {
				$updateDonation = $mySforceConnection->update($udonation, 'Donation__c');
			} catch (Exception $e) {
				die($e->faultstring);
			}
		}
	}
?>