<?php
//echo '<pre>';print_r($_POST);exit;
session_start();
include 'sf.php';
error_reporting(0);
if(isset($_GET['type']) && isset($_POST['key'])){
	$key = $_POST['key'];
	switch ($_GET['type']){
		case 'nric':

			$query = "SELECT Id FROM Account WHERE ID_NO__C = '$key' LIMIT 1";
    		$account = $mySforceConnection->query(($query));
    		if(isset($account->records[0]->Id)){
    			echo 'duplicate';
    		}
    		else{
    			echo 'ok';
    		}
		break;

		case 'email':
			$query = "SELECT Id FROM Account WHERE Email__c = '$key' LIMIT 1";
    		$account = $mySforceConnection->query(($query));
    		if(isset($account->records[0]->Id)){
    			echo 'duplicate';
    		}
    		else{
    			echo 'ok';
    		}
		break;

        case 'postcode':
         if(strlen($key) == 6){
            $query = "SELECT Id,Street__c,Block__c,Building_Name__c,Country__c,Name FROM Postal_Code__c WHERE Name = '$key' LIMIT 1";
            $data = $mySforceConnection->query(($query));
            //print_r($data);
            $queryResult = new QueryResult($data);
            $row = $queryResult->current();
            $street = 'none';
            if(isset($row->fields->Street__c)){
                $street = $row->fields->Street__c;
                if(isset($row->fields->Block__c)){
                    $street = trim($row->fields->Block__c).', '.$street;
                }
                if(isset($row->fields->Building_Name__c)){
                    $street .= ', '.trim($row->fields->Building_Name__c);
                }
            }
            else{
                if(isset($row->fields->Building_Name__c)){
                     $street = trim($row->fields->Building_Name__c);
                }
            }
            echo $street;
        }
        else{
            echo 'none';
        }
        break;
	}
}
else{
	echo 'error';
}
