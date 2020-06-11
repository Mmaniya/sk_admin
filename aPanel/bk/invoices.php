 <?php 
 require("includes.php");
 function main() { 
   
   if($_POST['act']=='show_invoices_list') {
  ob_clean();
   $param = array('tableName'=>TBL_INVOICE,'fields'=>array('*'),'showSql'=>'N','orderby'=>'id','sortby'=>'desc','condition'=>array('is_deleted'=>'N-CHAR'));     
    $rsInvoices = Table::getData($param);	
  if($_POST['page']=='')	$page=1;	else	$page = $_POST['page'];
	$totalCount = count($rsInvoices);
	$totalPages= ceil(($totalCount)/(PAGE_LIMIT));
	if($totalPages==0) $totalPages=1;
	$StartIndex= ($page-1)*PAGE_LIMIT;
	if(count($rsInvoices)>0) $listingArr = array_slice($rsInvoices,$StartIndex,PAGE_LIMIT,true);	
    include 'invoices_list.php'; 	   
  exit();
   }
 
    if($_POST['act']=='view_assign_specialist') {
 ob_clean();
include 'view_invoice_specialist.php'; 	   
 exit();
   }
   
   if($_POST['act']=='assign_invoice_specialist') {
    ob_clean();
	 
	$param['specialist_id']=$_POST['specialist_id'];  
	$param['updated_date'] = date('Y-m-d H:i:s',time());		
	$param['updated_by']= $_SESSION['user_id'];  
	$where= array('id'=>$_POST['invoice_line_item_id']);
	echo  Table::updateData(array('tableName'=>TBL_INVOICE_LINE_ITEM,'fields'=>$param,'where'=>$where,'showSql'=>'N'));
   
   exit();
   }  
 
 if($_POST['act']=='show_questionnaire') {
	ob_clean();
	include 'view_questionnaire.php';
	exit(); 
 }
 
  if($_POST['act']=='show_invoice_payment_details') {
	ob_clean(); 
	 include 'invoice_payment_details.php';  
	exit(); 
 }
 
   if($_POST['act']=='show_dash_invoice_payment_details') {
	ob_clean(); 
	 include 'dash_invoice_payment_details.php';  
	exit(); 
 }
 
  
 if($_POST['act']=='edit_questionnaire') {
	ob_clean();  
	 include 'edit_questionnaire.php';
	exit(); 
 }
 
 
  if($_POST['act']=='showClientInvoice') {
	ob_clean();    
	 include 'view_client_invoice.php';
	exit(); 
 } 
 
 
 if($_POST['act']=='filter_invoices_list') {
	  ob_clean();
	  $filter_text_id = $_POST['filter_text_id'];
	  $filter_textbox = $_POST['filter_textbox'];
	  
	   if($_POST['filter_type']=='email') {
		$param = array('tableName'=>TBL_INVOICE,'fields'=>array('*'),'showSql'=>'N','condition'=>array('client_id'=>$filter_text_id.'-INT','is_deleted'=>'N-CHAR'));     
		$rsInvoices  = Table::getData($param);	
	    }
		
		if($_POST['filter_type']=='client_name') {
		$param = array('tableName'=>TBL_INVOICE,'fields'=>array('*'),'showSql'=>'N','condition'=>array('client_id'=>$filter_text_id.'-INT','is_deleted'=>'N-CHAR'));     
$rsInvoices  = Table::getData($param);			
	    }
		
		if($_POST['filter_type']=='invoice_id') {
		$param = array('tableName'=>TBL_INVOICE,'fields'=>array('*'),'showSql'=>'N','condition'=>array('id'=>$filter_textbox.'-INT','is_deleted'=>'N-CHAR'));  
$rsInv = Table::getData($param);
if(!empty($rsInv))
	$rsInvoices[0]=	$rsInv;	
	    }
		
		
		if($_POST['filter_type']=='services') {
		$param = array('tableName'=>TBL_INVOICE_LINE_ITEM,'fields'=>array('*'),'showSql'=>'N','condition'=>array('service_id'=>$filter_text_id.'-INT'));  
        $rsInvoiceLineItems = Table::getData($param);
	    foreach($rsInvoiceLineItems as $key=>$val) $invoicesArr[]=$val->invoice_id;
		$qry = 'select * from `'.TBL_INVOICE.'` where id in('.implode(',',$invoicesArr).') and is_deleted="N"';
		$rsInvoices = dB::mExecuteSql($qry);
	    }
		
		if($_POST['filter_type']=='filter')
		{
			$qry = 'select * from `'.TBL_INVOICE.'` where is_deleted="N" order by id desc';
			$rsInvoices = dB::mExecuteSql($qry);
		}
			 	
	    
  if($_POST['page']=='')	$page=1;	else	$page = $_POST['page'];
	$totalCount = count($rsInvoices);
	$totalPages= ceil(($totalCount)/(PAGE_LIMIT));
	if($totalPages==0) $totalPages=1;
	$StartIndex= ($page-1)*PAGE_LIMIT;
	if(count($rsInvoices)>0) $listingArr = array_slice($rsInvoices,$StartIndex,PAGE_LIMIT,true);
    include 'invoices_list.php'; 	   
  exit();
   }
 
 
  if($_POST['act']=='show_invoice_status') {
   ob_clean();
	include 'set_invoice_status.php';  
   exit();	  
  }
  
    if($_POST['act']=='show_client_questionnaire') {
   ob_clean();
	include 'set_invoice_status.php';  
   exit();	  
  }
 
 if($_POST['act']=='update_line_item_status') {
	 ob_clean();
	// $line_item_status;
	
	$param = array('tableName'=>TBL_INVOICE_LINE_ITEM,'fields'=>array('*'),'showSql'=>'N','condition'=>array('id'=>$_POST['line_item_id'].'-INT'));
	$rsInvLineItem = Table::getData($param);	
	
	$prevStatus = $rsInvLineItem->line_item_status;
	
	$param=array();
	$param['line_item_status'] = $_POST['line_item_status']; 
	$param['status_set_by'] =  $_SESSION['user_id'];  
	$param['status_reason'] = $_POST['comments']; 
	
	$param['updated_date'] = date('Y-m-d H:i:s',time());		
	$param['updated_by']= $_SESSION['user_id'];  
	$where= array('id'=>$_POST['line_item_id']);
	echo  Table::updateData(array('tableName'=>TBL_INVOICE_LINE_ITEM,'fields'=>$param,'where'=>$where,'showSql'=>'N'));
	
	$param=array();
	
	$param['line_item_id']= $_POST['line_item_id'];
	$param['previous_status']= $prevStatus;
	$param['new_status']=  $_POST['line_item_status']; 
	$param['status_set_by']=  $_SESSION['user_id']; 
	$param['status_set_date']= date('Y-m-d H:i:s',time());	
	$param['status_reason']= $_POST['comments'];
	
	$param['added_date'] = date('Y-m-d H:i:s',time());		
	$param['added_by']= $_SESSION['user_id'];  
	$rsDtls = Table::insertData(array('tableName'=>TBL_INVOICE_LINE_ITEM_STATUS,'fields'=>$param,'showSql'=>'N')); 
	ob_clean();
	echo getStatusStyle($_POST['line_item_status']);
	exit();
 }
 
 if($_POST['act']=='show_Client_questionnaire') {
	ob_clean();    
	$invoiceObj = new Invoice();
	$invoiceObj->invoice_line_item_id= $_POST['line_item_id'];
	$invoiceObj->invoice_id= $_POST['invoice_id'];
	$questionnaireDtls = $invoiceObj->getQuestionnaireDetails(); ?>
	 
	 <div style="padding-left:10px"><button type="button" class="btn btn-primary btn-sm waves-effect" onclick="showQuestionnaire(<?php echo $_POST['line_item_id']; ?>)">Edit Questionnaire</button> <a href="javascript:void(0)" onclick="backtoInvoicesDetls()" class="btn btn-danger btn-sm">Back</a></div><br>
	<div style="width:100%;" class="questionnaire_html"><?php  print_r($questionnaireDtls); ?></div>
	
 <div class="col-md-12"><br/>
 <button type="button" class="btn btn-primary btn-sm waves-effect" onclick="showQuestionnaire(<?php echo $_POST['line_item_id']; ?>)">Edit Questionnaire</button> <a href="javascript:void(0)" onclick="backtoInvoicesDetls()" class="btn btn-danger btn-sm">Back</a>
              </div>				  
<?php 	exit(); } ?>  


						<div class="row">
						<div class="col-sm-12">
							<div class="page-title-box">
								<h4 class="page-title">Invoices</h4>
								<ol class="breadcrumb float-right">
									<li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
									<li class="breadcrumb-item active activeBread" onclick="show_services_list()" style="cursor:pointer;">Invoices </li>
								
								</ol>
								<div class="clearfix"></div>
							</div>
						</div>
						</div>


                        <div class="row">
                            <div class="col-lg-9">
                                <div class="card-box" style="background-color:#FFF">
								<div class="row page_head_title"  id="search_form_div">
								<div class="col-lg-6"><h4 class="m-t-0 header-title">Invoice Details</h4></div>
								<div class="col-lg-6"></div>
                               
                                  
								   <div class="col-lg-12" style="padding:10px"> 
								<form id="filter_form" style="display:flex;">
								 <select style="padding:2px; margin-left:10px;" name="filter_type" id="filter_type" onchange="filterOption()">
								 <option value="filter">Filter</option>								 
								 <option value="client_name">Client Name</option>
								 <option value="email">Email</option>
								 <option value="invoice_id">Invoice ID</option>
								 <option value="services">Services</option>
								 </select>
								 
								  <input type="text" name="filter_textbox" id="filter_textbox" class="form-control" style="padding:2px; margin-left:10px; width:25%">
								 
								 <input type="hidden" name="filter_text_id" id="filter_text_id">
								 <input type="hidden" name="filter_text" id="filter_text">
								 <input type="hidden" name="act" value="filter_invoices_list">
								 <button type="button" onclick="searchInvoice()" class="btn btn-sm btn-primary" style="margin-left:10px;">Search</button>
								 
								 </form>
								 </div> 
								  </div>
								   <div class="view_invoices_div"></div>
								   <div class="table_div"><span style="color:#039CFD">Loading..</span></div>
								   <div class="preview_div"></div>
                              </div>  
                            </div>  
							
                            <div class="col-lg-3">

                               <span class="right_bar_div"></span>
                               
                               
                                <span class="library_div"></span>
 
                            </div>
                        </div> 
       <script src='assets/js/jquery.inputmask.bundle.js'></script>              
<script>   
<?php if(!isset($_REQUEST['invId'])) { ?>
   show_invoices_list();
<?php } else {	
	?>
	paramData = {'act':'showClientInvoice', 'invoice_id': '<?php echo $_REQUEST['invId'];?>'};
          ajax({ 
            a:'invoices',
            b:$.param(paramData),
            c:function(){},
            d:function(data){  
			 $('.view_invoices_div').show(); 			   
			 $('.view_invoices_div').html(data); 			   
			 $('#search_form_div').hide(); 			   
			 $('.table_div').hide(); 
			 <?php if($_REQUEST['item_id'] > 0) { ?>
				show_Client_questionnaire('<?php echo $_REQUEST['item_id'];?>','<?php echo $_REQUEST['invId'];?>')			   
			 <?php } ?>
            }});	    
<?php } ?>
function show_invoices_list() {
	paramData = {'act':'show_invoices_list'};	
	
	ajax({ 
		a:'invoices',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		  $('.table_div').html(data);	
		  <?php if($_REQUEST['invId'] > 0) { ?>		  
		  viewInvoices('<?php echo $_REQUEST['invId'];?>');		  
		  <?php } else if($_REQUEST['invoiceId'] > 0 && $_REQUEST['edit']==1) {?>
		  editInvoice('<?php echo $_REQUEST['invoiceId'];?>');
		  <?php } ?>
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
	searchInvoice();
	 
	 } 
});


function searchInvoice() {
	err=0;
	
	if($('#filter_type').val()=='' ){ err=1; $('#filter_type').css("border","1px solid #ff0000 "); } else{  $('#filter_type').css("border",""); }
 	var form = $('form#filter_form');  
	 if(err==0) { 	   
   ajax({ 
  	a:'invoices',
  	b:form.serialize(),
  	c:function(){},
  	d:function(data){        
$('.table_div').html(data);
  
	 }});  	  
 }
}


function show_invoice_status(invoice_item_id) {
	paramData = {'act':'show_invoice_status','id':invoice_item_id};
	ajax({ 
		a:'invoices',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		  $('.right_bar_div').html(data);			  
		}});	
}


function show_questionnaire(invoice_item_id,invoice_id) {
	paramData = {'act':'show_questionnaire','line_item_id':invoice_item_id,'invoice_id':invoice_id};
	ajax({ 
		a:'invoices',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		  $('.right_bar_div').html(data);	
		  $('#con-close-modal').modal('show');	
		}});	
}

function filterOption() {
	$('#filter_textbox').val('');
	$('#filter_text_id').val('');
	$('#filter_text').val('');
	
	
}

</script>
  
					
 <?php } 
 if($_SESSION['user_type']=='E' || $_SESSION['user_type']=='FL')
   include 'e_template.php';
 else
   include 'template.php'; ?>