<?php
 require("includes.php");
 ini_set('display_errors',1);
 
$action = $_REQUEST['act'];

if($action=='checkInvoiceDocAccepted')
{
	ob_clean();
	$idsArr=explode("-",$_POST['ids']);

	$param = array('tableName'=>TBL_QUESTIONNAIRE_DTLS,'fields'=>array('*'),'condition'=>array('invoice_line_item_id'=>$idsArr[0].'-INT','document_id'=>$idsArr[1].'-INT'),'showSql'=>'N');
	 $rsQuesDtls = Table::getData($param);
   
	if(count($rsQuesDtls) > 0)
	{
		$param=array();	 	
		$param['is_accepted']= $_POST['ischecked'];  
		$where= array('invoice_line_item_id'=>$idsArr[0],'document_id'=>$idsArr[1]);
		Table::updateData(array('tableName'=>TBL_QUESTIONNAIRE_DTLS,'fields'=>$param,'where'=>$where,'showSql'=>'N'));
		exit;
	}
	else{
	$docIds=array($idsArr[1]);
	$param=array();
		$param['invoice_line_item_id']= $idsArr[0];
		$param['document_id']=$idsArr[1];
		$param['invoice_id']=$_POST['invoice_id'];

		$sql = "SELECT * from `".TBL_DOCUMENTS."` where id = '".$idsArr[1]."'";			
		$docRes =  dB::sExecuteSql($sql);
		$param['parent_id']=$docRes->parent_id;
		$param['document_type']= $docRes->doc_type;
		$param['document_name']= strtolower(str_replace(' ','_',clean($docRes->doc_name)));
		$param['document_text']= '';
		$param['is_accepted']=$_POST['ischecked'];  
		$param['added_date'] = date('Y-m-d H:i:s',time());		
		$param['added_by']= $_SESSION['user_id'];
		//print_r($param);
		$resultArr = Table::insertData(array('tableName'=>TBL_QUESTIONNAIRE_DTLS,'fields'=>$param,'showSql'=>'N')); 
	}
}
if($_POST['act']=='showQuestionnaireCmts') {
ob_clean();
 
$invoiceLineItemId = $_POST['invoice_line_item_id'];
$questionnaireId = $_POST['questionnaire_id'];
$documentid = $_POST['document_id']; 
$isDashboard=$_POST['dashboard'];
if(!$isDashboard)
{
		$param=array();	 	
		$param['is_read']= 'Y';  
		$where= array('invoice_line_item_id'=>$invoiceLineItemId,'document_id'=>$documentid,'questionnaire_id'=>$questionnaireId);
		 Table::updateData(array('tableName'=>TBL_QUESTIONNAIRE_COMMENTS,'fields'=>$param,'where'=>$where,'showSql'=>'N'));
}

$param = array('tableName'=>TBL_DOCUMENTS,'fields'=>array('*'),'condition'=>array('id'=>$documentid.'-INT'),'showSql'=>'N');
$rsDocument = Table::getData($param);
	
?>
<div class="card">
  <h5 class="card-header bg-primary text-white"> <?php echo $rsDocument->doc_name; ?> <br/>
<small class="text-white"><?php echo htmlspecialchars_decode($rsDocument->doc_desc); ?></small></h5>
  
<ul class="comments-list">
<?php
  $qry = "SELECT * from `".TBL_QUESTIONNAIRE_COMMENTS."` where  document_id = ".$documentid." and invoice_line_item_id = ".$invoiceLineItemId;
 $rsDocuments =  dB::mExecuteSql($qry);		
 $commentCnt=count($rsDocuments);
	if(count($rsDocuments)>0) {
		$cCnt=0;
	  foreach($rsDocuments as $key=>$val) { $postedName='';
		$cCnt++;
		  if($val->added_type=='C') { 
			  $qry = "SELECT * from `".TBL_CLIENTS."` where id = ".$val->added_by."";
			$rsClients =  dB::sExecuteSql($qry);	
			$postedName = $rsClients->client_fname.' '.$rsClients->client_lname;
		  } 		  
		  if($val->added_type=='A') {
             $qry = "SELECT * from `".TBL_USERS."` where id = ".$val->added_by."";
			$rsUsers =  dB::sExecuteSql($qry);	
			$postedName = $rsUsers->contact_fname.' '.$rsUsers->contact_lname;
			  } 
			  $boldMessage=0; 
			  if($_POST['dashboard'] && $val->is_read=='N')
			     $boldMessage=1; 
			  ?>
		    <li <?php echo $boldMessage?"style='font-weight:bold;'":"";?> <?php echo ($commentCnt==$cCnt)?"id='lastCId'":""?>><?php echo $val->message; ?> <br/> -<small><?php echo $postedName.' '.getTimeAgo(strtotime($val->added_date));?> </small></li>
			
			
		 <?php
		 
	  } 
	  if(!$isDashboard)
	  {
			  $param=array();	 	
			  $param['is_read']= 'Y';  
			  $where= array('invoice_line_item_id'=>$invoiceLineItemId,'document_id'=>$documentid,'questionnaire_id'=>$questionnaireId);
			   Table::updateData(array('tableName'=>TBL_QUESTIONNAIRE_COMMENTS,'fields'=>$param,'where'=>$where,'showSql'=>'N'));
	  } 
	  } else { echo ' <li>No comments available</li>';  }		?>

</ul>
<?php
 if($isDashboard)
 {
	 ?>
	 <div class="col-lg-1" style="margin-bottom:10px">
	 <button id="replyBtn" class="bt btn-info btn-sm" onclick="$('#commentFrm').toggle();if($('#commentFrm').css('display')=='none') $('#replyBtn').html('Reply'); else $('#replyBtn').html('Hide');" style="margin-top:10px;" type="button">Reply</button>	 
	 </div>
	 <?php
 }
?>
<div id="commentFrm" style="display:<?php echo $isDashboard?'none':'block'?>">
<form style="padding:10px;">
<input type="hidden" id="invoice_line_item_id" value="<?php echo $invoiceLineItemId;?>">
<input type="hidden" id="document_id" value="<?php echo $documentid;?>">
<input type="hidden" id="questionnaire_id" value="<?php echo $questionnaireId;?>">
<textarea class="form-control" id="ques_comments"></textarea>
<button class="bt btn-danger btn-sm" onclick="submitQuesComments()" style="margin-top:10px;" type="button">Submit</button>
<button class="btn btn-danger btn-sm float-right" type="button" style="margin-top:10px;" onclick="closeForm()">Close</button>
</form>
</div>
 </div>
 <style>
 .comments-list { list-style-type:none;padding-left:10px;  max-height: 400px; overflow-y: scroll;}
 .comments-list li {border-bottom:1px solid #00000026;padding-top:10px; }
 </style>
 <script>
 function closeForm(){
	 $('.right_bar_div').html('');
 }
 $('.comments-list').animate({scrollTop: $('.comments-list').prop("scrollHeight")}, 500);
 
 function submitQuesComments() { 	err=0;
 var invLineItemId = $('#invoice_line_item_id').val();
 var documentId = $('#document_id').val();
 var questionnaireId = $('#questionnaire_id').val();
  if($('#ques_comments').val()=='' ){ err=1; $('#ques_comments').css("border","1px solid #ff0000 "); } else{  $('#ques_comments').css("border","");}
	 var ques_comments =  $('#ques_comments').val();
 if(err==0) {
	$('#tempMessage'+invLineItemId).val(ques_comments);
	 paramData = {'act':'submitQuesComments','invoice_line_item_id': invLineItemId,"document_id":documentId,"questionnaire_id":questionnaireId,"message":ques_comments };
          ajax({ 
            a:'process',
            b:$.param(paramData),
            c:function(){},
            d:function(data){  
			var res = data.split("::");
			alert(res[1]);  var quest_comment_id = res[2];
			sendAlertEmail(invLineItemId,documentId,questionnaireId,quest_comment_id);
			showQuestionnaireCmts(invLineItemId,documentId,questionnaireId); 
			if($('#tempMessage'+invLineItemId).val()!='')
			$('#lastActivityStr'+invLineItemId).html($('#tempMessage'+invLineItemId).val());
            }}); 
 } }
 
 
 function sendAlertEmail(invLineItemId,documentId,questionnaireId,quest_comment_id) {
	 var ques_comments =  $('#ques_comments').val();  
 if(err==0) {
 paramData = {'act':'sendEmail','invoice_line_item_id': invLineItemId,"document_id":documentId,"questionnaire_id":questionnaireId,"message":ques_comments,'email_template_id':'8','param_type':'Q-C','quest_comment_id':quest_comment_id };	
	    ajax({ 
            a:'process',
            b:$.param(paramData),
            c:function(){},
            d:function(data){  
            }});
 } }
 </script>
<?php 
exit();	
}


if($_POST['act']=='submitQuesComments') {
 ob_clean();
 
$params = array('invoice_line_item_id','document_id','questionnaire_id','message');
foreach($params as $K=>$V) {  $param[$V]=$$V=check_input($_POST[$V]); } 
 
 $qry = "SELECT * from `".TBL_QUESTIONNAIRE_COMMENTS."` where parent_id = 0 and document_id = ".$document_id." and invoice_line_item_id = ".$invoice_line_item_id." and questionnaire_id = ".$questionnaire_id."";
 $rsQuesCmts =  dB::mExecuteSql($qry);	
 if($rsQuesCmts>0) { $param['parent_id'] =$rsQuesCmts[0]->id; }
 
$param['added_type'] = 'A';
$param['added_date'] = date('Y-m-d H:i:s',time());		
$param['added_by']= $_SESSION['user_id'];  
echo $rsDtls = Table::insertData(array('tableName'=>TBL_QUESTIONNAIRE_COMMENTS,'fields'=>$param,'showSql'=>'N')); 
 
 exit();	
}


if($action =='updateServiceList') {
	ob_clean();
	
		$line_item_id = $_POST['line_item_id'];
		$service_step_name = $_POST['service_step_name'];
 
	    $param['invoice_line_item_id']= $line_item_id;  
	    $param['service_step_name']= $_POST['service_step_name'];  
		$param['added_date'] = date('Y-m-d H:i:s',time());		
		$param['added_by']= $_SESSION['user_id'];  
		  Table::insertData(array('tableName'=>TBL_INVOICE_LINE_ITEM_SERVICE_STEP,'fields'=>$param,'showSql'=>'N')); 
		
		
        $param=array();
	 	$param['updated_date'] = date('Y-m-d H:i:s',time());		
		$param['updated_by']= $_SESSION['user_id'];  
		$param['service_step_name']= $_POST['service_step_name'];  
		$where= array('id'=>$line_item_id);
		 echo  Table::updateData(array('tableName'=>TBL_INVOICE_LINE_ITEM,'fields'=>$param,'where'=>$where,'showSql'=>'N'));
		 
 
	
	exit();
}


  if($action=='showServiceSteps') {
	  ob_clean();
	$serviceId = $_POST['id'];    
	$lineItenId = $_POST['line_item_id'];    
	$param = array('tableName'=>TBL_SERVICES,'fields'=>array('*'),'showSql'=>'N','condition'=>array('id'=>$serviceId.'-INT'));
	$rsService = Table::getData($param);
	foreach($rsService as $K=>$V)  $$K=$V;
	 
	 $unserialize =  unserialize($service_steps);  													  
			    
		 echo '&nbsp;<select name="service_step_name" id="service_step_name_'.$lineItenId.'">';
			   for($i=0;$i<count($unserialize);$i++) {  
			  foreach($unserialize as $key=>$val) {   
				  
				  if($unserialize[$key][$i]!='') {
					   echo '<option value="'.$unserialize['service_name_append'][$i].'">'.$unserialize['service_name_append'][$i].'</option>'; 					  
			   break; }}}  
			  
		  echo '</select> <button class="btn btn-primary btn-sm serviceStepList" onclick="submitPhaseList('.$lineItenId.')">Update</button>
		  <button class="btn btn-danger btn-sm serviceStepList" onclick="closeServiceList()">Close</button>
		  ';     
 exit(); }





if($action=='send_payment_details_email') {
	ob_clean(); 
	$invoicePaymentId = $_POST['invoice_payment_id'];
	$invoiceId = $_POST['invoice_id'];
	$emailAddress = $_POST['email_address'];
	$param = array('tableName'=>TBL_INVOICE,'fields'=>array('*'),'condition'=>array('id'=>$invoiceId.'-INT'));
	$rsInvoice = Table::getData($param); 	 
	foreach($rsInvoice as $K=>$V)  $$K=$V; 
	
	
	$param = array('tableName'=>TBL_CLIENTS,'fields'=>array('*'),'condition'=>array('id'=>$client_id.'-INT'));
	$rsClient = Table::getData($param);
	
					 
	$qry = "SELECT sum(amount_paid) as total_paid from `".TBL_INVOICE_PAYMENT."` where  invoice_id=".$id; 
	$rsInvIns =  dB::sExecuteSql($qry);  
	
	$serviceObj = new Invoice();
	$serviceObj->invoice_id = $id;
	$servicesOrdered = $serviceObj->getServicesByInvoiceId();
	
	$htmlContent =' <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css" />
			  <table  cellspacing="0" cellpadding="10" width="680" style="width:510.0px;background:#ffffff;border:solid #cccccc 1.0px;font-family: \'Lato\', Verdana, sans-serif;">
             <tbody>
				<tr>
				<td  border="1" colspan="2" style="background-color:#039cfd;color: #fff;text-align: center;font-weight: 600;"><p>Payment Details for BPE - 6144 </p></td>
				</tr>			 
			 <tr>
					<td><strong>'.$rsClient->client_fname.' '.$rsClient->client_lname.'<br/>'.$rsClient->client_phone.'<br/>'.$rsClient->client_email.'</strong></td>
					<td><ul class="invoice_services_list">';
					 foreach($servicesOrdered as $K1=>$V1) { 					 
					  if(is_array($V1)) {  
						if($K1==0) 
						$htmlContent.='<li>'.$V1['item_name'].'</li>';
						   } }
					$htmlContent.='</ul></td>
			  </tr>
			  
			  <tr>
			  <td><strong> Total Amount : '.money($final_amount,'$').' <br>';
			  if(trim($balance_amount)!='') { $htmlContent.='Balance Amount : '.money($balance_amount,'$'); }
			  
			  $htmlContent.='</strong></td>
			  <td style="text-align:center"><strong>Total Paid : '.money($rsInvIns->total_paid,'$').' </strong></td>
			  </tr>		
			  <tr>
			  <td colspan="2"> Payment Details </td>
			  </tr>
			  
			  <tr>
			  <td colspan="2" style="padding:0px;">
			  <table border="1" cellspacing="0" cellpadding="10" width="680" style="border: 1px solid #eee;">
					 <thead>					  
					  <tr><th>Date</th>
					  <th>Txn Id</th>					  
					  <th>Amount</th>
					 </tr></thead>
					 <tbody>';
					  $param = array('tableName'=>TBL_INVOICE_PAYMENT,'fields'=>array('*'),'orderby'=>'added_date','sortby'=>'asc','condition'=>array('id'=>$invoicePaymentId.'-INT'));
				$rsInvoicePayment[0] = Table::getData($param);
				if(count($rsInvoicePayment)>0) {
                    foreach($rsInvoicePayment as $key=>$val) {
						
									  $htmlContent.='<tr>					 			 
					  <td>'.date('M d, Y',strtotime($val->added_date)).'</td>
					   <td>'.$val->txn_id.'</td>
					  <td>'.money($val->amount_paid,'$').'</td>
				</tr>';  } }
        $htmlContent.='</tbody>
					</table>
			  </td>
			  </tr>
			  </tbody>
			  </table>';
			  
		$emailBody = generateMailContent("",$htmlContent);
			  
	   // use PHPMailer\PHPMailer\PHPMailer;
	   // use PHPMailer\PHPMailer\Exception;
		
		require_once 'PHPMailer/src/Exception.php';
		require_once 'PHPMailer/src/PHPMailer.php';
		require_once 'PHPMailer/src/SMTP.php';
		
		 $emailAddress = explode(',',$emailAddress);  
		 $emailSubject = "[BizPlanEasy] Payment Details for BPE -".$invoiceId; 
		  
		$mail = new PHPMailer();   
			
		try {
			//Server settings
			$mail->SMTPDebug = 2;                                       // Enable verbose debug output
			$mail->isSMTP();                                            // Set mailer to use SMTP
			$mail->Host       = 'email-smtp.us-east-1.amazonaws.com';  // Specify main and backup SMTP servers
			$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
			$mail->Username   = 'AKIAV6VOGF6A2SW4EACC';                     // SMTP username
			$mail->Password   = 'BPq9hAB7wThsvuZpsGWrITKeAwk8C96Iep5T5AhWkqbK';                               // SMTP password
			$mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
			$mail->Port       = 587;                                    // TCP port to connect to
		
			//Recipients
			$mail->setFrom('support@bizplaneasy.com', 'BizPlanEasy');
			$mail->addReplyTo('support@bizplaneasy.com', 'BizPlanEasy');
			
		
			// Content
			$mail->isHTML(true);                                  // Set email format to HTML
			//$mail->AddAddress('support@mastermindsolutionsonline.com');
			foreach($emailAddress as $K=>$V) {
			$mail->AddAddress($V);
			
			}
			$mail->Subject =  $emailSubject;                
			$mail->Body = $emailBody;
			$mail->send();
			 } catch (Exception $e) {
				ob_clean();
			    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}	
	
exit();	
				}  
				
				
if($action=='delete_quotation') {
	ob_clean();
	$quotationId = $_POST['quotation_id'];
	
	$param = array('tableName'=>TBL_INVOICE,'fields'=>array('*'),'showSql'=>'N','condition'=>array('quotation_id'=>$quotationId.'-INT'));
    $rsInvoiceid = Table::getData($param); 
	if(count($rsInvoiceid)>0) { echo 'An Invoice has already been raised for this quotation. Hence, it cannot be deleted from the system. Please contact webmaster to delete the quotation.';  } else 
		{    
   dB::deleteSql("DELETE FROM  `".TBL_QUOTATION_LINE_ITEM."` WHERE quotation_id=".$quotationId);
   dB::deleteSql("DELETE FROM  `".TBL_QUOTATION_INSTALLMENT."` WHERE quotation_id=".$quotationId);
   dB::deleteSql("DELETE FROM  `".TBL_QUOTATION_PAYMENT."` WHERE quotation_id=".$quotationId);
   dB::deleteSql("DELETE FROM  `".TBL_QUOTATION."` WHERE id=".$quotationId);
   echo 'Quotation Successfully Deleted';
		}
exit();	
}
if($action=='show_log') {
    ob_clean();
    $type=$_POST['type'];

    $id=$_POST['id'];

    $logObj= new Logs();
    $logObj->params=array('table_name'=>$type,'key_value'=>$id);
    if($type==TBL_INVOICE)
    {
        $logRes=$logObj->getLogs();

        $param = array('tableName'=>TBL_INVOICE_LINE_ITEM,'fields'=>array('*'),'showSql'=>'N','condition'=>array('invoice_id'=>$id.'-INT'));
        $rsInvoiceLineItem = Table::getData($param);

        ?>
        <style>
         .ui-widget{
            font-size: inherit;
         }
        </style>
        <div id="tabs" class="tabs">
          <ul>
            <li><a href="#invoiceLogs">Invoice</a></li>
            <li><a href="#invoiceLineItems">Line Items</a></li>
            <li><a href="#invoicePayment">Invoice Payments</a></li>
            <li><a href="#invoiceEmails">Emails</a></li>
          </ul>
          <div id="invoiceLogs">
            <?php include("log_list.php");?>
          </div>
          <div id="invoiceLineItems">
          <div class="accordion" id="accordion_<?php echo $id;?>">
            <?php foreach($rsInvoiceLineItem as $IK => $IV) { ?>
              <h3><?php echo $IV->line_item;?></h3>
              <div>
                  <div id="tabs_<?php echo $IV->id;?>" class="tabs">
                  <ul>
                     <li><a href="#lineItemLogs_<?php echo $IV->id;?>">Logs</a></li>
                     <li><a href="#questionnaireLogs_<?php echo $IV->id;?>" data-toggle="tab" aria-expanded="false" class="nav-link">Questionnaire Logs</a></li>
                  </ul>
                  <div id="lineItemLogs_<?php echo $IV->id;?>">
                      <?php
                        $logObj->params=array('table_name'=>TBL_INVOICE_LINE_ITEM,'key_value'=>$IV->id);
                        $logRes=$logObj->getLogs();
                        include("log_list.php");
                      ?>
                  </div>
                  <div id="questionnaireLogs_<?php echo $IV->id;?>">
                      <?php
                      $param = array('tableName'=>TBL_QUESTIONNAIRE_DTLS,'fields'=>array('*'),'showSql'=>'N','condition'=>array('invoice_line_item_id'=>$IV->id.'-INT'),'showSql'=>'N');
                      $rsQuestionnaireDtls = Table::getData($param);
                      $quesFound=0;
                      ?>
                      <div class="accordion" id="quest_accordion_<?php echo $IV->id;?>">
                          <?php foreach($rsQuestionnaireDtls as $QK => $QV) {
                              $logObj->params=array('table_name'=>TBL_QUESTIONNAIRE_DTLS,'key_value'=>$QV->id);
                              $logRes=$logObj->getLogs();
                              if(count($logRes) > 0){
                                  $quesFound=1;
                              ?>
                          <h3><?php echo $QV->document_name;?></h3>
                          <div>
                              <?php
                              include("log_list.php");
                              ?>
                          </div>
                          <?php } } if($quesFound==0) echo "No logs found.";?>
                      </div>
                  </div>
              </div>
             </div>
            <?php } ?>
          </div>
        </div>
            <div id="invoicePayment">
                <?php
                $logObj->invoice_id=$id;
                $logRes=$logObj->getInvoicePaymentLogs();
                include("log_list.php");
                ?>
            </div>
            <div id="invoiceEmails">
                <?php
                $logObj->params=array('table_name'=>TBL_INVOICE,'key_value'=>$id,'process_type'=>'EMAIL');
                $logRes=$logObj->getLogs();
                include("log_list.php");
                ?>
            </div>
      </div>

        <Script>
            $('.accordion').accordion({
                heightStyle: "content",
                collapsible: true
            });
            $( ".tabs" ).tabs();
        </Script>
    <?php
    }
    else if($type==TBL_INVOICE_LINE_ITEM)
    {
        ?>
        <style>
            .ui-widget{
                font-size: inherit;
            }
        </style>
        <div id="tabs" class="tabs">
          <ul>
              <li><a href="#lineItemLogs">Logs</a></li>
              <li><a href="#questionnaireLogs">Questionnaire Logs</a></li>
          </ul>
        <div id="lineItemLogs">
            <?php
            $logObj->params=array('table_name'=>TBL_INVOICE_LINE_ITEM,'key_value'=>$id);
            $logRes=$logObj->getLogs();
            include("log_list.php");
            ?>
        </div>
        <div id="questionnaireLogs">
            <?php
            $param = array('tableName'=>TBL_QUESTIONNAIRE_DTLS,'fields'=>array('*'),'showSql'=>'N','condition'=>array('invoice_line_item_id'=>$id.'-INT'),'showSql'=>'N');
            $rsQuestionnaireDtls = Table::getData($param);
            $quesFound=0;
            ?>
            <div class="accordion" id="quest_accordion">
                <?php foreach($rsQuestionnaireDtls as $QK => $QV) {
                    $logObj->params=array('table_name'=>TBL_QUESTIONNAIRE_DTLS,'key_value'=>$QV->id);
                    $logRes=$logObj->getLogs();
                    if(count($logRes) > 0){
                        $quesFound=1;
                        ?>
                        <h3><?php echo $QV->document_name;?></h3>
                        <div>
                            <?php
                            include("log_list.php");
                            ?>
                        </div>
                    <?php } } if($quesFound==0) echo "No logs found.";?>
            </div>
        </div>
       </div>
        <Script>
            $('.accordion').accordion({
                heightStyle: "content",
                collapsible: true
            });
            $( ".tabs" ).tabs();
        </Script>
        <?php
    }
    exit;
}
if($action=='show_manual_invoice_modal') {
ob_clean();
$quotationId = $_POST['id'];
$param = array('tableName'=>TBL_QUOTATION,'fields'=>array('*'),'condition'=>array('id'=>$quotationId.'-INT'));
$rsQuotation = Table::getData($param);

foreach($rsQuotation as $K=>$V)  $$K=$V;
			
$param = array('tableName'=>TBL_LEADS,'fields'=>array('*'),'condition'=>array('id'=>$lead_id.'-INT'));
$rsLeads = Table::getData($param);	

 $paidAmount = $final_amount;

if($installment=='Y') {  $paidAmount = $installment_downpayment;  }

?>

<div id="manual_invoice_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
		
          <div class="modal-body" style="padding:0px;">
          <div class="body-div" style="padding:15px;">            
          <div class="card">	 
		  <label class="card-header bg-primary text-white">Manual Invoice  - <?php echo customizeSerial($quotationId);?> <a href="javascript:void(0)" class="text-white float-right" data-dismiss="modal">Close</a></label>
			 <div class="card-body">
			 <div class="row">
			  <div class="col-md-4">  
            <label>Payment Date</label> 
            <input type="text" name="payment_date" id="payment_date" class="form-control datepicker">			
			 </div> 
			 <div class="col-md-4">  
            <label>Txn Id</label> 
            <input type="text" name="txn_id" id="txn_id" class="form-control">			
			 </div> 
			 
			  <div class="col-md-4">
            <label>Paid Amount ($)</label> 
             <input type="text" name="p_amount" id="p_amount" class="form-control" value="<?php echo money($paidAmount,'$');?>" readonly> 
<input type="hidden" name="paid_amount" id="paid_amount" class="form-control" value="<?php echo $paidAmount;?>" readonly>		   
			 </div> 	
			 
         <div class="col-md-4">  
		 <button type="button" class="btn btn-warning btn-md" onclick="makeManualInvoice()" style="margin-top:25px;">Create Invoice</button>
		 <input type="hidden" name="quotation_id" id="quotation_id"  value="<?php echo $id;?>">
		 <input type="hidden" name="act" value="submit_manual_invoice">
		 </div>
			 
             </div>
			</div>
			 
		</div>
	</div>
	</div><!-- /.modal -->

<script>
 $( function() {
    $( ".datepicker").datepicker({
      changeMonth: true,
      changeYear: true,
    });
  } );
function makeManualInvoice() {
	err=0;  
	if($('#txn_id').val()=='' ){ err=1; $('#txn_id').css("border","1px solid #F58634 "); } else{  $('#txn_id').css("border","");}
	if($('#paid_amount').val()=='' ){ err=1; $('#paid_amount').css("border","1px solid #F58634 "); } else{  $('#paid_amount').css("border","");}
	if($('#payment_date').val()=='' ){ err=1; $('#payment_date').css("border","1px solid #F58634 "); } else{  $('#payment_date').css("border","");}
	
	var txn_id =  $('#txn_id').val();  var paid_amount =  $('#paid_amount').val();  var quotation_id =  $('#quotation_id').val();
	var payment_date =  $('#payment_date').val();
	if(err==0) {
	paramData = {'act':'submit_manual_invoice','txn_id':txn_id,'paid_amount':paid_amount,'quotation_id':quotation_id,'payment_date':payment_date};
	ajax({ 
		a:'process',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
			 var res = data.split(":::"); 
			 $('#inv_'+quotation_id).html(res[1]); $('#manual_invoice_modal').modal('hide'); 
		}});	
} }

</script>

<?php  	
exit();  
}

if($action=='show_manual_payment_modal') {
    ob_clean();
    $invoiceId = $_POST['invoice_id'];
    $installmentId=$_POST['installment_id'];

    $param = array('tableName'=>TBL_INVOICE_INSTALLMENT,'fields'=>array('*'),'condition'=>array('id'=>$installmentId.'-INT'));
    $rsInstallment = Table::getData($param);

    foreach($rsInstallment as $K=>$V)  $$K=$V;
    /*$param = array('tableName'=>TBL_INVOICE,'fields'=>array('*'),'condition'=>array('id'=>$invoiceId.'-INT'));
    $rsInvoice = Table::getData($param);

    foreach($rsInvoice as $K=>$V)  $$K=$V;*/

    ?>

<div id="manual_payment_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
<div class="modal-dialog modal-lg">
<div class="modal-content">

    <div class="modal-body" style="padding:0px;">
        <div class="body-div" style="padding:15px;">
            <div class="card">
                <label class="card-header bg-primary text-white">Manual Payment  - BE - <?php echo $invoiceId;?> <a href="javascript:void(0)" class="text-white float-right" data-dismiss="modal">Close</a></label>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Payment Date</label>
                            <input type="text" name="payment_date" id="payment_date" class="form-control datepicker">
                        </div>
                        <div class="col-md-4">
                            <label>Txn Id</label>
                            <input type="text" name="txn_id" id="txn_id" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label>Installment Amount ($)</label>
                            <input type="text" name="p_amount" id="p_amount" class="form-control" value="<?php echo money($amount,'$');?>" readonly>
                            <input type="hidden" name="amount" id="amount" class="form-control" value="<?php echo $amount;?>" readonly>
                        </div>

                        <div class="col-md-4">
                            <button type="button" class="btn btn-warning btn-md" onclick="makeManualpayment()" style="margin-top:25px;">Make Payment</button>
                            <input type="hidden" name="invoice_id" id="invoice_id"  value="<?php echo $invoiceId;?>">
                            <input type="hidden" name="installment_id" id="installment_id"  value="<?php echo $installmentId;?>">
                            <input type="hidden" name="client_id" id="client_id" value="<?php echo $client_id;?>">
                            <input type="hidden" name="act" value="submit_manual_payment">
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div><!-- /.modal -->

    <script>
        $( function() {
            $( ".datepicker").datepicker({
                changeMonth: true,
                changeYear: true,
            });
        } );
        function makeManualpayment() {
            err=0;
            if($('#txn_id').val()=='' ){ err=1; $('#txn_id').css("border","1px solid #F58634 "); } else{  $('#txn_id').css("border","");}
            if($('#amount').val()=='' ){ err=1; $('#amount').css("border","1px solid #F58634 "); } else{  $('#amount').css("border","");}
            if($('#payment_date').val()=='' ){ err=1; $('#payment_date').css("border","1px solid #F58634 "); } else{  $('#payment_date').css("border","");}

            var txn_id =  $('#txn_id').val();  var paid_amount =  $('#amount').val();  var invoice_id =  $('#invoice_id').val();
            var payment_date =  $('#payment_date').val();
            if(err==0) {
                paramData = {'act':'submit_manual_payment','txn_id':txn_id,'amount':paid_amount,'invoice_id':invoice_id,'payment_date':payment_date,'installment_id':$('#installment_id').val(),'client_id':$('#client_id').val()};
                ajax({
                    a:'process',
                    b:$.param(paramData),
                    c:function(){},
                    d:function(data){
                        //alert(data);
                        //return;
                        //$('#inv_'+quotation_id).html(res[1]);
                        $('.modal-backdrop').remove();
                        $('#manual_payment_modal').modal('hide');
                        show_invoice_paymentDtls(invoice_id);
                        setTimeout(function() {showPaymentType('D');},500);

                    }});
            } }

    </script>

    <?php
    exit();
}

if($action == "submit_manual_payment"){
    ob_clean();
    // Transaction info
    $transactionID = $_POST['txn_id'];
    $paidAmount = $_POST['amount'];
    $invoiceId = $_POST['invoice_id'];
    $payment_date = $_POST['payment_date'];

    $installmentArr = array('installment_id'=>$_POST['installment_id'],'invoice_id'=>$invoiceId,'client_id'=>$_POST['client_id'],'transaction_id'=>$transactionID,'paid_amount'=>$paidAmount);

    $invoiceObj = new Invoice();
    $invoicePaymentId = $invoiceObj->installmentPayment($installmentArr);

    exit;
}
 if($action == "submit_manual_invoice"){
	 ob_clean();
		// Transaction info
		$transactionID = $_POST['txn_id'];
		$paidAmount = $_POST['paid_amount'];
		$quotationId = $_POST['quotation_id'];
		$payment_date = $_POST['payment_date'];
		//store it and convert to client
		//Client is paying for the first time, hence convert the lead to client 
		
		$clientParamArr = array('quotation_id'=>$quotationId,'transaction_id'=>$transactionID,'paid_amount'=>$paidAmount);
		$clientObj = new Clients();
		$clientObj->payment_date = $payment_date;
		$clientObj->param = $clientParamArr;
		$clientDtls = $clientObj->addNewClient();
		
    
	    $client_id = $clientDtls['client_id'];
		$invoice_id = $clientDtls['invoice_id'];
		$invoice_payment_id = $clientDtls['invoice_payment_id'];
        include "generate_invoice_pdf.php";
        $manualInvoice=1;

        include "order_thankyou_mail.php";
          ob_clean();
		  echo $invoice_id.':::&nbsp;<i class="fas fa-check-circle text-success" style="font-size:18px"></i> <br>
  <strong>Inv Id : '.$invoice_id.'</strong>';
		exit();
    }

if($_POST['act']=='mailReplaceVariables')
{
    ob_clean();
    $quotationId = $_POST['quotation_id'];
    $invoiceId = $_POST['invoice_id'];
    $clientId = $_POST['client_id'];
    $toAddress = $_POST['to_email_address'];
    if($clientId>0) {
        $qry ="SELECT * from `".TBL_CLIENTS."` WHERE id = ".$clientId;
        $rsClient= dB::sExecuteSql($qry);
    }

    $leadId = $_POST['lead_id'];
    if($leadId>0) {
        $qry ="SELECT * from `".TBL_LEADS."` WHERE id = ".$leadId;
        $rsLead= dB::sExecuteSql($qry);
    }
    $invoicePaymentId = $_POST['invoice_payment_id'];
    if($invoicePaymentId>0) {
        $qry ="SELECT * from `".TBL_INVOICE_PAYMENT."` WHERE id = ".$invoicePaymentId;
        $rsInvPayment= dB::sExecuteSql($qry);
        $invoiceId= $rsInvPayment->invoice_id;
        $qry ="SELECT * from `".TBL_INVOICE."` WHERE id = ".$rsInvPayment->invoice_id;
        $rsInvoice= dB::sExecuteSql($qry);
        $clientId= $rsInvPayment->client_id;
        $qry ="SELECT * from `".TBL_CLIENTS."` WHERE id = ".$clientId;
        $rsClient= dB::sExecuteSql($qry);
    }

    $installmentId = $_POST['installment_id'];
    if($installmentId>0) {
        $qry ="SELECT * from `".TBL_INVOICE_INSTALLMENT."` WHERE id = ".$installmentId;
        $rsInstallment= dB::sExecuteSql($qry);
        if($rsInstallment->is_paid=='Y') {

            $qry ="SELECT * from `".TBL_INVOICE_PAYMENT."` WHERE installment_id = ".$installmentId;
            $rsInvPayment= dB::sExecuteSql($qry);
            $invoicePaymentId = $rsInvPayment->id;
            $invoiceId= $rsInvPayment->invoice_id;
            $qry ="SELECT * from `".TBL_INVOICE."` WHERE id = ".$rsInvPayment->invoice_id;
            $rsInvoice= dB::sExecuteSql($qry);
            $clientId= $rsInvPayment->client_id;
            $qry ="SELECT * from `".TBL_CLIENTS."` WHERE id = ".$clientId;
            $rsClient= dB::sExecuteSql($qry);
        }
    }

    $questionnaireCommentId = $_POST['quest_comment_id'];
    if($questionnaireCommentId>0) {
        //LINE ITEM_ID
        $qry ="SELECT * from `".TBL_QUESTIONNAIRE_COMMENTS."` WHERE id = ".$questionnaireCommentId;
        $rsQuesCmts= dB::sExecuteSql($qry);
        $rsQuestionnaire = $rsQuesCmts->message;

        $qry ="SELECT * from `".TBL_QUESTIONNAIRE_DTLS."` WHERE id = ".$rsQuestionnaire->questionnaire_id;
        $rsQuestionnaireDtls= dB::sExecuteSql($qry);


        $qry ="SELECT * from `".TBL_INVOICE_LINE_ITEM."` WHERE id = ".$rsQuestionnaire->invoice_line_item_id;
        $invLineDtls = dB::sExecuteSql($qry);

        $qry ="SELECT * from `".TBL_USERS."` WHERE id = ".$invLineDtls->specialist_id;
        $rsUsers = dB::sExecuteSql($qry);

        if($rsQuestionnaire->added_type=='A') {
            $qry ="SELECT * from `".TBL_USERS."` WHERE id = ".$rsQuestionnaire->added_by;
            $rsPostedBy = dB::sExecuteSql($qry);
            $posted_by = $rsPostedBy->contact_fname.' '.$rsPostedBy->contact_lname;
        }

        if($rsQuestionnaire->added_type=='C') {
            $qry ="SELECT * from `".TBL_CLIENTS."` WHERE id = ".$rsQuestionnaire->added_by;
            $rsPostedBy = dB::sExecuteSql($qry);
            $posted_by = $rsPostedBy->client_fname.' '.$rsPostedBy->client_lname;
        }


    }

    $invoiceLineItem = $_POST['invoice_line_item_id'];
    if($invoiceLineItem>0) {
        $qry ="SELECT * from `".TBL_INVOICE_LINE_ITEM."` WHERE id = ".$invoiceLineItem;
        $rsInvLineItem= dB::sExecuteSql($qry);

        $qry ="SELECT * from `".TBL_USERS."` WHERE id = ".$rsInvLineItem->specialist_id;
        $rsUsers = dB::sExecuteSql($qry);

    }


    $paramType  = $_POST['param_type'];
    $emailTemplateId = $_POST['email_template_id'];
    $language  = $_POST['language'];
    $emailSubject  = $_POST['email_subject'];
    $emailBody  = $_POST['email_body'];

    $qry ="SELECT * from `".TBL_EMAIL_TEMPLATE."` WHERE id = ".$emailTemplateId;
    $rsDtl= dB::sExecuteSql($qry);
    if($emailSubject=='') {  $emailSubject = $rsDtl->email_subject;   }
    if($emailBody=='') {  $emailBody = $rsDtl->email_body;   }

    $notesArr = explode(',',$rsDtl->notes);
    $notesArr=array("[CLIENT_NAME]","[INSTALLMENT_PAYMENT_LINK]","[Q_FIELD]","[INVOICE_ID]","[LINE_ITEM_NAME]","[COMMENTS]","[POSTED_BY]","[CLIENT_EMAIL]","[CLIENT_PASS]","[ACCOUNT_LINK]","[SERVICES]","[PROGRESS]","[IMAGE]","[DAYS_TO_COMPLETE]","[SERVICE]","[SERVICEQDAYS]","[PURCHASEDATE]","[PURCHASEDATE3MONTHS]","[PURCHASEDATE6MONTHS]","[PURCHASEDATE12MONTHS]");
    $serviceObj=new Invoice();
    foreach($notesArr as $K=>$V) {

        $sI=trim($V);
        if($sI=='[Q_FIELD]') {
            $questionnaire = $rsQuestionnaireDtls->document_name;
            $replaceArr[$sI]=$questionnaire;
        }

        if($sI=='[SERVICES]') {
            if($invoiceLineItem > 0)
                $replaceArr[$sI]=$rsInvLineItem->line_item;
            else
            {
                $qry ="SELECT * from `".TBL_INVOICE_LINE_ITEM."` WHERE invoice_id = ".$invoiceId;
                $rsInvLineItem= dB::sExecuteSql($qry);
                $lineItems='<ul>';
                foreach($rsInvLineItem as $IK => $IV)
                {
                    $lineItems.='<li>'.$IV->line_item.'</li>';
                }
                $lineItems.='</ul>';
                $replaceArr[$sI]=$lineItems;
            }
        }

        if($sI=='[DAYS_TO_COMPLETE]')
        {
            $qry ="SELECT * from `".TBL_SERVICES."` WHERE id = ".$rsInvLineItem->service_id;
            $rsService= dB::sExecuteSql($qry);

            $now = time();
            $dateArr=explode(" ",$rsInvLineItem->added_date);

            $service_date = strtotime($dateArr[0]);
            $datediff = $now - $service_date;

            $diff= round($datediff / (60 * 60 * 24));

            $daysToComplete=$rsService->days_allowed_for_questionnaire;

            $replaceArr[$sI]=$daysToComplete-$diff;
            if($replaceArr[$sI]<0)
                $replaceArr[$sI]=0;
        }


       if($sI=='[SERVICE]')  // service description
		 {

            if(is_object($rsInvLineItem))
               $replaceArr[$sI]=$rsInvLineItem->line_item; 
            else {
			$qry ="SELECT * from `".TBL_SERVICES."` WHERE id = ".$rsInvLineItem->service_id;
            $rsService= dB::sExecuteSql($qry);
			$replaceArr[$sI]=$rsService->service_name; 	
           }
			 
	 }
		
		
		if($sI=='[SERVICEQDAYS]')  // days allowed for questionnaire
		 {
            $qry ="SELECT * from `".TBL_SERVICES."` WHERE id = ".$rsInvLineItem->service_id;
            $rsService= dB::sExecuteSql($qry);
			 $replaceArr[$sI]=$rsService->days_allowed_for_questionnaire.' days'; 
		}
		
		if($sI=='[PURCHASEDATE]')  // invoice sent date
		 {
            $qry ="SELECT * from `".TBL_INVOICE."` WHERE id = ".$invoiceId;
            $rsinvDtls= dB::sExecuteSql($qry);
			 $replaceArr[$sI]=date('M d, Y',strtotime($rsinvDtls->sent_date)); 
		 }
		 
		 
		 if($sI=='[PURCHASEDATE3MONTHS]')   
		 {
            $qry ="SELECT * from `".TBL_INVOICE."` WHERE id = ".$invoiceId;
            $rsinvDtls= dB::sExecuteSql($qry);
			 $sentDate = date('Y-m-d', strtotime("+3 month", strtotime($rsinvDtls->sent_date)));
			 $replaceArr[$sI]=date('M d, Y',strtotime($sentDate)); 
		 }
		 
		 
		 if($sI=='[PURCHASEDATE6MONTHS]')   
		 {
            $qry ="SELECT * from `".TBL_INVOICE."` WHERE id = ".$invoiceId;
            $rsinvDtls= dB::sExecuteSql($qry);
			$sentDate = date('Y-m-d', strtotime("+6 month", strtotime($rsinvDtls->sent_date)));
			$replaceArr[$sI]=date('M d, Y',strtotime($sentDate)); 
		 }
		 
		 
		 if($sI=='[PURCHASEDATE12MONTHS]')  
		 {
            $qry ="SELECT * from `".TBL_INVOICE."` WHERE id = ".$invoiceId;
            $rsinvDtls= dB::sExecuteSql($qry);
			$sentDate = date('Y-m-d', strtotime("+12 month", strtotime($rsinvDtls->sent_date)));
			$replaceArr[$sI]=date('M d, Y',strtotime($sentDate)); 
		 }
		

        if($sI=='[PROGRESS]' || $sI=='[IMAGE]') {
            $progressBar='';
            if($invoiceLineItem > 0)
            {
                $serviceObj->invoice_line_item_id=$invoiceLineItem;
                $is_questionnaire=$serviceObj->isQuestionnaire();
                if($is_questionnaire)
                {
                    $param = array('tableName'=>TBL_SERVICES,'fields'=>array('document_id'),'condition'=>array('id'=>$rsInvLineItem->service_id.'-INT'));
                    $rsService = Table::getData($param);
                    $docIds=$rsService->document_id;
                    $docIdsArr=explode(",",$docIds);
                    $docIdsArr=array_unique($docIdsArr);

                    $serviceObj->docIds=$docIds;
                    $quesCnt=$serviceObj->getQuestionnaireDetailsByDoc();

                    $quesPercentage=($quesCnt/count($docIdsArr))*100;
                    $progressBar='<div><strong>No. of questions:</strong> '.count($docIdsArr).'</div>';
                    $progressBar.='<div><strong>Answered questions:</strong> '.$quesCnt.'</div>';
                    $progressBar.='<div><strong>'.round($quesPercentage).'%</strong> completed so far.</div>';
                    //$progressBar.='<div style="width:40%"><div width="100%" style="background-color:#ccc;border-radius: .25rem;"><div style="width:'.round($quesPercentage).'%;background-color:#039cfd;height:35px;border-radius: .25rem;\">&nbsp;</div></div></div>';
                    $progressBar=round($quesPercentage);
                }
            }
            else
            {
                $qry ="SELECT * from `".TBL_INVOICE_LINE_ITEM."` WHERE invoice_id = ".$invoiceId;
                $rsInvLineItem= dB::sExecuteSql($qry);
                $lineItems='<ul>';
                foreach($rsInvLineItem as $IK => $IV)
                {
                    $lineItems.='<li>'.$IV->line_item;

                    $serviceObj->invoice_line_item_id=$IV->id;
                    $is_questionnaire=$serviceObj->isQuestionnaire();
                    $progressBar='';
                    if($is_questionnaire)
                    {
                        $param = array('tableName'=>TBL_SERVICES,'fields'=>array('document_id'),'condition'=>array('id'=>$rsInvLineItem->service_id.'-INT'));
                        $rsService = Table::getData($param);
                        $docIds=$rsService->document_id;
                        $docIdsArr=explode(",",$docIds);
                        $docIdsArr=array_unique($docIdsArr);

                        $serviceObj->docIds=$docIds;
                        $quesCnt=$serviceObj->getQuestionnaireDetailsByDoc();

                        $quesPercentage=($quesCnt/count($docIdsArr))*100;

                        $progressBarStr='<div><strong>No. of questions:</strong> '.count($docIdsArr).'</div>';
                        $progressBarStr.='<div><strong>Answered questions:</strong> '.$quesCnt.'</div>';
                        $progressBarStr.='<div><strong>'.round($quesPercentage).'%</strong> completed so far.</div>';
                        //$progressBarStr='<div style="width:40%"><progress value="'.round($quesPercentage).'" max="100"></progress> </div>';
                        //$progressBarStr.='<div style="width:40%"><div width="100%" style="background-color:#ccc;border-radius: .25rem;"><div style="width:'.round($quesPercentage).'%;background-color:#039cfd;height:35px;border-radius: .25rem;\">&nbsp;</div></div></div>';
                        $lineItems.=$progressBarStr;
                    }

                    $lineItems.='</li>';
                }
                $lineItems.='</ul>';
                $progressBar=$lineItems;
            }

            $replaceArr[$sI]=$progressBar;
        }
        if($sI=='[LINE_ITEM_NAME]') {
           // $lineItemName = $rsInvLineItem->service_id;
            $lineItemName = $rsInvLineItem->line_item;
            $replaceArr[$sI]=$lineItemName;
        }

        if($sI=='[AGENT]') {
            $clientName = $rsClient->client_fname.' '.$rsClient->client_lname;
            $replaceArr[$sI]=$clientName;
        }

        if($sI=='[COMMENTS]') {
            $message = $rsQuestionnaire->message;
            $replaceArr[$sI]=$message;
        }


        if($sI=='[CLIENT_NAME]') {
            $clientName = $rsClient->client_fname.' '.$rsClient->client_lname;
            $replaceArr[$sI]=$clientName;
        }
        if($sI=='[CLIENT_EMAIL]') {
            $replaceArr[$sI]=$rsClient->client_email;
        }
        if($sI=='[CLIENT_ADDRESS]') {
            $clientAddress = $rsClient->client_address.'<br/> '.$rsClient->client_city.' '.$rsClient->client_state;
            $replaceArr[$sI]=$clientAddress;
        }
        if($sI=='[CLIENT_PHONE]') {
            $clientPhone = $rsClient->client_phone;
            $replaceArr[$sI]=$clientPhone;
        }
        if($sI=='[CLIENT_PASS]') {
            $replaceArr[$sI]=$rsClient->client_pass;
        }
        if($sI=='[ACCOUNT_LINK]') {
            $replaceArr[$sI]=BASE_URL."accounts/";
        }

        if($sI=='[LEAD_NAME]') {
            $leadName = $rsLead->lead_fname.' '.$rsLead->lead_lname;
            $replaceArr[$sI]=$leadName;
        }
        if($sI=='[LEAD_ADDRESS]') {
            $leadAddress = $rsLead->lead_address.'<br/> '.$rsLead->lead_city.' '.$rsLead->lead_state;
            $replaceArr[$sI]=$leadAddress;
        }
        if($sI=='[LEAD_PHONE]') {
            $leadPhone = $rsLead->client_phone;
            $replaceArr[$sI]=$leadPhone;
        }

        if($sI=='[QUOTATION_ID]') {
            $replaceArr[$sI]=$quotationId;
        }

        if($sI=='[INVOICE_ID]') {
            $replaceArr[$sI]=$invoiceId;
        }
        if($sI=='[LEAD_ID]') {
            $replaceArr[$sI]=$leadId;
        }

        if($sI=='[INVOICE_PAYMENT_ID]') {
            $replaceArr[$sI]=$invoicePaymentId;
        }

        if($sI=='[INVOICE_PAYMENT_AMOUNT]') {
            $replaceArr[$sI]=$rsInvPayment->amount_paid;
        }
        if($sI=='[INVOICE_PAYMENT_TXN]') {
            $replaceArr[$sI]=$rsInvPayment->txn_id;
        }
        if($sI=='[INVOICE_PAYMENT_DATE]') {
            $replaceArr[$sI]=date('M d, Y',strtotime($rsInvPayment->added_date));
        }

        if($sI=='[PAYMENT_LINK]' && $paramType=='IS') {
            $replaceArr[$sI]=ACCOUNT_LINK.'installment_payment.php?id='.$installmentId;
        }

        if($sI=='[INSTALLMENT_PAYMENT_LINK]')
        {
            $replaceArr[$sI]=ACCOUNT_LINK.'installment_payment.php?id='.$installmentId;
        }
        if($sI=='[PAYMENT_LINK]' && $paramType=='Q') {
            $replaceArr[$sI]=ACCOUNT_LINK.'payment.php?id='.$quotationId;
        }

    }

    $emailBody =str_replace(array_keys($replaceArr), $replaceArr, $emailBody);
    $emailSubject =str_replace(array_keys($replaceArr), $replaceArr, $emailSubject);

    echo htmlspecialchars_decode($emailSubject)."@@||@@".htmlspecialchars_decode($emailBody);

    exit;
}
	
  if($_POST['act']=='sendEmail') {
	ob_clean();
	 
	
	$quotationId = $_POST['quotation_id'];
	$invoiceId = $_POST['invoice_id'];
	$clientId = $_POST['client_id'];
	$toAddress = $_POST['to_email_address'];
	if($clientId>0) {
	$qry ="SELECT * from `".TBL_CLIENTS."` WHERE id = ".$clientId;
	$rsClient= dB::sExecuteSql($qry);
	}
	
	$leadId = $_POST['lead_id'];
	if($leadId>0) {
	$qry ="SELECT * from `".TBL_LEADS."` WHERE id = ".$leadId;
	$rsLead= dB::sExecuteSql($qry);
	}
	$invoicePaymentId = $_POST['invoice_payment_id'];
	if($invoicePaymentId>0) {
		$qry ="SELECT * from `".TBL_INVOICE_PAYMENT."` WHERE id = ".$invoicePaymentId;
		$rsInvPayment= dB::sExecuteSql($qry);
		$invoiceId= $rsInvPayment->invoice_id;	
		$qry ="SELECT * from `".TBL_INVOICE."` WHERE id = ".$rsInvPayment->invoice_id;
		$rsInvoice= dB::sExecuteSql($qry);	
		$clientId= $rsInvPayment->client_id;	
		$qry ="SELECT * from `".TBL_CLIENTS."` WHERE id = ".$clientId;
		$rsClient= dB::sExecuteSql($qry);
	}
	
	$installmentId = $_POST['installment_id'];
	if($installmentId>0) {
		$qry ="SELECT * from `".TBL_INVOICE_INSTALLMENT."` WHERE id = ".$installmentId;
		$rsInstallment= dB::sExecuteSql($qry);
		if($rsInstallment->is_paid=='Y') {
		
		$qry ="SELECT * from `".TBL_INVOICE_PAYMENT."` WHERE installment_id = ".$installmentId;
		$rsInvPayment= dB::sExecuteSql($qry);
		$invoicePaymentId = $rsInvPayment->id;
		$invoiceId= $rsInvPayment->invoice_id;	
		$qry ="SELECT * from `".TBL_INVOICE."` WHERE id = ".$rsInvPayment->invoice_id;
		$rsInvoice= dB::sExecuteSql($qry);	
		$clientId= $rsInvPayment->client_id;	
		$qry ="SELECT * from `".TBL_CLIENTS."` WHERE id = ".$clientId;
		$rsClient= dB::sExecuteSql($qry);
		} 		
	}
	 
	 $questionnaireCommentId = $_POST['quest_comment_id']; 	
	if($questionnaireCommentId>0) { 		
		//LINE ITEM_ID 		
		$qry ="SELECT * from `".TBL_QUESTIONNAIRE_COMMENTS."` WHERE id = ".$questionnaireCommentId;
		$rsQuesCmts= dB::sExecuteSql($qry);	
        $rsQuestionnaire = $rsQuesCmts->message;	

     $qry ="SELECT * from `".TBL_QUESTIONNAIRE_DTLS."` WHERE id = ".$rsQuestionnaire->questionnaire_id;
	 $rsQuestionnaireDtls= dB::sExecuteSql($qry);	
	 		
		 
		$qry ="SELECT * from `".TBL_INVOICE_LINE_ITEM."` WHERE id = ".$rsQuestionnaire->invoice_line_item_id;
		$invLineDtls = dB::sExecuteSql($qry); 	

        $qry ="SELECT * from `".TBL_USERS."` WHERE id = ".$invLineDtls->specialist_id;
		$rsUsers = dB::sExecuteSql($qry); 	

     if($rsQuestionnaire->added_type=='A') { 
        $qry ="SELECT * from `".TBL_USERS."` WHERE id = ".$rsQuestionnaire->added_by;
		$rsPostedBy = dB::sExecuteSql($qry); 
		$posted_by = $rsPostedBy->contact_fname.' '.$rsPostedBy->contact_lname;
	 }  	 
	 
	  if($rsQuestionnaire->added_type=='C') { 
        $qry ="SELECT * from `".TBL_CLIENTS."` WHERE id = ".$rsQuestionnaire->added_by;
		$rsPostedBy = dB::sExecuteSql($qry); 
		$posted_by = $rsPostedBy->client_fname.' '.$rsPostedBy->client_lname;
	 }

  		
	}
	
	  $invoiceLineItem = $_POST['invoice_line_item_id'];
	
	if($invoiceLineItem>0) {
	    $qry ="SELECT * from `".TBL_INVOICE_LINE_ITEM."` WHERE id = ".$invoiceLineItem;
		$rsInvLineItem= dB::sExecuteSql($qry);	
		
		$qry ="SELECT * from `".TBL_USERS."` WHERE id = ".$rsInvLineItem->specialist_id;
		$rsUsers = dB::sExecuteSql($qry); 	  
		 
	 }
	  
		
	$paramType  = $_POST['param_type'];
	$emailTemplateId = $_POST['email_template_id'];
	$language  = $_POST['language'];
	$emailSubject  = $_POST['email_subject'];
	$emailBody  = $_POST['email_body'];
	
	$qry ="SELECT * from `".TBL_EMAIL_TEMPLATE."` WHERE id = ".$emailTemplateId;
	$rsDtl= dB::sExecuteSql($qry);
	if($emailSubject=='') {  $emailSubject = $rsDtl->email_subject;   }
	if($emailBody=='') {  $emailBody = $rsDtl->email_body;   }
	
	$notesArr = explode(',',$rsDtl->notes);
    $notesArr=array("[CLIENT_NAME]","[INSTALLMENT_PAYMENT_LINK]","[Q_FIELD]","[INVOICE_ID]","[LINE_ITEM_NAME]","[COMMENTS]","[POSTED_BY]","[CLIENT_EMAIL]","[CLIENT_PASS]","[ACCOUNT_LINK]","[SERVICES]","[PROGRESS]","[IMAGE]","[DAYS_TO_COMPLETE]");
    $serviceObj=new Invoice();
	foreach($notesArr as $K=>$V) {
		
		$sI=trim($V);
		if($sI=='[Q_FIELD]') {
		    $questionnaire = $rsQuestionnaireDtls->document_name;
			$replaceArr[$sI]=$questionnaire;
	   }

        if($sI=='[SERVICES]') {
            if($invoiceLineItem > 0)
                $replaceArr[$sI]=$rsInvLineItem->line_item;
            else
            {
                $qry ="SELECT * from `".TBL_INVOICE_LINE_ITEM."` WHERE invoice_id = ".$invoiceId;
                $rsInvLineItem= dB::sExecuteSql($qry);
                $lineItems='<ul>';
                foreach($rsInvLineItem as $IK => $IV)
                {
                  $lineItems.='<li>'.$IV->line_item.'</li>';
                }
                $lineItems.='</ul>';
                $replaceArr[$sI]=$lineItems;
            }
        }

        if($sI=='[DAYS_TO_COMPLETE]')
        {
            $qry ="SELECT * from `".TBL_SERVICES."` WHERE id = ".$rsInvLineItem->service_id;
            $rsService= dB::sExecuteSql($qry);

            $now = time();
            $dateArr=explode(" ",$rsInvLineItem->added_date);

            $service_date = strtotime($dateArr[0]);
            $datediff = $now - $service_date;

            $diff= round($datediff / (60 * 60 * 24));

            $daysToComplete=$rsService->days_allowed_for_questionnaire;

            $replaceArr[$sI]=$daysToComplete-$diff;
            if($replaceArr[$sI]<0)
                $replaceArr[$sI]=0;
        }

        if($sI=='[PROGRESS]' || $sI=='[IMAGE]') {
            $progressBar='';
            if($invoiceLineItem > 0)
            {
                $serviceObj->invoice_line_item_id=$invoiceLineItem;
                $is_questionnaire=$serviceObj->isQuestionnaire();
                if($is_questionnaire)
                {
                    $param = array('tableName'=>TBL_SERVICES,'fields'=>array('document_id'),'condition'=>array('id'=>$rsInvLineItem->service_id.'-INT'));
                    $rsService = Table::getData($param);
                    $docIds=$rsService->document_id;
                    $docIdsArr=explode(",",$docIds);
                    $docIdsArr=array_unique($docIdsArr);

                    $serviceObj->docIds=$docIds;
                    $quesCnt=$serviceObj->getQuestionnaireDetailsByDoc();

                    $quesPercentage=($quesCnt/count($docIdsArr))*100;
                    $progressBar='<div><strong>No. of questions:</strong> '.count($docIdsArr).'</div>';
                    $progressBar.='<div><strong>Answered questions:</strong> '.$quesCnt.'</div>';
                    $progressBar.='<div><strong>'.round($quesPercentage).'%</strong> completed so far.</div>';
                    //$progressBar.='<div style="width:40%"><div width="100%" style="background-color:#ccc;border-radius: .25rem;"><div style="width:'.round($quesPercentage).'%;background-color:#039cfd;height:35px;border-radius: .25rem;\">&nbsp;</div></div></div>';
                    $progressBar=round($quesPercentage);
                }
            }
            else
            {
                $qry ="SELECT * from `".TBL_INVOICE_LINE_ITEM."` WHERE invoice_id = ".$invoiceId;
                $rsInvLineItem= dB::sExecuteSql($qry);
                $lineItems='<ul>';
                foreach($rsInvLineItem as $IK => $IV)
                {
                    $lineItems.='<li>'.$IV->line_item;

                    $serviceObj->invoice_line_item_id=$IV->id;
                    $is_questionnaire=$serviceObj->isQuestionnaire();
                    $progressBar='';
                    if($is_questionnaire)
                    {
                        $param = array('tableName'=>TBL_SERVICES,'fields'=>array('document_id'),'condition'=>array('id'=>$rsInvLineItem->service_id.'-INT'));
                        $rsService = Table::getData($param);
                        $docIds=$rsService->document_id;
                        $docIdsArr=explode(",",$docIds);
                        $docIdsArr=array_unique($docIdsArr);

                        $serviceObj->docIds=$docIds;
                        $quesCnt=$serviceObj->getQuestionnaireDetailsByDoc();

                        $quesPercentage=($quesCnt/count($docIdsArr))*100;

                        $progressBarStr='<div><strong>No. of questions:</strong> '.count($docIdsArr).'</div>';
                        $progressBarStr.='<div><strong>Answered questions:</strong> '.$quesCnt.'</div>';
                        $progressBarStr.='<div><strong>'.round($quesPercentage).'%</strong> completed so far.</div>';
                        //$progressBarStr='<div style="width:40%"><progress value="'.round($quesPercentage).'" max="100"></progress> </div>';
                        //$progressBarStr.='<div style="width:40%"><div width="100%" style="background-color:#ccc;border-radius: .25rem;"><div style="width:'.round($quesPercentage).'%;background-color:#039cfd;height:35px;border-radius: .25rem;\">&nbsp;</div></div></div>';
                        $lineItems.=$progressBarStr;
                    }

                    $lineItems.='</li>';
                }
                $lineItems.='</ul>';
                $progressBar=$lineItems;
            }

            $replaceArr[$sI]=$progressBar;
        }
	   if($sI=='[LINE_ITEM_NAME]') {
		    $lineItemName = $rsInvLineItem->line_item;
			$replaceArr[$sI]=$lineItemName;
	   }
	   
	   if($sI=='[AGENT]') {
		    $clientName = $rsClient->client_fname.' '.$rsClient->client_lname;
			$replaceArr[$sI]=$clientName;
	   }
	   
	   if($sI=='[COMMENTS]') {
		    $message = $rsQuestionnaire->message;
			$replaceArr[$sI]=$message;
	   } 	   
	   
	   
	   if($sI=='[CLIENT_NAME]') {
		    $clientName = $rsClient->client_fname.' '.$rsClient->client_lname;
			$replaceArr[$sI]=$clientName;
	   }
	   if($sI=='[CLIENT_EMAIL]') {		
		$replaceArr[$sI]=$rsClient->client_email;
   		}
	   if($sI=='[CLIENT_ADDRESS]') {
		    $clientAddress = $rsClient->client_address.'<br/> '.$rsClient->client_city.' '.$rsClient->client_state;
			$replaceArr[$sI]=$clientAddress;
	   }
	   if($sI=='[CLIENT_PHONE]') {
		    $clientPhone = $rsClient->client_phone;
			$replaceArr[$sI]=$clientPhone;
	   }
	   if($sI=='[CLIENT_PASS]') {		
		$replaceArr[$sI]=$rsClient->client_pass;
	   }
	   if($sI=='[ACCOUNT_LINK]') {		
			$replaceArr[$sI]=BASE_URL."accounts/";
	   }

	   if($sI=='[LEAD_NAME]') {
		    $leadName = $rsLead->lead_fname.' '.$rsLead->lead_lname;
			$replaceArr[$sI]=$leadName;
	   }
	   if($sI=='[LEAD_ADDRESS]') {
		    $leadAddress = $rsLead->lead_address.'<br/> '.$rsLead->lead_city.' '.$rsLead->lead_state;
			$replaceArr[$sI]=$leadAddress;
	   }
	   if($sI=='[LEAD_PHONE]') {
		    $leadPhone = $rsLead->client_phone;
			$replaceArr[$sI]=$leadPhone;
	   }

	   if($sI=='[QUOTATION_ID]') {
			$replaceArr[$sI]=$quotationId;
	   }

	   if($sI=='[INVOICE_ID]') {
			$replaceArr[$sI]=$invoiceId;
	   }
	   if($sI=='[LEAD_ID]') {
			$replaceArr[$sI]=$leadId;
	   }

	   if($sI=='[INVOICE_PAYMENT_ID]') {
			$replaceArr[$sI]=$invoicePaymentId;
	   }

	   if($sI=='[INVOICE_PAYMENT_AMOUNT]') {
			$replaceArr[$sI]=$rsInvPayment->amount_paid;
	   }
	   if($sI=='[INVOICE_PAYMENT_TXN]') {
			$replaceArr[$sI]=$rsInvPayment->txn_id;
	   }
	   if($sI=='[INVOICE_PAYMENT_DATE]') {
			$replaceArr[$sI]=date('M d, Y',strtotime($rsInvPayment->added_date));
	   }

	   if($sI=='[PAYMENT_LINK]' && $paramType=='IS') {
			$replaceArr[$sI]=ACCOUNT_LINK.'installment_payment.php?id='.$installmentId;
	   }

	   if($sI=='[INSTALLMENT_PAYMENT_LINK]')
	   {
		 $replaceArr[$sI]=ACCOUNT_LINK.'installment_payment.php?id='.$installmentId;
	   }
	   if($sI=='[PAYMENT_LINK]' && $paramType=='Q') {
			$replaceArr[$sI]=ACCOUNT_LINK.'payment.php?id='.$quotationId;
	   }

	}
	
	$emailBody =str_replace(array_keys($replaceArr), $replaceArr, $emailBody);
	$emailSubject =str_replace(array_keys($replaceArr), $replaceArr, $emailSubject);

	/*$search = $notesArr;
	$replace = $replaceArr;		
	$emailBody = str_replace($search, $replace, $emailBody);
	$emailSubject = str_replace($search, $replace, $emailSubject);*/
    
	/*if($paramType=='IS' || $paramType=='I' || $paramType=='C' || $paramType=='IP') {
	   $toAddress = $rsClient->client_email;
	}
	
	if($paramType=='L') {
		$toAddress = $rsLead->lead_email;
	}*/
	
	if($paramType=='Q-A') {
		//agent email
		$toAddress = $rsUsers->contact_email; 		
	}
	if($paramType=='Q-C') {
		//CLIENT EMAIL
	  $toAddress = $rsClient->client_fname;		
	}
		
	if(strstr(BASE_URL,'bizplaneasy.com'))
	{
	
	//use PHPMailer\PHPMailer\PHPMailer;
	//use PHPMailer\PHPMailer\Exception;
	
	require 'PHPMailer/src/Exception.php';
	require 'PHPMailer/src/PHPMailer.php';
	require 'PHPMailer/src/SMTP.php';	
	

	$mail = new PHPMailer();   
    if($emailTemplateId=='5' && 1==2){
    echo $finalEmailHTML = generateMailContent('',$emailBody);
	exit;
	}
    $finalEmailHTML = generateMailContent('',$emailBody);

    $logObj = new Logs();
    if($quotationId > 0)
    {
        $tblName=TBL_QUOTATION;
        $refId=$quotationId;
    }
    if($invoiceId > 0)
    {
        $tblName=TBL_INVOICE;
        $refId=$invoiceId;
    }
    if($invoiceLineItem > 0)
    {
        $tblName=TBL_INVOICE_LINE_ITEM;
        $refId=$invoiceLineItem;
    }
    else
    {
        $tblName=TBL_CLIENTS;
        $refId=$clientId;
    }

    $logparam['table_name']=$tblName;
        $logparam['key_field']='id';
        $logparam['key_value']=$refId;
        $logparam['process_type']="EMAIL";
        $logparam['description']=urlencode("A mail has been sent from ".$_SESSION['name']." To ".$toAddress.". Email content below:<br>".$emailBody);
        $logObj->params=$logparam;
    $logObj->logInfo();
	
	try {
    //Server settings
    $mail->SMTPDebug = 2;                                       // Enable verbose debug output
    $mail->isSMTP();                                            // Set mailer to use SMTP
    $mail->Host       = 'email-smtp.us-east-1.amazonaws.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'AKIAV6VOGF6A2SW4EACC';                     // SMTP username
    $mail->Password   = 'BPq9hAB7wThsvuZpsGWrITKeAwk8C96Iep5T5AhWkqbK';                               // SMTP password
    $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
    $mail->Port       = 587;                                    // TCP port to connect to

    //Recipients
	
if($emailTemplateId==9)
{
    $mail->setFrom('no-reply@bizplaneasy.com');
    $mail->addReplyTo('no-reply@bizplaneasy.com');
}
        else{
    $mail->setFrom('no-reply@bizplaneasy.com',  $_SESSION['name'].' from BizPlanEasy');
    $mail->addReplyTo('no-reply@bizplaneasy.com',  $_SESSION['name'].' from BizPlanEasy');
        }
    

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
	$mail->AddBcc('support@mastermindsolutionsonline.com');
	$emailAddress = explode(',',$toAddress);
	foreach($emailAddress as $K=>$V) {
			 $mail->AddAddress($V); 	
			}
			
	//$mail->AddAddress($toAddress);
	//$mail->AddAddress("support@mastermindsolutionsonline.com");
	$mail->AddBcc("kavitharjn@Gmail.com");

	$mail->Subject =  $emailSubject;                
	$mail->Body = $finalEmailHTML;
    $mail->send();
	ob_clean();
    echo 'Email Sent Successfully';
	
		
} catch (Exception $e) {
		ob_clean();
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
	}
	else{
		ob_clean();
        $logObj = new Logs();
        if($quotationId > 0)
        {
            $tblName=TBL_QUOTATION;
            $refId=$quotationId;
        }
        if($invoiceId > 0)
        {
            $tblName=TBL_INVOICE;
            $refId=$invoiceId;
        }
        if($invoiceLineItem > 0)
        {
            $tblName=TBL_INVOICE_LINE_ITEM;
            $refId=$invoiceLineItem;
        }
        else
        {
            $tblName=TBL_CLIENTS;
            $refId=$clientId;
        }
        $logparam['table_name']=$tblName;
        $logparam['key_field']='id';
        $logparam['key_value']=$refId;
        $logparam['process_type']="EMAIL";
        $logparam['description']=urlencode("A mail has been sent from ".$_SESSION['name']." To ".$toAddress.". Email content below:<br>".$emailBody);
        $logObj->params=$logparam;
        //$logObj->logInfo();
		echo $finalEmailHTML = generateMailContent('',$emailBody);
    echo 'Email Sent Successfully';
	}

	exit();  
  }

  if($action=='loadEmailTemplate') {
	$emailTemplateId = $_POST['email_template_id'];
	$language = $_POST['language'];
	$qry ="SELECT * from `".TBL_EMAIL_TEMPLATE."` WHERE id=".$emailTemplateId;
	$rsDtls = dB::sExecuteSql($qry);
	ob_clean();
	if($language=='EN') {
	  echo htmlspecialchars_decode(trim($rsDtls->email_subject)).'::'.htmlspecialchars_decode($rsDtls->email_body);	
	}
	if($language=='SP') {
	  echo htmlspecialchars_decode(trim($rsDtls->spanish_email_subject)).'::'.htmlspecialchars_decode($rsDtls->spanish_email_body);	
	}
	exit();  
  }

 if($action=='showQuestionnaire') {
	 ob_clean();
	 include "build_questionnaire.php";
	 exit();   
   }
   
   if($action=='showClientEmail') {
	ob_clean();
	include "send_client_email.php";
	exit();   
   }
   
   if($action=='showSendEmail') {
	 ob_clean();
	 include "send_email.php";
	 exit();   
   }
  
  if($action=='updateLineItemProcess'){
	ob_clean();
	extract($_POST);
	
	if($checkedval==1)
	{
		$param['invoice_id']=$invoice_id;
		$param['invoice_line_item_id']=$invoice_line_item_id;
		$param['step_name']=$step;
		$param['added_by']=$_SESSION['user_id'];  
		$param['added_date']=date('Y-m-d H:i:s',time());		
	
		$rsDtls = Table::insertData(array('tableName'=>TBL_INVOICE_LINE_ITEM_PROCESS,'fields'=>$param,'showSql'=>'N'));		

	}
	else{
		$where= array('invoice_id'=>$invoice_id,'invoice_line_item_id'=>$invoice_line_item_id,'step_name'=>$step);
		Table::deleteData(array('tableName'=>TBL_INVOICE_LINE_ITEM_PROCESS,'fields'=>$param,'where'=>$where,'showSql'=>'N')); 		
	}
	
	exit();
  }
  
 if($action == 'show_installment') {
	 ob_clean();
	  $reportType = $_POST['type'];
	   $qry = "SELECT II.* from `".TBL_INVOICE_INSTALLMENT."` II join `".TBL_INVOICE."` I on I.id=II.invoice_id where is_deleted='N' order by installment_date ASC";
	 if($reportType=='month') {
			$qry = "SELECT II.* from `".TBL_INVOICE_INSTALLMENT."` II join `".TBL_INVOICE."` I on I.id=II.invoice_id where  MONTH(installment_date) = ".$_POST['mn']." and is_deleted='N' order by installment_date ASC";
	 }
	 elseif($reportType=='date') {
			$qry = "SELECT II.* from `".TBL_INVOICE_INSTALLMENT."` II join `".TBL_INVOICE."` I on I.id=II.invoice_id where installment_date = '".date('Y-m-d',strtotime($_POST['month']))."' and is_deleted='N'  order by installment_date ASC";
	 }
	 elseif($reportType=='range') {
			$qry = "SELECT II.* from `".TBL_INVOICE_INSTALLMENT."` II join `".TBL_INVOICE."` I on I.id=II.invoice_id where installment_date BETWEEN '".date('Y-m-d',strtotime($_POST['from_date']))."' AND '".date('Y-m-d',strtotime($_POST['to_date']))."' and is_deleted='N' order by installment_date ASC";
	 }
	 else
		$qry = "SELECT II.* from `".TBL_INVOICE_INSTALLMENT."` II join `".TBL_INVOICE."` I on I.id=II.invoice_id where is_deleted='N' order by installment_date ASC";


	$rsInstallment =  dB::mExecuteSql($qry);
	
	if($_POST['page']=='')	$page=1;	else	$page = $_POST['page'];
	$totalCount = count($rsInstallment);
	$totalPages= ceil(($totalCount)/(PAGE_LIMIT));
	if($totalPages==0) $totalPages=1;
	$StartIndex= ($page-1)*PAGE_LIMIT;
	if(count($rsInstallment)>0) $listingArr = array_slice($rsInstallment,$StartIndex,PAGE_LIMIT,true);	
	
    include 'dash_installment_list.php'; 	  
	
	exit();
 }
  
 if($action == 'show_pending_installment') {
	ob_clean();
	
   $qry = "SELECT II.* from `".TBL_INVOICE_INSTALLMENT."` II join `".TBL_INVOICE."` I on I.id=II.invoice_id where is_deleted='N' and installment_date <= '".date('Y-m-d')."' and is_paid!='Y' order by installment_date ASC";
	

   $rsInstallment =  dB::mExecuteSql($qry);
   
   if($_POST['page']=='')	$page=1;	else	$page = $_POST['page'];
   $totalCount = count($rsInstallment);
   $totalPages= ceil(($totalCount)/(PAGE_LIMIT));
   if($totalPages==0) $totalPages=1;
   $StartIndex= ($page-1)*PAGE_LIMIT;
   if(count($rsInstallment)>0) $listingArr = array_slice($rsInstallment,$StartIndex,PAGE_LIMIT,true);	
   
   include 'dash_installment_list.php'; 	  
   
   exit();
} 
  
 if($action == 'show_dash_leads') {
	 ob_clean();	 
	 $reportType = $_POST['type'];
	 if($reportType=='month') {
			$qry = "SELECT * from `".TBL_LEADS."` where status='A' and MONTH(lead_added_date) = ".$_POST['mn'];
	 }
	 elseif($reportType=='date') {
			$qry = "SELECT * from  `".TBL_LEADS."` where status='A' and lead_added_date = '".date('Y-m-d',strtotime($_POST['month']))."'";
	 }
	 elseif($reportType=='range') {
			$qry = "SELECT * from  `".TBL_LEADS."` where status='A' and lead_added_date BETWEEN '".date('Y-m-d',strtotime($_POST['from_date']))."' AND '".date('Y-m-d',strtotime($_POST['to_date']))."'";
	 }
	 else
		$qry = "SELECT * from `".TBL_LEADS."` where status='A'";

	$rsLeads =  dB::mExecuteSql($qry);
	if($_POST['page']=='')	$page=1;	else	$page = $_POST['page'];
	$totalCount = count($rsLeads);
	$totalPages= ceil(($totalCount)/(PAGE_LIMIT));
	if($totalPages==0) $totalPages=1;
	$StartIndex= ($page-1)*PAGE_LIMIT;
	if(count($rsLeads)>0) $listingArr = array_slice($rsLeads,$StartIndex,PAGE_LIMIT,true);
	
    include 'dash_leads_list.php'; 	  
	
	exit();
 }
 
if($action == 'show_revenue') {
	 ob_clean();
	 $reportType = $_POST['type'];
     $rType=$_POST['rType'];

	 if($reportType=='month') {
		$qry = "SELECT IP.* from `".TBL_INVOICE_PAYMENT."` IP join `".TBL_INVOICE."` I on I.id=IP.invoice_id where MONTH(IP.added_date) = ".$_POST['mn']." and is_deleted='N'";
	 }
	 elseif($reportType=='date') {
			$qry = "SELECT IP.* from `".TBL_INVOICE_PAYMENT."` IP join `".TBL_INVOICE."` I on I.id=IP.invoice_id where IP.added_date = '".date('Y-m-d',strtotime($_POST['month']))."' and is_deleted='N'";
	 }
	 elseif($reportType=='range') {
			$qry = "SELECT IP.* from `".TBL_INVOICE_PAYMENT."` IP join `".TBL_INVOICE."` I on I.id=IP.invoice_id where IP.added_date BETWEEN '".date('Y-m-d',strtotime($_POST['from_date']))."' AND '".date('Y-m-d',strtotime($_POST['to_date']))."' and is_deleted='N'";
	 }
	 else
		$qry = "SELECT IP.* from `".TBL_INVOICE_PAYMENT."` IP join `".TBL_INVOICE."` I on I.id=IP.invoice_id where is_deleted='N'";

    if($rType!='')
    {
        if($rType=='new')
            $qry.=" and is_downpayment='Y'";
        else
            $qry.=" and is_installment='Y'";
    }
    $qry.=" order by IP.added_date DESC";

	$rsRevenue =  dB::mExecuteSql($qry);
	if($_POST['page']=='')	$page=1;	else	$page = $_POST['page'];
	$totalCount = count($rsRevenue);
	$totalPages= ceil(($totalCount)/(PAGE_LIMIT));
	if($totalPages==0) $totalPages=1;
	$StartIndex= ($page-1)*PAGE_LIMIT;
	if(count($rsRevenue)>0) $listingArr = array_slice($rsRevenue,$StartIndex,PAGE_LIMIT,true);
	
    include 'dash_revenue_list.php'; 	  
	
	exit();
 }
  
 
 if($action == 'show_invoices') {
	 ob_clean();
	 $reportType = $_POST['type'];
	 if($reportType=='month') {
			$qry = "SELECT * from 	`".TBL_INVOICE."` where  MONTH(added_date) = ".$_POST['mn']." and is_deleted='N' order by added_date DESC";
	 }
	 elseif($reportType=='date') {
			$qry = "SELECT * from `".TBL_INVOICE."` where added_date = '".date('Y-m-d',strtotime($_POST['month']))."' and is_deleted='N'  order by added_date DESC";
	 }
	 elseif($reportType=='range') {
			$qry = "SELECT * from `".TBL_INVOICE."` where added_date BETWEEN '".date('Y-m-d',strtotime($_POST['from_date']))."' AND '".date('Y-m-d',strtotime($_POST['to_date']))."' and is_deleted='N' order by added_date DESC";
	 }
	 else
		$qry = "SELECT * from `".TBL_INVOICE."` where is_deleted='N' order by added_date DESC";

	$rsInvoices =  dB::mExecuteSql($qry);
	if($_POST['page']=='')	$page=1;	else	$page = $_POST['page'];
	$totalCount = count($rsInvoices);
	$totalPages= ceil(($totalCount)/(PAGE_LIMIT));
	if($totalPages==0) $totalPages=1;
	$StartIndex= ($page-1)*PAGE_LIMIT;
	if(count($rsInvoices)>0) $listingArr = array_slice($rsInvoices,$StartIndex,PAGE_LIMIT,true);
	
    include 'dash_invoices_list.php'; 	  
	
	exit();
 }

 

 
 if($action=='get_statistics'){
	 $invoiceObj = new Invoice();
	 $reportType = $_POST['type'];
	 $invoiceObj->reportType=$reportType;
	 if($reportType=='month') {
		$invoiceObj->month=$_POST['month'];
		$invoiceObj->monthName = $_POST['mn'];
	 }
	 if($reportType=='date') {
		$invoiceObj->dateField=$_POST['dateField'];
	 }
	 if($reportType=='range') {
		$invoiceObj->from_date=$_POST['from_date'];
		$invoiceObj->to_date=$_POST['to_date'];
	 }
	 $statArr = $invoiceObj->getSalesStatistics();
	 ob_clean();
	 echo $statArr;
	 exit();
 }
 
if($action=='coupon_code_check') { 
   ob_clean();
    $discountCode = $_POST['coupon_code'];
    if($discountCode=='')  exit();
    $param = array('tableName'=>TBL_DISCOUNT,'fields'=>array('*'),'showSql'=>'N','condition'=>array('discount_code'=>$discountCode.'-CHAR','status'=>'A-CHAR'));
	$rsDiscount = Table::getData($param);   
    if(count($rsDiscount)>0) {  
	
	
     foreach($rsDiscount as $key=>$val) {
		

		$valid_from = date('Y-m-d',strtotime($val->valid_from));
		$valid_to = date('Y-m-d',strtotime($val->valid_to));
		$currentDate = new DateTime();  
		$currentDate->format('d/m/Y');  
		$couponCodeDateBegin = new DateTime($valid_from);
		$couponcodeEndDate  = new DateTime($valid_to);
		
		if ($currentDate->getTimestamp() > $couponCodeDateBegin->getTimestamp() && $currentDate->getTimestamp() < $couponcodeEndDate->getTimestamp()){
	      echo "1::". $val->discount_value.'::'.$val->id.'::'.$val->discount_type; 
		  		 exit();
	    } else    echo "-1::Invalid Coupon Dates";  
				 exit();
 	} 
	}
	else  echo '0::0::0'; 
	
	
    exit(); 

  }
 
  

 if($action=='forgot_password') {
 ob_clean(); 
	    $email = $_POST['email_address'];
		$forgot_password_token = md5($email.date('Y-m-d H:i:s',time()));
		 
		$param = array('tableName'=>TBL_USERS,'fields'=>array('*'),'showSql'=>'N','condition'=>array('username'=>$email.'-CHAR','status'=>'A-CHAR'));
		$rsUsers = Table::getData($param);
	    if(count($rsUsers)>0) { 
		 // echo count($rsUsers);
		   foreach($rsUsers as $key=>$val)

		$emailcontent = array();
		$emailcontent['email'] =$email;
		$emailcontent['name'] = $val->contact_fname.' '.$val->contact_lname; 
		$emailcontent['recover_url'] = BASE_URL.'recovery_password.php?token='.$forgot_password_token;
		 
		$template = file_get_contents("email-templates/forgot_password/reset_link.html"); 
		foreach($emailcontent as $key => $value) {
		$template = str_replace('{{'.$key.'}}', $value, $template);
		} 		   

	$mail = new PHPMailer();                    
	$mail->From = FROM_EMAIL;
	$mail->FromName = FROM_NAME;
	$mail->AddAddress($email);
	$mail->Subject = "Password Reset";                  
	$mail->Body = $template;
	$mail- ishtml(true);
	if(!$mail->Send())
	{
	   echo "Message could not be sent. <p>";
	   echo $emailError = "Mailer Error: " . $mail->ErrorInfo;
	   $is_email_sent = 'Y';
	}
	else
	{
	  echo '<div class="alert alert-primary"><i class="fa fa-info" aria-hidden="true" style="margin-right:0.5em"></i>
		Please check your email address for a link to reset your password</div>';
	}  
	 		  
		  
		   
		    $param=array();
			$param['last_updated'] = date('Y-m-d H:i:s',time());		
			$param['forgot_password_token'] = $forgot_password_token;		
			$where= array('username'=>$email);
			Table::updateData(array('tableName'=>TBL_USERS,'fields'=>$param,'where'=>$where,'showSql'=>'N'));
		
		
		} else {  
		echo '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true" style="margin-right:1em"></i>Email address not found</div>';
		}  
 exit(); }
 
 
 
 
 if($action=='reset_password') {
ob_clean();

	$token = $_POST['token_id'];	
	$password = $_POST['password'];	
	$param = array('tableName'=>TBL_USERS,'fields'=>array('*'),'showSql'=>'Y','condition'=>array('forgot_password_token'=>$token.'-CHAR','status'=>'A-CHAR'));
	$rsUsers = Table::getData($param);
	if(count($rsUsers)>0) {
	foreach($rsUsers as $key=>$val)
		
		$param=array(); 
		$param['last_updated'] = date('Y-m-d H:i:s',time());		
		$param['forgot_password_token'] = '';		
		$param['password'] =$password;		
		$where= array('id'=>$val->id);
	  Table::updateData(array('tableName'=>TBL_USERS,'fields'=>$param,'where'=>$where,'showSql'=>'N'));
	echo '<p> Password Updated Successfully..<a href="'.BASE_URL.'">Login</a>';
		} else { echo 'invalid Token.  Please try again later'; }
exit();	 
 }
 
 
 if($action=='send_quotation') {
 ob_clean();
 
 
  $emailAddress = $_POST['email_address'];   
  
  $quotationId = $_GET['id'];
   		
   include 'quotation_send_email.php';
	
	exit();
 
  
 }

if($action=='add_edit_lead_email') {
    ob_clean();

    $leadId = $_POST['id'];
    $param = array('tableName'=>TBL_LEADS,'fields'=>array('lead_cc_email','id'),'condition'=>array('id'=>$leadId.'-INT'));
    $rsLeads = Table::getData($param);
    foreach($rsLeads as $K=>$V)  $$K=$V;

    ?>
    <div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">

        <div class="modal-body" style="padding:0px;">
        <div class="body-div" style="padding:15px;">
        <label>Update CC Email Addresses <?php echo $lead_fname.' '.$lead_lname; ?></label>
        <div class="card">
        <form method="post" style="padding:30px;">
        <div class="row">
        <div class="col-md-12">   </div>

            <div class="col-md-12">
            <div class="form-group row"> <br/>
                <label class="col-md-12 col-form-label">CC Email Addresses: </label>
                <div class="col-md-7"><br/>
                    <textarea class="form-control" name="lead_cc_email" id="lead_cc_email" ><?php echo $lead_cc_email; ?></textarea>
                    <small style="font-weight: 500;">You can Enter Multiple email address by comma separated</small>
                </div>
            </div>
            <div class="form-group row"> <br/>
                <div class="col-md-12">
                    <button type="button" class="btn btn-primary btn-sm"  onclick="add_edit_lead_email()">Submit</button>
                </div>
            </div>
                <input type="hidden" name="id" id="lead_id_1" value="<?php echo $id; ?>">
                <input type="hidden" name="act" value="addEditLeadEmail">
        </div>
        </div>
        </form>
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

        function add_edit_lead_email() {

            var lead_id = $('#lead_id_1').val();
            var lead_email =  $('#lead_cc_email').val();

            paramData = {'act':'addEditLeadEmail','id':lead_id,'lead_cc_email':lead_email};
            $('#submitBtn').prop('disabled', true);

            ajax({
                a:'leads',
                b:$.param(paramData),
                c:function(){},
                d:function(data){
                    alert('Update Successfully');
                    $('#con-close-modal').modal('hide');
                    $('#submitBtn').prop('disabled', true);
                }});

        }

    </script>
    <?php
    exit;
}

    if($action=='add_edit_lead_address') {
	ob_clean(); 

	$leadId = $_POST['id'];
	$param = array('tableName'=>TBL_LEADS,'fields'=>array('*'),'condition'=>array('id'=>$leadId.'-INT'));
	$rsLeads = Table::getData($param); 	 
	foreach($rsLeads as $K=>$V)  $$K=$V;
					 
	
	?>
	   <div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			 
			<div class="modal-body" style="padding:0px;">
			<div class="body-div" style="padding:15px;">
			 <label>Update Lead Address <?php echo $lead_fname.' '.$lead_lname; ?></label>
				 		<div class="card">	 
				<form method="post" style="padding:30px;">
					<div class="row">
					   <div class="col-md-12">   </div>
					
					
						<div class="col-md-12">
							 <div class="form-group row"> <br/>
						       <label class="col-md-12 col-form-label"> address: </label>
								<div class="col-md-7"><br/>
									 <textarea class="form-control" name="lead_address" id="lead_address" ><?php echo $lead_address; ?></textarea>
								</div>
						     </div> 
							 
							 <div class="form-group row"> <br/>
						       <label class="col-md-12 col-form-label"> City: </label>
								<div class="col-md-7">
									<input type="text" class="form-control" name="lead_city" id="lead_city" value="<?php echo $lead_city; ?>">  <br/>
									 
								</div>
						     </div> 
							 
							 <div class="form-group row"> <br/>
						       <label class="col-md-12 col-form-label"> State: </label>
								<div class="col-md-7">
									<input type="text" class="form-control" name="lead_state" id="lead_state" value="<?php echo $lead_state; ?>">  <br/>
									<input type="hidden"   name="id" id="lead_id_1" value="<?php echo $id; ?>">
									<input type="hidden"  name="act"  value="addEditLeadAddress">
								</div>
						     </div> 
						   
						   
						   <div class="form-group row"> <br/>
						      <div class="col-md-12">
									 <button type="button" class="btn btn-primary btn-sm"  onclick="add_edit_lead_address()">Submit</button>
								</div>
						     </div> 
							 
						</div>					
					</div>
					</form>
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
	  
	function add_edit_lead_address() {
		 
	var lead_address =  $('#lead_address').val();
	var lead_city =  $('#lead_city').val();
	var lead_state = $('#lead_state').val();   
	var lead_id = $('#lead_id_1').val();   
		 
		 
	paramData = {'act':'addEditLeadAddress','id':lead_id,'lead_state':lead_state,'lead_city':lead_city,'lead_address':lead_address };
    $('#submitBtn').prop('disabled', true);
  
	ajax({ 
		a:'leads',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		 alert('Update Successfully');	
 $('#con-close-modal').modal('hide'); 	
 $('#submitBtn').prop('disabled', true); 
		}});
	 	
}   
	  
</script>
 
	
   <?php  exit();	   
   } 
   

 if($_POST['act']=='installment_date') { 
        ob_clean();
		$installment_start_date = $_POST['installment_start_date'];
		$installment_period =  intval($_POST['installment_period']);
		$installment_payment_type = $_POST['installment_payment_type'];
		$final_amount = floatval($_POST['final_amount']);
		$installment_downpayment = floatval($_POST['installment_downpayment']);
	    $endDate = date('m/d/Y', strtotime("+".($installment_period-1)." months", strtotime($installment_start_date)));
		$finalAmount = $final_amount - $installment_downpayment;
		echo $endDate.'::'.($finalAmount/$installment_period);
		exit(); 
	 }   
 if($action=='add_edit_quotation') {
	 

	 $leadId =    $param['lead_id']= $_POST['lead_id'];
    $param['subject']=$_POST['subject'];
    $param['introduction']=$_POST['introduction'];
	 $param['conclusion']=$_POST['conclusion'];
	$param['internal_comments']=$_POST['internal_comments'];
	$param['is_discount']='N';
	$param['discount_code']='';
	$param['discount_type']='';
	$param['discount_value']='';
	$param['discount_amount']='';
	 
	if($_POST['is_discount']=='Y') { 
    $param['is_discount']= 'Y';	
    $param['discount_id']=$_POST['discount_code_id'];
	
	$paramDiscount = array('tableName'=>TBL_DISCOUNT,'fields'=>array('*'),'condition'=>array('id'=>$_POST['discount_code_id'].'-INT'));
	$rsDiscount = Table::getData($paramDiscount);
	
	
    $param['discount_code']=$rsDiscount->discount_code;
    $param['discount_type']=$rsDiscount->discount_type;
    $param['discount_value']=$rsDiscount->discount_value;
	}
    $param['discount_amount']=$_POST['couponcode_amount'];
    $param['quotation_amount']=$_POST['total_amount_before'];
    $param['final_amount']=$_POST['final_amount'];
    $param['balance_amount']=$_POST['final_amount'];
	
	$param['installment']='N';	
	$param['installment_downpayment']='';
    $param['installment_period']='';
    $param['installment_amount']='';
    $param['installment_start_date']='';
    $param['installment_end_date']='';
	
	if($_POST['installment']=='Y') {  
    $param['installment']='Y';
    $param['installment_downpayment']=$_POST['installment_downpayment'];
	$param['installment_type']=$_POST['installment_payment_type'];
    $param['installment_period']=$_POST['installment_period'];
	
	if($param['installment_type']=='A') {
	$dueDatesArr = calculate_due_dates($_POST['installment_period'],$_POST['installment_start_date']);	
    $param['installment_start_date']=date('Y-m-d',strtotime($_POST['installment_start_date']));
    $param['installment_end_date']=date('Y-m-d',strtotime($_POST['installment_end_date']));
    $param['installment_amount']=$_POST['installment_amount'];
	} else {
		$param['installment_start_date']=date('Y-m-d',strtotime($_POST['installment_date'][0]));
	    $param['installment_end_date']=date('Y-m-d',strtotime($_POST['installment_date'][count($_POST['installment_date'])-1]));
	}
	}
    $param['sent_date']=date('Y-m-d');
    $param['sent_by']=$_POST['user_id'];
	
	$param2 = array('tableName'=>TBL_CLIENTS,'fields'=>array('*'),'condition'=>array('lead_id'=>$leadId.'-INT'));
	$rsClientDtls = Table::getData($param2);  
	if($rsClientDtls[0]->id>0) { $param['client_id'] = $rsClientDtls[0]->id; }
	
	if($_POST['quotation_id']=='') {
    $param['added_by']=$_SESSION['user_id'];  
    $param['added_date']=date('Y-m-d H:i:s',time());		
 
	$rsDtls = Table::insertData(array('tableName'=>TBL_QUOTATION,'fields'=>$param,'showSql'=>'N')); 
	$explode = explode('::',$rsDtls);    $quotation_id = $explode[2];
	$param=array();
    $param['quotation_sent']= 'Y';  
	$param['last_updated_date'] = date('Y-m-d H:i:s',time());		
	$param['last_updated_by']= $_SESSION['user_id'];  
	$where= array('id'=>$leadId);
	Table::updateData(array('tableName'=>TBL_LEADS,'fields'=>$param,'where'=>$where,'showSql'=>'N')); 
	
	} else {
		//$param=array();
		$param['updated_date'] = date('Y-m-d H:i:s',time());		
		$param['updated_by']= $_SESSION['user_id'];  
		$where= array('id'=>$_POST['quotation_id']);
		$rsDtls = Table::updateData(array('tableName'=>TBL_QUOTATION,'fields'=>$param,'where'=>$where,'showSql'=>'N')); 
		$explode = explode('::',$rsDtls);    $quotation_id = $explode[2];
		
		$where= array('quotation_id'=>$_POST['quotation_id']);
		Table::deleteData(array('tableName'=>TBL_QUOTATION_LINE_ITEM,'fields'=>$param,'where'=>$where,'showSql'=>'N')); 
	}
   
   
   
     
   $package_id = $_POST['packages_id'];
	
   if(count($package_id)>0) {
		   foreach($package_id as $key=>$val) {    
		    $servicesIdArray=array();
		    $servicesId='';
			 
			$packageName = $_POST['total_package_name_'.$val];
			$packagePrice = $_POST['package_price'][$val];
			$package_id = $val;
			
			 if(count($_POST['service_id'])>0) {
		   foreach($_POST['service_id'] as $K=>$V) {  
		   if($_POST['service_id'][$K][$val]>0) {
			  $servicesIdArray[]  = $_POST['service_id'][$K][$val];
		   }
			   
		   }   $servicesId = implode(',',$servicesIdArray);
		   }
			
   
  
	$paramPackages['quotation_id']=$quotation_id;
	$paramPackages['package_id']=$package_id;
	$paramPackages['line_item']=$packageName;
	$paramPackages['package_price']=$packagePrice;
	$paramPackages['package_services']=$servicesId;
      
	  
	 
    Table::insertData(array('tableName'=>TBL_QUOTATION_LINE_ITEM,'fields'=>$paramPackages,'showSql'=>'N')); 
  }   }
  
   $service_category = $_POST['service_category'];
	
   if(count($service_category)>0) {
		   foreach($service_category as $key=>$val) {    
		  
			$category_name = $_POST['service_category_name_'.$val];
			$category_id = $val;
			
   if(count($_POST['services_list'])>0) {   
			    foreach($_POST['services_list'] as $K=>$V)  {   	
                			
					    $serviceId =  $_POST['services_list'][$K][$val];
                        $amount = $_POST['service_amount_'.$serviceId];                          						 
				        $service_name = $_POST['service_name_'.$serviceId];  
				        $service_desc = $_POST['service_desc'][$serviceId][$val];;  
  if($serviceId!=null) {    
  
    $paramLineItem['quotation_id']=$quotation_id;
    $paramLineItem['line_item']=$service_name;
    $paramLineItem['line_amount']=$amount;
    $paramLineItem['service_id']=$serviceId;
    $paramLineItem['category_id']=$val;
    $paramLineItem['line_desc']=$service_desc;
	
	
  
     Table::insertData(array('tableName'=>TBL_QUOTATION_LINE_ITEM,'fields'=>$paramLineItem,'showSql'=>'N')); 
	 
                           
  } }  }
  
  
	$addNewData=array();
	$paramLineItem=array();
	if(count($_POST['add_new_service_amount'])>0) {
		  foreach($_POST['add_new_service_amount'] as $K1=>$V1) {
			   $serviceItemPrice =  $_POST['add_new_service_amount'][$K1][$val]; 
				 $serviceItemName  = $_POST['add_new_service_item'][$K1][$val];  	
				 $serviceItemDesc = $_POST['add_new_service_desc'][$K1][$val];  	
				 if($serviceItemName!=null) {  
				 
					$paramLineItem['quotation_id']=$quotation_id;
					$paramLineItem['line_item']=$serviceItemName;
					$paramLineItem['line_amount']=$serviceItemPrice;
					$paramLineItem['category_id']=$val;
					$paramLineItem['line_desc']=$serviceItemDesc;

			Table::insertData(array('tableName'=>TBL_QUOTATION_LINE_ITEM,'fields'=>$paramLineItem,'showSql'=>'N')); 

				 }
			  
		}   }
		 			
   } 

	$addLine=array();
	$paramLineItem=array();
	if(count($_POST['add_new_line_item'])>0) {
		  foreach($_POST['add_new_line_item'] as $K2=>$V2) {
			  
			   $addNewlinePrice = intval($_POST['add_new_price'][$K2]); 
			   $addNewlineName = $_POST['add_new_line_item'][$K2]; 
			   $addNewlineDesc = $_POST['add_new_line_desc'][$K2]; 
			   if($addNewlinePrice>0) {  
			$paramLineItem['line_desc']=$addNewlineDesc;
			$paramLineItem['quotation_id']=$quotation_id;
			$paramLineItem['line_item']=$addNewlineName;
			$paramLineItem['line_amount']=$addNewlinePrice;
			
			Table::insertData(array('tableName'=>TBL_QUOTATION_LINE_ITEM,'fields'=>$paramLineItem,'showSql'=>'N')); 

			   }
		} } 
   } 
   

   $installmentParam=array();
     if($_POST['installment']=='Y') {  
	   dB::deleteSql("DELETE FROM  `".TBL_QUOTATION_INSTALLMENT."` WHERE quotation_id=".$quotation_id." and lead_id =".$_POST['lead_id']);
       if($_POST['installment_payment_type']=='M') { 
	   if(count($_POST['installment_date'])){
	    foreach($_POST['installment_date'] as $key=>$val) {
		$installmentParam['quotation_id']=$quotation_id;	
		$installmentParam['lead_id']=$_POST['lead_id'];
 		$installmentParam['installment_date']=date('Y-m-d',strtotime($_POST['installment_date'][$key]));
		$installmentParam['amount']=$_POST['amount'][$key];
		$installmentParam['last_updated_by']=$_SESSION['user_id'];  
		$installmentParam['last_updated_date']=date('Y-m-d H:i:s',time());
		 Table::insertData(array('tableName'=>TBL_QUOTATION_INSTALLMENT,'fields'=>$installmentParam,'showSql'=>'N')); 	
		}
	 }
	  } else {
		foreach($dueDatesArr as $key=>$val) {
		$installmentParam['quotation_id']=$quotation_id;	
		$installmentParam['lead_id']=$_POST['lead_id'];
		$installmentParam['installment_date']=date('Y-m-d',strtotime($val));
		$installmentParam['amount']=$_POST['installment_amount'];
		$installmentParam['last_updated_by']=$_SESSION['user_id'];  
		$installmentParam['last_updated_date']=date('Y-m-d H:i:s',time());
		 Table::insertData(array('tableName'=>TBL_QUOTATION_INSTALLMENT,'fields'=>$installmentParam,'showSql'=>'N')); 	
		}
		  
		  
		  
	  }
	 
	 } 
 exit();
  }  
  
  if($action=='add_edit_invoice') {
	 
	 
    $param['subject']=$_POST['subject'];
    $param['introduction']=$_POST['introduction'];
	$param['conclusion']=$_POST['conclusion'];
	$param['internal_comments']=$_POST['internal_comments'];
 
	$param['is_discount']='N';
	$param['discount_code']='';
	$param['discount_type']='';
	$param['discount_value']='';
	$param['discount_amount']='';
	 
	if($_POST['is_discount']=='Y') { 
    $param['is_discount']= 'Y';	
    $param['discount_id']=$_POST['discount_code_id'];
	
	$paramDiscount = array('tableName'=>TBL_DISCOUNT,'fields'=>array('*'),'condition'=>array('id'=>$_POST['discount_code_id'].'-INT'));
	$rsDiscount = Table::getData($paramDiscount);
	
	
    $param['discount_code']=$rsDiscount->discount_code;
    $param['discount_type']=$rsDiscount->discount_type;
    $param['discount_value']=$rsDiscount->discount_value;
	}
    $param['discount_amount']=$_POST['couponcode_amount'];
    $param['quotation_amount']=$_POST['total_amount_before'];
    $param['final_amount']=$_POST['final_amount'];

    $paramInv = array('tableName'=>TBL_INVOICE_PAYMENT,'fields'=>array('*'),'condition'=>array('invoice_id'=>$_POST['invoice_id'].'-INT'));
    $rsInv = Table::getData($paramInv);
    $paidAmt=0;
    foreach($rsInv as $PK => $PV)
    {
        $paidAmt+=$PV->amount_paid;
    }

    $param['balance_amount']=$_POST['final_amount']-$paidAmt;
	if($param['balance_amount']<0)
        $param['balance_amount']=0;
	$param['installment']='N';	
	$param['installment_downpayment']='';
    $param['installment_period']='';
    $param['installment_amount']='';
    $param['installment_start_date']='';
    $param['installment_end_date']='';
	
	if($_POST['installment']=='Y') {  
    $param['installment']='Y';
    $param['installment_downpayment']=$_POST['installment_downpayment'];
	$param['installment_type']=$_POST['installment_payment_type'];
    $param['installment_period']=$_POST['installment_period'];
	
	if($param['installment_type']=='A') {
	$dueDatesArr = calculate_due_dates($_POST['installment_period'],$_POST['installment_start_date']);	
    $param['installment_start_date']=date('Y-m-d',strtotime($_POST['installment_start_date']));
    $param['installment_end_date']=date('Y-m-d',strtotime($_POST['installment_end_date']));
    $param['installment_amount']=$_POST['installment_amount'];
	} else {
		$param['installment_start_date']=date('Y-m-d',strtotime($_POST['installment_date'][0]));
	    $param['installment_end_date']=date('Y-m-d',strtotime($_POST['installment_date'][count($_POST['installment_date'])-1]));
	}
	}
    $param['sent_date']=date('Y-m-d');
    $param['sent_by']=$_POST['user_id'];
	
	
	$param['updated_date'] = date('Y-m-d H:i:s',time());		
	$param['updated_by']= $_SESSION['user_id'];  
	$where= array('id'=>$_POST['invoice_id']);
	$rsDtls = Table::updateData(array('tableName'=>TBL_INVOICE,'fields'=>$param,'where'=>$where,'showSql'=>'N')); 
	$explode = explode('::',$rsDtls);    $invoice_id = $explode[2];
	
	//$where= array('invoice_id'=>$_POST['invoice_id']);
	//Table::deleteData(array('tableName'=>TBL_INVOICE_LINE_ITEM,'fields'=>$param,'where'=>$where,'showSql'=>'N')); 
	
   
   
   
     
   $package_ids = $_POST['packages_id'];
	$packageIds=array();
   if(count($package_ids)>0) {
		   foreach($package_ids as $key=>$val) {    
		    $servicesIdArray=array();
		    $servicesId='';
			 
			$packageName = $_POST['total_package_name_'.$val];
			$packagePrice = $_POST['package_price'][$val];
			$package_id = $val;
			
			 if(count($_POST['service_id'])>0) {
		   foreach($_POST['service_id'] as $K=>$V) {  
		   if($_POST['service_id'][$K][$val]>0) {
			  $servicesIdArray[]  = $_POST['service_id'][$K][$val];
		   }
			   
		   }   $servicesId = implode(',',$servicesIdArray);
		   }
			
   
  
	$paramPackages['invoice_id']=$invoice_id;
	$paramPackages['package_id']=$package_id;
	$paramPackages['line_item']=$packageName;
	$paramPackages['package_price']=$packagePrice;
	$paramPackages['package_services']=$servicesId;
    
	$param = array('tableName'=>TBL_INVOICE_LINE_ITEM,'fields'=>array('id'),'condition'=>array('package_id'=>$package_id.'-INT', 'invoice_id'=>$invoice_id.'-INT'));
	$rsInvItem = Table::getData($param);	
	if(count($rsInvItem) > 0)
	{
		$rsInvItem=$rsInvItem[0];
		$where= array('id'=>$rsInvItem->id);
		$rsDtls = Table::updateData(array('tableName'=>TBL_INVOICE_LINE_ITEM,'fields'=>$paramPackages,'where'=>$where,'showSql'=>'N')); 
	}
	else	
	  Table::insertData(array('tableName'=>TBL_INVOICE_LINE_ITEM,'fields'=>$paramPackages,'showSql'=>'N')); 
  $packageIds[]=$package_id;
  }   }
  
  if(count($packageIds) > 0) {
	$qry="DELETE from ".TBL_INVOICE_LINE_ITEM." where invoice_id='".$invoice_id."' and package_id > 0 and package_id not in (".implode(",",$packageIds).")";	  
	dB::deleteSql($qry);
  }
  
  
   $service_category = $_POST['service_category'];
	//print_r($service_category);
   if(count($service_category)>0) {
	   $serviceIds=array();		
		   foreach($service_category as $key=>$val) {    
		  
			$category_name = $_POST['service_category_name_'.$val];
			 $category_id = $val;
			//echo 'am in outer loop';
		
   if(count($_POST['services_list'])>0) {   
   //print_r($_POST['services_list']);
			    foreach($_POST['services_list'] as $K=>$V)  {   	
                			//echo $val."***<br>";
					    $serviceId =  $_POST['services_list'][$K][$val];
						
						
                        $amount = $_POST['service_amount_'.$serviceId];                          						 
				        $service_name = $_POST['service_name_'.$serviceId];  
				        $service_desc = $_POST['service_desc'][$serviceId][$val];;  
  if($serviceId!=null) {    
  $serviceIds[]=$serviceId;
    $paramLineItem['invoice_id']=$invoice_id;
    $paramLineItem['line_item']=$service_name;
    $paramLineItem['line_amount']=$amount;
    $paramLineItem['service_id']=$serviceId;
    $paramLineItem['category_id']=$val;
    $paramLineItem['line_desc']=$service_desc;
	
	$param = array('tableName'=>TBL_INVOICE_LINE_ITEM,'fields'=>array('id'),'condition'=>array('service_id'=>$serviceId.'-INT','category_id'=>$val.'-INT', 'invoice_id'=>$invoice_id.'-INT'),'showSql'=>'Y');
	$rsInvItem = Table::getData($param);	
    $rsInvItem=$rsInvItem[0];
	if($rsInvItem->id > 0)
	{
		
		$where= array('id'=>$rsInvItem->id);
		$rsDtls = Table::updateData(array('tableName'=>TBL_INVOICE_LINE_ITEM,'fields'=>$paramLineItem,'where'=>$where,'showSql'=>'N')); 
	}
	else
    {
        $Sparam = array('tableName'=>TBL_SERVICES,'fields'=>array('delivery_time','delivery_time_duration'),'condition'=>array('id'=>$serviceId.'-INT'));
        $rsServiceItem = Table::getData($Sparam);
        if(count($rsServiceItem) > 0)
        {
            switch($rsServiceItem->delivery_time_duration)
            {
                case "D":
                    $val_to_add="+".$rsServiceItem->delivery_time." day";
                    break;
                case "M":
                    $val_to_add="+".$rsServiceItem->delivery_time." month";
                    break;
            }

            if($rsServiceItem->delivery_time > 1)
                $val_to_add.="s";

            $delivery_due_date=date('Y-m-d',strtotime($val_to_add));

            $paramLineItem['estimated_delivery_date']=$delivery_due_date;
        }

        Table::insertData(array('tableName'=>TBL_INVOICE_LINE_ITEM,'fields'=>$paramLineItem,'showSql'=>'Y'));
    }
	 
                           
  } }    
  }
  
  if(count($serviceIds) > 0) {
	echo $qry="DELETE from ".TBL_INVOICE_LINE_ITEM." where invoice_id='".$invoice_id."' and category_id='".$val."' and service_id > 0 and service_id not in (".implode(",",$serviceIds).")";	  
	dB::deleteSql($qry);
  }
 
  
	$addNewData=array();
	$paramLineItem=array();
	$serviceItemIds=array();
	if(count($_POST['add_new_service_amount'])>0) {
		  foreach($_POST['add_new_service_amount'] as $K1=>$V1) {
			   $serviceItemPrice =  $_POST['add_new_service_amount'][$K1][$val]; 
				 $serviceItemName  = $_POST['add_new_service_item'][$K1][$val];  	
				 $serviceItemDesc = $_POST['add_new_service_desc'][$K1][$val];  	
				 if($serviceItemName!=null) {  
				 
					$paramLineItem['invoice_id']=$invoice_id;
					$paramLineItem['line_item']=$serviceItemName;
					$paramLineItem['line_amount']=$serviceItemPrice;
					$paramLineItem['category_id']=$val;
					$paramLineItem['line_desc']=$serviceItemDesc;

			if($_POST['add_new_service_id'][$K1][$val] > 0)
			{
				$where= array('id'=>$_POST['add_new_service_id'][$K1][$val]);
				$rsDtls = Table::updateData(array('tableName'=>TBL_INVOICE_LINE_ITEM,'fields'=>$paramLineItem,'where'=>$where,'showSql'=>'N'));	
				$serviceItemIds[]=$_POST['add_new_service_id'][$K1][$val];
			}
			else{
			$insRes=Table::insertData(array('tableName'=>TBL_INVOICE_LINE_ITEM,'fields'=>$paramLineItem,'showSql'=>'N')); 
			$insResArr=explode("::",$insRes);
			$serviceItemIds[]=$insResArr[1];
			}
				 }
			  
		}   }
		
		$tmpQry='';
		if(count($serviceItemIds) > 0)
			$tmpQry=" and id not in (".implode(",",$serviceItemIds).")";
		
		$qry="DELETE from ".TBL_INVOICE_LINE_ITEM." where invoice_id='".$invoice_id."' and category_id='".$val."' and service_id='0'".$tmpQry;	  
		dB::deleteSql($qry);	
			
   } 

	$addLine=array();
	$paramLineItem=array();
	$lineItemIds=array();
	if(count($_POST['add_new_line_item'])>0) {
		  foreach($_POST['add_new_line_item'] as $K2=>$V2) {
			  
			   $addNewlinePrice = intval($_POST['add_new_price'][$K2]); 
			   $addNewlineName = $_POST['add_new_line_item'][$K2]; 
			   $addNewlineDesc = $_POST['add_new_line_desc'][$K2]; 
			   if($addNewlinePrice>0) {  
			$paramLineItem['line_desc']=$addNewlineDesc;
			$paramLineItem['invoice_id']=$invoice_id;
			$paramLineItem['line_item']=$addNewlineName;
			$paramLineItem['line_amount']=$addNewlinePrice;
			
			if($_POST['add_new_line_item_id'][$K2] > 0)
			{
				$where= array('id'=>$_POST['add_new_line_item_id'][$K2]);
				$rsDtls = Table::updateData(array('tableName'=>TBL_INVOICE_LINE_ITEM,'fields'=>$paramLineItem,'where'=>$where,'showSql'=>'N'));	
				$lineItemIds[]=$_POST['add_new_line_item_id'][$K2];
			}
			else
			{
				$insRes=Table::insertData(array('tableName'=>TBL_INVOICE_LINE_ITEM,'fields'=>$paramLineItem,'showSql'=>'N')); 
				$insResArr=explode("::",$insRes);
				$lineItemIds[]=$insResArr[1];
			}
			
			   }
		} } 
		$tmpQry='';
		if(count($lineItemIds) > 0)
		  $tmpQry=" and id not in (".implode(",",$lineItemIds).")";
	  
		$qry="DELETE from ".TBL_INVOICE_LINE_ITEM." where invoice_id='".$invoice_id."' and category_id='0' and package_id='0'".$tmpQry;	  
		dB::deleteSql($qry);
   } 
   

   $installmentParam=array();
     if($_POST['installment']=='Y') {  
	   dB::deleteSql("DELETE FROM  `".TBL_INVOICE_INSTALLMENT."` WHERE invoice_id=".$invoice_id);
	   
	   $param = array('tableName'=>TBL_INVOICE,'fields'=>array('client_id'),'condition'=>array('id'=>$invoice_id.'-INT'),'showSql'=>'N');
	   $rsInvoice = Table::getData($param);	
	
       if($_POST['installment_payment_type']=='M') { 
	   if(count($_POST['installment_date'])){
	    foreach($_POST['installment_date'] as $key=>$val) {
		$installmentParam['invoice_id']=$invoice_id;	
		$installmentParam['client_id']=$rsInvoice->client_id;
 		$installmentParam['installment_date']=date('Y-m-d',strtotime($_POST['installment_date'][$key]));
		$installmentParam['amount']=$_POST['amount'][$key];
		$installmentParam['last_updated_by']=$_SESSION['user_id'];  
		$installmentParam['last_updated_date']=date('Y-m-d H:i:s',time());
		 Table::insertData(array('tableName'=>TBL_INVOICE_INSTALLMENT,'fields'=>$installmentParam,'showSql'=>'N')); 	
		}
	 }
	  } else {
		foreach($dueDatesArr as $key=>$val) {
		$installmentParam['invoice_id']=$invoice_id;			
		$installmentParam['client_id']=$rsInvoice->client_id;
		$installmentParam['installment_date']=date('Y-m-d',strtotime($val));
		$installmentParam['amount']=$_POST['installment_amount'];
		$installmentParam['last_updated_by']=$_SESSION['user_id'];  
		$installmentParam['last_updated_date']=date('Y-m-d H:i:s',time());
		 Table::insertData(array('tableName'=>TBL_INVOICE_INSTALLMENT,'fields'=>$installmentParam,'showSql'=>'N')); 	
		}
		  
		  
		  
	  }
	 
	 } 
 exit();
  }
  
  if($action=='generatepdf') {
	 ob_clean();
	 $quotationId = $_POST['id'];
     include "generate_quotation_pdf.php";
	 exit();  
  }
 if($action=='acceptInvoiceDoc')		
 {
	 ob_clean();	 
	 extract($_POST);
	
	 $param=array();	 	
	 $param['is_accepted']= $ischecked?'Y':'N'; 
	 $param['accepted_by']= $_SESSION['user_id'];  
	 $idsArr=explode("-",$ids);
	 $where= array('invoice_line_item_id'=>$idsArr[0],'document_id'=>$idsArr[1]);
	 Table::updateData(array('tableName'=>TBL_QUESTIONNAIRE_DTLS,'fields'=>$param,'where'=>$where,'showSql'=>'N'));
	 exit;
 }
 
 if($_POST['act']=='checkInvoiceDocNotApplicable')		
   {
	   ob_clean();	 	   
	   $idsArr=explode("-",$_POST['ids']);  
	   
	   $param = array('tableName'=>TBL_QUESTIONNAIRE_DTLS,'fields'=>array('*'),'condition'=>array('invoice_line_item_id'=>$idsArr[0].'-INT','document_id'=>$idsArr[1].'-INT'),'showSql'=>'N');
	   $rsQuesDtls = Table::getData($param);
   
	   if(count($rsQuesDtls) > 0)
	   {
		  $invoiceObj = new Invoice();
		  $invoiceObj->invoice_line_item_id=$idsArr[0];
	  
  	      $invoiceObj->document_ids=$idsArr[1]; 
		  
		  $invoiceObj->not_applicable=$_POST['ischecked']?'Y':'N'; 
		  $invoiceObj->updateQuesChildDocs();
	   }
	   else{
		  $docIds=array($idsArr[1]);
		  $param=array();
		    $param['invoice_line_item_id']= $idsArr[0];
			$param['document_id']=$idsArr[1];
			$param['invoice_id']=$_POST['invoice_id'];

			$sql = "SELECT * from `".TBL_DOCUMENTS."` where id = $idsArr[1]";			
			$docRes =  dB::sExecuteSql($sql);

			$param['parent_id']=$docRes->parent_id;
			$param['document_type']= $docRes->doc_type;
			$param['document_name']= strtolower(str_replace(' ','_',clean($docRes->doc_name)));
			$param['document_text']= '';
			$param['not_applicable']=$_POST['ischecked'];  
			$param['added_date'] = date('Y-m-d H:i:s',time());		
			$param['added_by']= $_SESSION['user_id'];
		    $resultArr = Table::insertData(array('tableName'=>TBL_QUESTIONNAIRE_DTLS,'fields'=>$param,'showSql'=>'N')); 
	   }
	   exit;
   }

   if($_POST['act']=='show_today_due')
   {
 	 ob_clean();
	  $qry="select invoice_id from ".TBL_INVOICE_LINE_ITEM." ILI join ".TBL_INVOICE." I on I.id=ILI.invoice_id where is_deleted='N' and specialist_id='".$_SESSION['user_id']."' and estimated_delivery_date='".date('Y-m-d')."'";

	  $todayDueRes= dB::sExecuteSql($qry);
	  
	  foreach($todayDueRes as $key=>$val) $invoicesArr[]=$val->invoice_id; 

	  $qry = 'select * from `'.TBL_INVOICE.'` where id in('.implode(',',$invoicesArr).')';
	  $rsInvoices = dB::mExecuteSql($qry);

	    if($_POST['page']=='')	$page=1;	else	$page = $_POST['page'];
		$totalCount = count($rsInvoices);
		$totalPages= ceil(($totalCount)/(PAGE_LIMIT));
		if($totalPages==0) $totalPages=1;
		$StartIndex= ($page-1)*PAGE_LIMIT;
		if(count($rsInvoices)>0) $listingArr = array_slice($rsInvoices,$StartIndex,PAGE_LIMIT,true);
		include 'e_invoices_list.php'; 	   
	
     exit;
   }

   if($_POST['act']=='show_e_invoices')
   {
	  ob_clean();
	  $type=$_POST['type'];

	  switch($type)
	  {
		  case "today":
		  $qry="select invoice_id from ".TBL_INVOICE_LINE_ITEM." ILI join ".TBL_INVOICE." I on I.id=ILI.invoice_id where is_deleted='N' and specialist_id='".$_SESSION['user_id']."' and estimated_delivery_date='".date('Y-m-d')."'";
		  break;

		  case "week":
		  $first_day_of_the_week = 'Sunday';
		  $start_of_the_week     = strtotime("Last $first_day_of_the_week");
		  if ( strtolower(date('l')) === strtolower($first_day_of_the_week) )
		  {
			  $start_of_the_week = strtotime('today');
		  }
		  $end_of_the_week = $start_of_the_week + (60 * 60 * 24 * 7) - 1;
	  
		  $date_format =  'Y-m-d';
	  
		  $start_date= date($date_format, $start_of_the_week);
		  $end_date= date($date_format, $end_of_the_week);
		  
		   $qry="select invoice_id from ".TBL_INVOICE_LINE_ITEM." ILI join ".TBL_INVOICE." I on I.id=ILI.invoice_id where is_deleted='N' and specialist_id='".$_SESSION['user_id']."' and estimated_delivery_date between '".$start_date."' and '".$end_date."'";
		  break;

		  case "month":
		  $monthStart=date("Y-m")."-01";
		  $monthEnd=date("Y-m-t");
	 
		  $qry="select invoice_id from ".TBL_INVOICE_LINE_ITEM." ILI join ".TBL_INVOICE." I on I.id=ILI.invoice_id where is_deleted='N' and specialist_id='".$_SESSION['user_id']."' and estimated_delivery_date between '".$monthStart."' and '".$monthEnd."'";
		  break;

		  case "overdue":
		  $qry="select invoice_id from ".TBL_INVOICE_LINE_ITEM." ILI join ".TBL_INVOICE." I on I.id=ILI.invoice_id where is_deleted='N' and specialist_id='".$_SESSION['user_id']."' and estimated_delivery_date < '".date('Y-m-d')."'";
		  
		  break;
	  }
	  
	  $itemRes= dB::mExecuteSql($qry);	

	  foreach($itemRes as $key=>$val) $invoicesArr[]=$val->invoice_id; 

	  $qry = 'select * from `'.TBL_INVOICE.'` where id in('.implode(',',$invoicesArr).')';
	  $rsInvoices = dB::mExecuteSql($qry);

	    if($_POST['page']=='')	$page=1;	else	$page = $_POST['page'];
		$totalCount = count($rsInvoices);
		$totalPages= ceil(($totalCount)/(PAGE_LIMIT));
		if($totalPages==0) $totalPages=1;
		$StartIndex= ($page-1)*PAGE_LIMIT;
		if(count($rsInvoices)>0) $listingArr = array_slice($rsInvoices,$StartIndex,PAGE_LIMIT,true);
		include 'e_invoices_list.php'; 	   
	
     exit;
   }
?>