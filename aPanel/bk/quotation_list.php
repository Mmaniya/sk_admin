<?php include 'includes.php';

$leadId = $_POST['lead_id'];
 
$param = array('tableName'=>TBL_LEADS,'fields'=>array('*'),'condition'=>array('id'=>$leadId.'-INT'));
$rsLeads = Table::getData($param);	
 ?>
<div style="background-color:#ffffff;padding:20px;overflow: scroll;">
<div class="form-group row">
   <label class="col-md-6 col-form-label">Quotation for : <?php echo $rsLeads->lead_fname.' '.$rsLeads->lead_lname; ?> </label>   
   <label class="col-md-6 col-form-label" style="text-align:right"><a href="javascript:void(0)" onclick="show_sendQuotation(<?php echo $rsLeads->id;?>)">Create Quotation</a> </label>   
</div> 
<table class="table table-bordered">
<thead>
<tr>
<td>#</td>
<td>Quotation ID</td>
<td>Subject</td>
<td>Date</td>
<td>Amount</td>
<td>Action</td>
</tr> 
</thead>

<tbody>
<?php $param = array('tableName'=>TBL_QUOTATION,'fields'=>array('*'),'orderby'=>'id','sortby'=>'desc','condition'=>array('lead_id'=>$leadId.'-INT'));
	$rsQuotation = Table::getData($param); 
	 if(count($rsQuotation)>0) {
	foreach($rsQuotation as $key=>$val) {		

	$param = array('tableName'=>TBL_USERS,'fields'=>array('*'),'condition'=>array('id'=>$val->sent_by.'-INT'));
	$rsUsers = Table::getData($param);

	?>
<tr>
<td><?php echo $key+1;?></td>
<td><?php echo customizeSerial($val->id);?>
<?php	 
  $quoteObj = new Quotation();
  $quoteObj->id = $val->id;
  $rsDtls = $quoteObj->isQuotationPaid();
 $isPaid=0;
  echo '<span id="inv_'.$val->id.'">';
  if($rsDtls->id>0){ $isPaid =1; echo '&nbsp;<i class="fas fa-check-circle text-success" style="font-size:18px"></i> <br>
  <strong>Inv Id : '.$rsDtls->id.'</strong>';  }
    echo '</span>';
 if($rsUsers->contact_fname!='') { ?> <br/> 
<small> Prepared by :<br/> <?php echo $rsUsers->contact_fname.''.$rsUsers->contact_lname; ?></small> <?php } ?>

</td>
<td><?php echo $val->subject;?></td>
<td><?php echo date('M d, Y',strtotime($val->sent_date));?></td>
<td><?php echo money($val->final_amount,'$');?></td>
<td><a href="javascript:void(0)" onclick="edit_quotation(<?php echo $val->id; ?>,<?php echo $val->lead_id; ?>)">[edit]</a> 
<a href="javascript:void(0)" onclick="generatepdf(<?php echo $val->id; ?>)">[pdf]</a><br/>
<a href="javascript:void(0)" onclick="view_quotation(<?php echo $val->id; ?>)">[view]</a>
<a href="javascript:void(0)" onclick="sendQuotation(<?php echo $val->id; ?>)">[send]</a>
<?php if($val->email_sent=='Y') { ?>
<i class="fa fa-check" aria-hidden="true" style="font-size:16px; font-weight:bold"></i>
<?php
}  
if($isPaid==0) {
?>
<a href="<?php echo CLIENT_URL; ?>payment.php?id=<?php echo $val->id; ?>" target="_blank">[pay]</a>
<a href="javascript:void(0)" onclick="showManualInvoice(<?php echo $val->id; ?>)">[manual invoice]</a>
<?php   if($rsDtls->id==0){  ?><br/> <a href="javascript:void(0)" onclick="deleteQuotation(<?php echo $val->id.','.$leadId; ?>)">[delete]</a><br/> <?php } ?>
<?php } ?>
 </td>
</tr>
	<?php } } else {  echo '<tr><td colspan="6" style="text-align:center">No Quotations</td></tr>';  } ?>
</tbody>
</table>
</div>



<div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			 
			<div class="modal-body" style="padding:0px;">
			<div class="body-div" style="padding:15px;">
            
            <div class="form-group row" style="background-color: #039cfd;color: #fff;margin:0px;" id="heading-title">
				
				</div> 
            <div class="row">
						<div class="col-md-12">
							 <div class="form-group row">
                         <div id="content_id"> Generating PDF....please wait</div>
                             </div>
                         </div>
                 </div>
             </div>
			</div>
			<div class="modal-footer">
				<button type="button"  class="btn btn-primary waves-effect" data-dismiss="modal">Close</button>
				 
			</div>
		</div>
	</div>
	</div><!-- /.modal -->
   
    
<script>

function deleteQuotation(quotation_id,lead_id) {  
	if(confirm('Are you sure want to delete this quotation?')) {
	paramData = {'act':'delete_quotation','quotation_id':quotation_id};
	ajax({ 
		a:'process',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		 alert(data);  show_quotations_lists(lead_id);		  
		}});	
} }

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

function showManualInvoice(id) {
	paramData = {'act':'show_manual_invoice_modal','id':id};
	ajax({ 
		a:'process',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		  $('.modal-popup').html(data); 
          $('#manual_invoice_modal').modal('show'); 		  
		}});	
}


function generatepdf(id) {
	 
	$('#con-close-modal').modal('show'); 		  
	paramData = {'act':'generatepdf','id':id};
	$('#heading-title').html('');
	$('#content_id').html(' Generating PDF....please wait');
	ajax({ 
		a:'process',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
			var dataArr = data.split(':::');
			$('#content_id').html(dataArr[1]);
		   $('#heading-title').html(dataArr[0]);
       
		}});		
	
}


function pay_quotation(id) {
	paramData = {'act':'payQuotation','id':id};
	ajax({ 
		a:'quotation',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		  $('.modal-popup').html(data); 
          $('#con-close-modal').modal('show'); 		  
		}});	
}

function sendQuotation(id) {
	paramData = {'act':'sendQuotation','id':id};
	ajax({ 
		a:'quotation',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		  $('.modal-popup').html(data); 
          $('#send-quotation-modal').modal('show');
		}});	
}

function edit_quotation(quotation_id,lead_id) {
	paramData = {'act':'edit_quotation','quotation_id':quotation_id,'lead_id':lead_id};
	ajax({ 
		a:'edit_quotation',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
			    $('.table_div').html(data);	
			   // $('.right_bar_div').html('');	
		}});	
}


	function view_quotation(id) {
	paramData = {'act':'view_quotation','id':id};
	ajax({ 
		a:'view_quotation',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
			    $('.right_bar_div').html(data);	
		}});	
}
</script>
