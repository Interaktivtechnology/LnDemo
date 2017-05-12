<?php 
session_start();
$donation_token = uniqid();
/*** add the donation token to the session ***/
$_SESSION['donation_token'] = $donation_token;
error_reporting(E_ERROR);
?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>InterAktiv Foundation</title>

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
        .smalltext{
            font-size: 12px;
            color: #ccc;
            text-align: center;
        }
        </style>
    </head>

    <body>
    
	<div class="container center_div">
		<div class="row">
			<div class="col-xs-12 col-md-6">
			<!-- CREDIT CARD FORM STARTS HERE -->
				<div class="panel panel-default credit-card-box">
					<div class="panel-heading display-table" >
						<div class="row display-tr" >
						<h3 class="display-td" style="text-align:left" >Making Donation</h3>
							
						</div>                    
					</div>
					<div class="panel-body">
					<form role="form" id="payment-form" method="post" action="process.php">
						 <div class="panel panel-default">
                            <br />
						                <div class="panel-body form-horizontal payment-form">
						                    <div class="form-group">
						                        <label for="name" class="col-sm-3 control-label">Name</label>
						                        <div class="col-sm-9">
						                            <input type="text" class="form-control" value="<?php if(isset($_GET['name'])) echo $_GET['name'] ?>" id="name" name="name" required autofocus>
						                        </div>
						                    </div>
						                    
						                    <div class="form-group">
						                        <label for="id_no" class="col-sm-3 control-label">ID Number</label>
						                        <div class="col-sm-9">
						                            <input type="text" class="form-control" maxlength="9" id="id_no" name="id_no" value="<?php if(isset($_GET['idno'])) echo $_GET['idno'] ?>" >
						                        </div>
						                    </div>

                                            <div class="form-group">
                                                <label for="id_no" class="col-sm-3 control-label">ID Type</label>
                                                <div class="col-sm-9">
                                                    <select class=" select" id="id_type" name="id_type" required="">
                                                     <option value="N/A"  <?php if(!isset($_GET['idno'])) echo 'selected="selected"' ;?>>N/A</option>
                                                    <option value="nric" <?php if(isset($_GET['idno'])) echo 'selected="selected"' ;?> >NRIC</option>
                                                    <option value="fin">FIN</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
						                    <div class="form-group">
						                        <label for="email" class="col-sm-3 control-label">Email</label>
						                        <div class="col-sm-9">
						                            <input type="text" class="form-control" maxlength="30" value="<?php if(isset($_GET['email'])) echo $_GET['email'] ?>"  id="email" name="email" required="" data-validation="email">
						                        </div>
						                    </div>
						                    <div class="form-group">
						                        <label for="amount" class="col-sm-6 control-label">I wish to donate</label>
						                        <div class="col-sm-6">
                                                    <div class="input-group ">
                                                        <span class="input-group-addon">SGD</span>    
                                                         <input type="text" class="form-control" id="amount" value="<?php if(isset($_GET['amount'])) echo $_GET['amount'] ?>" name="amount" required="" data-validation="minimum_donation">
                                                    </div>
                                                   
						                            
						                        </div>
						                    </div> 

											<div class="row">
												<div class="col-md-12">
												<input type="hidden" name="donation_token" value="<?=$donation_token?>" />
                                                <input type="hidden" name="phone" value="<?php if(isset($_GET['phone'])) echo $_GET['phone'] ?>" />
                                                <input type="hidden" name="leadsource" value="<?php if(isset($_GET['leadsource'])) echo $_GET['leadsource'] ?>" />
                                                <input type="hidden" name="channel" value="<?php if(isset($_GET['channel'])) echo $_GET['channel'] ?>" />
                                                <br />
                                                <br />
												<button class="btn btn-success btn-lg btn-block" type="submit">Make Donation</button>
                                                <p class="smalltext"><center>Note : for donations over $50, please provide ID Number to enjoy Tax-Exemption</center></p>
												</div>
											</div>
						                   
						                </div>
						            </div>            

					</form>
				</div>
			</div>            
		</div>            

		<div class="col-xs-12 col-md-6">
			    <img src="http://www.publicdomainpictures.net/pictures/170000/velka/holding-hands-1463700055riT.jpg" height="300px" width="550px"/>
			 <div class="row" style="border-top:1px solid #CCC;margin-top:10px" style="text-align:left;clear:both">
			 	<h1>Contact Us</h1>
                <br />
			 	<p>
			 	
			 	<img src="images/logo.jpg" style="" width="100px" />
			 	</p>
                <p>Mr Richard</p>
			 	<p>
			 	Tel: 111111<br />
			 	Fax: 111111<br />
			 	Email: donation@interaktiv.sg
			 	</p>
			 	<p style="display:none">
			 	Facebook<br />
			 	Twitter
			 	</p>
			 </div>
		</div>    

	</div>
	</div>

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
