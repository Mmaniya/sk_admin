 <?php 
 function main() { 
 
 
 if($_POST['act']=='addEditPackage') {  
 ob_clean();
 $params = array('service_category_id','package_name','package_desc','package_price','package_payment_plan','package_recurring_duration','is_installment_allowed','service_steps','service_files','delivery_time_duration','delivery_time');
 foreach($params as $K=>$V) {  $param[$V]=$$V=check_input($_POST[$V]); } 
 
     $arr=array();
	 if($_POST['document_id']!='') {
	 $documentArr = $_POST['document_id'];
     $document_id = implode(",", $documentArr);
   
	 $param['document_id'] = $document_id; }
   
   $arr['package_name_append'] = $_POST['package_name_append'];
   $arr['package_description_append'] = $_POST['package_description_append'];
   $arr['delivery_time_append'] = $_POST['delivery_time_append'];
   $arr['delivery_time_duration_append'] = $_POST['delivery_time_duration_append'];
   
  
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
	echo $rsDtls = Table::insertData(array('tableName'=>TBL_PACKAGES,'fields'=>$param,'showSql'=>'N')); 
	$explode = explode('::',$rsDtls);  $serviceId = $explode[2];
 }
	else { 
	 	$param['last_updated_date'] = date('Y-m-d H:i:s',time());		
		$param['last_updated_by']= $_SESSION['user_id'];  
		$where= array('id'=>$_POST['id']);
		 echo  Table::updateData(array('tableName'=>TBL_PACKAGES,'fields'=>$param,'where'=>$where,'showSql'=>'N'));
		 
	}
		 
 exit(); }
 
  
 if($_POST['act']=='add_package_services') {
 ob_clean();
  
     dB::deleteSql("DELETE FROM  `".TBL_PACKAGE_SERVICES."` WHERE package_id=".$_POST['package_id']);
   
  $service_price  = $_POST['service_price'];
  
  $packageId  = $_POST['package_id'];

  $service_id  = $_POST['service_id'];
  $service_categoty_id  = $_POST['service_categoty_id'];
  if(count($service_categoty_id)>0) {
   foreach($service_categoty_id as $key=>$val) {
	   
	   if(count($service_id)>0) {
	     foreach($service_id as $K=>$V) {
			    $servicePrice=''; $serviceId='';
				 
				 
			$serviceId =  $service_id[$K][$val];
           $servicePrice =  $service_price[$serviceId];
    //  print_r($service_price);
      
		 
			   
			$param['package_id']=$packageId;
			$param['service_category_id']=$service_categoty_id[$key];
			$param['service_id']=$serviceId;
			$param['service_price']=$servicePrice;
			$param['added_date'] = date('Y-m-d H:i:s',time());		
			$param['added_by']= $_SESSION['user_id'];  
			
            Table::insertData(array('tableName'=>TBL_PACKAGE_SERVICES,'fields'=>$param,'showSql'=>'N')); 
		   
	   }   } 
  } }
 
 
 exit();
 }  
 
   
 
 
 
 
 
   if($_POST['act']=='show_add_edit_package') {
 ob_clean();
include 'add_edit_package.php'; 	   
 exit();
   }
 
 
 
 if($_POST['act']=='deletePackage') {
		ob_clean();
		$param['last_updated_date'] = date('Y-m-d H:i:s',time());		
		$param['last_updated_by']= $_SESSION['user_id'];  
		$param['status']= 'I';  
		$where= array('id'=>$_POST['id']);
		echo Table::updateData(array('tableName'=>TBL_PACKAGES,'fields'=>$param,'where'=>$where,'showSql'=>'N'));
	 exit();	
	}
 
 if($_POST['act']=='show_package_list') {
  ob_clean();
   $param = array('tableName'=>TBL_PACKAGES,'fields'=>array('*'),'orderby'=>'id','sortby'=>'desc','condition'=>array('status'=>'A-CHAR'));
    $rsServices = Table::getData($param);	
  if($_POST['page']=='')	$page=1;	else	$page = $_POST['page'];
	$totalCount = count($rsServices);
	$totalPages= ceil(($totalCount)/(PAGE_LIMIT));
	if($totalPages==0) $totalPages=1;
	$StartIndex= ($page-1)*PAGE_LIMIT;
	if(count($rsServices)>0) $listingArr = array_slice($rsServices,$StartIndex,PAGE_LIMIT,true);
    include 'package_list.php'; 	   
  exit();
   }
   
  if($_POST['act']=='searchForm') {
	ob_clean(); 
	 
	  
    $param = array('tableName'=>TBL_PACKAGES,'fields'=>array('*'),'orderby'=>'id','sortby'=>'desc','condition'=>array('status'=>'A-CHAR'));
     $rsPackage = Table::getData($param);	 
  if($_POST['page']=='')	$page=1;	else	$page = $_POST['page'];
	$totalCount = count($rsPackage);
	$totalPages= ceil(($totalCount)/(PAGE_LIMIT));
	if($totalPages==0) $totalPages=1;
	$StartIndex= ($page-1)*PAGE_LIMIT;
	if(count($rsPackage)>0) $listingArr = array_slice($rsPackage,$StartIndex,PAGE_LIMIT,true);
	   include 'package_list.php';
    exit();
  }

 if($_POST['act']=='show_add_package_service') {
 ob_clean();
	 include 'add_packages_services.php';
exit(); }

 if($_POST['act']=='view_package') {
 ob_clean();
	 include 'view_package.php';
exit(); }


 ?>  
						<div class="row">
						<div class="col-sm-12">
							<div class="page-title-box">
								<h4 class="page-title">Packages</h4>
								<ol class="breadcrumb float-right">
									<li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
									<li class="breadcrumb-item active">Packages</li>
								</ol>
								<div class="clearfix"></div>
							</div>
						</div>
						</div>


                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card-box">
								<div class="row">
								<div class="col-lg-6">  <h4 class="m-t-0 header-title">Packages</h4></div>
								<div class="col-lg-6"><a href="javascript:void(0)" onclick="showAddEditForm(0)" style="float:right">  Add New </a>
  
								</div>     </div>
                                 
								   <div class="table_div"></div>
								   
                                </div>

                            </div>

                            <div class="col-lg-6">

                               <span class="right_bar_div"></span>

                            </div>
                        </div>
                        
<script> 
function showAddEditForm(id) {
	paramData = {'act':'show_add_edit_package','id':id};
	ajax({ 
		a:'package',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		  //$('.right_bar_div').html(data);			  
		  $('.table_div').html(data);			  
		  $('.right_bar_div').html('');			  
		}});	
}


function view_services(id) {
	paramData = {'act':'view_package','id':id};
	ajax({ 
		a:'package',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		  $('.right_bar_div').html(data);			  
		}});	
}

 show_package_list();
function show_package_list() {
	paramData = {'act':'show_package_list'};
	ajax({ 
		a:'package',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		  $('.table_div').html(data);			  
		  $('.right_bar_div').html('');			  
		}});	
}


function deletePackage(id) {
	if(confirm('Are you sure you want to delete this Package?')) {
	paramData = {'act':'deletePackage','id':id};
	ajax({ 
		a:'package',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		 show_package_list();		
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

 
function searchForm() {
	 
	
	var form = $('#filter_form');   
	if(err==0) {
	   ajax({ 
  	a:'package',
  	b:form.serialize(),
  	c:function(){},
  	d:function(data){    
	$('.table_div').html(data);	
	 }}); 	
} }
</script>
  
					
 <?php } include 'template.php'; ?>