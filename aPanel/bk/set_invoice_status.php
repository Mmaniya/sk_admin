<?php
 $invoiceId = $_POST['id']; 
$param = array('tableName'=>TBL_INVOICE_LINE_ITEM,'fields'=>array('*'),'condition'=>array('id'=>$invoiceId.'-INT'));
$rsInvoice = Table::getData($param);
foreach($rsInvoice as $K=>$V)  $$K=$V;
 
  
 $invStatus = trim($line_item_status);
$statusOption='';
if($invStatus =='QS') { $statusOption = '<option value="IP">InProgress </option><option value="SP">Submitted for Process</option>'; } 
if($invStatus =='IP') { $statusOption = '<option value="SP">Submitted for Process</option><option value="AWC">Awaiting Customer Reply</option><option value="D">Done</option>'; } 
if($invStatus =='AWC') { $statusOption = '<option value="R">Replied</option><option value="IP">InProgress </option>'; } 
if($invStatus =='R') { $statusOption = '<option value="IP">InProgress </option><option value="SP">Submitted for Process</option><option value="AWC">Awaiting Customer Reply</option>'; } 
if($invStatus =='SP') { $statusOption = '<option value="D">Done</option><option value="AWC">Awaiting Customer Reply</option>'; } 
if($invStatus =='FQ') { $statusOption = '<option value="IP">InProgress </option><option value="SP">Submitted for Process</option><option value="AWC">Awaiting Customer Reply</option>'; } 
 
?>
  
<div class="row">
  <div class="col-md-12">
    <div class="card">
       <div class="card-header bg-primary text-white"> 
	   <span class="text-secondary"><a href="javascript:void(0)" class="text-white">BPE-<?php echo $invoice_id;?></a></span> 
	    
	   </div>
        <div class="card-body">
		<p style="margin:0px;"><strong>Previous Status : <?php echo $GLOBALS['LINEITEMSTATUS'][$line_item_status];?></strong></p>
		<?php if($invStatus=='AWC') { echo '<p><strong> Comments : '.$status_reason.'</strong></p>'; }
	 
		 if($invStatus=='QS' || $invStatus=='IP' || $invStatus=='AWC' || $invStatus=='R' || $invStatus=='SP' || $invStatus=='FQ') {  ?> <form name="update_status_form">
		 <div class="row" style="margin-top:20px;">
           <div class="col-md-12">		   
					<div class="form-group row">
						<label class="col-md-4 col-form-label">Set status to  : </label>
						<div class="col-md-8">
							<select class="form-control" id="invoice_process_status" onchange="checkOption(this.value)">
							<option value=''>Select</option>
							<?php echo $statusOption; ?>
							</select>
						</div>
					</div>
							 
	        </div>
	        </div>
        <div class="row">
		  <div class="col-md-12">
				<div class="form-group row"  id="comments_option" style="display:none">
					<label class="col-md-4 col-form-label">Comments : </label>
					<div class="col-md-8">
						<textarea class="form-control" name="comments" id="comments" placeholder="Comments"></textarea>
					</div>
				</div> 									<hr/>
		 <input type="hidden" id="line_item_id"  value="<?php echo $id; ?>">
		  <button class="btn btn-primary btn-sm" id="submit_status_button" type="button" onclick="updateStatus()">Update</button>
		  <button class="btn btn-danger btn-sm float-right" type="button" onclick="closeForm()">Close</button>
		  
		  </div>		  
	      </div>
		</form> <?php }  ?>     
	   </div>     
   </div>   
   </div>
</div>

<script>
 

function updateStatus() {
	err=0;
 if($('#invoice_process_status').val()=='' ){ err=1; $('#invoice_process_status').css("border","1px solid #ff0000 "); } else{  $('#invoice_process_status').css("border",""); }
 
 var status =   $('#invoice_process_status').val();
  
 if(err==0) {
	 
	var comments =   $('#comments').val();
	var line_item_id =   $('#line_item_id').val();
	 $("#submit_status_button").attr("disabled", true);

	 paramData = {'act':'update_line_item_status','line_item_status':status,'line_item_id':line_item_id,'comments':comments}
	ajax({ 
		a:'invoices',
		b:$.param(paramData),
		c:function(){},
		d:function(data){  
		
			$("#submit_status_button").attr("disabled", false);
			//alert(res[1]);	
			$('.right_bar_div').html(''); 
			$('#status_'+line_item_id).html(data);
			if(status=='D')
			{
				$('#invoiceLineItem_'+line_item_id).hide();
				$('#invoiceLineItem2_'+line_item_id).hide();
			}
//			show_invoices_list();
		}});	
  }
 }
	

function checkOption(option) {  
	$('#comments_option').hide();
	if(option=='AWC') {  $('#comments_option').show(); } 	
}

function closeForm() {
	$('.right_bar_div').html('');
	
}

</script>