<?php
 $userId = $_POST['id'];
$btnName = $title = 'Add New';
$joined_date ='';
if($userId>0) { 
	$param = array('tableName'=>TBL_USERS,'fields'=>array('*'),'condition'=>array('id'=>$userId.'-INT'));
	$rsUsers = Table::getData($param);
	foreach($rsUsers as $K=>$V)  $$K=$V;
	$btnName = $title = 'Edit ';
	 
}
 
?>
	
    <div class="card-box">
      <h4 class="m-t-0 header-title">   Change Email  </h4>
             <p class="text-muted font-14 m-b-20"> <strong><?php echo $contact_fname.' '.$contact_lname.' - '.$contact_email; ?> </strong> </p>
                      <form class="form-horizontal" role="form" id="users_form" enctype="multipart/form-data" autocomplete="off">
                                        <div class="form-group row"> 
											<div class="col-md-4"> Email : 
                                              <input type="email" class="form-control" name="contact_email" id="contact_email1"  onblur="checkEmail(this.value)">
											  <input type="hidden" id="email_check" value="">
											 <span class="email_check_span" style="color:#ff0000"></span> 
											</div>  											
										           
										</div>
										 								 
                                        <div class="form-group mb-0 row">
                                            <div class="col-md-9">
											<input type="hidden" name="id" value="<?php echo $id;?>"/>
											<input type="hidden" name="act" value="changeUserEmail"/>
                                                <button type="submit"  class="btn btn-info waves-effect waves-light">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
								
 <script>
  function IsEmail(email) {
        var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if(!regex.test(email)) {
           return false;
        }else{
           return true;
        }
      }
  
$("form#users_form").on('submit',(function(e){
e.preventDefault(); 
	  err=0;
    
	if($('#contact_email1').val()=='' ){ err=1; $('#contact_email1').css("border","1px solid #ff0000 "); } else{  $('#contact_email1').css("border","");}
	 var contact_email =  $('#contact_email1').val();  
	  if(IsEmail(contact_email)==false){ err=1; $('#contact_email').css("border","1px solid #ff0000 "); } else { $('#contact_email').css("border","");}
	   
	checkEmail(contact_email); 
	  
	 if(IsEmail(contact_email)==true) {
	 var contact_email = $('#contact_email').val(); 
	 
	  
	var email_check = $('#email_check').val();  
	if(email_check==0) { err=0; $('#email_check').val(''); $('.email_check_span').html(''); $('#contact_email').css("border",""); } 
	if(email_check==1) {  err=1; $('#contact_email').css("border","1px solid #ff0000 "); $('.email_check_span').html('Email Already Exits'); }
	 } 
	 
	var form = $('#users_form');  
 	 
  if(err==0) {
	   $('.loading').show();
   ajax({ 
  	a:'users',
  	b:form.serialize(),
  	c:function(){},
  	d:function(data){   
    var res = data.split("::");
alert(res[1]);
$('.right_bar_div').html('');
 show_user_list();
	 }});  

	  
 }  
}));


 
    
	
	
	  
function checkEmail(contact_email) {   
	paramData = {'act':'checkEmail','contact_email':contact_email};
	ajax({ 
		a:'users',
		b:$.param(paramData),
		c:function(){},
		d:function(data){ 
		if(data.trim()==0) { $('#email_check').val(0); }
        if(data.trim()==1) {  $('#email_check').val(1);    }	
  if(data.trim()==0) { err=0; $('#email_check').val(''); $('.email_check_span').html(''); $('#contact_email').css("border",""); } 
	if(data.trim()==1) {  err=1; $('#contact_email').css("border","1px solid #ff0000 "); $('.email_check_span').html('Email Address already exits'); }
 
		
		}});	
}

   
  </script>

 
 


<style> textarea{border:1px solid #cfcfcf}

@media screen and (max-width: 768px) {
	.paddingTop { margin-top:20px; }
	.removebtn { margin-top:10px; float:right; }
}
.form-control { color: #000; }

</style>
