<?php 
$packageId = $_POST['id'];
$btnName = $title = 'Add New ';
if($packageId>0) { 
	$param = array('tableName'=>TBL_PACKAGES,'fields'=>array('*'),'condition'=>array('id'=>$packageId.'-INT'));
	$rsPackage = Table::getData($param);
	foreach($rsPackage as $K=>$V)  $$K=$V;
}
?>

 <div class="card-box">
                                     
                                     

                                   
                                        <div class="form-group row">
                                            <label class="col-md-4"><?php echo $package_name; ?></label>
                                            <label class="col-md-4 col-form-label"><?php echo money($package_price,'$'); ?></label>
                                          <div class="col-md-12"> <hr/></div>
                                        </div>
										
										 <div class="form-group row">
                                           <div class="col-md-8"> <?php echo $package_desc; ?></div>
										    <div class="col-md-12"> <hr/></div>
                                        </div>
										<?php 
										if($is_installment_allowed=='Y') { $installment = 'Yes';} 
										if($is_installment_allowed=='N') { $installment = 'N';}  
										?>
										 <div class="form-group row">
                                           <div class="col-md-8"><strong> Is installment Allowed : </strong> <?php echo $installment; ?></div>
										    <div class="col-md-12"> <hr/></div>
                                        </div>
										
										
										<?php 
										if($package_payment_plan=='OT') { $packagePaymentPlan = 'One Time';} 
										if($package_payment_plan=='RC') { $packagePaymentPlan = 'Recurring';}  									 
										?>
										
										<?php  $recuDuration='';
										if($package_recurring_duration=='W') { $recurringDuration = 'Weekly';} 
										if($package_recurring_duration=='B') { $recurringDuration = 'Bi-Weekly';}  									 
										if($package_recurring_duration=='M') { $recurringDuration = 'Monthly';}  									 
										if($package_recurring_duration=='Y') { $recurringDuration = 'Yearly';}  	

if($package_payment_plan=='RC') {  $recuDuration = ' - '.$recurringDuration;  }
										
										?>
										
										<div class="form-group row">
                                           <div class="col-md-8"><strong>Package Payment Plan:</strong> <?php echo $packagePaymentPlan .$recuDuration; ?></div>
										    <div class="col-md-12"> <hr/></div>
                                        </div>
										
										
										 
										<?php 
										
										if($delivery_time_duration=='M') { $duration = 'Months';} 
										if($delivery_time_duration=='D') { $duration = 'Days';} 
										if($delivery_time_duration=='H') { $duration = 'Hours';} 
										?>
										
										<div class="form-group row">
                                           <div class="col-md-8"><strong> Delivery Time:</strong> <?php echo $delivery_time.' '.$duration; ?></div>
										    <div class="col-md-12"> <hr/></div>
                                        </div>
										<?php if($service_payment_type=='OT') { $service_payment_type='One Time';  }  ?>
										<?php if($service_payment_type=='RC') { $service_payment_type='Recurring'; }  ?>
										
										  
										
										<?php $param = array('tableName'=>TBL_SERVICE_CATEGORY,'fields'=>array('*'),'condition'=>array('id'=>$service_category_id.'-INT'));
										$rsServiceCat = Table::getData($param);  ?>
										
										<div class="form-group row">
                                           <div class="col-md-12" style="padding-bottom: 10px;"> <strong> Service Steps  : <?php echo $rsServiceCat->category_name; ?> </strong></div>
										  
               <div class="col-md-1" style="border:1px solid #0000002e;padding:5px;font-weight:600">#</div>
               <div class="col-md-7" style="border:1px solid #0000002e;padding:5px;font-weight:600">Content</div>
               <div class="col-md-4" style="border:1px solid #0000002e;padding:5px;font-weight:600">Estimate Time to Complete </div>
              
										  </div> 	
										     <?php 
											if($service_steps!='') { 
											
                                             $unserialize =  unserialize($service_steps);  	 
													  
													   
													  $no=0;
													   for($i=0;$i<count($unserialize);$i++) {  
													  foreach($unserialize as $key=>$val) {
														  
														
														    
														 
														  // echo($val[$i]);
														  if($unserialize[$key][$i]!='') {
															  
															  $rowValue = rand();
															  
														$deliveryTime = $unserialize['delivery_time_append'][$i];	  
                                                        $checkSelect1 = trim($unserialize['delivery_time_duration_append'][$i]);
														$schedule='';
															   if($deliveryTime!='') { 
															if($checkSelect1=='D') {  $schedule = $deliveryTime.' Days';  }  
															if($checkSelect1=='M') {   $schedule =  $deliveryTime.' Months';  }  
															if($checkSelect1=='H') {   $schedule =  $deliveryTime.' Hours';  }  
															   }
															  ?> 												  
										    
										     <div class="form-group row" style="font-weight:600">
										    <div class="col-md-1" style="border:1px solid #0000002e;padding:5px;"><?php echo $i+1; ?></div>
										    <div class="col-md-7" style="border:1px solid #0000002e;padding:5px;"> <strong><?php echo $unserialize['package_name_append'][$i]; ?></strong> <br/>
											<?php echo $unserialize['package_description_append'][$i]; ?></div>
											 <div class="col-md-4" style="border:1px solid #0000002e;padding:5px;"><?php echo $schedule; ?></div>
											 
											 </div> 											 
											 <?php   break; } }  } } ?> 											 
                                      			 
									 
									 	
										  <div class="form-group row"> <div class="col-md-12"> <hr/></div>
                                            <label class="col-md-5" <?php if($service_files!='') {?> style="border-right: 2px solid #000;" <?php } ?>>Questionnaire / Documents : </label>
                                            <label class="col-md-3 col-form-label"> <?php $unserializeForm =  unserialize($service_files); 
								 	  if($service_files!='') {
									  if(count($unserializeForm)>0) {
									  foreach($unserializeForm as $key=>$val) {
										  // echo $val;
										  if($val!='') {
										  $no = $key+1;  ?>
										  
									    <a href="service_files/<?php echo $val;?>" download><?php echo $no; ?> ) Download</a> 
										<?php   }
								  } } }
								  ?> </label>
                                          <div class="col-md-12"> <hr/></div>
                                        </div>
											 
					  <div class="form-group row">  
                        <div class="col-md-12"> <ul>
											   <?php 
										 
 										 for($i=0;$i<=count(explode(',',$document_id));$i++) { 												 
											  $explodeData = explode(',',$document_id);
											  if($explodeData[$i]>0) {
		$param = array('tableName'=>TBL_DOCUMENTS,'fields'=>array('*'),'showSql'=>'N','condition'=>array('id'=>$explodeData[$i].'-INT','status'=>'A-CHAR'));
		$rsDocuments = Table::getData($param);		 
										 
                                       
										  ?>
					 <li> <?php echo $rsDocuments->doc_name; ?> </li>
				  				
                                         <?php } } ?> 
</ul>			<hr/>							 
									  </div> 			 
								 </div> 	


 <div class="form-group row">   <label class="col-md-5">Package Services : </label>
                        <div class="col-md-12"> <hr/>
						 
						<ul> 
					<?php 
$param = array('tableName'=>TBL_PACKAGE_SERVICES,'fields'=>array('*'),'condition'=>array('package_id'=>$packageId.'-INT'));
$rsPackage = Table::getData($param); 
if(count($rsPackage)>0) {
 foreach($rsPackage as $key=>$val) { 
  
	$param = array('tableName'=>TBL_SERVICES,'fields'=>array('*'),'condition'=>array('id'=>$val->service_id.'-INT'));
	$rsServiceRes = Table::getData($param);
	if($val->service_id>0) {
 ?>
	 <li><?php echo $rsServiceRes->service_name; ?></li>
	<?php } } } else { echo '<li>No services Added</li>'; } ?>
	
						
						</ul>

</div>
</div>
						
										 
										
                               <div class="form-group mb-0 justify-content-end row">
                                  <div class="col-md-9">
										<input type="hidden" name="id" value="<?php echo $id;?>"/>
											<input type="hidden" name="act" value="addEditService"/>
                                                <button type="button"  class="btn btn-danger waves-effect waves-light" onclick="closeDiv()">Close</button>
                                     </div>
                                </div>
                                    
                                </div>
								
						<script>
 function closeDiv() {
	$('.right_bar_div').html(''); 
	 
 }
</script>						

 


<style>
.right_bar_div .card-box { background-color:#fff; }

.right_bar_div .form-group {
    margin-bottom: 0px;
}
.right_bar_div hr {
    margin-top: 0.5rem;
    margin-bottom: 0.5rem;
    border: 0;
    border-top: 1px solid rgba(0,0,0,.1);
}
 textarea{border:1px solid #cfcfcf;}
.right_bar_div  .col-form-label {text-align:right; }
@media screen and (max-width: 768px) {
	
	.right_bar_div  .paddingTop { margin-top:20px; }
	.right_bar_div  .removebtn { margin-top:10px; float:right; }
}</style>
