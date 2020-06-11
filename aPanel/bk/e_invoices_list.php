<?php 

$prev=$next=$last=$first='&nbsp;';

if($page > 1)
	$first = "<img src='assets/images/first_page.png' style='cursor:pointer; margin-top:3px;' border='0'  onclick='ShowListPagination(\"1\",\"".$filter_by."\",\"".$filter_text_id."\",\"".$filter_textbox."\",\"".$filter_status."\")'/>";
	
	if($page < $totalPages)
	$last = "<img src='assets/images/last_page.png' style='cursor:pointer; margin-top:3px;' border='0' onclick='ShowListPagination(\"$totalPages\",\"".$filter_by."\",\"".$filter_text_id."\",\"".$filter_textbox."\",\"".$filter_status."\")'/>";
	if(count($rsInvoices)>0 && $totalPages > 1){
	if($page > 1){
		$pageNo = $page - 1;
		$prev = "<img src='assets/images/prev_page.png' style='cursor:pointer; margin-top:3px;' border='0' onclick='ShowListPagination(\"".$pageNo."\",\"".$filter_by."\",\"".$filter_text_id."\",\"".$filter_textbox."\",\"".$filter_status."\")'/>";
	} 
		
	if ($page < $totalPages){
		$pageNo = $page + 1;
		$next = " <img src='assets/images/next_page.png' style='cursor:pointer; margin-top:3px;' border='0' onclick='ShowListPagination(\"".$pageNo."\",\"".$filter_by."\",\"".$filter_text_id."\",\"".$filter_textbox."\",\"".$filter_status."\")'/>";
	} 
	
	if($pageNo=='')
		$pageNo=1;
	if($totalPages>1) {
	$pagebox="<td style='border:0;'><input type='text' name='page' id='page' value='".$page."' onchange='ShowListPagination(this.value,\"".$filter_by."\",\"".$filter_text_id."\",\"".$filter_textbox."\",\"".$filter_status."\")' style='border: 1px solid rgb(170, 170, 170); text-align: center; width: 25px; height: 15px; vertical-align: middle;' size='4'> of $totalPages</td>";
	}	

	$table_val = "<table class='' width='100%;padding:10px' cellpadding='5' cellspacing='0' border='0' style='border:0;><tr style='background-color:#fff'><td align='center' style='border:1; font-size:14px; vertical-align:middle; color:#000; padding:10px;'></td><td align='right'><table align='right' cellpadding='0' cellspacing='1'><tr style='background-color:#fff'><td style='padding:10px 12px;'>$first</td><td style='padding:10px 6px;'> $prev </td>$pagebox<td style='padding:10px 2px;'>$next </td><td style='padding:10px 12px;'>$last</td></tr></table></td></tr></table>";
}  
   
?>

<div class="col-md-12"><hr></div>
<div class="row text-white bg-primary">       
    <div class="col-md-1 p-2 row-border text-center">#</div>        
    <div class="col-md-1 p-2 row-border">Order # / Date </div>
	<?php if($_SESSION['user_type']!='FL') { ?>
    <div class="col-md-1 p-2 row-border">Amount</div>
	<?php } ?>
    <div class="col-md-2 p-2 row-border">Client Details</div>    
    <div class="col-md-6 p-2 row-border">Services Ordered</div>                
    <div class="col-md-1 p-2 row-border">Action</div>                
</div>
 
 <?php   
  	  if(count($listingArr)>0) {
			foreach($listingArr as $K=>$V) {
			  
				$serviceObj = new Invoice();
				$serviceObj->invoice_id = $V->id;
				$serviceObj->specialist_id=$_SESSION['user_id'];
				$servicesOrdered = $serviceObj->getServicesByInvoiceId();
				$invoiceDtls = $serviceObj->getInvoiceDetails();
			
		
				?>
            <div class="row row-striped mt-2">   
               <div class="col-md-1  p-1 row-border text-center"><?php echo ($K+1); ?></div>            
                  <div class="col-md-1 pb-2  row-border">
                      <span class="text-secondary"><a href="invoices.php?invId=<?php echo $V->id;?>" target="_blank"  class="text-primary"><strong>BPE-<?php echo $V->id;?></strong></a></span><br/>
                      <?php echo date('M d, Y',strtotime($V->added_date));   ?></div>
					  <?php if($_SESSION['user_type']!='FL') { ?>
					  <div class='col-md-1 row-border'><?php echo $invoiceDtls['amount_details']['final_amount']; ?></div>
					  <?php } ?>
                   <div class="col-md-2 p-2 row-border" style="overflow: auto;">
				   
				   <?php echo $invoiceDtls['client']['name'].'<br/>'.$invoiceDtls['client']['phone'].'<br/>'.$invoiceDtls['client']['email']; ?>
				   <a  href="<?php echo BASE_URL;?>accounts?clid=<?php echo $invoiceDtls['client_id'];?>&ap=1&invi=<?php echo $V->id;?>" target="_blank" style="position:absolute;top:0;right:0;margin:5px;"><i class="fas fa-external-link-alt"></i></a>
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
						echo "<div class='col-md-4'>".$V1['item_name'].'</div>'; ?>
	 
	 <?php   
		 $param = array('tableName'=>TBL_USERS,'fields'=>array('*'),'showSql'=>'N','condition'=>array('id'=>$V2->user_id.'-INT'));
		$rsUsers = Table::getData($param);  
        	  
			 echo '<div class="col-md-3"><a href="javascript:void(0)" onclick="showServicesteps('.$V1['service_id'].','.$V1['item_id'].')">update Phase</a></div>';
			 
						/*&nbsp;&nbsp;<span style="font-size:20px;">
				      <a href="javascript:void(0)" title="questionnaire" onclick="show_questionnaire('.$V1['item_id'].','.$V->id.')"><i class="fa fa-list-alt text-info" aria-hidden="true"></i> <a/> 
				     <!-- <i class="fa fa-file-text-o text-warning"></i> 	-->
                      <a href="javascript:void(0)" title="update status" onclick="show_invoice_status('.$V1['item_id'].')"><i class="mdi mdi-sync"></i></a>		
 <a href="javascript:void(0)" title="documents and files" onclick="list_client_documents('.$V1['item_id'].')"><i class="fas fa-file-upload   text-warning"></i></a>	*/
						 
					 	echo "<div class='col-md-5 text-right'><span id='status_".$V1['item_id']."'>".getStatusStyle($V1['status']);
						echo '
                  </span> 				  
				   </span>
                  </div>';$service_step_name='';
				  if($V1['service_step_name']!='') { $service_step_name ='<small>Current Phase : '.$V1['service_step_name'].'</small>'; }
						echo ' 
						<span class="current_phase_'.$V1['item_id'].'" style="color:#ff9800;">'.$service_step_name.'</span><br/>
						<span class="serviceStepList phase_div_'.$V1['item_id'].'"></span>
						</div>';
					   // echo "<li class='pl-5;><i class='fas fa-check'></i>&nbsp;".$V1['item_name']."&nbsp;&nbsp;".getStatusStyle($V1['status'])." --- ".date('M d, Y',strtotime($V1['estimated_delivery_date']))."</li>";
					  }
				  }
				  ?>                  
                     </div>
                   <div class="col-md-1 pb-2 row-border">					 
					    &nbsp;&nbsp;<span style="font-size:20px;padding-top:10px;">
						<?php if($_SESSION['user_type']!='FL'){ ?>
						<a href="javascript:void(0)" onclick="show_invoice_paymentDtls(<?php echo $V->id;?>)"><i class="fa fa-dollar"></i></a>&nbsp;
						<?php } ?>
						<a href="javascript:void(0)" onclick="showSendEmail(<?php echo $V->client_id;?>,'all','C')"><i class="fas fa-envelope-open-text text-success"></i></a>
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

 
function ShowListPagination(page,filter_type,filter_text_id,filter_textbox,filter_status) { 
	 paramData = {'act':'show_invoices_list','page':page,'filter_type':filter_type,'filter_text_id':filter_text_id,'filter_textbox':filter_textbox,'filter_status':filter_status}
	ajax({ 
		a:'e_dashboard',
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

function show_invoice_status(invoice_item_id) {
	paramData = {'act':'show_invoice_status','id':invoice_item_id};
	ajax({ 
		a:'invoices',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		  $('.right_bar_div').html(data);			  
		}});	
}


function show_questionnaire(invoice_item_id,invoice_id) {
	paramData = {'act':'show_questionnaire','line_item_id':invoice_item_id,'invoice_id':invoice_id};
	ajax({ 
		a:'invoices',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		  $('.right_bar_div').html(data);	
		  $('#con-close-modal').modal('show');	
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
			 $('#right_bar_div').hide();			   
            }});	    	  
 }	
	</script>

