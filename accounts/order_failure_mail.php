<?php 


	
	/*
	    Array ( [TIMESTAMP] => 2019-06-12T15:48:29Z [CORRELATIONID] => 46abec189d18 [ACK] => Failure [VERSION] => 65.1 [BUILD] => 46457558 [L_ERRORCODE0] => 10527 
		[L_SHORTMESSAGE0] => Invalid Data [L_LONGMESSAGE0] => This transaction cannot be processed. Please enter a valid credit card number and type. [L_SEVERITYCODE0] => Error [AMT] => 1.00 [CURRENCYCODE] => USD )
		
		[ORDER_AMOUNT] [INVOICE_ID] [INVOICE_DATE_TIME] [TXN_ID] [CLIENT_EMAIL] [CLIENT_PASS] 
		
				
		*/
			
ini_set('display_errors',1);



		$param = array('tableName'=>TBL_QUOTATION,'fields'=>array('*'),'condition'=>array('id'=>$_POST['quotationId'].'-INT'),'showSql'=>'N');
		$rsQuote = Table::getData($param);		



		$param = array('tableName'=>TBL_LEADS,'fields'=>array('*'),'condition'=>array('id'=>$rsQuote->lead_id.'-INT'),'showSql'=>'Y');
		$rsLead = Table::getData($param);		
		 
		 
		
		
		use PHPMailer\PHPMailer\PHPMailer;
		use PHPMailer\PHPMailer\Exception;
		
		require_once 'PHPMailer/src/Exception.php';
		require_once 'PHPMailer/src/PHPMailer.php';
		require_once 'PHPMailer/src/SMTP.php';
		
		 
		 $mail = new PHPMailer();   
			
		try {
			
			
			// send success notification
			$mail = new PHPMailer();   
			$mail->SMTPDebug = 0;                                       // Enable verbose debug output
			$mail->isSMTP();                                            // Set mailer to use SMTP
			$mail->Host       = 'email-smtp.us-east-1.amazonaws.com';  // Specify main and backup SMTP servers
			$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
			$mail->Username   = 'AKIAV6VOGF6A2SW4EACC';                     // SMTP username
			$mail->Password   = 'BPq9hAB7wThsvuZpsGWrITKeAwk8C96Iep5T5AhWkqbK';                               // SMTP password
			$mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
			$mail->Port       = 587;                                    // TCP port to connect to
		
			//Recipients
			$mail->setFrom('support@bizplaneasy.com', 'BPE Payment Failure Notifications');
			$mail->addReplyTo('support@bizplaneasy.com', 'BizPlanEasy');
			

			$mail->isHTML(true);
			$mail->AddAddress('support@bizplaneasy.com');
			$mail->AddBcc('kavitharjn@gmail.com');
			$emailSubject = "[BizPlanEasy] Quotation Id: ".$_POST['quotationId']." Payment Failure "; 
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
			<p style="line-height:13.5px"><span style="font-size:16px;color:black"><strong>Hey Support Team,</strong>,</span></p>
			</td>
			</tr>
			<tr>
			<td valign="top" style="padding:0cm 0cm 21.0px 0cm">
			<p>Payment Failure for the Order. The details of the order is listed below:</p>
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
			<td valign="top" style="border-top:none;border-left:none;border-bottom:solid #edebeb 1.0px;border-right:solid #edebeb 1.0px;background:#ffffff;padding:7.5px 7.5px 7.5px 0cm">
			<p><b><span style="color:black">Client Name</span></b></p>
			</td>
			<td valign="top" style="background:#ffffff;">
			<p><span style="color:black">[CLIENT_NAME]</span> ([CLIENT_EMAIL])</p>
			</td>
			</tr>
			
			<tr>
			<td valign="top" style="border-top:none;border-left:none;border-bottom:solid #edebeb 1.0px;border-right:solid #edebeb 1.0px;background:#ffffff;padding:7.5px 7.5px 7.5px 0cm">
			<p><b><span style="color:black">Order Amount</span></b></p>
			</td>
			<td valign="top" style="border:none;border-bottom:solid #edebeb 1.0px;background:#ffffff;">
			<p><span style="color:black">[ORDER_AMOUNT]</span></p>
			</td>
			</tr>
			<tr>
			<td valign="top" style="border-top:none;border-left:none;border-bottom:solid #edebeb 1.0px;border-right:solid #edebeb 1.0px;background:#ffffff;padding:7.5px 7.5px 7.5px 0cm">
			<p><b><span style="color:black">Quotation ID</span></b></p>
			</td>
			<td valign="top" style="border:none;border-bottom:solid #edebeb 1.0px;background:#ffffff;">
			<p><span style="color:black">[QUOTATION_ID]</span></p>
			</td>
			</tr>
			<tr>
			<td valign="top" style="border-top:none;border-left:none;border-bottom:solid #edebeb 1.0px;border-right:solid #edebeb 1.0px;background:#ffffff;padding:7.5px 7.5px 7.5px 0cm">
			<p><b><span style="color:black">Order Date &amp; Time</span></b></p>
			</td>
			<td valign="top" style="border:none;border-bottom:solid #edebeb 1.0px;background:#ffffff;">
			<p><span style="color:black">[QUOTATION_DATE_TIME]</span></p>
			</td>
			</tr>
			<tr>
			<td valign="top" style="border-top:none;border-left:none;border-bottom:solid #edebeb 1.0px;border-right:solid #edebeb 1.0px;background:#ffffff;padding:7.5px 7.5px 7.5px 0cm">
			<p><b><span style="color:black">Paypal Error Message</span></b></p>
			</td>
			<td valign="top" style="border:none;border-bottom:solid #edebeb 1.0px;background:#ffffff;">
			<p><span style="color:black">[L_LONGMESSAGE0]</span></p>
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
			
		$search = array('[ORDER_AMOUNT]','[QUOTATION_ID]','[QUOTATION_DATE_TIME]','[CLIENT_EMAIL]','[L_LONGMESSAGE0]','[CLIENT_NAME]');
		$replace = array($response['AMT'],$_POST['quotationId'],date('M d,Y h:i A',strtotime($response['TIMESTAMP'])),$rsLead->lead_email,
		$response['L_LONGMESSAGE0'],$rsLead->lead_fname.' '.$rsLead->lead_lname);		
		$html = str_replace($search, $replace, $html);		
		
		$mail->Body = $html;	
		$mail->send();		
			
			
		   
		} catch (Exception $e) {
				ob_clean();
			    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}	
		
?>			