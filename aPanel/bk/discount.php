 <?php 
 function main() { 
 $discountObj = new Discount;
 
  if($_POST['act']=='addEditDiscount') {  
 ob_clean();
 $params = array('discount_code','discount_name','discount_desc','discount_type','discount_value','valid_from','valid_to');
 foreach($params as $K=>$V) {  $param[$V]=$$V=check_input($_POST[$V]); } 
   
   $param['valid_from'] = date('Y-m-d',strtotime($_POST['valid_from']));
   $param['valid_to'] = date('Y-m-d',strtotime($_POST['valid_to']));
 
 if($_POST['id']=='') { 
	$param['added_date'] = date('Y-m-d H:i:s',time());		
	$param['added_by']= $_SESSION['user_id'];  
	echo $rsDtls = Table::insertData(array('tableName'=>TBL_DISCOUNT,'fields'=>$param,'showSql'=>'N')); 
	$explode = explode('::',$rsDtls);  $serviceId = $explode[2];
 } else {
	 
	$param['updated_date'] = date('Y-m-d H:i:s',time());		
	$param['updated_by']= $_SESSION['user_id'];  
	$where= array('id'=>$_POST['id']);
	echo  Table::updateData(array('tableName'=>TBL_DISCOUNT,'fields'=>$param,'where'=>$where,'showSql'=>'N'));
  } }
 
 
 if($_POST['act']=='show_add_edit_discount') {
  ob_clean();
  include 'add_edit_discount.php'; 	
 exit();	 
 }
 
 if($_POST['act']=='show_discount_list') {
ob_clean();
 
    $rsDiscount = $discountObj->getActiveInactiveDiscount(); 
	 
 if($_POST['page']=='')	$page=1;	else	$page = $_POST['page'];
	$totalCount = count($rsDiscount);
	$totalPages= ceil(($totalCount)/(PAGE_LIMIT));
	if($totalPages==0) $totalPages=1;
	$StartIndex= ($page-1)*PAGE_LIMIT;
	if(count($rsDiscount)>0) $listingArr = array_slice($rsDiscount,$StartIndex,PAGE_LIMIT,true);
include 'discount_list.php';	 
exit(); }
 
 
 if($_POST['act']=='deleteDiscount') {
		ob_clean();
		$param['updated_date'] = date('Y-m-d H:i:s',time());		
		$param['updated_by']= $_SESSION['user_id'];  
		$param['status']= 'D';  
		$where= array('id'=>$_POST['id']);
		echo Table::updateData(array('tableName'=>TBL_DISCOUNT,'fields'=>$param,'where'=>$where,'showSql'=>'N'));
	 exit();	
	}
	
	
	 
 if($_POST['act']=='setActiveDiscount') {
		ob_clean();
		$param['updated_date'] = date('Y-m-d H:i:s',time());		
		$param['updated_by']= $_SESSION['user_id'];  
		$param['status']= $_POST['status'];  
		$where= array('id'=>$_POST['id']);
		echo Table::updateData(array('tableName'=>TBL_DISCOUNT,'fields'=>$param,'where'=>$where,'showSql'=>'N'));
	 exit();	
	}
 
 ?>
 <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
 <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <link href="plugins/switchery/switchery.min.css" rel="stylesheet" /> 
                 <div class="row">
                            <div class="col-sm-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">Settings</h4>
                                    <ol class="breadcrumb float-right">
									    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                        <li class="breadcrumb-item active">Discount</li>
                                    </ol>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                 </div>
				 
				 
				  <div class="row">
                            <div class="col-lg-6">
                                <div class="card-box">
								<div class="row">
								<div class="col-lg-6"><h4 class="m-t-0 header-title">Discount</h4></div>
								<div class="col-lg-6"><a href="javascript:void(0)" onclick="showAddEditDiscount(0)" style="float:right">Add New</a></div> 
								</div>
                                 
								   <div class="table_div"></div>
								   
                                </div>

                            </div>

                            <div class="col-lg-6">

                               <span class="right_bar_div"></span>

                            </div>
                        </div>
	 
<script> 
 
function showAddEditDiscount(id) {
	paramData = {'act':'show_add_edit_discount','id':id};
	ajax({ 
		a:'discount',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		  $('.right_bar_div').html(data);			  
		}});	
}
showDiscountList();
function showDiscountList() {
	paramData = {'act':'show_discount_list'};
	ajax({ 
		a:'discount',
		b:$.param(paramData),
		c:function(){},
		d:function(data){    
		  $('.table_div').html(data);			  
		}});	
}


function deleteDiscount(id) {
	if(confirm('Are you sure you want to delete this discount?')) {
	paramData = {'act':'deleteDiscount','id':id};
	ajax({ 
		a:'discount',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		 showDiscountList();	
var res = data.split("::");
alert(res[1]);		 
		}});	
} }


</script>	
 
 <?php } include 'template.php'; ?>