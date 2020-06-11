<?php

function main() {
	$clientId = $_SESSION['CLIENT_ID'];
	
	$param = array('tableName'=>TBL_INVOICE,'fields'=>array('*'),'condition'=>array('client_id'=>$clientId.'-INT','is_deleted'=>'N-CHAR'),'orderby'=>'added_date','sortby'=>'DESC','showSql'=>'N');
	$rsInvoices = Table::getData($param);
	$latestInvoice = $rsInvoices[0]->id;
	
	if($_POST['act']=='showAllOrders') {
//	$param = array('tableName'=>TBL_INVOICE,'fields'=>array('*'),'condition'=>array('client_id'=>$clientId.'-INT'),'showSql'=>'N');
//	$rsInvoices = Table::getData($param);
	
	//$param = array('tableName'=>TBL_INVOICE,'fields'=>array('*'),'condition'=>array('client_id'=>$clientId.'-INT'),'orderby'=>'added_date','sortby'=>'DESC','showSql'=>'N');
	//$rsInvoices = Table::getData($param);
	//$latestInvoice = $rsInvoices[0]->id;
	
	if($_SESSION['CLIENT_SPECIALIST']>0) {
	$param = array('tableName'=>TBL_USERS,'fields'=>array('*'),'condition'=>array('id'=>$_SESSION['CLIENT_SPECIALIST'].'-INT'),'showSql'=>'N');
	$rsSpecialist = Table::getData($param);
	$specialistName=$rsSpecialist->contact_fname.' '.$rsSpecialist->contact_lname;
	$specialistEmail=$rsSpecialist->business_email;
	}	
	ob_clean();
?>

<div class="row">
  <div class="col-md-8">
    <div class="card h-100">
      <div class="card-body">
              <p class="card-text">Below is the list of orders you placed with BizPlanEasy.</p>
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
                  <div class="col-md-9  row-border">
                
                  <?php
				  foreach($servicesOrdered as $K1=>$V1) {
					  if(is_array($V1)) {
						if($K1==0)
						echo ' <div class="row p-1 pt-2" style="font-size:16px;">';  
						else
						echo ' <div class="row p-1 pt-2 border-top" style="font-size:16px;">';  
						echo "<div class='col-md-4'>".$V1['item_name'].' <br/> '.getStatusStyle($V1['status']).'</div>';
						echo "<div class='col-md-2'>".date('M d, Y',strtotime($V1['estimated_delivery_date'])).'</div>';
					 echo "<div class='col-md-3'><a href='javascript:void(0)' class='btn btn-primary' style='padding: .25rem .5rem;font-size: .875rem;' onclick='viewOrder(".$V->id.")'>View Order</a> </div>";
						echo '<div class="col-md-3">
                   <span style="font-size:25px;"> 
				   <a href="questionnaire.php?ili='.$V1['item_id'].'"><i class="fa fa-list-alt text-info" aria-hidden="true"></i></a>
				   <i class="fas fa-file-invoice-dollar text-success"></i> 
                <a href="javascript:void(0)" onclick="list_client_documents('.$V1['item_id'].')"><i class="fas fa-file-alt text-warning"></i></a><br/>
               	</span>
                  </div>';
						echo ' </div>';
					   // echo "<li class='pl-5;><i class='fas fa-check'></i>&nbsp;".$V1['item_name']."&nbsp;&nbsp;".getStatusStyle($V1['status'])." --- ".date('M d, Y',strtotime($V1['estimated_delivery_date']))."</li>";
					  }
				  }
				  ?>
                 
                                     </div>
              </div>
            
         <?php  } } ?>      
        </div>
      </div>
    </div>
  
  <div class="col-md-4" id="order_content_div">
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

<?php
exit();
	}
?>

<div class="row">
  <div class="col-md-4"><h1 class="heading">My Orders</h1> </div>
 </div>
<div class="row">
<div class="col-md-12" id="order_div_html" >
Loading..
</div>
</div>
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

function showAllOrders() {
	      paramData = {'act':'showAllOrders'};
          ajax({ 
            a:'myorders',
            b:$.param(paramData),
            c:function(){},
            d:function(data){  
			   $('#order_div_html').html(data);
            }});	    
}


function list_client_documents(invoice_line_item_id) {
	  paramData = {'act':'showDocumentsList','invoice_line_item_id':invoice_line_item_id};
          ajax({ 
            a:'documents',
            b:$.param(paramData),
            c:function(){},
            d:function(data){  
			  $('#order_content_div').html(data);
            }});	    	  
 }
 
  function showDocumentUploadForm(service_id) {
	  paramData = {'act':'showDocumentsUploadForm', 'invoice_line_item_id': service_id};
          ajax({ 
            a:'documents',
            b:$.param(paramData),
            c:function(){},
            d:function(data){  
			 $('#order_content_div').html(data);
			  $('#con-close-modal').modal('show');
            }});	    	  
 }
 
<?php
if(!isset($_REQUEST['showall'])){
if($_REQUEST['invi']>0) {
  ?>
  viewOrder(<?php echo $_REQUEST['invi'];?>);
  
  <?php 	
} else {

?>
viewOrder(<?php echo $latestInvoice;?>);
//showAllOrders();

<?php
}
}
else { ?>showAllOrders(); <?php } ?>
</script>
<?php 
}
include "template.php";


?>