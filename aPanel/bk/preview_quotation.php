<?php
 require("includes.php"); 
 
 
  $service_category = $_POST['service_category'];
  $services_list = $_POST['services_list'];
  
    $lead_enquiry_for = $_POST['service_category'];
	 
	/*echo '<p> <strong>Subject :</strong> <br/>'.$_POST['subject'].'</p>';
	echo '<p><strong>Introduction :</strong> <br/>'.$_POST['Introduction'].'</p>';
	 
	
	echo '<p><strong>Service Requested :</strong></p>';
   if(count($lead_enquiry_for)>0) {
		   foreach($lead_enquiry_for as $key=>$val) {    
		    
			$category_name = $_POST['service_category_name_'.$val];
			$category_id = $val;
		 echo '<p>'.$category_name.'</p>'; 
         
		  
		     
		   
		  $serviceData=array();
  if(count($_POST['services_list'])>0) {  echo '<ul>';	  
			    foreach($_POST['services_list'] as $K=>$V)  { 
				
					    $serviceId =  $_POST['services_list'][$K][$val];
                        $amount = $_POST['service_amount_'.$serviceId];                          						 
				        $service_name = $_POST['service_name_'.$serviceId];  
  if($serviceId!=null) {     echo '<li>'.$service_name.' '.$amount.'</li>';   }
   
			     } 
				  $addNewData=array();
				  if(count($_POST['add_new_service_amount'])>0) {  		
					  foreach($_POST['add_new_service_amount'] as $K1=>$V1) {
					       $serviceItemPrice =  $_POST['add_new_service_amount'][$K1][$val]; 
					         $serviceItemName  = $_POST['add_new_service_item'][$K1][$val];  	
						     if($serviceItemName!=null) {  echo '<li>'.$serviceItemName.' '.$serviceItemPrice.'</li>';    }
						  
					}     }
  
  
		 echo '</ul>';    }
                  
				  

			  
		   }   
   }
   
   echo 'Add New Line Item <br/>';
		$addLine=array();
		if(count($_POST['add_new_line_item'])>0) { echo '<ul>';	  
		  foreach($_POST['add_new_line_item'] as $K2=>$V2) {
			   $addNewlinePrice = intval($_POST['add_new_price'][$K2]); 
			      $addNewlineName = $_POST['add_new_line_item'][$K2]; 
			   if($addNewlinePrice!=null) {   echo '<li>'.$addNewlineName.' '.$addNewlinePrice.'</li>';  }
		}  
			   
		echo '</ul>'; }
			*/		
					
?>
<div class="form-group row">
					   <label class="col-md-12 col-form-label">Subject: </label>
						<div class="col-md-7">
							<?php echo  $_POST['subject']; ?>
						</div>
					</div>
					
					
					<div class="form-group row">
					   <label class="col-md-6 col-form-label">Introduction Notes: </label>
					   <label class="col-md-6 col-form-label text-right"></label>
						<div class="col-md-12">
						<?php echo  $_POST['Introduction']; ?>
						</div>
					</div>
					
					 
					
					 <div class="form-group row">
						<label class="col-md-7 col-form-label">Service Requested : </label>  
                    </div>
						
				<div class="form-group row" style="margin-bottom:0px;">		
						  
			<div class="col-md-12" style="background-color:#ffffff;padding:20px;">
						  <?php 
					if(count($lead_enquiry_for)>0) {
		   foreach($lead_enquiry_for as $key=>$val) {    
		    
			$category_name = $_POST['service_category_name_'.$val];
			$category_id = $val;
		   
		 
						 ?>
			<div class="row">
			<label class="col-md-9 col-form-label">  <?php echo $category_name;?>  	</label>			 	
                </div>
			 
			<ul class="list_ul lead_service_type_<?php echo $val->id; ?>"> 
			<?php $serviceData=array();
  if(count($_POST['services_list'])>0) {    
			    foreach($_POST['services_list'] as $K=>$V)  { 
				
					    $serviceId =  $_POST['services_list'][$K][$val];
                        $amount = $_POST['service_amount_'.$serviceId];                          						 
				        $service_name = $_POST['service_name_'.$serviceId];  
				        $service_desc = $_POST['service_desc'.$serviceId];  
  if($serviceId!=null) {       
				
			?> 
			<li> &nbsp;<?php echo $service_name?> 			 
			<span class="service_amount"><?php echo   money($amount,'$');?></span><br/>
			<small>Description: <?php echo $service_desc;?></small>
			</li>

			<?php  } } 
			
			$addNewData=array();
				  if(count($_POST['add_new_service_amount'])>0) {  		
					  foreach($_POST['add_new_service_amount'] as $K1=>$V1) {
					       $serviceItemPrice =  intval($_POST['add_new_service_amount'][$K1][$val]); 
					         $serviceItemName  = $_POST['add_new_service_item'][$K1][$val];  	
					         $serviceItemDesc  = $_POST['add_new_service_desc'][$K1][$val];  	
						     if($serviceItemName!=null) {   ?>
							 
<li> &nbsp;<?php echo $serviceItemName?> <span class="service_amount"><?php echo money($serviceItemPrice,'$');?></span>
<br/><small>Description: <?php echo $serviceItemDesc;?></small> </li>
			
                 <?php  } } } ?> </ul>			 
				
					<?php } } } ?> 
					
                       </div>		
 			 
					</div>
					
					
					<?php if(count($_POST['packages_id'])>0) { ?>
					 <div class="form-group row">
						<label class="col-md-12 col-form-label">Packages : </label>  
                    </div> 					
					<ul> 
					<?php foreach($_POST['packages_id'] as $key=>$val) { 
					$packagePrice = $_POST['package_price'][$val];
					?>
					<li> <?php echo $_POST['package_name'][$val]; ?> &nbsp; &nbsp; <?php echo money($packagePrice,'$'); ?><br/>
					    <ul>
						<?php  if(count($_POST['service_id'])>0) {
		   foreach($_POST['service_id'] as $K=>$V) {  
						//echo '<li>'.$_POST['package_service_name'][$V].'</li>'; 
						 $service_id = $_POST['service_id'][$K][$val];
						 if($service_id>0) {
						 echo '<li>'.($_POST['package_service_name'][$val][$service_id]).'</li>'; }
						} }
		   ?>
						</ul>
					
					</li>
					<?php } ?>
					</ul>
					<?php } ?>
					
					
					
					
    <div class="form-group row" style="background-color: #80808047;padding: 15px; margin-bottom: 0px;">
	  <div class="col-md-12"><strong> Add new line item </strong> </div>
	  <div class="col-md-12"> 
<ul class="list_ul"> <?php 
$addLine=array();
		if(count($_POST['add_new_line_item'])>0) { 
		  foreach($_POST['add_new_line_item'] as $K2=>$V2) {
			   $addNewlinePrice = intval($_POST['add_new_price'][$K2]); 
			      $addNewlineName = $_POST['add_new_line_item'][$K2]; 
			      $addNewlineDesc = $_POST['add_new_line_desc'][$K2]; 
			   if($addNewlinePrice!=null) { ?>
 <li> &nbsp;<?php echo $addNewlineName?> <span class="service_amount"><?php echo money($addNewlinePrice,'$');?></span> 
 <br/><small>Description: <?php echo $addNewlineDesc;?></small> </li>  <?php  }
		}   }  ?>
</ul>
	  </div>	 
	</div>
	 
	 
	
	  <div class="form-group row" style="background-color:#ffffff;padding: 15px; margin-bottom: 0px;">
	    <div class="col-md-12">
     <div class="bottom-pricetag"> <span>TOTAL</span>
	 
      <span class="float-right"><?php echo money($_POST['total_amount_before'],'$');  ?></span> </div>
		</div>
		<?php if($_POST['is_discount']=='Y') { ?> 
		<div class="col-md-12">
     <div style="padding: 10px;"> 
	  
	   DISCOUNT &nbsp;&nbsp;&nbsp; <span class="coupecodeError" style="color:#ff0000"></span>  
		
      <span class="float-right">  <span class="discount_amount_span"><?php echo money($_POST['couponcode_amount'],'$'); ?></span>  </span>  </div>
		</div> <?php } ?>
		
		<div class="col-md-12">
     <div class="bottom-pricetag"> <span>Final Total</span>
	  
      <span class="float-right"><?php echo money($_POST['final_amount'],'$');  ?></span> </div>
		</div> 		  
	  </div>
	  
	  
	  <?php if($_POST['installment']=='Y') { ?>  
	  <div class="form-group row">
           <label class="col-md-7 col-form-label"  style="padding-left:0;padding-top:15px;padding-bottom:0;">Installment : </label>  
      </div>
	   <div class="form-group row" style="background-color: #ffffff;padding: 15px; margin-bottom: 0px;padding-bottom: 0px;">
	  <div class="col-md-12"><p>  </p>
	   </div>
	  
<div class="form-group row" id="installment_div">

	  	<div class="col-md-4">Installment Period <br/>
			 <?php echo $_POST['installment_period']; ?> Months
		</div>
		
		<div class="col-md-4"> start date <br/>
			<?php echo date('m/d/Y',strtotime($_POST['installment_start_date'])); ?>
		</div>
		
		<div class="col-md-4"> End date <br/>
			<?php echo date('m/d/Y',strtotime($_POST['installment_end_date'])); ?>
		</div>
		<div class="col-md-12"><hr/></div>
	
		 <div class="col-md-4">Down Payment <br/>
			 <?php echo money($_POST['installment_downpayment'],'$'); ?> 
		</div>
		
		<div class="col-md-4"> Amount($) <br/>
			   	  <?php echo money($_POST['installment_amount'],'$'); ?>
		</div>
		 
	</div>
	  
	 </div>
	  <?php } ?>
	    
	  
	 
	  <div class="form-group row" style="margin-bottom: 0px;">
	  <div class="col-md-6" style="padding:0px;"> 
			  <div class="preview_button_div" style="text-align:left;"> 					 
					<button type="button" class="btn btn-primary" style="padding: 10px;font-weight: 600;" onclick="backtoQuotation()"> Previous Step</button>
			  </div>
	    </div>
		
	    <div class="col-md-6" style="padding:0px;"> 
			  <div class="preview_button_div" style="text-align:right;"> 					 
					<button type="button" class="btn btn-primary" style="padding: 10px;font-weight: 600;" onclick="sendQuotation()">Create Quotation</button>
			 </div>
	    </div> 		
		
		
	   </div>
	 
 <script>
					  function backtoQuotation() {
  
   $('.preview_div').html(''); 
   $('.table_div').show(); 
   $('.right_bar_div').html(''); 
   
	 
 } 

</script>
