 <?php 
 function main() { 

    $userId = $_SESSION['user_id'];
$param = array('tableName'=>TBL_USERS,'fields'=>array('*'),'showSql'=>'N','condition'=>array('id'=>$userId.'-INT'));
$rsClient = Table::getData($param);
foreach($rsClient as $K=>$V)  $$K=$V;
 
 
 if($_POST['act']=='update_user') {
 ob_clean(); $param=array();
 $params = array('contact_fname','contact_lname','contact_phone','contact_address','contact_city','contact_state','skype_id','business_email','phone','timezone');
 foreach($params as $K=>$V) {  $param[$V]=$$V=check_input($_POST[$V]); } 
 
  $param['phone'] =  $_POST['phone'];
  $param['contact_phone'] =  $_POST['contact_phone'];
 if($_POST['is_change_psw']=='Y') {
	  $param['password'] =  $_POST['confirm_password'];
 }
  $param['last_updated'] = date('Y-m-d H:i:s',time());		
  $where= array('id'=>$_SESSION['user_id']);
 echo  Table::updateData(array('tableName'=>TBL_USERS,'fields'=>$param,'where'=>$where,'showSql'=>'N'));
 	 
 exit(); }
 	 
 ?> 
             
        <div class="row">
        <div class="col-sm-12">
        <div class="page-title-box">
        <h4 class="page-title">Welcome  <?php echo $_SESSION['name']; ?>!</h4>
        <ol class="breadcrumb float-right">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
        <div class="clearfix"></div>
        </div>
        </div>
        </div>
        
        <div class="row"> 
        <div class="col-lg-12">
		 <form id="users_form">
<div class="row">
  <div class="col-md-8">
    <div class="card">      
       
      <div class="card-body">
	  
	  <div class="row">
  <div class="col-md-6">
  
		  <div class="form-group">
			<label for="client_fname">First Name : </label>
			<input type="text" class="form-control" name="contact_fname" id="contact_fname" value="<?php echo $contact_fname; ?>">
		  </div>
		  </div>
	<div class="col-md-6">	  
		  <div class="form-group">
			<label for="contact_lname">Last Name : </label>
			<input type="text" class="form-control" name="contact_lname" id="contact_lname" value="<?php echo $contact_lname; ?>">
		  </div> 	
		  </div> 	
		  </div> 	


 <div class="row">
  <div class="col-md-6">
         <div class="form-group">
			<label for="contact_phone">Phone No : </label>
			<input type="text" class="form-control" name="contact_phone" id="contact_phone" value="<?php echo $contact_phone; ?>">
			<span class="error_contact_phone" style="color:#ff0000;"></span>
		 </div> 	
		 </div> 	
		    <div class="col-md-6">
		  <div class="form-group">
			<label for="contact_email">Email / Login ID : </label>
			<input type="text" class="form-control" name="contact_email" id="contact_email" value="<?php echo $contact_email; ?>" readonly>
		  </div>  
		  </div>  
		  </div>  


 <div class="row">
 
		  
<div class="col-md-6">
          <div class="form-group">
			<label for="contact_address"> Address : </label>
			<textarea class="form-control" name="contact_address"  id="contact_address"><?php echo $contact_address; ?></textarea>
			 
		  </div>  	
		  </div>  	
		  </div>  	

<div class="row">
  <div class="col-md-6">
          <div class="form-group">
			<label for="contact_city"> City : </label>
			<input type="text" class="form-control" name="contact_city" id="contact_city" value="<?php echo $contact_city; ?>">
		  </div>  	
		  </div>  	
  <div class="col-md-6">
          <div class="form-group">
			<label for="contact_state"> State : </label>
			<input type="text" class="form-control" name="contact_state" id="contact_state" value="<?php echo $contact_state; ?>">
		  </div> 		  
		  </div> 


<div class="col-md-6">
			<div class="form-group ">
			 <div class="col-md-12"> <strong> Skype ID  : </strong>
			  <input type="text" class="form-control" name="skype_id" id="skype_id" value="<?php echo $skype_id; ?>">
			  </div> 			 										  
			</div>
			</div>

<div class="col-md-6">
			<div class="form-group row">
			 <div class="col-md-12"> <strong> Business Email  : </strong> 
			<div class="" style="display:inline-flex;">
			<input type="text" class="form-control" name="business_email" id="business_email" value="<?php echo $business_email; ?>" style="width:50%">@bizplaneasy.com </div>
			  </div> 
			</div>
			</div>
										
		  </div> 
<div class="form-group row">
										<div class="col-md-5"><strong>Phone : </strong>
										  <input type="text" class="form-control" name="phone" id="phone" value="<?php echo $phone; ?>">	
										  <input type="hidden" id="email_check">
                                           <span class="error_phone" style="color:#ff0000;"></span>										  
										</div>
										<div class="col-md-5"><strong>Timezone : </strong>
										   
										  <select class="form-control" name="timezone" id="timezone" >
										  <option value="">Select</option>
 <option value="Pacific/Midway">(GMT-11:00) Midway Island, Samoa</option>
<option value="America/Adak">(GMT-10:00) Hawaii-Aleutian</option>
<option value="Etc/GMT+10">(GMT-10:00) Hawaii</option>
<option value="Pacific/Marquesas">(GMT-09:30) Marquesas Islands</option>
<option value="Pacific/Gambier">(GMT-09:00) Gambier Islands</option>
<option value="America/Anchorage">(GMT-09:00) Alaska</option>
<option value="America/Ensenada">(GMT-08:00) Tijuana, Baja California</option>
<option value="Etc/GMT+8">(GMT-08:00) Pitcairn Islands</option>
<option value="America/Los_Angeles">(GMT-08:00) Pacific Time (US & Canada)</option>
<option value="America/Denver">(GMT-07:00) Mountain Time (US & Canada)</option>
<option value="America/Chihuahua">(GMT-07:00) Chihuahua, La Paz, Mazatlan</option>
<option value="America/Dawson_Creek">(GMT-07:00) Arizona</option>
<option value="America/Belize">(GMT-06:00) Saskatchewan, Central America</option>
<option value="America/Cancun">(GMT-06:00) Guadalajara, Mexico City, Monterrey</option>
<option value="Chile/EasterIsland">(GMT-06:00) Easter Island</option>
<option value="America/Chicago">(GMT-06:00) Central Time (US & Canada)</option>
<option value="America/New_York">(GMT-05:00) Eastern Time (US & Canada)</option>
<option value="America/Havana">(GMT-05:00) Cuba</option>
<option value="America/Bogota">(GMT-05:00) Bogota, Lima, Quito, Rio Branco</option>
<option value="America/Caracas">(GMT-04:30) Caracas</option>
<option value="America/Santiago">(GMT-04:00) Santiago</option>
<option value="America/La_Paz">(GMT-04:00) La Paz</option>
<option value="Atlantic/Stanley">(GMT-04:00) Faukland Islands</option>
<option value="America/Campo_Grande">(GMT-04:00) Brazil</option>
<option value="America/Goose_Bay">(GMT-04:00) Atlantic Time (Goose Bay)</option>
<option value="America/Glace_Bay">(GMT-04:00) Atlantic Time (Canada)</option>
<option value="America/St_Johns">(GMT-03:30) Newfoundland</option>
<option value="America/Araguaina">(GMT-03:00) UTC-3</option>
<option value="America/Montevideo">(GMT-03:00) Montevideo</option>
<option value="America/Miquelon">(GMT-03:00) Miquelon, St. Pierre</option>
<option value="America/Godthab">(GMT-03:00) Greenland</option>
<option value="America/Argentina/Buenos_Aires">(GMT-03:00) Buenos Aires</option>
<option value="America/Sao_Paulo">(GMT-03:00) Brasilia</option>
<option value="America/Noronha">(GMT-02:00) Mid-Atlantic</option>
<option value="Atlantic/Cape_Verde">(GMT-01:00) Cape Verde Is.</option>
<option value="Atlantic/Azores">(GMT-01:00) Azores</option>
<option value="Europe/Belfast">(GMT) Greenwich Mean Time : Belfast</option>
<option value="Europe/Dublin">(GMT) Greenwich Mean Time : Dublin</option>
<option value="Europe/Lisbon">(GMT) Greenwich Mean Time : Lisbon</option>
<option value="Europe/London">(GMT) Greenwich Mean Time : London</option>
<option value="Africa/Abidjan">(GMT) Monrovia, Reykjavik</option>
<option value="Europe/Amsterdam">(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna</option>
<option value="Europe/Belgrade">(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague</option>
<option value="Europe/Brussels">(GMT+01:00) Brussels, Copenhagen, Madrid, Paris</option>
<option value="Africa/Algiers">(GMT+01:00) West Central Africa</option>
<option value="Africa/Windhoek">(GMT+01:00) Windhoek</option>
<option value="Asia/Beirut">(GMT+02:00) Beirut</option>
<option value="Africa/Cairo">(GMT+02:00) Cairo</option>
<option value="Asia/Gaza">(GMT+02:00) Gaza</option>
<option value="Africa/Blantyre">(GMT+02:00) Harare, Pretoria</option>
<option value="Asia/Jerusalem">(GMT+02:00) Jerusalem</option>
<option value="Europe/Minsk">(GMT+02:00) Minsk</option>
<option value="Asia/Damascus">(GMT+02:00) Syria</option>
<option value="Europe/Moscow">(GMT+03:00) Moscow, St. Petersburg, Volgograd</option>
<option value="Africa/Addis_Ababa">(GMT+03:00) Nairobi</option>
<option value="Asia/Tehran">(GMT+03:30) Tehran</option>
<option value="Asia/Dubai">(GMT+04:00) Abu Dhabi, Muscat</option>
<option value="Asia/Yerevan">(GMT+04:00) Yerevan</option>
<option value="Asia/Kabul">(GMT+04:30) Kabul</option>
<option value="Asia/Yekaterinburg">(GMT+05:00) Ekaterinburg</option>
<option value="Asia/Tashkent">(GMT+05:00) Tashkent</option>
<option value="Asia/Kolkata">(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi</option>
<option value="Asia/Katmandu">(GMT+05:45) Kathmandu</option>
<option value="Asia/Dhaka">(GMT+06:00) Astana, Dhaka</option>
<option value="Asia/Novosibirsk">(GMT+06:00) Novosibirsk</option>
<option value="Asia/Rangoon">(GMT+06:30) Yangon (Rangoon)</option>
<option value="Asia/Bangkok">(GMT+07:00) Bangkok, Hanoi, Jakarta</option>
<option value="Asia/Krasnoyarsk">(GMT+07:00) Krasnoyarsk</option>
<option value="Asia/Hong_Kong">(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi</option>
<option value="Asia/Irkutsk">(GMT+08:00) Irkutsk, Ulaan Bataar</option>
<option value="Australia/Perth">(GMT+08:00) Perth</option>
<option value="Australia/Eucla">(GMT+08:45) Eucla</option>
<option value="Asia/Tokyo">(GMT+09:00) Osaka, Sapporo, Tokyo</option>
<option value="Asia/Seoul">(GMT+09:00) Seoul</option>
<option value="Asia/Yakutsk">(GMT+09:00) Yakutsk</option>
<option value="Australia/Adelaide">(GMT+09:30) Adelaide</option>
<option value="Australia/Darwin">(GMT+09:30) Darwin</option>
<option value="Australia/Brisbane">(GMT+10:00) Brisbane</option>
<option value="Australia/Hobart">(GMT+10:00) Hobart</option>
<option value="Asia/Vladivostok">(GMT+10:00) Vladivostok</option>
<option value="Australia/Lord_Howe">(GMT+10:30) Lord Howe Island</option>
<option value="Etc/GMT-11">(GMT+11:00) Solomon Is., New Caledonia</option>
<option value="Asia/Magadan">(GMT+11:00) Magadan</option>
<option value="Pacific/Norfolk">(GMT+11:30) Norfolk Island</option>
<option value="Asia/Anadyr">(GMT+12:00) Anadyr, Kamchatka</option>
<option value="Pacific/Auckland">(GMT+12:00) Auckland, Wellington</option>
<option value="Etc/GMT-12">(GMT+12:00) Fiji, Kamchatka, Marshall Is.</option>
<option value="Pacific/Chatham">(GMT+12:45) Chatham Islands</option>
<option value="Pacific/Tongatapu">(GMT+13:00) Nuku'alofa</option>
<option value="Pacific/Kiritimati">(GMT+14:00) Kiritimati</option>
</select>
										  
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
		<span class="password_error"></span>
	 </div> 
    </div>	  
</div>	 <br/>
<input type="hidden" name="id" value="<?php echo $id;?>"/>
 <input type="hidden" name="act" value="update_user"/>
<button type="submit" class="btn btn-danger" id="submitBtn">Edit Profile</button><br/>
<h5 class="update_info"></h5>   
   </div> 

  </div>
 </form>
		</div>
         
        


<script>   
 //$('select[name^="timezone"] option[value='<?php echo $timezone; ?>']').attr("selected","selected");

$('input[name="is_change_psw"]').click(function(){
            if($(this).prop("checked") == true){ 
               $('.password_row').show();
            }
            else if($(this).prop("checked") == false){  $('.password_row').hide();  }
        });
		
	 $(document).ready(function(){ 			
		$("form#users_form").on('submit',(function(e){
e.preventDefault();  
	 err=0;
	var isChangePsw = $('.is_change_psw:checked').val();
 if(isChangePsw=='Y') {
	 if($('#new_password').val()=='' ){ err=1; $('#new_password').css("border","1px solid #ff0000 "); } else{  $('#new_password').css("border","");}
	 if($('#confirm_password').val()=='' ){ err=1; $('#confirm_password').css("border","1px solid #ff0000 "); } else{  $('#confirm_password').css("border","");}
	 new_password = $('#new_password').val();
	 confirm_password = $('#confirm_password').val()
	 
	 if(new_password!=confirm_password) {  err=1; $('.password_error').html('<h5 style="color:#ff0000">Enter Confirm Password Same as Password </h5>');
$('#password').css("border","1px solid #ff0000 "); $('#confirm_password').css("border","1px solid #ff0000 ");
	 } else { $('.password_error').html(''); $('#password').css("border",""); $('#confirm_password').css("border","");  }
	 
 }
	 
	 

	 
	  if($('#contact_fname').val()=='' ){ err=1; $('#contact_fname').css("border","1px solid #ff0000 "); } else{  $('#contact_fname').css("border","");}
	  if($('#contact_lname').val()=='' ){ err=1; $('#contact_lname').css("border","1px solid #ff0000 "); } else{  $('#contact_lname').css("border","");}
	   
	   
	  
	  if($('#contact_address').val()=='' ){ err=1; $('#contact_address').css("border","1px solid #ff0000 "); } else{  $('#contact_address').css("border","");}
	  if($('#contact_city').val()=='' ){ err=1; $('#contact_city').css("border","1px solid #ff0000 "); } else{  $('#contact_city').css("border","");}
	  //if($('#contact_state').val()=='' ){ err=1; $('#contact_state').css("border","1px solid #ff0000 "); } else{  $('#contact_state').css("border","");}
	  if($('#contact_country').val()=='' ){ err=1; $('#contact_country').css("border","1px solid #ff0000 "); } else{  $('#contact_country').css("border","");}
	  
	  
	 
	   if($('#contact_phone').val()=='' ){ err=1; $('#contact_phone').css("border","1px solid #ff0000"); } else{  $('#contact_phone').css("border",""); var contact_phone = $('#contact_phone').val();
	 mobCodeChar = contact_phone.replace(/[^A-Z0-9]+/ig, "");  
	 if(mobCodeChar.length<10) { err=1; $('.error_contact_phone').html( 'Enter 10 digit Phone number');$('#contact_phone').css("border","1px solid #ff0000");  }
   	 else { $('.error_contact_phone').html(''); $('#contact_phone').css("border",""); }
	 }
	 
	   
	   if($('#business_email').val()=='' ){ err=1; $('#business_email').css("border","1px solid #ff0000 "); } else{  $('#business_email').css("border","");}
	 
	 
	 if($('#phone').val()=='' ){ err=1; $('#phone').css("border","1px solid #ff0000"); } else{  $('#phone').css("border",""); var phone = $('#phone').val();
	 mobCodeChar = phone.replace(/[^A-Z0-9]+/ig, "");  
	 if(mobCodeChar.length<10) { err=1; $('.error_phone').html( 'Enter 10 digit Phone number');$('#contact_phone').css("border","1px solid #ff0000");  }
   	 else { $('.error_phone').html(''); $('#contact_phone').css("border",""); }
	 }
	 
	 
	  //if($('#timezone').val()=='' ){ err=1; $('#timezone').css("border","1px solid #ff0000 "); } else{  $('#timezone').css("border","");}
	  
	 
	 
	var form = $('#users_form');  
 	 
  if(err==0) { $('.update_info').html('loading...');
	   
   ajax({ 
  	a:'e_update_profile',
  	b:form.serialize(),
  	c:function(){},
  	d:function(data){  
    var res = data.split("::");
   $('.update_info').html('<br/> Profile '+res[1]);
 
 
	 }});  

	  
 }  
}));
});   
  
</script>                  
       
 <?php } include 'e_template.php'; ?>
 
  