<?php 
if(isset($_POST['client_id'])) { 
	$id=$clientId = $_POST['client_id'];
	  $qry = "SELECT * from `".TBL_CLIENTS."` where id= ".$clientId;
	$rsClient = dB::sExecuteSql($qry); 
	$templateId=$_REQUEST['templateId'];
}

$emailType = $_POST['email_type'];
$paramType  = $_POST['param_type'];

$toAddress = $rsClient->client_email;

?>
<script type="text/javascript" src="../ckeditor/ckeditor.js"></script> 
  <div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			 
			<div class="modal-body" style="padding:0px;">
            <form method="post" id="sendMail">
            <input type="hidden" name="act" value="sendEmail" /> 
            <input type="hidden" value="<?php echo $_POST['param_type'];?>" name="param_type">       
            <input type="hidden" value="<?php echo $clientId;?>" name="client_id">   
            <input type="hidden" value="<?php echo $templateId?$templateId:'8';?>" name="email_template_id">

			<div class="body-div" style="padding:15px;">
			
		 <div class="card">	 
		  <label class="card-header bg-primary text-white">Send Email    <a href="javascript:void(0)"  class="text-white float-right" data-dismiss="modal">Close</a></label>
			 <div class="card-body">			 
			  
			  <div class="row">
			 <div class="col-md-8"><label class="col-form-label text-blue">Email Address: </label> </div>
			 <div class="col-md-12">
			    <textarea class="form-control" name="to_email_address" id="to_email_address"><?php echo $toAddress;?></textarea>
				<p><small style="font-weight: 500;">You can Enter Multiple email address by comma separated</small></p>
				</div> 
			  </div>		                 
			  <?php
    $qry ="SELECT * from `".TBL_EMAIL_TEMPLATE."` WHERE id='".$templateId."'";
    $rsDtls = dB::sExecuteSql($qry);
        
    $email_subject= htmlspecialchars_decode(trim($rsDtls->email_subject));
    $email_body=htmlspecialchars_decode($rsDtls->email_body);	
    
              ?>			  
			  <section id="email_contents" style="">
				<div class="form-group row" id="email_sub_div" >                                           
					<div class="col-md-12"> <label class="col-form-label text-blue">Email Subject : </label>
						<input type="text" class="form-control" value="<?php echo $email_subject;?>" name="email_subject" id="email_subject">
					</div>
				</div>

				 <div class="form-group row" id="email_body_div">                                            
					<div class="col-md-12"><label class="col-form-label text-blue">Email Body : </label>
					  <textarea name="email_body" id="email_body" ><?php echo $email_body;?></textarea>
					</div>
				</div>

				<div class="form-group mb-0 justify-content-end row" id="email_btn_div">				  
					<div class="col-md-6">					 
					
						<button type="button" onclick="sendMail()"  class="btn btn-lg btn-success">Send </button>
						<?php if($_POST['templateId']=='5') { ?><button type="button" onclick="backToPayment('<?php echo $_POST['invoice_id'];?>')"  class="btn btn-lg btn-warning">Back </button>
						<input type="hidden" name="invoice_id" id="invoice_id" value="<?php echo $_POST['invoice_id'];?>">
						<input type="hidden" name="installment_id" id="installment_id" value="<?php echo $_POST['installment_id'];?>">
						<input type="hidden" name="templateId" id="templateId" value="<?php echo $_POST['templateId'];?>">
						<?php } ?>
					</div>  
					<div class="col-md-6">					
					<button type="button"  class="btn btn-primary waves-effect float-right" data-dismiss="modal">Close</button>	</div>
				</div>
                </section>
			  
			</div>
			 
		</div>
	  </div>
      </form>
    </div> 
   </div> 
   </div> 
 </div> 
	
	<script>
	var editor = CKEDITOR.replace('email_body');
 CKEDITOR.editorConfig = function( config ) {
	    config.toolbarGroups = [
		 { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
	];
};


function sendMail() {
 //	var emailBody =CKEDITOR.instances.email_body.getData();
 //editor.getData();
	for (instance in CKEDITOR.instances) {
    CKEDITOR.instances[instance].updateElement();
}
	var form = $('form#sendMail');  
	
	ajax({ 
		a:'process',
		b:form.serialize(),
		c:function(){},
		d:function(data){ 		
		alert(data);

		}});	
	
}

function backToPayment(invId)
{
	paramData = {'act':'show_invoice_payment_details','invoice_id':invId};
          ajax({ 
            a:'invoices',
            b:$.param(paramData),
            c:function(){},
            d:function(data){   
			  $('.modal-backdrop').remove();	
			  $('.right_bar_div').html(data);
			  $('#con-close-modal').modal('show');
			  $('.due_payment_details').show();
			  $('.paid_payment_details').hide();
            }});	    
}
</script>