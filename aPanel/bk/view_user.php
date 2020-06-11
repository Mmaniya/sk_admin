<?php
 $userId = $_POST['id'];
$btnName = $title = 'Add New';
$joined_date ='';
if($userId>0) { 
	$param = array('tableName'=>TBL_USERS,'fields'=>array('*'),'condition'=>array('id'=>$userId.'-INT'));
	$rsUsers = Table::getData($param);
	foreach($rsUsers as $K=>$V)  $$K=$V;
	$btnName = $title = 'Edit ';
	$joined_date = date('m/d/Y',strtotime($joined_date));
}
  $employeeTypeArr = array("BPS"=>"Business Plan Specialist","CS"=>"Certification Specialist","LS"=>"License Specialist","WS"=>"Website Specialist",
                          "DMS"=>"Digital Marketing Specialist",
						  "All"=>"All",
						  "A"=>"Administration",
						  "ACC"=>"Accounting",'PM'=>'Project Manager');
 $userTypeArr = array("SA"=>"Super Admin","A"=>"Admin","E"=>"Employee");		
?>

	<div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			 
			<div class="modal-body">
				<div class="row">
					<div class="col-md-6">
						 <?php echo $contact_fname.' '.$contact_lname.' ('.$userTypeArr[$user_type].')'; ?> 
					</div>
					<div class="col-md-6">
						<div class="right-div" style="text-align:right">
						 <a href="javascript:void(0)"  onclick="showAddEditForm(<?php echo $id; ?>)">[edit]</a>
						 <a href="javascript:void(0)" onclick="changePassword(<?php echo $id; ?>)">[change pwd] </a>
						 </div>
					</div>
<div class="col-md-12"> <hr> </div>
				</div>
				
				<div class="row">
					<div class="col-md-4">
						<strong> U: <?php echo $username; ?> | P: <?php echo $password; ?> </strong> <br/> 
						Skype Id : <?php echo  $skype_id; ?> <br/><?php echo '<a href="'.$phone.'">'.$phone.'</a> <br/>'; ?>
						<?php echo '<a href="'.$business_email.'@bizplaneasy.com">'.$business_email.'@bizplaneasy.com</a> <br/>'; ?>
					</div>
					
					<div class="col-md-3">				 
							 <strong>Services</strong>	<br/>	
				<?php   $employee_typeArr = explode(',',$employee_type); 
	foreach($employee_typeArr as $key) {
		$param = array('tableName'=>TBL_EMPLOYEE_CATEGORY,'fields'=>array('*'),'condition'=>array('id'=>$key.'-INT'));
	$rsEmp = Table::getData($param);
		echo $rsEmp->category_name.'<br/>';
	}
 ?>					 
					</div>
					
					
					<div class="col-md-5">
						<strong>Contact Detils </strong> <br/>
						<a href="tel:<?php echo $contact_phone;?>"><?php echo $contact_phone;?> </a><br/>
						<a href="mailto:<?php echo $contact_email;?>"><?php echo $contact_email; ?></a> <br/> 
						<?php echo $contact_city.','.$contact_state.','.$contact_country; ?> <br/> 
					</div>
				</div>
				
				
				<div class="row">
				<div class="col-md-12 full-width-tabs"> <br/> <ul class="nav nav-tabs">
                                        <li class="nav-item">
                                            <a href="#home" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                                Projects Assigned
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#profile" data-toggle="tab" aria-expanded="true" class="nav-link ">
                                                In Progress
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#messages" data-toggle="tab" aria-expanded="false" class="nav-link">
                                                Completed
                                            </a>
                                        </li>
                                        
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane fade" id="home">
                                            <p> </p>
                                        </div>
                                        <div class="tab-pane fade show active" id="profile">
                                            <p> </p>
                                        </div>
                                        <div class="tab-pane fade" id="messages">
                                            <p> </p>
                                        </div>
                                        
                                    </div></div>
					  
				</div>
				 
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary waves-effect" data-dismiss="modal">Close</button>
				 
			</div>
		</div>
	</div>
	</div><!-- /.modal -->
	
	<style>
	 .full-width-tabs > ul.nav.nav-tabs {
    display: table;
    width: 100%;
    table-layout: fixed;
}
.full-width-tabs > ul.nav.nav-tabs > li {
    float: none;
    display: table-cell;
}
.full-width-tabs > ul.nav.nav-tabs > li > a {
    text-align: center;
}
.take-all-space-you-can{
    width:100%;
}  .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
    color: #fff;
    background-color: #2772d0;
    border-color: #dee2e6 #dee2e6 #fff;
}

.nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link {
    color: #fff;
    background-color: #a0939a;
    border-color: #dee2e6 #dee2e6 #fff;
}

</style>