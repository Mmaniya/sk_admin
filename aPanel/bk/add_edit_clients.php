<?php 

$clientId = $_POST['id'];
$btnName = $title = 'Add New';
if($clientId>0) { 
	$param = array('tableName'=>TBL_CLIENTS,'fields'=>array('*'),'condition'=>array('id'=>$clientId.'-INT'));
	$rsClientId = Table::getData($param);
	foreach($rsClientId as $K=>$V)  $$K=$V;
	$btnName = $title = 'Edit ';
}
?>
			<div class="card-box">
				<h4 class="m-t-0 header-title"><?php echo $title; ?> Client </h4>
				<p class="text-muted font-14 m-b-20"></p>

			   <form class="form-horizontal" role="form" id="client_form" enctype="multipart/form-data">
			   
			 <div class="form-group row">
				 <div class="col-md-10">Company Name  
				    <input type="text" name="client_company_name" class="form-control" id="client_company_name" value="<?php echo $client_company_name; ?>"/>
				 </div>										
			 </div>
			   
					<div class="form-group row">
						<div class="col-md-5">First Name  
							<input type="text"   class="form-control" name="client_fname" id="client_fname" value="<?php echo $client_fname; ?>">
						</div>
						
						<div class="col-md-5"> Last Name  
						  <input type="text" class="form-control" name="client_lname" id="client_lname" value="<?php echo $client_lname; ?>">
						</div> 											
					 </div>
					
					
					 <div class="form-group row">
						<div class="col-md-5">Email  
						  <input type="text" class="form-control" name="client_email" id="client_email" value="<?php echo $client_email; ?>" readonly>
					 </div>
						
				  <div class="col-md-5"> Phone  
					<input type="text" class="form-control" name="client_phone" data-mask="(999) 999-9999" id="client_phone" value="<?php echo $client_phone; ?>">
						</div>											
					</div>

                   <div class="form-group row">
                       <div class="col-md-10">CC Email Addresses
                           <textarea name="client_cc_email" class="form-control" id="client_cc_email"><?php echo $client_cc_email; ?></textarea>
                           <small style="font-weight: 500;">You can Enter Multiple email address by comma separated</small>
                       </div>
                   </div>

					<div class="form-group row">
						<div class="col-md-10">Address  
						<textarea name="client_address" class="form-control" id="client_address"><?php echo $client_address; ?></textarea>
						</div>										
					</div>
					
					
					 <div class="form-group row">
						<div class="col-md-5">City  
						  <input type="text" class="form-control" name="client_city" id="client_city" value="<?php echo $client_city; ?>">
						</div>
						
						<div class="col-md-5"> State  
						  <input type="text" class="form-control" name="client_state"  id="client_state" value="<?php echo $client_state; ?>">
						</div>											
					</div>
					 
					<div class="form-group  justify-content-end row">
						<div class="col-md-9">
						<input type="hidden" name="id" id="clientId" value="<?php echo $id;?>"/>
						<input type="hidden" name="act" value="submitClientsDtls"/>						   
						</div>
					</div>
					
					<div class="row" style="margin-top:20px;">
					   <div class="col-md-6"> <button type="submit"  class="btn btn-info waves-effect waves-light float-right">Submit</button></div>
					   <div class="col-md-6"> <button type="button" onclick="closeLeadForm()"  class="btn btn-danger float-right">Close</button></div>
					</div>
					
					
					
				</form>
			</div>
								
								<script>
					 				 
								
								
  $(document).ready(function (e){  
 $("#lead_phone").inputmask({"mask": "(999) 999-9999"});
  

  
$("form#client_form").on('submit',(function(e){
e.preventDefault();
	  err=0;
	 if($('#client_fname').val()=='' ){ err=1; $('#client_fname').css("border","1px solid #F58634"); } else{  $('#client_fname').css("border","");}
	 if($('#client_lname').val()=='' ){ err=1; $('#client_lname').css("border","1px solid #F58634"); } else{  $('#client_lname').css("border","");}
	 var client_fname = $('#client_fname').val();
	 var client_lname = $('#client_lname').val();
	 var clientId = $('#clientId').val();
	 var client_email = $('#client_email').val();
	 var client_phone = $('#client_phone').val();
	 var client_address = $('#client_address').val();
	 var client_city = $('#client_city').val();
	 var client_state = $('#client_state').val();
	  
  if(err==0) {
	     
	   	   $.ajax({
				url: "clients.php",
				type: "POST",
				data:  new FormData(this),
				contentType: false,
				cache: false,
				processData:false,
				success: function(data){  		
				var res = data.split("::");	alert(res[1]); 
                 if(res[1]=='Successfully updated')	{ $('#client_name_'+clientId).html(client_fname+' '+client_lname); 
				 
				  var clientDetails =' <a href="mailto:'+client_email+'">'+client_email+'</a>';
				  clientDetails+='<br><a href="tel:'+client_phone+'">'+client_phone+'</a><br>'+client_address+'<br> '+client_city+' -'+client_state;
				  
				  
                       $('#client_details_'+clientId).html(clientDetails);     }			
				$('.right_bar_div').html('');
				},
				error: function(){} 	        
		});
     
	   
 /*  ajax({ 
  	a:'leads',
  	b:form.serialize(),
  	c:function(){},
  	d:function(data){    
	var res = data.split("::");
	alert(res[1]);
   $('.right_bar_div').html('');
  show_services_list();
	 }});  
*/
	  
 }  
}));
}); 
  
  <?php if($id>0) { ?>  showOtherEnquiryType('<?php echo $lead_enquiry_type; ?>'); <?php  }  ?>
   
   
   function closeLeadForm() {
     $('.right_bar_div').html('');

   }	   
   
   
  function showOtherEnquiryType(type) {
	  var other_enq_div = $('#other_enq_div').hide();
	  if(type=='Other') {  $('#other_enq_div').show(); } 
  }
  
  
   function IsEmail(email) {
        var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if(!regex.test(email)) {
           return false;
        }else{
           return true;
        }
      }
	  
  
  </script>

 
 


<style> textarea{border:1px solid #cfcfcf}

@media screen and (max-width: 768px) {
	
	.paddingTop { margin-top:20px; }
	.removebtn { margin-top:10px; float:right; }
} 


.form-headline { background-color: #039cfd;color: #fff;margin: 0; }
.form-headline .col-form-label { text-align: left; }
													
.append_forms {  padding-top: 20px; padding-bottom: 10px; }
.append_forms:nth-child(even) {background-color: #f2f2f2; padding-top: 20px; padding-bottom: 10px;}
textarea{border:1px solid #cfcfcf;}

@media screen and (max-width: 768px) {
	.col-form-label {text-align:left; }
	.paddingTop { margin-top:20px; }
	.append_forms { padding:20px; }
	 
	.removebtn { margin-top:10px; float:right; }
}</style>
