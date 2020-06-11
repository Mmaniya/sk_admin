<?php function main() { 

 /*function clean($string) {
   $string = str_replace(' ', '', $string); 
   $string = str_replace('-', '', $string);  
   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}*/

 $clientId = $_SESSION['CLIENT_ID'];
$param = array('tableName'=>TBL_CLIENTS,'fields'=>array('*'),'showSql'=>'N','condition'=>array('id'=>$clientId.'-INT'));
$rsClient = Table::getData($param);
foreach($rsClient as $K=>$V)  $$K=$V;
 
 
 if($_POST['act']=='update_client') {
 ob_clean(); $param=array();
 $params = array('client_fname','client_lname','client_email','client_cc_email','client_phone','client_address','client_city','client_state');
 foreach($params as $K=>$V) {  $param[$V]=$$V=check_input($_POST[$V]); } 
 
  $param['client_phone'] =  clean($_POST['client_phone']);
 if($_POST['is_change_psw']=='Y') {
	  $param['client_pass'] =  $_POST['confirm_password'];
 }
  $param['last_updated_date'] = date('Y-m-d H:i:s',time());		
  $param['last_updated_by']= $_SESSION['user_id'];  
  $where= array('id'=>$_POST['id']);
 echo  Table::updateData(array('tableName'=>TBL_CLIENTS,'fields'=>$param,'where'=>$where,'showSql'=>'N'));
 	 
 exit(); }
 
 


 
?>

<h3 class="heading">Update Information</h3>
<form id="client_form">
<div class="row">
  <div class="col-md-8">
    <div class="card	">
     
        <h5 class="card-header warning-text text-left">Contact Information </h5>
      <div class="card-body">
	  
	  <div class="row">
  <div class="col-md-6">
  
		  <div class="form-group">
			<label for="client_fname">First Name : </label>
			<input type="text" class="form-control" name="client_fname" id="client_fname" value="<?php echo $client_fname; ?>">
		  </div>
		  </div>
	<div class="col-md-6">	  
		  <div class="form-group">
			<label for="client_lname">Last Name : </label>
			<input type="text" class="form-control" name="client_lname" id="client_lname" value="<?php echo $client_lname; ?>">
		  </div> 	
		  </div> 	
		  </div> 	


 <div class="row">
  <div class="col-md-6">
         <div class="form-group">
			<label for="client_phone">Phone No : </label>
			<input type="text" class="form-control" name="client_phone" id="client_phone" value="<?php echo $client_phone; ?>">
			<span class="error_contact_phone" style="color:#ff0000;"></span>
		 </div> 	
		 </div> 	
		    <div class="col-md-6">
		  <div class="form-group">
			<label for="client_email">Email / Login ID : </label>
			<input type="text" class="form-control" name="client_email" id="client_email" value="<?php echo $client_email; ?>" readonly>
		  </div>  
		  </div>  
		  </div>  


 <div class="row">
  <div class="col-md-6">
  
          <div class="form-group">
			<label for="client_cc_email">CC Email Address : </label>
			<textarea class="form-control" name="client_cc_email" id="client_cc_email"><?php echo $client_cc_email; ?></textarea>
			<p><small style="font-weight: 500;">You can Enter Multiple email address by comma separated</small></p>
			<span class="cc_email_error" style="color:#ff0000;"></span>
		  </div>  	
		  </div>  	
		  
<div class="col-md-6">
          <div class="form-group">
			<label for="client_address"> Address : </label>
			<textarea class="form-control" name="client_address"  id="client_address"><?php echo $client_address; ?></textarea>
			 
		  </div>  	
		  </div>  	
		  </div>  	

<div class="row">
  <div class="col-md-6">
          <div class="form-group">
			<label for="client_city"> City : </label>
			<input type="text" class="form-control" name="client_city" id="client_city" value="<?php echo $client_city; ?>">
		  </div>  	
		  </div>  	
  <div class="col-md-6">
          <div class="form-group">
			<label for="client_state"> State : </label>
			<input type="text" class="form-control" name="client_state" id="client_state" value="<?php echo $client_state; ?>">
		  </div> 		  
		  </div> 		  
		  </div> 

 
		  
		  
        </div>
      </div>
	  
 <div class="card" style="margin-top:10px;">     
    <h5 class="card-header warning-text text-left">Account Password </h5>
    <div class="card-body">
    <input type="checkbox" name="is_change_psw" class="is_change_psw" value="Y"> I want to change my password 
      <div class="row password_row" style="display:none;"><div class="col-md-12"><hr/></div>
        <div class="col-md-6">
          <div class="form-group">
			<label for="new_password"> New Password : </label>
			<input type="password" class="form-control" name="new_password" id="new_password">
			<span id="span_psw_error" style="color:#ff0000;"></span><br/>
		<span class="new_pass_error" style="color:#ff0000;"></span>
			
		  </div>  	
		</div>  
		
        <div class="col-md-6">
          <div class="form-group">
			<label for="confirm_password"> Confirm Password : </label>
			<input type="password" class="form-control" name="confirm_password" id="confirm_password">
		  </div> 		  
        </div> 
		
	 </div> 
    </div>	  
</div>	 <br/>
<input type="hidden" name="id" value="<?php echo $id;?>"/>
 <input type="hidden" name="act" value="update_client"/>
<button type="submit" class="btn btn-danger" id="submitBtn">Edit Profile</button>
    </div> 

  </div>
 </form>
<script type="text/javascript">

  
   function IsEmail(email) {
        var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if(!regex.test(email)) {
           return false;
        }else{
           return true;
        }
      }
	  
    $(document).ready(function(){ 		
	 
    $("#client_phone").inputmask({"mask": "(999) 999 - 9999"});

	 
        $('input[name="is_change_psw"]').click(function(){
            if($(this).prop("checked") == true){ 
               $('.password_row').show();
            }
            else if($(this).prop("checked") == false){  $('.password_row').hide();  }
        });
		
		
 $( "form#client_form" ).submit(function( event ) {
   event.preventDefault();
    err=0;
  if($('#client_fname').val()=='' ){ err=1; $('#client_fname').css("border","1px solid #ff0000 "); } else{  $('#client_fname').css("border","");}
  if($('#client_lname').val()=='' ){ err=1; $('#client_lname').css("border","1px solid #ff0000 "); } else{  $('#client_lname').css("border","");}
  if($('#client_phone').val()=='' ){ err=1; $('#client_phone').css("border","1px solid #ff0000 "); } else{  $('#client_phone').css("border","");}
  if($('#client_address').val()=='' ){ err=1; $('#client_address').css("border","1px solid #ff0000 "); } else{  $('#client_address').css("border","");}
  if($('#client_city').val()=='' ){ err=1; $('#client_city').css("border","1px solid #ff0000 "); } else{  $('#client_city').css("border","");}
  if($('#client_state').val()=='' ){ err=1; $('#client_state').css("border","1px solid #ff0000 "); } else{  $('#client_state').css("border","");}


  emailErr=0; 
var cc_email =  $('#client_cc_email').val();
if(cc_email!='') { 
	 ccEmails=cc_email.split(",");	 
	 $.each(ccEmails, function(index,element)
	 {		
        if(IsEmail($.trim(element))==false)
		{
			emailErr++; 			
		}
	 });

	 if(emailErr > 0)
	 {
		err=1; $('#client_cc_email').css("border","1px solid #ff0000 "); $('.cc_email_error').html('Enter Vaild email address');
	 }
	 else { $('#client_cc_email').css("border","");   $('.cc_email_error').html('');}	  
	  
}
 if($('#client_phone').val()=='' ){ err=1; $('#client_phone').css("border","1px solid #ff0000"); } else{  $('#client_phone').css("border",""); var client_phone = $('#client_phone').val();
	 mobCodeChar = client_phone.replace(/[^A-Z0-9]+/ig, "");  
	 if(mobCodeChar.length<10) { err=1; $('.error_contact_phone').html( 'Enter 10 digit Phone number');$('#client_phone').css("border","1px solid #ff0000");  }
   	 else { $('.error_contact_phone').html(''); $('#client_phone').css("border",""); }
	 }
	 
	 
 var isChangePsw = $('.is_change_psw:checked').val();
 if(isChangePsw=='Y') {
	if($('#new_password').val()=='' ){ err=1; $('#new_password').css("border","1px solid #ff0000 "); } else{  $('#new_password').css("border","");}
	if($('#confirm_password').val()=='' ){ err=1; $('#confirm_password').css("border","1px solid #ff0000 "); } else{  $('#confirm_password').css("border","");}
		
	var new_password = $('#new_password').val();
		
		 if(new_password.length<6) { err=1; $('.new_pass_error').html('Password must 6 characters'); } else { $('.new_pass_error').html('') }
		
		
	var confirm_password = $('#confirm_password').val();
	 $('#span_psw_error').html('');
	if(new_password!=confirm_password) {  
	       $('#new_password').css("border","1px solid #ff0000 "); 
 		   $('#confirm_password').css("border","1px solid #ff0000 "); 
		   $('#span_psw_error').html('confirm password not matched');
		   err=1;
		   } 
	
 }  
 if(err==0) { $('#submitBtn').html('updating please wait....');
	 var form = $('#client_form');  
	    
   ajax({ 
  	a:'accountprofile',
  	b:form.serialize(),
  	c:function(){},
  	d:function(data){ 
		//  alert(data);  
    var res = data.split("::"); 
    alert(res[1]);   
  $('#submitBtn').html('Edit Profile');
	 }});  

	  
 }
 
 
  
});
		
    });
</script>



<?php }  include 'template.php'; ?>