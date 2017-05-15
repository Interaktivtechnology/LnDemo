<?php 
session_start();
include_once('sf.php');
error_reporting(E_ERROR);
?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Breast Cancer Foundation</title>

        <!-- CSS -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="assets/css/form-elements.css">
		<link href="assets/css/highlight.css" rel="stylesheet">
    	<link href="assets/css/bootstrap-switch.css" rel="stylesheet">
        <link rel="stylesheet" href="assets/css/style.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="assets/ico/favicon.ico">
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
        </style>
    </head>

    <body>
    
	<div class="container center_div">
		<div class="row">
			<div class="col-xs-12 col-md-12">
			<!-- CREDIT CARD FORM STARTS HERE -->
				<div class="panel panel-default credit-card-box">
					<div class="panel-heading display-table" >
						<div class="row display-tr" >
						<h3 class="display-td" style="text-align:left" >Send Email Invitation</h3>
							
						</div>                    
					</div>
					<div class="panel-body">
					<form role="form" method="post" id="payment-form" action="send">
 <div class="panel panel-default">
                <div class="panel-body form-horizontal payment-form">
                    <div class="form-group">
                        <label for="id_no" class="col-sm-3 control-label">Contact ID Number</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="id_no" name="id_no" required="">
                        </div>
                    </div> 
                    <div class="form-group">
                        <label for="event_id" class="col-sm-3 control-label">Event ID Number</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="event_id" name="event_id" required="">
                        </div>
                    </div> 
                    <div class="form-group">
                        <label for="text" class="col-sm-3 control-label">Text</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="text" name="text" required="">
                        </div>
                    </div> 
                   

					<div class="row">
						<div class="col-md-12">
						<button class="btn btn-success btn-lg btn-block" type="submit">Send Invitation</button>
						</div>
					</div>
                   
                </div>
            </div>            
					</form>
				</div>
			</div>            
		</div>            

		
	</div>
	</div>

    <!-- Javascript -->
    <script src="assets/js/jquery-1.11.1.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.backstretch.min.js"></script>
    <script src="assets/js/retina-1.1.0.min.js"></script>
    <script src="assets/js/highlight.js"></script>
	<script src="assets/js/bootstrap-switch.js"></script>
    <script src="assets/js/scripts.js"></script>
    
    <!--[if lt IE 10]>
        <script src="assets/js/placeholder.js"></script>
    <![endif]-->

    </body>

</html>