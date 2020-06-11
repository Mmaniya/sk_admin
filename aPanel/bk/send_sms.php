<?php

include "includes.php";


if($_POST['act']=='sendsms') {
ob_clean();
$toPhone = '+1'.$_POST['to_phone'];
$toMessage = $_POST['message'];
$smsParam = array('to'=>$toPhone,'is_sms_code'=>0,'message'=>$toMessage);
ob_clean();
echo sendSMS($smsParam);
exit();	
}

if($_POST['lead_id']>0) { $qry = "SELECT * from `".TBL_LEADS."` where id=".$_POST['lead_id'];
$rsDtls = dB::sExecuteSql($qry);
$receiverName = $rsDtls->lead_fname.' '.$rsDtls->lead_lname;
$receiverPhone = $rsDtls->lead_phone;
$hiddenInput = "<input type='hidden' name='lead_id' value='".$_POST['lead_id']."'>";
}
if($_POST['client_id']>0) { $qry = "SELECT * from `".TBL_CLIENTS."` where id=".$_POST['client_id'];
$rsDtls = dB::sExecuteSql($qry);
$receiverName = $rsDtls->client_fname.' '.$rsDtls->client_lname;
$receiverPhone = $rsDtls->client_phone;
$hiddenInput = "<input type='hidden' name='client_id' value='".$_POST['client_id']."'>";
}
if($_POST['user_id']>0) { $qry = "SELECT * from `".TBL_USERS."` where id=".$_POST['user_id'];
$rsDtls = dB::sExecuteSql($qry);
$receiverName = $rsDtls->contact_fname.' '.$rsDtls->contact_lname;
$receiverPhone = $rsDtls->contact_phone;
$hiddenInput = "<input type='hidden' name='user_id' value='".$_POST['user_id']."'>";


}

?>
	<div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">		
        <div class="modal-header">
			  <div class="col-md-12">
             <h4> Send SMS to <?php echo $receiverName; ?> (<?php echo formatPhoneNumber($receiverPhone); ?></h4>
              </div></div>	 
			<div class="modal-body">
				 <div class="row" id="mod_body">
					<div class="col-md-12">
                    <form id="smsForm"><?php echo $hiddenInput; ?>
                    <input type="hidden" name="act" value="sendsms" />
                    <input type="hidden" name="to_phone" id="to_phone" value="<?php echo $receiverPhone; ?>" />
                    <div class="row"><div class="col-md-8 p-2"><strong>Text Message</strong> </div></div>
                    <div class="row"><div class="col-md-8 p-2" ><textarea id="message" class="form-control" style="margin-top: 0px; margin-bottom: 0px; height: 103px;" name="message"></textarea></div></div>
                    <div class="row"><div class="col-md-12 p-2"><input type="button" onclick="send_message()" class="btn btn-md btn-primary" value="Send Text Message" /></div>
                    
                    </form>
					</div>
				</div>		
			</div>
			<div class="modal-footer">
			  <div class="col-md-12">
				<button type="button" class="btn btn-primary waves-effect float-right" data-dismiss="modal">Close</button>	
              </div>				
			</div>
		</div>
	</div>
	</div><!-- /.modal --> 
 <script>
 function send_message() {
	 var form = $('#smsForm');
	ajax({ 
  	a:'send_sms',
  	b:form.serialize(),
  	c:function(){},
  	d:function(data){   
      $('#mod_body').html(data);
   
	 }});  	
	 
 }
 </script>