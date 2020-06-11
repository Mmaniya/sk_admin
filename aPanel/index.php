<?php
session_start();
require("includes.php");
 
 if($_POST['act']=='login') {
   $postVar = array('username','password');  
   foreach($postVar as $K=>$V) $$V=check_input($_POST[$V]);
   $returnArr = Users::checkCredentials($username,$password);
   if(count($returnArr)>1) {
	 $rsUser = $returnArr[1];
	 $_SESSION['user_id']=$rsUser->id;
	 $_SESSION['name']=$rsUser->contact_fname.' '.$rsUser->contact_lname;
	 $_SESSION['username']=$rsUser->username;
	 $_SESSION['contact_email']=$rsUser->contact_email;	 
	 $_SESSION['contact_mobile']=$rsUser->contact_mobile;	 
	 $_SESSION['user_type']=$rsUser->user_type;	
	 $_SESSION['employee_type']=$rsUser->employee_type;	
	 ob_clean();
	 echo 'Success::'.$rsUser->user_type;
	 exit();
  }
  ob_clean();
  echo $returnArr[0];
  exit();	
} 
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

            <div class="text-center">
                <a href="index.php" class="logo-lg"><img src="assets/images/logo.png" alt="logo"/></a>
            </div>
			
<?php if($_GET['res']=='success') {  ?> <br/><div class="alert alert-success">Your password was changed. Login with your new password</div>  <?php } ?>
            <form class="form-horizontal m-t-20" action="#"> 
                <div class="form-group row">
                    <div class="col-12">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="mdi mdi-account"></i></span>
                            </div>
                            <input class="form-control" type="text" placeholder="Username" id="username">
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-12">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="mdi mdi-radar"></i></span>
                            </div>
                            <input class="form-control" type="password" placeholder="Password" id="password">
                        </div>
                    </div>
                </div>                 
 <div class="form-group row">
                    <!-- <div class="col-6">
                        <div class="checkbox checkbox-primary">
                            <input id="checkbox-signup" type="checkbox">
                            <label for="checkbox-signup">
                                Remember me
                            </label>
                        </div>
                    </div> -->
					
                </div>
                <div class="form-group text-center m-t-20">
                    <div class="col-xs-12">
                        <button class="btn btn-warning btn-custom w-md waves-effect waves-light" type="submit"><i style="padding-right:5px;" class="fa fa-sign-in" aria-hidden="true"></i> Log In </button><br/><br/>
						<p class="error_class"></p>
                    </div>
                </div>  
				
				

              <!-- <div class="form-group row m-t-10">
                    <div class="col-sm-12 text-center">
                        <a href="forgot_password.php" class="text-muted"><i class="fa fa-lock m-r-5"></i> Forgot your
                            password?</a>
                    </div>                    
                </div>				 -->
            </form>
        </div>
            
   
<script type="text/javascript"> 
 var resizefunc = [];
 
 $(document).ready(function() {  
  $('form').on('submit', function(e){
	   e.preventDefault();
	  login_check();
	  });
	  });

function login_check() {
	var err = 0;
	if(	$('#username').val()=='' ){ err=1; $('#username').css("border","1px solid #fb0b0cf7") } else 
	{ $('#username').css("border",""); var username = $('#username').val(); }
	
	if(	$('#password').val()=='' ){ err=1; $('#password').css("border","1px solid #fb0b0cf7"); }
	else { $('#password').css("border",""); var password = $('#password').val(); }
	
	if(err==0){ 	
	 	var paramData = {'act':'login','username':username,'password':password} 	
		ajax({ 
			a:'index',
			b:$.param(paramData),
			c:function(){},
			d:function(data){   	
            data = data.split('::');  							
			if(data[0].trim()=='Success') {  
            if(data[1]=='E' || data[1]=='FL') { window.location.href = 'e_dashboard.php'; } else { window.location.href = 'dashboard.php'; }
 
			} 
              else {
			$('.error_class').html('Invalid Username or Password');
			 
			}
		    	 			
				 } 
			}); 
		} }

</script>
<style>.boxred { border:1px solid #e9570e !important; } .error_class { color:#ff0000; }</style>
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