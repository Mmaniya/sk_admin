<?php 
$serviceId = $_POST['id'];
$btnName = $title = 'Add New ';
if($serviceId>0) { 
	$param = array('tableName'=>TBL_SERVICES,'fields'=>array('*'),'condition'=>array('id'=>$serviceId.'-INT'));
	$rsService = Table::getData($param);
	foreach($rsService as $K=>$V)  $$K=$V;
}
?>

 <div class="card-box">
                                     
                                     

                                   
                                        <div class="form-group row">
                                            <label class="col-md-4"><?php echo $service_name; ?></label>
                                            <label class="col-md-4 col-form-label"><?php echo money($service_price,'$'); ?></label>
                                          <div class="col-md-12"> <hr/></div>
                                        </div>
										
										 <div class="form-group row">
                                           <div class="col-md-8"> <?php echo $service_description; ?></div>
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
										
										<div class="form-group row">
                                           <div class="col-md-8"><strong> Service Payment Type : </strong> <?php echo $service_payment_type; ?></div>
										    <div class="col-md-12"> <hr/></div>
                                        </div>
										<?php 
										
										if($service_recurring_duration=='W') { $service_recurring_duration='Weekly'; }
										if($service_recurring_duration=='BW') { $service_recurring_duration='Bi-Weekly'; }
										if($service_recurring_duration=='M') { $service_recurring_duration='Monthly'; }
										if($service_recurring_duration=='Y') { $service_recurring_duration='Yearly'; }
										
										
										if($service_payment_type=='Recurring') { ?>
										<div class="form-group row">
                                           <div class="col-md-8"><strong> Service Recurring Duration: </strong> <?php echo $service_recurring_duration; ?></div>
										    <div class="col-md-12"> <hr/></div>
                                        </div> <?php } ?>
										
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
										    <div class="col-md-7" style="border:1px solid #0000002e;padding:5px;"> <strong><?php echo $unserialize['service_name_append'][$i]; ?></strong> <br/>
											<?php echo $unserialize['service_description_append'][$i]; ?><br/><br/>
                                           <a href="<?php echo trim($unserialize['service_link_append'][$i]); ?>" target="_blank"><?php echo $unserialize['service_link_append'][$i]; ?> </a></div>
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
											  
		$param = array('tableName'=>TBL_DOCUMENTS,'fields'=>array('*'),'orderby'=>'id','sortby'=>'desc','condition'=>array('parent_id'=>'0-INT','status'=>'A-CHAR'));
		$rsDocuments = Table::getData($param);	
		 $document_id = explode(',',$document_id); 
										$i=1;
                                        if(count($rsDocuments)>0) {
										foreach($rsDocuments as $key=>$val) {  $checked=''; 
										 if (in_array($val->id, $document_id))  {  $checked ='checked';   } ?>
					 <li> <?php echo $val->doc_name; ?> </li>
				<?php 	$i++;
               
					?>  				
                                         <?php }} ?> 
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
