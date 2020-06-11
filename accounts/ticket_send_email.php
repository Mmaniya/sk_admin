<?php
  
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

  
require("includes.php");
  
 
 if($ticketType=='create') { include "ticket_create_email.php"; }
 if($ticketType=='reply') { include "ticket_reply_email.php"; }
  
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
    $mail->setFrom('support@bizplaneasy.com', 'Marcelo from BizPlanEasy');
    $mail->addReplyTo('support@bizplaneasy.com', 'Marcelo from BizPlanEasy');
    

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
	//$mail->AddAddress('support@mastermindsolutionsonline.com');
	 
	$mail->AddAddress($emailaddress); 
	$mail->AddBcc("kavitharjn@gmail.com"); 
	
	$mail->Subject =  $emailSubject;   
	
	$mail->Body = $introHtml;
	
	

    $mail->send();
	
		
} catch (Exception $e) {
		ob_clean();
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	
}

exit();

