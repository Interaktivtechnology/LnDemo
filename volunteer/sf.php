<?php
define("USERNAME", "lndemo2@interaktiv.sg");
define("PASSWORD", "interaktiv.3");
define("SECURITY_TOKEN", "qZZ13ujzgxOMZjNQsAJHxzg1O");
ini_set("soap.wsdl_cache_enabled", 0);
require_once ('loader/soapclient/SforceEnterpriseClient.php');

try {
    $mySforceConnection = new SforceEnterpriseClient();
    $mySforceConnection->createConnection("loader/soapclient/enterprise.wsdl.xml");
    $mySforceConnection->login(USERNAME, PASSWORD . SECURITY_TOKEN);

    $query = "SELECT Id, Name FROM Account WHERE id = '00QO000000557g4'";
    $account = $mySforceConnection->query(($query));
} catch (Exception $e) {
    die($e->faultstring);
}

function SelectList($client, $objectType, $fieldName, $selected = null, $options = array()) {
    $result = $client->describeSObject($objectType);
    foreach ($result->fields as $field) {
        if ($field->name == $fieldName) {
            $selectString = "\n\t<select ";
            if(!array_key_exists("name", $options)) $selectString .= "name=\"" . $fieldName . "\" ";
            
            //else unset($options["name"]);
            foreach ($options as $key => $value) {
                $selectString .= $key ."=\"". $value ."\" ";
            }
            $selectString .= ">";
            if(!array_key_exists("multiple", $options)) {
                $defaultVal = (array_key_exists("default", $options)) ? $options['default'] : "";
                $selectString .= "\n\t\t<option value=\"\">". $defaultVal ."</option>";
            }
            foreach ($field->picklistValues as $value) {
                $select = ($value->label == $selected) ? ' selected="selected" ' : '';
                $value = htmlspecialchars($value->label);
                $selectString .= "\n\t\t<option " . $select . " value=\"" . $value . "\">" . $value . "</option>";
            }
            $selectString .= "\n\t</select>";
        }
    }
    return utf8_decode($selectString);
}

function getSelectedValue($strValue) {
    $selectOpt = '';
    if(!empty($strValue)) {
        $arrValue = explode(";", $strValue);
        foreach ($arrValue as $value) {
            $selectOpt .= '<option value="'. $value .'">'. $value .'</option>';
        }
    }
    return $selectOpt;
}

function reformatDate($date, $toSF = false) {
    $dateFormat = ($toSF) ? "Y-m-d" : "d-m-Y";
    if(isset($date)) {
        return date($dateFormat, strtotime($date));
    } else {
        return '';
    }
}

function listInterest(){
    global $mySforceConnection;
    $account = $mySforceConnection->describeSObject('Account');
    foreach($account->fields as $field){
        if($field->name == 'Volunteer_Area_of_Interests__c'){
            $i = 0;
            $option = '<div class="row col-md-12">';
            $count = count($field->picklistValues);
            foreach($field->picklistValues as $value){
                if($value->label == 'Workplace programmes' || $value->label == 'Organising events' || $value->label == 'Performing Arts' ){
                    $option .= '<div class="col-md-3">
                                <label class="custom-option button">
                                <input id="checkbox-able-'.($i+1).'" type="checkbox" value="'.$value->value.'" name="interest[]">
                                <span class="button-checkbox"></span>
                                </label>
                                <label for="checkbox-able-'.($i+1).'">'.$value->label.'</label>
                            </div>';
                }
                else{
                $option .= '<div class="col-md-2">
                                <label class="custom-option button">
                                <input id="checkbox-able-'.($i+1).'" type="checkbox" value="'.$value->value.'" name="interest[]">
                                <span class="button-checkbox"></span>
                                </label>
                                <label for="checkbox-able-'.($i+1).'">'.$value->label.'</label>
                            </div>';
                }
                $i++;
                if($i%5 == 0 AND $i < $count){
                    $option .= '</div><div class="row col-md-12" style="margin-top:10px">';
                }
            }
            $option .= '</div>';
        }
    }
    return $option;
}

?>