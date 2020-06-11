<?php
 
	$clientId = $_SESSION['CLIENT_ID'];
	$invoiceId = $_POST['order_id'];
	$param = array('tableName'=>TBL_INVOICE,'fields'=>array('*'),'condition'=>array('id'=>$invoiceId.'-INT'),'showSql'=>'N');
	$rsInvoice = Table::getData($param);
	
	if($_SESSION['CLIENT_SPECIALIST']>0) {
		$param = array('tableName'=>TBL_USERS,'fields'=>array('*'),'condition'=>array('id'=>$_SESSION['CLIENT_SPECIALIST'].'-INT'),'showSql'=>'N');
		$rsSpecialist = Table::getData($param);
		$specialistName=$rsSpecialist->contact_fname.' '.$rsSpecialist->contact_lname;
		$specialistEmail=$rsSpecialist->business_email;
	}

	$invoiceObj = new Invoice();
	$invoiceObj->invoice_id= $invoiceId;
	$invoiceServices = $invoiceObj->getInvoiceDetails();
	//echo '<pre>';
	//print_r($invoiceServices);
	//echo '</pre>';
	


 ?>

<h1 class="heading">My Orders</h1>

    <div class="card bg-light mb-3">
    <div class="card-header bg-primary text-white">
        <div class="text-left"><strong>Order Id : BPE-<?=$invoiceId?></strong> <span style="font-size:15px; float:right" class="text-primary pull-right"></span></div> 
        </div>
           <div class="card-body bg-white">

			<div class="row">
  <div class="col-md-6">
  
  <div class="row">
  <div col="col-md-12">
    <div class="card mt-3">
    <div class="card-header bg-secondary">
        <div class="text-white text-left"><strong>List of Services </strong></div>       </div>
           <div class="card-body" style="padding:0px;">
             
                <table class="table m-0 table-stripped">
                <thead class="bg-light border">
                
                <tr><th scope="col">#</th><th scope="col" style="width:55%">Services Requested</th><th width="35%" scope="col">BPE Specialist</th><th scope="col">Action</th></tr> </thead>
                <tbody class="bg-white border">
                <?php
				 foreach($invoiceServices['services'] as $K=>$V) {
					
				?>
                <tr class="border">
                <th scope="row"><?php echo $K+1;?></th>
                <td class="border"><strong><?php echo $V['item_name'];  ?> </strong><br/>
                <i style="font-size:15px"><?php echo $V['item_desc']; ?></i> <br/>
                <span class="text-info" style="font-size:15px"><?php echo $V['category']; ?></span>
                <?php  echo getStatusStyle($V['status']); ?>
                </td>
                <td class="border">
                <?php
				
				if(trim($V['specialist']['name'])!='') {
				echo $V['specialist']['name'].'&nbsp;&nbsp;<i class="fas fa-envelope"></i>';
				} else {
				echo "<h6 class='text-info'>BPE Specialist will be assigned to you shortly! If you want to contact support, pls call <strong><mark>".SUPPORT_PHONE_NUMBER."</mark></strong>
				or email support : <i class=\"fas fa-envelope\"></i></h6>";	
				}
				
				?>
                
                </td>
                <td style="font-size:15px; width:10%" class="text-primary border"> [<strong><a href="javascript:void(0)" onclick="showQuestionnaire(<?php echo $V['item_id'];?>)">Questionnaire</a></strong>]<br/>
				[<strong><a href="javascript:void(0)" onclick="list_client_documents(<?php echo $V['item_id'];?>)">Documents</a></strong>]<br/>
				[<strong><a href="javascript:void(0)" onclick="viewItemTickets(<?php echo $V['item_id'];?>)">Tickets</a></strong>]</td>
                </tr>
                <?php
				 }
				?>

                </tbody>
                </table>
           <div class="card-group">
      
      <div class="card mt-3">
    <div class="card-header bg-secondary">
        <div class="text-white text-left"><strong>Payment Details</strong> <span style="font-size:15px; float:right" class="text-white pull-right">View Invoices</span></div> 
        </div>
           <div class="card-body">
           <!-- show amount dtls -->
           
           <div class="row"> <div class="col-md-1"></div>
           <div class="col-md-10">
            <div class="row">
            
              <div class="col-sm-8 border  bg-light p-1 pr-2"><span class="float-right"><h5>Order Total: </h5></span></div>
              <div class="col-sm-4 p-1 border"><span class="float-right"><h5><?php echo $invoiceServices['amount_details']['total_amount']; ?></h5></span> </div>
             </div>
             <?php
			 if($invoiceServices['amount_details']['is_discount']=='Y') {
			 ?>
             <div class="row">
              <div class="col-sm-8 border bg-light p-1 pr-2"><span class="float-right"><h5>Discount: </h5></span></div>
              <div class="col-sm-4 p-1 border"><span class="float-right"><h5>-<?php echo $invoiceServices['amount_details']['discount']['amount']; ?></h5></span> </div>
             </div>
              <div class="row">
              <div class="col-sm-8 border bg-light p-1 pr-2"><span class="float-right text-primary"><h5>Final Amount: </h5></span></div>
              <div class="col-sm-4 p-1 border"><span class="float-right  text-primary"><h5>$><?php echo $invoiceServices['amount_details']['final_amount'];?></h5></span> </div>
             </div>
             <?php
			 }
			 ?>
              <div class="row mt-1">
              <div class="col-sm-8 border bg-light p-1 pr-2"><span class="float-right text-dark"><h5>Total Paid: </h5></span></div>
              <div class="col-sm-4 p-1 border"><span class="float-right text-dark"><h5><?php echo money($invoiceServices['amount_details']['total_paid'],'$');?></h5> </span> <i class="fas fa-check-circle text-success"></i></div>
             </div>
               <div class="row  mt-1">
            
              <div class="col-sm-8 border bg-light p-1 pr-2"><span class="float-right text-primary"><h5><strong>Total Due: </strong></h5></span></div>
              <div class="col-sm-4 bg-info p-1 border"><span class="float-right text-white"><h5><strong><?php echo money($invoiceServices['amount_details']['total_due'],'$');?></strong></h5></span> </div>
             </div>
			</div>
            <div class="col-md-1"></div>                        
         </div>
         
      </div>
   </div> 

   
   <?php  if($invoiceServices['amount_details']['is_installment']=='Y') { ?>

   <div class="card mt-3">
    <div class="card-header bg-secondary">
        <div class="text-white text-left"><strong>Installment Schedule</strong></div> 
        </div>
           <div class="card-body">
           <?php
		   
		   $installmentArr = $invoiceServices['amount_details']['installment'];
		   $installmentSchedule = $installmentArr['schedule'];
			foreach($installmentSchedule as $K=>$V) {		   
			 if($V['payment_past']=='Y') { $icon ='<a href="#" data-toggle="tooltip" data-placement="right" title="Installment NOT paid!"><i class="fas fa-exclamation-triangle text-danger"></i></a> &nbsp;&nbsp;';
			 $btn = '<button type="button" class="btn btn-primary btn-xs">Pay Now</button>';
			 $alertText = '<div class="bg-danger text-white" style="font-size:14px">Installment NOT paid! Due date past. Please pay immediately for uninterrupted services.</div>';
			 
			 }
			 if($V['is_paid']=='Y') { $icon ='<i class="fas fa-check-circle text-success"></i> &nbsp;&nbsp;'; $btn='';}

		   ?>
           <div class="row  mt-1">
            
              <div class="col-sm-8 bg-light p-1 pl-3 border"><span class="float-left text-dark"><h5><strong><?php echo $icon; echo date('M d, Y',strtotime($V['installment_date'])); ?> </strong></h5><?php echo $alertText;?></span></div>
              <div class="col-sm-4 bg-light p-1 pr-1 border align-middle"><span class="float-right text-dark align-middle"><h5><strong><?php echo $V['installment_amount'];echo $btn;?></strong></h5></span> </div>
             </div>
           
		<?php } ?>	
         
      </div>
   </div>   

   		   <?php }  ?>
             
   </div>
         </div>
      </div>
      </div>
      </div>
      
      
      
   </div>
   
    <div class="col-md-6" id="content_order">
    
    
    
    </div>
	</div>
  </div>
</div>
   	

<script>
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});


function showQuestionnaire(service_id) {
	      paramData = {'act':'showQuestionnaire', 'service_id': service_id};
          ajax({ 
            a:'process',
            b:$.param(paramData),
            c:function(){},
            d:function(data){  
			alert(data);
			   $('#content_order').html(data);
            }});	    
	 
}
  
 function viewItemTickets(service_id) {
	  paramData = {'service_id': service_id};
          ajax({ 
            a:'ticket_line_item_list',
            b:$.param(paramData),
            c:function(){},
            d:function(data){  
			  $('#content_order').html(data);
            }});	    	  
 }


 function openTicket(service_id) {
	  paramData = {'service_id': service_id};
          ajax({ 
            a:'ticket_list',
            b:$.param(paramData),
            c:function(){},
            d:function(data){  
			  $('#content_order').html(data);
            }});	    	  
 }



 function list_client_documents(service_id) {
	  paramData = {'act':'showDocumentsList', 'invoice_line_item_id': service_id};
          ajax({ 
            a:'documents',
            b:$.param(paramData),
            c:function(){},
            d:function(data){  
			  $('#content_order').html(data);
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
            }});	    	  
 }
   
 
</script>
