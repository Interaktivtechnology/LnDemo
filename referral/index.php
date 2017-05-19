<?php 
session_start();
$referral_token = uniqid();
/*** add the donation token to the session ***/
$_SESSION['referral_token'] = $referral_token;
error_reporting(E_ERROR);
require_once("library/FunctionLib.php");
?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>InterAktiv</title>

        <!-- CSS -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="assets/css/form-elements.css">
		<link href="assets/css/highlight.css" rel="stylesheet">
    	<link href="assets/css/bootstrap-switch.css" rel="stylesheet">
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/jquery-ui.css">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Favicon and touch icons -->
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
        <style>
        .center_div{
		    margin: 0 auto;
		    margin-top:1%;
		    background: #FFFFFF;
		    padding-top: 20px;
		}
		.credit-card-box .panel-title {
		    display: inline;
		    font-weight: bold;
		}
		.credit-card-box .form-control.error {
		    border-color: red;
		    outline: 0;
		    box-shadow: inset 0 1px 1px rgba(0,0,0,0.075),0 0 8px rgba(255,0,0,0.6);
		}
		.credit-card-box label.error {
		  font-weight: bold;
		  color: red;
		  padding: 2px 8px;
		  margin-top: 2px;
		}
		.credit-card-box .payment-errors {
		  font-weight: bold;
		  color: red;
		  padding: 2px 8px;
		  margin-top: 2px;
		}
		.credit-card-box label {
		    font-weight: normal;
		    text-align: left !important;
		    margin-left: 0px;
		    left: 0px;
		}
		/* The old "center div vertically" hack */
		.credit-card-box .display-table {
		}
		.credit-card-box .display-tr {
		    display: table-row;
		}
		.credit-card-box .display-td {
		    display: table-cell;
		    vertical-align: middle;
		    width: 100%;
		}
		/* Just looks nicer */
		.credit-card-box .panel-heading img {
		    min-width: 180px;
		    padding : 10px 70px;
		}
		.credit-card-box .panel-heading {
		    padding : 10px;
		    margin-left: 0px;
		}
		.display-td{
		    margin-left: -80px;
		}
		#amount{
			background: #f8f8f8 none repeat scroll 0 0;
		    border: 3px solid #ddd;
		    border-radius: 4px;
		    box-shadow: none;
		    color: #888;
		    font-family: "Roboto",sans-serif;
		    font-size: 16px;
		    font-weight: 300;
		    height: 50px;
		    line-height: 50px;
		    margin: 0;
		    padding: 0 20px;
		    transition: all 0.3s ease 0s;
		    vertical-align: middle;
		}
		. div_cc{
			margin: 0px auto;
		}
		p{
			text-align: left !important;
		}
        .smalltext{
            font-size: 12px;
            color: #ccc;
            text-align: center;
        }
        </style>
    </head>

    <body>
    
	<div class="container center_div">
		<form class="referral-form" action="process.php" method="post">
        <div class="row">
			<div class="col-xs-12 col-md-12">
				<div class="panel panel-default credit-card-box">
					<div class="panel-heading display-table" >
						<div class="row display-tr" >
						<h3 class="display-td" style="text-align:left" >Client's particulars</h3>
							
						</div>                    
					</div>
					<div class="panel-body col-md-6">
                        <div class="panel panel-default">
                        <div class="panel-body form-horizontal">
                            <div class="form-group">
                                <label for="name" class="col-sm-3 control-label">First Name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="" id="First_Name__c" name="First_Name__c" required autofocus>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-sm-3 control-label">Last Name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="" id="Name__c" name="Name__c" required>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="id_no" class="col-sm-3 control-label">NRIC Number</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" maxlength="9" id="NRIC_No__c" name="NRIC_No__c" >
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="id_no" class="col-sm-3 control-label">Nationality</label>
                                <div class="col-sm-9">
                                    <?=SelectList($mySforceConnection, 'Admission_Orientation__c', 'Nationality__c', null, array("class"=>"select", "required" => "required"))?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email" class="col-sm-3 control-label">Residential Address</label>
                                <div class="col-sm-9">
                                    <textarea id="Residential_Address__c" name="Residential_Address__c" class="form-control"  rows="2" style="height:auto"></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="id_no" class="col-sm-3 control-label">Date of birth</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" maxlength="9" id="Date_of_birth__c" name="Date_of_birth__c" >
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="id_no" class="col-sm-3 control-label">Language Spoken</label>
                                <div class="col-sm-9">
                                    <?=SelectList($mySforceConnection, 'Admission_Orientation__c', 'Language_spoken__c', null, array("class"=>"select", "required" => "required"))?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="id_no" class="col-sm-3 control-label">Education</label>
                                <div class="col-sm-9">
                                    <?=SelectList($mySforceConnection, 'Admission_Orientation__c', 'Education__c', null, array("class"=>"select", "required" => "required"))?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="id_no" class="col-sm-3 control-label">Ethnicity/Race</label>
                                <div class="col-sm-9">
                                    <?=SelectList($mySforceConnection, 'Admission_Orientation__c', 'Ethnicity_Race__c', null, array("class"=>"select", "required" => "required"))?>
                                </div>
                            </div>                                
                        </div>
                    </div>   
				</div>

                <div class="panel-body col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-body form-horizontal">
                            <div class="form-group">
                                <label for="id_no" class="col-sm-3 control-label">Marital status</label>
                                <div class="col-sm-9">
                                    <?=SelectList($mySforceConnection, 'Admission_Orientation__c', 'Marital_status__c', null, array("class"=>"select", "required" => "required"))?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-sm-3 control-label">No of children</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="" id="No_of_children__c" name="No_of_children__c">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-sm-3 control-label">HP</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="" id="HP__c" name="HP__c">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-sm-3 control-label">Home Phone</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="" id="Home_Phone__c" name="Home_Phone__c">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="id_no" class="col-sm-3 control-label">Religion</label>
                                <div class="col-sm-9">
                                    <?=SelectList($mySforceConnection, 'Admission_Orientation__c', 'Religion__c', null, array("class"=>"select", "required" => "required"))?>
                                </div>
                            </div>   

                            <div class="form-group">
                                <label for="id_no" class="col-sm-3 control-label">Earliest Date of Release</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" maxlength="9" id="Earliest_Date_of_Release_EDR__c" name="Earliest_Date_of_Release_EDR__c" >
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-sm-3 control-label">Prison Number</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="" id="Prison_number__c" name="Prison_number__c">
                                </div>
                            </div>                             
                        </div>
                    </div>   
				</div>
			</div>            
		</div>          
	</div>

    <div class="row">
        <div class="col-xs-12 col-md-12">
            <div class="panel panel-default credit-card-box">
                <div class="panel-heading display-table" >
                    <div class="row display-tr" >
                    <h3 class="display-td" style="text-align:left" >Family Composition</h3>
                        
                    </div>                    
                </div>
                <div class="panel-body col-md-6">
                    <div class="panel panel-default">
                    <div class="panel-body form-horizontal">
                        <div class="form-group">
                            <label for="name" class="col-sm-3 control-label">Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="" id="Name_Family__c" name="Name_Family__c" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-sm-3 control-label">Relationship with resident</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="" id="Relationship_with_resident__c" name="Relationship_with_resident__c" >
                            </div>
                        </div>
                    </div>
                </div>   
            </div>

            <div class="panel-body col-md-6">
                <div class="panel panel-default">
                    <div class="panel-body form-horizontal">
                        <div class="form-group">
                            <label for="name" class="col-sm-3 control-label">Age</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="" id="Age_Family__c" name="Age_Family__c" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-sm-3 control-label">Occupation</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="" id="Occupation__c" name="Relationship_with_resident__c" >
                            </div>
                        </div>                       
                    </div>
                </div>   
            </div>
        </div>            
    </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-12">
            <div class="panel panel-default credit-card-box">
                <div class="panel-heading display-table" >
                    <div class="row display-tr" >
                    <h3 class="display-td" style="text-align:left" >Emergency Contact</h3>
                        
                    </div>                    
                </div>
                <div class="panel-body col-md-6">
                    <div class="panel panel-default">
                    <div class="panel-body form-horizontal">
                        <div class="form-group">
                            <label for="name" class="col-sm-3 control-label">Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="" id="Name_EC__c" name="Name_EC__c" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-sm-3 control-label">Relationship</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="" id="Relationship__c" name="Relationship__c" >
                            </div>
                        </div>
                    </div>
                </div>   
            </div>

            <div class="panel-body col-md-6">
                <div class="panel panel-default">
                    <div class="panel-body form-horizontal">
                        <div class="form-group">
                            <label for="name" class="col-sm-3 control-label">Contact Number</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="" id="Contact_Number__c" name="Contact_Number__c" >
                            </div>
                        </div>                       
                    </div>
                </div>   
            </div>
        </div>            
    </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-12">
            <div class="panel panel-default credit-card-box">
                <div class="panel-heading display-table" >
                    <div class="row display-tr" >
                    <h3 class="display-td" style="text-align:left" >Emergency Contact</h3>
                        
                    </div>                    
                </div>
                <div class="panel-body col-md-6">
                    <div class="panel panel-default">
                    <div class="panel-body form-horizontal">
                        <div class="form-group">
                            <label for="name" class="col-sm-3 control-label">Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="" id="Name_EC__c" name="Name_EC__c" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-sm-3 control-label">Relationship</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="" id="Relationship__c" name="Relationship__c" >
                            </div>
                        </div>
                    </div>
                </div>   
            </div>

            <div class="panel-body col-md-6">
                <div class="panel panel-default">
                    <div class="panel-body form-horizontal">
                        <div class="form-group">
                            <label for="name" class="col-sm-3 control-label">Contact Number</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="" id="Contact_Number__c" name="Contact_Number__c" >
                            </div>
                        </div>                       
                    </div>
                </div>   
            </div>
        </div>            
    </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-12">
            <div class="panel panel-default credit-card-box">
                <div class="panel-heading display-table" >
                    <div class="row display-tr" >
                    <h3 class="display-td" style="text-align:left" >Aftercare Case Manager Details (if any)</h3>
                        
                    </div>                    
                </div>
                <div class="panel-body col-md-6">
                    <div class="panel panel-default">
                    <div class="panel-body form-horizontal">
                        <div class="form-group">
                            <label for="name" class="col-sm-3 control-label">Email</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="" id="Email__c" name="Email__c" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-sm-3 control-label">Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="" id="Name_Manager__c" name="Name_Manager__c" >
                            </div>
                        </div>
                    </div>
                </div>   
            </div>

            <div class="panel-body col-md-6">
                <div class="panel panel-default">
                    <div class="panel-body form-horizontal">
                        <div class="form-group">
                            <label for="name" class="col-sm-3 control-label">Contact Number</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="" id="Contact_Number_Manager__c" name="Contact_Number_Manager__c" >
                            </div>
                        </div>                      
                    </div>
                </div>   
            </div>
        </div>            
    </div>
    </div>


    <div class="row">
        <div class="col-xs-12 col-md-12">
            <div class="panel panel-default credit-card-box">
                <div class="panel-heading display-table" >
                    <div class="row display-tr" >
                    <h3 class="display-td" style="text-align:left" >Forensic/Criminal History</h3>
                        
                    </div>                    
                </div>
                <div class="panel-body col-md-6">
                    <div class="panel panel-default">
                    <div class="panel-body form-horizontal">
                        <div class="form-group">
                            <label for="name" class="col-sm-3 control-label">History of Sexual Assult</label>
                            <div class="col-sm-9">
                                <?=SelectList($mySforceConnection, 'Admission_Orientation__c', 'History_of_sexual_assult__c', null, array("class"=>"select", "required" => "required"))?>
                            </div>
                        </div> 

                        <div class="form-group">
                            <label for="email" class="col-sm-3 control-label">If Yes Please Specifiy</label>
                            <div class="col-sm-9">
                                <textarea id="if_yes_please_specifiy__c" name="if_yes_please_specifiy__c" class="form-control"  rows="2" style="height:auto"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-sm-3 control-label">Current/hist.of violent/hostile/aggrsv</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="" id="Current_hist_of_violent_hostile_aggrsv__c" name="History_of_sexual_assult__c" >
                            </div>
                        </div> 

                        <div class="form-group">
                            <label for="email" class="col-sm-3 control-label">If Yes please specify (History Violent)</label>
                            <div class="col-sm-9">
                                <textarea id="If_Yes_please_specify_History_Violent__c" name="If_Yes_please_specify_History_Violent__c" class="form-control"  rows="2" style="height:auto"></textarea>
                            </div>
                        </div>
                    </div>
                </div>   
            </div>

            <div class="panel-body col-md-6">
                <div class="panel panel-default">
                    <div class="panel-body form-horizontal">
                        <div class="form-group">
                            <label for="name" class="col-sm-3 control-label">Risk to Commit Violent Crime</label>
                            <div class="col-sm-9">
                                <?=SelectList($mySforceConnection, 'Admission_Orientation__c', 'Risk_to_Commit_Violent_Crime__c', null, array("class"=>"select", "required" => "required"))?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-sm-3 control-label">Number of Years in Prison</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control"  id="Number_of_Years_in_Prison__c" name="Number_of_Years_in_Prison__c" value="0.00" >
                            </div>
                        </div>   

                        <div class="form-group">
                            <label for="email" class="col-sm-3 control-label">Details of Offences</label>
                            <div class="col-sm-9">
                                <textarea id="Details_of_Offences__c" name="Details_of_Offences__c" class="form-control"  rows="2" style="height:auto"></textarea>
                            </div>
                        </div>                  
                    </div>
                </div>   
            </div>
        </div>            
    </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-md-12">
            <div class="panel panel-default credit-card-box">
                <div class="panel-heading display-table" >
                    <div class="row display-tr" >
                    <h3 class="display-td" style="text-align:left" >History of Substance use and Dependency</h3>
                        
                    </div>                    
                </div>
                <div class="panel-body col-md-6">
                    <div class="panel panel-default">
                    <div class="panel-body form-horizontal">
                        <div class="form-group">
                            <label for="email" class="col-sm-3 control-label">Types of Substances Taken & freq of Use</label>
                            <div class="col-sm-9">
                                <textarea id="Types_of_Substances_Taken_freq_of_Use__c" name="Types_of_Substances_Taken_freq_of_Use__c" class="form-control"  rows="2" style="height:auto"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-sm-3 control-label">No. of times in DRC (Drug Rehab Centre)</label>
                            <div class="col-sm-9">
                                <textarea id="No_of_times_in_DRC_Drug_Rehab_Centre__c" name="No_of_times_in_DRC_Drug_Rehab_Centre__c" class="form-control"  rows="2" style="height:auto"></textarea>
                            </div>
                        </div>
                    </div>
                </div>   
            </div>

            <div class="panel-body col-md-6">
                <div class="panel panel-default">
                    <div class="panel-body form-horizontal">
                        <div class="form-group">
                            <label for="email" class="col-sm-3 control-label">Details of Offences</label>
                            <div class="col-sm-9">
                                <textarea id="Details_of_Offences_History__c" name="Details_of_Offences_History__c" class="form-control"  rows="2" style="height:auto"></textarea>
                            </div>
                        </div>                  
                    </div>
                </div>   
            </div>
        </div>            
    </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-md-12">
            <div class="panel panel-default credit-card-box">
                <div class="panel-heading display-table" >
                    <div class="row display-tr" >
                    <h3 class="display-td" style="text-align:left" >Mental/Medical Health Issue</h3>
                        
                    </div>                    
                </div>
                <div class="panel-body col-md-6">
                    <div class="panel panel-default">
                    <div class="panel-body form-horizontal">
                        <div class="form-group">
                            <label for="email" class="col-sm-3 control-label">Active/impace daily functioning</label>
                            <div class="col-sm-9 left" style="text-align:left">
                                <input type="checkbox" name="Active_impace_daily_functioning__c" value="true">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-sm-3 control-label">To Specify If Ticked</label>
                            <div class="col-sm-9">
                                <textarea id="To_Specify_If_Ticked__c" name="To_Specify_If_Ticked__c" class="form-control"  rows="2" style="height:auto"></textarea>
                            </div>
                        </div>
                    </div>
                </div>   
            </div>

            <div class="panel-body col-md-6">
                <div class="panel panel-default">
                    <div class="panel-body form-horizontal">
                        <div class="form-group">
                            <label for="email" class="col-sm-3 control-label">Stable/Little Impact on Daily Func.</label>
                            <div class="col-sm-9 left" style="text-align:left">
                                <input type="checkbox" name="Stable_little_impact_on_daily_func__c" value="true">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-sm-3 control-label">To Specify If Ticked</label>
                            <div class="col-sm-9">
                                <textarea id="To_Specify_If_Ticked_Daily__c" name="To_Specify_If_Ticked_Daily__c" class="form-control"  rows="2" style="height:auto"></textarea>
                            </div>
                        </div>                  
                    </div>
                </div>   
            </div>
        </div>            
    </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-md-12">
            <div class="panel panel-default credit-card-box">
                <div class="panel-heading display-table" >
                    <div class="row display-tr" >
                    <h3 class="display-td" style="text-align:left" >Others</h3>
                        
                    </div>                    
                </div>
                <div class="panel-body col-md-6">
                    <div class="panel panel-default">
                    <div class="panel-body form-horizontal">
                        <div class="form-group">
                            <label for="email" class="col-sm-3 control-label">Special Needs</label>
                            <div class="col-sm-9 left" style="text-align:left">
                                <input type="checkbox" name="Special_Needs__c" value="true">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-sm-3 control-label">To Specify If Ticked</label>
                            <div class="col-sm-9">
                                <textarea id="To_Specify_If_Ticked_SN__c" name="To_Specify_If_Ticked_SN__c" class="form-control"  rows="2" style="height:auto"></textarea>
                            </div>
                        </div>
                    </div>
                </div>   
            </div>
        </div>
    </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-md-12">
            <div class="panel panel-default credit-card-box">
                <div class="panel-heading display-table" >
                    <div class="row display-tr" >
                    <h3 class="display-td" style="text-align:left" >System Information</h3>
                        
                    </div>                    
                </div>
                <div class="panel-body col-md-6">
                    <div class="panel panel-default">
                    <div class="panel-body form-horizontal">
                        <div class="form-group">
                            <label for="email" class="col-sm-3 control-label">Additional Remarks</label>
                            <div class="col-sm-9">
                                <textarea id="Additional_Remarks__c" name="Additional_Remarks__c" class="form-control"  rows="2" style="height:auto"></textarea>
                            </div>
                        </div>
                    </div>
                </div>   
            </div>
        </div>
    </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-md-12">
            <div class="panel panel-default credit-card-box">
                <div class="panel-heading display-table" >
                    <div class="row display-tr" >
                    <h3 class="display-td" style="text-align:left" >Details of Referring Agency</h3>
                        
                    </div>                    
                </div>
                <div class="panel-body col-md-6">
                    <div class="panel panel-default">
                    <div class="panel-body form-horizontal">
                        <div class="form-group">
                            <label for="name" class="col-sm-3 control-label">Name of Referring Agency</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="" id="Name_of_Referring_Agency__c" name="Name_of_Referring_Agency__c" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-sm-3 control-label">Name of Referring Staff</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="" id="Name_of_Referring_Staff__c" name="Name_of_Referring_Staff__c" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-sm-3 control-label">Designation</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="" id="Designation__c" name="Designation__c" >
                            </div>
                        </div>
                        
                    </div>
                </div>   
            </div>

            <div class="panel-body col-md-6">
                <div class="panel panel-default">
                    <div class="panel-body form-horizontal">
                        <div class="form-group">
                            <label for="name" class="col-sm-3 control-label">Contact Number</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="" id="Contact_Number_Referring_Agency__c" name="Contact_Number_Referring_Agency__c" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-sm-3 control-label">Email</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="" id="Email_Referring_Agency__c" name="Email_Referring_Agency__c" >
                            </div>
                        </div>                  
                    </div>
                </div>   
            </div>
        </div>            
    </div>
    </div>
      
    <div class="row">
        <div class="col-md-12">
            <input type="hidden" name="referral_token" value="<?=$referral_token?>" />
            <br />
            <button class="btn btn-success btn-lg btn-block" type="submit">Submit</button>
            <br />
        </div>
    </div>
	</div>
    </form>
	<div class="modal fade loading-modal-sm" id="myPleaseWait" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        <span class="glyphicon glyphicon-time">
                        </span> Please Wait, do not close or refresh the page
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="progress">
                        <div class="progress-bar progress-bar-info progress-bar-striped active" style="width: 100%">
                            Processing..
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Javascript -->
    <script src="assets/js/jquery-1.11.1.min.js"></script>
    <script src="assets/js/jquery-ui.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.backstretch.min.js"></script>
    <script src="assets/js/retina-1.1.0.min.js"></script>
    <script src="assets/js/highlight.js"></script>
	<script src="assets/js/bootstrap-switch.js"></script>
    <script src="assets/js/scripts.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script> 


    <!-- Required - Custom select -->
    <script src="js/jquery.maskedinput.min.js" type="text/javascript"></script>

    <script language="javascript">
        function closeModal() {
            setTimeout(function () {
                $('#myPleaseWait').modal('hide');
            }, 2000);
        }
        $.formUtils.addValidator({
            name: 'minimum_donation',
            validatorFunction: function (value, $el, config, language, $form) {
                return (parseInt(value) > 0);
            },
            errorMessage: 'Donation amount is not valid',
            errorMessageKey: 'badMinumumDanation'
        });
        $.formUtils.addValidator({
            name: 'expired_date',
            validatorFunction: function (value, $el, config, language, $form) {
                var today = new Date();
                var thisYear = today.getFullYear();
                var exp = value.split("/");
                var expMonth = parseInt(exp[0]);
                var expYear = parseInt(exp[1]);

                return (expMonth >= 1
                        && expMonth <= 12
                        && (expYear >= thisYear && expYear < thisYear + 20)
                        && (expYear == thisYear ? expMonth >= (today.getMonth() + 1) : true))

            },
            errorMessage: 'Credit card expiry date is not valid',
            errorMessageKey: 'badExpiredDate'
        });
        $.formUtils.addValidator({
            name: 'nirc_check',
            validatorFunction: function (str, $el, config, language, $form) {
                if (str.length != 9)
                    return false;

                str = str.toUpperCase();

                var i,
                        icArray = [];
                for (i = 0; i < 9; i++) {
                    icArray[i] = str.charAt(i);
                }

                icArray[1] = parseInt(icArray[1], 10) * 2;
                icArray[2] = parseInt(icArray[2], 10) * 7;
                icArray[3] = parseInt(icArray[3], 10) * 6;
                icArray[4] = parseInt(icArray[4], 10) * 5;
                icArray[5] = parseInt(icArray[5], 10) * 4;
                icArray[6] = parseInt(icArray[6], 10) * 3;
                icArray[7] = parseInt(icArray[7], 10) * 2;

                var weight = 0;
                for (i = 1; i < 8; i++) {
                    weight += icArray[i];
                }

                var offset = (icArray[0] == "T" || icArray[0] == "G") ? 4 : 0;
                var temp = (offset + weight) % 11;

                var st = ["J", "Z", "I", "H", "G", "F", "E", "D", "C", "B", "A"];
                var fg = ["X", "W", "U", "T", "R", "Q", "P", "N", "M", "L", "K"];

                var theAlpha;
                if (icArray[0] == "S" || icArray[0] == "T") {
                    theAlpha = st[temp];
                } else if (icArray[0] == "F" || icArray[0] == "G") {
                    theAlpha = fg[temp];
                }

                return (icArray[8] === theAlpha);
            },
            errorMessage: 'ID number is not valid',
            errorMessageKey: 'badNircCheck'
        });
        $.validate({
            modules: 'security, logic',
            errorMessagePosition: 'top',
            validateOnBlur: false,
            onError: function ($form) {
                $('.form-error').prepend('<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>').addClass('alert-dismissible');
                closeModal();
            },
            onValidate: function ($form) {
                $('#myPleaseWait').modal('show');
            },
        });
        $(document).ready(function () {
            $("#cc_expiry").mask("99/2099");
            $('#cc_num').keyup(function() {
                ccvalue = $(this).val();
                if (ccvalue.match(/^4/)) {
                    $('#visa-icon').removeClass("hidden");
                    if(!$('#master-icon').hasClass("hidden")) $('#master-icon').addClass("hidden");
                } else if(ccvalue.match(/^5[1-5]/)) {
                    $('#master-icon').removeClass("hidden");
                    if(!$('#visa-icon').hasClass("hidden")) $('#visa-icon').addClass("hidden");
                } else {
                    if(!$('#visa-icon').hasClass("hidden")) $('#visa-icon').addClass("hidden");
                    if(!$('#master-icon').hasClass("hidden")) $('#master-icon').addClass("hidden");
                }
            })
            $('#myPleaseWait').modal({
                keyboard: false,
                backdrop: 'static',
                show: false
              })
            $('input[type=radio][name=amount]').change(function () {
                $('#other-amount').val($(this).val());
                if ($(this).val() == '')
                    $('#other-amount').focus();
            });
            $('#amount').change(function () {
                otherVal = parseInt($(this).val());
                if(!isNaN(otherVal)) $(this).val(otherVal);
                if (otherVal == 10)
                    $("#radio-amt-1").prop("checked", true);
                else if (otherVal == 20)
                    $("#radio-amt-2").prop("checked", true);
                else if (otherVal == 30)
                    $("#radio-amt-3").prop("checked", true);
                else if (otherVal == 50)
                    $("#radio-amt-4").prop("checked", true);
                else if (otherVal == 100)
                    $("#radio-amt-5").prop("checked", true);
                else {
                    $("#radio-amt-6").prop("checked", true);
                }
            });
            $('.remove').click(function () {
                $(this).closest('div').slideUp('slow', function () {
                    $(this).remove();
                });
            });

            var donation_purpose = ($('#donation_purpose').val());
            if(donation_purpose == 'Others'){
                $('#div_other_purpose').val('');
                $('#div_other_purpose').slideDown();
            } else{
                $('#div_other_purpose').slideUp();
            }
            
        });
    </script>
    
    <!--[if lt IE 10]>
        <script src="assets/js/placeholder.js"></script>
    <![endif]-->

    </body>

</html>
