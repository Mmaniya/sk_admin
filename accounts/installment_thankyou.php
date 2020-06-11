<?php

function main() {
	
	


$html  = ' <div style="margin:auto;width:610.0px;background:#ffffff;margin-top:30px;">
       <div  width="580" style="margin:auto;display:table;"> 
	      
         <div style="padding-top:30px;">
		     <p style="line-height:13.5px"><span style="color:black">Hey [CLIENT_NAME],</span></p>
		  </div>


		   <div style="padding:0cm 0cm 21.0px 0cm">
             <p style="line-height:21.5px"><span style="color:#000">Thank you for your installment Payment! Your transaction with BizPlanEasy was successful.</span></p>
           </div>
		  
		  
		  <div>
		  <ul style="list-style-type: none;line-height: 40px; padding: 0; border: 1px solid #eee; padding: 10px;">
		  
		  <li style="border-bottom: 1px solid #eee;">
		  <span style="color:#000;width:60%">Installment Amount </span> <span style="float:right;color:#000;width:40%;border-left: 1px solid #eee;padding-left: 5px;">[ORDER_AMOUNT]</span> </li>
		  
		  <li style="border-bottom: 1px solid #eee;">
		  <span style="color:#000;width:60%">Invoice ID  </span>  <span style="float:right;color:#000;width:40%;border-left: 1px solid #eee;padding-left: 5px;">[INVOICE_ID]</span> </li>
		  
		  
		  <li style="border-bottom: 1px solid #eee;">
		  <span style="color:#000;width:60%">Order Date & Time </span>  <span style="float:right;color:#000;width:40%;border-left: 1px solid #eee;padding-left: 5px;">[INVOICE_DATE_TIME] </span> </li>
		  
		  <li>
		  <span style="color:#000;width:60%">Merchant Transaction Identifier </span>  <span style="float:right;color:#000;width:40%;border-left: 1px solid #eee;padding-left: 5px;"> [TXN_ID]</span> </li>
		  </ul> 		  
		  </div>
          
          
          
          
		   <div style="padding:0.5cm 0.5cm 21.0px 0cm">
             <p style="line-height:20.5px"><span style="color:#006DCB">You can now access your dedicated account panel by using the below login credentials:</span></p>
           </div>
		  
		  
		  <div style="padding-top:15px;">
		  <ul style="list-style-type: none;line-height: 40px; padding: 0; border: 1px solid #eee; padding: 10px;">
		  
		  <li style="border-bottom: 1px solid #eee;">
		  <span style="color:#000;width:30%">Login URL </span> <span style="float:right;color:#000;width:70%;border-left: 1px solid #eee;padding-left: 5px;">
		  <a href="https://sys2.bizplaneasy.com/accounts/index.php?txid=[TXN_ID]1" target="_blank">Your Account Dashboard</a></span> </li>
		  
		  <li style="border-bottom: 1px solid #eee;">
		  <span style="color:#000;width:30%">Username </span>  <span style="float:right;color:#000;width:70%;border-left: 1px solid #eee;padding-left: 5px;">[CLIENT_EMAIL]</span> </li>
		  
		  
		  <li style="border-bottom: 1px solid #eee;">
		  <span style="color:#000;width:30%">Password </span>  <span style="float:right;color:#000;width:70%;border-left: 1px solid #eee;padding-left: 5px;">[CLIENT_PASS] </span> </li>
		  
		  
		  </ul> 		  
		  </div>
          
          
		  
		  <div>
		       <p style="line-height:26.5px"><span style="color:#000;line-height:16px;">Best regards,<br>
    </span><span style="color:#5b5b5b"Support Team<br />BizPlanEasy <br/> support@bizplaneasy.com</span><span style="color:black"> </span></p>
		  </div>
   
   
    
	   </div>       	   
	     <div  style="border:none;background:#fcfcfc;padding:10.0px 0cm 27.0px 0cm"> </div>    
   </div>
';
  
 // print_r($_POST);
  $invoice_payment_id  = $_POST['invoice_payment_id'];
  $client_id  = $_POST['clientid'];
     $txnid  = $_POST['txnid'];  
 
	$param = array('tableName'=>TBL_INVOICE_PAYMENT,'fields'=>array('*'),'condition'=>array('id'=>$invoice_payment_id.'-INT'),'showSql'=>'N');
		$rsInvPayment = Table::getData($param);		

		$param = array('tableName'=>TBL_CLIENTS,'fields'=>array('*'),'condition'=>array('id'=>$client_id.'-INT'),'showSql'=>'N');
		$rsClient = Table::getData($param);		
		 
		 
		$search = array('[ORDER_AMOUNT]','[INVOICE_ID]','[INVOICE_DATE_TIME]','[TXN_ID]','[CLIENT_EMAIL]','[CLIENT_PASS]','[CLIENT_NAME]');
		$replace = array(money($rsInvPayment->amount_paid,'$'),$rsInvPayment->invoice_id,date('M d,Y h:i A',strtotime($rsInvPayment->added_date)),$txnid,$rsClient->client_email,
		                 $rsClient->client_pass,$rsClient->client_fname.' '.$rsClient->client_lname);		
			
	$html = str_replace($search, $replace, $html);		
	
  echo $html;
  
}

include "payment_template.php";
?>