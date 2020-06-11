<?php 
$leadsId = $_POST['id'];
if($leadsId>0) { 
	$param = array('tableName'=>TBL_LEADS,'fields'=>array('*'),'condition'=>array('id'=>$leadsId.'-INT'));
	$rsLeads = Table::getData($param);
	foreach($rsLeads as $K=>$V)  $$K=$V;
	 
}

	$packageObj = new Packages; 
	$categoryObj = new ServiceCategory(); 
	$categoryObj->category_id= $lead_enquiry_for;
	$enquiryFor = $categoryObj->getCategoryByIds();
   
?>
<div class="row">
  <div class="col-md-8">
  
  <div class="row">
  <div class="col-md-6">   
     <label><?php echo $lead_fname.' '.$lead_lname;?></label> <br/>
     <a href="tel:<?php echo formatPhoneNumber($lead_phone);?>"><?php echo formatPhoneNumber($lead_phone);?></a><br/>
     <?php if($lead_email!='') { ?> <a href="mailto:<?php echo $lead_email;?>"><?php echo $lead_email;?></a><br/> <?php } ?>
     <a href="javascript:void(0)" onclick="showAddEditLeadAddressForm(<?php echo $id; ?>)">[add address]</a>
      </div> 
	  
	<div class="col-md-6"> 
	<div class="lead_status_details" style="float:right;">
	<?php if($lead_address!='') { ?> <label>Address details</label>  <br/>
		  <?php  echo $lead_address.'<br/>'.$lead_city.' <br/>'.$lead_state;  } ?>
	           
	 </div>
	  </div>   	  
    </div> 
	
	  <div class="row">
         <div class="col-md-12"><hr/></div>
		 
		 <div class="col-md-6">
		   <p>Service Requested    <a href="javascript:void(0)">[add new]</a> </p><hr/> 		   
		   <ul class="list-services"> 
    <?php if(count($enquiryFor)>0) {  	
            foreach($enquiryFor as $K=>$V) { ?>
          <li><?php echo $V->category_name; ?>
		  <ul>
		  
		  </ul>
		  
		  </li>
	      <?php } }  				
 
            $packageObj->package_id= $packages_id;
              $rsPackages = $packageObj->getPackagesByIds();
			  if(count($rsPackages)>0) {
				echo  ''; 	
			  foreach($rsPackages as $K1=>$V1) {
				  echo '<li>'.$V1->package_name.'</li>';
			  }  } 
?>	</ul>
		 </div>
		 
     </div>
	
	
  </div> 
  
    <div class="col-md-4"></div>
  
</div>

 
 <script>
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

</script>


