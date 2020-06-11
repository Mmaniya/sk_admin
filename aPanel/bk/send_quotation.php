 <?php


 $leadId = $_REQUEST['id'];
 $categoryObj = new ServiceCategory(); 
 
if($leadId>0) { 
	$param = array('tableName'=>TBL_LEADS,'fields'=>array('*'),'condition'=>array('id'=>$leadId.'-INT'));
	$rsLead = Table::getData($param);
	foreach($rsLead as $K=>$V)  $$K=$V;
	$btnName = $title = 'Edit ';  	 	
			 
 }    

$leadsObj = new Leads; 
$packageObj = new Packages; 

$categoryObj = new ServiceCategory();  

?>   
		<script>
 function toggle(id) {  $('.lead_service_type_'+id).toggle();  }
 function togglePackage(id) {  $('.package_service_type_'+id).toggle();  }
 </script>	<div class="card-box"> 
			<form class="form-horizontal" role="form" id="quotation_form" enctype="multipart/form-data">
					<div class="form-group row">
					   <label class="col-md-12 col-form-label">Subject: </label>
						<div class="col-md-7">
							<input type="text" class="form-control" name="subject" id="subject" value="<?php echo $value->subject; ?>">
						</div>
					</div>
					
					
					<div class="form-group row">
					   <label class="col-md-6 col-form-label">Introduction Notes: </label>
					   <label class="col-md-6 col-form-label text-right"><a href="javascript:void(0)" onclick="show_library(2);">[load it from library]</a></label>
						<div class="col-md-12">
						<textarea name="Introduction" id="Introduction" class="form-control" style="margin-top: 0px; margin-bottom: 0px; height: 212px;"><?php echo $Introduction; ?></textarea></div>
					</div>
					
					 
					
					 <div class="form-group row form-headline"  style="margin-bottom: 0;">
						<label class="col-md-12 col-form-label">Service Requested : </label>  
                    </div>
						
				<div class="form-group row" style="margin-bottom:0px;">		
						  
			<div class="col-md-12" style="background-color:#ffffff;padding:20px;">
						  <?php 
					$categoryObj->category_id= $lead_enquiry_for;
					$rsServiceCat = $categoryObj->getCategoryByIds();
   
						$leadsEnquire = explode(',',$lead_enquiry_for);    
						  
					 
					if(count($rsServiceCat)>0) {
					foreach($rsServiceCat as $key=>$val) {
						  if (in_array($val->id, $leadsEnquire)) { 
						  $checked='checked'; echo '<script>   toggle('.$val->id.')</script>'; } 		else{   $checked='';	} 
						 ?>
			<div class="row">
			<label class="col-md-9 col-form-label"><input type="checkbox" class="check_category" name="service_category[]"  onclick="toggle(<?php echo $val->id;?>)"  value="<?php echo $val->id;?>" <?php   echo $checked;  ?>> <?php echo $val->category_name;?>  	</label>	
			 <input type="hidden" name="service_category_id_<?php echo $val->id;?>" value="<?php echo $val->id;?>"/>
			 <input type="hidden" name="service_category_name_<?php echo $val->id;?>" value="<?php echo $val->category_name;?>"/>
			<label class="col-md-3 col-form-label"><a href="javascript:void(0)" onclick="showAppendItem1(<?php echo $val->id;?>)">[add a new subline Item]</a></label>	
                </div>
			 
			<ul class="list_ul lead_service_type_<?php echo $val->id; ?>" style="display:none"> 
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
			<li><input type="checkbox" class="services_amount_checked services_list_checkbox_<?php echo $val->id;?>" name="services_list[][<?php echo $val->id;?>]" value="<?php echo $V->id;?>" <?php echo $checked; ?>>&nbsp;<?php echo $V->service_name?> 
			<input type="hidden" class="service_amount_<?php echo $V->id;?>" name="service_amount_<?php echo $V->id;?>" value="<?php echo $V->service_price; ?>">
			<input type="hidden" class="service_name_<?php echo $V->id;?>" name="service_name_<?php echo $V->id;?>" value="<?php echo $V->service_name; ?>">
			<span class="service_amount"><?php echo money($V->service_price,'$');?> <br/> 
			<a  onclick="view_services(<?php echo $V->id; ?>)" style="float:right;cursor:pointer;"><i class="fa fa-info-circle" aria-hidden="true"></i></a> </span>
			<br/><textarea name="service_desc[][<?php echo $val->id;?>]" style="margin: 0px; height: 45px; width:50%" class="form-control" placeholder="Description"><?php echo $V->service_description;?> </textarea>
			</li>

			<?php } } else { echo '<li>No services found</li>'; } ?></ul>	
			<div class="col-md-12"> <div class="appendNewLine_item_<?php echo $val->id;?>"></div>  </div>
				
					 <?php }} ?> 
                    <p class="error_msg_checkbox" style="color:#ff0000"></p>
                    <span style="clear:both"></span>
						 </div>		
 			 
					</div>
					
			
   
	 
	  <div class="form-group row">   <label class="col-md-12 col-form-label  form-headline" style="text-align:left;">Packages </label>
                                            <div class="col-md-12" style="background-color:#fff;">  
											 
                                             <?php 
											 $packagesId = explode(',',$packages_id);
											 
									$packageObj->package_id= $packages_id;
									$rsPackages = $packageObj->getPackagesByIds();
					
											 
                       if(count($rsPackages)>0) {
                         foreach($rsPackages as $key=>$val) {  
						  $checked='';
                       if (in_array($val->id, $packagesId)) { $checked='checked'; echo '<script>   togglePackage('.$val->id.')</script>';     }
						  ?>
       <label class="col-md-12 col-form-label"> <input type="hidden" name="package_name[<?php echo $val->id; ?>]" value="<?php echo $val->package_name; ?>">		
	   <input type="checkbox" class="package_prices" name="packages_id[]" onclick="togglePackage(<?php echo $val->id; ?>)" value="<?php echo $val->id;?>" <?php echo $checked; ?>>&nbsp;<?php echo $val->package_name?>&nbsp; &nbsp;<div style="float:right;display: inline-flex;">  <span style="font-size:24px;">$</span>
	   <input type="text" name="package_price[<?php echo $val->id; ?>]" class="form-control calculate_attr" value="<?php echo $val->package_price; ?>" style="text-align:right;width:100px;"> &nbsp;&nbsp;  
	  <span onclick="view_packages(<?php echo $val->id; ?>)"  ><i class="fa fa-info-circle" aria-hidden="true"></i></span>
	   </div>    </label>
	   
	   
	   <ul class="package_service_type_<?php echo $val->id; ?>" style="display:none">
    <?php 
 $param = array('tableName'=>TBL_PACKAGE_SERVICES,'fields'=>array('*'),'showSql'=>'N','condition'=>array('package_id'=>$val->id.'-INT'));
			$rsPackageService = Table::getData($param);  
			if(count($rsPackageService)>0) {
			foreach($rsPackageService as $K2=>$V2) {
			
			if($V2->service_id>0) {
			$param = array('tableName'=>TBL_SERVICES,'fields'=>array('*'),'condition'=>array('id'=>$V2->service_id.'-INT'));
			$rsServices = Table::getData($param);
			if($V2->service_id==$rsServices->id) {  $checked='checked';   } 
			?> 
			<input type="hidden" name="package_service_id[]" value="<?php echo $V2->service_category_id; ?>">
			<input type="hidden" name="package_service_name[<?php echo $val->id; ?>][<?php echo $V2->service_id;?>]" value="<?php echo $rsServices->service_name;?>">
<li><input type="checkbox" name="service_id[][<?php echo $val->id; ?>]" value="<?php echo $V2->service_id;?>" <?php echo $checked; ?>>&nbsp;<?php echo $rsServices->service_name;?>   </li>
			<?php }	}  ?> </ul> <?php  }  ?>       
		
              
          					
					   <?php } } ?>	 
                                            </div>											
                                        </div>
										
										 <div class="form-group row" style="background-color: #80808047;padding: 15px; margin-bottom: 0px;">
	  <div class="col-md-12"><strong> Add new line item </strong> </div>
	  <div class="col-md-6"><input type="text" class="form-control" name="add_new_line_item[]" placeholder="Service Name"/>  </div>
	  <div class="col-md-3"></div>
	  <div class="col-md-3"> 
	  <div style="float: right; display: inline-flex;"> 
	         <span style="font-size:24px;">$</span> <input type="text" class="form-control calculate_attr" name="add_new_price[]" style="text-align:right;width:100px;" placeholder="Price"/>&nbsp;&nbsp;&nbsp;&nbsp; </div> </div> 
		  <div class="col-md-6"> <textarea name="add_new_service_desc[]" class="form-control" placeholder="Description"  style="margin: 0px; height: 45px;"></textarea>  </div>
	  
	   <div class="col-md-12"> <div class="appendNewLineItem"></div>  </div>
	   
	  <div class="col-md-12">   
	    <div class="add_more_div"> <a href="javascript:void(0)" onclick="AddMoreLineItem()"><strong>[+]</strong></a> <a href="javascript:void(0)"><strong>[-]</strong></a>  </div>
	 </div>
	</div>
	
	
	  <div class="form-group row" style="background-color:#ffffff;padding: 15px; margin-bottom: 0px;">
	    <div class="col-md-12">
     <div class="bottom-pricetag"> <span>TOTAL</span>
	 <input type="hidden" name="total_amount_before" id="total_amount_before">
      <span class="float-right total-before-discount"></span> </div>
		</div>
		
		<div class="col-md-12">
     <div style="padding: 10px;"> 
	 <input type="checkbox" name="is_discount" class="is_discount" id="is_discount" value="Y"> 
	 <input type="hidden" name="couponcode" value="coupon_code_check"> 
	 <input type="hidden" name="couponcode_amount" id="couponcode_amount"> 
	   DISCOUNT &nbsp;&nbsp;&nbsp;<span style="display:none" id="discountDiv"> 
		<input type="text" style="width:100px;text-align:center;text-transform:uppercase" name="coupon_code"  id="discount_amount" onblur="checkCouponCode()">
		<input type="hidden" name="discount_code_id"  id="discount_code_id">
		</span> <span class="coupecodeError" style="color:#ff0000"></span>  
		
      <span class="float-right">  <span class="discount_amount_span"></span>  </span>  </div>
		</div>
		
		<div class="col-md-12">
     <div class="bottom-pricetag"> <span>TOTAL</span>
	  <input type="hidden" name="final_amount" id="final_amount">
      <span class="float-right total-after-discount"></span> </div>
		</div> 		  
	  </div>
	  
	    
	   <div class="form-group row form-headline"  style="margin-bottom: 0;">
           <label class="col-md-12 col-form-label">Installment : </label>  
      </div>
	   <div class="form-group row" style="background-color: #ffffff;padding: 15px; margin-bottom: 0px;padding-bottom: 0px;">
	  <div class="col-md-12"><p> <input type="checkbox" name="installment" class="installment" id="installment" value="Y"> Is installment </p>
	   </div>
	  
<div class="form-group row" id="installment_div" style="display:none;">

	<div class="col-md-2"> Down Payment($) <br/>
			  <input type="text" class="form-control" name="installment_downpayment" id="installment_downpayment" value="<?php echo $installment_downpaynment; ?>"  onblur="installment_date()">
		</div>
		


	  <div class="col-md-3">Installment Period
			<select name="installment_period" id="installment_period" class="form-control" onchange="installment_date()"> 
	   <option value="2">2 months</option>
	   <option value="3">3 months</option>
	   <option value="4">4 months</option>
	   <option value="5">5 months</option>
	   <option value="6">6 months</option>
	   <option value="7">7 months</option>
	   <option value="8">8 months</option>
	   <option value="9">9 months</option>
	   <option value="10">10 months</option>	  
	   </select> 
		</div>
		
		<div class="col-md-2"> start date
			<input type="text" class="form-control datepicker" name="installment_start_date" id="installment_start_date" onchange="installment_date()" readonly>
		</div>
		
		<div class="col-md-2"> End date
			<input type="text" class="form-control" name="installment_end_date" id="installment_end_date" value="<?php echo $installment_end_date; ?>" readonly>
		</div>
		
		<div class="col-md-2"> Amount($) <br/>
			  <input type="text" class="form-control" name="installment_amount" id="installment_amount" value="<?php echo $installment_amount; ?>" readonly>
		</div>
		 
	</div>
	  
	 </div>
	 
	  
	  <div class="form-group row" style="margin-bottom: 0px;">
	   <div class="col-md-12" style="padding:0px;"> 
	   <div style="padding-top: 15px;padding-bottom: 15px"> Prepared By : 
	     
       <?php 


	$categoryObj->category_id= $lead_enquiry_for;
	$enquiryFor = $categoryObj->getCategoryByIds();

	$leadsObj->emp_type_id = $val->id; 
	$empType = $leadsObj->getUsersBYEmployeeTypeId(); 		  
	if(count($empType)>0) { 
					 
	?>
    <select name="user_id" id="user_id_<?php echo $val->id; ?>">
    <option value="">select</option>
    <?php           
		foreach($empType as $K=>$V) { $selected='';
		$param = array('tableName'=>TBL_LEAD_SPECIALIST,'fields'=>array('*'),'showSql'=>'N','condition'=>array('lead_id'=>$id.'-INT'));
		$rsLeadSpec = Table::getData($param); 
		if(count($rsLeadSpec)>0) {
			foreach($rsLeadSpec as $K2=>$V2) 
				 if($V2->user_id==$V->id) {  $selected='selected';   }   } 
				  echo '<option value="'.$V->id.'" '.$selected.'>'.$V->contact_fname.' '.$V->contact_lname.'</option>';
		  } 
    ?>
    </select> 
	<?php } ?> 	
    </div>
    </div>
    </div>
	  
    <div class="form-group row" style="margin-bottom: 0px;">
    <div class="col-md-12" style="padding:0px;"> 
          <div class="preview_button_div">
                <input type="hidden" name="calculation" value="yes">
                <input type="hidden" name="act" value="submit">
                <input type="hidden" id="lead_id" name="lead_id" value="<?php echo $id; ?>">
                <button type="button" class="btn btn-primary" style="padding: 10px;font-weight: 600;" onclick="previewQuotation()">PREVIEW QUOTATION</button>
          </div>
    </div>
    </div>
                
					</form>
						

<script>
$('.page-title').html(' Quotation for <?php echo $lead_fname.' '.$lead_lname;?>');
$('.page_head_title').html('');
$('.activeBread').html('Leads');




function view_packages(id) {
	paramData = {'act':'view_package','id':id};
	ajax({ 
		a:'package',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		  $('.right_bar_div').html(data);			  
		}});	
}


//alert(4500-(4500/10)); 
		
		 $( function() {
    $( ".datepicker").datepicker({
      changeMonth: true,
      changeYear: true,
    });
  } );
  
  function view_services(id) {
	paramData = {'act':'view_services','id':id};
	ajax({ 
		a:'services',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		  $('.right_bar_div').html(data);			  
		}});	
}


  function show_library(id) {
	paramData = {'act':'show_library','category_id':id};
	ajax({ 
		a:'view_library',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		  $('.right_bar_div').html(data);			  
		}});	
}

  
  
  function installment_date() {
	  var installment_period = $('#installment_period').val();
	  var installment_start_date = $('#installment_start_date').val();
	  var final_amount = $('#final_amount').val();
	  var installment_downpayment = $('#installment_downpayment').val();
	  var installment =  $('input[name="installment"]:checked').val();
	  if(installment_start_date!='' && installment=='Y') {
	paramData = {'act':'installment_date','installment_period':installment_period,'installment_start_date':installment_start_date,'final_amount':final_amount,'installment_downpayment':installment_downpayment};
	ajax({ 
		a:'leads',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
			var res = data.split("::"); 		  
                   
		  $('#installment_end_date').val(res[0].trim());			  
		  $('#installment_amount').val(res[1].trim());	  	  
		}});	
	  }
}
		
	var x1 = 0; 
var max_fields_1 = 100; 
  function showAppendItem1(category_id) { 		
		if(x1 < max_fields_1){
    x1++;  
		var html=''
			html+='<div class="newLineItem_'+category_id+'_'+x1+'" style="margin-bottom:10px;">  <div class="row">'; 				  
      html+='<div class="col-md-6"><input type="text" class="form-control" name="add_new_service_item[]['+category_id+']"  placeholder="Service Name"/>  </div>';
	  html+='<div class="col-md-3"></div>';
	  html+='<div class="col-md-3"><div style="float: right; display: inline-flex;"><span style="font-size:24px;">$</span> <input type="text" class="form-control calculate_attr" name="add_new_service_amount[]['+category_id+']"  style="text-align:right;width:100px;" placeholder="Price"><a href="javascript:void(0)" onclick="removeNewLineItem('+x1+','+category_id+')">[x]</a></div></div> <div class="col-md-6"><textarea class="form-control" placeholder="Description" name="add_new_service_desc[]['+category_id+']" style="margin: 0px; height: 45px;margin-top:10px;"></textarea>  </div> <div class="col-md-12"><hr/></div>'; 				 
      html+='</div></div>'; 		 
      $('.appendNewLine_item_'+category_id).append(html);  	
		}
  } 		


  function removeNewLineItem(id,category_id){   $('.newLineItem_'+category_id+'_'+id).remove();   x1--;   calculation(); }		
				
		
  function showDiscountTextBox(type) {
	  $('#amountBox').hide(); $('#percentageBox').hide();
	  
	  if(type=='amount') {  $('#amountBox').show() }
	  if(type=='percentage') {  $('#percentageBox').show() }
	  
  }   
  
  function formatCurrency(total) {
    var neg = false;
    if(total < 0) {
        neg = true;
        total = Math.abs(total);
    }
    return (neg ? "-$" : '$ ') + parseFloat(total, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString();
}

  $(document).ready(function(){
    $(".check_category").click(function(){ var category_id = $( this ).val();
	
        if ($(this).is(':checked')) {  
			 $(".services_list_checkbox_"+category_id+"").prop("checked", true);
		} else { $(".services_list_checkbox_"+category_id+"").prop("checked", false);
         }   
calculation(); checkCouponCode();		 
    }); 
	
	
	 $(".is_discount").click(function(){  
 calculation();	  installment_date();
 $('#couponcode_amount').val(''); 
 $('.discount_amount_span').html(''); 
        if ($(this).is(':checked')) { 
			 $('#discountDiv').show();
			 
		} else {  $('#discountDiv').hide(); $('#discount_amount').val('');   }        
    }); 
	
	 $(".installment").click(function(){  			   
        if ($(this).is(':checked')) { 
			 $('#installment_div').show();
			 
		} else {  $('#installment_div').hide(); }        
    }); 
	
	
	 
});

 // services check 
 $(".check_category, .services_amount_checked, .package_prices").click(function(){ 
  
calculation(); checkCouponCode();
 });
 
 // when appeded textbox fireup
 $(document).on("blur",".calculate_attr",function() {   
 calculation();  checkCouponCode();
  });
  
calculation();
  function calculation() {
	  
	   var form = $('#quotation_form');
	 //  $('.loading').show();
   ajax({ 
  	a:'leads',
  	b:form.serialize(),
  	c:function(){},
  	d:function(data){   
   var res = data.split("::");
 // alert(res[1]);
  $('.total-before-discount').html(formatCurrency(res[0]));
  //$('.total-after-discount').html(formatCurrency(res[0]));
  
  before_amount = $('#total_amount_before').val(res[0].trim());
  
  couponCodeAmount  = $('#couponcode_amount').val();
 
   $('.total-after-discount').html(formatCurrency(res[0]-couponCodeAmount));
   $('#final_amount').val(res[0]-couponCodeAmount);
 //$('.right_bar_div').html(data);
  //checkCouponCode();
  installment_date();
	 }});  	  
 }  
	  
  
 function checkCouponCode() {
	 $('.coupecodeError').html('');
	var is_discount =  $('input[name="is_discount"]:checked').val();
 
	  var discount_amount = $('#discount_amount').val().trim();;
	  if(is_discount=='Y' && discount_amount!='') { 
  var form = $('#quotation_form');
	ajax({ 
  	a:'process',
  	b:form.serialize(),
  	c:function(){},
  	d:function(data){   
   var res = data.split("::");   
   if(res[0]==1) {  
  // $('#couponcode_amount').val(formatCurrency(res[1])); 
   $('.discount_amount_span').html(formatCurrency(res[1])); 
   // calculation(); 
   $('#discount_code_id').val(res[2]); 
    
	before_amount = $('#total_amount_before').val(); 
	couponCodeAmount  = $('#couponcode_amount').val(res[1]);  
	$('.total-after-discount').html(formatCurrency(before_amount-res[1]));
	$('#final_amount').val(before_amount-res[1]);
   installment_date();
   } 
   if(res[0].trim()==0) {   $('.coupecodeError').html('Not Available');
	$('#couponcode_amount').val(''); 
	$('.discount_amount_span').html(''); 
	installment_date();  calculation();	
   } 
   
   if(res[0].trim()=='') { $('.coupecodeError').html('');   } 
    }});  
	  } else {     calculation();
	  }	 
	   
 }  
  
  function sendQuotation() {
  var form = $('#quotation_form');
	ajax({ 
  	a:'quotation',
  	b:form.serialize(),
  	c:function(){},
  	d:function(data){   
    alert('Quotation Sent Sucessfully');
    show_services_list();
   $('.table_div').show(); 
  // $('.right_bar_div').html('');
   $('.preview_div').html('');
   var lead_id =  $('#lead_id').val();
   show_quotations_lists(lead_id);
   $('html, body').animate({ scrollTop: 0 }, 'slow');
	 }});  	  
 } 
 
 
 
  function previewQuotation() {
  var form = $('#quotation_form');
	ajax({ 
  	a:'preview_quotation',
  	b:form.serialize(),
  	c:function(){},
  	d:function(data){   
   $('.preview_div').html(data); 
   $('.table_div').hide(); 
   $('.right_bar_div').html(''); 
   
	 }});  	  
 } 
 
				 					
var x = 0; 
var max_fields = 100; 
  function AddMoreLineItem() { 		
		if(x < max_fields){
    x++; 
		var html=''
			html+='<div class="innerCategory_'+x+'">  <div class="row"> <div class="col-md-12"><hr/></div>'; 				  
      html+='<div class="col-md-6"><input type="text" class="form-control" name="add_new_line_item[]" placeholder="Service Name"/>  </div>';
	  html+='<div class="col-md-3"></div>';
	  html+='<div class="col-md-3"><div style="float: right; display: inline-flex;"><span style="font-size:24px;">$</span> <input type="text" class="form-control calculate_attr" name="add_new_price[]"   style="text-align:right;width:100px;" placeholder="Price"/><a href="javascript:void(0)" onclick="removeNewLineRow('+x+')">[x]</a></div></div>'; 				 
      html+='<div class="col-md-6"> <textarea name="add_new_line_desc[]" class="form-control" style="margin: 0px; height: 45px;margin-top:0px;" placeholder="Description"></textarea>  </div></div></div>'; 		 
      $('.appendNewLineItem').append(html);
	  
		}
  } 		 
  function removeNewLineRow(id){  $('.innerCategory_'+id).remove();   x--;   calculation();  }	
 
  		 

</script>						
<style> 
.form-control:disabled, .form-control[readonly] {
    background-color: #ffffff;
    opacity: 1;
}

.add_more_div { text-align:right; }
.card-box { border:0px; background-color: #f5f5f5; }
	.list_ul li { border: 1px solid #00000026; margin-bottom: 0px; padding: 5px; }
	.list_ul { list-style-type:none; }
	.service_amount { float:right; }
	
	.bottom-pricetag { background-color: #a3cdda82;  padding: 10px; }
	.preview_button_div {  background-color: #f18628b0; padding: 20px 7px 20px 17px; text-align:right;}
 
.form-headline { background-color: #039cfd;color: #fff;  }
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