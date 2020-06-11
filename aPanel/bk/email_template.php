 <?php 
 function main() { 
 
  if($_POST['act']=='addEditEmailTemplate') {  
 ob_clean();   
 $params = array('email_type','service_category_id','service_id','template_name','email_subject','spanish_email_subject','notes');
 foreach($params as $K=>$V) {  $param[$V]=$$V=check_input($_POST[$V]); } 
   $param['email_body']= check_input($_POST['email_body']);  
   $param['spanish_email_body']= check_input($_POST['spanish_email_body']);  
   
 if($_POST['email_template_id']=='') { 
	$param['added_date'] = date('Y-m-d H:i:s',time());		
	$param['added_by']= $_SESSION['user_id'];  
	echo $rsDtls = Table::insertData(array('tableName'=>TBL_EMAIL_TEMPLATE,'fields'=>$param,'showSql'=>'N')); 
	$explode = explode('::',$rsDtls);  $serviceId = $explode[2];
 } else {
	 
	$param['updated_date'] = date('Y-m-d H:i:s',time());		
	$param['updated_by']= $_SESSION['user_id'];  
	$where= array('id'=>$_POST['email_template_id']);
	echo  Table::updateData(array('tableName'=>TBL_EMAIL_TEMPLATE,'fields'=>$param,'where'=>$where,'showSql'=>'N'));
  } 
  
  exit(); }
 
 
 if($_POST['act']=='show_add_edit_template') {
  ob_clean();
  include 'add_edit_email_template.php'; 	
 exit();	 
 }
 
  
 if($_POST['act']=='view_email_template') {
  ob_clean();
  include 'view_email_template.php'; 	
 exit();	 
 }
 
 if($_POST['act']=='show_template_list') {
ob_clean();
$param = array('tableName'=>TBL_EMAIL_TEMPLATE,'fields'=>array('*'),'orderby'=>'id','sortby'=>'desc','condition'=>array('status'=>'A-CHAR'));
$rsEmailTemplate = Table::getData($param);
if($_POST['page']=='')	$page=1;	else	$page = $_POST['page'];
$totalCount = count($rsEmailTemplate);
$totalPages= ceil(($totalCount)/(PAGE_LIMIT));
if($totalPages==0) $totalPages=1;
$StartIndex= ($page-1)*PAGE_LIMIT;
if(count($rsEmailTemplate)>0) $listingArr = array_slice($rsEmailTemplate,$StartIndex,PAGE_LIMIT,true);
include 'email_template_list.php';	 
exit(); }
 
 
 if($_POST['act']=='delete_email_template') {
		ob_clean();
		$param['updated_date'] = date('Y-m-d H:i:s',time());		
		$param['updated_by']= $_SESSION['user_id'];  
		$param['status']= 'I';  
		$where= array('id'=>$_POST['id']);
		echo Table::updateData(array('tableName'=>TBL_EMAIL_TEMPLATE,'fields'=>$param,'where'=>$where,'showSql'=>'N'));
	 exit();	
	}
	
 
 if($_POST['act']=='show_service_list') {
ob_clean();
$categoryId = $_POST['id'];
$serviceId = $_POST['service_id'];
	 $param = array('tableName'=>TBL_SERVICES,'fields'=>array('id,service_name'),'orderby'=>'service_name','sortby'=>'asc','condition'=>array('service_category_id'=>$categoryId.'-INT','status'=>'A-CHAR'));
		$rsServices = Table::getData($param);
		echo '<option value="">select</option>';
		if(count($rsServices)>0) {
		foreach($rsServices as $key=>$val) {   $selected =''; if($serviceId==$val->id) { echo $selected='selected'; }
		  echo '<option value='.$val->id.' '.$selected.'>'.$val->service_name.'</option>';
		} } else { echo '<option value="">No Services</option>';  }
exit();
 }
 
 
 
 ?>
  <link href="plugins/switchery/switchery.min.css" rel="stylesheet" /> 
                 <div class="row">
                            <div class="col-sm-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">Email Template</h4>
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
								<div class="col-lg-6"><h4 class="m-t-0 header-title">Email Template</h4></div>
								<div class="col-lg-6"><a href="javascript:void(0)" onclick="showAddEditEmailTemplate(0)" style="float:right">Add New</a></div> 
								</div>
                                 
								   <div class="table_div"></div>
								   
                                </div>

                            </div>

                            <div class="col-lg-6">

                               <span class="right_bar_div"></span>

                            </div>
                        </div>
	 
<script> 
 
function showAddEditEmailTemplate(id) {
	paramData = {'act':'show_add_edit_template','id':id};
	ajax({ 
		a:'email_template',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		  $('.right_bar_div').html(data);			  
		}});	
}
showEmailTemplateList();
function showEmailTemplateList() {
	paramData = {'act':'show_template_list'};
	ajax({ 
		a:'email_template',
		b:$.param(paramData),
		c:function(){},
		d:function(data){    
		  $('.table_div').html(data);			  
		}});	
}


function deleteEmailTemplate(id) {
	if(confirm('Are you sure you want to delete this Email Template?')) {
	paramData = {'act':'delete_email_template','id':id};
	ajax({ 
		a:'email_template',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		 showEmailTemplateList();
var res = data.split("::");
alert(res[1]);		 
		}});	
} }


</script>	
 
 <?php } include 'template.php'; ?>