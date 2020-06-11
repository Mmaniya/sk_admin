<?php
  
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

  
require("includes.php");

  $emailAddress = explode(',',$_POST['email_address']);   
  
  $quotationId = $_REQUEST['id'];
  include "generate_quotation_pdf.php";	


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
	
	if($quoteServices ['prepared_by']['name']!='') {
	
   $mail->setFrom('no-reply@bizplaneasy.com', $quoteServices ['prepared_by']['name'].' from BizPlanEasy');
    $mail->addReplyTo('no-reply@bizplaneasy.com', $quoteServices ['prepared_by']['name'].' from BizPlanEasy');
	} else {
   $mail->setFrom('no-reply@bizplaneasy.com', 'BizPlanEasy');
    $mail->addReplyTo('no-reply@bizplaneasy.com', 'BizPlanEasy');
		
	}
    
    

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
	//$mail->AddAddress('support@mastermindsolutionsonline.com');
	foreach($emailAddress as $K=>$V)
	$mail->AddAddress($V);
	$mail->AddAddress("support@bizplaneasy.com");
		$mail->AddBCC("kavitharjn@Gmail.com");

	$mail->AddAttachment(dirname(__FILE__)."/quotation_pdf/".$fileName.".pdf");
	$mail->Subject =  $emailSubject;                
	
	$emailHtml.= ' ';
	
	$mail->Body = $emailHtml;
	
	

    $mail->send();
	ob_clean();
    echo 'Quotation Sent Successfully';
	//update status of the quotation
		$param['email_sent']='Y';
		$param['updated_date'] = date('Y-m-d H:i:s',time());		
		$param['updated_by']= $_SESSION['user_id'];  
		$where= array('id'=>$quotationId);
		$rsDtls = Table::updateData(array('tableName'=>TBL_QUOTATION,'fields'=>$param,'where'=>$where,'showSql'=>'N'));
		
} catch (Exception $e) {
		ob_clean();
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

exit();

