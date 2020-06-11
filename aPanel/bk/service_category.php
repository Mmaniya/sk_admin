 <?php 
 function main() { 
 
  if($_POST['act']=='addEditServiceCat') {  
 ob_clean();
 $params = array('category_name','abbreviation','description');
 foreach($params as $K=>$V) {  $param[$V]=$$V=check_input($_POST[$V]); } 
 if($_POST['id']=='') { 
	$param['added_date'] = date('Y-m-d H:i:s',time());		
	$param['added_by']= $_SESSION['user_id'];  
	echo $rsDtls = Table::insertData(array('tableName'=>TBL_SERVICE_CATEGORY,'fields'=>$param,'showSql'=>'N')); 
	$explode = explode('::',$rsDtls);  $serviceId = $explode[2];
 } else {
	 
	$param['updated_date'] = date('Y-m-d H:i:s',time());		
	$param['updated_by']= $_SESSION['user_id'];  
	$where= array('id'=>$_POST['id']);
	echo  Table::updateData(array('tableName'=>TBL_SERVICE_CATEGORY,'fields'=>$param,'where'=>$where,'showSql'=>'N'));
  } }
 
 
 if($_POST['act']=='add_edit_service_cat') {
  ob_clean();
  include 'add_edit_service_cat.php'; 	
 exit();	 
 }
 
 if($_POST['act']=='show_category_list') {
ob_clean();
$categoryObj = new ServiceCategory();
$rsServiceCat = $categoryObj->getActiveInactiveCategory();
 if($_POST['page']=='')	$page=1;	else	$page = $_POST['page'];
	$totalCount = count($rsServiceCat);
	$totalPages= ceil(($totalCount)/(PAGE_LIMIT));
	if($totalPages==0) $totalPages=1;
	$StartIndex= ($page-1)*PAGE_LIMIT;
	if(count($rsServiceCat)>0) $listingArr = array_slice($rsServiceCat,$StartIndex,PAGE_LIMIT,true);
include 'service_category_list.php';	 
exit(); }
 
 
 if($_POST['act']=='deleteService') {
		ob_clean();
		$param['updated_date'] = date('Y-m-d H:i:s',time());		
		$param['updated_by']= $_SESSION['user_id'];  
		$param['status']= 'D';  
		$where= array('id'=>$_POST['id']);
		echo Table::updateData(array('tableName'=>TBL_SERVICE_CATEGORY,'fields'=>$param,'where'=>$where,'showSql'=>'N'));
	 exit();	
	}
	
	
	 
 if($_POST['act']=='setActiveCategory') {
		ob_clean();
		$param['updated_date'] = date('Y-m-d H:i:s',time());		
		$param['updated_by']= $_SESSION['user_id'];  
		$param['status']= $_POST['status'];  
		$where= array('id'=>$_POST['id']);
		echo Table::updateData(array('tableName'=>TBL_SERVICE_CATEGORY,'fields'=>$param,'where'=>$where,'showSql'=>'N'));
	 exit();	
	}
 
 ?>
  <link href="plugins/switchery/switchery.min.css" rel="stylesheet" /> 
                 <div class="row">
                            <div class="col-sm-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">Settings</h4>
                                    <ol class="breadcrumb float-right">
									    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                        <li class="breadcrumb-item active">Settings</li>
                                    </ol>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                 </div>
				 
				 
				  <div class="row">
                            <div class="col-lg-6">
                                <div class="card-box">
								<div class="row">
								<div class="col-lg-6"><h4 class="m-t-0 header-title">Services Category</h4></div>
								<div class="col-lg-6"><a href="javascript:void(0)" onclick="showAddEditServiceCat(0)" style="float:right">Add New</a></div> 
								</div>
                                 
								   <div class="table_div"></div>
								   
                                </div>

                            </div>

                            <div class="col-lg-6">

                               <span class="right_bar_div"></span>

                            </div>
                        </div>
	 
<script> 
 
function showAddEditServiceCat(id) {
	paramData = {'act':'add_edit_service_cat','id':id};
	ajax({ 
		a:'service_category',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		  $('.right_bar_div').html(data);			  
		}});	
}
showServiceCatList();
function showServiceCatList() {
	paramData = {'act':'show_category_list'};
	ajax({ 
		a:'service_category',
		b:$.param(paramData),
		c:function(){},
		d:function(data){    
		  $('.table_div').html(data);			  
		}});	
}


function deleteServices(id) {
	if(confirm('Are you sure you want to delete this service Category?')) {
	paramData = {'act':'deleteService','id':id};
	ajax({ 
		a:'service_category',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		 showServiceCatList();	
var res = data.split("::");
alert(res[1]);		 
		}});	
} }


</script>	
 
 <?php } include 'template.php'; ?>