<?php 
$categoryObj = new ServiceCategory(); 

$prev=$next=$last=$first='&nbsp;';

if($page > 1)
	$first = "<img src='assets/images/first_page.png' style='cursor:pointer; margin-top:3px;' border='0'  onclick='ShowListPagination(\"1\",\"".$filter_by."\")'/>";
	
	if($page < $totalPages)
	$last = "<img src='assets/images/last_page.png' style='cursor:pointer; margin-top:3px;' border='0' onclick='ShowListPagination(\"$totalPages\",\"".$filter_by."\")'/>";
	if(count($rsUsers)>0 && $totalPages > 1){
	if($page > 1){
		$pageNo = $page - 1;
		$prev = "<img src='assets/images/prev_page.png' style='cursor:pointer; margin-top:3px;' border='0' onclick='ShowListPagination(\"".$pageNo."\",\"".$filter_by."\")'/>";
	} 
		
	if ($page < $totalPages){
		$pageNo = $page + 1;
		$next = " <img src='assets/images/next_page.png' style='cursor:pointer; margin-top:3px;' border='0' onclick='ShowListPagination(\"".$pageNo."\",\"".$filter_by."\")'/>";
	} 
	
	if($pageNo=='')
		$pageNo=1;
	if($totalPages>1) {
	$pagebox="<td style='border:0;'>&nbsp;<input type='text' name='page' id='page' value='".$page."' onchange='ShowListPagination(this.value,\"".$filter_by."\")' style='border: 1px solid rgb(170, 170, 170); text-align: center; width: 25px; height: 15px; vertical-align: middle;' size='4'> of $totalPages &nbsp;</td>";
	}	

	$table_val = "<table class='' width='100%;padding:10px' cellpadding='5' cellspacing='0' border='0' style='border:0;><tr style='background-color:#fff'><td align='center' style='border:1; font-size:14px; vertical-align:middle; color:#000; padding:10px;'></td><td align='right'><table align='right' cellpadding='0' cellspacing='1'><tr style='background-color:#fff'><td style='padding:10px 12px;'>$first</td><td style='padding:10px 6px;'> $prev </td>$pagebox<td style='padding:10px 2px;'>$next </td><td style='padding:10px 12px;'>$last</td></tr></table></td></tr></table>";
}  ?>

<div class="col-md-12"><hr></div>
<div class="row" style="font-weight:600">
<div class="col-md-1 d-none d-sm-block">#</div>
<div class="col-md-4 d-none d-sm-block">Name / Contact Details</div>
<div class="col-md-3 d-none d-sm-block">Employee Type</div>
<div class="col-md-2 d-none d-sm-block">Action</div>
</div>
<div class="col-md-12 d-none d-sm-block"><hr></div>

 <?php   $employeeTypeArr = array("BPS"=>"Business Plan Specialist","CS"=>"Certification Specialist","LS"=>"License Specialist","WS"=>"Website Specialist",
                          "DMS"=>"Digital Marketing Specialist",
						  "All"=>"All",
						  "A"=>"Administration",
						  "ACC"=>"Accounting",'PM'=>'Project Manager');
						  
	  if(count($listingArr)>0) {
	   foreach($listingArr as $key=>$val) {
  
   
   $enquiryType='';
   if($val->lead_enquiry_type=='E') { $enquiryType ='Email'; }
   if($val->lead_enquiry_type=='C') { $enquiryType ='Call'; }
   if($val->lead_enquiry_type=='Other') { $enquiryType ='Other - '.$val->other_enquiry_type;  }
   
   
		$userTypeArr = array("SA"=>"Superadmin","A"=>"Admin","E"=>"Employee");				 
   
		   ?>
<div class="row tb_row">
<div class="col-md-1 d-none d-sm-block"><?php echo $key+1;?></div>
<div class="col-md-4"><strong><?php echo $val->contact_fname.' '.$val->contact_lname.' ('.$val->user_type.')'; ?></strong>   <br/>
	<strong> U: <?php echo $val->username; ?> | P: <?php echo $val->password; ?> </strong> <br/> 
	<a href="tel:<?php echo $val->contact_phone;?>"><?php echo $val->contact_phone;?> </a><br/>
<a href="mailto:<?php echo $val->contact_email;?>"><?php echo $val->contact_email; ?></a> <br/> 
<?php echo $val->contact_city.','.$val->contact_state.','.$val->contact_country; ?> <br/> 
  </div>
  
<div class="col-md-3"> 
 <?php   $employee_typeArr = explode(',',$val->employee_type); 
	foreach($employee_typeArr as $key) {
		$param = array('tableName'=>TBL_EMPLOYEE_CATEGORY,'fields'=>array('*'),'condition'=>array('id'=>$key.'-INT'));
	$rsEmp = Table::getData($param);
		echo $rsEmp->category_name.'<br/>';
	}
 ?>

 <br/> 
</div>
 <div class="col-md-3"> 
                <a href="javascript:void(0)" onclick="viewUsers(<?php echo $val->id; ?>)">[view]</a>
	            <a href="javascript:void(0)" onclick="showAddEditForm(<?php echo $val->id; ?>)">[edit]</a>  
				<a href="javascript:void(0)" onclick="deleteUsers(<?php echo $val->id; ?>)">[delete]</a><br/>
				<a href="javascript:void(0)" onclick="changePassword(<?php echo $val->id; ?>)">[change pwd]</a><br/>
				<a href="javascript:void(0)" onclick="showChangeUsername(<?php echo $val->id; ?>)">[change username]</a><br/>
				<a href="javascript:void(0)" onclick="showChangeEmail(<?php echo $val->id; ?>)">[change email]</a>
				
	</div>
	 
	</div>
	 <?php } } else { ?>
	 <div class="col-md-12">No record found</div> <?php } ?>
	 <div class="col-md-12"><?php  if($table_val!='') { echo  $table_val; }  ?></div>
	  
<style> .mobile-device { display:none; } 
@media screen and (max-width: 768px) { .mobile-device { display:block; } }   

.tb_row { padding: 5px; border-bottom: 1px solid #0000002b; padding-top: 10px;}
	
 .tb_row:nth-child(odd) {background-color: rgba(0, 0, 0, 0.03);} 
 
	</style>
	 
 <script>
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip(); 
});
</script> <script>
   function ShowListPagination(page) { 
	 paramData = {'act':'show_users_list','page':page,}
	ajax({ 
		a:'users',
		b:$.param(paramData),
		c:function(){},
		d:function(data){  
		  $('.table_div').html(data);		
		}});	
	}
	</script>

