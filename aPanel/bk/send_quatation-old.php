 <?php
 $leadId = $_POST['id'];
 $categoryObj = new ServiceCategory(); 
 
if($leadId>0) { 
	$param = array('tableName'=>TBL_LEADS,'fields'=>array('*'),'condition'=>array('id'=>$leadId.'-INT'));
	$rsLead = Table::getData($param);
	foreach($rsLead as $K=>$V)  $$K=$V;
	$btnName = $title = 'Edit ';  	
}  	

$leadsObj = new Leads; 

$categoryObj = new ServiceCategory(); 

?>   
		<script>
 function toggle(id) {  $('.lead_service_type_'+id).toggle();  }
 </script>	<div class="card-box"> 
			<form class="form-horizontal" role="form" id="service_category_form" enctype="multipart/form-data">
					<div class="form-group row">
					   <label class="col-md-12 col-form-label">Subject: </label>
						<div class="col-md-7">
							<input type="text" class="form-control" name="subject" id="subject" value="<?php echo $subject; ?>">
						</div>
					</div>
					
					
					<div class="form-group row">
					   <label class="col-md-6 col-form-label">Introduction Notes: </label>
					   <label class="col-md-6 col-form-label text-right"><a href="javascript:void(0)">[load it from library]</a></label>
						<div class="col-md-12">
						<textarea name="Introduction" id="Introduction" class="form-control" style="margin-top: 0px; margin-bottom: 0px; height: 212px;"><?php echo $Introduction; ?></textarea></div>
					</div>
					
					 
					
					 <div class="form-group row">
						<label class="col-md-7 col-form-label">Service Requested : </label>  
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
			<label class="col-md-9 col-form-label"><input type="checkbox" class="check_category" name="lead_enquiry_for[]"  onclick="toggle(<?php echo $val->id;?>)"  value="<?php echo $val->id;?>" <?php   echo $checked;  ?>> <?php echo $val->category_name;?>  	</label>	
			<label class="col-md-3 col-form-label"><a href="javascript:void(0)" onclick="showAppendItem1(<?php echo $val->id;?>)">[add a new subline Item]</a></label>	
                </div>
			 
			<ul class="list_ul lead_service_type_<?php echo $val->id; ?>" style="display:none"> 
			<?php $param = array('tableName'=>TBL_SERVICES,'fields'=>array('*'),'condition'=>array('service_type'=>$val->id.'-INT'));
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
			<li><input type="checkbox" class="services_list_checkbox_<?php echo $val->id;?>" name="service_type_list[][<?php echo $val->id;?>]" value="<?php echo $V->id;?>" <?php echo $checked; ?>>&nbsp;<?php echo $V->service_name?> 
			<input type="hidden" name="service_amount_<?php echo $V->id;?>" value="<?php echo $V->service_price; ?>">
			<span class="service_amount"><?php echo money($V->service_price,'$');?></span>
			</li>

			<?php } } else { echo '<li>No services found</li>'; } ?></ul>	
			<div class="col-md-12"> <div class="appendNewLine_item_<?php echo $val->id;?>"></div>  </div>
				
					 <?php }} ?> 
                    <p class="error_msg_checkbox" style="color:#ff0000"></p>
                    <span style="clear:both"></span>
						 </div>		
 			 
					</div>
					
					
    <div class="form-group row" style="background-color: #80808047;padding: 15px; margin-bottom: 0px;">
	  <div class="col-md-12"><strong> Add new line item </strong> </div>
	  <div class="col-md-6"><input type="text" class="form-control" name=""/>  </div>
	  <div class="col-md-3"></div>
	  <div class="col-md-3"> 
	  <div style="float: right; display: inline-flex;"> 
	         <span style="font-size:24px;">$</span> <input type="text" class="form-control" name="price"  style="text-align:right;width:100px;"/>&nbsp;&nbsp;&nbsp;&nbsp; </div> </div> 
	  
	   <div class="col-md-12"> <div class="appendNewLineItem"></div>  </div>
	   
	  <div class="col-md-12">   
	    <div class="add_more_div"> <a href="javascript:void(0)" onclick="AddMoreLineItem()"><strong>[+]</strong></a> <a href="javascript:void(0)"><strong>[-]</strong></a>  </div>
	 </div>
	</div>
	
	  <div class="form-group row" style="background-color:#ffffff;padding: 15px; margin-bottom: 0px;">
	    <div class="col-md-12">
     <div class="bottom-pricetag"> <span>TOTAL</span>
      <span class="float-right">$4500</span> </div>
		</div>
		
		<div class="col-md-12">
     <div style="padding: 10px;"> <input type="checkbox" name="is_discount" class="is_discount"> 
	   DISCOUNT &nbsp;&nbsp;&nbsp;  <span style="display:none" id="discountDiv"> 
		<input type="radio" name="discount_type" id="discount_type_percentage" value="percentage" onclick="showDiscountTextBox('percentage')"> PERCENTAGE   
		<input type="text" style="width:100px;text-align:center;display:none;" id="percentageBox">%
		<input type="radio" name="discount_type"  id="discount_type_amount"  value="amount"  onclick="showDiscountTextBox('amount')"> AMOUNT  
		<input type="text" style="width:100px;text-align:center;display:none;"  id="amountBox">
		</span>
		
      <span class="float-right"><span style="font-size:24px;">$</span> <input type="text" style="text-align:right;width:100px;" value="4500"/></span> </div>
		</div>
		
		<div class="col-md-12">
     <div class="bottom-pricetag"> <span>TOTAL</span>
      <span class="float-right">$4500</span> </div>
		</div> 		  
	  </div>
	  
	  <div class="form-group row" style="margin-bottom: 0px;">
	   <div class="col-md-12"> 
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
		  </select> <?php } ?>
		 
		
		
		</div>
		</div>
	  </div>
	  
	   <div class="form-group row" style="margin-bottom: 0px;">
	    <div class="col-md-12"> 
			  <div class="preview_button_div">
					<button class="btn btn-primary" style="padding: 10px;font-weight: 600;">PREVIEW QUOTATION</button>
			  </div>
	    </div>
	   </div>
					
					</form>
						

<script>
$('.page-title').html(' Quotation for <?php echo $lead_fname.' '.$lead_lname;?>');
$('.page_head_title').html('');
$('.activeBread').html('Quotation');

//alert(500-10);

	var x1 = 0; 
var max_fields_1 = 100; 
  function showAppendItem1(category_id) { 		
		if(x1 < max_fields_1){
    x1++;  
		var html=''
			html+='<div class="newLineItem_'+category_id+'_'+x1+'" style="margin-bottom:10px;">  <div class="row">'; 				  
      html+='<div class="col-md-6"><input type="text" class="form-control" name=""/>  </div>';
	  html+='<div class="col-md-3"></div>';
	  html+='<div class="col-md-3"><div style="float: right; display: inline-flex;"><span style="font-size:24px;">$</span> <input type="text" class="form-control" name="price"  style="text-align:right;width:100px;"/><a href="javascript:void(0)" onclick="removeNewLineItem('+x1+','+category_id+')">[x]</a></div></div>'; 				 
      html+='</div></div>'; 		 
      $('.appendNewLine_item_'+category_id).append(html);  	
		}
  } 		

  function removeNewLineItem(id,category_id){   $('.newLineItem_'+category_id+'_'+id).remove();   x1--; }		
		
		
		
  function showDiscountTextBox(type) {
	  $('#amountBox').hide(); $('#percentageBox').hide();
	  
	  if(type=='amount') {  $('#amountBox').show() }
	  if(type=='percentage') {  $('#percentageBox').show() }
	  
  }

  
  $(document).ready(function(){
    $(".check_category").click(function(){ var category_id = $( this ).val();
        if ($(this).is(':checked')) { 
			 $(".services_list_checkbox_"+category_id+"").prop("checked", true);
		} else { $(".services_list_checkbox_"+category_id+"").prop("checked", false);
              

		}        
    }); 
	
	
	 $(".is_discount").click(function(){  
	 $("#discount_type_percentage").prop("checked", false);  
			   $("#discount_type_amount").prop("checked", false); 
        if ($(this).is(':checked')) { 
			 $('#discountDiv').show();
			 
		} else {  $('#discountDiv').hide(); }        
    }); 
	
	
});

				 					
var x = 0; 
var max_fields = 100; 
  function AddMoreLineItem() { 		
		if(x < max_fields){
    x++; 
		var html=''
			html+='<div class="innerCategory_'+x+'">  <div class="row">'; 				  
      html+='<div class="col-md-6"><input type="text" class="form-control" name=""/>  </div>';
	  html+='<div class="col-md-3"></div>';
	  html+='<div class="col-md-3"><div style="float: right; display: inline-flex;"><span style="font-size:24px;">$</span> <input type="text" class="form-control" name="price" style="text-align:right;width:100px;"/><a href="javascript:void(0)" onclick="removeNewLineRow('+x+')">[x]</a></div></div>'; 				 
      html+='</div></div>'; 		 
      $('.appendNewLineItem').append(html);
		}
  } 		

  function removeNewLineRow(id){   $('.innerCategory_'+id).remove();   x--; }	
 
  		

		
		

</script>						
<style> .add_more_div { text-align:right; }
.card-box { border:0px; background-color: #f5f5f5; }
	.list_ul li { border: 1px solid #00000026; margin-bottom: 0px; padding: 5px; }
	.list_ul { list-style-type:none; }
	.service_amount { float:right; }
	
	.bottom-pricetag { background-color: #a3cdda82;  padding: 10px; }
	.preview_button_div {  background-color: #f18628b0; padding: 20px 7px 20px 17px; text-align:right;}
</style>