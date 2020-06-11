<?php 

$prev=$next=$last=$first='&nbsp;';

if($page > 1)
	$first = "<img src='assets/images/first_page.png' style='cursor:pointer; margin-top:3px;' border='0'  onclick='ShowListPagination(\"1\",\"".$filter_by."\")'/>";
	
	if($page < $totalPages)
	$last = "<img src='assets/images/last_page.png' style='cursor:pointer; margin-top:3px;' border='0' onclick='ShowListPagination(\"$totalPages\",\"".$filter_by."\")'/>";
	if(count($rsInvoices)>0 && $totalPages > 1){
	if($page > 1){
		$pageNo = $page - 1;
		$prev = "<img src='assets/images/prev_page.png' style='cursor:pointer; margin-top:3px;' border='0' onclick='ShowListPagination(\"".$pageNo."\",\"".$filter_by."\")'/>";
	} 
		
	if ($page < $totalPages){
		$pageNo = $page + 1;
		$next = " <img src='assets/images/next_page.png' style='cursor:pointer; margin-top:3px;' border='0' onclick='ShowListPagination(\"".$pageNo."\",\"".$filter_by."\")'/>";
	} 
	
	if($pageNo=='')
		$pageNo=1;
	if($totalPages>1) {
	$pagebox="<td style='border:0;'><input type='text' name='page' id='page' value='".$page."' onchange='ShowListPagination(this.value,\"".$filter_by."\")' style='border: 1px solid rgb(170, 170, 170); text-align: center; width: 25px; height: 15px; vertical-align: middle;' size='4'> of $totalPages</td>";
	}	

	$table_val = "<table class='' width='100%;padding:10px' cellpadding='5' cellspacing='0' border='0' style='border:0;><tr style='background-color:#fff'><td align='center' style='border:1; font-size:14px; vertical-align:middle; color:#000; padding:10px;'></td><td align='right'><table align='right' cellpadding='0' cellspacing='1'><tr style='background-color:#fff'><td style='padding:10px 12px;'>$first</td><td style='padding:10px 6px;'> $prev </td>$pagebox<td style='padding:10px 2px;'>$next </td><td style='padding:10px 12px;'>$last</td></tr></table></td></tr></table>";
}  
   
?>

<div class="col-md-12"><hr></div>
<div class="row text-white bg-primary">       
    <div class="col-md-1 p-2 row-border text-center">#</div>        
    <div class="col-md-1 p-2 row-border">Order # / Date </div>
    <div class="col-md-1 p-2 row-border">Amount</div>
    <div class="col-md-2 p-2 row-border">Client Details</div>    
    <div class="col-md-6 p-2 row-border">Services Ordered</div>                
    <div class="col-md-1 p-2 row-border">Action</div>                
</div>
 
 <?php   
  	  if(count($listingArr)>0) {
			foreach($listingArr as $K=>$V) {
			  
				$serviceObj = new Invoice();
				$serviceObj->invoice_id = $V->id;
				$servicesOrdered = $serviceObj->getServicesByInvoiceId();
				$invoiceDtls = $serviceObj->getInvoiceDetails();
			
			$clientCompany='';
			if($invoiceDtls['client']['company']!='') { $clientCompany='<strong>'.$invoiceDtls['client']['company'].'</strong><br/>';  }
		
				?>				
            <div class="row row-striped mt-2" id="invoiceRow_<?php echo $V->id;?>">   
               <div class="col-md-1  p-1 row-border text-center"><?php echo ($K+1); ?></div>            
                  <div class="col-md-1 pb-2  row-border">
                      <span class="text-secondary"><a href="javascript:void(0)" onclick="viewInvoices(<?php echo $V->id; ?>)" class="text-primary"><strong>BPE-<?php echo $V->id;?></strong></a></span><br/>
                      <?php echo date('M d, Y',strtotime($V->added_date));   ?></div>
					  <div class='col-md-1 row-border'><?php if(trim($V->balance_amount)<=0) echo '<i class="fas fa-check-circle text-success" style="font-size:18px"></i>&nbsp;';?><?php echo $invoiceDtls['amount_details']['final_amount']; ?></div>
                   <div class="col-md-2 p-2 row-border" style="overflow: auto;">
				   
		  <?php echo $clientCompany.$invoiceDtls['client']['name'].' &nbsp;<a style="color:#f76397" href="'.SHAREPOINT_LINK.$invoiceDtls['client_id'].	'" target="_blank"><i class="fa fa-folder" aria-hidden="true"></i></a><br/>'.$invoiceDtls['client']['phone'].'<br/>'.$invoiceDtls['client']['email']; ?>
				   <a  href="<?php echo BASE_URL;?>accounts?clid=<?php echo $invoiceDtls['client_id'];?>&ap=1&invi=<?php echo $V->id; ?>" target="_blank" style="position:absolute;top:0;right:0;margin:5px;"><i class="fas fa-external-link-alt"></i></a>
				     <a href="javascript:void(0)" title="send SMS" onclick="send_sms('<?php echo $invoiceDtls['client_id'];?>')"> <i class="fas fa-sms text-success" style="font-size:24px;"></i></a>	
				   </div>
 
				   
           	  <div class="col-md-6 row-border">                
                  <?php
				  foreach($servicesOrdered as $K1=>$V1) { 					 
					  if(is_array($V1)) {  
						if($K1==0)
						echo '<div class="row p-1 pt-2" style="font-size:16px;">';  
						else
						echo '<div class="row p-1 pt-2 border-top" style="font-size:16px;">';  
						echo "<div class='col-md-4'>".$V1['item_name'].'</div>';?>
	 <div class='col-md-3'>
	 <?php   
		 $param = array('tableName'=>TBL_USERS,'fields'=>array('*'),'showSql'=>'N','condition'=>array('id'=>$V2->user_id.'-INT'));
		$rsUsers = Table::getData($param);  
        	?>
		  
	<span class="assignresponse_<?php echo $V1['item_id'];?>"> <?php    echo $V1['specialist']['name']; ?>  </span>  
	 <small><a href="javascript:void(0)" class="assignresponse_show_<?php echo $V1['item_id']; ?>" onclick="assignSpecialist(<?php echo $V->id.','.$V1['item_id']; ?>)">[assign specialist]</a></small>	 
	 <?php echo '<small><a href="javascript:void(0)" onclick="showServicesteps('.$V1['service_id'].','.$V1['item_id'].')">update Phase</a></small>'; ?>
 
	  						   
						  </div>
						
						<?php
						 echo "<div class='col-md-5 text-right'><span id='status_".$V1['item_id']."'>".getStatusStyle($V1['status']);
						 /*' &nbsp;&nbsp;<span style="font-size:20px;">
						 <a href="javascript:void(0)" title="questionnaire" onclick="show_questionnaire('.$V1['item_id'].','.$V->id.')"><i class="fa fa-list-alt text-info" aria-hidden="true"></i> <a/> 
						<!-- <i class="fa fa-file-text-o text-warning"></i> 	-->
						 <a href="javascript:void(0)" title="update status" onclick="show_invoice_status('.$V1['item_id'].')"><i class="mdi mdi-sync"></i></a>		
	<a href="javascript:void(0)" title="documents and files" onclick="list_client_documents('.$V1['item_id'].')"><i class="fas fa-file-upload   text-warning"></i></a>		</span>';*/
						echo '
                  			  
				   </span>
                  </div>'; $service_step_name='';
				   if($V1['service_step_name']!='') { $service_step_name ='<small>Current Phase : '.$V1['service_step_name'].'</small>'; }
						echo ' 
						<span class="current_phase_'.$V1['item_id'].'" style="color:#ff9800;">'.$service_step_name.'</span><br/>
						<span class="serviceStepList phase_div_'.$V1['item_id'].'"></span>';
						
						echo ' </div>';
					   // echo "<li class='pl-5;><i class='fas fa-check'></i>&nbsp;".$V1['item_name']."&nbsp;&nbsp;".getStatusStyle($V1['status'])." --- ".date('M d, Y',strtotime($V1['estimated_delivery_date']))."</li>";
					  }
				  }
				  ?>                  
                     </div>
                   <div class="col-md-1 pb-2 row-border">					 
					    &nbsp;&nbsp;<span style="font-size:20px;padding-top:10px;">
						<a href="javascript:void(0)" onclick="show_invoice_paymentDtls(<?php echo $V->id;?>)"><i class="fa  fa-eye"></i></a>&nbsp;<a style="color:#e86a8d" title="View Log" href="javascript:viewLogs('<?php echo $V->id;?>','<?php echo TBL_INVOICE;?>')">&nbsp;<i class="fa fa-history" aria-hidden="true"></i></a>
						<a href="javascript:void(0)"><i class="fas fa-envelope-open-text text-success"></i></a>
						<a title="Edit Invoice" href="javascript:editInvoice('<?php echo $V->id;?>')"><i class="fa fa-edit" aria-hidden="true"></i></a>
						<a title="Delete Invoice" href="javascript:void();" onclick="deleteInvoice('<?php echo $V->id;?>')"><i style="color:red;font-size: 16px;" class="fas fa-trash"></i></a>						
						</span> 
						</div>
						</div> 
              </div>
			 	  
              </div>
            
         <?php  } } else { ?>
	 <div class="col-md-12">No record found</div> <?php } ?>
	 <div class="col-md-12"><?php  if($table_val!='') { echo  $table_val; } ?></div>
	 
<style> 
.row-border:nth-of-type(odd){ border:1px solid #efefef;}
.row-border:nth-of-type(even){border:1px solid #efefef;}  
</style>
	 
 <script>
     function viewLogs(id,type)
     {
         paramData = {'act':'show_log','id':id,'type':type};
         ajax({
             a:'invoiceStatus',
             b:$.param(paramData),
             c:function(){},
             d:function(data){
                 $('.right_bar_div').html(data);
                 ajax({
                     a:'process',
                     b:$.param(paramData),
                     c:function(){},
                     d:function(data){
                         //alert(data);
                         $('.log_div').html(data);
                     }
                 });
                 $('#logs_modal').modal('show');
             }});
     }
  function viewInvoices(invoiceId) {
	  paramData = {'act':'showClientInvoice', 'invoice_id': invoiceId};
          ajax({ 
            a:'invoices',
            b:$.param(paramData),
            c:function(){},
            d:function(data){  
			 $('.view_invoices_div').show(); 			   
			 $('.view_invoices_div').html(data); 			   
			 $('#search_form_div').hide(); 			   
			 $('.table_div').hide(); 			   
            }});	    	  
 }
 
 
function showServicesteps(serviceId,itemId) { $('.serviceStepList').hide();
	paramData = {'act':'showServiceSteps','id':serviceId,'line_item_id':itemId};
	ajax({ 
		a:'process',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
			  $('.phase_div_'+itemId).show();
			  $('.phase_div_'+itemId).html(data);
		}});	
	
}


 function submitPhaseList(line_item_id) {
	service_step_name =  $('#service_step_name_'+line_item_id).val();
	 paramData = {'act':'updateServiceList','line_item_id':line_item_id,'service_step_name':service_step_name};
	ajax({ 
		a:'process',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
			  var res = data.split('::');
			  alert(res[1]); 
			  $('.current_phase_'+line_item_id).html('<small>Current Phase : '+service_step_name+'</small>');
			  $('.serviceStepList').hide();
		}});	 	 
 }

function closeServiceList() {
	 $('.serviceStepList').hide();
	
}


	function assignSpecialist(id,line_item_id) {
	paramData = {'act':'view_assign_specialist','id':id,'line_item_id':line_item_id};
	ajax({ 
		a:'invoices',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
			$('.modal-popup').html(data); 
			$('#con-close-modal-1').modal('show'); 	  
		}});	
}


function send_sms(id) {
	
	paramData = {'client_id':id,'type':'client'};
	ajax({ 
		a:'send_sms',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		
			$('.right_bar_div').html(data);	
		  $('#con-close-modal').modal('show'); 		   
		}});	
}


function ShowListPagination(page,filter_type,filter_text,service_types) { 
	 paramData = {'act':'show_invoices_list','page':page,'filter_type':filter_type,'filter_text':filter_text}
	ajax({ 
		a:'invoices',
		b:$.param(paramData),
		c:function(){},
		d:function(data){  
		  $('.table_div').html(data);		
		}});	
	}
	
 
 
  function showDocumentUploadForm(service_id) {
	  paramData = {'act':'showDocumentsUploadForm', 'invoice_line_item_id': service_id};
          ajax({ 
            a:'documents',
            b:$.param(paramData),
            c:function(){},
            d:function(data){  
			 $('.right_bar_div').html(data);
			  $('#con-close-modal').modal('show');
            }});	    	  
 }
 
 function list_client_documents(invoice_line_item_id) {
	  paramData = {'act':'showDocumentsList','invoice_line_item_id':invoice_line_item_id};
          ajax({ 
            a:'documents',
            b:$.param(paramData),
            c:function(){},
            d:function(data){  
			  $('.right_bar_div').html(data);
            }});	    	  
 }
 
 
  function show_invoice_paymentDtls(invoice_id) {
	  paramData = {'act':'show_invoice_payment_details','invoice_id':invoice_id};
          ajax({ 
            a:'invoices',
            b:$.param(paramData),
            c:function(){},
            d:function(data){   
			  $('.right_bar_div').html(data);
			  $('#con-close-modal').modal('show');
			  
            }});	    	  
 }
 function deleteInvoice(invId)
{
    if(confirm('Are you sure you want to delete this invoice and related items?'))
    {
        paramData = {'act':'delete_invoice','invoice_id':invId};
        ajax({ 
		a:'invoiceStatus',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
			searchInvoice();
            alert('BPE-'+invId+' deleted!');
		}});	
    }
}
function editInvoice(invId)
{
	paramData = {'act':'edit_invoice','invoice_id':invId};
        ajax({ 
		a:'edit_invoice',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
			$('.table_div').html(data);
		}});	
}
 /*function edit_questionnaire(invoice_item_id) { $('.modal-backdrop').hide(); $('#con-close-modal').modal('hide'); $('.right_bar_div').html('');	
	paramData = {'act':'edit_questionnaire','line_item_id':invoice_item_id};
	ajax({ 
		a:'invoices',
		b:$.param(paramData),
		c:function(){},
		d:function(data){ 
		  $('.right_bar_div').html(data);	
		  $('#con-close-modal').modal('show');	
		  
		}});	
	
} */
	</script>

