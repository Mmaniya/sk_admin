 <?php 
 function main() { 
 
 

 if($_POST['act']=='addEditLeads') {  
	ob_clean();

	
	$params = array('lead_company_name','lead_fname','lead_lname','lead_email','lead_phone','lead_enquiry_type','other_enquiry_type','lead_enquiry_desc');
	foreach($params as $K=>$V) {  $param[$V]=$$V=($_POST[$V]); } 
	
	$packagesId = $_POST['packages_id'];
	
	$param['packages_id']='';
	if(count($packagesId)>0) {
		$packagesIdList = implode(",", $packagesId);
		$param['packages_id']= $packagesIdList;
	}
	$param['lead_enquiry_for']='';
	$arrayEnquiry = $_POST['lead_enquiry_for'];
	if(count($arrayEnquiry)>0) {
		$leadsEnquiryIds = implode(",", $arrayEnquiry);
	}
	
	$param['lead_enquiry_for']= $leadsEnquiryIds;
	$param['lead_phone'] = str_replace('','-',($_POST['lead_phone'])); 
	$param['lead_followed_by']=$_SESSION['user_id'];  
	$lead_followed_by = $_SESSION['user_id'];

	if($_POST['id']=='') {       
		$param['lead_added_date'] = date('Y-m-d H:i:s',time());		
		$param['lead_added_by']= $_SESSION['user_id'];  
		$rsDtls = Table::insertData(array('tableName'=>TBL_LEADS,'fields'=>$param,'showSql'=>'N')); 
		$explode = explode('::',$rsDtls);  $leadId = $explode[2];  	
	}
	else { 
		$param['last_updated_date'] = date('Y-m-d H:i:s',time());		
		$param['last_updated_by']= $_SESSION['user_id'];  
		$where= array('id'=>$_POST['id']);
		$rsDtls = Table::updateData(array('tableName'=>TBL_LEADS,'fields'=>$param,'where'=>$where,'showSql'=>'N'));
        $explode = explode('::',$rsDtls);  $leadId = $explode[2];
	}
	
	
	$where= array('lead_id'=>$_POST['id']);
	Table::deleteData(array('tableName'=>TBL_LEAD_SERVICES,'fields'=>$param,'where'=>$where,'showSql'=>'N'));
	
	
	$param = array('tableName'=>TBL_LEAD_SERVICES,'fields'=>array('*'),'condition'=>array('id'=>$_POST['id'].'-INT'));
	$rsServiceList = Table::getData($param);
	
	if(count($_POST['service_type_list'])) {
	foreach($_POST['lead_enquiry_for'] as $K=>$V) {
	foreach($_POST['service_type_list'] as $key=>$val) {
		$param=array();
		// print_r($_POST['service_type_list'][$key][$V]); exit();
		$service_type_list = $_POST['service_type_list'][$key][$V];
		
		$param = array('tableName'=>TBL_SERVICES,'fields'=>array('*'),'condition'=>array('id'=>$service_type_list.'-INT'));
		$rsServiceRes = Table::getData($param);
		
		if($_POST['service_type_list'][$key][$V]!='') {
			$param=array();
			$param['lead_id'] = $leadId;
			$param['service_category_id'] = $_POST['lead_enquiry_for'][$K];
			$param['service_id'] = $_POST['service_type_list'][$key][$V];
			$param['service_amount'] = $rsServiceRes->service_price;
			$param['added_by'] = $_SESSION['user_id'];   	
			$param['added_date']= date('Y-m-d H:i:s',time());	
			echo $rsDtls = Table::insertData(array('tableName'=>TBL_LEAD_SERVICES,'fields'=>$param,'showSql'=>'N'));
		}	
	} 
	}
	}
	
	exit(); 
  }
 
 
   if($_POST['act']=='show_add_edit_leads') {
		ob_clean();
		include 'add_edit_leads.php'; 	   
		exit();
   }
 
 
 
 if($_POST['act']=='deleteService') {
		ob_clean();
		$param['last_updated_date'] = date('Y-m-d H:i:s',time());		
		$param['last_updated_by']= $_SESSION['user_id'];  
		$param['status']= 'I';  
		$where= array('id'=>$_POST['id']);
		echo Table::updateData(array('tableName'=>TBL_LEADS,'fields'=>$param,'where'=>$where,'showSql'=>'N'));
	 exit();	
	}
//PAGE_LIMIT
 if($_POST['act']=='show_services_list') {
  ob_clean();
  $param = array('tableName'=>TBL_LEADS,'fields'=>array('*'),'orderby'=>'id','sortby'=>'desc','condition'=>array('status'=>'A-CHAR'));
    $rsLeads = Table::getData($param);	
		 
	if($_POST['page']=='')	$page=1;	else	$page = $_POST['page'];
	$totalCount = count($rsLeads);
	$totalPages= ceil(($totalCount)/(PAGE_LIMIT));
	if($totalPages==0) $totalPages=1;
	$StartIndex= ($page-1)*PAGE_LIMIT;
	if(count($rsLeads)>0) $listingArr = array_slice($rsLeads,$StartIndex,PAGE_LIMIT,true);
	
    include 'leads_list.php'; 	  
	
  exit();
   }
   
   
    if($_POST['act']=='filter_leads_list') {
	  ob_clean();
	  $filter_text_id = $_POST['filter_text_id'];
	  $filter_textbox = $_POST['filter_textbox'];
	  
	   if($_POST['filter_type']=='email') {
		$param = array('tableName'=>TBL_LEADS,'fields'=>array('*'),'showSql'=>'N','condition'=>array('id'=>$filter_text_id.'-INT','status'=>'A-CHAR'));     
		$rsLeads[0]  = Table::getData($param);	
	    }
		
		if($_POST['filter_type']=='lead_name') {
		$param = array('tableName'=>TBL_LEADS,'fields'=>array('*'),'showSql'=>'N','condition'=>array('id'=>$filter_text_id.'-INT','status'=>'A-CHAR'));     
          $rsLeads[0]  = Table::getData($param);			
	    }
		
		
		if($_POST['filter_type']=='company_name') {
		$param = array('tableName'=>TBL_LEADS,'fields'=>array('*'),'showSql'=>'N','condition'=>array('id'=>$filter_text_id.'-INT','status'=>'A-CHAR'));     
          $rsLeads[0]  = Table::getData($param);			
	    }
		
		if($_POST['filter_type']=='lead_phone') {
		$param = array('tableName'=>TBL_LEADS,'fields'=>array('*'),'showSql'=>'N','condition'=>array('id'=>$filter_text_id.'-INT','status'=>'A-CHAR'));     
          $rsLeads[0]  = Table::getData($param);			
	    }
		 		
		
		 if($_POST['filter_type']=='services') {
		$param = array('tableName'=>TBL_LEAD_SERVICES,'fields'=>array('*'),'showSql'=>'N','condition'=>array('service_id'=>$filter_text_id.'-INT'));  
        $rsServiceItems = Table::getData($param);
	    foreach($rsServiceItems as $key=>$val) $leadServiceArr[]=$val->lead_id;
		  $qry = 'select * from `'.TBL_LEADS.'` where id in('.implode(',',$leadServiceArr).') and status="A"';
		$rsLeads = dB::mExecuteSql($qry);
	    }  
		
		  if($_POST['filter_type']=='filter')
		{
			$qry = 'select * from `'.TBL_LEADS.'` where status="A" order by id desc';
			$rsLeads = dB::mExecuteSql($qry);
		}  
			 	
	    
  if($_POST['page']=='')	$page=1;	else	$page = $_POST['page'];
	$totalCount = count($rsLeads);
	$totalPages= ceil(($totalCount)/(PAGE_LIMIT));
	if($totalPages==0) $totalPages=1;
	$StartIndex= ($page-1)*PAGE_LIMIT;
	if(count($rsLeads)>0) $listingArr = array_slice($rsLeads,$StartIndex,PAGE_LIMIT,true);
    include 'leads_list.php'; 	   
  exit();
   }

 

   if($_POST['act']=='view_assign_specialist') {
 ob_clean();
include 'view_assign_specialist.php'; 	   
 exit();
   }
 
 if($_POST['act']=='add_edit_specialist') {  
 ob_clean();   
  
  
	$where= array('service_category_id'=>$_POST['service_category_id'],'lead_id'=>$_POST['lead_id']);
	  Table::deleteData(array('tableName'=>TBL_LEAD_SPECIALIST,'fields'=>$param,'showSql'=>'N','where'=>$where));
  
  
 $param=array();
 $params = array('lead_id','service_category_id','user_id');
 foreach($params as $K=>$V) {  $param[$V]=$$V=check_input($_POST[$V]); } 
 
  if($_POST['userType']=='add_new') {  //8,7,6,5,3,1
	   $user_id = $_POST['user_id'];  
	   
	  $param1 = array('tableName'=>TBL_USERS,'fields'=>array('*'),'condition'=>array('id'=>$user_id.'-INT'));
	$rsUsers = Table::getData($param1);
	$emptype = rtrim($rsUsers->employee_type,','); 
	  $where=array();  
	  $addempType = $emptype.','.$_POST['service_category_id'];
	 
   $paramData['employee_type']= ltrim($addempType,','); 
   $paramData['last_updated']= date('Y-m-d H:i:s',time());	
 
	$where= array('id'=>$_POST['user_id']);
	echo  Table::updateData(array('tableName'=>TBL_USERS,'fields'=>$paramData,'where'=>$where,'showSql'=>'Y'));
	$where=array();
  }	  
 
 if($_POST['lead_specialist_id']=='') {
	$param['added_date'] = date('Y-m-d H:i:s',time());		
	$param['added_by']= $_SESSION['user_id'];  
	echo $rsDtls = Table::insertData(array('tableName'=>TBL_LEAD_SPECIALIST,'fields'=>$param,'showSql'=>'N')); 
	$explode = explode('::',$rsDtls);  $serviceId = $explode[2];
   } else { 
   
    
   
	$param['updated_date'] = date('Y-m-d H:i:s',time());		
	$param['updated_by']= $_SESSION['user_id'];  
	$where= array('id'=>$_POST['lead_specialist_id']);
	echo  Table::updateData(array('tableName'=>TBL_LEAD_SPECIALIST,'fields'=>$param,'where'=>$where,'showSql'=>'N'));
		 
	}  
	exit();
 }
 
  if($_POST['act']=='show_send_quotation_form') {
		ob_clean();
		include 'edit_quotation.php';	  
		exit(); 
	}
   
 
   if($_POST['calculation']=='yes') {
	   ob_clean();
	   
	   $lead_enquiry_for = $_POST['service_category'];
	   
	   $discount_amount = intval($_POST['couponcode_amount']);
	  if($discount_amount=='') { $discount_amount = 0; }
	   
	   
	   if(count($lead_enquiry_for)>0) {
		   foreach($lead_enquiry_for as $key=>$val) {    
		   
		   
		   
				/*** add new line item  Start *****/
				   if(count($_POST['add_new_service_amount'])>0) {
					  foreach($_POST['add_new_service_amount'] as $K1=>$V1) {
					      $total+=intval($_POST['add_new_service_amount'][$K1][$val]); 
					}   }
				/*** add new line item  End  *****/
		  
		   
		   
		   /*** Service checked Item Price  Start *****/
			  if(count($_POST['services_list'])>0) {   
			    foreach($_POST['services_list'] as $K=>$V) {  				      
					    $serviceId =  $_POST['services_list'][$K][$val];
                            $total+=intval($_POST['service_amount_'.$serviceId]); 
			     }  			  
			  } 
               /*** Service checked Item Price  End *****/			  
		   } 		   
	   }
	   	   
	   
	    if(count($_POST['add_new_price'])>0) {
					  foreach($_POST['add_new_price'] as $K2=>$V2) {
					      $total+=intval($_POST['add_new_price'][$K2]); 
					}   }
					
					   if(count($_POST['packages_id'])>0) {
					  foreach($_POST['packages_id'] as $K2=>$V2) {
					      $total+=intval($_POST['package_price'][$V2]); 
					}   }
	   
	    	
	   echo $total;
	   
  exit(); }
 

		
		
 if($_POST['act']=='view_lead_details') {
 ob_clean();
    include 'lead_details.php';  
 exit(); 
 }	 
 
 if($_POST['act']=='addEditLeadAddress') {
	 ob_clean(); 
	$params = array('lead_address','lead_city','lead_state');
	foreach($params as $K=>$V) {  $param[$V]=$$V=check_input($_POST[$V]); } 
	
	$param['last_updated_date'] = date('Y-m-d H:i:s',time());		
	$param['last_updated_by']= $_SESSION['user_id'];  
	$where= array('id'=>$_POST['id']);
    Table::updateData(array('tableName'=>TBL_LEADS,'fields'=>$param,'where'=>$where,'showSql'=>'N')); 	 
     exit(); }

     if($_POST['act']=='addEditLeadEmail') {
         ob_clean();
         $params = array('lead_cc_email');
         foreach($params as $K=>$V) {  $param[$V]=$$V=check_input($_POST[$V]); }

         $param['last_updated_date'] = date('Y-m-d H:i:s',time());
         $param['last_updated_by']= $_SESSION['user_id'];
         $where= array('id'=>$_POST['id']);
         Table::updateData(array('tableName'=>TBL_LEADS,'fields'=>$param,'where'=>$where,'showSql'=>'N'));
         exit(); }
		 
 
 ?>  

						<div class="row">
						<div class="col-sm-12">
							<div class="page-title-box">
								<h4 class="page-title">Leads</h4>
								<ol class="breadcrumb float-right">
									<li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
									<li class="breadcrumb-item active">Quotation </li>
									<li class="breadcrumb-item active activeBread"  onclick="show_services_list()" style="cursor:pointer;">Leads </li>
								</ol>
								<div class="clearfix"></div>
							</div>
						</div>
						</div>


                        <div class="row">
                            <div class="col-md-6">
                                <div class="card-box" style="background-color:#FFF">
								<div class="row page_head_title">
								<div class="col-lg-6"><h4 class="m-t-0 header-title">Leads Details</h4></div>
								<div class="col-lg-6"><a href="javascript:void(0)" onclick="showAddEditForm(0)" style="float:right">Add New</a></div>  



 <div class="col-lg-12" style="padding:10px"> 
								<form id="filter_form" style="display:flex;">
						  <select style="padding:2px; margin-left:10px;" name="filter_type" id="filter_type" onchange="filterOption(this.value)">
								 <option value="filter">Filter</option>								 
								 <option value="lead_name">Lead Name</option>
								 <option value="company_name">Company Name</option>
								 <option value="email">Email</option>
								 <option value="lead_phone">Phone</option>
								 <option value="services">Services</option>
								 </select>
								 
								  <input type="text" name="filter_textbox" id="filter_textbox" class="form-control" style="padding:2px; margin-left:10px; width:25%">
								 
								 <input type="hidden" name="filter_text_id" id="filter_text_id">
								 <input type="hidden" name="filter_text" id="filter_text">
								 <input type="hidden" name="act" value="filter_leads_list">
								 <button type="button" onclick="searchLeads()" class="btn btn-sm btn-primary" style="margin-left:10px;">Search</button>
								 
								 </form>
								 </div> 

								
                                      </div>
                                  
								   <div class="table_div"> </div>
								   <div class="preview_div"></div>
                              </div>  
                            </div>  
							
                            <div class="col-md-6">

                               <div class="right_bar_div"></div>
                               
                               
                                <span class="library_div"></span>
 
                            </div>
                        </div> 
       <script src='assets/js/jquery.inputmask.bundle.js'></script>              
<script>  


 var filter_type = $('#filter_type').val();
 $("#filter_textbox").autocomplete({ 	 
  source: function(request, response) {
  $.getJSON("search_details.php",{ filter_type: $('#filter_type').val(),'act':'leadsAutocomplete','term':$('#filter_textbox').val() },response); },
  minLength: 2,
  select: function(event, ui){
  event.preventDefault();  
	$("#filter_textbox").val(ui.item.value);
	$("#filter_text_id").val(ui.item.id);
	$("#filter_text").val(ui.item.value);
	searchLeads();
	 
	 } 
});


 

function searchLeads() {
	err=0;
	
	if($('#filter_type').val()=='' ){ err=1; $('#filter_type').css("border","1px solid #ff0000 "); } else{  $('#filter_type').css("border",""); }
	$('.table_div').html('Loading...');
 	var form = $('form#filter_form');  
	 if(err==0) { 	   
   ajax({ 
  	a:'leads',
  	b:form.serialize(),
  	c:function(){},
  	d:function(data){        
$('.table_div').html(data);
  
	 }});  	  
 }
}

function showAddEditForm(id) {
	paramData = {'act':'show_add_edit_leads','id':id};
	ajax({ 
		a:'leads',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		  $('.right_bar_div').html(data);			  
		}});	
}


function show_services_list() {
	
	paramData = {'act':'show_services_list'};
	ajax({ 
		a:'leads',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
			$('.page-title').html('Leads');


		  $('.table_div').html(data);			  
		}});	
}

 show_services_list();
function deleteServices(id) {
	if(confirm('Are you sure you want to delete this Lead?')) {
	paramData = {'act':'deleteService','id':id};
	ajax({ 
		a:'leads',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		  show_services_list();
var res = data.split("::");
alert(res[1]);		 
		}});	
} }


  function filterOption(value) {
	  $('#service_types').hide();
	$('#filter_text').hide();
	  var filter_type = $('#filter_type').val(); 
	 
	if(filter_type=='service_type') {  $('#service_types').show(); }
	if(filter_type=='service_name') {  $('#filter_text').show(); }
	
	$('#filter_textbox').val('');
	$('#filter_text_id').val('');
	$('#filter_text').val('');
	
	if(value=='filter') { searchLeads(); }
  }

 //searchForm();
/*function searchForm() {
	err=0;
 
	if($('#filter_type').val()=='' ){ err=1; $('#filter_type').css("border","1px solid #F58634 "); } else{  $('#filter_type').css("border","");}
	
	 var filter_type = $('#filter_type').val(); 
	 
	if(filter_type=='service_type') { 
            if($('#service_types').val()=='' ){ err=1; $('#service_types').css("border","1px solid #F58634 "); } else{  $('#service_types').css("border","");}
	}
	if(filter_type=='service_name') { if($('#filter_text').val()=='' ){ err=1; $('#filter_text').css("border","1px solid #F58634 "); } else{  $('#filter_text').css("border","");}   }
	
	
	var form = $('#filter_form');   
	if(err==0) {
	   ajax({ 
  	a:'leads',
  	b:form.serialize(),
  	c:function(){},
  	d:function(data){    
	$('.table_div').html(data);	
	 }}); 	
} } */
</script>
  
					
 <?php } include 'template.php'; ?>