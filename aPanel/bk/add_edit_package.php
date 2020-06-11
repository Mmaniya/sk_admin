<?php 
$packageId = $_POST['id'];
$btnName = $title = 'Add New ';
if($packageId>0) { 
	$param = array('tableName'=>TBL_PACKAGES,'fields'=>array('*'),'condition'=>array('id'=>$packageId.'-INT'));
	$rsService = Table::getData($param);
	foreach($rsService as $K=>$V)  $$K=$V;
	$btnName = $title = 'Edit ';
}
?>
<script>function toggle(id) {  $('.package_service_type_'+id).toggle();  }</script>
 <div class="card-box">
                                    <h4 class="m-t-0 header-title"><?php echo $btnName; ?> Package </h4>
                                    <p class="text-muted font-14 m-b-20"></p>

                                   <form class="form-horizontal" role="form" id="service_form" enctype="multipart/form-data">
								   
								     <!-- <div class="form-group row" >
                                            <label class="col-md-3 col-form-label">Service Category : </label>
                                            <div class="col-md-5">
                                               <select name="service_category_id" id="service_category_id" class="form-control">
											   <option value="">Select Category</option>
											   <?php 
											$param = array('tableName'=>TBL_SERVICE_CATEGORY,'fields'=>array('*'),'condition'=>array('status'=>'A-CHAR'));
											$rsServiceCategory = Table::getData($param);
											if(count($rsServiceCategory)>0) {
											foreach($rsServiceCategory as $key=>$val) { $selected ='';
											 if($service_category_id==$val->id) { $selected ='selected'; }
											echo '<option value="'.$val->id.'" '.$selected.'>'.$val->category_name.'</option>';
											} }
											   ?>
											   </select>
                                            </div>
                                        </div>  --->
								   
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Package Name : </label>
                                            <div class="col-md-5">
                                                <input type="text" class="form-control" name="package_name" id="package_name" value="<?php echo $package_name; ?>">
                                            </div>
                                        </div>
										
										 <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Description : </label>
                                            <div class="col-md-9">
                                              <textarea name="package_desc" class="form-control" id="package_desc" style="height:135px;"><?php echo $package_desc; ?></textarea>
                                            </div>
                                        </div>
										
										 <div class="form-group row">
                                            <label class="col-md-3 col-form-label" style="padding:0;">is installment allowed : </label>
                                            <div class="col-md-8">
												<input type="radio" class="is_installment_allowed" name="is_installment_allowed" value="Y" <?php if($is_installment_allowed=='Y') { echo 'checked'; } ?>> Yes  
												<input type="radio" class="is_installment_allowed" name="is_installment_allowed" value="N" <?php if($is_installment_allowed=='N') { echo 'checked'; } ?>> No &nbsp; &nbsp; 
                                            </div>
                                        </div>
										
									 
										
										
										 <div class="form-group row">
                                            <label class="col-md-3 col-form-label" style="padding:0;">Service payment Type : </label>
                                            <div class="col-md-8">
												<input type="radio" class="package_payment_plan" name="package_payment_plan" value="OT" <?php if($package_payment_plan=='OT') { echo 'checked'; } ?>> One Time  
												<input type="radio" class="package_payment_plan" name="package_payment_plan" value="RC" <?php if($package_payment_plan=='RC') { echo 'checked'; } ?>> Recurring &nbsp; &nbsp; 
												
											<span style="display:none;" id="recurring_duration">
                     <select name="package_recurring_duration" id="package_recurring_duration">
											 <option value=''>Select Recurring Duration</option>
                     <option value="W" <?php if($package_recurring_duration=='W') { echo 'selected'; } ?>> Weekly  </option>
                     <option value="BW" <?php if($package_recurring_duration=='BW') { echo 'selected'; } ?>> Bi-Weekly</option>
                     <option value="M" <?php if($package_recurring_duration=='M') { echo 'selected'; } ?>> Monthly</option>
                     <option value="Y" <?php if($package_recurring_duration=='Y') { echo 'selected'; } ?>> Yearly</option>
                                            </select> </span>
                                            </div>
											
											 
                                        </div>
										
										
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Price : </label>
                                            <div class="col-md-3" style="display:inline-flex">
                                                 <span style="font-size:21px;">$</span> <input type="text" class="form-control" name="package_price" id="package_price" value="<?php echo $package_price; ?>"> 
                                            </div>
                                        </div>
										
										<div class="form-group row">
                                            <label class="col-md-3 col-form-label">Delivery Time : </label>
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
										
										<div class="form-group row form-headline">
                                            <label class="col-6 col-form-label">Packages Steps </label>
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
													  
										 
										<div class="append_forms inner_service_<?php echo $rowValue; ?>">
										 <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Step Title : </label>
                                            <div class="col-md-5">
                                                <input type="text" class="form-control" value="<?php echo $unserialize['package_name_append'][$i]; ?>" name="package_name_append[]" placeholder="">
                                            </div>
                                        </div>
										
										
										<div class="form-group row">
                                            <label class="col-md-3 col-form-label">Step Description : </label>
                                            <div class="col-md-5">
                                    <textarea name="package_description_append[]"  style="width: 308px;"><?php echo $unserialize['package_description_append'][$i]; ?></textarea>
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
<div class="col-md-5"><button type="button" class="removebtn btn-icon waves-effect waves-light btn-danger btn-sm" onclick="removeServiceRow(<?php echo $rowValue; ?>)"> <i class="fa fa-remove"></i> </button></div>
											
                                        </div>  </div> 
										
														  <?php   break; } }  } } else { ?>
											<div class="append_forms" style="background-color: #f2f2f2;">
										 <div class="form-group row ">
                                            <label class="col-md-3 col-form-label">Step Title  : </label>
                                            <div class="col-md-5">
                                                <input type="text" class="form-control" name="package_name_append[]" placeholder="">
                                            </div>
                                        </div>
										
										
										<div class="form-group row">
                                            <label class="col-md-3 col-form-label">Step Description  : </label>
                                            <div class="col-md-5">
                                             <textarea name="package_description_append[]" class="form-control"   placeholder=""></textarea>
                                            </div>
                                        </div>
										
										
										<div class="form-group row">
                                            <label class="col-md-3 col-form-label" style="padding:0px;">Estimated Time to Complete : </label>
                                            <div class="col-md-2"><input type="text" class="form-control" name="delivery_time_append[]" placeholder=""></div>
                                            <div class="col-md-2">
											      <select class="form-control paddingTop" name="delivery_time_duration_append[]">
												  <option value="D">Days</option>
												  <option value="M">Months</option>
												  <option value="H">Hours</option>
												  </select>
										    </div>   											
                                        </div>
                                        </div>
											<?php } ?>
										
										<div class="appendservice"></div>
										
										<div class="form-group row">
                                            <label class="col-md-12 col-form-label text-right">
											<a class="btn btn-primary btn-sm" href="javascript:void(0)" onclick="AddMoreService()"> <i class="fa fa-plus"></i> Add More </a></label>
									    </div>	
										
										 
								<div class="form-group row form-headline">
                                    <label class="col-md-12 col-form-label" style="text-align:left;"><u>File Upload </u></label>
								</div>	
 
								<div class="form-group row append_forms" style="margin:0px;margin-top:10px;">
								
								  <label class="col-md-2 col-form-label" style="text-align:left;">Info File : </label>
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
										  
									    <a href="service_files/<?php echo $val;?>" download><?php echo $no; ?> )  <?php echo $val; ?></a><br/>  
										<?php   }
								  } } }
								  ?> </div></div>
							 
										
									 <div class="appendinfofile"></div>
										
										
										<div class="form-group row">
										    <label class="col-md-12 col-form-label text-right">
                                            <a class="btn btn-primary btn-sm" href="javascript:void(0)" onclick="addmoreInfoFile()"> <i class="fa fa-plus"></i> Add More </a></label>
									    </div>	
										
										
										<div class="form-group row form-headline">
                                    <label class="col-md-12 col-form-label" style="text-align:left;">Questionnaire / Documents :</label>				 
								
								</div>	
								
                                       <div class="form-group row" style="margin:0px;margin-top: 10px;margin-bottom:10px;">
								
								  <?php 
										 
		$param = array('tableName'=>TBL_DOCUMENTS,'fields'=>array('*'),'orderby'=>'id','sortby'=>'desc','condition'=>array('parent_id'=>'0-INT','status'=>'A-CHAR'));
		$rsDocuments = Table::getData($param);	
		 $document_id = explode(',',$document_id); 
										$i=0;
                                        if(count($rsDocuments)>0) {
										foreach($rsDocuments as $key=>$val) {  $checked=''; 
										 if (in_array($val->id, $document_id))  {  $checked ='checked';   } ?>
										 <div class="col-md-6"> 
					<input type="checkbox" name="document_id[]" value="<?php echo $val->id;?>" <?php echo $checked; ?>> <?php echo $val->doc_name; ?>  	 </div>					
                                         <?php }} ?>
															
							    </div>	 
                     
					  
										
										
                                        <div class="form-group mb-0 justify-content-end row">									 
                                            <div class="col-md-12 preview_button_div">
											<input type="hidden" name="id" value="<?php echo $id;?>"/>
											<input type="hidden" name="act" value="addEditPackage"/>
                                                <button type="submit"  class="btn btn-primary waves-effect waves-light">STEP 2</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
 <style>
.preview_button_div {
    background-color: #f18628b0;
    padding: 20px 7px 20px 17px;
    text-align: right;
}
</style>	
 <script>
 <?php if($package_payment_plan=='RC') { ?>   $('#recurring_duration').show();   <?php } ?>
 
  $(document).ready(function(){
        $(".package_payment_plan").click(function(){
			 $('#recurring_duration').hide();
            var radioValue = $("input[name='package_payment_plan']:checked").val();
            if(radioValue=='RC'){
                $('#recurring_duration').show();
            }
        });
        
    });
	
	
	
	function showAddPackagesServices(id) {
	paramData = {'act':'show_add_package_service','id':id};
	ajax({ 
		a:'package',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		  //$('.right_bar_div').html(data);			  
		  $('.table_div').html(data);			  
		}});	
}


  
var x = 0; 
var max_fields = 100;

  function AddMoreService() { 
		
		if(x < max_fields){
    x++; 
		var html=''
		 html+='<div class="inner_service_'+x+' append_forms"><div class="form-group row">';
			html+='<label class="col-md-3 col-form-label">Step title: </label>';
			html+='<div class="col-md-5">';
			html+='<input type="text" class="form-control" name="package_name_append[]" placeholder="">';
			html+='</div>';
		html+='</div>';


		 html+='<div class="form-group row">';
			 html+='<label class="col-md-3 col-form-label">Step Description : </label>';
			 html+='<div class="col-md-5">';
			   html+='<textarea name="package_description_append[]" style="width: 308px;"  placeholder=""></textarea>';
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
           html+='<div class="col-md-5"><button type="button" class="removebtn btn-icon waves-effect waves-light btn-danger btn-sm" onclick="removeServiceRow('+x+')"> <i class="fa fa-remove"></i> </button></div>';		 
		 html+='</div> </div>';
		 
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
			html+='<div class="form-group append_forms row inner_info_file_'+x_file+'">';
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
	 if($('#package_name').val()=='' ){ err=1; $('#package_name').css("border","1px solid #F58634 "); } else{  $('#package_name').css("border","");}
	 if($('#package_description').val()=='' ){ err=1; $('#package_description').css("border","1px solid #F58634 "); } else{  $('#package_description').css("border","");}
	 if($('#package_price').val()=='' ){ err=1; $('#package_price').css("border","1px solid #F58634 "); } else{  $('#package_price').css("border","");}
	  
	 
	var form = $('#service_form');   
  if(err==0) {
	   $('.loading').show();
	   
	   $.ajax({
url: "package.php",
type: "POST",
data:  new FormData(this),
contentType: false,
cache: false,
processData:false,
success: function(data){ 
var res = data.split("::");
//alert(res[1]);
$('.right_bar_div').html('');
showAddPackagesServices(res[2]);
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
