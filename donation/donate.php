<?php 
session_start();

$donation_token = uniqid();

/*** add the donation token to the session ***/

$_SESSION['donation_token'] = $donation_token;

error_reporting(E_ALL);

?>

<?php
   /**
   
   * The template for displaying all pages
   
   *
   
   * This is the template that displays all pages by default.
   
   * Please note that this is the WordPress construct of pages and that
   
   * other 'pages' on your WordPress site will use a different template.
   
   *
   
   * @package WordPress
   
   * @subpackage Twenty_Fourteen
   
   * @since Twenty Fourteen 1.0
   
   */
   
   //get_header(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div id="main-content">
   <?php
    /*
      if ( is_front_page() && twentyfourteen_has_featured_posts() ) {
      
      	// Include the featured content template.
      
      	get_template_part( 'featured-content' );
      
      }
      */
      ?>
   <div id="primary" class="content-area">
      <div id="content" class="site-content pink-content" role="main">
        
         
            
      </div>
      <!-- #content -->
   </div>
   <!-- #primary -->
</div>
<!-- #main-content -->
<div style="">
   <div id="donate-pop">
      <h4>DONATE</h4>
      <!--<p>Sign up for our membership now and never miss out on our latest news and events.</p>-->
      <?php //echo do_shortcode('[newsletter_form][newsletter_field name="first_name" label="Full name"][newsletter_field name="email"][/newsletter_form]') ?>
      <?php //echo do_shortcode('[contact-form-7 id="776" title="Donate"]') ?>

      <?php 

        if(isset($_SESSION['error_message'])){

          echo '<p><b>Error message:</b></p><ul>';

          foreach ($_SESSION['error_message'] as $error ) {

            echo '<li>'.$error.'</li>';

          }

          echo '</ul>';

        }

      ?>

	<form role="form" id="payment-form" method="post" action="process.php">
        <div class="panel panel-default">
           <div class="panel-body form-horizontal payment-form">
              <div class="form-group">
                 <label for="name" class="col-sm-3 control-label">Name</label>
                 <div class="col-sm-9">
                    <input type="text" class="form-control" value="<?php if(isset($_GET['name'])) echo $_GET['name'] ?>" id="name" name="name" required autofocus>
                 </div>
                 <div class="clear"></div>
              </div>
              <div class="form-group">
                 <label for="id_no" class="col-sm-3 control-label">ID Number</label>
                 <div class="col-sm-9">
                    <input type="text" class="form-control" maxlength="9" id="id_no" name="id_no" value="<?php if(isset($_GET['idno'])) echo $_GET['idno'] ?>" >
                 </div>
                 <div class="clear"></div>
              </div>
              <div class="form-group">
                 <label for="id_no" class="col-sm-3 control-label">ID Type</label>
                 <div class="col-sm-9">
                    <select class=" select" id="id_type" name="id_type" required="">
                       <option value="N/A" selected="selected">N/A</option>
                       <option value="nric">NRIC</option>
                       <option value="fin">FIN</option>
                    </select>
                 </div>
                 <div class="clear"></div>
              </div>
              <div class="form-group">
                 <label for="email" class="col-sm-3 control-label">Email</label>
                 <div class="col-sm-9">
                    <input type="email" class="form-control" maxlength="30" value="<?php if(isset($_GET['email'])) echo $_GET['email'] ?>"  id="email" name="email" required="" data-validation="email">
                 </div>
                 <div class="clear"></div>
              </div>
              <div class="form-group">
                 <label for="amount" class="col-sm-6 control-label">I wish to donate</label>
                 <div class="col-sm-6">
                    <div class="input-group ">
                       <span class="input-group-addon">SGD</span>    
                       <input type="text" class="form-control" id="amount" value="<?php if(isset($_GET['amount'])) echo $_GET['amount'] ?>" name="amount" required="" data-validation="minimum_donation">
                    </div>
                 </div>
                 <div class="clear"></div>
              </div>
              <div class="row">
                 <div class="col-md-12">
                    <input type="hidden" name="donation_token" value="<?=$donation_token?>" />
                    <input type="hidden" name="phone" value="<?php if(isset($_GET['phone'])) echo $_GET['phone'] ?>" />
                    <input type="hidden" name="leadsource" value="<?php if(isset($_GET['leadsource'])) echo $_GET['leadsource'] ?>" />
                    <input type="hidden" name="channel" value="<?php if(isset($_GET['channel'])) echo $_GET['channel'] ?>" />
                   
                    <button class="btn btn-success btn-lg btn-block" type="submit" id="submit">Make Donation</button>
                    <p class="smalltext">
                    <center>Note : for donations over $50, please provide ID Number to enjoy Tax-Exemption</center>
                    </p>
                 </div>
              </div>
           </div>
        </div>
     </form>

   </div>
</div>
<script type="text/javascript">
   jQuery(document).ready(function(){

    var id_type = $('#id_type').val();

    //set validation for id_type
    if(id_type == 'N/A'){
      $("#id_no").prop('required',false);
      $("#id_no").attr('data-validation','');
    }
    else{
      $("#id_no").prop('required',true);
      $("#id_no").attr('data-validation','nirc_check');
    }
        function validateNRIC(str) {

      if (str.length != 9) 

          return false;



      str = str.toUpperCase();



      var i, 

          icArray = [];

      for(i = 0; i < 9; i++) {

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

      for(i = 1; i < 8; i++) {

          weight += icArray[i];

      }



      var offset = (icArray[0] == "T" || icArray[0] == "G") ? 4:0;

      var temp = (offset + weight) % 11;



      var st = ["J","Z","I","H","G","F","E","D","C","B","A"];

      var fg = ["X","W","U","T","R","Q","P","N","M","L","K"];



      var theAlpha;

      if (icArray[0] == "S" || icArray[0] == "T") { theAlpha = st[temp]; }

      else if (icArray[0] == "F" || icArray[0] == "G") { theAlpha = fg[temp]; }



      return (icArray[8] === theAlpha);

    }

    $('#id_type').on('change', function() {
      if(this.value == 'N/A'){
         $("#id_no").prop('required',false);
         $("#id_no").attr('data-validation','');
        }
        else{
          $("#id_no").prop('required',true);
          $("#id_no").attr('data-validation','nirc_check');
        }
    });

    jQuery('#submit').on('click',function(e){

        jQuery('#inputmember').val('1');

        if( jQuery('#id_no').val()) {


            var validNRIC = validateNRIC(jQuery('#id_no').val());

            if(validNRIC != true){

            alert('NRIC is invalid');

            return false;

            }

          }

          else{

            var id_type =  $('#id_type').val();
            if(id_type != 'N/A'){
              alert('NRIC is required');

              return false;
            }
            
          }

        /*

        if ($("#btn-member").hasClass("btn-top-active")) {

            $('#inputmember').val('1');

        }

        else{

            $('#inputmember').val('');

        }

        /*

        if ($("#btn-volunteer").hasClass("btn-top-active")) {

            $('#inputvolunteer').val('1');

        }

        else{

            $('#inputvolunteer').val('');

        }

        */

        var error = 'success';

        jQuery('.registration-form').find('.required').each(function() {

            if( jQuery(this).val() == "" ) {

                //alert($(this).attr('id'));

                e.preventDefault();

                jQuery(this).addClass('input-error');

                var error = 'error';

            }

            else {

                jQuery(this).removeClass('input-error');

                //$('.registration-form').submit();

            }

        });

        if(error == 'success'){

             jQuery('.registration-form').submit();

        }

        else{

            alert('Error found');

        }

    })
  })

</script>
</body>
</html>