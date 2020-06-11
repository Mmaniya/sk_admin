<?php

function main() {
		ini_set('display_errors',1);
	$clientId = $_SESSION['CLIENT_ID'];
	$param = array('tableName'=>TBL_INVOICE,'fields'=>array('*'),'condition'=>array('client_id'=>$clientId.'-INT'),'orderby'=>'added_date','sortby'=>'DESC','showSql'=>'N');
	$rsInvoices = Table::getData($param);
	//echo $latestInvoice = $rsInvoices[0]->id;
	
	if($_SESSION['CLIENT_SPECIALIST']>0) {
	$param = array('tableName'=>TBL_USERS,'fields'=>array('*'),'condition'=>array('id'=>$_SESSION['CLIENT_SPECIALIST'].'-INT'),'showSql'=>'N');
	$rsSpecialist = Table::getData($param);
	$specialistName=$rsSpecialist->contact_fname.' '.$rsSpecialist->contact_lname;
	$specialistEmail=$rsSpecialist->business_email;
	}
	
	$ticketObj = new tickets;
	
 $ticketCount =  $ticketObj->clientNewTicketCount(); 
 
 
?>
 <script type="text/javascript" src="../ckeditor/ckeditor.js"></script> 
<div class="row">
  <div class="col-md-4"><h1 class="heading">Dashboard</h1> </div>
  <div class="col-md-6"> <?php if($ticketCount->total>0) { ?><a href="ticket_view.php" style="color:#ff0000">You have Received Ticket Reply</a> <?php } ?>  </div></div>
<div class="row">
  <div class="col-md-8">
    <div class="card h-100">
      <div class="card-body">
        <h5 class="card-title warning-text text-left">Welcome <?php echo $_SESSION['CLIENT_NAME']; ?></h5>
        <p class="card-text">Thank you for your order with BizPlanEasy. Find the status of your order listed below.</p>
        
        <?php
		if(count($rsInvoices)>0) {
			?>
          <div class="row text-white" style="background-color:#096AB6; font-weight:normal">       
           <div class="col-md-1 p-3  row-border text-center">#
                     </div>        
                  <div class="col-md-2 p-3 row-border">Order # /  Date
                     </div>
                     
                  <div class="col-md-9 p-3  row-border">Service(s) Ordered
                  and Delivery Date(s)</div>
                
              </div>
            <?php
			
			
			foreach($rsInvoices as $K=>$V) {
				$serviceObj = new Invoice();
				$serviceObj->invoice_id = $V->id;
				$servicesOrdered = $serviceObj->getServicesByInvoiceId();
				
		
				?>
            <div class="row row-striped mt-2">   
               <div class="col-md-1 p-1 row-border text-center"><?php echo ($K+1); ?></div>            
                  <div class="col-md-2 pb-2  row-border">
                      <span class="text-secondary"><a href="javascript:void(0)" class="text-primary" onclick="viewOrder(<?php echo $V->id;?>)"><strong>BPE-<?php echo $V->id;?></strong></a></span><br/>
                      <?php echo date('M d, Y',strtotime($V->added_date));   ?></div>
                  <div class="col-md-7  row-border">
                
                  <?php
				  foreach($servicesOrdered as $K1=>$V1) {
					  if(is_array($V1)) {
						if($K1==0)
						echo ' <div class="row p-1 pt-2" style="font-size:16px;">';  
						else
						echo ' <div class="row p-1 pt-2 border-top" style="font-size:16px;">';  
						echo "<div class='col-md-4'>".$V1['item_name'].'</div>';
						echo "<div class='col-md-2'>".date('M d, Y',strtotime($V1['estimated_delivery_date'])).'</div>';
						echo "<div class='col-md-4'>".getStatusStyle($V1['status']).'</div>';
						echo '<div class="col-md-2 ">
                  <!-- <span style="font-size:25px;"> <i class="fa fa-list-alt text-info" aria-hidden="true"></i> <i class="fas fa-file-invoice-dollar text-success"></i> 
                <i class="fas fa-file-alt text-warning"></i></span>-->
                  </div>';
						echo ' </div>';
					   // echo "<li class='pl-5;><i class='fas fa-check'></i>&nbsp;".$V1['item_name']."&nbsp;&nbsp;".getStatusStyle($V1['status'])." --- ".date('M d, Y',strtotime($V1['estimated_delivery_date']))."</li>";
					  }
				  }
				  ?>
                 
                                     </div>
		   <div class="col-md-2 row-border">
		       <span class="text-secondary">
			        <a href="javascript:void(0)"  style="margin-top:10px;" class="btn btn-primary btn-sm " onclick="viewOrder(<?php echo $V->id;?>)">View order</a>
			   </span>
    	  </div>
              </div>
			 
            
         <?php  } } ?>     
        </div>
      </div>
    </div>
  
  <div class="col-md-4">
    <div class="card  h-100">
        <h5 class="card-header warning-text text-left">Your BizPlanEasy Specialist</h5>
      <div class="card-body"><div class="card-text">
        <?php
		
		if($_SESSION['CLIENT_SPECIALIST']>0) {
		?>
          
              <b><?php echo $specialistName?></b><br/>
              <i class="fas fa-envelope"></i>&nbsp;&nbsp; <a href="mailto:<?php echo $specialistEmail;?>"><?php echo $specialistEmail?></a> <br/>
              <i class="fas fa-phone-alt"></i>&nbsp;&nbsp; <?php echo SUPPORT_PHONE_NUMBER;?> 
        
        <?php
		} else {
		?> 
        One of our BizPlanEasy Specialist will be assigned for your services. Until then, our support team will be at your service during business hours. <br/><br/>
        <h4>Call Support at <strong class="text-success"><?php echo SUPPORT_PHONE_NUMBER; ?></strong></h4>
        
        <?php } ?> </div>
      </div>
    </div>
  </div>
</div>
<br/>
<div class="row">
  <div class="col-md-8">
    <div class="card h-100">
     
        <h5 class="card-header warning-text text-left">Have Questions about your order(s) ? </h5>
      <div class="card-body">
        <p class="card-text">In this section, you can connect to our support team regarding any questions/clarifications about your order(s)</p>
        <div class="table-responsive-md">
           <table class="table table-hover" style="border: 2px solid #eee;">
  <thead class="bg-primary text-white">
    <tr>
		<th scope="col">#</th>
		<th scope="col">Subject</th>
		<th scope="col">status</th>
		<th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
  <?php  $no=1;
  $param = array('tableName'=>TBL_TICKETS,'fields'=>array('*'),'condition'=>array('client_id'=>$_SESSION['CLIENT_ID'].'-INT'),'showSql'=>'N');
  $rsTickets = Table::getData($param);
  if(count($rsTickets)>0) {
	foreach($rsTickets as $key=>$val) {
 
	
	if(!in_array($val->id,$shownTicket) && !in_array($val->parent_id,$shownTicket)) {

if($val->parent_id==0) {
     $ticketObj->ticket_id = $val->id;
	 $shownTicket[$val->id]=$val->id;
	 $mailTicket = $val->id;
}
else {
   	  $ticketObj->ticket_id = $val->parent_id;
	  $shownTicket[$val->parent_id]=$val->parent_id;
	  $mailTicket = $val->parent_id;
}
 
 $ticketDetails =  $ticketObj->getTicketDetails();
 
 $readStatus='';
 $ticketObj->ticket_by = 'U';
	 $rsData = $ticketObj->newTicketCount();
	 if(count($rsData)>0) { $readStatus = 'unread';   } else {
		 $readStatus = 'viewed'; 
	 }
 
 
 $ticketStatus='';
	if($ticketDetails['tickets']['ticket_status']=='O') {  $ticketStatus = 'Open'; }
	if($ticketDetails['tickets']['ticket_status']=='I') {  $ticketStatus = 'In Progress'; }
	if($ticketDetails['tickets']['ticket_status']=='R') {  $ticketStatus = 'Resolved'; }
	if($ticketDetails['tickets']['ticket_status']=='N') {  $ticketStatus = 'Not Resolved'; }
	if($ticketDetails['tickets']['ticket_status']=='C') {  $ticketStatus = 'Close'; }
	
	
		?>
    <tr>
		<th scope="row"><?php echo $no++; ?></th>
		<td><?php echo $ticketDetails['tickets']['subject']; ?></td>
		<td><?php echo $ticketStatus; ?></td>
		<td><a href="ticket_view.php"><i class="fas fa-reply"></i> &nbsp; <span class="messageCount <?php echo $readStatus; ?>"><?php echo $ticketDetails['tickets']['parent_count']; ?></span> </a></td>
    </tr>
    
<?php } }} else { echo '<tr> <td colspan="3" style="text-align:center;">No tickets</td> </tr>'; } ?>
  <tr><td colspan="4" class="text-right"><a href="tickets.php" class="btn btn-danger">Open Ticket</a></td>
  </tbody>
</table></div>

        </div>
      </div>
    </div>

<div class="col-md-4">
    <div class="card  h-100">
        <h5 class="card-header warning-text text-left">Your Documents</h5>
      <div class="card-body">
        
 <p class="card-text">In this section, you can view/upload documents</p>
        <div class="table-responsive-md" id="document_list_tb">
            <table class="table table-hover">
  <thead class="bg-primary text-white">
    <tr>
      <th scope="col">#</th>
      <th scope="col">File Name</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
   <?php 
 $param = array('tableName'=>TBL_CLIENT_DOCUMENTS,'fields'=>array('*'),'orderby'=>'id','sortby'=>'desc','condition'=>array('client_id'=>$_SESSION['CLIENT_ID'].'-INT'),'showSql'=>'N');
 $rsDocuments= Table::getData($param); 
 if(count($rsDocuments)>0) {
 foreach($rsDocuments as $key=>$val) {
	 ?>
  <tr>
      <th scope="row"><?php echo $key+1; ?></th>
      <td><a href="../client_documents/<?php echo $val->document_file;?>" download><?php echo $val->document_name;?></a></td>
	   <th scope="row"><a href="../client_documents/<?php echo $val->document_file;?>" style="font-size: 14px;font-weight: 600;" download>[download]</a> 
<a href="javascript:void(0)" style="font-size: 14px;font-weight: 600;" onclick="delete_document(<?php echo $val->id;?>)">[delete]</a> </th>
    </tr>
 <?php } } else {  ?>  <tr><td colspan="3" class="text-right"> No documents uploded</td> <?php } ?>
 
     <tr><td colspan="3" class="text-right"><a href="#" class="btn btn-danger">Upload</a></td>
  </tbody>
</table></div>
      </div>
    </div>
  </div>
  </div>
<style>
	 .messageCount { color: #fff;  padding: 5px;  border-radius: 5px;  }
	 .unread {   background-color: #ec1919;  }
	 .viewed {   background-color: #2196f3;  } 
	</style>
   
<script>

function viewOrder(order_id) {
	      paramData = {'act':'viewOrder', 'order_id': order_id};
          ajax({ 
            a:'process',
            b:$.param(paramData),
            c:function(){},
            d:function(data){  
			   $('#contentbar').html(data);
            }});	    
	
	
}

//viewOrder('<?php echo $latestInvoice;  ?>');
//viewOrder();

function list_client_documents() {
	  paramData = {'act':'showDocumentsList'};
          ajax({ 
            a:'documents',
            b:$.param(paramData),
            c:function(){},
            d:function(data){  
			  $('#document_list_tb').html(data);
            }});	    	  
 }
 
  function showDocumentUploadForm(service_id) {
	  paramData = {'act':'showDocumentsUploadForm', 'invoice_line_item_id': service_id};
          ajax({ 
            a:'documents',
            b:$.param(paramData),
            c:function(){},
            d:function(data){  
			 $('.upload_form').html(data);
			  $('#con-close-modal').modal('show');
            }});	    	  
 }
 

$('.doneCheckbox').on('click', function () {
        var $this=$(this).closest('tr[stepId]').find('.doneCheckbox'), checked = $this.hasClass('fa-square')?1:0, tr=$this.closest('tr'); stepId=tr.attr('stepId');
        $this.toggleClass('fa-square');
        $this.toggleClass('fa-check-square');
 	    paramData = {'act':'step_done', 'step_id': stepId,'done':checked};
        ajax({ 
            a:'bpe_steps',
            b:$.param(paramData),
            c:function(){},
            d:function(data){  
                alert(data); return;
                data = $.trim(data);
                var pBar=$('.progress-bar');
                pBar.css('width', data+'%').attr('aria-valuenow', data).html(data+'%');
                data<100 ? pBar.removeClass('bg-success') : pBar.addClass('bg-success');
                if (data==0) { pBar.html(''); }
            }});	    
        tr.toggleClass('done');
	});    
    
    $('.showDetails, .title').on('click', function () {
		var tr=$(this).closest('tr[stepId]'), $this=tr.closest('tr[stepId]').find('.showDetails'), checked = tr.attr('visible'), body=tr.find('.body');
		if (checked=='1') {
			body.hide().find('.card-body').hide();
			tr.attr('visible', 0);
		} else {
			body.show().find('.card-body').slideDown();
			tr.attr('visible', 1);
		}
		$this.toggleClass('fa-angle-down');
		$this.toggleClass('fa-angle-up');
		return false;
	});
	
list_client_documents();
</script>    
<?php 
}
include "template.php";
?>