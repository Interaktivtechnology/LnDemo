<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\sf\SforceEnterpriseClient;

class HelloController extends Controller {

    public function actionIndex() {

        echo 'Hallo, apa kabar?';
        exit();
    }

    public function actionSftest() {
        $builder = new \Phpforce\SoapClient\ClientBuilder(
                'sandbox.enterprise.wsdl.xml', 'boystown@interaktiv.sg.dev3', 'interAktiv.123', 'BXieXbHSyrXuDs1nLtuY1s7d'
        );
        $client = $builder->build();
        //$first = array();
        $first = new \stdClass();
        $first->Credit_Card_No__c = "123123123";
        $createResponse = $client->create(array($first), 'Holding_Table__c');
        if ($createResponse) {
            foreach ($createResponse as $createResult) {
                print_r($createResult);
            }
            echo "ok";
        } else
            echo "not";
        //$results = $client->query('select Amount__c, Bank__c from Donation__c limit 5');
        //foreach ($results as $account) {
        //echo 'Amount: ' . $account->Amount__c . "\n";
        //}
        //$result = $client->query('insert Holding_Table__c (Credit_Card_No__c) values ("123123123")');
    }

    public function actionTest() {
        define("USERNAME", "user@example.com");
        define("PASSWORD", "password");
        define("SECURITY_TOKEN", "sdfhkjwrhgfwrgergp");

        $mySforceConnection = new SforceEnterpriseClient();
        $mySforceConnection->createConnection("sandbox.enterprise.wsdl.xml");
        $mySforceConnection->login('boystown@interaktiv.sg.dev3', 'interAktiv.123' . 'BXieXbHSyrXuDs1nLtuY1s7d');

        /* $query = "SELECT Id, FirstName, LastName, Phone from Contact";
          $response = $mySforceConnection->query($query);

          echo "Results of query '$query'<br/><br/>\n";
          foreach ($response->records as $record) {
          echo $record->Id . ": " . $record->FirstName . " "
          . $record->LastName . " " . $record->Phone . "<br/>\n";
          }
         * 
         */
        $records = array();

        $records[0] = new \stdclass();
        $records[0]->Credit_Card_No__c = '40441231231231';

        $response = $mySforceConnection->create($records, 'Holding_Table__c');
    }

}
