<?php
    $line_item_id = $_POST['line_item_id'];
    $id=$_POST['id'];
    $btnName = $title = 'Add New';
    $joined_date ='';
   
 
$param = array('tableName'=>TBL_INVOICE_LINE_ITEM,'fields'=>array('*'),'condition'=>array('id'=>$line_item_id.'-INT'));
 $rsInvoiceLineItem = Table::getData($param);
 
	$categoryObj = new ServiceCategory(); 

	$categoryObj->category_id= $rsInvoiceLineItem->category_id;
	
	$enquiryFor = $categoryObj->getCategoryByIds();

	$leadsObj = new Leads; 
 
?>

	<div id="con-close-modal-1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content"> 			 
			<div class="modal-body" style="padding: 9px; padding-top:0px">
				<div class="row">
                <div class="col-md-12 card-header bg-primary text-white"> 
                  <span class="text-secondary"><a class="text-white">Assign Specialist BPE - <?php echo $id;  ?> - <?php echo $rsInvoiceLineItem->line_item;?> </a></span> 
                </div>					
<div class="col-md-12"><hr/></div>					
				</div>  
				<div class="row">
         <?php    
		  
		   $categoryObj->category_id= $rsInvoiceLineItem->category_id; 	
	       $categoryDtls = $categoryObj->getCategoryByIds();
			   ?>		  
				
				<div class="col-md-4">
				 
		  <select name="user_id" id="user_id_<?php echo $rsInvoiceLineItem->id; ?>" class="form-control">
				<option value="">select</option>
			<?php 	$param = array('tableName'=>TBL_USERS,'fields'=>array('*'),'showSql'=>'N','condition'=>array('status'=>'A-CHAR'));
			  $rsUsers = Table::getData($param);
			if(count($rsUsers)>0) {
               foreach($rsUsers as $K3=>$V3) {  $selected=''; if($rsInvoiceLineItem->specialist_id==$V3->id) {  $selected = 'selected'; }
                       echo '<option value="'.$V3->id.'" '.$selected.'>'.$V3->contact_fname.' '.$V3->contact_lname.'</option>';
			}}
			   ?>
				</select>
		       		
				</div>
				 
				<div class="col-md-4">             
  				<button class="btn btn-primary btn-sm" onclick="setAssignSpecialist(<?php echo $rsInvoiceLineItem->id; ?>,'already')">Assign</button>  	 		 
				</div>
				
				<div class="col-md-12"><hr/></div>			 			 
			 
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
	 