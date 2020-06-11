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
      <h4 class="m-t-0 header-title">   Change Password  </h4>
             <p class="text-muted font-14 m-b-20"> <?php echo $contact_fname.' '.$contact_lname; ?></p>
                      <form class="form-horizontal" role="form" id="users_form" enctype="multipart/form-data" autocomplete="off">
                                        <div class="form-group row"> 
											<div class="col-md-4"> Password : 
                                              <input type="password" class="form-control" name="password" id="password1">
											</div>
											
											<div class="col-md-4">Confirm Password :
                                               <input type="password" class="form-control" name="password" id="cpassword">
											   <span class="password_error" style="color:#ff0000;"></span>
                                            </div>            
										</div>
										 								 
                                        <div class="form-group mb-0 justify-content-end row">
                                            <div class="col-md-9">
											<input type="hidden" name="id" value="<?php echo $id;?>"/>
											<input type="hidden" name="act" value="UpdateUserPassword"/>
                                                <button type="submit"  class="btn btn-info waves-effect waves-light">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
								
 <script>
 
  
$("form#users_form").on('submit',(function(e){
e.preventDefault(); 
	  err=0;
  
	 if($('#password1').val()=='' ){ err=1; $('#password1').css("border","1px solid #ff0000 "); } else{  $('#password1').css("border","");}
	 if($('#cpassword').val()=='' ){ err=1; $('#cpassword').css("border","1px solid #ff0000 "); } else{  $('#cpassword').css("border","");}
	 password = $('#password1').val();
	 cpassword = $('#cpassword').val();
	  
	 if(password!=cpassword) {  err=1; $('.password_error').html('<small>Enter Confirm Password Same as Password </small>');
$('#password1').css("border","1px solid #ff0000 "); $('#cpassword').css("border","1px solid #ff0000 ");
	 } else { $('.password_error').html(''); $('#password').css("border",""); $('#cpassword').css("border","");  }
	  
	 
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
    
   
  </script>

 
 


<style> textarea{border:1px solid #cfcfcf}

@media screen and (max-width: 768px) {
	.paddingTop { margin-top:20px; }
	.removebtn { margin-top:10px; float:right; }
}
.form-control { color: #000; }

</style>
