<?php 

$prev=$next=$last=$first='&nbsp;';

if($page > 1)
	$first = "<img src='assets/images/first_page.png' style='cursor:pointer; margin-top:3px;' border='0'  onclick='ShowListPagination(\"1\",\"".$filter_by."\")'/>";
	
	if($page < $totalPages)
	$last = "<img src='assets/images/last_page.png' style='cursor:pointer; margin-top:3px;' border='0' onclick='ShowListPagination(\"$totalPages\",\"".$filter_by."\")'/>";
	if(count($rsLeads)>0 && $totalPages > 1){
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
    $packageObj = new Packages; 
	$categoryObj = new ServiceCategory(); 
?>
 
 
<div class="row bg-primary text-white">
<div class="col-md-1 p-2 d-none d-sm-block border-left"><strong>#</strong></div>
<div class="col-md-1 p-2 d-none d-sm-block border-left"><strong>Invoice ID</strong></div>
<div class="col-md-3 p-2 d-none d-sm-block border-left"><strong>Client Details</strong></div>
<div class="col-md-3 p-2 d-none d-sm-block border-left"><strong>Services</strong></div>
<div class="col-md-1 p-2 d-none d-sm-block border-left"><strong>Amount Paid</strong></div>
<div class="col-md-1 p-2 d-none d-sm-block border-left"><strong>Balance Amount</strong></div>
<div class="col-md-2 p-2 d-none d-sm-block border-left"><strong>Action</strong></div>
</div>
<!--div class="col-md-12 d-none d-sm-block"><hr style="margin-bottom:0px;"></div>-->
 <?php   
	  if(count($listingArr)>0) { $total_paid=0; $total_balance=0;
	   foreach($listingArr as $key=>$val) {
		   
		   $qry = "SELECT client_id,balance_amount from `".TBL_INVOICE."` where id = $val->invoice_id";
		   $invoiceRes= dB::sExecuteSql($qry);
           $clientId= $invoiceRes->client_id;
		   $qry = "SELECT * from `".TBL_CLIENTS."` where id = $clientId";
		   $rsClient = dB::sExecuteSql($qry);
		   
		   $clientName = $rsClient->client_fname.' '.$rsClient->client_lname;
		   $clientPhone = $rsClient->client_phone;
		   $clientEmail = $rsClient->client_email;

			//get invoice line item
		   $param = array('tableName'=>TBL_INVOICE_LINE_ITEM,'fields'=>array('line_item'),'showSql'=>'N','condition'=>array('invoice_id'=>$val->invoice_id.'-INT'));
			$rsInvoiceLineItem = Table::getData($param);   
			$lineItemStr='';

			foreach($rsInvoiceLineItem as $LIK=> $LIV)
			{
				$lineItemStr.="<div style='border-bottom: 1px solid #dee2e6'>".$LIV->line_item."</div>";
			}

			//$lineItemStr=substr($lineItemStr,0,-4);

   ?>
<div class="row tb_row">
<div class="col-md-1 d-none d-sm-block col-1 row-border"><?php echo $key+1;  echo $warning; ?></div>
<div class="col-md-1 d-none d-sm-block row-border">
	<span class="text-secondary text-primary"><strong>BPE-<?php echo $val->invoice_id;?></strong></span>
 </div>
 
 <?php
                $clientCompany='';
					 if($rsClient->client_company_name!='') { 
					 $clientCompany = '<strong>'.$rsClient->client_company_name.'</strong><br/>';  }
					 ?>
 
<div class="col-md-3 row-border">
<strong><?php echo $clientCompany.$clientName.' &nbsp;<a style="color:#f76397" href="'.SHAREPOINT_LINK.$rsClient->id. '" target="_blank"><i class="fa fa-folder" aria-hidden="true"></i></a>';?></strong>   <br/>
<a href="tel:<?php echo $clientPhone;?>"><?php echo formatPhoneNumber($clientPhone);?> </a><br/>
<?php echo $clientEmail; ?>
</div>
 
<div class="col-md-3 row-border">
<?php echo $lineItemStr;?>
</div>
 
 
<div class="col-md-1 row-border text-right"> <?php echo money($val->amount_paid,'$'); $total_paid+=$val->amount_paid;?><br/>
	<small><i><strong><?php echo date('M d, Y',strtotime($val->added_date));   ?></strong></i></small>
 </div>
 
 <div class="col-md-1 row-border text-right"> <?php echo money(($invoiceRes->balance_amount>0)?$invoiceRes->balance_amount:0,'$'); $total_balance+=$invoiceRes->balance_amount;?> </div>
	


 <div class="col-md-2 action_col  row-border text-right"> 
<a href="javascript:void(0)" onclick="dash_invoice_paymentDtls(<?php echo $val->id.','.$val->invoice_id; ?>)" title="View"><i class="fa fa-eye" style="font-size:20px;" aria-hidden="true"></i></a>  &nbsp;
<a title="Edit Invoice" href="invoices.php?invoiceId=<?php echo $val->invoice_id;?>&edit=1" target="_blank"><i style="font-size: 18px;" class="fa fa-edit" aria-hidden="true"></i></a>&nbsp;
<a href="javascript:void(0)" onclick="showSendEmail(<?php echo $val->id;?>,'all','IP')" title="send email"><i style="font-size:20px;" class="fa fa-envelope" aria-hidden="true"></i></a> &nbsp;
<a href="javascript:void(0)" title="PDF"><i  style="font-size:20px;" class="fa fa-file-pdf-o" aria-hidden="true"></i></a> &nbsp;
 </div>
	 
	</div>
	 <?php } ?>
	 <div class="row tb_row">
	   <div class="col-md-8 row-border text-right"><strong>Total</strong></div>
	   <div class="col-md-1 row-border text-right"><strong><?php echo money($total_paid,'$');?></strong></div>
	   <div class="col-md-1 row-border text-right"><strong><?php echo money($total_balance,'$');?></strong></div>
	   <div class="col-md-2 action_col  row-border text-right"> 
	   </div>
	 </div>
	 <?php
	  } else { ?>
	 <div class="col-md-12 text-center p-2 ">No record found</div> <?php } ?>
	 <div class="col-md-12"><?php  if($table_val!='') { echo  $table_val; } ?></div>
	 
<style> 
.row-border:nth-of-type(odd){ border:1px solid #efefef;padding:5px;}
.row-border:nth-of-type(even){border:1px solid #efefef;padding:5px;}  
 
.tb_row {   border-bottom: 1px solid #ffffff;  }
 .tb_row:nth-child(odd) {background-color: #ffffff;} 

 .warning_row .col-1 { background-color:#ff0000; color:#fff; }
.warning { font-size: 25px; color: #fff; }

.action_col { font-size:14px; }
.list-services { list-style: none; padding-left:0px; color:#008000; }
.list-services li:before { content: '✓';     padding-right: 5px; }
.mobile-device { display:none; }
@media screen and (max-width: 768px) { .mobile-device { display:block; } 
.warning_row { background-color:#ff0000 !important; color:#fff;     border-top: 2px solid #fff;}
.warning_row a {  color:#fff !important; }
.warning_row .list-services { color:#fff !important; }
 
}


 
</style>
	 
 <script>
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip(); 
});
 

function showAddEditLeadAddressForm(id) {
	paramData = {'act':'add_edit_lead_address','id':id};
	ajax({ 
		a:'process',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		//  $('.right_bar_div').html(data);		
			$('.modal-popup').html(data); 
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


    function view_lead(id) {
		paramData = {'act':'view_lead_details','id':id};
	ajax({ 
		a:'leads',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		    $('.table_div').html(data);			  
		 // $('.right_bar_div').html(data);			  
		}});	 		
	}


   function ShowListPagination(page) { 
	 paramData = {'act':'show_services_list','page':page,}
	ajax({ 
		a:'leads',
		b:$.param(paramData),
		c:function(){},
		d:function(data){  
		  $('.table_div').html(data);		
		}});	
	}
	
	function assignSpecialist(id) {
	paramData = {'act':'view_assign_specialist','id':id};
	ajax({ 
		a:'leads',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
			$('.modal-popup').html(data); 
			$('#con-close-modal').modal('show'); 	  
		}});	
}

function edit_quotation(quotation_id,lead_id) {
	paramData = {'act':'edit_quotation','quotation_id':quotation_id,'lead_id':lead_id};
	ajax({ 
		a:'edit_quotation',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
			    $('.table_div').html(data);	
			   // $('.right_bar_div').html('');	
		}});	
}


	function view_quotation(id) {
	paramData = {'act':'view_quotation','id':id};
	ajax({ 
		a:'view_quotation',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
			    $('.right_bar_div').html(data);	
		}});	
}
	</script>

