<?php 
include 'includes.php';

$ticketObj = new tickets;
 
 
if($ticket_to=='C') { 

 $introHtml ="##- Please DO NOT REPLY to this email -## <br/>
Hi [CLIENT_NAME], <br/>

Thanks for contacting us. Customer Service Team has responded to your ticket number <TICKET_NUMBER> 

You can view your ticket thread in your accounts dashboard. Click here to login to your accounts dashboard.

<a href=".BASE_URL." target='_blank'>View ticket</a>


Kind regards,
Customer Success Team
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

 $introHtml ="Hi Admin,
  A ticket has been opened by Client : [CLIENT_NAME]. Details of the ticket is as follows: <br/><br/>


 Ticket Id: [TICKET_ID] <br/>
 Subject:  [TICKET_SUBJECT] <br/>
 Message :  [TICKET_MESSAGE] <br/>

 Invoice Id: [INVOICE_ID] <br/>


 Please log in to your admin dashboard to respond to the ticket. <br/>

 Regards,<br/>
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