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
        <title>InterAktiv Foundation</title>

        <!-- CSS -->
        <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:400,100,300,500">
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

    </head>

    <body>
		

        <!-- Top content -->
        <div class="top-content">
        	
            <div class="inner-bg">
                <div class="container">
                    
                    <div class="row" style="margin-top: -50px">
                        <div class="col-sm-9 col-sm-offset-1 form-box">
                        	
                        	<form role="form" action="process.php" method="post" class="registration-form update2">
                        		<div class="col-sm-12" style="background: #EEEEEE;border:25px solid #fff">
                        		<div class="col-sm-6 nopadding">
	                        		<fieldset>
			                        	<br />
			                            <div class="form-bottom">
			                           
			                            	<div class="form-group">
					                    		<label class="sr-only" for="form-nric">NRIC/FIN/Passport Number</label>
					                        	<input type="text" name="form-nric" placeholder="NRIC/FIN/Passport Number..." class="form-first-name form-control required" value="<?php if(isset($_GET['id_no'])){ echo $_GET['id_no']; } ?>" id="form-nric" required>
					                        </div>
					                        <div class="form-group">
					                    		<label class="sr-only" for="form-id-type">NRIC/FIN/Passport Number</label>
					                        	<select class="form-control required select" id="form-id-type" name="form-id-type" required>
					                        		<option value="">ID Type</option>
	                                                <option value="NRIC">NRIC</option>
	                                                <option value="FIN">FIN</option>
	                                                <option value="N/A">N/A</option>
                                                </select>
					                        </div>
					                    	<div class="form-group">
					                    		<label class="sr-only" for="form-first-name">First name</label>
					                        	<input type="text" name="form-first-name" placeholder="Full Name as in NRIC" class="form-first-name form-control required" value="<?php if(isset($_GET['name'])){ echo $_GET['name']; } ?>"  id="form-first-name">
					                        </div>
					                        <div class="form-group" style="display:none">
					                        	<label class="sr-only" for="form-last-name">Last name</label>
					                        	<input type="text" name="form-last-name" placeholder="Last name..." class="form-last-name form-control" id="form-last-name">
					                        </div>
					                        <div class="form-group">
					                        	<label class="sr-only" for="form-preferred-name">Preferred Name</label>
					                        	<input type="text" name="form-preferred-name" placeholder="Preferred name..." class="form-last-name form-control" id="form-preferred-name">
					                        </div>
					                        <div class="form-group">
					                        	<label class="sr-only" for="form-email">Email Address</label>
					                        	<input type="text" name="form-email" placeholder="Email Address..." class="form-email form-control required" id="form-email" value="<?php if(isset($_GET['email'])){ echo $_GET['email']; } ?>" >
					                        </div>

					                        <div class="row">
							                        <div class="form-group col-md-6">
							                        	<label class="sr-only" for="form-birth-year">Date of Birth</label>
							                        	<input type="text" name="form-birth-year" placeholder="Date of Birth" class="form-last-name form-control " id="form-birth-year" required="" pattern="\d{1,2}/\d{1,2}/\d{4}">
							                         </div>
						                        	 <div class="form-group col-md-6">
							                        	<label class="sr-only" for="form-phone">Phone No.</label>
							                        	<input type="text" name="form-phone" placeholder="Phone No." class="form-last-name form-control" id="form-phone" value="<?php if(isset($_GET['phone'])){ echo $_GET['phone']; } ?>" >
						                        	</div>
						                        </div>

						                        <div class="row">
							                        <div class="form-group col-md-6">
						                        		<label class="sr-only" for="form-gender">Gender</label>
														<select class="form-control select required="" " id="form-gender" name="form-gender" required>
														    <option selected="selected" value="">Gender</option>
														    <option value="Male">Male</option>
														    <option value="Female">Female</option>
													  	</select>
													</div>
						                        	<div class="form-group col-md-6">
							                        	<label class="sr-only" for="form-postal-code">Postal Code</label>
							                        	<input type="text" name="form-postal-code" placeholder="Postal Code..." class="form-last-name form-control " id="form-postal-code" required>
						                        	</div>
						                        </div>

					                        <div class="form-group">
					                        	<label class="sr-only" for="form-category">Membership Category</label>
					                        	<?php
																		$issueOpt = array("class"=>"custom-select form-control required select","name"=>"form-category","id"=>"form-category");
																		echo str_replace('><', '>Membership Category<', SelectList($mySforceConnection, 'Contact', 'Membership_Category__c', 'How',$issueOpt));
																		?>
					                        </div>

					                        <div class="form-group">
					                        	<label class="sr-only" for="form-know">I got to know about Interaktiv Foundation's' membership via:</label>
					                        	
																	<?php
																		$issueOpt = array("class"=>"custom-select form-control required select","name"=>"form-via","id"=>"form-via");
																		echo str_replace('><', '>I got to know about Interaktiv Foundation\'s membership via:<', SelectList($mySforceConnection, 'Contact', 'How_I_know_BCF_Membership__c', 'Know',$issueOpt));
																	?>
					                        </div>

					                     	<div class="form-group">
					                        	<label class="checkbox-inline"><input type="checkbox" class="required" value="agree" id="agree" name="agree"><p>I agree to the <a href="#" class="tos">terms & conditions</a> and <a href="volunteer.pdf" class="" target="_blank">Secrery Agreement</a>  of this sign up</p></label>
					                        </div>
					                        <button type="submit" class="btn" id="submit">Sign me up!</button>

					                        
					                    </div>
				                    </fieldset> 
			                    </div>
			                    <div class="col-sm-6 nopadding">
				                    <fieldset>
			                        	<br />
			                            <div class="form-bottom">
			                            	<div class="devRight right1">
						                        					                         
						                        <div class="form-group">
						                        	<label class="sr-only" for="form-address">Mailing Address</label>
						                        	<textarea name="form-about-address" placeholder="Mailing Address..." 
						                        	class="form-address form-control " id="form-about-yourself" required></textarea>
						                        </div>
						                    </div>


				                       	<div class="devRight right2">
					                        <div class="form-group">
						                    	<textarea name="form-why" placeholder="Why are you interested in volunteering with Interaktiv Foundation?" class="form-last-name form-control "></textarea> 
						                    </div>
					                       

					                        <div class="form-group">
					                        	<select class="form-control select" id="race" name="form-have">
												    <option selected="selected ">Have you volunteered with Interaktiv Foundation before?                </option>
												    <option value="Yes">Yes (Please Specify)</option>
												    <option value="no">No</option>
												    
												  </select>
					                        </div>
					                        <div class="form-group" id="div_other_race" style="display: none">
					                        	<input type="text" name="form-have-role" placeholder="Role" class="form-role-name form-control" id="form-role-name">
					                        	<input type="text" name="form-have-period" placeholder="Period of volunteering" class="form-role-name form-control" id="form-role-name" style="margin-top:10px">
					                        </div>

					                        <div class="form-group">
					                        	<select class="form-control  select" id="race2" name="form-org">
												    <option selected="selected">Do you volunteer with other organisations?                          </option>
												    <option value="Yes">Yes (Please Specify)</option>
												    <option value="no">No</option>
												    
												  </select>
					                        </div>
					                        <div class="form-group" id="div_other_race2" style="display: none">
					                        	<input type="text" name="form-org-name" placeholder="Name of Organisation " class="form-role-name form-control" id="form-role-name" >
					                        	<input type="text" name="form-org-role" placeholder="Role" class="form-role-name form-control" id="form-role-name" style="margin-top:10px">
					                        	<input type="text" name="form-org-period" placeholder="Period of volunteering" class="form-role-name form-control" id="form-role-name" style="margin-top:10px">
					                        </div>

					                        <div class="form-group">
						                        	
						                        	<textarea name="form-qualities" placeholder="What qualities and /or skills can you contribute to Interaktiv Foundation Volunteer Programme? " class="form-last-name form-control " ></textarea> 
						                     </div>

						                     <input type="hidden" name="inputmember" id="inputmember"/>
						                     <input type="hidden" name="inputvolunteer" id="inputvolunteer"/>
						                     <input type="hidden" name="msource" id="msource" value="<?php if(isset($_GET['msource'])){ echo $_GET['msource']; } ?>"/>
						                     <input type="hidden" name="vsource" id="vsource" value="<?php if(isset($_GET['vsource'])){ echo $_GET['vsource']; } ?>"/>

						                </div>
				                        
					                    </div>
				                    </fieldset>
			                    </div>
			                    </div>
		                    
		                    </form>
		                    <br />
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="myModalLabel">Terms and conditions</h4>
		      </div>
		      <div class="modal-body">
		      	<p>
		      	I hereby undertake and agree to the following:
		      	</p>
		      	<p>
				1.	My participation in any event or activity organised, facilitated or supported by Interaktiv Foundation or any of its officers, employees, agents, volunteers, partners or sponsors (together, the “Interaktiv FoundationParties”), or any event or activity organised for or on behalf of Interaktiv Foundation by any third parties, or any activities carried out together with any Interaktiv Foundation Parties, or activities carried out for the benefit, or with the knowledge, consent or endorsement, of Interaktiv Foundation, including any classes, seminars, conferences, sessions, meetings and fund-raising activities, in each case whether or not carried out in Interaktiv Foundation’s premises (together, “Interaktiv Foundation Activities”), is solely at my own risk.
			 	</p>
			 	<p>
				2.	I hereby absolve, acquit and discharge the Interaktiv Foundation Parties from any and all responsibility and liability whatsoever caused by or sustained by me or affecting my personal belongings, as a result of my participation in any Interaktiv Foundation Activities, including, without limitation and only to the extent permissible by law, physical injury, loss of life or property damage. 
				</p>
				<p>
				3.	I will indemnify and keep indemnified, and will save and hold harmless all Interaktiv Foundation Parties against all claims, demands, actions, proceedings, damages, liabilities, losses, costs and expenses (including legal fees) arising in any way from my participation in the Interaktiv Foundation Activities. 
				</p>
			

		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default  btn-disagree" data-dismiss="modal">Close</button>
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
        
        <!--[if lt IE 10]>
            <script src="assets/js/placeholder.js"></script>
        <![endif]-->

    </body>

</html>
