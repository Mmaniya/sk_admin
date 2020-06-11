 <?php 
 function main() { 
   
 if($_POST['act']=='submitClientsDtls') {  
 ob_clean(); 
 $params = array('client_company_name','client_fname','client_lname','client_email','client_cc_email','client_phone','client_address','client_city','client_state');
 foreach($params as $K=>$V) {  $param[$V]=$$V=check_input($_POST[$V]); } 
  
 
 if($_POST['id']=='') {
    $param['client_added_date'] = date('Y-m-d H:i:s',time());		
	$param['client_added_by']= $_SESSION['user_id'];  
	echo $rsDtls = Table::insertData(array('tableName'=>TBL_CLIENTS,'fields'=>$param,'showSql'=>'N')); 
	$explode = explode('::',$rsDtls);  $clientId = $explode[2];
 }
	else { 
 $param['last_updated_date'] = date('Y-m-d H:i:s',time());		
 $param['last_updated_by']= $_SESSION['user_id'];  
 $where= array('id'=>$_POST['id']);
 echo  Table::updateData(array('tableName'=>TBL_CLIENTS,'fields'=>$param,'where'=>$where,'showSql'=>'N'));
		 
	}
	exit();
 }
 
 
  if($_POST['act']=='showAddEditClients') {  
  ob_clean();
  include 'add_edit_clients.php';
  exit();  
  }
 
 
 if($_POST['act']=='filter_clients_list') {
	  ob_clean();
	  $filter_text_id = $_POST['filter_text_id'];
	  $filter_textbox = $_POST['filter_textbox'];
	  $filter_type = $_POST['filter_type'];
	  
	   if($_POST['filter_type']=='show_all_clients') {
	   $param = array('tableName'=>TBL_CLIENTS,'fields'=>array('*'),'showSql'=>'N','orderby'=>'id','sortby'=>'desc','condition'=>array('status'=>'A-CHAR'));     
       $rsClients = Table::getData($param);	
	   }
	   if($_POST['filter_type']=='client_id') {
		$param = array('tableName'=>TBL_CLIENTS,'fields'=>array('*'),'showSql'=>'N','condition'=>array('id'=>$filter_text_id.'-INT','status'=>'A-CHAR'));     
		$rsClients[0]  = Table::getData($param);	
	    }
		
	  
	   if($_POST['filter_type']=='email') {
		$param = array('tableName'=>TBL_CLIENTS,'fields'=>array('*'),'showSql'=>'N','condition'=>array('client_email'=>$filter_textbox.'-CHAR','status'=>'A-CHAR'));     
		$rsClients  = Table::getData($param);	
	    }
		
		if($_POST['filter_type']=='client_name') {
		$param = array('tableName'=>TBL_CLIENTS,'fields'=>array('*'),'showSql'=>'N','condition'=>array('f_name'=>$filter_textbox.'-STRING','status'=>'A-CHAR'));     
        $rsClients = Table::getData($param);	

        $qry = 'select * from `'.TBL_CLIENTS.'` where  client_fname like "%'.$filter_textbox.'%" or client_lname like "%'.$filter_textbox.'%" and status ="A"';
		$rsClients = dB::mExecuteSql($qry);		
	    }
	  
	    
  if($_POST['page']=='')	$page=1;	else	$page = $_POST['page'];
	$totalCount = count($rsClients);
	$totalPages= ceil(($totalCount)/(PAGE_LIMIT)); 
	if($totalPages==0) $totalPages=1;
	$StartIndex= ($page-1)*PAGE_LIMIT;  
	if(count($rsClients)>0) $listingArr = array_slice($rsClients,$StartIndex,PAGE_LIMIT,true);
    include 'clients_list.php'; 	   
  exit();
   }
 
 
		 
 
 ?>  

						<div class="row">
						<div class="col-sm-12">
							<div class="page-title-box">
								<h4 class="page-title">Cllients</h4>
								<ol class="breadcrumb float-right">
									<li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
									<li class="breadcrumb-item active activeBread" style="cursor:pointer;">Clients </li>
								
								</ol>
								<div class="clearfix"></div>
							</div>
						</div>
						</div>


                        <div class="row">
                            <div class="col-lg-7">
                                <div class="card-box" style="background-color:#FFF">
								<div class="row page_head_title">
								<div class="col-lg-6"><h4 class="m-t-0 header-title">Client Details</h4></div>
								<div class="col-lg-6"></div>
								   </div>
                                  
								   <div class="col-lg-12" style="padding:10px"> 
								<form id="filter_form" style="display:flex;">
								 <select style="padding:2px; margin-left:10px;" name="filter_type" id="filter_type" onchange="filterOption(this.value)">
								 <option value="show_all_clients">Filter</option>								 
								 <option value="client_name">Client Name</option>
								 <option value="email">Email</option>
								 <option value="show_all_clients">All Clients</option>
								 </select>
								 
								  <input type="text" name="filter_textbox" id="filter_textbox" class="form-control" style="padding:2px; margin-left:10px; width:25%">
								 
								 <input type="hidden" name="filter_text_id" id="filter_text_id">
								 <input type="hidden" name="filter_text" id="filter_text">
								 <input type="hidden" name="act" value="filter_clients_list">
								 <button type="button" onclick="searchClients()" class="btn btn-sm btn-primary" style="margin-left:10px;">Search</button>
								 
								 </form>
								 </div> 
								 
								   <div class="table_div"></div>
								   <div class="preview_div"></div>
                              </div>  
                            </div>  
							
                            <div class="col-lg-5"> 
                               <span class="right_bar_div"></span>
                               <span class="library_div"></span> 
                            </div>
                        </div> 
       <script src='assets/js/jquery.inputmask.bundle.js'></script>              
<script>   

show_clients_list();
function show_clients_list() { $('.table_div').html('<h4 class="text-center;">Loading....</h4>');		
	paramData = {'act':'filter_clients_list','filter_type':'show_all_clients'};
	ajax({ 
		a:'clients',
		b:$.param(paramData),
		c:function(){},
		d:function(data){ 
		  $('.table_div').html(data);			  
		}});	
}

 var filter_type = $('#filter_type').val();
 $("#filter_textbox").autocomplete({ 	 
  source: function(request, response) {
  $.getJSON("search_details.php",{ filter_type: $('#filter_type').val(),'act':'invoiceAutocomplete','term':$('#filter_textbox').val() },response); },
  minLength: 2,
  select: function(event, ui){
  event.preventDefault();  
	$("#filter_textbox").val(ui.item.value);
	$("#filter_text_id").val(ui.item.id);
	$("#filter_text").val(ui.item.value);
	showClientDetails(ui.item.id);
	 
	 } 
});


function showClientDetails(client_id) { 	
	paramData = {'act':'filter_clients_list','filter_type':'client_id','filter_text_id':client_id};
	ajax({ 
		a:'clients',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		$('.table_div').html(data); 
		 		
		}});	
}



function searchClients() {
	err=0;
	
	if($('#filter_type').val()=='' ){ err=1; $('#filter_type').css("border","1px solid #ff0000 "); } else{  $('#filter_type').css("border",""); }
 	var form = $('form#filter_form');  
	 if(err==0) { 	   
   ajax({ 
  	a:'clients',
  	b:form.serialize(),
  	c:function(){},
  	d:function(data){        
$('.table_div').html(data);
  
	 }});  	  
 }
}
 

function filterOption(type) {
	$('#filter_textbox').val('');
	$('#filter_text_id').val('');
	$('#filter_text').val('');  
if(type=='show_all_clients') { show_clients_list();}	
}
</script>
  
					
 <?php } include 'template.php'; ?>