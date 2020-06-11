<?php 
include 'includes.php';

$ticketObj = new tickets;
 $ticketObj->id = $ticketId;
 
if($ticket_to=='C') { 

 $introHtml =" ##- Please DO NOT REPLY to this email -## <br/>
Hi [CLIENT_NAME], <br/><br/>

Thanks for contacting us. Your request has been received and we'll get back to you as soon as possible. Your ticket number is [TICKET_NUMBER] <br/>

You can view your ticket thread in your accounts dashboard. Click here to login to your accounts dashboard.<br/><br/>

<a href=".BASE_URL." target='_blank'>View ticket</a><br/><br/>


Kind regards,<br/><br/>
Customer Success Team<br/><br/>
BizPlanEasy.com";

$ticketDetails =  $ticketObj->getTicketDetails();
$ticketDtls = $tickets['tickets'];
 
	$search = array('[CLIENT_NAME]', '[TICKET_NUMBER]');
	$replace = array($ticketDtls['clients']['name'],'TKE-'.$ticketDtls['id']);		
	$htmlbody = str_replace($search, $replace, $introHtml);
	$emailSubject = '[BPE] Response Received: TKE-'.$ticketDtls['id'];
	$emailaddress = $ticketDtls['clients']['client_email'];
}		
 
 
 
 if($ticket_to=='U') { 

 $introHtml ="Hi Admin, <br/>
   [CLIENT_NAME] has responded to your message for ticket. Details of the ticket is as follows: <br/>


Ticket Id: [TICKET_ID] <br/>
Subject:  [TICKET_SUBJECT] <br/>
Message :  [TICKET_MESSAGE] <br/>

Invoice Id: [INVOICE_ID] <br/>


Please log in to your admin dashboard to respond to the ticket. <br/>

Regards, <br/>
Automated Alert System";

 $ticketDetails =  $ticketObj->getTicketDetails();
$ticketDtls = $tickets['tickets'];
 
 $search = array('[CLIENT_NAME]','[TICKET_ID]','[TICKET_SUBJECT]','[TICKET_MESSAGE]','[INVOICE_ID]');
 $replace = array($ticketDtls['clients']['name'],'TKE-'.$ticketDtls['id'],$ticketDtls['subject'],$ticketDtls['message'],'BPE-'.$ticketDtls['line_item']['invoice_id']);		
 $htmlbody = str_replace($search, $replace, $introHtml);
$emailSubject = '[BPE] Response Received: TKE-'.$ticketDtls['id'];			
$emailaddress = ADMIN_EMAIL;
}		
 
 
 
?>