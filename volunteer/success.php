<?php
session_start();
?>
<!doctype html>
<html lang="en-US">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no" />
		<title>Breast Cancer Foundation - Success</title>
		

        <!-- CSS -->
        <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="assets/css/form-elements.css">
		<link href="assets/css/highlight.css" rel="stylesheet">
    	<link href="assets/css/bootstrap-switch.css" rel="stylesheet">
        <link rel="stylesheet" href="assets/css/style.css">

   		
	<style>
		html{
					background: #FFF;
		}
		body {
			padding-top: 50px;
			font-size: 16px;
			font-family: "Open Sans",serif;
			background: transparent;
		}

		h1 {
			font-family: "Abel", Arial, sans-serif;
			font-weight: 400;
			font-size: 40px;
		}

		/* Override B3 .panel adding a subtly transparent background */
		.panel {
			background-color: rgba(255, 255, 255, 0.9);
		}

		.margin-base-vertical {
			margin: 40px 0;
		}
		nav{
			top:-50px;
			position: absolute;
		}

	</style>

</head>
<body>

	<div class="container">
		<nav role="navigation" class="navbar navbar-inverse navbar-no-bg">
			<div class="container main">
				<div class="navbar-header">
					<button data-target="#top-navbar-1" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a href="index" class="navbar-brand">Breast Cancer Foundation</a>
				</div>
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div id="top-navbar-1" class="collapse navbar-collapse">
					<ul class="nav navbar-nav navbar-right">
						
					</ul>
				</div>
			</div>
		</nav>
		<div class="row">
			<div class="col-md-6 col-md-offset-3 panel panel-default">
			<br />
				<center>
					<img src="assets/img//thank-you-circle.png" width="200px"/>
				</center>
				<p>
					Thank you for volunteering with Breast Cancer Foundation! 
				</p>
				<p>
					 We will be in touch with you soon
				</p>
				

				<p class="text-center">
					<a href="index.php">
					<button type="submit" class="btn btn-success btn-lg">Click here to go back to our Home Page</button>
					</a>
				</p>
				<br />
			</div>
		</div>
	</div>
		<!-- Required - jQuery -->
		<script src="js/jquery-2.1.1.min.js"></script>
  		<script type="text/javascript" src="js/jquery-ui.js"></script>		
  		<!-- Required - Bootstrap JS -->
		<script src="js/bootstrap.min.js"></script>
		


	</body>
</html>