<?php   

	$invoiceId = $_POST['invoice_id'];
	$invoicePaymentId = $_POST['invoice_payment_id'];
	$param = array('tableName'=>TBL_INVOICE,'fields'=>array('*'),'condition'=>array('id'=>$invoiceId.'-INT'));
	$rsInvoice = Table::getData($param); 	 
	foreach($rsInvoice as $K=>$V)  $$K=$V; 
	
	
	$param = array('tableName'=>TBL_CLIENTS,'fields'=>array('*'),'condition'=>array('id'=>$client_id.'-INT'));
	$rsClient = Table::getData($param);
	
					 
	$qry = "SELECT sum(amount_paid) as total_paid from `".TBL_INVOICE_PAYMENT."` where  invoice_id=".$id; 
	$rsInvIns =  dB::sExecuteSql($qry);  
	
	$serviceObj = new Invoice();
	$serviceObj->invoice_id = $id;
	$servicesOrdered = $serviceObj->getServicesByInvoiceId();
	
				
	?>
	   <div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			 
			<div class="modal-body" style="padding:0px;">
			<div class="body-div" style="padding:15px;">
			
		 <div class="card">	 
		  <label class="card-header bg-primary text-white">Payment Details for BPE -  <?php echo $id; ?></label>
			 <div class="card-body">
			 <div class="row">
			 <div class="col-md-6"> <strong><?php echo $rsClient->client_fname.' '.$rsClient->client_lname.'<br/>'.$rsClient->client_phone.'<br/>'.$rsClient->client_email; ?></strong></div>
			 <div class="col-md-6">
			 
			  
				 		 <div class="row" style="font-size:16px;">  
						 <div class='col-md-12'><ul class="invoice_services_list">
						 <?php
				  foreach($servicesOrdered as $K1=>$V1) { 					 
					  if(is_array($V1)) {  
						if($K1==0) ?>
						<li><?php echo $V1['item_name']; ?> </li>
						 <?php  } }  ?>  </ul>
						 </div> 
						 </div>  				 
					
			 
			 </div>
			 <div class="col-md-12"><hr/></div>
			</div>
			
				 <div class="row" style="margin-bottom: 10px;line-height: 25px;">
				  <div class="col-md-6"><strong> Total Amount : <?php echo   money($final_amount,'$');?> <br/>
				  <?php if(trim($balance_amount)!='') { ?> Balance Amount : <?php echo money($balance_amount,'$'); }?> </strong></div>
				  <div class="col-md-6"> <strong>
				  Total Paid : <?php echo money($rsInvIns->total_paid,'$'); ?> </strong>
				  </div>
				 </div>
				  
			    <div class="row">				
				  <div class="col-md-12">				 
				  <div class="paid_payment_details">
				   <p style="margin-top:10px;margin-bottom:10px" class="text-primary">Paid Details</p>
				    <table class="table table-bordered">
					 <thead>					  
					  <th>Date</th>
					  <th>Txn Id</th>					  
					  <th>Amount</th>
					  <!--<th>Action</th>-->
					 </thead>
					 <tbody>
				<?php 
				 $param = array('tableName'=>TBL_INVOICE_PAYMENT,'fields'=>array('*'),'orderby'=>'added_date','sortby'=>'asc','condition'=>array('id'=>$invoicePaymentId.'-INT'));
				$rsInvoicePayment[0] = Table::getData($param);
				if(count($rsInvoicePayment)>0) {
                    foreach($rsInvoicePayment as $key=>$val) { ?>
					  <tr>					 			 
					  <td><?php echo date('M d, Y',strtotime($val->added_date)); ?></td>
					   <td><?php echo $val->txn_id; ?></td>
					  <td><?php echo money($val->amount_paid,'$'); ?></td>
					 <!-- <td>
					   <a href="javascript:void(0)"><i class="fa fa-envelope" aria-hidden="true"></i></a>
					   <a href="javascript:void(0)"> <i class="fas fa-file-pdf"></i></a></td>-->
					  </tr>
				<?php } } else {  echo '<tr><td colspan="5" class="text-center">No results</td></tr>'; }    ?>
					 </tbody>
					</table>				  
				  </div>
				  </div>
            
			  <div class="col-md-12"> 
			  <button class="btn btn-primary btn-sm email_show_btn" type="button" onclick="showEmailForm()">Send Email</button>
			  <div class="email_form_div" style="margin-top:20px;display:none">
			     <textarea id="client_email_id" style="margin: 0px; height: 114px; width: 446px;"><?php echo $rsClient->client_email;?></textarea><br/>
				 <small>Add Multiple email by comma separated</small> <br/><br/>
				 <button class="btn btn-primary btn-sm" onclick="sendEmailPaymentDetails(<?php echo $invoiceId.','.$invoicePaymentId;?>);">Submit</button>
				 <button class="btn btn-warning btn-sm" type="button" onclick="showEmailForm()">Close</button>
			  </div>
			    <div class="email_response"></div>
			  
			  </div>
				  
				 </div>	 
				  		 
			    </div>					 
		    </div>
				 </div>
			</div>
			<div class="modal-footer">
				<button type="button"  class="btn btn-primary waves-effect" data-dismiss="modal">Close</button>
				 
			</div>
		</div>
	</div>
	</div><!-- /.modal -->
<style>   
.invoice_services_list { list-style: none; }
.invoice_services_list li:before { content: '✓'; color: #039cfd;font-weight: bold; padding-right: 10px; }
</style>
	<script>
	function showEmailForm() {
		$('.email_form_div').toggle();
		$('.email_show_btn').toggle(); 		
	}
	
 function sendEmailPaymentDetails(invoice_id,invoice_payment_id) {
  err=0;	 
 if($('#client_email_id').val()=='' ){ err=1; $('#client_email_id').css("border","1px solid #F58634"); } else{  $('#client_email_id').css("border","");}
 var client_email_id = $('#client_email_id').val();
 if(err==0) {
	paramData = {'act':'send_payment_details_email','invoice_payment_id':invoice_payment_id,'email_address':client_email_id,'invoice_id':invoice_id};
	ajax({ 
		a:'process',
		b:$.param(paramData),
		c:function(){},
		d:function(data){    $('.email_show_btn').show(); $('.email_form_div').hide();
		   		  $('.email_response').html('<br/><h5>Email Send Successfully</h5>');
		}});	
 } }
	
	</script>
	
	 