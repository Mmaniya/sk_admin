<?php 
  $html = '<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css" />
<table border="1" cellspacing="0" cellpadding="0" width="680" style="width:510.0px;background:#ffffff;border:solid #cccccc 1.0px;font-family: \'Lato\', Verdana, sans-serif;">
 <tbody><tr>
  <td valign="top" style="border:none;padding:0cm 0cm 0cm 0cm">
  <div align="center">
  <table border="0" cellspacing="0" cellpadding="0" width="580" style="width:435.0px">
   <tbody><tr>
    <td valign="top" style="padding:22.5px 7.5px 0cm 7.5px"></td>
   </tr>
   <tr>
    <td valign="top" style="border:none;border-bottom:solid #3179bc 2.25px;padding:0cm 7.5px 0cm 7.5px">
    <p align="center" style="text-align:center">
	<img border="0" src="https://www.bizplaneasy.com/images/bizplaneasylogo2014.png" alt="BizPlanEasy" /><u></u> </p>
    </td>
   </tr>
   <tr>
    <td valign="top" style="padding:0cm 7.5px 22.5px 7.5px"></td>
   </tr>
	
   <tr>
    <td valign="top" style="padding:0cm 0cm 12.0px 0cm">
    <p style="line-height:13.5px"><span style="font-size:16px;color:black"><strong>Hey [CLIENT_NAME]</strong>,</span></p>
    </td>
   </tr>
   <tr>
    <td valign="top" style="padding:0cm 0cm 21.0px 0cm">
    <p>Thank you for your order! Your transaction with BizPlanEasy was successful.</p>
    </td>
   </tr>
   <tr>
    <td valign="top" style="padding:0cm 0cm 24.0px 0cm">
    <div align="center">
    <table border="1" cellspacing="0" cellpadding="0" width="580" style="width:435.0px;border:solid #edebeb 1.0px">
     <tbody><tr>
      <td valign="top" style="border:none;padding:0cm 0cm 0cm 0cm">
      <div align="center">
      <table border="0" cellspacing="5" cellpadding="0" width="100%" style="width:100.0%">
       <tbody><tr>
        <td valign="top" style="border-top:none;border-left:none;border-bottom:solid #edebeb 1.0px;border-right:solid #edebeb 1.0px;background:#ffffff;padding:7.5px 7.5px 7.5px 0cm">
        <p><b><span style="color:black">Order Amount</span></b></p>
        </td>
        <td valign="top" style="border:none;border-bottom:solid #edebeb 1.0px;background:#ffffff;">
        <p><span style="color:black">[ORDER_AMOUNT]</span></p>
        </td>
       </tr>
       <tr>
        <td valign="top" style="border-top:none;border-left:none;border-bottom:solid #edebeb 1.0px;border-right:solid #edebeb 1.0px;background:#ffffff;padding:7.5px 7.5px 7.5px 0cm">
        <p><b><span style="color:black">Invoice ID</span></b></p>
        </td>
        <td valign="top" style="border:none;border-bottom:solid #edebeb 1.0px;background:#ffffff;">
        <p><span style="color:black">[INSTALLMENT_PAYMENT_ID]</span></p>
        </td>
       </tr>
       <tr>
         <td valign="top" style="border:none;border-right:solid #edebeb 1.0px;background:#ffffff;padding:7.5px 7.5px 7.5px 0cm">
           <p><b><span style="color:black">Order Date &amp; Time</span></b></p>
           </td>
         <td valign="top" style="background:#ffffff;">
           <p><span style="color:black">[INVOICE_DATE_TIME]</span></p>
           </td>
       </tr>
       <tr>
        <td valign="top" style="border:none;border-right:solid #edebeb 1.0px;background:#ffffff;padding:7.5px 7.5px 7.5px 0cm">
        <p><b><span style="color:black">Bank Transaction Identifier</span></b></p>
        </td>
        <td valign="top" style="background:#ffffff;">
        <p><span style="color:black">[TXN_ID]</span></p>
        </td>
       </tr>
      </tbody></table>
      </div>
      </td>
     </tr>
    </tbody></table>
    </div>
    </td>
   </tr>';
   
   
   /* <tr>
    <td valign="top" style="padding:0cm 0cm 24.0px 0cm">
    <div align="center">
    <table border="1" cellspacing="0" cellpadding="0" width="580" style="width:435.0px;border:solid #edebeb 1.0px">
     <tbody><tr>
      <td valign="top" style="border:none;padding:0cm 0cm 0cm 0cm">
      <div align="center">
      <table border="0" cellspacing="5" cellpadding="0" width="100%" style="width:100.0%">
       <tbody><tr>
        <td colspan="2" valign="top" style="border-top:none;border-left:none;border-bottom:solid #edebeb 1.0px;border-right:solid #edebeb 1.0px;background:#ffffff;padding:7.5px 7.5px 7.5px 0cm">
          <p><b><span style="color:#006DCB">You can now access your dedicated account panel by using the below login credentials:</span></b></p>
        </td>
        </tr>
		<tr>
        <td valign="top" style="border-top:none;border-left:none;border-bottom:solid #edebeb 1.0px;border-right:solid #edebeb 1.0px;background:#ffffff;padding:7.5px 7.5px 7.5px 0cm">
        <p><b><span style="color: black">Login URL</span></b></p>
        </td>
        <td valign="top" style="border:none;border-bottom:solid #edebeb 1.0px;background:#ffffff;">
        <p><span style="color:black">Click <a href="[LOGIN_URL]">here</a> to login into your account using the credentials given below</span></p>
        </td>
       </tr>
       <tr>
        <td valign="top" style="border-top:none;border-left:none;border-bottom:solid #edebeb 1.0px;border-right:solid #edebeb 1.0px;background:#ffffff;padding:7.5px 7.5px 7.5px 0cm">
        <p><b><span style="color: black">Username</span></b></p>
        </td>
        <td valign="top" style="border:none;border-bottom:solid #edebeb 1.0px;background:#ffffff;">
        <p><span style="color:black">[CLIENT_EMAIL]</span></p>
        </td>
       </tr>
       <tr>
        <td valign="top" style="border-top:none;border-left:none;border-bottom:solid #edebeb 1.0px;border-right:solid #edebeb 1.0px;background:#ffffff;padding:7.5px 7.5px 7.5px 0cm">
        <p><b><span style="color: black">Password</span></b></p>
        </td>
        <td valign="top" style="border:none;border-bottom:solid #edebeb 1.0px;background:#ffffff;">
        <p><span style="color:black">[CLIENT_PASS]</span></p>
        </td>
       </tr>
      </tbody></table>
      </div>
      </td>
     </tr>
    </tbody></table>
    </div>
    </td>
   </tr>*/
   $html .= ' <tr>
    <td valign="top" style="padding:0cm 0cm 42.0px 0cm">
    <p ><span style="color:black">Best regards,<br /><br />
    </span><span style="color:#5b5b5b">Support Team<br />BizPlanEasy <br/> support@bizplaneasy.com
    </span> </p></td>
   </tr>
   <tr>
    <td valign="top" style="padding:0cm 0cm 24.0px 0cm">
    <div align="center">
    <table border="0" cellspacing="0" cellpadding="0" width="580" style="width:435.0px;background:#f7faf0">
     <tbody><tr>
      <td valign="top" style="padding:15.0px 24.0px 15.0px 24.0px">
      <div align="center">
      <table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%">
       <tbody><tr>
        <td valign="top" style="padding:7.5px 7.5px 12.0px 0cm">
        <p><b><span style="color:black">Any questions?</span></b></p>
        </td>
       </tr>
       <tr>
        <td valign="top" style="padding:0cm 0cm 0cm 0cm">
        <table border="0" cellspacing="0" cellpadding="0" align="left" width="100%" style="width:100.0%">
         <tbody><tr>
          <td valign="top" style="padding:0cm 6.0px 9.0px 0cm">
          <p><span style="font-size:12px;color:black;background:#e1e6d5">1</span> </p>
          </td>
          <td valign="top" style="padding:0cm 0cm 9.0px 0cm">
          <p><span style="font-size:13px;color:black">If you have any questions regarding your order, please contact our support team at support@bizplaneasy.com
          </span></p>
          </td>
         </tr>
        
        </tbody></table>
        </td>
       </tr>
      </tbody></table>
      </div>
      </td>
     </tr>
    </tbody></table>
    </div>
    </td>
   </tr>
</tbody></table></div></td></tr></tbody></table>';

	
	/*
		
		[ORDER_AMOUNT] [INVOICE_ID] [INVOICE_DATE_TIME] [TXN_ID] [CLIENT_EMAIL] [CLIENT_PASS] 
		
				
		*/
		$param = array('tableName'=>TBL_INVOICE_PAYMENT,'fields'=>array('*'),'condition'=>array('id'=>$invoice_payment_id.'-INT'),'showSql'=>'Y');
		$rsInvPayment = Table::getData($param);		

		$param = array('tableName'=>TBL_CLIENTS,'fields'=>array('*'),'condition'=>array('id'=>$client_id.'-INT'),'showSql'=>'N');
		$rsClient = Table::getData($param);		
		 
		 
		 $loginUrl = CLIENT_URL;
		$search = array('[ORDER_AMOUNT]','[INVOICE_PAYMENT_ID]','[INVOICE_DATE_TIME]','[TXN_ID]','[CLIENT_EMAIL]','[CLIENT_PASS]','[CLIENT_NAME]','[LOGIN_URL]');
		$replace = array(money($rsInvPayment->amount_paid,'$'),$invoice_payment_id,date('M d,Y h:i A',strtotime($rsInvPayment->added_date)),$transactionID,$rsClient->client_email,
		                 $rsClient->client_pass,$rsClient->client_fname.' '.$rsClient->client_lname);		
		$html = str_replace($search, $replace, $html);		
		
	//	use PHPMailer\PHPMailer\PHPMailer;
	//	use PHPMailer\PHPMailer\Exception;
		
		require_once 'PHPMailer/src/Exception.php';
		require_once 'PHPMailer/src/PHPMailer.php';
		require_once 'PHPMailer/src/SMTP.php';
		
		 $emailAddress = explode(',',$rsClient->client_email);  
		 $emailSubject = "[BizPlanEasy] Installment Received for Order Id: ".$rsInvPayment->invoice_id." Thank you for your order, ".$rsClient->client_fname.' '.$rsClient->client_lname; 
		  print_r($emailAddress);
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
			$mail->Body = $html;
			$mail->send();
			
			// send success notification
			$mail = new PHPMailer();   
			$mail->SMTPDebug = 2;                                       // Enable verbose debug output
			$mail->isSMTP();                                            // Set mailer to use SMTP
			$mail->Host       = 'email-smtp.us-east-1.amazonaws.com';  // Specify main and backup SMTP servers
			$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
			$mail->Username   = 'AKIAV6VOGF6A2SW4EACC';                     // SMTP username
			$mail->Password   = 'BPq9hAB7wThsvuZpsGWrITKeAwk8C96Iep5T5AhWkqbK';                               // SMTP password
			$mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
			$mail->Port       = 587;                                    // TCP port to connect to
		
			//Recipients
			$mail->setFrom('support@bizplaneasy.com', 'BPE Payment Success Notifications');
			$mail->addReplyTo('support@bizplaneasy.com', 'BizPlanEasy Alert System');
			

			$mail->isHTML(true);
			$mail->AddAddress('support@bizplaneasy.com');
			$mail->AddAddress('kavitharjn@gmail.com');
			$emailSubject = "[BizPlanEasy] Installment for Order Id: ".$rsInvPayment->invoice_id." Payment Successful "; 
			$mail->Subject =  $emailSubject;                
			
			$html = '<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css" />
			<table border="1" cellspacing="0" cellpadding="0" width="680" style="width:510.0px;background:#ffffff;border:solid #cccccc 1.0px;font-family: \'Lato\', Verdana, sans-serif;">
			<tbody><tr>
			<td valign="top" style="border:none;padding:0cm 0cm 0cm 0cm">
			<div align="center">
			<table border="0" cellspacing="0" cellpadding="0" width="580" style="width:435.0px">
			<tbody><tr>
			<td valign="top" style="padding:22.5px 7.5px 0cm 7.5px"></td>
			</tr>
			<tr>
			<td valign="top" style="border:none;border-bottom:solid #3179bc 2.25px;padding:0cm 7.5px 0cm 7.5px">
			<p align="center" style="text-align:center">
			<img border="0" src="https://www.bizplaneasy.com/images/bizplaneasylogo2014.png" alt="BizPlanEasy" /><u></u> </p>
			</td>
			</tr>
			<tr>
			<td valign="top" style="padding:0cm 7.5px 22.5px 7.5px"></td>
			</tr>
			
			<tr>
			<td valign="top" style="padding:0cm 0cm 12.0px 0cm">
			<p style="line-height:13.5px"><span style="font-size:16px;color:black"><strong>Hey BizPlanEasy Team,</strong>,</span></p>
			</td>
			</tr>
			<tr>
			<td valign="top" style="padding:0cm 0cm 21.0px 0cm">
			<p>A new order has been placed successfully. The details of the order is listed below:</p>
			</td>
			</tr>
			<tr>
			<td valign="top" style="padding:0cm 0cm 24.0px 0cm">
			<div align="center">
			<table border="1" cellspacing="0" cellpadding="0" width="580" style="width:435.0px;border:solid #edebeb 1.0px">
			<tbody><tr>
			<td valign="top" style="border:none;padding:0cm 0cm 0cm 0cm">
			<div align="center">
			<table border="0" cellspacing="5" cellpadding="0" width="100%" style="width:100.0%">
			<tbody>
			<tr>
			<td valign="top" style="border:none;border-right:solid #edebeb 1.0px;background:#ffffff;padding:7.5px 7.5px 7.5px 0cm">
			<p><b><span style="color:black">Client Name</span></b></p>
			</td>
			<td valign="top" style="background:#ffffff;">
			<p><span style="color:black">[CLIENT_NAME]</span></p>
			</td>
			</tr>
			</tbody></table>
			</div>
			</td>
			</tr>
			<tr>
			<td valign="top" style="border-top:none;border-left:none;border-bottom:solid #edebeb 1.0px;border-right:solid #edebeb 1.0px;background:#ffffff;padding:7.5px 7.5px 7.5px 0cm">
			<p><b><span style="color:black">Installment Amount</span></b></p>
			</td>
			<td valign="top" style="border:none;border-bottom:solid #edebeb 1.0px;background:#ffffff;">
			<p><span style="color:black">[ORDER_AMOUNT]</span></p>
			</td>
			</tr>
			<tr>
			<td valign="top" style="border-top:none;border-left:none;border-bottom:solid #edebeb 1.0px;border-right:solid #edebeb 1.0px;background:#ffffff;padding:7.5px 7.5px 7.5px 0cm">
			<p><b><span style="color:black">Invoice ID</span></b></p>
			</td>
			<td valign="top" style="border:none;border-bottom:solid #edebeb 1.0px;background:#ffffff;">
			<p><span style="color:black">[INVOICE_ID]</span></p>
			</td>
			</tr>
			<tr>
			<td valign="top" style="border:none;border-right:solid #edebeb 1.0px;background:#ffffff;padding:7.5px 7.5px 7.5px 0cm">
			<p><b><span style="color:black">Order Date &amp; Time</span></b></p>
			</td>
			<td valign="top" style="background:#ffffff;">
			<p><span style="color:black">[INVOICE_DATE_TIME]</span></p>
			</td>
			</tr>
			<tr>
			<td valign="top" style="border:none;border-right:solid #edebeb 1.0px;background:#ffffff;padding:7.5px 7.5px 7.5px 0cm">
			<p><b><span style="color:black">Bank Transaction Identifier</span></b></p>
			</td>
			<td valign="top" style="background:#ffffff;">
			<p><span style="color:black">[TXN_ID]</span></p>
			</td>
			</tr>
			</tbody></table>
			</div>
			</td>
			</tr>
			
			
			</tbody></table>
			</div>
			</td>
			</tr>
			
			</tbody></table>';
			




		$search = array('[ORDER_AMOUNT]','[INVOICE_ID]','[INVOICE_DATE_TIME]','[TXN_ID]','[CLIENT_EMAIL]','[CLIENT_PASS]','[CLIENT_NAME]');
		$replace = array($rsInvPayment->amount_paid,$rsInvPayment->invoice_id,date('M d,Y h:i A',strtotime($rsInvPayment->added_date)),$transactionID,$rsClient->client_email,
		$rsClient->client_pass,$rsClient->client_fname.' '.$rsClient->client_lname);		
		$html = str_replace($search, $replace, $html);		
		
		$mail->Body = $html;	
		
		$mail->AddAttachment($_SERVER['DOCUMENT_ROOT']."test/invoice_pdf/".$fileName.".pdf");
		$mail->send();		
			
			
		   
		} catch (Exception $e) {
				ob_clean();
			    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}	
		
?>			