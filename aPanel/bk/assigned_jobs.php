 <?php 
 function main() { 

 if($_POST['act']=='filter_invoices_list') {
	  ob_clean();
	  $filter_text_id = $_POST['filter_text_id'];
	  $filter_textbox = $_POST['filter_textbox'];
	  $filter_status = $_POST['filter_status'];
	  $filter_type = $_POST['filter_type'];
	  $param = array('tableName'=>TBL_INVOICE_LINE_ITEM,'fields'=>array('*'),'showSql'=>'N','condition'=>array('specialist_id'=>$_SESSION['user_id'].'-INT'));  
		$rsInvoiceLineItems = Table::getData($param); 
		foreach($rsInvoiceLineItems as $key=>$val) $invoicesArr[]=$val->invoice_id; 
		
		
	   if($_POST['filter_type']=='') {  	    
					
		$qry = 'select * from `'.TBL_INVOICE.'` where id in('.implode(',',$invoicesArr).')';
		$rsInvoices = dB::mExecuteSql($qry);
	 }		
		
		if($_POST['filter_type']=='client_id') {
		  $qry = 'select * from `'.TBL_INVOICE.'` where id in('.implode(',',$invoicesArr).') and client_id = '.$filter_text_id.'';
		$rsInvoices = dB::mExecuteSql($qry);		
	    }
		
		if($_POST['filter_type']=='client_name') {
		  $qry = 'select * from `'.TBL_INVOICE.'` where id in('.implode(',',$invoicesArr).') and client_id = '.$filter_text_id.'';
		$rsInvoices = dB::mExecuteSql($qry);		
	    }
		
		if($_POST['filter_type']=='email_address') {
		  $qry = 'select * from `'.TBL_INVOICE.'` where id in('.implode(',',$invoicesArr).') and client_id = '.$filter_text_id.'';
		$rsInvoices = dB::mExecuteSql($qry);		
	    }
		
		if($_POST['filter_type']=='invoice_id') { 			  
		 $qry = 'select * from `'.TBL_INVOICE.'` where id in('.implode(',',$invoicesArr).') and id = '.$filter_textbox.'';
		 $rsInv = dB::sExecuteSql($qry);
		 if(count($rsInv)==0) { echo 'No results'; exit();  }
		 $rsInvoices[0]=$rsInv;	
	    }
		  
 		if($_POST['filter_type']=='services') {
		$param = array('tableName'=>TBL_INVOICE_LINE_ITEM,'fields'=>array('*'),'showSql'=>'N','condition'=>array('specialist_id'=>$_SESSION['user_id'].'-INT','service_id'=>$filter_text_id.'-INT'));  
        $rsInvoiceLineItems = Table::getData($param); $invoicesArr=array();
	    foreach($rsInvoiceLineItems as $key=>$val) $invoicesArr[]=$val->invoice_id;
		$qry = 'select * from `'.TBL_INVOICE.'` where id in('.implode(',',$invoicesArr).')';
		$rsInvoices = dB::mExecuteSql($qry);
	    }
	   
		 
	 
		
		if($_POST['filter_type']=='status') { 
		
		$param = array('tableName'=>TBL_INVOICE_LINE_ITEM,'fields'=>array('*'),'showSql'=>'N','condition'=>array('line_item_status'=>$filter_status.'-CHAR','specialist_id'=>$_SESSION['user_id'].'-INT'));  
		$rsInvoiceLineItems = Table::getData($param); $invoicesArr=array();
		foreach($rsInvoiceLineItems as $key=>$val) $invoicesArr[]=$val->invoice_id;
		
		$qry = 'select * from `'.TBL_INVOICE.'` where id in('.implode(',',$invoicesArr).')';
		$rsInvoices = dB::mExecuteSql($qry);		
	    }
		  
		  
	    
  if($_POST['page']=='')	$page=1;	else	$page = $_POST['page'];
	$totalCount = count($rsInvoices);
	$totalPages= ceil(($totalCount)/(PAGE_LIMIT));
	if($totalPages==0) $totalPages=1;
	$StartIndex= ($page-1)*PAGE_LIMIT;
	if(count($rsInvoices)>0) $listingArr = array_slice($rsInvoices,$StartIndex,PAGE_LIMIT,true);
    include 'e_invoices_list.php'; 	   
  exit();
   }
 	 
 ?> 
             
        <div class="row">
        <div class="col-sm-12">
        <div class="page-title-box">
        <h4 class="page-title">Welcome  <?php echo $_SESSION['name']; ?>!</h4>
        <ol class="breadcrumb float-right">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
        <div class="clearfix"></div>
        </div>
        </div>
        </div>
        <div id="search_form_div">
        <div class="row">
        <div class="col-lg-12"><h4 id="stat_heading" class="pb-3">Assigned Jobs</h4></div></div>
        <div class="col-lg-12">
		<form id="filter_form">
		<div class="row">
		 <div class="col-xl-2 col-md-4">
		 
		<select class="form-control" name="filter_type" id="filter_type" onchange="showFilterOption(this.value)">
		<option value="">Filter by </option>
		<option value="services">Services</option>
		<option value="client_name">Client Name</option>
		<option value="invoice_id">Invoice Id</option>
		<option value="email_address">Email Address</option>
		<option value="status">Status</option>
		<option value="phase">Phase</option>
		<option value="">All Clients</option>
		</select> </div>
		
		<div class="col-xl-2 col-md-4" id="textbox_div" style="display:none">
		   <input type="text" class="form-control" name="filter_textbox" id="filter_textbox">
		</div>
		
		<div class="col-xl-2 col-md-4" id="status_div" style="display:none">
		<select class="form-control" name="filter_status" onchange="searchInvoices()">
		<option value="">Select Status</option>
		<option value="IP">In Progress</option>
		<option value="PQ">Pending Questionnaire</option>
		<option value="AWC">Awaiting Customer Reply</option>
		<option value="SP">Submitted for Process</option>
		<option value="D">Done</option>
		</select> </div> 
		<div class="col-xl-2 col-md-4">
		<input type="hidden" name="filter_text_id" id="filter_text_id">
		<input type="hidden" name="filter_text" id="filter_text">
		<input type="hidden" name="act" value="filter_invoices_list">
		<button class="btn btn-primary btn-sm" type="button" onclick="searchInvoices()">Submit</button>
		</div>
		
		</div>
		</form>
		</div>
        </div> 
        <div class="row pt-3">
        <div class="col-md-9 bg-white border table_div" id="table_div">
       
        </div>
		<div class="view_invoices_div col-md-9"></div>
         <div class="col-md-3 bg-white border right_bar_div" id="right_bar_div">
       
          <span class="library_div"></span> </div>
        </div>


<script> 
show_invoices_list();
function show_invoices_list() {
	paramData = {'act':'filter_invoices_list'};
	ajax({ 
		a:'assigned_jobs',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		  $('.table_div').html(data);			  
		}});	
}
 
 function showSendEmail(id,email_type,param_type) {

   if(param_type=='I') paramData = {'act':'showSendEmail','invoice_id':id,param_type:param_type,'email_type':email_type};
   if(param_type=='C') paramData = {'act':'showSendEmail','client_id':id,param_type:param_type,'email_type':email_type};
   if(param_type=='IS') paramData = {'act':'showSendEmail','installment_id':id,param_type:param_type,'email_type':email_type};
   if(param_type=='L') paramData = {'act':'showSendEmail','lead_id':id,param_type:param_type,'email_type':email_type};
   if(param_type=='IP') paramData = {'act':'showSendEmail','invoice_payment_id':id,param_type:param_type,'email_type':email_type}; //invoice payment

	ajax({ 
		a:'process',
		b:$.param(paramData), 
		c:function(){},
		d:function(data){ 		
		  $('.right_bar_div').html(data);	
          $('#con-close-modal').modal('show');		  
		}});	
} 
 
 
 $("#filter_textbox").autocomplete({ 	 
  source: function(request, response) {
  $.getJSON("e_search_details.php",{ filter_type: $('#filter_type').val(),'act':'clientAutocomplete','term':$('#filter_textbox').val() },response); },
  minLength: 2,
  select: function(event, ui){
  event.preventDefault();  
	$("#filter_textbox").val(ui.item.value);
	$("#filter_text_id").val(ui.item.id);
	$("#filter_text").val(ui.item.value);
	showInvoiceDetails(ui.item.id);
	 
	 } 
});


function showInvoiceDetails(filter_text_id) {  $('.table_div').html('<h4>Loading...</h4>'); 	
 
	if($('#filter_type').val()=='services') { paramData = {'act':'filter_invoices_list','filter_type':'services','filter_text_id':filter_text_id}; } else {
		paramData = {'act':'filter_invoices_list','filter_type':'client_id','filter_text_id':filter_text_id};
	}
	ajax({ 
		a:'assigned_jobs',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		$('.table_div').html(data); 
		 		
		}});	
}


function searchInvoices() {
	err=0; 	 
 	var form = $('form#filter_form');  
	 if(err==0) { 	   
   ajax({ 
  	a:'assigned_jobs',
  	b:form.serialize(),
  	c:function(){},
  	d:function(data){       
$('.table_div').html(data);
  
	 }});  	  
 }
}

function showFilterOption(type) {
	$('#textbox_div').hide(); $('#status_div').hide();
if(type=='services' || type=='client_name' || type=='invoice_id'|| type=='email_address' || type=='phase') { $('#textbox_div').show();  }	
if(type=='status') { $('#status_div').show(); }	

  $('#filter_textbox').val('');
  $('#filter_text_id').val('');
  $('#filter_text').val('');
  if(type=='') { searchInvoices(); }
 
} 
</script>                  
       
 <?php } include 'e_template.php'; ?>
 
  