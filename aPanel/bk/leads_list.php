<?php 

$prev=$next=$last=$first='&nbsp;';

if($page > 1)
	$first = "<img src='assets/images/first_page.png' style='cursor:pointer; margin-top:3px;' border='0'  onclick='ShowListPagination(\"1\",\"".$filter_by."\")'/>";
	
	if($page < $totalPages)
	$last = "<img src='assets/images/last_page.png' style='cursor:pointer; margin-top:3px;' border='0' onclick='ShowListPagination(\"$totalPages\",\"".$filter_by."\")'/>";
	if(count($rsLeads)>0 && $totalPages > 1){
	if($page > 1){
		$pageNo = $page - 1;
		$prev = "<img src='assets/images/prev_page.png' style='cursor:pointer; margin-top:3px;' border='0' onclick='ShowListPagination(\"".$pageNo."\",\"".$filter_by."\")'/>";
	} 
		
	if ($page < $totalPages){
		$pageNo = $page + 1;
		$next = " <img src='assets/images/next_page.png' style='cursor:pointer; margin-top:3px;' border='0' onclick='ShowListPagination(\"".$pageNo."\",\"".$filter_by."\")'/>";
	} 
	
	if($pageNo=='')
		$pageNo=1;
	if($totalPages>1) {
	$pagebox="<td style='border:0;'><input type='text' name='page' id='page' value='".$page."' onchange='ShowListPagination(this.value,\"".$filter_by."\")' style='border: 1px solid rgb(170, 170, 170); text-align: center; width: 25px; height: 15px; vertical-align: middle;' size='4'> of $totalPages</td>";
	}	

	$table_val = "<table class='' width='100%;padding:10px' cellpadding='5' cellspacing='0' border='0' style='border:0;><tr style='background-color:#fff'><td align='center' style='border:1; font-size:14px; vertical-align:middle; color:#000; padding:10px;'></td><td align='right'><table align='right' cellpadding='0' cellspacing='1'><tr style='background-color:#fff'><td style='padding:10px 12px;'>$first</td><td style='padding:10px 6px;'> $prev </td>$pagebox<td style='padding:10px 2px;'>$next </td><td style='padding:10px 12px;'>$last</td></tr></table></td></tr></table>";
}  
    $packageObj = new Packages; 
	$categoryObj = new ServiceCategory(); 
?>



<div class="col-md-12"><hr></div>
<div class="row bg-primary text-white">
<div class="col-md-1 p-2 d-none d-sm-block">#</div>
<div class="col-md-2 p-2 d-none d-sm-block">Enquiry Date</div>
<div class="col-md-3 p-2 d-none d-sm-block">Name</div>
<div class="col-md-4 p-2 d-none d-sm-block">Enquiry</div>
<div class="col-md-2 p-2 d-none d-sm-block">Action</div>
</div> 
 <?php   
	  if(count($listingArr)>0) {
	   foreach($listingArr as $key=>$val) {
  
   $categoryObj->category_id= $val->lead_enquiry_for;
   $enquiryFor = $categoryObj->getCategoryByIds();
   $enquiryType='';
   $otherEnquiryType='';
   if($val->lead_enquiry_type=='E') { $enquiryType = '<i class="fa fa-envelope" aria-hidden="true"></i> &nbsp;'; }
   if($val->lead_enquiry_type=='C') { $enquiryType = '<i class="fa fa-phone" aria-hidden="true"></i> &nbsp;'; }
   if($val->lead_enquiry_type=='Other') { $otherEnquiryType ='Enquiry by - '.$val->other_enquiry_type.'<br/>';  }
   
   $warning='';$warningClass='';
   if($val->quotation_sent=='N') {
   $currentTime = time();  
   $leadDate = strtotime($val->lead_added_date);
   $datediff = $currentTime - $leadDate;
   $days =  round($datediff / (60 * 60 * 24));
   if($days>3) { $warning = '<br/><span class="warning"><i class="fa fa-exclamation-triangle" aria-hidden="true" style="color:#ff0000;"></i> </span>'; 
                 //$warningClass = 'warning_row';
   }
   }
   
   $companyName='';
   
   if($val->lead_company_name!='') { $companyName = '<strong>'.$val->lead_company_name.'</strong> <br/>';   }
   
   
		   ?>
<div class="row tb_row <?php echo $warningClass; ?>">
<div class="col-md-1 d-none d-sm-block col-1 row-border text-center"><?php echo $key+1;  echo $warning; ?></div>

<div class="col-md-2 d-none d-sm-block row-border">
  <strong><?php echo date('M d, Y',strtotime($val->lead_added_date));   ?></strong>
 </div>
 
<div class="col-md-3 row-border"> 
<?php echo $companyName.$enquiryType.' '.$val->lead_fname.' '.$val->lead_lname; ?><br/> <?php echo $otherEnquiryType; ?>
<a href="tel:<?php echo $val->lead_phone;?>"><?php echo formatPhoneNumber($val->lead_phone);?> </a><br/>
<a href="mailto:<?php echo $val->lead_email;?>"><?php echo $val->lead_email; ?></a>
<br/><a href="javascript:void(0)"  onclick="showAddEditLeadAddressForm(<?php echo $val->id; ?>)">[Add Address]</a><br/><a href="javascript:void(0)"  onclick="showAddEditLeadEmailForm(<?php echo $val->id; ?>)">[Add Email Address]</a>
<button type="button" class="btn btn-primary mobile-device" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo $val->lead_enquiry_desc; ?>" style="float:right;"><i class="fa fa-eye"></i></button>  							
</div>
 
 
<div class="col-md-4 row-border"> 
 <?php if(count($enquiryFor)>0) {  	
            foreach($enquiryFor as $K=>$V) {	
			
 $param = array('tableName'=>TBL_LEAD_SPECIALIST,'fields'=>array('*'),'showSql'=>'N','condition'=>array('lead_id'=>$val->id.'-INT','service_category_id'=>$V->id.'-INT'));
$rsLeadSpec = Table::getData($param); 
 foreach($rsLeadSpec as $K1=>$V1)  
 if(count($rsLeadSpec)>0) {
		$param = array('tableName'=>TBL_USERS,'fields'=>array('*'),'showSql'=>'N','condition'=>array('id'=>$V1->user_id.'-INT'));
		$rsUsers = Table::getData($param); }    $random =rand(); ?>
 <div class="row">
     <div class="col-md-6 row-border p-1 pt-2"><?php echo $V->category_name; ?></div>
     <div class="col-md-6 row-border p-1 pt-2"><a href="javascript:void(0)">
	<span class="assignresponse_<?php echo $random;?>"> <?php if(count($rsLeadSpec)>0) { echo $rsUsers->contact_fname.' '.$rsUsers->contact_lname; ?>  </span>  
	 <small>
     <a style="cursor:pointer" class="assignresponse_show_<?php echo $random;?>" onclick="assignSpecialist(<?php echo $val->id.','.$random; ?>)">[change] </a>
     
     </small>	 
	 <?php  } else {   ?>
	  <small><a style="cursor:pointer" class="assignresponse_change_<?php echo $random;?>" onclick="assignSpecialist(<?php echo $val->id.','.$random; ?>)">[assign specialist]</a></small>
	 <?php } ?>
	 </a></div> 	     
 </div>	
 <?php } } 
 
	$packageObj->package_id= $val->packages_id;
	  $rsPackages = $packageObj->getPackagesByIds();
	  if(count($rsPackages)>0) {
		echo  ''; 	
	  foreach($rsPackages as $K1=>$V1) { 
	   $param = array('tableName'=>TBL_LEAD_SPECIALIST,'fields'=>array('*'),'showSql'=>'N','condition'=>array('lead_id'=>$val->id.'-INT','service_category_id'=>$V1->id.'-INT'));
		$rsLeadSpec = Table::getData($param); 
		foreach($rsLeadSpec as $K1=>$V1)  
		if(count($rsLeadSpec)>0) {
		$param = array('tableName'=>TBL_USERS,'fields'=>array('*'),'showSql'=>'N','condition'=>array('id'=>$V1->user_id.'-INT'));
		$rsUsers = Table::getData($param); } $random =rand(); 
	  ?>		  
		<div class="row">
		<div class="col-md-6 row-border p-1 pt-2"><?php echo $V1->package_name; ?></div>
		<div class="col-md-6 row-border p-1 pt-2">
		<span class="assignresponse_<?php echo $random;?>"> <?php if(count($rsLeadSpec)>0) { echo $rsUsers->contact_fname.' '.$rsUsers->contact_lname; ?>  </span> 
	 <small><a href="javascript:void(0)" class="assignresponse_show_<?php echo $random;?>" onclick="assignSpecialist(<?php echo $val->id.','.$random; ?>)">[change]</a></small>	 
	 <?php  } else {   ?>
		<small><a href="javascript:void(0)" class="assignresponse_change_<?php echo $random;?>" onclick="assignSpecialist(<?php echo $val->id.','.$random; ?>)">[assign specialist]</a></small>
		 <?php } ?>
		</div> 	     
		</div>			  
	 <?php  }  } ?>  
 </div>

 <div class="col-md-2 action_col  row-border"> 
	            <a href="javascript:void(0)" onclick="showAddEditForm(<?php echo $val->id; ?>)" title="Edit Client"><i class="fa fa-edit" style="font-size:24px;" aria-hidden="true"></i></a>  
				<!--<a href="javascript:void(0)" onclick="deleteServices(<?php echo $val->id; ?>)">[delete]</a>-->
				<!--<a href="javascript:void(0)" onclick="view_lead(<?php echo $val->id; ?>)">[view]</a>--> &nbsp;
				<a href="javascript:void(0)" onclick="showSendEmail(<?php echo $val->id;?>,'all','L')" title="Send Email"><i class="fa fa-envelope" style="font-size:24px;" aria-hidden="true"></i></a> &nbsp;				
				<a href="javascript:void(0)" onclick="sms_lead(<?php echo $val->id; ?>)" title="Send SMS"><i class="fas fa-sms text-success" style="font-size:24px;"></i></a>
				
				<?php $param = array('tableName'=>TBL_QUOTATION,'fields'=>array('*'),'showSql'=>'N','condition'=>array('lead_id'=>$val->id.'-INT'));
				$rsQuotation = Table::getData($param);
				if(count($rsQuotation)>0) { ?>		
				<a href="javascript:void(0)" onclick="show_quotations_lists(<?php echo $val->id; ?>)" title="Quotations"><i class="fa fa-list-alt text-warning" style="font-size:24px;" ></i></a> 
				<?php } else { ?>
				<br/><a href="javascript:void(0)" onclick="show_sendQuotation(<?php echo $val->id; ?>)">[create quotation]</a> <?php }  ?>
                <!--<a href="javascript:void(0)" onclick="view_quotation(<?php echo $V->id; ?>)">[view quotation]</a> --> 
                 <a href="javascript:void(0)" title="Log"><i class="fa fa-history"  style="font-size:24px;" aria-hidden="true"></i></a> 
 </div>
	 
	</div>
	 <?php } } else { ?>
	 <div class="col-md-12">No record found</div> <?php } ?>
	 <div class="col-md-12"><?php  if($table_val!='') { echo  $table_val; } ?></div>
	 
<style> 
.row-border:nth-of-type(odd){ border:1px solid #efefef;}
.row-border:nth-of-type(even){border:1px solid #efefef;}  
 
.tb_row { padding:0px; border-bottom: 1px solid #0000002b; padding-top: 10px;}
 .tb_row:nth-child(odd) {background-color: rgba(0, 0, 0, 0.03);} 

 .warning_row .col-1 { background-color:#ff0000; color:#fff; }
.warning { font-size: 25px; color: #fff; }

.action_col { font-size:14px; }
.list-services { list-style: none; padding-left:0px; color:#008000; }
.list-services li:before { content: '✓';     padding-right: 5px; }
.mobile-device { display:none; }
@media screen and (max-width: 768px) { .mobile-device { display:block; } 
.warning_row { background-color:#ff0000 !important; color:#fff;     border-top: 2px solid #fff;}
.warning_row a {  color:#fff !important; }
  .warning_row .list-services { color:#fff !important; }
 
}


 
</style>
	 
 <script>
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip(); 
});
 
 function showSendEmail(id,email_type,param_type) {

   if(param_type=='I') paramData = {'act':'showSendEmail','invoice_id':id,param_type:param_type,'email_type':email_type};
   if(param_type=='C') paramData = {'act':'showSendEmail','client_id':id,param_type:param_type,'email_type':email_type};
   if(param_type=='IS') paramData = {'act':'showSendEmail','installment_id':id,param_type:param_type,'email_type':email_type};
   if(param_type=='L') paramData = {'act':'showSendEmail','lead_id':id,param_type:param_type,'email_type':email_type};
   if(param_type=='IP') paramData = {'act':'showSendEmail','invoice_payment_id':id,param_type:param_type,'email_type':email_type}; //invoice payment
     $('.modal-popup').html('');
     ajax({
		a:'process',
		b:$.param(paramData), 
		c:function(){},
		d:function(data){ 		
		  $('.right_bar_div').html(data);	
          $('#con-close-modal').modal('show');		  
		}});	
}


function showAddEditLeadAddressForm(id) {
	paramData = {'act':'add_edit_lead_address','id':id};
    $('.right_bar_div').html('');
	ajax({ 
		a:'process',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		//  $('.right_bar_div').html(data);		
			$('.modal-popup').html(data); 
			$('#con-close-modal').modal('show'); 		  
		}});	
}

function showAddEditLeadEmailForm(id) {
    paramData = {'act':'add_edit_lead_email','id':id};
    ajax({
        a:'process',
        b:$.param(paramData),
        c:function(){},
        d:function(data){
            //  $('.right_bar_div').html(data);
            $('.modal-popup').html(data);
            $('#con-close-modal').modal('show');
        }});
}

function show_quotations_lists(lead_id) {
	paramData = {'act':'show_quotations_list','lead_id':lead_id};
	ajax({ 
		a:'quotation_list',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		  $('.right_bar_div').html(data);			  
		  		  
		}});	
}



function show_sendQuotation(id) {
	paramData = {'act':'show_send_quotation_form','lead_id':id};
	ajax({ 
		a:'leads',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		  $('.table_div').html(data);			  
		 // $('.right_bar_div').html('');			  
		}});	
}
function sms_lead(id) {
	
	paramData = {'lead_id':id,'type':'lead'};
	ajax({ 
		a:'send_sms',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		
			$('.right_bar_div').html(data);	
		  $('#con-close-modal').modal('show'); 		   
		}});	
}

    function view_lead(id) {
		paramData = {'act':'view_lead_details','id':id};
	ajax({ 
		a:'leads',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		    $('.table_div').html(data);			  
		 // $('.right_bar_div').html(data);			  
		}});	 		
	}


   function ShowListPagination(page) { 
	 paramData = {'act':'show_services_list','page':page,}
	ajax({ 
		a:'leads',
		b:$.param(paramData),
		c:function(){},
		d:function(data){  
		  $('.table_div').html(data);		
		}});	
	}
	
	function assignSpecialist(id,randonId) {
	paramData = {'act':'view_assign_specialist','id':id,'randon_id':randonId};
	ajax({ 
		a:'leads',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
			$('.modal-popup').html(data); 
			$('#con-close-modal').modal('show'); 	  
		}});	
}


	</script>

