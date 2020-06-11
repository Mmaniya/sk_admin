
<?php  
$invoiceId = $_POST['invoice_id'];
$param = array('tableName'=>TBL_INVOICE,'fields'=>array('*'),'showSql'=>'N','condition'=>array('id'=>$invoiceId.'-INT'));     
$rsInvoice[0] = Table::getData($param);	 	
    
  	  if(count($rsInvoice)>0) {
			foreach($rsInvoice as $K=>$V) {
			 
				$serviceObj = new Invoice();
				$serviceObj->invoice_id = $V->id;
				$servicesOrdered = $serviceObj->getServicesByInvoiceId();
				$invoiceDtls = $serviceObj->getInvoiceDetails();
			 
		
				?>
		<div class="row page_head_title">
		  <div class="col-lg-12 row-border" style="padding:0px;">
		  <div class="card">
		     <div class="card-header bg-primary text-white">
 <span class="text-secondary"><a href="javascript:void(0)" class="text-white"><strong>BPE-<?php echo $V->id;?></strong></a></span>
			 <strong><a href="javascript:void(0)" class="float-right text-white" onclick="<?php if($_SESSION['user_type']!='E' && $_SESSION['user_type']!='FL') { ?>backInvoicesList()<?php } else {?>window.location='invoiceStatus.php'; <?php } ?>">Invoice List</a></strong>
			 </div>			 
		    </div>
		  </div>  		   
		</div>
		<?php
		$clientCompany='';
			if($invoiceDtls['client']['company']!='') { $clientCompany='<strong>'.$invoiceDtls['client']['company'].'</strong><br/>';  }
		?>
		
		<div class="row">
		<div class="col-md-4 p-2 row-border" style="overflow: auto;"> 				   
	   <?php echo $clientCompany.$invoiceDtls['client']['name'].' &nbsp;<a style="color:#f76397" href="'.SHAREPOINT_LINK.$invoiceDtls['client_id'].	'" target="_blank"><i class="fa fa-folder" aria-hidden="true"></i></a><br/>'.$invoiceDtls['client']['phone'].'<br/>'.$invoiceDtls['client']['email']; ?>
	   <a  href="<?php echo BASE_URL;?>accounts?clid=<?php echo $invoiceDtls['client_id'];?>&ap=1" target="_blank" style="margin:5px;"><i class="fas fa-external-link-alt"></i></a>
		 <a href="javascript:void(0)" title="send SMS" onclick="send_sms('<?php echo $invoiceDtls['client_id'];?>')"> <i class="fas fa-sms text-success" style="font-size:24px;"></i></a>	
</div>
<div class="col-md-8 p-2  row-border">
<?php if($_SESSION['user_type']!='FL') { ?>		 
   <strong>Amount : <?php echo $invoiceDtls['amount_details']['final_amount']; ?> </strong><br/>
<?php } ?>
   <strong>Order Date : <?php echo date('M d, Y',strtotime($V->added_date));   ?> </strong><br/>					   
</div> 
 
		</div>
		 <div class="row row-striped mt-2"> 
		 <div class="col-lg-12 row-border" style="padding:0px;">
		  <div class="card">
		     <div class="card-header bg-primary text-white"><span class="text-secondary"><a href="javascript:void(0)" class="text-white"><strong>Services</a></span>			 
			 </div>			 
		    </div>
		  </div>  
		  </div>  
				
            <div class="row row-striped mt-2">                           
                 <!-- <div class="col-md-6 pb-2  row-border">
                      <span class="text-secondary"><a href="javascript:void(0)" class="text-primary"><strong>BPE-<?php echo $V->id;?></strong></a></span>           
					   <strong> &nbsp;&nbsp;&nbsp;Amount : <?php echo $invoiceDtls['amount_details']['final_amount']; ?> </strong><br/>
					   <?php echo date('M d, Y',strtotime($V->added_date));   ?> <br/>					   
				  </div>
					  
					 
                   <div class="col-md-3 p-2 row-border" style="overflow: auto;"> 				   
				   <?php echo $invoiceDtls['client']['name'].'<br/>'.$invoiceDtls['client']['phone'].'<br/>'.$invoiceDtls['client']['email']; ?>
				   <a  href="<?php echo BASE_URL;?>accounts?clid=<?php echo $invoiceDtls['client_id'];?>&ap=1" target="_blank" style="position:absolute;top:0;right:0;margin:5px;"><i class="fas fa-external-link-alt"></i></a>
				     <a href="javascript:void(0)" title="send SMS" onclick="send_sms('<?php echo $invoiceDtls['client_id'];?>')"> <i class="fas fa-sms text-success" style="font-size:24px;"></i></a>	
				   </div> -->
 
				   
           	  <div class="col-md-11 row-border">                
                  <?php
				  foreach($servicesOrdered as $K1=>$V1) { 					 
					  if(is_array($V1)) {  
						if($K1==0)
						echo '<div class="row p-1 pt-2" style="font-size:16px;">';  
						else
						echo '<div class="row p-1 pt-2 border-top" style="font-size:16px;">';  
						echo "<div class='col-md-5'>".$V1['item_name'].'<br/><small>'.$V1['item_desc'].'</small> <br/>
						'.getStatusStyle($V1['status']).'';
						
						 $service_step_name='';
				   if($V1['service_step_name']!='') { $service_step_name =' <br/><small>Current Phase : '.$V1['service_step_name'].'</small>'; }
						echo ' 
						<span class="current_phase_'.$V1['item_id'].'" style="color:#ff9800;">'.$service_step_name.'</span><br/>
						<span class="serviceStepList phase_div_'.$V1['item_id'].'"></span>   <small><a href="javascript:void(0)" onclick="showServicesteps('.$V1['service_id'].','.$V1['item_id'].')">update Phase</a></small></div>';
						?>
						 
	 <div class='col-md-2'>
	 <?php $param = array('tableName'=>TBL_USERS,'fields'=>array('*'),'showSql'=>'N','condition'=>array('id'=>$V2->user_id.'-INT'));
		$rsUsers = Table::getData($param);  
        	?>
		  
	<span class="assignresponse_<?php echo $V1['item_id'];?>"> <?php    echo $V1['specialist']['name']; ?>  </span>  <br/>
	 <small><a href="javascript:void(0)" class="assignresponse_show_<?php echo $V1['item_id']; ?>" onclick="assignSpecialist(<?php echo $V->id.','.$V1['item_id']; ?>)">[assign specialist]</a></small>	 
	 
 
	  						   
						  </div>
						
						<?php
						$serviceObj->invoice_line_item_id=$V1['item_id'];
						$is_questionnaire=$serviceObj->isQuestionnaire();

						$questionnaireStr='&nbsp;<span style="font-size:20px;"><br/>';
						if($is_questionnaire)
						  $questionnaireStr.='<a href="javascript:void(0)" class="btn btn-sm btn-primary" title="questionnaire" onclick="show_Client_questionnaire('.$V1['item_id'].','.$V->id.')">questionnaire</a> ';

					 	echo "<div class='col-md-4'><span id='status_".$V1['item_id']."'>";
						echo $questionnaireStr.'<a href="javascript:void(0)" class="btn btn-sm btn-success" title="update status" onclick="show_invoice_status('.$V1['item_id'].')">update status</a>	 	
 <a href="javascript:void(0)"  class="btn btn-sm btn-warning" title="documents and files" onclick="list_client_documents('.$V1['item_id'].')">documents</a>					  
				   </span>
                  </div>';
						
						echo ' </div>';
					   // echo "<li class='pl-5;><i class='fas fa-check'></i>&nbsp;".$V1['item_name']."&nbsp;&nbsp;".getStatusStyle($V1['status'])." --- ".date('M d, Y',strtotime($V1['estimated_delivery_date']))."</li>";
					  }
				  }
				  ?>                  
                     </div>
                   <div class="col-md-1 pb-2 row-border">					 
					    &nbsp;&nbsp;<span style="font-size:20px;padding-top:10px;">
						<?php if($_SESSION['user_type']!='FL') { ?>
						<a href="javascript:void(0)" class="btn btn-sm btn-danger" onclick="show_invoice_paymentDtls(<?php echo $V->id;?>)">Payments</i></a>&nbsp;
						<?php } ?>
						<a href="javascript:void(0)"  onclick="showSendEmail(<?php echo $V->id;?>,'all','C')"  class="btn btn-sm btn-info">Email</a>
						</span> 
						</div>
						</div> 
              </div>
                
         <?php  } }   ?>
		 <script>
 function backInvoicesList() {
	 if($('.table_div').html()!='<span style="color:#039CFD">Loading..</span>')
	 {
		$('.table_div').show();
		$('.view_invoices_div').hide();
		$('#search_form_div').show();
		$('.right_bar_div').html('');
	 }
	 else
	 {
		$('.table_div').show();		  
		$('.view_invoices_div').hide(); 			   			 
		$('#search_form_div').show(); 	
		paramData = {'act':'show_invoices_list'};
		ajax({ 
		a:'invoices',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		  $('.table_div').html(data);			 		   
		  
		}});	
	 }
			 
 }
 
 function backtoInvoicesDetls() {
	  $('.view_invoices_div').show();
	  $('.preview_div').hide(); $('.right_bar_div').html('');
 }
		


function showSendEmail(id,email_type,param_type) {

   if(param_type=='I') paramData = {'act':'showSendEmail','invoice_id':id,param_type:param_type,'email_type':email_type};
   if(param_type=='C') paramData = {'act':'showSendEmail','client_id':id,param_type:param_type,'email_type':email_type};
   if(param_type=='IS') paramData = {'act':'showSendEmail','installment_id':id,param_type:param_type,'email_type':email_type};
   if(param_type=='L') paramData = {'act':'showSendEmail','lead_id':id,param_type:param_type,'email_type':email_type};
   if(param_type=='IP') paramData = {'act':'showSendEmail','invoice_payment_id':id,param_type:param_type,'email_type':email_type}; //invoice payment

	ajax({ 
		a:'process',
		b:$.param(paramData), 
		c:function(){},
		d:function(data){ 		
		  $('.right_bar_div').html(data);	
          $('#con-close-modal').modal('show');		  
		}});	
} 

		
		function show_Client_questionnaire(invoice_item_id,invoice_id) {
	paramData = {'act':'show_Client_questionnaire','line_item_id':invoice_item_id,'invoice_id':invoice_id};
	ajax({ 
		a:'invoices',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		  //$('.table_div').show();	
		  $('.preview_div').show();	
		  $('.preview_div').html(data);	
		  $('.view_invoices_div').hide();	
		  
		}});	
}


function showQuestionnaire(service_id) {
	      paramData = {'act':'showQuestionnaire', 'service_id': service_id};
          ajax({ 
            a:'process',
            b:$.param(paramData),
            c:function(){},
            d:function(data){  	
				$('.preview_div').show();	
				$('.questionnaire_html').html(data);	
				$('.view_invoices_div').hide();
            }});	    
	 
}
 //showQuestionnaire(<?php echo $_REQUEST['line_item_id'];?>);

function processQuestionnaire() {
  $( "form#questionnaire" ).submit(function( event ) {
   event.preventDefault();
   $.ajax({
		url: "process_questionnaire.php",
		type: "POST",
		data:  new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		success: function(data){   alert(data);
		 
			$('.preview_div').show();	
			$('.questionnaire_html').html(data);	
			$('.view_invoices_div').hide();

		},
		error: function(){} 	        
		});  });
}  

function showQuestionnaireCmts(invLineItemId,documentId,questionnaireId) {
	 paramData = {'act':'showQuestionnaireCmts','invoice_line_item_id': invLineItemId,"document_id":documentId,"questionnaire_id":questionnaireId };
          ajax({ 
            a:'process',
            b:$.param(paramData),
            c:function(){},
            d:function(data){  
				$('.right_bar_div').css('position','absolute');			
			   $('.right_bar_div').html(data);
			   var eleTopPos=100;               
               topPos=$('#docId_'+documentId).offset().top-eleTopPos;
			   //console.log($('#docId_'+documentId).offset().top);
               $('.right_bar_div').animate({top:topPos},1500);
            }}); 
}

function acceptInvoice(curCheck, quesDet)
{
	if(confirm('Are you sure you want to update this?'))
	{	
		var ischecked=0;
		
		if(curCheck.checked)
			ischecked=1;

		//alert(quesDet+"-"+ischecked);
		paramData = {'act':'acceptInvoiceDoc','ids':quesDet,'ischecked':ischecked};
		
		ajax({ 
            a:'process',
            b:$.param(paramData),
            c:function(){},
            d:function(data){  

		}}); 	
	}	
	else{curCheck.checked=false;}	
}
function checkInvoiceDocAccepted(curCheck,ids,invId)
{
	if(confirm('Are you sure you want to update this?'))
	{			
		paramData = {'act':'checkInvoiceDocAccepted','ids':ids,'ischecked':curCheck.value,'invoice_id':invId};
		
		ajax({ 
            a:'process',
            b:$.param(paramData),
            c:function(){},
            d:function(data){  
				//alert(data);
		}}); 	
	}	
	
}

function checkInvoiceDocNotApplicable(curCheck,ids,invId)
{
	if(confirm('Are you sure you want to update this?'))
	{	
		var ischecked=0;
		
		if(curCheck.checked)
			ischecked=1;

		paramData = {'act':'checkInvoiceDocNotApplicable','ids':ids,'ischecked':ischecked,'invoice_id':invId};
		
		ajax({ 
            a:'process',
            b:$.param(paramData),
            c:function(){},
            d:function(data){  

		}}); 	
	}	
	else{curCheck.checked=false;}	
}
</script>
	 