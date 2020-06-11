<?php 

ini_set('display_errors',1);
$leadsId = $_POST['id'];
$btnName = $title = 'Add New';
if($leadsId>0) { 
	$param = array('tableName'=>TBL_LEADS,'fields'=>array('*'),'condition'=>array('id'=>$leadsId.'-INT'));
	$rsLeads = Table::getData($param);
	foreach($rsLeads as $K=>$V)  $$K=$V;
	$btnName = $title = 'Edit ';
}
?>
<script>function toggle(id) {  $('.lead_service_type_'+id).toggle();  }</script>	

 <div class="card-box">
          <h4 class="m-t-0 header-title"><?php echo $title; ?> Lead </h4>
          <p class="text-muted font-14 m-b-20"></p>

               <form class="form-horizontal" role="form" id="leads_form" enctype="multipart/form-data">
						 
							 
							            <div class="form-group row">
                                            <label class="col-md-2 col-form-label" style="line-height:40px;"> </label>
                                            <div class="col-md-5"> Company Name   :
                                                <input type="text" class="form-control" name="lead_company_name" id="lead_company_name" value="<?php echo $lead_company_name; ?>">
                                            </div> 									
										 
									     </div>
										
										
										
							 
                                        <div class="form-group row">
                                            <label class="col-md-2 col-form-label" style="line-height:40px;">Name : </label>
                                            <div class="col-md-5">First Name  
                                                <input type="text"   class="form-control" name="lead_fname" id="lead_fname" value="<?php echo $lead_fname; ?>">
                                            </div>
											
											<div class="col-md-5"> Last Name  
                                              <input type="text" class="form-control" name="lead_lname" id="lead_lname" value="<?php echo $lead_lname; ?>">
                                            </div>
											
									     </div>
										
										
										 <div class="form-group row">
                                            <label class="col-md-2 col-form-label" style="line-height: 40px;">Contact : </label>
                                            <div class="col-md-5">Email  
                                              <input type="text" class="form-control" name="lead_email" id="lead_email" value="<?php echo $lead_email; ?>">
                                            </div>
											
											<div class="col-md-5"> Phone  
                                              <input type="text" class="form-control" name="lead_phone" data-mask="(999) 999-9999" id="lead_phone" value="<?php echo $lead_phone; ?>">
                                            </div>
											
                                        </div>
										
										 
										
										<div class="form-group row" style="margin:0;">
                                            <label class="col-md-2 col-form-label" style="padding:0px;">Enquiry Type  : </label>
                                            <div class="col-md-5">&nbsp;
                                               <input type="radio" onclick="showOtherEnquiryType('E')" name="lead_enquiry_type" value="E" <?php if($lead_enquiry_type=='E') { echo 'checked'; } ?>> Email &nbsp;
                                               <input type="radio" onclick="showOtherEnquiryType('C')" name="lead_enquiry_type" value="C" <?php if($lead_enquiry_type=='C') { echo 'checked'; } ?>> Call &nbsp;
                                               <input type="radio" onclick="showOtherEnquiryType('Other')" name="lead_enquiry_type" value="Other" <?php if($lead_enquiry_type=='Other') { echo 'checked'; } ?>> Other &nbsp; 	<br/> <p class="error_msg" style="color:#ff0000"> </p>										   
                                            </div>
                                        </div>
										 
										 
										  <div class="form-group row" style="display:none;" id="other_enq_div">
                                            <label class="col-md-2 col-form-label"> </label>
                                            <div class="col-md-5">Other Enquiry Type  
                                              <input type="text" class="form-control" name="other_enquiry_type" id="other_enquiry_type" value="<?php echo $other_enquiry_type; ?>">
                                            </div> 											
                                        </div>
										
										
                                        <div class="form-group row">
                                            <label class="col-md-12 col-form-label form-headline" style="text-align:left;">Enquiry for : </label> 
                                              <div class="col-md-9" style="margin-top:10px;">
											  <?php 
											  
											$leadsEnquire = explode(',',$lead_enquiry_for);    
											  $param=array();
											  $param = array('tableName'=>TBL_SERVICE_CATEGORY,'fields'=>array('*'),'condition'=>array('status'=>'A-CHAR'));
										$rsServiceCat = Table::getData($param);
										 
                                        if(count($rsServiceCat)>0) {
										foreach($rsServiceCat as $key=>$val) {
											  if (in_array($val->id, $leadsEnquire)) { 
											  $checked='checked'; echo '<script>   toggle('.$val->id.')</script>'; } 		else{   $checked='';	} 
											 ?>
					<input type="checkbox" name="lead_enquiry_for[]"  onclick="toggle(<?php echo $val->id;?>)"  value="<?php echo $val->id;?>" <?php   echo $checked;  ?>> <?php echo $val->category_name;?>  	<br/>	
                     <ul class="lead_service_type_<?php echo $val->id; ?>" style="display:none"> 
						<?php $param = array('tableName'=>TBL_SERVICES,'fields'=>array('*'),'condition'=>array('service_category_id'=>$val->id.'-INT'));
						$rsServiceRes = Table::getData($param);
                       if(count($rsServiceRes)>0) {
                         foreach($rsServiceRes as $K=>$V) {  
						  $checked='';
    $param = array('tableName'=>TBL_LEAD_SERVICES,'fields'=>array('*'),'showSql'=>'N','condition'=>array('lead_id'=>$id.'-INT','service_category_id'=>$val->id.'-INT','service_id'=>$V->id.'-INT'));
$rsLeadSpec = Table::getData($param);  
if(count($rsLeadSpec)>0) {
 foreach($rsLeadSpec as $K2=>$V2)
if($V2->service_id==$V->id) {  $checked='checked';   }  }
		
						 ?>
					 <li><input type="checkbox" name="service_type_list[][<?php echo $val->id;?>]" value="<?php echo $V->id;?>" <?php echo $checked; ?>>&nbsp;<?php echo $V->service_name?> </li>
					 
					   <?php } } else { echo '<li>No services found</li>'; } ?></ul>	
									
                                         <?php }} ?> 
												<p class="error_msg_checkbox" style="color:#ff0000"></p>
                                             <span style="clear:both"></span>
                                             </div>
                                        </div>
										
										
										
										 <div class="form-group row">
                                            <label class="col-md-12 col-form-label  form-headline" style="text-align:left;">Packages </label>
                                            <div class="col-md-8">  
											<ul style="margin-top:10px; list-style-type:none;" >
                                             <?php 
											 $packagesId = explode(',',$packages_id);
											 $param = array('tableName'=>TBL_PACKAGES,'fields'=>array('*'),'condition'=>array('status'=>'A-CHAR'));
						$rsPackages = Table::getData($param);
                       if(count($rsPackages)>0) {
                         foreach($rsPackages as $key=>$val) {  
						  $checked='';
                       if (in_array($val->id, $packagesId)) { $checked='checked';      }
						  ?>
       <li><input type="checkbox" name="packages_id[]" value="<?php echo $val->id;?>" <?php echo $checked; ?>>&nbsp;<?php echo $val->package_name?> </li>
									
					   <?php } } ?>	 </ul>
                                            </div>											
                                        </div>
										
										
										
                                        <div class="form-group row"><label class="col-md-12 col-form-label"> <hr/> </label>
                                            <label class="col-md-2 col-form-label"> Description : </label>
                                            <div class="col-md-6">
                                                 <textarea class="form-control" name="lead_enquiry_desc" id="lead_enquiry_desc" style="margin-top: 0px; margin-bottom: 0px; height: 101px;"><?php echo $lead_enquiry_desc; ?></textarea>
                                            </div>
                                        </div>
																			
											 
										
									 
                                        
                                        <div class="form-group  justify-content-end row">
                                            <div class="col-md-9">
											<input type="hidden" name="id" value="<?php echo $id;?>"/>
											<input type="hidden" name="act" value="addEditLeads"/>
                                               
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
  

  
 $("form#leads_form").on('submit',(function(e){
e.preventDefault();
	  err=0;
	 if($('#lead_fname').val()=='' ){ err=1; $('#lead_fname').css("border","1px solid #F58634 "); } else{  $('#lead_fname').css("border","");}
	 if($('#lead_lname').val()=='' ){ err=1; $('#lead_lname').css("border","1px solid #F58634 "); } else{  $('#lead_lname').css("border","");}
	 
	 var lead_enquiry_type =  $("input[name='lead_enquiry_type']:checked").val();
	 
	 if(lead_enquiry_type==undefined){ err=1; $('.error_msg').html("Select Enquiry Type");  } else{  $('.error_msg').html();  }
	 
	 var checkbox = $('input[type=checkbox]').prop('checked');
// if(checkbox==false){ err=1; $('.error_msg_checkbox').html("Select any one");  } else{  $('.error_msg_checkbox').html('');  }
	 
	var email =  $('#lead_email').val()
	  if(IsEmail(email)==false){ err=1; $('#lead_email').css("border","1px solid #F58634 "); } else { $('#lead_email').css("border","");}
		  
		// if($('#lead_phone').val()=='' ){ err=1; $('#lead_phone').css("border","1px solid #F58634 "); } else{  $('#lead_phone').css("border","");} 
		  if($('#lead_phone').val()=='' ){ err=1; $('#lead_phone').css("border","1px solid #F58634"); } else{  $('#lead_phone').css("border",""); var lead_phone = $('#lead_phone').val();
	 mobCodeChar = lead_phone.replace(/[^A-Z0-9]+/ig, "");  
	 if(mobCodeChar.length<10) { err=1; $('.error_mobile').html( 'Enter 10 digit Phone number');$('#lead_phone').css("border","1px solid #F58634");  }
   	 else { $('.error_mobile').html(''); $('#lead_phone').css("border",""); }
	 }
	

 	 
  if(err==0) {
	   $('.loading').show();
	   
	   	   $.ajax({
				url: "leads.php",
				type: "POST",
				data:  new FormData(this),
				contentType: false,
				cache: false,
				processData:false,
				success: function(data){ 
			
				var res = data.split("::");
			
				$('.right_bar_div').html('');
				show_services_list();
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


 function IsEmail(email) {
        var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if(!regex.test(email)) {
           return false;
        }else{
           return true;
        }
      }
  
  <?php if($id>0) { ?>  showOtherEnquiryType('<?php echo $lead_enquiry_type; ?>'); <?php  }  ?>
   
   
   function closeLeadForm() {
     $('.right_bar_div').html('');

   }	   
   
   
  function showOtherEnquiryType(type) {
	  var other_enq_div = $('#other_enq_div').hide();
	  if(type=='Other') {  $('#other_enq_div').show(); } 
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
