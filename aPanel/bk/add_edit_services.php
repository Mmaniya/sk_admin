<?php 
$serviceId = $_POST['id'];
$btnName = $title = 'Add New ';
if($serviceId>0) { 
	$param = array('tableName'=>TBL_SERVICES,'fields'=>array('*'),'condition'=>array('id'=>$serviceId.'-INT'));
	$rsService = Table::getData($param);
	foreach($rsService as $K=>$V)  $$K=$V;
}
?>

 <div class="card-box">
                                    <h4 class="m-t-0 header-title">Add Service </h4>
                                    <p class="text-muted font-14 m-b-20"></p>

                                   <form class="form-horizontal" role="form" id="service_form" enctype="multipart/form-data">
                                        <div class="form-group row">
                                            <label class="col-md-4 col-form-label">Service Name : </label>
                                            <div class="col-md-5">
                                                <input type="text" class="form-control" name="service_name" id="service_name" value="<?php echo $service_name; ?>">
                                            </div>
                                        </div>
										
										 <div class="form-group row">
                                            <label class="col-md-4 col-form-label">Description : </label>
                                            <div class="col-md-5">
                                              <textarea name="service_description" id="service_description" style="width: 308px;"><?php echo $service_description; ?></textarea>
                                            </div>
                                        </div>
										
										
                                        <div class="form-group row">
                                            <label class="col-md-4 col-form-label">Service Types : </label>
                                              <div class="col-md-8">
											  <?php $num=0;
											  $param=array();
											  $param = array('tableName'=>TBL_SERVICE_CATEGORY,'fields'=>array('*'),'condition'=>array('status'=>'A-CHAR'));
										$rsServiceCat = Table::getData($param);
										$i=0;
                                        if(count($rsServiceCat)>0) {
										foreach($rsServiceCat as $key=>$val) {?>
					<input type="radio" name="service_category_id" value="<?php echo $val->id;?>" <?php if($service_category_id==$val->id) { echo 'checked'; } ?>> <?php echo $val->category_name;
					 if($num %2) {  echo '<br/>'; }
					 $num++
					?>  				
                                         <?php }} ?>
												
                                              <!--  <input type="radio" name="service_type" value="BP" <?php if($service_type=='BP') { echo 'checked'; } ?>> Business Plan &nbsp;  
                                                <input type="radio" name="service_type" value="C" <?php if($service_type=='C') { echo 'checked'; } ?>> Certificate <br/>
                                                <input type="radio" name="service_type" value="L" <?php if($service_type=='L') { echo 'checked'; } ?>> License &nbsp; &nbsp; 
                                                <input type="radio" name="service_type" value="W" <?php if($service_type=='W') { echo 'checked'; } ?>> Website <br/>
                                                <input type="radio" name="service_type" value="DM" <?php if($service_type=='DM') { echo 'checked'; } ?>> Digital Marketing -->
                                             </div>
                                        </div>
										
										
										 <div class="form-group row">
                                            <label class="col-md-4 col-form-label" style="padding:0px;">Service payment Type : </label>
                                            <div class="col-md-8">
												<input type="radio" class="service_payment_type" name="service_payment_type" value="OT" <?php if($service_payment_type=='OT') { echo 'checked'; } ?>> One Time  
												<input type="radio" class="service_payment_type" name="service_payment_type" value="RC" <?php if($service_payment_type=='RC') { echo 'checked'; } ?>> Recurring &nbsp; &nbsp; 
												
												 <span style="display:none;" id="recurring_duration"> 
												   <select name="service_recurring_duration"> 
												   <option value="">Recurring Duration</option>
														<option value="W" <?php if($service_recurring_duration=='W') { echo 'selected'; } ?>> Weekly  </option>
														<option value="BW" <?php if($service_recurring_duration=='BW') { echo 'selected'; } ?>> Bi-Weekly  </option>
														<option value="M" <?php if($service_recurring_duration=='M') { echo 'selected'; } ?>> Monthly  </option>
														<option value="Y" <?php if($service_recurring_duration=='Y') { echo 'selected'; } ?>> Yearly  </option>
												 </select>
												</span>
                                            </div>
                                        </div>
										
										  										
                                        <div class="form-group row">
                                            <label class="col-md-4 col-form-label">Price : </label>
                                            <div class="col-md-3" style="display:inline-flex">
                                                 <span style="font-size:21px;">$</span> <input type="text" class="form-control" name="service_price" id="service_price" value="<?php echo $service_price; ?>"> 
                                            </div>
                                        </div>
										
										<div class="form-group row">
                                            <label class="col-md-4 col-form-label">Delivery Time : </label>
                                            <div class="col-md-2">
											<input type="text" class="form-control" name="delivery_time" id="delivery_time" value="<?php echo $delivery_time; ?>"></div>
                                            <div class="col-md-2">
											      <select class="form-control paddingTop" name="delivery_time_duration">
												  <option value="D" <?php if($delivery_time_duration=='D') { echo 'selected'; } ?>>Days</option>
												  <option value="M" <?php if($delivery_time_duration=='M') { echo 'selected'; } ?>>Months</option>
												  <option value="M" <?php if($delivery_time_duration=='H') { echo 'selected'; } ?>>Hours</option>
												  </select>
										    </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-4 col-form-label">Days allowed for Questionnaire to complete : </label>
                                            <div class="col-md-2"><input type="text" onkeypress="return restrictAlphabets(event)" class="form-control" name="days_allowed_for_questionnaire" id="days_allowed_for_questionnaire" value="<?php echo $days_allowed_for_questionnaire; ?>"></div>
                                        </div>

										<div class="form-group row form-headline">
                                            <div class="col-md-12 col-form-label">Service Steps</div>
									    </div>		
													   <?php 
											if($service_steps!='') { 
											
                                             $unserialize =  unserialize($service_steps);  	 
													  
													   
													  $no=0;
													   for($i=0;$i<count($unserialize);$i++) {  
													  foreach($unserialize as $key=>$val) {
														  
														
														    
														 
														  // echo($val[$i]);
														  if($unserialize[$key][$i]!='') {
															  
															  $rowValue = rand();
															  ?>
													  
										
										<div class="inner_service_<?php echo $rowValue; ?> append_forms">
										 <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Step Title : </label>
                                            <div class="col-md-5">
                                                <input type="text" class="form-control" value="<?php echo $unserialize['service_name_append'][$i]; ?>" name="service_name_append[]" placeholder="">
                                            </div>
                                        </div>
										
										
										<div class="form-group row">
                                            <label class="col-md-3 col-form-label">Step Description : </label>
                                            <div class="col-md-5">
                                    <textarea name="service_description_append[]"  style="width: 308px;"><?php echo $unserialize['service_description_append'][$i]; ?></textarea>
                                            </div>
                                        </div>
                                        
                                        	
										
										
                                        
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Step Link : </label>
                                            <div class="col-md-5">
                                    <textarea name="service_link_append[]"  style="width: 308px;"><?php echo $unserialize['service_link_append'][$i]; ?></textarea>
                                            </div>
                                        </div>
										
										
										<div class="form-group row">
                                            <label class="col-md-3 col-form-label">Estimated Time to Complete : </label>
                                            <div class="col-md-2">
											  <input type="text" class="form-control" name="delivery_time_append[]" value="<?php echo $unserialize['delivery_time_append'][$i]; ?>"></div>
                                            <div class="col-md-2">
											      <select class="form-control paddingTop" name="delivery_time_duration_append[]">
												  <?php $checkSelect = $unserialize['delivery_time_duration_append'][$i]; ?>
												  <option value="D" <?php if($checkSelect=='D') { echo 'selected'; }?>>Days</option>
												  <option value="M" <?php if($checkSelect=='M') { echo 'selected'; }?>>Months</option>
												  <option value="H" <?php if($checkSelect=='H') { echo 'selected'; }?>>Hours</option>
												  </select>
										    </div>   

											
                                        </div>
                                            <div class="form-group row">
                                                <label class="col-md-3 col-form-label">Labor Hours : </label>
                                                <div class="col-md-2">
                                                    <input type="text" class="form-control" name="labor_hours_append[]" value="<?php echo $unserialize['labor_hours_append'][$i]; ?>">
                                                </div>
                                                <?php if($i > 0) { ?>
                                                <div class="col-md-5"><button type="button" class="removebtn btn-icon waves-effect waves-light btn-danger btn-sm" onclick="removeServiceRow(<?php echo $rowValue; ?>)"> <i class="fa fa-remove"></i> </button></div><?php } ?>
                                            <hr/>  </div>
                                            </div>
										
														  <?php   break; } }  } } else { ?>
											<div class="append_forms">
										 <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Step Title  : </label>
                                            <div class="col-md-5">
                                                <input type="text" class="form-control" name="service_name_append[]" placeholder="">
                                            </div>
                                        </div>
										
										
										<div class="form-group row">
                                            <label class="col-md-3 col-form-label">Step Description  : </label>
                                            <div class="col-md-5">
                                             <textarea name="service_description_append[]" style="width: 308px;"  placeholder=""></textarea>
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Step Link  : </label>
                                            <div class="col-md-5">
                                             <textarea name="service_link_append[]" style="width: 308px;"  placeholder=""></textarea>
                                            </div>
                                        </div>
										
										
										<div class="form-group row">
                                            <label class="col-md-3 col-form-label">Estimated Time to Complete : </label>
                                            <div class="col-md-2"><input type="text" class="form-control" name="delivery_time_append[]" placeholder=""></div>
                                            <div class="col-md-2">
											      <select class="form-control paddingTop" name="delivery_time_duration_append[]">
												  <option value="D">Days</option>
												  <option value="M">Months</option>
												  <option value="H">Hours</option>
												  </select>
										    </div>   
											
                                        </div>
                                        <div class="form-group row">
                                             <label class="col-md-3 col-form-label">Labor Hours : </label>
                                            <div class="col-md-2"><input type="text" class="form-control" name="labor_hours_append[]" placeholder=""></div>
                                         </div>
                                         </div>
											<?php } ?>
										
										<div class="appendservice"></div>
										
										<div class="form-group row">
                                            <label class="col-md-12 col-form-label text-right">
											<a class="btn btn-primary btn-sm" href="javascript:void(0)" onclick="AddMoreService()"> <i class="fa fa-plus"></i> Add More </a></label>
									    </div>	
										
										
										<div class="form-group row form-headline">
                                            <div class="col-md-12 col-form-label">File Upload </div>
									    </div>	
										 

								<div class="form-group row append_forms" style="margin: 0;">
								  <label class="col-12 col-form-label" style="text-align:left">Info File : </label>
								<div class="col-md-5">
								  <input type="file" name="service_files[]">
								</div>
								 <div class="col-md-12">
								 <?php $unserializeForm =  unserialize($service_files); 
								 	  if($service_files!='') {
									  if(count($unserializeForm)>0) {
									  foreach($unserializeForm as $key=>$val) {
										  // echo $val;
										  if($val!='') {
										  $no = $key+1;  ?>
										  
									    <a href="service_files/<?php echo $val;?>"><?php echo $no; ?> )  <?php echo $val; ?></a><br/><hr> 
										<?php   }
								  } } }
								  ?> </div>
								</div>
										
											<div class="appendinfofile"></div>
										
										
										<div class="form-group row">
										    <label class="col-md-12 col-form-label text-right">
                                            <a class="btn btn-primary btn-sm" href="javascript:void(0)" onclick="addmoreInfoFile()"> <i class="fa fa-plus"></i> Add More </a></label>
									    </div>	
										
                                  <div class="form-group row form-headline">
								      <label class="col-md-12 col-form-label">Questionnaire / Documents : </label>
								  </div>
								 <div class="form-group row" style="margin:0px;margin-top: 10px;margin-bottom:10px;">
								
								  <?php  
		$param = array('tableName'=>TBL_DOCUMENTS,'fields'=>array('*'),'orderby'=>'id','sortby'=>'desc','condition'=>array('parent_id'=>'0-INT','status'=>'A-CHAR'));
		$rsDocuments = Table::getData($param);	
		 $document_id = explode(',',$document_id); 
										 
                                        if(count($rsDocuments)>0) {
										foreach($rsDocuments as $key=>$val) {  $checked=''; 
										 if (in_array($val->id, $document_id))  {  $checked ='checked';   } ?>
										 <div class="col-md-6"> 
					<input type="checkbox" name="document_id[]" value="<?php echo $val->id;?>" <?php echo $checked; ?>> <?php echo $val->doc_name;?> </div> 			
                                         <?php }}   ?>
									 </div>								
							     
										
                                        <div class="form-group mb-0 justify-content-end row" style="background-color:#e3f2f3;padding: 10px;">
                                            <div class="col-md-12">
											<input type="hidden" name="id" value="<?php echo $id;?>"/>
											<input type="hidden" name="act" value="addEditService"/>
                                                <button type="submit"  class="btn btn-danger waves-effect waves-light">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
								
 <script>
 <?php if($service_payment_type=='RC') { ?>   $('#recurring_duration').show();   <?php } ?>
 
  $(document).ready(function(){
        $(".service_payment_type").click(function(){
			 $('#recurring_duration').hide();
            var radioValue = $("input[name='service_payment_type']:checked").val();
            if(radioValue=='RC'){
                $('#recurring_duration').show();
            }
        });
        
    });
	
  
var x = 0; 
var max_fields = 100;

  function AddMoreService() {  
		
		if(x < max_fields){
    x++; 
		var html=''
		 html+='<div class="inner_service_'+x+' append_forms"> <div class="form-group row">';
			html+='<label class="col-md-3 col-form-label">Step title: </label>';
			html+='<div class="col-md-5">';
			html+='<input type="text" class="form-control" name="service_name_append[]" placeholder="">';
			html+='</div>';
		html+='</div>';


		 html+='<div class="form-group row">';
			 html+='<label class="col-md-3 col-form-label">Step Description : </label>';
			 html+='<div class="col-md-5">';
			   html+='<textarea name="service_description_append[]" style="width: 308px;"  placeholder=""></textarea>';
			 html+='</div>';
		 html+='</div>';


		 html+='<div class="form-group row">';
			 html+='<label class="col-md-3 col-form-label">Step Link : </label>';
			 html+='<div class="col-md-5">';
			   html+='<textarea name="service_link_append[]" style="width: 308px;"  placeholder=""></textarea>';
			 html+='</div>';
		 html+='</div>';
		 
		 html+='<div class="form-group row">';
			 html+='<label class="col-md-3 col-form-label">Estimated Time to Complete :</label>';
			 html+='<div class="col-md-2"><input type="text" class="form-control" name="delivery_time_append[]" placeholder=""></div>';
			 html+='<div class="col-md-2">';
				   html+='<select class="form-control paddingTop" name="delivery_time_duration_append[]">';
				   html+='<option value="D">Days</option>';
				   html+='<option value="M">Month</option>';
				   html+='<option value="H">Hours</option>';
				   html+='</select>';
			 html+='</div>';
		 html+='</div>';
         html+='<div class="form-group row">';
         html+='<label class="col-md-3 col-form-label">Labor Hours :</label>';
         html+='<div class="col-md-2"><input type="text" class="form-control" name="labor_hours_append[]" placeholder=""></div>';
         html+='<div class="col-md-5"><button type="button" class="removebtn btn-icon waves-effect waves-light btn-danger btn-sm" onclick="removeServiceRow('+x+')"> <i class="fa fa-remove"></i> </button></div>';
            html+='</div>';
		 
		 $('.appendservice').append(html);
		}
  } 		

  function removeServiceRow(id){   $('.inner_service_'+id).remove();   x--; }	
  
  
  var x_file = 0; 
var max_fields_file = 100;

  function  addmoreInfoFile() {
	  if(x_file < max_fields_file){
    x_file++; 
	var html='';
			html+='<div class="append_forms form-group row inner_info_file_'+x_file+'" style="margin:0">';
			  html+='<label class="col-md-2 col-form-label">Info File : </label>';
			html+='<div class="col-md-5">';
			  html+='<input type="file" name="service_files[]">';
			html+='</div>';
			 html+='<div class="col-md-5">';
			  html+='<button type="button" onclick="removeinfoRow('+x_file+')" class="removebtn btn btn-icon waves-effect waves-light btn-danger btn-sm"><i class="fa fa-remove"></i> </button></div>';
			html+='</div>';
	   $('.appendinfofile').append(html);
  }   }
  
   function removeinfoRow(id){ $('.inner_info_file_'+id).remove(); x--; }	
  
  
 
  
  $(document).ready(function (e){   
$("form#service_form").on('submit',(function(e){
e.preventDefault();
	  err=0;
	 if($('#service_name').val()=='' ){ err=1; $('#service_name').css("border","1px solid #F58634 "); } else{  $('#service_name').css("border","");}
	 if($('#service_description').val()=='' ){ err=1; $('#service_description').css("border","1px solid #F58634 "); } else{  $('#service_description').css("border","");}
	 if($('#service_price').val()=='' ){ err=1; $('#service_price').css("border","1px solid #F58634 "); } else{  $('#service_price').css("border","");}
	  
	 
	var form = $('#service_form');

  if(err==0) {
	   $('.loading').show();
	   
	   $.ajax({
url: "services.php",
type: "POST",
data:  new FormData(this),
contentType: false,
cache: false,
processData:false,
success: function(data){
var res = data.split("::");
alert(res[1]);
$('.right_bar_div').html('');
searchForm();
},
error: function(){} 	        
});

	  /*  ajax({ 
  	a:'services',
  	b:form.serialize(),
  	c:function(){},
  	d:function(data){    
    $('.test').html(data);
	 }});  */
 }  
}));
});

 function restrictAlphabets(e){
     var x=e.which||e.keycode;
     //console.log(x);
     if((x>=48 && x<=57) || x==8 ||
         (x>=35 && x<=40)|| x==46)
         return true;
     else
         return false;
 }
  
  </script>


 


<style> 
.form-headline { background-color: #039cfd;color: #fff;margin: 0; }
.form-headline .col-form-label { text-align: left; }
													
.append_forms {  padding-top: 20px; padding-bottom: 10px; }
.append_forms:nth-child(even) {background-color: #f2f2f2; padding-top: 20px; padding-bottom: 10px;}
textarea{border:1px solid #cfcfcf;}
.col-form-label {text-align:right; }
@media screen and (max-width: 768px) {
	.col-form-label {text-align:left; }
	.paddingTop { margin-top:20px; }
	.append_forms { padding:20px; }
	 
	.removebtn { margin-top:10px; float:right; }
}</style>
