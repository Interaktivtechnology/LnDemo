<?php 
session_start();
ini_set("soap.wsdl_cache_enabled",0);
include_once('sf.php');
error_reporting(0);

$programmeid = $_REQUEST['programme'];
$participant = $_REQUEST['participant'];
if(!isset($participant) || !isset($programmeid)){
	$error = 'link is invalid';
}
$query = "SELECT Id,Ttile__c FROM Programme_Event__c WHERE Id = '$programmeid' LIMIT 1";
try {
    $programme = $mySforceConnection->query(($query));
    $programme_record = $programme->records[0];
    $title = $programme_record->Ttile__c;
    $prog_id = $programme_record->Id;
}
catch(Exception $e) {
   $error = 'link is invalid';
}

$query = "SELECT Id FROM Participant__c WHERE  Participating_Programme_Event__c  ='$programmeid' AND status__c = 'Accepted' ";
try {
    $participant_data = $mySforceConnection->query(($query));
    $participant_record = $participant_data->records[0];
    $records = count($participant_data->records);
    if($records > 1){
        $error = 'The volunteers for this programme is already fullfilled.';
    }

}
catch(Exception $e) {
   $error = 'link is invalid';
}

$query = "SELECT Id,Name, Status__c FROM Participant__c WHERE Id = '$participant' AND Participating_Programme_Event__c  ='$programmeid' LIMIT 1";
try {
    $participant_data = $mySforceConnection->query(($query));
    $participant_record = $participant_data->records[0];
        
    if($participant_record->status__c != 'Selected'){
        $error = 'link is expired';
    }    
}
catch(Exception $e) {
   $error = 'link is invalid';
}

?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Interaktiv Foundation</title>

        <!-- CSS -->
        <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <style>
        
        input[type="text"], 
        input[type="password"], 
        textarea, 
        textarea.form-control {
            height: 50px;
            margin: 0;
            padding: 0 20px;
            vertical-align: middle;
            background: #f8f8f8;
            border: 3px solid #ddd;
            font-family: 'Roboto', sans-serif;
            font-size: 16px;
            font-weight: 300;
            line-height: 50px;
            color: #888;
            -moz-border-radius: 4px; -webkit-border-radius: 4px; border-radius: 4px;
            -moz-box-shadow: none; -webkit-box-shadow: none; box-shadow: none;
            -o-transition: all .3s; -moz-transition: all .3s; -webkit-transition: all .3s; -ms-transition: all .3s; transition: all .3s;
        }

        textarea, 
        textarea.form-control {
            padding-top: 10px;
            padding-bottom: 10px;
            line-height: 30px;
        }

        input[type="text"]:focus, 
        input[type="password"]:focus, 
        textarea:focus, 
        textarea.form-control:focus {
            outline: 0;
            background: #fff;
            border: 3px solid #ccc;
            -moz-box-shadow: none; -webkit-box-shadow: none; box-shadow: none;
        }

        input[type="text"]:-moz-placeholder, input[type="password"]:-moz-placeholder, 
        textarea:-moz-placeholder, textarea.form-control:-moz-placeholder { color: #888; }

        input[type="text"]:-ms-input-placeholder, input[type="password"]:-ms-input-placeholder, 
        textarea:-ms-input-placeholder, textarea.form-control:-ms-input-placeholder { color: #888; }

        input[type="text"]::-webkit-input-placeholder, input[type="password"]::-webkit-input-placeholder, 
        textarea::-webkit-input-placeholder, textarea.form-control::-webkit-input-placeholder { color: #888; }



        button.btn {
            height: 50px;
            margin: 0;
            padding: 0 20px;
            vertical-align: middle;
            background: #19b9e7;
            border: 0;
            font-family: 'Roboto', sans-serif;
            font-size: 16px;
            font-weight: 300;
            line-height: 50px;
            color: #fff;
            -moz-border-radius: 4px; -webkit-border-radius: 4px; border-radius: 4px;
            text-shadow: none;
            -moz-box-shadow: none; -webkit-box-shadow: none; box-shadow: none;
            -o-transition: all .3s; -moz-transition: all .3s; -webkit-transition: all .3s; -ms-transition: all .3s; transition: all .3s;
        }

        button.btn:hover { opacity: 0.6; color: #fff; }

        button.btn:active { outline: 0; opacity: 0.6; color: #fff; -moz-box-shadow: none; -webkit-box-shadow: none; box-shadow: none; }

        button.btn:focus { outline: 0; opacity: 0.6; background: #19b9e7; color: #fff; }

        button.btn:active:focus, button.btn.active:focus { outline: 0; opacity: 0.6; background: #19b9e7; color: #fff; }
        .btn-success{
            background-color:#CE4F8A;
        }
        body{
            background: url('assets/img/volunteer_tree.jpg') no-repeat center center fixed; 
        }
</style>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Favicon and touch icons -->


    </head>

    <body>
        <!-- Top content -->
        <div class="top-content">
        	
            <div class="inner-bg">
                <div class="container">
                    
                    <div class="row" style="margin-top: 10%">
                        
                        <div class="col-sm-9 col-sm-offset-1 form-box" style="opacity: 0.9;">
                            <img src="assets/img/old_logo.jpg" width="150px"/><br /><br />
                        	<?php if(!isset($error)) { ?>
                        	<form role="form" action="accept.php" method="post" class="registration-form update2" style="margin-top: 15%">
                        		<div class="col-sm-12" style="background: #EEEEEE;border:25px solid #fff">
	                        		<div class="col-sm-12 nopadding">
		                        		<center>
		                        			<h1><?php echo $title; ?></h1>
		                        			<br />
		                        			Click the button below if you want to become a participant of this programme:
		                        			<input type="hidden" name="participant_id" value="<?php echo $participant_record->Id; ?>"/>
		                        			<input type="hidden" name="programme_id" value="<?php echo $programme_record->Id; ?>"/>
		                        			<br />
		                        			<br />
		                        			    <button class="btn btn-large btn-block btn-success" style="background-color:#2A6CAB;" type="submit">Yes, I want to Join!</button>
		                        			   <br />
		                        		</center>

				                    </div>
		                    	</div>
		                    </form>
                            <?php } else { ?>
                                <div class="col-sm-12" style="background: #EEEEEE;border:25px solid #fff;margin-top: 20%">
	                        		<div class="col-sm-12 nopadding">
		                        		<center>
		                        			<h1><?php echo $error; ?></h1>
		                        		</center>

				                    </div>
		                    	</div>
                            <?php } ?>
		                    <br />
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

        <!-- Javascript -->
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </body>

</html>