<?php
 $invoiceId = $_POST['id'];
   $line_item_id = $_POST['line_item_id'];
$btnName = $title = 'Add New';
$joined_date ='';
 if($invoiceId>0) { 
	$param = array('tableName'=>TBL_INVOICE,'fields'=>array('*'),'condition'=>array('id'=>$invoiceId.'-INT'));
	$rsUsers = Table::getData($param);
	foreach($rsUsers as $K=>$V)  $$K=$V;
	$btnName = $title = 'Edit ';
  	
	/*$param = array('tableName'=>TBL_LEAD_SPECIALIST,'fields'=>array('*'),'condition'=>array('lead_id'=>$leadId.'-INT','service_category_id'=>$leadId.'-INT','user_id'=>$leadId.'-INT'));
	$rsLeadSpec = Table::getData($param); */
 }
 
$param = array('tableName'=>TBL_INVOICE_LINE_ITEM,'fields'=>array('*'),'condition'=>array('invoice_id'=>$invoiceId.'-INT'));
 $rsInvoiceLineItem = Table::getData($param);
 if(count($rsInvoiceLineItem)>0) { 
   foreach($rsInvoiceLineItem as $key=>$val) {
	   $categoryId[] =  $val->category_id;
   }
 }
	$categoryObj = new ServiceCategory(); 

	$categoryObj->category_id= implode(',',$categoryId);
	
	$enquiryFor = $categoryObj->getCategoryByIds();

	$leadsObj = new Leads; 
 
?>

	<div id="con-close-modal-1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content"> 			 
			<div class="modal-body">
				<div class="row">
					<div class="col-md-6">
						Assign Specialist BPE - <?php echo $id;  ?> 
					</div> 		
<div class="col-md-12"><hr/></div>					
				</div>  
				<div class="row">
         <?php    
		 $param = array('tableName'=>TBL_INVOICE_LINE_ITEM,'fields'=>array('*'),'showSql'=>'N','condition'=>array('invoice_id'=>$invoiceId.'-INT'));
         $rsInvoiceLineItem = Table::getData($param);
		 if(count($rsInvoiceLineItem)>0) {
		   foreach($rsInvoiceLineItem as $key=>$val) { 
		   $categoryObj->category_id= $val->category_id; 	
	       $categoryDtls = $categoryObj->getCategoryByIds();
			   ?>		  
				<div class="col-md-4">
				<?php  echo '&nbsp;'.$categoryDtls[0]->category_name; echo '<br/><small>'.$val->line_item.'</small>';  ?>
				</div>
				<div class="col-md-4">
				 
		  <select name="user_id" id="user_id_<?php echo $val->id; ?>" class="form-control">
				<option value="">select</option>
			<?php 	$param = array('tableName'=>TBL_USERS,'fields'=>array('*'),'showSql'=>'N','condition'=>array('status'=>'A-CHAR'));
			  $rsUsers = Table::getData($param);
			if(count($rsUsers)>0) {
               foreach($rsUsers as $K3=>$V3) {  $selected=''; if($val->specialist_id==$V3->id) {  $selected = 'selected'; }
                       echo '<option value="'.$V3->id.'" '.$selected.'>'.$V3->contact_fname.' '.$V3->contact_lname.' ('.$V3->user_type.')</option>';
			}}
			   ?>
				</select>
		       		
				</div>
				 
				<div class="col-md-4">             
  				<button class="btn btn-primary btn-sm" onclick="setAssignSpecialist(<?php echo $val->id; ?>,'already')">assign</button>  	 		 
				</div>
				
				<div class="col-md-12"><hr/></div>
			 <?php } }  ?>
			 
			 
				 </div>	   
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary waves-effect" data-dismiss="modal">Close</button>				 
			</div>
		</div>
	</div>
	</div><!-- /.modal -->
<script>

  function showSpecialistUser(id)  {
	 var user_id =  $('#user_id_'+id).show();
	 var assign_button_ =  $('#assign_button_'+id).show();
	  $('#error_text_'+id).html('');
	  
  }


	 function setAssignSpecialist(invoice_line_item_id) {   
		var specialistId = $('#user_id_'+invoice_line_item_id).val(); 		 
		  
		 var specialistName = $("#user_id_"+invoice_line_item_id+" option:selected").html();
		 
	paramData = {'act':'assign_invoice_specialist','invoice_line_item_id':invoice_line_item_id,'specialist_id':specialistId};
	ajax({ 
		a:'invoices',
		b:$.param(paramData),
		c:function(){},
		d:function(data){   
			var res = data.split("::"); 
			alert(res[1]);  
			$('.assignresponse_change_'+invoice_line_item_id).hide();
			$('.assignresponse_show_'+invoice_line_item_id).show();
			$('.assignresponse_'+invoice_line_item_id).html(specialistName);  
		}});	
}  




</script>
	 