<?php

require_once (__DIR__.'/soapclient/SforceEnterpriseClient.php');
require_once("config.php");
try {
    $mySforceConnection = new SforceEnterpriseClient();
    $mySforceConnection->createConnection(__DIR__."/soapclient/enterprise.wsdl.xml");
    $mySforceConnection->login(SF_USERNAME, SF_PASSWORD . SF_SECURITY_TOKEN);
} catch (Exception $e) {
    die($e->faultstring);
}

function checkId($idno) {
    global $mySforceConnection;
    try {
        $query = "SELECT Id from Account WHERE ID_NO__C = '". $idno ."' LIMIT 1";
        $data = $mySforceConnection->query(($query));
        return $data->records[0]->Id;
    } catch (Exception $e) {
        return 'error';
    }
}
function checkEmail($email) {
    global $mySforceConnection;
    try {
        $query = "SELECT Id from Account WHERE Email__c = '". $email ."' LIMIT 1";
        $data = $mySforceConnection->query(($query));
        return $data->records[0]->Id;
    } catch (Exception $e) {
        return 'error';
    }
}

function formCheck($post) {
    global $form;
    global $cardType;
    $gump = new GUMP();

    $data = $gump->sanitize($post);

    $rules = array(
        'name' => 'required|valid_name',
        'email' => 'required|valid_email',
        'phone' => 'required|numeric',
        'postcode' => 'integer',
        'id_type' => 'required',
        'donation_purpose' => 'required',
        'other-amount' => 'required|integer|min_numeric,1',
        'cc_name' => 'required|valid_name',
        'cc_num' => 'required|valid_cc',
        'cvv_num' => 'required|integer'
    );
    if($post['id_type'] != "n/a") $rules['id_no'] = 'required';
    if($post['donation_purpose'] == "Others") $rules['other_donation_purpose'] = 'required';
    
    $gump->validation_rules($rules);

    $gump->filter_rules(array(
        'name' => 'trim|sanitize_string',
        'email' => 'trim|sanitize_email',
        'postcode' => 'trim|sanitize_numbers',
        'phone' => 'trim|sanitize_numbers',
        'donation_purpose' => 'trim|sanitize_string',
        'other_donation_purpose' => 'trim|sanitize_string',
        'city' => 'trim|sanitize_string',
        'id_type' => 'trim|sanitize_string',
        'id_no' => 'trim|sanitize_string',
        'other-amount' => 'trim|sanitize_numbers',
        'cc_name' => 'trim|sanitize_string',
        'cc_num' => 'trim|sanitize_numbers',
        'cvv_num' => 'trim|sanitize_numbers',
        'street' => 'trim|sanitize_string'
    ));

    $validated_data = $gump->run($data);
    $form = $validated_data;

    $card = CreditCard::validCreditCard($data['cc_num']);

    if ($validated_data && $card['valid'] > 0 && ($card['type'] == "visa" || $card['type'] == "mastercard")) {
        $expiry = explode("/", $post['cc_expiry']);
        $expiry_m = $expiry[0];
        $expiry_y = $expiry[1];
        $validCvv = CreditCard::validCvc($data['cvv_num'], $card['type']);
        $validDate = CreditCard::validDate($expiry_y, $expiry_m);
        if ($validCvv && $validDate) {
            $cardType = $card['type'];
            return true;
        }
    }
    return false;
}

function generateFgkey($secret, $mid, $reference, $currency, $amount) {
    $format = $secret ."?mid=". $mid ."&ref=". $reference ."&cur=". $currency ."&amt=". $amount;
    $fgkey = md5($format);
    return $fgkey;
}

function responseFgkey($secret, $mid, $reference, $currency, $amount, $rescode, $transid) {
    $format = $secret ."?mid=". $mid ."&ref=". $reference ."&cur=". $currency ."&amt=". $amount ."&rescode=". $rescode ."&transid=". $transid;
    $fgkey = md5($format);
    return $fgkey;
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
?>


