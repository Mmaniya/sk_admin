<?php

function main() {


$html  = '<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css" />
<table border="1" cellspacing="0" cellpadding="0"  style="width:100%;background:#ffffff;border:solid #cccccc 1.0px;font-family: \'Lato\', Verdana, sans-serif;">
 <tbody>
	
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
        <p><b><span style="color:black">Paypal Transaction Identifier</span></b></p>
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
    <tr>
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
        <p><span style="color:black">Click <a href="https://sys2.bizplaneasy.com/accounts/index.php">here</a> to login into your account using the credentials given below</span></p>
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
   </tr>
   <tr>
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
  
 // print_r($_POST);
  $invoice_payment_id  = $_POST['invoice_payment_id'];
  $client_id  = $_POST['clientid'];
     $txnid  = $_POST['txnid'];  
 
	$param = array('tableName'=>TBL_INVOICE_PAYMENT,'fields'=>array('*'),'condition'=>array('id'=>$invoice_payment_id.'-INT'),'showSql'=>'N');
		$rsInvPayment = Table::getData($param);		

		$param = array('tableName'=>TBL_CLIENTS,'fields'=>array('*'),'condition'=>array('id'=>$client_id.'-INT'),'showSql'=>'N');
		$rsClient = Table::getData($param);		
		 
		 
		$search = array('[ORDER_AMOUNT]','[INVOICE_ID]','[INVOICE_DATE_TIME]','[TXN_ID]','[CLIENT_EMAIL]','[CLIENT_PASS]','[CLIENT_NAME]');
		$replace = array($rsInvPayment->amount_paid,$rsInvPayment->invoice_id,date('M d,Y h:i A',strtotime($rsInvPayment->added_date)),$txnid,$rsClient->client_email,
		                 $rsClient->client_pass,$rsClient->client_fname.' '.$rsClient->client_lname);		
			
	$html = str_replace($search, $replace, $html);		
	
  echo $html;
  
}

include "payment_template.php";
?>