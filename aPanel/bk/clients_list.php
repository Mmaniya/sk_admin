<?php 

$prev=$next=$last=$first='&nbsp;';

if($page > 1)
	$first = "<img src='assets/images/first_page.png' style='cursor:pointer; margin-top:3px;' border='0'  onclick='ShowListPagination(\"1\",\"".$filter_type."\",\"".$filter_textbox."\")'/>";
	
	if($page < $totalPages)
	$last = "<img src='assets/images/last_page.png' style='cursor:pointer; margin-top:3px;' border='0' onclick='ShowListPagination(\"$totalPages\",\"".$filter_type."\",\"".$filter_textbox."\")'/>";
	if(count($rsClients)>0 && $totalPages > 1){
	if($page > 1){
		$pageNo = $page - 1;
		$prev = "<img src='assets/images/prev_page.png' style='cursor:pointer; margin-top:3px;' border='0' onclick='ShowListPagination(\"".$pageNo."\",\"".$filter_type."\",\"".$filter_textbox."\")'/>";
	} 
		
	if ($page < $totalPages){
		$pageNo = $page + 1;
		$next = " <img src='assets/images/next_page.png' style='cursor:pointer; margin-top:3px;' border='0' onclick='ShowListPagination(\"".$pageNo."\",\"".$filter_type."\",\"".$filter_textbox."\")'/>";
	} 
	
	if($pageNo=='')
		$pageNo=1;
	if($totalPages>1) {
	$pagebox="<td style='border:0;'><input type='text' name='page' id='page' value='".$page."' onchange='ShowListPagination(this.value,\"".$filter_type."\",\"".$filter_textbox."\")' style='border: 1px solid rgb(170, 170, 170); text-align: center; width: 25px; height: 15px; vertical-align: middle;' size='4'> of $totalPages</td>";
	}	

	$table_val = "<table class='' width='100%;padding:10px' cellpadding='5' cellspacing='0' border='0' style='border:0;><tr style='background-color:#fff'><td align='center' style='border:1; font-size:14px; vertical-align:middle; color:#000; padding:10px;'></td><td align='right'><table align='right' cellpadding='0' cellspacing='1'><tr style='background-color:#fff'><td style='padding:10px 12px;'>$first</td><td style='padding:10px 6px;'> $prev </td>$pagebox<td style='padding:10px 2px;'>$next </td><td style='padding:10px 12px;'>$last</td></tr></table></td></tr></table>";
}  
   
?>

<div class="col-md-12"><hr></div>
<div class="row text-white" style="background-color:#096AB6; font-weight:normal">       
    <div class="col-md-1 p-2 row-border text-center">#</div>        
    <div class="col-md-2 p-2 row-border">Client Name </div>
    <div class="col-md-3 p-2 row-border">Client Details</div>    
    <div class="col-md-6 p-2 row-border">Invoice Details</div>                  
</div> 
 <?php   
    if(count($listingArr)>0) {
			foreach($listingArr as $key=>$val) { 			  
		
		$clientCompany='';
			if($val->client_company_name!='') { $clientCompany='<strong>'.$val->client_company_name.'</strong><br/>';  }
		
		
				?>
            <div class="row row-striped mt-2">   
               <div class="col-md-1  p-1 row-border"><?php echo ($key+1); ?></div>            
               <div class="col-md-2  p-1 row-border" id="client_name_<?php echo $val->id;?>"><?php echo $clientCompany.$val->client_fname.' '.$val->client_lname; ?></div>            
               <div class="col-md-3 p-1 row-border" id="client_details_<?php echo $val->id;?>">
			   <?php   echo '<a href="mailto:'.$val->client_email.'">'.$val->client_email.'</a><br/><a href="tel:'.$val->client_phone.'">'.$val->client_phone.'</a>'.'<br/>'.$val->client_address.'<br/>'.$val->client_city.' - '.$val->client_state; ?></div>            
               <div class="col-md-4 p-1 row-border">
			   <?php
				$param = array('tableName'=>TBL_INVOICE,'fields'=>array('*'),'showSql'=>'N','condition'=>array('client_id'=>$val->id.'-INT','is_deleted'=>'N-CHAR'));     
				$rsInvoices  = Table::getData($param);	
	if(count($rsInvoices)>0) { 
	   foreach($rsInvoices as $K=>$V) {
				$serviceObj = new Invoice();
				$serviceObj->invoice_id = $V->id;
				$invoiceDtls = $serviceObj->getInvoiceDetails(); 
				
			  ?>
						   <div class="row" style="margin-left:0px;margin-bottom: 10px;border-bottom: 1px solid #eee;">
						     <div class="col-md-6"> 
							 <span class="text-secondary">
							     <a href="javascript:void(0)" class="text-primary"><strong>BPE-<?php echo $V->id;?></strong></a>
						    </span><br/><?php 	echo date('M d, Y',strtotime($V->added_date));   ?></div>
						     <div class="col-md-3"><?php echo $invoiceDtls['amount_details']['final_amount']; ?></div>
						     <div class="col-md-2"> 
                        <?php						
						$invoiceObj = new Invoice();
						$invoiceObj->id  = $V->id;
						if($invoiceObj->isInvoicePaid()==0) { ?> 
						<span class="bg-success text-white p-1" style="font-size:13px; font-weight:bold">PAID</span>
                        <i class="fas fa-thumbs-up text-success"></i>
                        <?php } ?></div><hr/>
						   </div>	
 					   
					<?php  } } ?>
			   </div> 
       <div class="col-md-2 row-border">
	        <a href="javascript:void(0)" onclick="showAddEditClients(<?php echo $val->id; ?>)">[edit]</a>
			<a href="javascript:void(0)" onclick="send_sms(<?php echo $val->id; ?>)">[SMS]</a><br/>
			<a href="javascript:void(0)" onclick="show_quotations_lists(<?php echo $val->lead_id; ?>)">[quotation]</a>
	  </div>	          
					 
            </div>
			 
            
          <?php  } } else { ?>
	 <div class="col-md-12">No record found</div>   <?php }  ?>
	 <div class="col-md-12"><?php  if($table_val!='') { echo  $table_val; } ?></div>
	 
<style> 
.row-border:nth-of-type(odd){ border:1px solid #efefef;}
.row-border:nth-of-type(even){border:1px solid #efefef;}  
.right_bar_div .col-form-label { text-align:inherit; }
</style>
	 
 <script>

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


function show_quotations_lists(lead_id) {
	paramData = {'act':'show_quotations_list','lead_id':lead_id};
	ajax({ 
		a:'quotation_list',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		  $('.right_bar_div').html(data);			  
		  		  
		}});	
}


function show_sendQuotation(id) {
	paramData = {'act':'show_send_quotation_form','lead_id':id};
	ajax({ 
		a:'leads',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		  $('.table_div').html(data);			  
		 // $('.right_bar_div').html('');			  
		}});	
}

 function show_services_list() {
	show_clients_list();
}

function showAddEditClients(id) { 	
	paramData = {'act':'showAddEditClients','id':id};
	ajax({ 
		a:'clients',
		b:$.param(paramData),
		c:function(){},
		d:function(data){ 		
			$('.right_bar_div').html(data);	
		  $('#con-close-modal').modal('show'); 		   
		}});	
}

function ShowListPagination(page,filter_type,filter_text) { 
	 paramData = {'act':'filter_clients_list','page':page,'filter_type':filter_type,'filter_text':filter_text}
	ajax({ 
		a:'clients',
		b:$.param(paramData),
		c:function(){},
		d:function(data){  
		  $('.table_div').html(data);		
		}});	
	}
	
 
  
	
	</script>

