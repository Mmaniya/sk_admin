 <?php 
 function main() { 
 
  if($_POST['act']=='addEditDocuments') {  
 ob_clean();
 $params = array('doc_name','doc_desc','doc_type','is_repeatable_field');
 foreach($params as $K=>$V) {  $param[$V]=$$V=check_input($_POST[$V]); } 
 if($_POST['id']=='') { 
	$param['added_date'] = date('Y-m-d H:i:s',time());		
	$param['added_by']= $_SESSION['user_id'];  
	  echo $rsDtls = Table::insertData(array('tableName'=>TBL_DOCUMENTS,'fields'=>$param,'showSql'=>'N')); 
	$explode = explode('::',$rsDtls);  $documentId = $explode[2];

  
 if($_POST['doc_type']=='multiple' || $_POST['doc_type']=='select' || $_POST['doc_type']=='radio') {
	 $no=1; 
	foreach($_POST['parent_doc_name'] as $key=>$val) {
    $param=array(); 
   
   $param['parent_id']=$documentId;
   $param['doc_name']=$_POST['parent_doc_name'][$key];
   $param['doc_desc']=$_POST['parent_doc_desc'][$key];
   
   if($_POST['doc_type']=='select' || $_POST['doc_type']=='radio')
   $param['doc_type']=$_POST['doc_type'];
   else
   $param['doc_type']=$_POST['parent_document_type'][$no++];
   $param['is_repeatable_field']=$_POST['is_repeatable_field'];
   
    $param['added_date'] = date('Y-m-d H:i:s',time());		
	$param['added_by']= $_SESSION['user_id'];  
	  $rsDtls = Table::insertData(array('tableName'=>TBL_DOCUMENTS,'fields'=>$param,'showSql'=>'N')); 
 }	}	 
	
	
 } else {
	 
	$param['updated_date'] = date('Y-m-d H:i:s',time());		
	$param['updated_by']= $_SESSION['user_id'];  
	$where= array('id'=>$_POST['id']);
	 echo  Table::updateData(array('tableName'=>TBL_DOCUMENTS,'fields'=>$param,'where'=>$where,'showSql'=>'N'));
	
	
	 if($_POST['doc_type']=='multiple' || $_POST['doc_type']=='select' || $_POST['doc_type']=='radio') {
		 if(count($_POST['parent_hidden'])>0) {
    foreach($_POST['parent_hidden'] as $key=>$val) {
    $param=array(); 
   $parent_document_type = $_POST['parent_document_type'][$_POST['parent_hidden'][$key]][$_POST['id']]; 
   
   $param['doc_name']=$_POST['parent_doc_name'][$key];
   $param['doc_desc']=$_POST['parent_doc_desc'][$key];
   $param['doc_type']=$parent_document_type;
   
   $param['is_repeatable_field']=$_POST['is_repeatable_field'];
	$param['updated_date'] = date('Y-m-d H:i:s',time());		
	$param['updated_by']= $_SESSION['user_id'];  
	$where= array('id'=>$_POST['parent_hidden'][$key]);
	   Table::updateData(array('tableName'=>TBL_DOCUMENTS,'fields'=>$param,'where'=>$where,'showSql'=>'N'));
		 } }

  
 $no=1;
 if(count($_POST['parent_append_hidden'])>0) {
	foreach($_POST['parent_append_hidden'] as $key=>$val) {
    $param=array(); 
   
   $param['parent_id']=$documentId;
   $param['doc_name']=$_POST['parent_doc_name'][$key];
   $param['doc_desc']=$_POST['parent_doc_desc'][$key];
   $param['doc_type']=$_POST['parent_document_type'][$no++];
   $param['parent_id']=$_POST['id'];
   
   
    $param['added_date'] = date('Y-m-d H:i:s',time());		
	$param['added_by']= $_SESSION['user_id'];  
	  $rsDtls = Table::insertData(array('tableName'=>TBL_DOCUMENTS,'fields'=>$param,'showSql'=>'N')); 
 } }


	 }  }
   
  exit();
  } 
 
 
 if($_POST['act']=='add_edit_documents') {
  ob_clean();
  include 'add_edit_documents.php'; 	
 exit();	 
 }
 
 
 

if($_POST['act']=='show_documents_list') {
  ob_clean();
  $param = array('tableName'=>TBL_DOCUMENTS,'fields'=>array('*'),'orderby'=>'id','sortby'=>'desc','condition'=>array('parent_id'=>'0-INT','status'=>'A-CHAR'));
    $rsDocuments = Table::getData($param);	
    $pageLimit=PAGE_LIMIT;
	$pageLimit = 1000;
	if($_POST['page']=='')	$page=1;	else	$page = $_POST['page'];
	$totalCount = count($rsDocuments);
	$totalPages= ceil(($totalCount)/($pageLimit));
	if($totalPages==0) $totalPages=1;
	$StartIndex= ($page-1)*PAGE_LIMIT;
	if(count($rsDocuments)>0) $listingArr = array_slice($rsDocuments,$StartIndex,$pageLimit,true);
	
    include 'documents_list.php'; 	  
	
  exit();
   }
 
 
 if($_POST['act']=='deleteCategory') {
		ob_clean();
		$param['updated_date'] = date('Y-m-d H:i:s',time());		
		$param['updated_by']= $_SESSION['user_id'];  
		$param['status']= 'I';  
		$where= array('id'=>$_POST['id']);
		echo Table::updateData(array('tableName'=>TBL_DOCUMENTS,'fields'=>$param,'where'=>$where,'showSql'=>'N'));		 
		
	 exit();	
	}
	
	
	 
 if($_POST['act']=='setActiveCategory') {
		ob_clean();
		$param['updated_date'] = date('Y-m-d H:i:s',time());		
		$param['updated_by']= $_SESSION['user_id'];  
		$param['status']= $_POST['status'];  
		$where= array('id'=>$_POST['id']);
		echo Table::updateData(array('tableName'=>TBL_DOCUMENTS,'fields'=>$param,'where'=>$where,'showSql'=>'N'));
	 exit();	
	}
 
   if($_POST['act']=='add_new_documents') {
  ob_clean();
	include'add_new_document.php';   	   
  exit(); }
 
 
 if($_POST['act']=='addEditNewDocuments') {  
 ob_clean();
 $params = array('doc_name','doc_desc','doc_type','parent_id');
 foreach($params as $K=>$V) {  $param[$V]=$$V=check_input($_POST[$V]); } 
 if($_POST['id']=='') { 
	$param['added_date'] = date('Y-m-d H:i:s',time());		
	$param['added_by']= $_SESSION['user_id'];  
	  echo $rsDtls = Table::insertData(array('tableName'=>TBL_DOCUMENTS,'fields'=>$param,'showSql'=>'N')); 
	$explode = explode('::',$rsDtls);  $documentId = $explode[2];
	 
	
 } else {
	$param['updated_date'] = date('Y-m-d H:i:s',time());		
	$param['updated_by']= $_SESSION['user_id'];  
	$where= array('id'=>$_POST['id']);
	echo  Table::updateData(array('tableName'=>TBL_DOCUMENTS,'fields'=>$param,'where'=>$where,'showSql'=>'N'));
 }
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
                                        <li class="breadcrumb-item active">Questionnaire / Documents</li>
                                    </ol>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                 </div>
				 
				 
				  <div class="row">
                            <div class="col-lg-6">
                                <div class="card-box">
								<div class="row">
								<div class="col-lg-6"><h4 class="m-t-0 header-title">Questionnaire / Documents</h4></div>
								<div class="col-lg-6"><a href="javascript:void(0)" onclick="showAddEditDocuments(0)" style="float:right">Add New</a></div> 
								</div>
                                 
								   <div class="table_div"></div>
								   
                                </div>

                            </div>

                            <div class="col-lg-6">

                               <span class="right_bar_div"></span>

                            </div>
                        </div>
	 
<script> 

function showAddNewDocument(id,parent_id) {
	paramData = {'act':'add_new_documents','id':id,'parent_id':parent_id};
	ajax({ 
		a:'documents_category',
		b:$.param(paramData),
		c:function(){},
		d:function(data){  $('.modal-popup').html(data); 
		 $('#con-close-modal').modal('show'); 			  
		}});	
}

 
function showAddEditDocuments(id) {
	paramData = {'act':'add_edit_documents','id':id};
	ajax({ 
		a:'documents_category',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		  $('.right_bar_div').html(data);			  
		}});	
}
 showDocumentsList();
function showDocumentsList() {
	paramData = {'act':'show_documents_list'};
	ajax({ 
		a:'documents_category',
		b:$.param(paramData),
		c:function(){},
		d:function(data){    
		  $('.table_div').html(data);		
		  $('.right_bar_div').html('');
		}});	
}


function deleteDocuments(id) {
	if(confirm('Are you sure you want to delete this document?')) {
	paramData = {'act':'deleteCategory','id':id};
	ajax({ 
		a:'documents_category',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		  showDocumentsList();
var res = data.split("::");
alert(res[1]);		 
		}});	
} }


</script>	
 
 <?php } include 'template.php'; ?>