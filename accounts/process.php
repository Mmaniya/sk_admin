<?php

	include "includes.php";
	
	
	
	if($_POST['act']=='submitInternalMessages') {
        ob_clean();
        
       $params = array('invoice_line_item_id','invoice_id','message');
       foreach($params as $K=>$V) {  $param[$V]=$$V=check_input($_POST[$V]); } 
                     
       $param['added_date'] = date('Y-m-d H:i:s',time());		
       $param['added_by']= $_SESSION['user_id'];  
       echo $rsDtls = Table::insertData(array('tableName'=>TBL_INTERNAL_MESSAGES,'fields'=>$param,'showSql'=>'N')); 
        
        exit();	
       }
	   
	   
	 if($_POST['act']=='sendQuesReviewEmail') {
	ob_clean();
	$invLineItemId = $_POST['invoice_line_item_id'];
	$clientId = SessionRead('CLIENT_ID');
	
	$param = array('tableName'=>TBL_CLIENTS,'fields'=>array('*'),'condition'=>array('id'=>$clientId.'-INT'),'showSql'=>'N');
     $rsClients = Table::getData($param);
	 $htmlContent = '<p>'.$rsClients->client_fname.' '.$rsClients->client_lname.' has send the questionnaire for your review</p>';
	 
	 $emailBody = generateMailContent("",$htmlContent);
	 
	    
        $qry ="SELECT * from `".TBL_INVOICE_LINE_ITEM."` WHERE id = ".$invLineItemId;
        $rsInvLineItem= dB::sExecuteSql($qry);

        $qry ="SELECT * from `".TBL_USERS."` WHERE id = ".$rsInvLineItem->specialist_id;
        $rsUsers = dB::sExecuteSql($qry);

        $emailAddress = $rsUsers->contact_email;
	 		
		require_once 'PHPMailer/src/Exception.php';
		require_once 'PHPMailer/src/PHPMailer.php';
		require_once 'PHPMailer/src/SMTP.php';
		
		$emailSubject = "[BizPlanEasy]  Send Questionnaire  for Review - BPE -".$invoiceId; 
		  
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
			$mail->AddAddress($emailAddress);			 
			$mail->AddCC('support@bizplaneasy.com');			 
			$mail->Subject =  $emailSubject;                
			$mail->Body = $emailBody;
			$mail->send();
			 } catch (Exception $e) {
				ob_clean();
			    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}		
	
	exit();
	 }
	 
	 
	 
	  if($_POST['act']=='showInternalMessages')
    {
    
            ob_clean();
             
            $invoiceLineItemId = $_POST['invoice_line_item_id'];           
            $invoice_id = $_POST['invoice_id']; 
            $isDashboard=$_POST['dashboard'];
                       
            $param = array('tableName'=>TBL_INVOICE_LINE_ITEM,'fields'=>array('*'),'condition'=>array('id'=>$invoiceLineItemId.'-INT'),'showSql'=>'N');
            $rsLineItem = Table::getData($param);
             
            ?>
            <div class="card">
              <h5 class="card-header bg-primary text-white">BE - <?php echo $invoice_id; ?> - <?php echo $rsLineItem->line_item; ?></h5>
              
            <ul class="comments-list">
            <?php
             $qry = "SELECT * from `".TBL_INTERNAL_MESSAGES."` where  invoice_id = ".$invoice_id." and invoice_line_item_id = ".$invoiceLineItemId;
             $rsMessages =  dB::mExecuteSql($qry);		
             $messageCnt=count($rsMessages);
                if(count($rsMessages)>0) {
                    $cCnt=0;
                  foreach($rsMessages as $key=>$val) { $postedName='';
                    $cCnt++;
                     
                    $qry = "SELECT * from `".TBL_USERS."` where id = ".$val->added_by."";
                    $rsUsers =  dB::sExecuteSql($qry);	
                    $postedName = $rsUsers->contact_fname.' '.$rsUsers->contact_lname;
                       
                    $boldMessage=0; 
                    if($_POST['dashboard'] && $val->is_read=='N')
                         $boldMessage=1; 
                     ?>
                        <li <?php echo $boldMessage?"style='font-weight:bold;'":"";?> <?php echo ($messageCnt==$cCnt)?"id='lastCId'":""?>><?php echo $val->message; ?> <br/> -<small><?php echo $postedName.' '.getTimeAgo(strtotime($val->added_date));?> </small></li>
                        
                     <?php
                     
                  } 
                  
                  } else { echo ' <li>No messages available</li>';  }		?>
            
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
            <input type="hidden" id="invoice_id" value="<?php echo $invoice_id;?>">            
            <textarea class="form-control" id="internal_message"></textarea>
            <button class="bt btn-danger btn-sm" onclick="submitInternalMessages()" style="margin-top:10px;" type="button">Submit</button>
            <button class="btn btn-danger btn-sm float-right" type="button" style="margin-top:10px;" onclick="closeForm()">Close</button>
            </form>
            </div>
             </div>
             <style>
             .comments-list { list-style-type:none;padding-left:10px;  max-height: 400px; overflow-y: scroll;width:100%; }
             .comments-list li {border-bottom:1px solid #00000026;padding-top:10px; }
             </style>
             <script>
             $('.comments-list').animate({scrollTop: $('.comments-list').prop("scrollHeight")}, 500);
             
             function submitInternalMessages() { 	err=0;
             var invLineItemId = $('#invoice_line_item_id').val();
             var invoiceId = $('#invoice_id').val();
             
              if($('#internal_message').val()=='' ){ err=1; $('#internal_message').css("border","1px solid #ff0000 "); } else{  $('#internal_message').css("border","");}
                 var internal_message =  $('#internal_message').val();
             if(err==0) {
                $('#tempMessage'+invLineItemId).val(internal_message);
                 paramData = {'act':'submitInternalMessages','invoice_line_item_id': invLineItemId,"invoice_id":invoiceId,"message":internal_message };
                      ajax({ 
                        a:'invoiceStatus',
                        b:$.param(paramData),
                        c:function(){},
                        d:function(data){  
                        var res = data.split("::");
                        alert(res[1]);                                        
                        showInternalMessages(invLineItemId,invoiceId); 
                        if($('#tempMessage'+invLineItemId).val()!='')
                            $('#lastMessageStr'+invLineItemId).html($('#tempMessage'+invLineItemId).val());
                        }}); 
             } }
                         
             
             </script>
            <?php 
            exit();	
            }
			
			

if($_POST['act']=='showQuestionnaireCmts') {
ob_clean();
 
$invoiceLineItemId = $_POST['invoice_line_item_id'];
$questionnaireId = $_POST['questionnaire_id'];
$documentid = $_POST['document_id']; 

$param = array('tableName'=>TBL_DOCUMENTS,'fields'=>array('*'),'condition'=>array('id'=>$documentid.'-INT'),'showSql'=>'N');
$rsDocument = Table::getData($param);
	
?>
<div class="card">
  <h5 class="card-header bg-primary text-white"> <?php echo $rsDocument->doc_name; ?> <br/><small class="text-white"><?php echo htmlspecialchars_decode($rsDocument->doc_desc); ?></small></h5>
  
<ul class="comments-list">
<?php
  // $qry = "SELECT * from `".TBL_QUESTIONNAIRE_COMMENTS."` where  document_id = ".$documentid." and invoice_line_item_id = ".$invoiceLineItemId." and questionnaire_id = ".$questionnaireId."";
 $qry = "SELECT * from `".TBL_QUESTIONNAIRE_COMMENTS."` where  document_id = ".$documentid." and invoice_line_item_id = ".$invoiceLineItemId."";

 $rsDocuments =  dB::mExecuteSql($qry);		
	if(count($rsDocuments)>0) {
      foreach($rsDocuments as $key=>$val) { $postedName='';
		  if($val->added_type=='C') { 
			$qry = "SELECT * from `".TBL_CLIENTS."` where id = ".$val->added_by."";
			$rsClients =  dB::sExecuteSql($qry);	
			$postedName = $rsClients->client_fname.' '.$rsClients->client_lname;
		  } 		  
		  if($val->added_type=='A') {
             $qry = "SELECT * from `".TBL_USERS."` where id = ".$val->added_by."";
			$rsUsers =  dB::sExecuteSql($qry);	
			$postedName = $rsUsers->contact_fname.' '.$rsUsers->contact_lname;
			  } ?>
		    <li><?php  echo $val->message; ?> <br/> -<small><?php echo $postedName.' '.getTimeAgo(strtotime($val->added_date));?> </small></li>
			
			
		 <?php
	  } } else { echo ' <li>No comments available</li>';  }		?>

</ul>
<form style="padding:10px;">
<input type="hidden" id="invoice_line_item_id" value="<?php echo $invoiceLineItemId;?>">
<input type="hidden" id="document_id" value="<?php echo $documentid;?>">
<input type="hidden" id="questionnaire_id" value="<?php echo $questionnaireId;?>">
<textarea class="form-control" id="ques_comments"></textarea>
<button class="bt btn-danger btn-sm" onclick="submitQuesComments()" style="margin-top:10px;" type="button">Save</button>
</form>
 </div>
 <style>
 .comments-list {     width: 100%; list-style-type:none;padding-left:10px;  max-height: 400px; overflow-y: scroll;}
 .comments-list li {border-bottom:1px solid #00000026;padding-top:10px; }
 </style>
 <script>
 $('.comments-list').animate({scrollTop: $('.comments-list').prop("scrollHeight")}, 500);
 
 function submitQuesComments() { 	err=0;
 var invLineItemId = $('#invoice_line_item_id').val();
 var documentId = $('#document_id').val();
 var questionnaireId = $('#questionnaire_id').val();
  if($('#ques_comments').val()=='' ){ err=1; $('#ques_comments').css("border","1px solid #ff0000 "); } else{  $('#ques_comments').css("border","");}
	 var ques_comments =  $('#ques_comments').val();
 if(err==0) {
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
 
$param['added_type'] = 'C';
$param['added_date'] = date('Y-m-d H:i:s',time());		
$param['added_by']= $_SESSION['CLIENT_ID'];  
  $rsDtls = Table::insertData(array('tableName'=>TBL_QUESTIONNAIRE_COMMENTS,'fields'=>$param,'showSql'=>'N')); 
 
 exit();	
}

  
 if($_POST['act']=='showQuestionnaire') {
	 ob_clean();
	 include "build_questionnaire.php";
	 exit();   
   }
  
    
  
   if($_POST['act']=='viewOrder') {
	 ob_clean();
	 include "view_order.php";
	 exit();   
   }
   
    if($_POST['act']=='sendEmail') {
	ob_clean();
	//print_r($_POST);
	
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
	
	foreach($notesArr as $K=>$V) {
		if($V=='[Q_FIELD]') {
		    $questionnaire = $rsQuestionnaireDtls->document_name;
			$replaceArr[]=$questionnaire;
	   }
	   
	   if($V=='[LINE_ITEM_NAME]') {
		    $lineItemName = $rsInvLineItem->line_item;
			$replaceArr[]=$lineItemName;
	   }
	   
	   if($V=='[AGENT]') {
		    $clientName = $rsClient->client_fname.' '.$rsClient->client_lname;
			$replaceArr[]=$clientName;
	   }
	   
	   if($V=='[COMMENTS]') {
		    $message = $rsQuestionnaire->message;
			$replaceArr[]=$message;
	   } 	   
	   
	   
	   if($V=='[CLIENT_NAME]') {
		    $clientName = $rsClient->client_fname.' '.$rsClient->client_lname;
			$replaceArr[]=$clientName;
	   }
	   if($V=='[CLIENT_ADDRESS]') {
		    $clientAddress = $rsClient->client_address.'<br/> '.$rsClient->client_city.' '.$rsClient->client_state;
			$replaceArr[]=$clientAddress;
	   }
	   if($V=='[CLIENT_PHONE]') {
		    $clientPhone = $rsClient->client_phone;
			$replaceArr[]=$clientPhone;
	   }

	   if($V=='[LEAD_NAME]') {
		    $leadName = $rsLead->lead_fname.' '.$rsLead->lead_lname;
			$replaceArr[]=$leadName;
	   }
	   if($V=='[LEAD_ADDRESS]') {
		    $leadAddress = $rsLead->lead_address.'<br/> '.$rsLead->lead_city.' '.$rsLead->lead_state;
			$replaceArr[]=$leadAddress;
	   }
	   if($V=='[LEAD_PHONE]') {
		    $leadPhone = $rsLead->client_phone;
			$replaceArr[]=$leadPhone;
	   }

	   if($V=='[QUOTATION_ID]') {
			$replaceArr[]=$quotationId;
	   }

	   if($V=='[INVOICE_ID]') {
			$replaceArr[]=$invoiceId;
	   }
	   if($V=='[LEAD_ID]') {
			$replaceArr[]=$leadId;
	   }

	   if($V=='[INVOICE_PAYMENT_ID]') {
			$replaceArr[]=$invoicePaymentId;
	   }

	   if($V=='[INVOICE_PAYMENT_AMOUNT]') {
			$replaceArr[]=$rsInvPayment->amount_paid;
	   }
	   if($V=='[INVOICE_PAYMENT_TXN]') {
			$replaceArr[]=$rsInvPayment->txn_id;
	   }
	   if($V=='[INVOICE_PAYMENT_DATE]') {
			$replaceArr[]=date('M d, Y',strtotime($rsInvPayment->added_date));
	   }

	   if($V=='[PAYMENT_LINK]' && $paramType=='IS') {
			$replaceArr[]=ACCOUNT_LINK.'installment_payment.php?id='.$installmentId;
	   }

	   if($V=='[PAYMENT_LINK]' && $paramType=='Q') {
			$replaceArr[]=ACCOUNT_LINK.'payment.php?id='.$quotationId;
	   }

	}
	
	$search = $notesArr;
	$replace = $replaceArr;		
	$emailBody = str_replace($search, $replace, $emailBody);
	$emailSubject = str_replace($search, $replace, $emailSubject);
    
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
	
	
	
	//use PHPMailer\PHPMailer\PHPMailer;
	//use PHPMailer\PHPMailer\Exception;
	
	require 'PHPMailer/src/Exception.php';
	require 'PHPMailer/src/PHPMailer.php';
	require 'PHPMailer/src/SMTP.php';	
	

	$mail = new PHPMailer();   
    
    $finalEmailHTML = generateMailContent('',$emailBody);
	
	
	
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
	

    $mail->setFrom('no-reply@bizplaneasy.com',  $_SESSION['name'].' from BizPlanEasy');
    $mail->addReplyTo('no-reply@bizplaneasy.com',  $_SESSION['name'].' from BizPlanEasy');
    
    

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
	$mail->AddAddress('support@mastermindsolutionsonline.com');
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


	exit();  
  }
  

   if($_POST['ptype']=='first') {
	/*** Get required parameters from the web form for the request ***/
	$paymentType =urlencode( $_POST['paymentType']);
	$firstName =urlencode( $_POST['clientFName']);
	$lastName =urlencode( $_POST['clientLName']);
	$creditCardType =urlencode( $_POST['creditCardType']);
	$creditCardNumber = urlencode($_POST['creditCardNumber']);
	$expDateMonth =urlencode( $_POST['expDateMonth']);

//Month must be padded with leading zero
	$padDateMonth = str_pad($expDateMonth, 2, '0', STR_PAD_LEFT);
	
	$expDateYear =urlencode( $_POST['expDateYear']);
	$cvv2Number = urlencode($_POST['cvv2Number']);
	$amount = urlencode($_POST['finalAmountVal']);
	$currencyCode="USD";
	
	
		// Create an instance of PaypalPro class
		$paypal = new PaypalPro();
		
		// Payment details
		$paypalParams = array(
			'paymentAction' => 'Sale',
			'itemName' => 'Business Services for Quote Id: '.$_POST['quotationId'],
			'itemNumber' => $_POST['quotationId'],
			'amount' => $amount,
			'currencyCode' => $currencyCode,
			'creditCardType' => $creditCardType,
			'creditCardNumber' => $creditCardNumber,
			'expMonth' => $expDateMonth,
			'expYear' => $expDateYear,
			'cvv' => $cvv2Number,
			'firstName' => $firstName,
			'lastName' => $lastName,
			'city' => $clientCity,
			'zip'	=> $clientZip,
			'countryCode' => 'US',
		);
		
                              
    $response = $paypal->paypalCall($paypalParams);
    $paymentStatus = strtoupper($response["ACK"]);
	
	
	
     
    if($paymentStatus == "SUCCESS"){
		// Transaction info
		$transactionID = $response['TRANSACTIONID'];
		$paidAmount = $response['AMT'];
		
		//store it and convert to client
		//Client is paying for the first time, hence convert the lead to client 
		
		$clientParamArr = array('quotation_id'=>$_POST['quotationId'],'transaction_id'=>$transactionID,'paid_amount'=>$paidAmount);
		$clientObj = new Clients();
		$clientObj->param = $clientParamArr;
		$clientDtls = $clientObj->addNewClient();
		
    
	    $client_id = $clientDtls['client_id'];
		$invoice_id = $clientDtls['invoice_id'];
		$invoice_payment_id = $clientDtls['invoice_payment_id'];
        include "generate_invoice_pdf.php";
        include "order_thankyou_mail.php";
         
		
		ob_clean();
		echo trim('SUCCESS:::'.$transactionID.':::'.$paidAmount.':::'.$_POST['quotationId'].':::'.$client_id.':::'.$invoice_id.':::'.$invoice_payment_id);
		exit();
    }else{
	  ob_clean();	
	 // echo '<pre>';
	  //print_r($response);
	  //print_r($_POST);
	  //echo '</pre>';
	         
	         include "order_failure_mail.php";
		 
		// print_r($response);
 ob_clean();	
       echo $response['L_LONGMESSAGE0'];
	   
	   
	   exit();
    }
	
   }
   
   
   
    if($_POST['ptype']=='installment') {
	/*** Get required parameters from the web form for the request ***/
	$paymentType =urlencode( $_POST['paymentType']);
	$firstName =urlencode( $_POST['clientFName']);
	$lastName =urlencode( $_POST['clientLName']);
	$creditCardType =urlencode( $_POST['creditCardType']);
	$creditCardNumber = urlencode($_POST['creditCardNumber']);
	$expDateMonth =urlencode( $_POST['expDateMonth']);

//Month must be padded with leading zero
	$padDateMonth = str_pad($expDateMonth, 2, '0', STR_PAD_LEFT);
	
	$expDateYear =urlencode( $_POST['expDateYear']);
	$cvv2Number = urlencode($_POST['cvv2Number']);
	$amount = urlencode($_POST['finalAmountVal']);
	$currencyCode="USD";
	
	
		// Create an instance of PaypalPro class
		$paypal = new PaypalPro();
		
		// Payment details
		$paypalParams = array(
			'paymentAction' => 'Sale',
			'itemName' => 'Installment for Invoice Id: '.$_POST['installment_id'],
			'itemNumber' => $_POST['installment_id'],
			'amount' => $amount,
			'currencyCode' => $currencyCode,
			'creditCardType' => $creditCardType,
			'creditCardNumber' => $creditCardNumber,
			'expMonth' => $expDateMonth,
			'expYear' => $expDateYear,
			'cvv' => $cvv2Number,
			'firstName' => $firstName,
			'lastName' => $lastName,
			'city' => $clientCity,
			'zip'	=> $clientZip,
			'countryCode' => 'US',
		);
		
                              
    $response = $paypal->paypalCall($paypalParams);
    $paymentStatus = strtoupper($response["ACK"]);
	
	
	
     
    if($paymentStatus == "SUCCESS"){
		// Transaction info
		$transactionID = $response['TRANSACTIONID'];
		$paidAmount = $response['AMT'];
		
		//insert installment payment
		
		$installmentArr = array('installment_id'=>$_POST['installment_id'],'invoice_id'=>$_POST['invoice_id'],'client_id'=>$_POST['client_id'],'transaction_id'=>$transactionID,'paid_amount'=>$paidAmount);
		

		$invoiceObj = new Invoice();
		$invoicePaymentId = $invoiceObj->installmentPayment($installmentArr);
    
	    $client_id = $_POST['client_id'];
		$invoice_id = $_POST['invoice_id'];
		$installmentPayment = 1;
		$invoice_payment_id = $invoicePaymentId;
        include "generate_invoice_pdf.php";
        include "order_installment_thankyou_mail.php";
         
		
		ob_clean();
		echo trim('SUCCESS:::'.$transactionID.':::'.$paidAmount.':::'.$_POST['installment_id'].':::'.$_POST['client_id'].':::'.$_POST['invoice_id'].':::'.$invoice_payment_id);
		exit();
    }else{
	  ob_clean();	
	 // echo '<pre>';
	  //print_r($response);
	  //print_r($_POST);
	  //echo '</pre>';
	         
	         include "order_failure_mail.php";
		 
		// print_r($response);
 ob_clean();	
       echo $response['L_LONGMESSAGE0'];
	   
	   
	   exit();
    }
	
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
			$param['added_by']= $_SESSION['CLIENT_ID'];
		    $resultArr = Table::insertData(array('tableName'=>TBL_QUESTIONNAIRE_DTLS,'fields'=>$param,'showSql'=>'N')); 
	   }
	   exit;
   }

   if($_REQUEST['act']=="sEcurepAyment")
   {
	   $installmentids=array("59","60");
	   foreach($installmentids as $IK => $IV)
	   {
		   $paid_amount=384;
		   if($IK==1)
		     $paid_amount='384.4';
			$installmentArr = array('installment_id'=>$IV,'invoice_id'=>6165,'client_id'=>16,'transaction_id'=>'manual payment requested by client','paid_amount'=>$paid_amount);
			
			$invoiceObj = new Invoice();
			$invoicePaymentId = $invoiceObj->installmentPayment($installmentArr);
			echo $invoicePaymentId."<br>";
	   }
   }
   

?>