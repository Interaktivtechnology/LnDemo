<?php 
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\models\sf\SforceEnterpriseClient;
use app\models\McpVerification;

class McpController extends Controller {

	public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

	public function actionIndex(){
		$request = Yii::$app->request;
        $mcp =  new \app\models\McpVerification;
        $dataProvider = $mcp->search($request->get('McpVerification'));
        
		return $this->render("/donation/channels/mcp", ['dataProvider' => $dataProvider, 'mcp' => $mcp]);
	}



	public function actionEdit()
	{
	    $model = McpVerification::find()->where(['id' => Yii::$app->request->get('id')])->one();

	    if (Yii::$app->request->post()) {
	    	$model->attributes = Yii::$app->request->post('McpVerification');
	        if ($model->validate()) {
	            // form inputs are valid, do something here
	            $model->save();
	            $this->redirect(['mcp/index']);
	        }
	    }

	    return $this->render('/donation/mcp-edit', [
	        'model' => $model,
	    ]);
	}

	public function actionUploadToSf()
	{
		$request = Yii::$app->request;
        $model = McpVerification::find();
        $mcps = $model->where('salesforce_id is null')->
        andWhere('id in ('.$request->get('id').')')->all();

        $mySforceConnection = new SforceEnterpriseClient();

        $connection = $mySforceConnection->createConnection(Yii::$app->params['sfentwsdl']);
        $mySforceConnection->login(Yii::$app->params['sfuser'], Yii::$app->params['sfpassword'] . Yii::$app->params['sftoken']);
        

        $success = 0;
        $i = 0;
        $log = [];
        foreach($mcps as $mcp):
        	$soql = "SELECT Id, Amount__c, Transaction_No__c FROM Donation__c where Transaction_No__c = '".$mcp->reference."' AND ".
        		" Channel_Of_Donation__c In ('BT Website','By Post') LIMIT 1";
        	$sfRecord = $mySforceConnection->query($soql);
        	if(count($sfRecord->records) == 0):
        		preg_match_all('/(?:\d*\.)?\d+/', $mcp->card_no, $cardNo);
        		$name = explode(' ',$mcp->payer_name);
        		$name = count($name) > 0 ? $name[0] : $mcp->payer_name;
        		$soql = "SELECT Id, Amount__c, Transaction_No__c FROM Donation__c where (Credit_Card_No__c LIKE '%".$cardNo[0][1]."%' AND Credit_Card_No__c LIKE '%".$cardNo[0][0]."%') 
                    AND Cleared_Date__c = null ORDER BY LastModifiedDate DESC LIMIT 1";
        		$sfRecord = $mySforceConnection->query($soql);
        	endif;

        	if(count($sfRecord->records) > 0):
                if((int)$mcp->amount == (int)$sfRecord->records[0]->Amount__c):
    	        	$record = new \stdClass;
    		        $record->Auth_Code__c = $mcp->auth_code;
                    $record->Donation_Status__c = 'cleared';
                    $record->Cleared_Date__c = date("Y-m-d H:i:s");
    		        $record->Id = $sfRecord->records[0]->Id;
                    $record->Transaction_No__c = $mcp->reference;
                    $record->Remarks__c = "Cleared from AWS MCP Records. Payer Name: ".$mcp->payer_name.".";
    		        $donation = $mySforceConnection->update([$record],'Donation__c');
    		        if($donation[0]->success):
    		        	$mcp->salesforce_id = $record->Id;
    		        	$mcp->save();
    		        	$success++;
    		        	$eachLog['message'] = "Transaction No $mcp->reference inserted to Salesforce succesfully.";
    		        else:
    		        	$eachLog['message'] = $donation[0]->errors[0]->message. " SalesforceId : ".$record->Id;
    		        endif;
                else:
                    $eachLog['message'] = "No BT Website Field found in Salesforce for this transaction($mcp->reference) with amount = ".number_format($mcp->amount).".";
                endif;
		    else:
		    	$eachLog['message'] = "No BT Website Field found in Salesforce for this transaction($mcp->reference) with amount = ".number_format($mcp->amount).".";
	        endif;
	        $eachLog['_row'] = $i + 1;
	        $log[]=$eachLog;
        	$i ++;
        endforeach;

        Yii::$app->getSession()->setFlash('log', $log);
        Yii::$app->getSession()->setFlash('success', $success." record(s) was uploaded to Salesforce.");
        //Yii::$app->getSession()->setFlash('json', true);
        $this->redirect(['mcp/index']);
	}

}