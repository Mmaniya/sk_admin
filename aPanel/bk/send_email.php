<?php 
 
if(isset($_POST['invoice_id'])) {  
	$id=$invoiceId = $_POST['invoice_id'];
	$invoiceObj = new Invoice();
	$invoiceObj->invoice_id = $invoiceId;
	$invoiceDtls = $invoiceObj->getInvoiceDetails();
	$clientId = $invoiceDtls->client_id;
	$qry = "SELECT * from `".TBL_CLIENTS."` where id= ".$invoiceDtls->client_id;
	$rsClient = dB::sExecuteSql($qry);
}
if(isset($_POST['client_id'])) { 
	$id=$clientId = $_POST['client_id'];
	  $qry = "SELECT * from `".TBL_CLIENTS."` where id= ".$clientId;
	$rsClient = dB::sExecuteSql($qry); 
}

if(isset($_POST['lead_id'])) { 
	$id=$leadId = $_POST['lead_id'];
	$qry = "SELECT * from `".TBL_LEADS."` where id= ".$leadId;
    $rsLead = dB::sExecuteSql($qry);
}
if(isset($_POST['invoice_payment_id'])) { 
	$id=$invoicePaymentId = $_POST['invoice_payment_id'];
	//$qry = "SELECT * from `".TBL_CLIENTS."` where id= ".$clientId;
	//$rsClient = dB::sExecuteSql($qry);
}

if(isset($_POST['installment_id'])){ 
    $id=$installmentId = $_POST['installment_id'];
	$qry = "SELECT * from `".TBL_INVOICE_INSTALLMENT."` where id= ".$installmentId;
	$rsInstallment = dB::sExecuteSql($qry);
	$invoiceObj = new Invoice();
	$invoiceId = $invoiceObj->invoice_id = $rsInstallment->invoice_id;
	$invoiceDtls = $invoiceObj->getInvoiceDetails();
	$clientId = $rsInstallment->client_id;
	$qry = "SELECT * from `".TBL_CLIENTS."` where id= ".$rsInstallment->client_id;
	$rsClient = dB::sExecuteSql($qry);
}

$emailType = $_POST['email_type'];
$paramType  = $_POST['param_type'];

if($paramType=='IS' || $paramType=='I' || $paramType=='C' || $paramType=='IP') {
	   $toAddress = $rsClient->client_email;
       if($rsClient->client_cc_email!='')
       {
           $ccEmailsArr=explode(",",$rsClient->client_cc_email);
           foreach($ccEmailsArr as $EK => $EV)
           {
               if(trim($EV)!='')
                   $ccEmails[]=trim($EV);
           }
       }
	}
	
	if($paramType=='L') {
		$toAddress = $rsLead->lead_email;

        if($rsLead->lead_cc_email!='')
        {
            $ccLEmailsArr=explode(",",$rsLead->lead_cc_email);
            foreach($ccLEmailsArr as $EK => $EV)
            {
                if(trim($EV)!='')
                    $ccLEmails[]=trim($EV);
            }
        }
	}

    if(count($ccLEmails) > 0)
        $ccEmails=$ccLEmails;
?>
<script type="text/javascript" src="../ckeditor/ckeditor.js"></script> 
  <div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			 
			<div class="modal-body" style="padding:0px;"> 			
            <form method="post" id="sendMail">
            <input type="hidden" name="act" id="email_act" value="sendEmail" />
            <input type="hidden" value="<?php echo $_POST['param_type'];?>" name="param_type">
            <input type="hidden" value="<?php echo $invoiceId;?>" name="invoice_id">
            <input type="hidden" value="<?php echo $clientId;?>" name="client_id">
            <input type="hidden" value="<?php echo $installmentId;?>" name="installment_id">
            <input type="hidden" value="<?php echo $leadId;?>" name="lead_id">
            <input type="hidden" value="<?php echo $invoicePaymentId;?>" name="invoice_payment_id">
                <input type="hidden" value="<?php echo $_POST['line_item_id'];?>" name="invoice_line_item_id">
			<div class="body-div" style="padding:15px;">
			
		 <div class="card">	 
		  <label class="card-header bg-primary text-white">Send Email    <a href="javascript:void(0)"  class="text-white float-right" data-dismiss="modal">Close</a></label>
			 <div class="card-body">			 
			  
			    <div class="row">
				   <div class="col-md-4">
              <div class="row">
			 <div class="col-md-8"><label class="col-form-label text-blue">Email Address: </label> </div>
			 <div class="col-md-12">
			    <textarea class="form-control" name="to_email_address" id="to_email_address"><?php echo $toAddress;?></textarea>
				<p><small style="font-weight: 500;">You can Enter Multiple email address by comma separated</small></p>
				</div> 
			  </div>

                 <div class="row">
                     <div class="col-md-8"><label class="col-form-label text-blue">CC Email Address: </label> </div>
                     <div class="col-md-12">
                         <textarea class="form-control" name="cc_email_address" id="cc_email_address"><?php echo count($ccEmails) > 0?implode(",",$ccEmails):'';?></textarea>
                         <p><small style="font-weight: 500;">You can Enter Multiple email address by comma separated</small></p>
                     </div>
                 </div>
			  
                <div class="form-group row">                                           
				<div class="col-md-3"><span style="font-weight: 500;"> Choose Language:</span>   </div> 
                    	<div class="col-md-9"><input type="radio" value="EN" name="language" checked="checked" /> English &nbsp;&nbsp;
                        <input type="radio" value="SP" name="language" /> Spanish </div> 
                    </div>
					
					
			  
			  <div class="form-group row">                                           
					<div class="col-md-12"> 
                    
                    <label class="col-form-label text-blue">Choose Email Template : </label>
						<select name="email_template_id" id="email_template_id" class="form-control" onchange="showMailContent(this.value)">
						  <option>select</option>
						  <?php
						  $condition = array('email_type'=>$emailType.'-CHAR','status'=>'A-CHAR');
						  if($emailType=='all') {  $condition = array('status'=>'A-CHAR');  }
						  
	 $param = array('tableName'=>TBL_EMAIL_TEMPLATE,'fields'=>array('*'),'showSql'=>'N','orderby'=>'template_name','sortby'=>'asc','condition'=>$condition);
					$rsEmailTemplate = Table::getData($param);
              if(count($rsEmailTemplate)>0) {
				  foreach($rsEmailTemplate as $key=>$val) {
					echo '<option value='.$val->id.'>'.$val->template_name.'</option>';
			    } } ?>
						</select>
					</div>
				</div>

				   </div>
				   <div class="col-md-8">
 <section id="email_contents" style="display:none">
				<div class="form-group row" id="email_sub_div" >                                           
					<div class="col-md-12"> <label class="col-form-label text-blue">Email Subject : </label>
						<input type="text" class="form-control" name="email_subject" id="email_subject">
					</div>
				</div>

				 <div class="form-group row" id="email_body_div">                                            
					<div class="col-md-12"><label class="col-form-label text-blue">Email Body : </label>
					  <textarea name="email_body" id="email_body" ></textarea>
					</div>
				</div>

				<div class="form-group mb-0 justify-content-end row" id="email_btn_div">				  
					<div class="col-md-6">					 
					
						<button type="button" onclick="sendMail()"  class="btn btn-lg btn-success">Send </button>
					</div>  
					<div class="col-md-6"><button type="button"  class="btn btn-primary waves-effect float-right" data-dismiss="modal">Close</button>	</div>
				</div>
                </section>

				   </div>
			  </div>
			  
			  
			 
			 
			  
			</div>
			 
		</div>
	  </div>
      </form>
    </div> 
   </div> 
   </div> 
 </div> 
	<div id="emailContent"></div>
	
	<style>
	@media (min-width: 992px) {
    .modal-lg { max-width: 1600px;}
 } 
 
 .cke_contents  { height:500px !important;}</style>
	
	
	<script>
	var editor = CKEDITOR.replace('email_body');
 CKEDITOR.editorConfig = function( config ) {
	    config.toolbarGroups = [
		 { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
	];
	//config.height = '800px';
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
//$('#emailContent').html(data);
		}});	
	
}

function showMailContent(email_template_id) {
	
	/*var language = $("input[name='language']:checked"). val();
	paramData = {'act':'loadEmailTemplate','email_template_id':email_template_id,'language':language};
	ajax({ 
		a:'process',
		b:$.param(paramData),
		c:function(){},
		d:function(data){ 		
		  var dataArr = data.split('::');
		  $('#email_contents').show();
		  $('#email_subject').val(dataArr[0]);  
		  CKEDITOR.instances.email_body.insertHtml('');
		  	for (instance in CKEDITOR.instances) {
    CKEDITOR.instances[instance].updateElement();
}
		  CKEDITOR.instances.email_body.insertHtml(dataArr[1]); 
		 // $('#email_body').setData(dataArr[0]);  

		}});	*/
    //sendEmail
    $('#sendMail #email_act').val('mailReplaceVariables');

    var form = $('form#sendMail');

    ajax({
        a:'process',
        b:form.serialize(),
        c:function(){},
        d:function(data){
            var results= $.trim(data).split('@@||@@');
//alert(results[0]);
            $('#sendMail #email_subject').val(results[0]);
            $('#email_contents').show();
            $('#sendMail #email_act').val('sendEmail');
            CKEDITOR.instances.email_body.insertHtml('');
            for (instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }
            CKEDITOR.instances.email_body.insertHtml(results[1]);
              
        }});
}
</script>