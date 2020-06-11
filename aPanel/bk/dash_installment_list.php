<?php 
$prev=$next=$last=$first='&nbsp;';

if($page > 1)
	$first = "<img src='assets/images/first_page.png' style='cursor:pointer; margin-top:3px;' border='0'  onclick='ShowListPagination(\"1\",\"".$filter_by."\")'/>";
	
	if($page < $totalPages)
	$last = "<img src='assets/images/last_page.png' style='cursor:pointer; margin-top:3px;' border='0' onclick='ShowListPagination(\"$totalPages\",\"".$filter_by."\")'/>";
	if(count($rsInstallment)>0 && $totalPages > 1){
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




<div class="row bg-primary text-white">
<div class="col-md-1  p-2  border-left"><strong>#</strong></div>
<div class="col-md-3  p-2  border-left"><strong>Client Details</strong></div>
<div class="col-md-2  p-2  border-left"><strong>Invoice Details</strong></div>
<div class="col-md-2  p-2  border-left"><strong>Installment Date</strong></div>
<div class="col-md-2  p-2  border-left"><strong>Amount</strong></div>
<div class="col-md-2  p-2  border-left"><strong>Action</strong></div>
</div>

 <?php  
	  if(count($listingArr)>0) {
	   foreach($listingArr as $key=>$val) {
   		   	$param = array('tableName'=>TBL_INVOICE,'fields'=>array('*'),'condition'=>array('id'=>$val->invoice_id.'-INT'));
			$rsInvoice = Table::getData($param);
			
		   	$param = array('tableName'=>TBL_CLIENTS,'fields'=>array('*'),'condition'=>array('id'=>$val->client_id.'-INT'));
			$rsClient = Table::getData($param);
			$sendReminder = 0;	
			$paymentIcon = '';$paymentDtls = '';
			if($val->is_paid=='Y') { $paymentIcon = '<i class="fas fa-thumbs-up text-success"></i>';
			  $qry = "SELECT * from `".TBL_INVOICE_PAYMENT."` WHERE installment_id=".$val->id;
			  $rsPayment = dB::sExecuteSql($qry);
			  $paymentDtls = 'Paid on '.date('M d, Y',strtotime($rsPayment->added_date));
  			  $sendReminder = 0;			  
			}
			if ((strtotime($val->installment_date) < strtotime("+1 day", time())) && $val->is_paid=='N') {
							$paymentIcon = '<i class="fas fa-thumbs-down text-danger"></i>';
							$sendReminder = 1;
			}

                   $clientCompany='';
					 if($invoiceDtls['client']['company']!='') { 
					 $clientCompany = '<strong>'.$invoiceDtls['client']['company'].'</strong><br/>';  }			
  
  ?>
<div class="row border">
<div class="col-md-1 p-2  border-left"><strong><?php echo $key+1; ?></strong></div>
<div class="col-md-3 p-2 border-left"><?php echo $clientCompany.'<strong>'.$rsClient->client_fname.' '.$rsClient->client_lname.'</strong> &nbsp;<a style="color:#f76397" href="'.SHAREPOINT_LINK.$rsClient->id. '" target="_blank"><i class="fa fa-folder" aria-hidden="true"></i></a><br/>'.$rsClient->client_phone.'<br/>'.$rsClient->client_email; ?></div>

<div class="col-md-2 p-2 border-left"><?php echo '<strong> BPE: '.$rsInvoice->id.'</strong>';?></div>


<div class="col-md-2 p-2 border-left"><strong><?php echo date('M d, Y',strtotime($val->installment_date));?></strong></div>

<div class="col-md-2 p-2 border-left"><strong><?php echo money($val->amount,'$'); ?></strong>
<?php echo $paymentIcon.' '.$paymentDtls; ?>


</div>
<div class="col-md-2 p-2 border-left" style="font-size:24px;"><strong>
<?php if($sendReminder==1) { ?>
 <a href="../accounts/installment_payment.php?id=<?php echo $val->id; ?>" target="_blank"><i class="fas fa-stopwatch text-danger"></i> </a>	

<?php } 
elseif($val->is_paid=='N') {
?>
<a href="../accounts/installment_payment.php?id=<?php echo $val->id; ?>"  target="_blank" ><i class="fas fa-comment-dollar text-success"></i></a>
<?php
}
?>
<a href="javascript:void(0)" onclick="showSendEmail(<?php echo $val->id;?>,'P','IS')"><i class="fa fa-envelope" aria-hidden="true"></i> </a>							
   <a href="javascript:void(0)" title="send SMS" onclick="send_sms('<?php echo $val->client_id;?>')"> <i class="fas fa-sms text-success" style="font-size:24px;"></i></a> <a title="Edit Invoice" target="_blank" href="invoiceStatus.php?edit=1&invId=<?php echo $val->invoice_id;?>"><i class="fa fa-edit" aria-hidden="true"></i></a>
<?php if($val->is_paid=='Y') { ?>
<a href="javascript:void(0)" onclick="generatePaymentPDF(<?php echo $val->id; ?>)"><i class="fas fa-file-pdf"></i></a>
<?php } ?>
</strong></div> </div>

	 <?php } } else { ?>
	 <div class="col-md-12">No record found</div> <?php } ?>
	 <div class="col-md-12"><?php  if($table_val!='') { echo  $table_val; } ?></div>