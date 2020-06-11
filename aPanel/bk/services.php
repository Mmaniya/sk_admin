 <?php 
 function main() { 
 
 
 if($_POST['act']=='addEditService') {  
 ob_clean();
 $params = array('service_name','service_description','service_category_id','service_price','service_payment_type','service_recurring_duration','delivery_time','delivery_time_duration','days_allowed_for_questionnaire');
 foreach($params as $K=>$V) {  $param[$V]=$$V=check_input($_POST[$V]); } 
 
     $arr=array();
	 
	 $documentArr = $_POST['document_id'];
     $document_id = implode(",", $documentArr);
   
   $param['document_id'] = $document_id;
   
   $arr['service_name_append'] = $_POST['service_name_append'];
   $arr['service_description_append'] = $_POST['service_description_append'];
   $arr['service_link_append'] = $_POST['service_link_append'];
   $arr['delivery_time_append'] = $_POST['delivery_time_append'];
   $arr['delivery_time_duration_append'] = $_POST['delivery_time_duration_append'];
   $arr['labor_hours_append'] = $_POST['labor_hours_append'];
   
  
	$service_serialise_data = serialize($arr);	 

	$service_files_serialize = serialize($_POST['service_files']);       

	$unserialize =  unserialize($service_serialise_data);
	  
	$service_files_serialize = array();
	foreach($_FILES['service_files']['name'] as $key=>$val) { 		
	$imagefile=$_FILES['service_files']['name'][$key]; 
	if($imagefile!='') {
	$expImage=explode('.',$imagefile);
	$imageExpType=$expImage[1];
	$date = date('m/d/Yh:i:sa', time());
	$rand=rand(10000,99999);
	$encname=$date.$rand;
	$service_files_serialize[] = $imageName=md5($encname).'.'.$imageExpType;
	$imagePath="service_files/".$imageName;
	move_uploaded_file($_FILES["service_files"]["tmp_name"][$key],$imagePath);
    }
	 }
	 	 
	  $param['service_steps'] = $service_serialise_data;
	  if(!empty($service_files_serialize))  { 
	  $param['service_files'] = serialize($service_files_serialize);  
	  }
  
  
  
  
 if($_POST['id']=='') {     
      
	 
	$param['added_date'] = date('Y-m-d H:i:s',time());		
	$param['added_by']= $_SESSION['user_id'];  
	echo $rsDtls = Table::insertData(array('tableName'=>TBL_SERVICES,'fields'=>$param,'showSql'=>'N')); 
	$explode = explode('::',$rsDtls);  $serviceId = $explode[2];
 }
	else { 
	 	$param['last_updated_date'] = date('Y-m-d H:i:s',time());		
		$param['last_updated_by']= $_SESSION['user_id'];  
		$where= array('id'=>$_POST['id']);
		 echo  Table::updateData(array('tableName'=>TBL_SERVICES,'fields'=>$param,'where'=>$where,'showSql'=>'N'));
		 
	}
		 
 exit(); }
 
 
   if($_POST['act']=='show_add_edit_services') {
 ob_clean();
include 'add_edit_services.php'; 	   
 exit();
   }
 
 
 
 if($_POST['act']=='deleteService') {
		ob_clean();
		$param['last_updated_date'] = date('Y-m-d H:i:s',time());		
		$param['last_updated_by']= $_SESSION['user_id'];  
		$param['status']= 'I';  
		$where= array('id'=>$_POST['id']);
		echo Table::updateData(array('tableName'=>TBL_SERVICES,'fields'=>$param,'where'=>$where,'showSql'=>'N'));
	 exit();	
	}
 
 if($_POST['act']=='show_services_list') {
  ob_clean();
   $param = array('tableName'=>TBL_SERVICES,'fields'=>array('*'),'orderby'=>'id','sortby'=>'desc','condition'=>array('status'=>'A-CHAR'));
    $rsServices = Table::getData($param);	
  if($_POST['page']=='')	$page=1;	else	$page = $_POST['page'];
	$totalCount = count($rsServices);
	$totalPages= ceil(($totalCount)/(PAGE_LIMIT));
	if($totalPages==0) $totalPages=1;
	$StartIndex= ($page-1)*PAGE_LIMIT;
	if(count($rsServices)>0) $listingArr = array_slice($rsServices,$StartIndex,PAGE_LIMIT,true);
    include 'services_list.php'; 	   
  exit();
   }
   
  if($_POST['act']=='searchForm') {
	ob_clean(); 
	$filterType = $_POST['filter_type'];
	$filterText = $_POST['filter_text'];
	$service_types = $_POST['service_types'];
	 
	 $param = array('tableName'=>TBL_SERVICES,'fields'=>array('*'),'condition'=>array('status'=>'A-CHAR'));
	 
	if($filterType=='service_name') {
	$param = array('tableName'=>TBL_SERVICES,'fields'=>array('*'),'condition'=>array('service_name'=>$filterText.'-STRING','status'=>'A-CHAR'));
	}
	
if($filterType=='service_category_id') {
	$condition = array('service_category_id'=>$service_types.'-INT','status'=>'A-CHAR');
	
	 if($service_types=='all') {  $condition =array('status'=>'A-CHAR'); }
	 
	$param = array('tableName'=>TBL_SERVICES,'fields'=>array('*'),'condition'=>$condition);
	}	
	 
	
	$rsServices = Table::getData($param);
	
	 
	  
  // $param = array('tableName'=>TBL_SERVICES,'fields'=>array('*'),'orderby'=>'id','sortby'=>'desc','condition'=>array('status'=>'A-CHAR'));
   // $rsServices = Table::getData($param);	 
  if($_POST['page']=='')	$page=1;	else	$page = $_POST['page'];
	$totalCount = count($rsServices);
	$totalPages= ceil(($totalCount)/(PAGE_LIMIT));
	if($totalPages==0) $totalPages=1;
	$StartIndex= ($page-1)*PAGE_LIMIT;
	if(count($rsServices)>0) $listingArr = array_slice($rsServices,$StartIndex,PAGE_LIMIT,true);
	   include 'services_list.php';
    exit();
  }

 if($_POST['act']=='view_services') {
 ob_clean();
	 include 'view_services.php';
exit(); }


 ?>  
						<div class="row">
						<div class="col-sm-12">
							<div class="page-title-box">
								<h4 class="page-title">Services</h4>
								<ol class="breadcrumb float-right">
									<li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
									<li class="breadcrumb-item active">Services</li>
								</ol>
								<div class="clearfix"></div>
							</div>
						</div>
						</div>


                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card-box">
								<div class="row">
								<div class="col-lg-6">  <h4 class="m-t-0 header-title">Services</h4></div>
								<div class="col-lg-6"><a href="javascript:void(0)" onclick="showAddEditForm(0)" style="float:right">Add New</a></div>                                     
                                      </div>
                                 <div class="col-lg-12" style="padding:10px"> 
								<form id="filter_form">
								 <select style="padding:2px;" name="filter_type" id="filter_type" onchange="filterOption()">
								 <option value="filter">Filter</option>								 
								 <option value="service_name">Service Name</option>
								 <option value="service_category_id">Service Type</option>
								 </select>
								 
								 <select style="padding:2px;display:none" name="service_types" id="service_types" onclick="searchForm()">
								 <option value="all">All</option>
									<?php   $param=array();
									$param = array('tableName'=>TBL_SERVICE_CATEGORY,'fields'=>array('*'),'condition'=>array('status'=>'A-CHAR'));
									$rsServiceCat = Table::getData($param);
									$i=0;
									if(count($rsServiceCat)>0) {
									foreach($rsServiceCat as $key=>$val) {  echo '<option value="'.$val->id.'">'.$val->category_name.'</option>'; ?>
									 
									<?php } } ?>
								<!-- <option value="BP">Business Plan</option>
								 <option value="C">Certification</option>
								 <option value="L">License</option>
								 <option value="W">Website</option>
								 <option value="DM">Digital Marketing</option>-->
								 
								 </select>
								 
								 <input type="text" name="filter_text" id="filter_text" style="display:none">
								 <input type="hidden" name="act" value="searchForm">
								 <button type="button" onclick="searchForm()">Search</button>
								 
								 </form>
								 </div>  
								   <div class="table_div"></div>
								   
                                </div>

                            </div>

                            <div class="col-lg-6">

                               <span class="right_bar_div"></span>

                            </div>
                        </div>
                        
<script> 
function showAddEditForm(id) {
	paramData = {'act':'show_add_edit_services','id':id};
	ajax({ 
		a:'services',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		  $('.right_bar_div').html(data);			  
		}});	
}


function view_services(id) {
	paramData = {'act':'view_services','id':id};
	ajax({ 
		a:'services',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		  $('.right_bar_div').html(data);			  
		}});	
}

 
function show_services_list(id) {
	paramData = {'act':'show_services_list'};
	ajax({ 
		a:'services',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		  $('.table_div').html(data);			  
		}});	
}


function deleteServices(id) {
	if(confirm('Are you sure you want to delete this service?')) {
	paramData = {'act':'deleteService','id':id};
	ajax({ 
		a:'services',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		 show_services_list();		
var res = data.split("::");
alert(res[1]);		 
		}});	
} }


  function filterOption() {
	  $('#service_types').hide();
	$('#filter_text').hide();
	  var filter_type = $('#filter_type').val(); 
	 
	if(filter_type=='service_category_id') {  $('#service_types').show(); }
	if(filter_type=='service_name') {  $('#filter_text').show(); }
  }

searchForm();
function searchForm() {
	err=0;
 
	if($('#filter_type').val()=='' ){ err=1; $('#filter_type').css("border","1px solid #F58634 "); } else{  $('#filter_type').css("border","");}
	
	 var filter_type = $('#filter_type').val(); 
	 
	if(filter_type=='service_category_id') { 
            if($('#service_types').val()=='' ){ err=1; $('#service_types').css("border","1px solid #F58634 "); } else{  $('#service_types').css("border","");}
	}
	if(filter_type=='service_name') { if($('#filter_text').val()=='' ){ err=1; $('#filter_text').css("border","1px solid #F58634 "); } else{  $('#filter_text').css("border","");}   }
	
	
	var form = $('#filter_form');   
	if(err==0) {
	   ajax({ 
  	a:'services',
  	b:form.serialize(),
  	c:function(){},
  	d:function(data){    
	$('.table_div').html(data);	
	 }}); 	
} }
</script>
  
					
 <?php } include 'template.php'; ?>