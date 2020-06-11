<?php
 $leadId = $_POST['id'];
   $randonId = $_POST['randon_id'];
$btnName = $title = 'Add New';
$joined_date ='';
if($leadId>0) { 
	$param = array('tableName'=>TBL_LEADS,'fields'=>array('*'),'condition'=>array('id'=>$leadId.'-INT'));
	$rsUsers = Table::getData($param);
	foreach($rsUsers as $K=>$V)  $$K=$V;
	$btnName = $title = 'Edit ';
  	
	$param = array('tableName'=>TBL_LEAD_SPECIALIST,'fields'=>array('*'),'condition'=>array('lead_id'=>$leadId.'-INT','service_category_id'=>$leadId.'-INT','user_id'=>$leadId.'-INT'));
	$rsLeadSpec = Table::getData($param);
}

	$categoryObj = new ServiceCategory(); 

	$categoryObj->category_id= $lead_enquiry_for;
	
	$enquiryFor = $categoryObj->getCategoryByIds();

	$leadsObj = new Leads; 

?>

	<div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			 
			<div class="modal-body">
				<div class="row">
					<div class="col-md-6">
						Assign Lead <?php echo $lead_fname.' '.$lead_lname.')'; echo $randonId; ?> 
					</div> 		
<div class="col-md-12"><hr/></div>					
				</div>  
				<div class="row">
           <?php   	   
		   
		   foreach($enquiryFor as $key=>$val) {
                  //TBL_LEAD_SPECIALIST               
					
			   ?>
		  
				<div class="col-md-4">
				<?php   echo '&nbsp;'.$val->category_name;?>
				</div>
				<div class="col-md-4">
				<?php  $leadsObj->emp_type_id = $val->id; 
					  $empType = $leadsObj->getUsersBYEmployeeTypeId(); 		  
					  if(count($empType)>0) { 
					 
					  ?>
				<select name="user_id" id="user_id_<?php echo $val->id; ?>" class="form-control">
				<option value="">select</option>
				<?php           
			 foreach($empType as $K=>$V) { $selected='';
$param = array('tableName'=>TBL_LEAD_SPECIALIST,'fields'=>array('*'),'showSql'=>'N','condition'=>array('lead_id'=>$id.'-INT','service_category_id'=>$val->id.'-INT','user_id'=>$V->id.'-INT'));
$rsLeadSpec = Table::getData($param); 
 if(count($rsLeadSpec)>0) {
foreach($rsLeadSpec as $K2=>$V2) 
 if($V2->user_id==$V->id) {  $selected='selected';   }   } 
				 
				 echo '<option value="'.$V->id.'" '.$selected.'>'.$V->contact_fname.' '.$V->contact_lname.'</option>';
		  } 
				?>
		  </select> <?php } else {  ?> 
		  <select name="user_id" id="user_id_<?php echo $val->id; ?>" class="form-control" style="display:none;">
				<option value="">select</option>
			<?php 	$param = array('tableName'=>TBL_USERS,'fields'=>array('*'),'showSql'=>'N','condition'=>array('status'=>'A-CHAR'));
			  $rsUsers = Table::getData($param);
			if(count($rsUsers)>0) {
               foreach($rsUsers as $K3=>$V3) {  	   
 
 
                       echo '<option value="'.$V3->id.'">'.$V3->contact_fname.' '.$V3->contact_lname.'</option>';
			}}
			   ?>
				</select>
		        <?php echo '<p id="error_text_'.$val->id.'">No specialist available.<br/><a href="javascript:void(0)" onclick="showSpecialistUser('.$val->id.')">Click here to add one</a> </p>'; ?> <?php  } ?>
				
				</div>
				 <input type="hidden" id="service_category_id_<?php echo $val->id; ?>" value="<?php echo $val->id; ?>">
				<div class="col-md-4">  
           <?php   if(count($empType)>0) {  ?>
  				<button class="btn btn-primary btn-sm" onclick="setAssignSpecialist(<?php echo $val->id; ?>,'already')">assign</button> 
		   <?php } else {  ?>
		   <button class="btn btn-primary btn-sm" id="assign_button_<?php echo $val->id; ?>" style="display:none;"  onclick="setAssignSpecialist(<?php echo $val->id; ?>,'add_new')">assign</button> <?php } ?>
				</div>
				
				<div class="col-md-12"><hr/></div>
			 <?php }  ?>
			 
			 <input type="hidden" id="lead_id_1" value="<?php echo $id; ?>">
			 
			 <?php /* 
 No specialist available. Click here to add one
 lead_id, service_category_id, user_id
 lead_specialist

			 $lead_enquiry_forArr = explode(',',$lead_enquiry_for); 
	foreach($lead_enquiry_forArr as $key) {
		$param = array('tableName'=>TBL_EMPLOYEE_CATEGORY,'fields'=>array('*'),'condition'=>array('id'=>$key.'-INT'));
	$rsEmp = Table::getData($param);
		echo $rsEmp->category_name.'<br/>';
	} */
	 
 /* ?>	
   <select name="users_id_<?php echo $val->id;?>"> 
		   <?php 
		   $param = array('tableName'=>TBL_USERS,'fields'=>array('*'),'condition'=>array('status'=>'A-CHAR'));
	       $rsUsers1 = Table::getData($param);
             if(count($rsUsers1)>0) {
              foreach($rsUsers as $K1=>$V1) {  ?>
		   <option value="<?php echo $V->id;?>"><?php echo $V1->contact_fname.' '.$V1->contact_lname; ?></option>
			 <?php } } else { echo '<option>No users</option>'; } ?>
		   </select> <?php */ 
		   
		   
		  // leads_services ?>
		   
				 </div>	 
				 
				 
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary waves-effect" data-dismiss="modal">Close</button>
				 
			</div>
		</div>
	</div>
	</div><!-- /.modal -->
<script>

  function showSpecialistUser(id)  {
	 var user_id =  $('#user_id_'+id).show();
	 var assign_button_ =  $('#assign_button_'+id).show();
	  $('#error_text_'+id).html('');
	  
  }


	 function setAssignSpecialist(lead_id,userType) {   
		var service_category_id = $('#service_category_id_'+lead_id).val();
		var user_id = $('#user_id_'+lead_id).val();
		var lead_id_uniq = $('#lead_id_1').val();
		 
		var specialistName = $("#user_id_"+lead_id+" option:selected").html();
 
		  
	paramData = {'act':'add_edit_specialist','lead_id':lead_id_uniq,'service_category_id':service_category_id,'user_id':user_id,'userType':userType};
	ajax({ 
		a:'leads',
		b:$.param(paramData),
		c:function(){},
		d:function(data){   
			var res = data.split("::"); 
			alert(res[1]);  
			 $('.assignresponse_change_'+<?php echo $randonId;?>).hide();
			$('.assignresponse_show_'+<?php echo $randonId;?>).show();
			$('.assignresponse_'+<?php echo $randonId;?>).html(specialistName);  
		}});	
}  




</script>
	 