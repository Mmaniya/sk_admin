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
        <title>Password Recovery  | Bizplan Easy</title>
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
<?php  $token = $_GET['token'];	
        $param = array('tableName'=>TBL_USERS,'fields'=>array('*'),'showSql'=>'N','condition'=>array('forgot_password_token'=>$token.'-CHAR','status'=>'A-CHAR'));
		$rsUsers = Table::getData($param);
	    if(count($rsUsers)>0) {   ?> 
		
            <form method="post" action="#" role="form" class="text-center m-t-20">
               <div class="form-group m-b-0">
                    <div class="input-group">
                        <input type="password" class="form-control" placeholder="Password" id="password">                        
                    </div>
                </div> 
				
				  <div class="form-group m-b-0">
                    <div class="input-group">                        
                        <input type="password" class="form-control" placeholder="Confirm Password" id="cpassword">                                               
                    </div>
                </div> 
				
				  <div class="form-group m-b-0">
                    <div class="input-group">                                                 
                        <input type="hidden" name="token_id" value="<?php echo $token; ?>" id="token_id"/>
                        <button type="submit" class="btn btn-warning waves-effect waves-light">Reset Password</button>  
                    </div>
                </div> 
				
				
            </form> <br/> 
		<?php }  else {  echo '<br/><h5>invalid Token.  Please try again later</h5>'; }?>
            <div class="error_class"></div> <br/>
            <div class="pass_error_class"></div>
        </div>
<script>  
$(document).ready(function() {  
  $('form').on('submit', function(e){
	   e.preventDefault();
	  reset_password();
	  });
	  });

function reset_password() {
	var err = 0;
	$('.error_class').html('');
	if(	$('#password').val()=='' ){ err=1; $('#password').css("border","1px solid #fb0b0cf7") } else 
	{ $('#password').css("border",""); var password = $('#password').val(); }
	
	var passLength = $("#password").val().length;
  if(passLength<6) {  err=1; $('.pass_error_class').html('Password Must 6 digit');  } else { $('.pass_error_class').html(''); }
	
	if(	$('#cpassword').val()=='' ){ err=1; $('#cpassword').css("border","1px solid #fb0b0cf7") } else 
	{ $('#cpassword').css("border",""); var cpassword = $('#cpassword').val(); }
		 
	if(password!=cpassword) { $('.error_class').html('Enter Confirm Password Same as Password'); err=1;
$('#password').css("border","1px solid #fb0b0cf7"); $('#cpassword').css("border","1px solid #fb0b0cf7")

	}	 
		 
	var token_id = $('#token_id').val();
	
	if(err==0){ 	
	 	var paramData = {'act':'reset_password','password':password,'token_id':token_id } 	
		ajax({ 
			a:'process',
			b:$.param(paramData),
			c:function(){},
			d:function(data){   $('form').hide();             					
			   $('.error_class').html(data);	
               //$('#email_address').val('');	
 string = data.trim();
if(string=='login') { $('.error_class').html(''); window.location.href='index.php?res=success'; }					   
			 } 
			}); 
		} }
		</script>
 <style>.boxred { border:1px solid #e9570e !important; } .error_class { color:#ff0000; text-center;}  .pass_error_class { color:#ff0000; text-center;  }</style>
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