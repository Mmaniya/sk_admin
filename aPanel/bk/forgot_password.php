<?php 
include 'includes.php';
 
 
?>

<!DOCTYPE html>
<html>    
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="assets/images/logo.png">
        <title>Login | Bizplan Easy</title>
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
        <link href="assets/css/style.css" rel="stylesheet" type="text/css">
        <script src="assets/js/modernizr.min.js"></script>
		<script src="assets/js/jquery.min.js"></script>
		<script src="assets/js/default.js"></script>
    </head>
    <body>
        <div class="wrapper-page">
		<!--
<div class="alert alert-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true" style="margin-right:1em"></i>Email address not found</div>

<div class="alert alert-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true" style="margin-right:1em"></i>Email address not found</div>
-->

            <div class="text-center">
               <a href="index.php" class="logo-lg"><img src="assets/images/logo.png" alt="logo"/></a>
            </div><div class="error_class"></div> <br/> 
          <p> <strong>Forgot Password </strong></p>
		  <p>Please enter your email address to restore your password. </p>


            <form method="post" action="#" role="form" class="text-center m-t-20">
               <!-- <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    Enter your <b>Email</b> and instructions will be sent to you!
                </div>--->
                <div class="form-group m-b-0">
                    <div class="input-group">
                        <input type="email" class="form-control" placeholder="Enter Email" id="email_address">
                        <!--<span class="input-group-append"> <button type="submit" class="btn btn-primary waves-effect waves-light">Reset</button> </span>-->
				   </div>
                </div> 
				
				 <div class="form-group m-b-0">
                    <div class="input-group">
                        <button type="submit" class="btn btn-warning waves-effect waves-light">Reset Password</button> 
                    </div>
                </div> 
            </form> <br/> 
            
        </div>
<script> var resizefunc = [];
$(document).ready(function() {  
  $('form').on('submit', function(e){
	   e.preventDefault();
	  send_verify_email();
	  });
	  });

function send_verify_email() {
	var err = 0;
	if(	$('#email_address').val()=='' ){ err=1; $('#email_address').css("border","1px solid #fb0b0cf7") } else 
	{ $('#email_address').css("border",""); var email_address = $('#email_address').val(); }
		 
	
	if(err==0){ 	
	 	var paramData = {'act':'forgot_password','email_address':email_address } 	
		ajax({ 
			a:'process',
			b:$.param(paramData),
			c:function(){},
			d:function(data){                 					
			   $('.error_class').html(data);	
               $('#email_address').val('');			   
			 } 
			}); 
		} }
		</script>
 <style>.boxred { border:1px solid #e9570e !important; } .error_class { color:#ff0000; text-center;} .wrapper-page { max-width: 400px;}

@media screen and (max-width: 768px) { .wrapper-page {  max-width: 360px; } }</style>
 <!-- Plugins  -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/popper.min.js"></script><!-- Popper for Bootstrap -->
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/detect.js"></script>
        <script src="assets/js/fastclick.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/jquery.blockUI.js"></script>
        <script src="assets/js/waves.js"></script>
        <script src="assets/js/wow.min.js"></script>
        <script src="assets/js/jquery.nicescroll.js"></script>
        <script src="assets/js/jquery.scrollTo.min.js"></script>
          <!-- Custom main Js -->
        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>
	
	</body>
</html>