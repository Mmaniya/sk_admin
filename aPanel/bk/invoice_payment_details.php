<?php   

	$InvoiceId = $_POST['invoice_id'];
	$param = array('tableName'=>TBL_INVOICE,'fields'=>array('*'),'condition'=>array('id'=>$InvoiceId.'-INT'));
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
				 <?php if($rsInvoice->internal_comments!='') { ?>
				 <div class="row">
				   <div class="col-md-12">
					<div class="card">	 					  
					  <label class="card-header bg-primary text-white">Internal Comments</label>
					   <div class="card-body" style="background-color:#ffffb5;padding: 7px;">
					     <?php echo $rsInvoice->internal_comments;?>
					   </div>
					 </div>  
					</div> 
				 </div>
				 <?php } ?>
				 <div class="row">
				 <?php
				   $param = array('tableName'=>TBL_INVOICE_LINE_ITEM,'fields'=>array('*'),'condition'=>array('invoice_id'=>$id.'-INT'));
				   $rsInvoiceLineItem = Table::getData($param); 
				   if(count($rsInvoiceLineItem) > 0)
				   {	
				?>
				<style>
				  .line_item_details th{
					background-color:#039cfdc2;
					color:#fff;
				  }
				</style>
				<div class="col-md-12">				 
				  <div class="line_item_details">
				   <p style="margin-top:10px;margin-bottom:10px" class="text-primary">Services</p>
				    <table class="table table-bordered">
					 <thead>
					  <th>#</th>
					  <th>Service</th>					  				  
					  <th>Amount</th>					  
					 </thead>
					 <tbody>
					 <?php foreach($rsInvoiceLineItem as $LK => $LV)
					 {?>
					 <tr>
					  <td><?php echo $LK+1;?></td>
					  <td><strong><?php echo $LV->line_item;?></strong><br><small>Description: <?php echo $LV->line_desc;?></small>
					  <?php
					    $serviceObj->invoice_line_item_id=$LV->id;
						$is_questionnaire=$serviceObj->isQuestionnaire();
						if($is_questionnaire) { 
							$param = array('tableName'=>TBL_SERVICES,'fields'=>array('document_id'),'condition'=>array('id'=>$LV->service_id.'-INT'));
							$rsService = Table::getData($param); 				   							
							$docIds=$rsService->document_id;
							$docIdsArr=explode(",",$docIds);
							$docIdsArr=array_unique($docIdsArr);
							
							$serviceObj->docIds=$docIds;										
							$quesCnt=$serviceObj->getQuestionnaireDetailsByDoc();
             
							$quesPercentage=($quesCnt/count($docIdsArr))*100;
					
						?>
						<div style="margin-top:10px">			
						<div style="font-size:12px"><?php echo $quesCnt>0?$quesCnt:"0";?>/<?php echo count($docIdsArr);?></div>
				<div class="progress"  style="background-color:#e9ecef; height:2rem;margin-bottom:0px; cursor:pointer">
			<div class="progress-bar" role="progressbar" aria-valuenow="<?php echo round($quesPercentage);?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo round($quesPercentage);?>%">
			<span class="sr-only"><?php echo round($quesPercentage);?>% Complete</span>
			</div>
			</div>
			<div style="margin-top:10px">
			<a class="btn btn-sm btn-primary" href="invoices.php?invId=<?php echo $id;?>&item_id=<?php echo $LV->id;?>" target="_blank" title="Show Questionnaire">questionnaire</i></a>
						</div>	
						</div>
						<?php } ?>
					  </td>
					  <td><strong><?php echo money($LV->line_amount,'$');?></strong></td>
					  </tr>
					 <?php } ?>
					 </tbody>
					</table>
				   </div>
				  </div> 	 
				   <?php } ?>	
				 </div>
				 <div class="row" style="background-color:#039cfdc2;color:#fff;">
				 <div class="col-md-4 row-border" onclick="showPaymentType('P')" style="padding:8px;cursor:pointer;">Paid Details</div>
				 <div class="col-md-4" onclick="showPaymentType('D')" style="padding:8px;cursor:pointer;">Due Details</div>				 
				 </div>
				 
			    <div class="row">								
				  <div class="col-md-12">				 
				  <div class="paid_payment_details">
				   <p style="margin-top:10px;margin-bottom:10px" class="text-primary">Paid Details</p>
				    <table class="table table-bordered">
					 <thead>
					  <th>#</th>
					  <th>Date</th>
					  <th>Txn Id</th>					  
					  <th>Amount</th>
					  <!--<th>Action</th>-->
					 </thead>
					 <tbody>
				<?php 
				 $param = array('tableName'=>TBL_INVOICE_PAYMENT,'fields'=>array('*'),'orderby'=>'added_date','sortby'=>'asc','condition'=>array('invoice_id'=>$id.'-INT'));
				$rsInvoicePayment = Table::getData($param);
				if(count($rsInvoicePayment)>0) {
                    foreach($rsInvoicePayment as $key=>$val) { ?>
					  <tr>
					  <td><?php echo $key+1; ?></td>					 
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
				 </div>	 
				 
				 
				  <div class="col-md-12">
				  <div class="due_payment_details" style="display:none;">
				  <p style="margin-top:10px;margin-bottom:10px" class="text-primary">Due Details</p>
				      <table class="table table-bordered">
					 <thead>
					  <th>#</th>
					  <th>Installment Date</th>
					  <th>Amount</th>
					  <th>Action</th>
					 </thead>
					 <tbody>
				<?php 
				 $param = array('tableName'=>TBL_INVOICE_INSTALLMENT,'fields'=>array('*'),'orderby'=>'installment_date','sortby'=>'asc','condition'=>array('invoice_id'=>$id.'-INT','is_paid'=>'N-CHAR'));
				$rsInvoicePayment = Table::getData($param);
				if(count($rsInvoicePayment)>0) {
                    foreach($rsInvoicePayment as $key=>$val) { ?>
					  <tr>
					  <td><?php echo $key+1; ?></td>
					  <td><?php echo date('M d, Y',strtotime($val->installment_date));?></td>
					  <td><?php echo money($val->amount,'$'); ?></td>
					  <td >
<a href="../accounts/installment_payment.php?id=<?php echo $val->id; ?>"  target="_blank" ><i class="fas fa-comment-dollar text-success" style="font-size:20px;"></i></a>&nbsp;<a href="javascript:void(0)" onclick="showPopSendEmail(<?php echo $rsInvoice->client_id;?>,'all','C','<?php echo $InvoiceId; ?>','<?php echo $val->id; ?>')" title="Send Email"><i class="fa fa-envelope" style="font-size:21px;" aria-hidden="true"></i></a>&nbsp;<a href="javascript:showManualPayment('<?php echo $InvoiceId; ?>','<?php echo $val->id; ?>')">[Manual Pay]</a>
</td>
					  </tr>
				<?php } } else {  echo '<tr><td colspan="5" class="text-center">No results</td></tr>'; }  ?>
					 </tbody>
					</table>				  
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
    function showManualPayment(invId,insId) {
        paramData = {'act':'show_manual_payment_modal','invoice_id':invId,'installment_id':insId};
        ajax({
            a:'process',
            b:$.param(paramData),
            c:function(){},
            d:function(data){
                $('.modal-backdrop').remove();
                $('.right_bar_div').html(data);
                $('#manual_payment_modal').modal('show');
            }});
    }

	function showPaymentType(type) {
		$('.paid_payment_details').hide(); $('.due_payment_details').hide();
		
             if(type=='P') { $('.paid_payment_details').show(); }		
             if(type=='D') { $('.due_payment_details').show();  }		
		
	}
	function showPopSendEmail(id,email_type,param_type,invId,installment_id) {

		if(param_type=='C') paramData = {'act':'showClientEmail','client_id':id,'param_type':param_type,'email_type':email_type,'templateId':'5','invoice_id':invId,'installment_id':installment_id};

		ajax({ 
			a:'process',
			b:$.param(paramData), 
			c:function(){},
			d:function(data){ 					
			$('.modal-backdrop').remove();
			$('.right_bar_div').html(data);	
			$('#con-close-modal').modal('show');		  
			}});	
    }
	</script>
	