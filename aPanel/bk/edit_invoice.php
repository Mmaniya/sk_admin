<?php
  include 'includes.php';
 
  
  $invoice_id = $_POST['invoice_id'];
    
  
  if($invoice_id>0) { 

		$title = 'Update Invoice #BE-'.$invoice_id;  	 	
		$btnName ='Update Invoice';
		$param = array('tableName'=>TBL_INVOICE,'fields'=>array('*'),'condition'=>array('id'=>$invoice_id.'-INT'));
		$rsInvoice = Table::getData($param);
		$installment_start_date = date('m/d/Y',strtotime($rsInvoice->installment_start_date));
		$installment_end_date = date('m/d/Y',strtotime($rsInvoice->installment_end_date));
  }    
  

   if($invoice_id>0) { 
  $param = array('tableName'=>TBL_INVOICE_LINE_ITEM,'fields'=>array('*'),'condition'=>array('invoice_id'=>$invoice_id.'-INT'));
  $rsInvoiceLineItem = Table::getData($param);
   $serviceIds = array();
   $servicesArr=array();
  if(count($rsInvoiceLineItem)>0) {
		foreach($rsInvoiceLineItem as $key=>$val) { 
		 if(!in_array($val->category_id,$categoryIds)) $categoryIds[] = $val->category_id;   
		 $serviceIds[] =   ($val->service_id>0)?$val->service_id:-1; 
		 if($val->service_id > 0)
		 {  
			 $servicesArr[$val->service_id]['amount']=$val->line_amount;
			 $servicesArr[$val->service_id]['desc']=$val->line_desc;
		 }
	  }	 
	}
   }


  	
  $allCategoryObj = new ServiceCategory(); 	
  $allCatgories = $allCategoryObj->getAllActiveCategories();
 
  $categoryObj = new ServiceCategory(); 
  $categoryObj->category_id= $lead_enquiry_for;
  $rsServiceCat = $categoryObj->getCategoryByIds();


  $allPackageObj = new Packages(); 	
  $allPackages = $allPackageObj->getAllActivePackages();
	    if($invoice_id>0) {
			$packageServices1=array();					 
			$packageIds=array();					 
			$param = array('tableName'=>TBL_INVOICE_LINE_ITEM,'fields'=>array('*'),'condition'=>array('invoice_id'=>$invoice_id.'-INT'));
			$rsInvoiceLineItem = Table::getData($param);
			if(count($rsInvoiceLineItem)>0) {
			foreach($rsInvoiceLineItem as $key=>$val) { 
			if($val->package_id>0) { 
				$packageIds[]  =   $val->package_id;   
				$packageServices[] =   $val->package_services;   
				$packagePrice   =   $val->package_price;   
				$packageServices1[$val->package_id] = array('package_id'=>$val->package_id,'package_services'=>$packageServices,'package_price'=>$packagePrice);
			   }
			 }	  
			}	    
		}
  
  $packageObj = new Packages;
  $packageObj->package_id= $packages_id;
  $rsPackages = $packageObj->getPackagesByIds();

  $invoiceObj = new Invoice;   
  $invoiceObj->invoice_id=$invoice_id;
  $empType = $invoiceObj->getUsersBYEmployeeTypeId();   
  
  
 
  
  
 
?>   
		<script>
 function toggle(id) {  $('.lead_service_type_'+id).toggle();  }
  function togglePackage(id) {  
if( $('#package_name_'+id).is(':checked') )
  $('.package_service_type_'+id).show();  else  $('.package_service_type_'+id).hide();
  
  }
 </script>	
 
 <div class="card-box quotation-card"> 
 
    <form class="form-horizontal" role="form" id="invoice_form" enctype="multipart/form-data">
    <input type="hidden" value="add_edit_invoice" name="act" />
     <div class="card-header bg-primary text-white"><h2><?php echo $title;?> <span class="pull-right" style="cursor:pointer" onclick="<?php echo $_POST['processTrack']==1?'showHideTracking()':'searchInvoice()';?>;"> [X] </span> </h2> </div>
   
    
	 <input type="hidden" class="form-control" name="subject" id="subject" value="<?php echo $rsInvoice->subject; ?>">
    
    <div class="form-group row">
    <label class="col-md-6 col-form-label">Introduction Notes: </label>
    <label class="col-md-6 col-form-label text-right"><a href="javascript:void(0)" onclick="show_library(2,'introduction');">[load it from library]</a></label>
    <div class="col-md-12"><textarea name="introduction" id="introduction" class="form-control" style="margin-top: 0px; margin-bottom: 0px; height: 212px;"><?php echo $rsInvoice->introduction; ?></textarea></div>
    </div>
					
					 
					
    <div class="form-group row">
	 <label class="col-md-7 col-form-label">Service Requested : </label>  
    </div>
						
     <div class="form-group row" style="margin-bottom:0px;">
     <div class="col-md-12" style="background-color:#ffffff;padding:20px;">
	 <?php 
		
	if(count($allCatgories)>0) {
	foreach($allCatgories as $key=>$val) {
		if(count($categoryIds)>0) {
			$isCheckedCat=  false;
		  if (in_array($val->id, $categoryIds)) { 	$isCheckedCat=true; $checked= 'checked="checked"'; } 		else{  $isCheckedCat=  false; $checked='';	}  }
									 ?>
                <div class="row">
                <label class="col-md-9 col-form-label">
                <input type="checkbox" class="check_category" name="service_category[]"  onclick="toggle(<?php echo $val->id;?>)"  value="<?php echo $val->id;?>" <?php   echo $checked;  ?>> 
				<?php echo $val->category_name;?>  	</label>	
                <input type="hidden" name="service_category_id_<?php echo $val->id;?>" value="<?php echo $val->id;?>"/>
                <input type="hidden" name="service_category_name_<?php echo $val->id;?>" value="<?php echo $val->category_name;?>"/>
                <label class="col-md-3 col-form-label"><a href="javascript:void(0)" onclick="showAppendItem1(<?php echo $val->id;?>)">[add a new subline Item]</a></label>	
                </div>
			 
			<ul class="list_ul lead_service_type_<?php echo $val->id; ?>"  <?php if(!$isCheckedCat){ ?> style="display:none" <?php } ?>  >
	
			
			<?php 
			

			$param = array('tableName'=>TBL_SERVICES,'fields'=>array('*'),'condition'=>array('service_category_id'=>$val->id.'-INT'));
			$rsServiceRes = Table::getData($param);
			if(count($rsServiceRes)>0) {
			foreach($rsServiceRes as $K=>$V) {  
			$checked='';
		    
			if (in_array($V->id, $serviceIds)) {  $checked='checked="checked"';    } else { $checked='';	  } 
			
				
			?> 
			<li>
            <input type="checkbox"  class="services_amount_checked services_list_checkbox_<?php echo $val->id;?>" name="services_list[][<?php echo $val->id;?>]" 
            value="<?php echo $V->id;?>" <?php echo $checked; ?>>&nbsp;<?php echo $V->service_name?> 			
			<input type="hidden" class="service_name_<?php echo $V->id;?>" name="service_name_<?php echo $V->id;?>" value="<?php echo $V->service_name; ?>">
			<span class="service_amount">
			<input type="text" style="width: 40%;text-align: right;" class="serviceAmount service_amount_<?php echo $V->id;?> form-control" name="service_amount_<?php echo $V->id;?>" value="<?php echo $servicesArr[$V->id]['amount'] > 0?$servicesArr[$V->id]['amount']:$V->service_price; ?>">
            <a  onclick="view_services(<?php echo $V->id; ?>)" style="cursor:pointer;"><i class="fa fa-info-circle pull-right" aria-hidden="true"></i></a> </span>
			<br/><textarea name="service_desc[<?php echo $V->id;?>][<?php echo $val->id;?>]" style="margin: 0px; height: 45px; width:50%" class="form-control" placeholder="Description"><?php echo ($servicesArr[$V->id]['desc']!='')?$servicesArr[$V->id]['desc']:$V->service_description;?> </textarea>
			</li>

			<?php } } else { echo '<li>No services found</li>'; } ?></ul>	
			<div class="col-md-12">
			<div class="appendNewLine_item_<?php echo $val->id;?>">
			
			<?php 
			
			if($invoice_id>0) {
			$param = array('tableName'=>TBL_INVOICE_LINE_ITEM,'fields'=>array('*'),'condition'=>array('invoice_id'=>$invoice_id.'-INT','category_id'=>$val->id.'-INT','service_id'=>'0-INT'));
			$rsInvoiceLineItem = Table::getData($param);
			if(count($rsInvoiceLineItem)>0) {
			foreach($rsInvoiceLineItem as $K1=>$V1) {  ?>  		 
                <div class="newLineItem_<?php echo $val->id;?>_<?php echo $V1->id;?>" style="margin-bottom:10px;">
                <div class="row"> 				  
                <div class="col-md-6"><input type="text" class="form-control" name="add_new_service_item[][<?php echo $val->id;?>]" value="<?php echo $V1->line_item;?>"/></div> 
                <div class="col-md-3"></div> 
                <div class="col-md-3">
                <div style="float: right; display: inline-flex;"><span style="font-size:24px;">$</span><input type="text" class="form-control calculate_attr" name="add_new_service_amount[][<?php echo $val->id;?>]"  style="text-align:right;width:100px;" value="<?php echo $V1->line_amount;?>"/>
                <a href="javascript:void(0)" onclick="removeNewLineItem(<?php echo $V1->id;?>,<?php echo $val->id;?>)">[x]</a></div></div>  				 
                <div class="col-md-6"><textarea class="form-control" placeholder="Description" name="add_new_service_desc[][<?php echo $val->id;?>]" style="margin: 0px; height: 45px;margin-top:10px;"><?php echo $V1->line_desc;?></textarea>  </div> <div class="col-md-12"><hr/></div> 
				<input type="hidden" name="add_new_service_id[][<?php echo $val->id;?>]" value="<?php echo $V1->id;?>">				
                </div></div> 
	      <?php }} }  ?> 
	  
			</div>
			
			</div>
			
			 <?php } } ?>
			 	
     <p class="error_msg_checkbox" style="color:#ff0000"></p><span style="clear:both"></span></div>		</div>
					
					
					 
	  <div class="form-group row">   
      <label class="col-md-12 col-form-label  form-headline" style="text-align:left;">Packages </label>
      <div class="col-md-12" style="background-color:#fff;">  
											 
	<?php 
	

		if(count($allPackages)>0) {
		foreach($allPackages as $key=>$val) {  
		  $checked='';
		$packId =  $packageServices1[$val->id]['package_id'];
		$packPrice =  $packageServices1[$val->id]['package_price'];
		if($packId!='') { $packServices  =  implode(',',$packageServices1[$val->id]['package_services']); }
		
		if ($val->id==$packId) {  $checked='checked="checked"'; } else { $checked='';	} 
		
		
		$isCheckedCat=  false;
		if (in_array($val->id, $packageIds)) { 	$isCheckedCat=true; $checked= 'checked="checked"'; } 		else
		{  $packPrice = $val->package_price; 
		
		$isCheckedCat=  false; $checked='';	}  
		  
		  
						  ?>
       <label class="col-md-12 col-form-label"> <input type="hidden" name="package_name[<?php echo $val->id; ?>]" value="<?php echo $val->package_name; ?>">		
       <input type="hidden" name="total_package_name_<?php echo $val->id;?>" value="<?php echo $val->package_name;?>"/>
	   <input type="checkbox" class="package_prices" name="packages_id[]" id="package_name_<?php echo $val->id;?>" onclick="togglePackage(<?php echo $val->id; ?>)" value="<?php echo $val->id;?>" <?php echo $checked; ?>>&nbsp;<?php echo $val->package_name?>&nbsp; &nbsp;<div style="float:right;display: inline-flex;">  <span style="font-size:24px;">$</span>
	   <input type="text" name="package_price[<?php echo $val->id; ?>]" class="form-control calculate_attr" value="<?php echo $packPrice; ?>" style="text-align:right;width:100px;">
	   </div></label>
	   
	   
	   <ul class="package_service_type_<?php echo $val->id; ?>" <?php if(!$isCheckedCat){ ?> style="display:none" <?php } ?>>
    <?php     
	                      
	  if($packId!='') {  $packServices =  explode(',',$packServices);    }
		    $param = array('tableName'=>TBL_PACKAGE_SERVICES,'fields'=>array('*'),'showSql'=>'N','condition'=>array('package_id'=>$val->id.'-INT'));
			$rsPackageService = Table::getData($param);  
			if(count($rsPackageService)>0) {
				foreach($rsPackageService as $K2=>$V2) {
			 	   $checked='';
				   if($V2->service_id>0) {
						$param = array('tableName'=>TBL_SERVICES,'fields'=>array('*'),'condition'=>array('id'=>$V2->service_id.'-INT'));
						$rsServices = Table::getData($param);
		 			    if($packId!='') {   if (in_array($V2->service_id, $packServices)) {  $checked='checked'; }  }
			?> 
			<input type="hidden" name="package_service_id[]" value="<?php echo $V2->service_category_id; ?>">
			<input type="hidden" name="package_service_name[<?php echo $val->id; ?>][<?php echo $V2->service_id;?>]" value="<?php echo $rsServices->service_name;?>">
            <li><input type="checkbox" name="service_id[][<?php echo $val->id; ?>]" value="<?php echo $V2->service_id;?>" <?php echo $checked; ?>>&nbsp;<?php echo $rsServices->service_name;?>   </li>
			<?php }	
			
			}  ?> </ul> <?php  }  ?>       

					   <?php } } ?>	 
            </div>											
          </div>
					
					
    <div class="form-group row" style="background-color: #80808047;padding: 15px; margin-bottom: 0px;">
	  <div class="col-md-12"><strong> Add new line item </strong> </div>
	 
	  
	   <div class="col-md-12"> <div class="appendNewLineItem">
	   <?php $param = array('tableName'=>TBL_INVOICE_LINE_ITEM,'fields'=>array('*'),'condition'=>array('invoice_id'=>$invoice_id.'-INT','category_id'=>'0-INT','package_id'=>'0-INT'));
	$rsInvoiceLineItem = Table::getData($param);
	if(count($rsInvoiceLineItem)>0) {
	foreach($rsInvoiceLineItem as $K1=>$V1) {  ?>
	   <div class="innerCategory_<?php echo $V1->id;?>">  <div class="row">   <div class="col-md-12"><hr/></div>			  
      <div class="col-md-6"><input type="text" class="form-control" name="add_new_line_item[]" value="<?php echo $V1->line_item;?>"/>  </div> 
	  <div class="col-md-3"></div> 
	   <div class="col-md-3"><div style="float: right; display: inline-flex;"><span style="font-size:24px;">$</span> <input type="text" class="form-control calculate_attr" name="add_new_price[]" value="<?php echo $V1->line_amount;?>"  style="text-align:right;width:100px;"/><a href="javascript:void(0)" onclick="removeNewLineRow(<?php echo $V1->id;?>)">[x]</a></div></div> 	
<div class="col-md-6"> <textarea name="add_new_line_desc[]" class="form-control" style="margin: 0px; height: 45px;margin-top:0px;" placeholder="Description"><?php echo $V1->line_desc;?></textarea>  </div>
<input type="hidden" name="add_new_line_item_id[]" value="<?php echo $V1->id;?>">
	   
     </div></div>
	<?php } } ?>
	   
	   
	   </div>  </div>
	   
	  <div class="col-md-12">   
	    <div class="add_more_div"> <a href="javascript:void(0)" onclick="AddMoreLineItem()"><strong>[+]</strong></a> <a href="javascript:void(0)"><strong>[-]</strong></a>  </div>
	 </div>
	</div>
	 
	
	  <div class="form-group row" style="background-color:#ffffff;padding: 15px; margin-bottom: 0px;">
	    <div class="col-md-12">
     <div class="bottom-pricetag"> <span>TOTAL</span>
	 <input type="hidden" name="total_amount_before" id="total_amount_before" value="<?php echo $rsInvoice->quotation_amount; ?>">
      <span class="float-right total-before-discount"></span> </div>
		</div>
		
		<div class="col-md-12">
     <div style="padding: 10px;"> 
	 <input type="checkbox" name="is_discount" class="is_discount" id="is_discount" value="Y"> 
	 <input type="hidden" name="couponcode" value="coupon_code_check"> 
	 <input type="hidden" name="couponcode_amount" id="couponcode_amount"  value="<?php echo $rsInvoice->discount_amount ?>"> 
	   DISCOUNT &nbsp;&nbsp;&nbsp;<span style="display:none" id="discountDiv"> 
		<input type="text" style="width:100px;text-align:center;text-transform:uppercase;" name="coupon_code"  id="discount_amount" value="<?php echo $rsInvoice->discount_code;?>" onblur="checkCouponCode()">
		<input type="hidden" name="discount_code_id"  id="discount_code_id" value="<?php echo $rsInvoice->discount_id; ?>">
		</span> <span class="coupecodeError" style="color:#ff0000"></span>  
		
      <span class="float-right">  <span class="discount_amount_span"></span>  </span>  </div>
		</div>
		
        <div class="col-md-12">
        <div class="bottom-pricetag"> <span>TOTAL</span> <input type="hidden" name="final_amount" id="final_amount">  <span class="float-right total-after-discount"></span> </div>
        </div> 		  
        </div>
        
        <div class="form-group row"><label class="col-md-7 col-form-label"  style="padding-left:0;padding-top:15px;padding-bottom:0;">Installment : </label>  
        </div>
        <div class="form-group row" style="background-color: #ffffff;padding: 15px; margin-bottom: 0px;padding-bottom: 0px;">
        <div class="col-md-12"><p> <input type="checkbox" name="installment" class="installment" id="installment" value="Y" <?=($rsInvoice->installment=='Y')?'checked':'';?>> Is Installment? </p>
        </div>
	  
	 
 <div class="form-group row" id="installment_div" style="display:none;">

 <div class="col-md-12">
	 <p> <input type="radio" name="installment_payment_type" value="A" <?php if($rsInvoice->installment_type!='M') echo 'checked="checked"';  ?> onclick="installmentPaymentType('A')">Automatic
	  <input type="radio" name="installment_payment_type" value="M" <?php if($rsInvoice->installment_type=='M') echo 'checked="checked"';  ?> onclick="installmentPaymentType('M')">Manual </p>
 </div>
 
 <div class="col-md-12">
        <div class="row">
        <div class="col-md-3"> Down Payment($) <br/>
        <input type="text" class="form-control" name="installment_downpayment" id="installment_downpayment" value="<?php echo $rsInvoice->installment_downpayment; ?>"  onblur="installment_date()">
        </div>
        
        <div class="col-md-3">Installment Period  
        <select name="installment_period" id="installment_period" class="form-control" onchange="installment_date(),installmentPaymentDiv()"> 
		<option value="1">1 month</option>
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
        
 </div>


</div>
		
 <div class="installment_automatic" <?php if($rsInvoice->installment_type=='M') echo 'style="display:none"';  ?> >
		
		<div class="col-md-12">
		<div class="row">
		<div class="col-md-4"> start date
			<input type="text" class="form-control datepicker" name="installment_start_date" id="installment_start_date" value="<?php echo date('m/d/Y',strtotime($installment_start_date)); ?>"  onchange="installment_date()" readonly>
		</div>
		
		<div class="col-md-4"> End date
			<input type="text" class="form-control datepicker" name="installment_end_date" id="installment_end_date" value="<?php echo date('m/d/Y',strtotime($installment_end_date)); ?>" readonly>
		</div>
		
		<div class="col-md-4"> Amount($) <br/>
			  <input type="text" class="form-control" name="installment_amount" id="installment_amount" value="<?php echo $installment_amount; ?>" readonly>
		</div>
	  </div>
	  </div>
			 
	</div>	 
  
 <div class="col-md-12">
  <?php

       $param = array('tableName'=>TBL_INVOICE_INSTALLMENT,'fields'=>array('*'),'showSql'=>'N','condition'=>array('invoice_id'=>$invoice_id.'-INT'));
       $rsQuoInstallment = Table::getData($param); 
	   ?>
   <div class="installment_manual"  <?php   if($rsInvoice->installment_type!='M') {?>  style="display:none" <?php } ?>>
     
	 <?php

      
       if(count($rsQuoInstallment)>0) {
		 
        foreach($rsQuoInstallment as $key=>$val) { 
	
		 ?>
   
    <div class="row">
    
	   <div class="col-md-2">
      
	   <p> Date : <input type="text" name="installment_date[]" class="form-control datepicker" value="<?php echo date('m/d/Y',strtotime($val->installment_date)); ?>" />   </p>
       </div>	
	   
	   <div class="col-md-2">
	   <p> Amount : <input type="text" name="amount[]" class="form-control" value="<?php echo $val->amount; ?>"> </p>
       </div>		   
	</div>	
	 
   <?php } } ?> 
  </div>
 <span class="test_span"></span>  
 </div>		

 
 </div>	
	  
	 </div>
	 
	  
	  
      
      
        
    <div class="form-group row">
    <label class="col-md-6 col-form-label">Conclusion Notes: </label>
    <label class="col-md-6 col-form-label text-right"><a href="javascript:void(0)" onclick="show_library(2,'conclusion');">[load it from library]</a></label>
    <div class="col-md-12"><textarea name="conclusion" id="conclusion" class="form-control" style="margin-top: 0px; margin-bottom: 0px; height: 212px;"><?php echo $rsInvoice->conclusion; ?></textarea></div>
    </div>
	<div class="form-group row">
    <label class="col-md-6 col-form-label">Internal Comments: </label>    
    <div class="col-md-12"><textarea name="internal_comments" id="internal_comments" class="form-control" style="margin-top: 0px; margin-bottom: 0px; height: 212px;"><?php echo $rsInvoice->internal_comments; ?></textarea></div>
    </div>
			<div class="form-group row" style="margin-bottom: 0px;">
	   <div class="col-md-12" style="padding:0px;"> 
	   <div style="padding-top: 15px;padding-bottom: 15px"> Prepared By : 
	     
       <?php 
					  if(count($empType)>0) { 
					 
					  ?>
				<select name="user_id" id="user_id_<?php echo $val->id; ?>">
				<option value="">select</option>
				<?php           
					 foreach($empType as $K=>$V) { 
					   $selected='';
					   if($rsInvoice->sent_by==$V->id) $selected='selected';
				  	  echo '<option value="'.$V->id.'" '.$selected.'>'.$V->contact_fname.' '.$V->contact_lname.'</option>';
				  } 
				?>
		  </select> <?php } ?> 	
		
		</div>
		</div>
	  </div>	
	  
	   <div class="form-group row" style="margin-bottom: 0px;">
	    <div class="col-md-12" style="padding:0px;"> 
			  <div class="preview_button_div">
					<input type="hidden" name="calculation" value="yes">
				
					<input type="hidden" id="lead_id" name="lead_id" value="<?php echo $id; ?>">
					<input type="hidden" name="invoice_id" value="<?php echo $rsInvoice->id; ?>">
					<button type="button" class="btn btn-primary" style="padding: 10px;font-weight: 600;" onclick="sendInvoice(<?php echo $rsInvoice->id; ?>)"><?=$btnName?></button>
			  </div>
	    </div>
	   </div>
		 </form>
         
         </div>
	
    <style>
	.library_div{
	position:relative;	
	}
	</style>	 
     <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>     
    
<script>
 

   function show_library(id,content_load_id) {
	
	
	paramData = {'act':'show_library','category_id':id,'content_load_id':content_load_id};
	ajax({ 
		a:'view_library',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
			var offset = $( "#"+content_load_id ).offset();
			$(".library_div").css({top: offset.top-100, left: offset.left-300, position:'absolute'});
			$('.library_div').show();	

/*$(".library_div").position({
		my:        "right top",
		at:        "right bottom",
		of:        $("#"+content_load_id), // or $("#otherdiv")
		collision: "fit"
	});*/
	
;
  $('.library_div').html(data);	
  
		}});	
}


 $('select[name^="user_id"] option[value="<?php echo $rsInvoice->sent_by; ?>"]').attr("selected","selected");

/*
$('.page-title').html(' Quotation for <?php echo $lead_fname.' '.$lead_lname;?>');
$('.page_head_title').html('');
$('.activeBread').html('Leads');
*/
//alert(4500-(4500/10)); 
		
		
  
  
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

function installmentPaymentType(type) { 	 
	 $('.installment_automatic').hide();  $('.installment_manual').hide();
	 
	 if(type=='A') { installment_date(); $('.installment_automatic').show(); }
	 if(type=='M') { installmentPaymentDiv(); $('.installment_manual').show(); }
	 
 }
 
var datePickerOptions = {
    dateFormat: 'dd/mm/yyyy',
    firstDay: 1,
    changeMonth: true,
    changeYear: true
    // ...
}

  function installmentPaymentDiv() { 		
		  var html='' 
		   //alert($('#installment_period').val());
		  var installmentInputs = document.getElementsByName("installment_date[]"); 
		   
		  var startIndex = installmentInputs.length;  
		  var startInd = startIndex;
		   period = $('#installment_period').val();
		 
		  var amount = $('#installment_amount').val();  
		 // $('.test_span').html(''+startInd+' - '+period+'');
		  //if(period==2)  period=2; 
  	      //for(i=0;i<period;i++) {  
  	       for(i=startIndex;i<period;i++) {  
		       html+='<div class="row">';
			   html+='<div class="col-md-2">';
			   html+='<p> Date : <input type="text" name="installment_date[]" id="ins_date_'+i+'" class="form-control datepicker">  </p>';
			   html+='</div>';	
			   
			   html+='<div class="col-md-2">';
			   html+='<p> Amount : <input type="text" name="amount[]" class="form-control" value="'+amount+'"> </p>';
			   html+='</div>';		   
			   html+='</div>';	 		
		   }
		   $('.installment_manual').append(html);  
		if(period>startIndex)  
			 $('.installment_msssanual').append(html);  
		else {  	   
	       do {    
			    $('div.installment_manual').children().last().remove();
			  // $('.row:last-child').remove();
			   installmentInputs = document.getElementsByName("installment_date[]");
			   startIndex = installmentInputs.length;  
		   } while(startIndex>period); 
		}
		
		
		
		 for(i=startIndex;i<period;i++) $('#ins_date'+i).datepicker();
			$('[name="amount[]"]').val(amount);  
			
			if(startInd==0) $('#ins_date_'+0).val($.datepicker.formatDate('mm/dd/yy', new Date()));  
		}




  function installment_date() { 
	  var installment_period = $('#installment_period').val();
	   var installment_payment_type = $('#installment_payment_type').val();
	  var installment_start_date = $('#installment_start_date').val();
	  var final_amount = $('#final_amount').val();
	  var installment_downpayment = $('#installment_downpayment').val();
	  var installment =  $('input[name="installment"]:checked').val();
	  if(installment_start_date=='') { installment_start_date = $.datepicker.formatDate('mm/dd/yy', new Date());$('#installment_start_date').val(installment_start_date); }
	  if(installment_start_date!='' && installment=='Y') {
	paramData = {'act':'installment_date','installment_payment_type':installment_payment_type,'installment_period':installment_period,'installment_start_date':installment_start_date,'final_amount':final_amount,'installment_downpayment':installment_downpayment};
	ajax({ 
		a:'process',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
			var res = data.split("::"); 		  
                   
		  $('#installment_end_date').val(res[0].trim());			  
		  $('#installment_amount').val(res[1].trim());	  	  
		  $('[name="amount[]"]').val(res[1].trim()); 
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
      html+='<div class="col-md-6"><input type="text" class="form-control" name="add_new_service_item[]['+category_id+']"/>  </div>';
	  html+='<div class="col-md-3"></div>';
	  html+='<div class="col-md-3"><div style="float: right; display: inline-flex;"><span style="font-size:24px;">$</span> <input type="text" class="form-control calculate_attr" name="add_new_service_amount[]['+category_id+']"  style="text-align:right;width:100px;"/><a href="javascript:void(0)" onclick="removeNewLineItem('+x1+','+category_id+')">[x]</a></div></div>'; 				 
      html+='</div></div>'; 		 
      $('.appendNewLine_item_'+category_id).append(html);  	
		}
  } 		


  function removeNewLineItem(id,category_id){   $('.newLineItem_'+category_id+'_'+id).remove();   x1--; calculation(); checkCouponCode(); }		
				
		
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
	
	isDiscountCheck('<?php echo $rsInvoice->is_discount; ?>');
	function isDiscountCheck(type) {
		$('#discountDiv').hide();
		if(type=='Y') { $('#discountDiv').show(); $('input[name=is_discount]').attr('checked', true);
		checkCouponCode();
  }
		
	}
	
	
	
	
	 $(".installment").click(function(){  	
		$('#installment_downpayment').val('');
		$('#installment_start_date').val('');
		$('#installment_end_date').val('');
		$('#installment_amount').val('');	
        if ($(this).is(':checked')) { 
			 $('#installment_div').show();
			 
		} else {  $('#installment_div').hide(); }        
    }); 
	
	isInstallmentYes('<?php echo $rsInvoice->installment; ?>');
	function isInstallmentYes(type)  {  
	$('select[name^="installment_period"] option[value="<?php echo $rsInvoice->installment_period; ?>"]').attr("selected","selected");

	
	   $('#installment_div').hide();  
	   if(type=='Y') { $('#installment_div').show(); $('input[name=installment]').attr('checked', true);  } else { $('#installment_downpayment').val('');
	$('#installment_start_date').val('');
	$('#installment_end_date').val('');
	   $('#installment_amount').val('');   }
	} 
	
	
	

});





$(document).on('click', '.datepicker', function(){
   $(this).datepicker({
      changeMonth: true,
      changeYear: true
     }).focus();
   $(this).removeClass('datepicker'); 
});

//service amount changed
$(document).on("blur",".serviceAmount",function() {   
 calculation();  checkCouponCode();  
  });

 // services check 
 $(".check_category,.services_amount_checked,.package_prices").click(function(){    
calculation(); checkCouponCode();  
 });
 
 // when appeded textbox fireup
 $(document).on("blur",".calculate_attr",function() {   
 calculation();  checkCouponCode();  
  });
  

  function calculation() {
	
	  
	var form = $('#invoice_form');
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
		// checkCouponCode();
		installment_date();
	 }});  	  
 }  
	  
  
 function checkCouponCode() {
	 $('.coupecodeError').html('');
	var is_discount =  $('input[name="is_discount"]:checked').val();
    var coupon_code = $('input[name="coupon_code"]').val();

	  if(is_discount=='Y' && coupon_code!='') { 
	paramData = {'act':'coupon_code_check','coupon_code':coupon_code};
	
	ajax({ 
  	a:'process',
  	b:$.param(paramData),
  	c:function(){},
  	d:function(data){ 	
   var res = data.split("::"); 

   if(res[0]==1) {  

  // $('#couponcode_amount').val(formatCurrency(res[1])); 
   
   // calculation(); 
   $('#discount_code_id').val(res[2]); 
    var discount_amount=0;
	var coupon_value='';
	before_amount = $('#total_amount_before').val(); 
	
	var couponType =  res[3];
	if(couponType=='P' ) {
		coupon_value = res[1]+' %';
		discount_amount = parseFloat(before_amount)*(parseFloat(res[1])/100);
	} else {
		discount_amount = res[1];

		
	}
	var after_discount_amount=parseFloat(before_amount-discount_amount);
	$('.discount_amount_span').html(formatCurrency(discount_amount)); 
	couponCodeAmount  = $('#couponcode_amount').val(discount_amount);  
	$('.total-after-discount').html(formatCurrency(after_discount_amount));
	$('#final_amount').val(after_discount_amount);
   installment_date();
   } 
   if(res[0].trim()==0) {   $('.coupecodeError').html('Not Available');
	$('#couponcode_amount').val(''); 
	$('.discount_amount_span').html(''); 
	installment_date();  calculation();	
   } 
      if(res[0].trim()==-1) {   $('.coupecodeError').html('Invalid Coupon Date');
	$('#couponcode_amount').val(''); 
	$('.discount_amount_span').html(''); 
	installment_date();  calculation();	
   } 
   
   if(res[0].trim()=='') { $('.coupecodeError').html('');   } 
    }});  
	  } else {     calculation();
	  }	 
	   
 }  
  
  function sendInvoice(invId) {
  var form = $('#invoice_form');
	ajax({ 
  	a:'process',
  	b:form.serialize(),
  	c:function(){},
  	d:function(data){   
//alert(data);
  
   alert('Invoice Updated Sucessfully');

  <?php if($_POST['processTrack']==1) { ?>
    $('.preview_div').fadeOut();
	$('#filter_type').val('filter');
	filterOption('filter');
	$('.table_div').fadeIn('3000');
  <?php } else { ?> searchInvoice();$('.table_div').show(); <?php } ?>
       
   //invoiceRow_
   	$('html, body').animate({ scrollTop: 0 }, 'slow');
   
	 }});  	  
 } 
 
 
 
  function previewQuotation() {
  var form = $('#invoice_form');
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
      html+='<div class="col-md-6"><input type="text" class="form-control" name="add_new_line_item[]"/>  </div>';
	  html+='<div class="col-md-3"></div>';
	  html+='<div class="col-md-3"><div style="float: right; display: inline-flex;"><span style="font-size:24px;">$</span> <input type="text" class="form-control calculate_attr" name="add_new_price[]"   style="text-align:right;width:100px;"/><a href="javascript:void(0)" onclick="removeNewLineRow('+x+')">[x]</a></div></div>'; 				 
      html+='</div></div>'; 		 
      $('.appendNewLineItem').append(html);
	  
		}
  } 		 
  function removeNewLineRow(id){  $('.innerCategory_'+id).remove();   x--;   calculation();checkCouponCode();  }	
 
<?php
 if($invoice_id>0) { 
?>  		 
calculation();
<?php
 }
?>

function closeLibraryDiv() {
   $('.library_div').hide();	
}


$(document).ready(function() {

    $('.datepicker').datepicker({
        format: 'dd/mm/yyyy'
    });
});

</script>						
<style> 
.form-control:disabled, .form-control[readonly] {
    background-color: #ffffff;
    opacity: 1;
}

.add_more_div { text-align:right; }
  quotation-card { border:0px; background-color: #f5f5f5; padding: 0; border: none; } 
	.list_ul li { border: 1px solid #00000026; margin-bottom: 0px; padding: 5px; }
	.list_ul { list-style-type:none; }
	.service_amount { float:right; }
	
	.bottom-pricetag { background-color: #a3cdda82;  padding: 10px; }
	.preview_button_div {  background-color: #f18628b0; padding: 20px 7px 20px 17px; text-align:right;}
</style>