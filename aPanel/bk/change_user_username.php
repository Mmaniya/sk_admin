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
             <p class="text-muted font-14 m-b-20"> <strong><?php echo $contact_fname.' '.$contact_lname.' - '.$username; ?> </strong> </p>
                      <form class="form-horizontal" role="form" id="users_form" enctype="multipart/form-data" autocomplete="off">
                                        <div class="form-group row"> 
											<div class="col-md-4"> Username : 
										<input type="text"   class="form-control" name="username" id="username1" onblur="checkUsername(this.value)">
										<input type="hidden" id="username_check">
										<span class="username_check_span" style="color:#ff0000"></span> 
											</div>  											
										           
										</div>
										 								 
                                        <div class="form-group mb-0 row">
                                            <div class="col-md-9">
											<input type="hidden" name="id" value="<?php echo $id;?>"/>
											<input type="hidden" name="act" value="changeUserUsername"/>
                                                <button type="submit"  class="btn btn-info waves-effect waves-light">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
								
 <script>
 
  
$("form#users_form").on('submit',(function(e){
e.preventDefault(); 
	  err=0;
    if($('#username1').val()==''){ err=1; $('#username1').css("border","1px solid #ff0000 "); } else{  $('#username1').css("border","");  }
	 
	var usernameVal = $('#username1').val(); 
	    checkUsername(usernameVal);  
	 
	   var username_check = $('#username_check').val().trim();   
     if(username_check==0) { err=0; $('#username_check').val(''); $('.username_check_span').html(''); $('#username1').css("border",""); } 
	if(username_check==1) {  err=1; $('#username1').css("border","1px solid #ff0000 "); $('.username_check_span').html('Username Already Exits'); } 
	  
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


 
    
	
	
  
function checkUsername(username) {   
	paramData = {'act':'checkUsername','username':username};
	ajax({ 
		a:'users',
		b:$.param(paramData),
		c:function(){},
		d:function(data){ 
		if(data.trim()==0) { $('#username_check').val(0); }
        if(data.trim()==1) {  $('#username_check').val(1);    }	
  if(data.trim()==0) { err=0; $('#username_check').val(''); $('.username_check_span').html(''); $('#username1').css("border",""); } 
	if(data.trim()==1) {  err=1; $('#username1').css("border","1px solid #ff0000 "); $('.username_check_span').html('Username already exits'); }
 
		
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
