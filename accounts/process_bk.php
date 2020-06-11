<?php

	include "includes.php";

  
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

?>