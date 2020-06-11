<?php
 require("includes.php"); 
 $quotationId = $_POST['id'];
 $param = array('tableName'=>TBL_QUOTATION,'fields'=>array('*'),'condition'=>array('id'=>$quotationId.'-INT'));
 $rsQuotation = Table::getData($param);
	 
	foreach($rsQuotation as $K=>$V)  $$K=$V;
					
	$param = array('tableName'=>TBL_LEADS,'fields'=>array('*'),'condition'=>array('id'=>$lead_id.'-INT'));
	$rsLeads = Table::getData($param);	
	
	$packageObj = new Packages; 
	
?>
<div class="view_quotation_lead" style="background-color:#fff;padding:20px;">
<div class="form-group row">
   <label class="col-md-6 col-form-label">Quotation for : <?php echo $rsLeads->lead_fname.' '.$rsLeads->lead_lname; ?> </label>
   <label class="col-md-6 col-form-label" style="text-align:right"> <a href="javascript:void(0)" onclick="show_quotations_lists(<?php echo $rsLeads->id; ?>)">[back to quotations]</a> |  <a href="javascript:void(0)" onclick="edit_quotation(<?php echo $id; ?>,<?php echo $rsLeads->id; ?>)">[edit]</a> </label>
</div> 

                  <div class="form-group row">
					   <label class="col-md-12 col-form-label" style="background-color: #0598f5;color: #fff;">#Quotation ID: <?php echo customizeSerial($rsQuotation->id);?> </label>
						 
					</div>
					
<div class="form-group row">
					   <label class="col-md-12 col-form-label"><strong>Subject:</strong> <?php echo  $subject; ?></label>
					
					</div>
					
					
					<div class="form-group row">
					 
					   <label class="col-md-6 col-form-label text-right"></label>
						<div class="col-md-12">
						<?php echo  strtr($introduction, array("\r\n" => '<br />', "\r" => '<br />', "\n" => '<br />')); ?>
						</div>
					</div>
				
					 <div class="form-group row">
						<label class="col-md-12 col-form-label">Service Requested : </label>  
                    </div>
				
		 <div class="form-group row" style="margin-bottom:0px;"> 
			<div class="col-md-12" style="background-color:#ffffff;">
						  <?php  
			$param = array('tableName'=>TBL_QUOTATION_LINE_ITEM,'fields'=>array('*'),'condition'=>array('quotation_id'=>$id.'-INT'));
			$rsQuotationLineItem = Table::getData($param); 	
			  if(count($rsQuotationLineItem)>0) {
		         foreach($rsQuotationLineItem as $key=>$val) {    
		    
			$category_id = $val->category_id;
			$service_id = $val->service_id;
			  if($category_id>0) {
						 ?>
			<!--<div class="row">
			<label class="col-md-9 col-form-label">  <?php echo $val->line_item;?>  	</label>			 	
                </div>-->
			 
			<ul class="list_ul lead_service_type_<?php echo $val->id; ?>"> 
			<?php        
				
			?> 
			<li><strong> <?php echo $val->line_item;?> 			 
			<span class="service_amount"><?php echo   money($val->line_amount,'$');?></span></strong><br/>
			<small>Description: <?php echo $val->line_desc;?></small>
			</li>

			 </ul>			 
				
			  <?php } } } ?> 
					
            </div>
		</div>
					
					 
					 
					 
					 
				
		 <div class="form-group row" style="margin-bottom:0px;"> 
			<div class="col-md-12" style="background-color:#ffffff;">
						  <?php  
		
					if(count($rsQuotationLineItem)>0) {
		   foreach($rsQuotationLineItem as $key=>$val) {    
		    		 
			$package_id = $val->package_id;
			  if($package_id>0) {
						 ?>
			 
			
			<?php        
				$param = array('tableName'=>TBL_PACKAGES,'fields'=>array('*'),'showSql'=>'N','condition'=>array('id'=>$package_id.'-INT'));
			    $rsPackages = Table::getData($param);
			?> 
             <ul class="list_ul"> <strong>
			<?php echo $rsPackages->package_name;?> 
			<span class="service_amount"><?php echo   money($val->package_price,'$');?></span> </strong><br/>
	         <li>
			  <ul>
			<?php $packageObj->package_id= $val->package_services;
              $rsPackageServices = $packageObj->getPackageServicesByIds();
			  if(count($rsPackageServices)>0) {
			  foreach($rsPackageServices as $key=>$val) {								 
			echo '<li>'.$val->service_name.'</li>';
			  } } ?>
			  </ul>
			</li></ul>

			
				
			  <?php } } } ?> 
					
                       </div>
					 </div>
					
                    
<div class="form-group row" style="margin-bottom:0px;"> 
			<div class="col-md-12" style="background-color:#ffffff;">
						  <?php  
		
					if(count($rsQuotationLineItem)>0) {
		   foreach($rsQuotationLineItem as $key=>$val) {    
		    		 

			  if( $val->service_id==0 && $val->line_amount>0) {
						 ?>
			 
			
			<ul class="list_ul lead_service_type_<?php echo $val->id; ?>"> 
			<?php        
				
			?> 
			<li><strong> <?php echo $val->line_item;?> 			 
			<span class="service_amount"><?php echo   money($val->line_amount,'$');?></span></strong><br/>
			<small>Description: <?php echo $val->line_desc;?></small>
			</li>

			 </ul>	

			
				
			  <?php } } } ?> 
					
                       </div>
					 </div>                     
				 
	
	  <div class="form-group row" style="background-color:#ffffff;padding: 15px; margin-bottom: 0px;">
	    <div class="col-md-12">
     <div class="bottom-pricetag"> <span><strong>TOTAL</strong></span>
	 
      <span class="float-right"><strong><?php echo money($quotation_amount,'$');  ?></strong></span> </div>
		</div>
		<?php if($is_discount=='Y') { ?> 
		<div class="col-md-12">
     <div style="padding: 10px;"> 
	  <?php 
	   if($discount_type=='P') { $discount_type = $discount_value.'%'; }
	   if($discount_type=='F') { $discount_type = money($discount_value,'$'); }
	   ?>
	  
	   <strong>DISCOUNT</strong> &nbsp;&nbsp;&nbsp; <span class="coupecodeError" style="color:#000000">  <?php echo $discount_code; ?> - <?php echo $discount_type; ?> </span>  
		
      <span class="float-right">  <span class="discount_amount_span"><strong>(-) <?php echo money($discount_amount,'$'); ?></strong></span>  </span>  </div>
		</div> <?php } ?>
		</div>
         <div class="form-group row" style="background-color:#09C; color:#FFF; font-size:16px;">
		<div class="col-md-12" >
     <div class="bottom-pricetag"> <span>Final Total</span>
	  
      <span class="float-right" ><strong><?php echo money($final_amount,'$');  ?></strong></span> </div>
		</div> 		  
	  </div>
	  
	  
	  <?php if($installment=='Y') { ?>  
	  <div class="form-group row">
           <label class="col-md-7 col-form-label"  style="padding-left:0;padding-top:15px;padding-bottom:0;">Installment : </label>  
      </div>
	   <div class="form-group row" style="background-color: #ffffff;padding: 15px; margin-bottom: 0px;padding-bottom: 0px;">
	  <div class="col-md-12"><p>  </p>
	   </div>
	  
<div class="form-group row" id="installment_div"> 
    
	  <div class="col-md-4">Installment Period <br/>
			 <?php echo $installment_period; ?> Months
		</div>
		
		<div class="col-md-4"> Start date <br/>
			<?php echo date('m/d/Y',strtotime($installment_start_date)); ?>
		</div>
		
		<div class="col-md-4"> End date <br/>
			<?php echo date('m/d/Y',strtotime($installment_end_date)); ?>
		</div>
		<div class="col-md-12"><hr/></div>
		<div class="col-md-4">Down Payment <br/>
			 <?php echo money($installment_downpayment,'$'); ?> 
		</div>
		 
		<div class="col-md-4"> Installment Amount  <br/>
			   	  <?php echo money($installment_amount,'$'); ?>
		</div>
		 
	</div>
	  
	 </div>
	  <?php } ?>
	    
	  
      <div class="form-group row">
					 
					   <label class="col-md-6 col-form-label text-right"></label>
						<div class="col-md-12">
						<?php echo  strtr($conclusion, array("\r\n" => '<br />', "\r" => '<br />', "\n" => '<br />')); ?>
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
<style> 
.form-control:disabled, .form-control[readonly] {
    background-color: #ffffff;
    opacity: 1;
}

.add_more_div { text-align:right; }
.card-box { border:0px; background-color: #f5f5f5; }
	.list_ul li { border: 1px solid #00000026; margin-bottom: 0px; padding: 5px; }
	.list_ul { list-style-type:none; }
	.service_amount { float:right; }
	
	.bottom-pricetag { background-color: #a3cdda82;  padding: 10px; }
	.preview_button_div {  background-color: #f18628b0; padding: 20px 7px 20px 17px; text-align:right;}
</style>