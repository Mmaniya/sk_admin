<?
	function chargeCard($stripeTokenId,$existingCard, $amountToBeCharged, $customerDtl,$saveCard='Y') {
		$returnArray=array();
		foreach($customerDtl as $K=>$V) $$K=$V;
		require 'lib/Stripe.php';
		Stripe::setApiKey($_SESSION['Configurations']['PHP_STRIPE_KEY']);
		try {
			 $stripeCustomerId = $customerDtl['stripe_customer_id'];		
			 if($existingCard=='new') {	
				  if($stripeCustomerId!='') {
				 if($saveCard=='Y') {	 
					$customerArr = Stripe_Customer::retrieve($stripeCustomerId);
					$cardDtls = $customerArr->sources->create(array("source" => $stripeTokenId));
				   }
				 $stripArr = array("amount" => intval($amountToBeCharged*100),"currency" => "usd","customer" => $stripe_customer_id,'card'=>$cardDtls->id);	
				} else {
					$token = $stripeTokenId;
					$customer = Stripe_Customer::create(array("card"=> $stripeTokenId,"email" =>$email_address,"description" => $first_name.' '.$last_name.'-'.$email_address));
					$stripeCustomerId=$customer->id;
					$stripArr = array("amount" => intval($amountToBeCharged*100),"currency" => "usd","customer" => $stripeCustomerId);	
				 }
				$returnArray['stripe_customer_id']=$stripeCustomerId;
			 } else
				$stripArr = array("amount" => intval($amountToBeCharged*100),"currency" => "usd","customer" => $stripeCustomerId,'card'=>$existingCard);	
			 $charge = Stripe_Charge::create($stripArr);
			 $stripe_charge_id = $charge->id;
			
			 $chargeDtl = Stripe_Charge::retrieve($stripe_charge_id);	
			 $brand = $chargeDtl->source['brand'];
			 $last4 =$chargeDtl->source['last4'];
			 $exp_month = $chargeDtl->source['exp_month'];
			 $exp_year =  $chargeDtl->source['exp_year'];
			 $card_details="Paid using $brand card ending in $last4, expiring $exp_month/$exp_year";			 

			 $message = array("result"=>"Success","stripe_charge_id"=>$stripe_charge_id, "stripe_customer_id"=>$stripeCustomerId,"card_details"=>$card_details);
			 return $message;
		}
		catch (Exception $e) {
			 $message = $e->getMessage();
			 $message = array("result"=>"Error", "message"=>$message);
			 return $message;
		}
	}
	
	
	
function applyCCDiscount() {
	if($GLOBALS['APPLY_CC_DISCOUNT']=='Y') {
	$percent = $GLOBALS['CC_DISCOUNT_PERCENT'];
	$percent=0;
	foreach($_SESSION['reservationDtls']['details']['total'] as $K=>$V) $$K=$V;
	$discount_amount = money($fare_amount*($percent/100));
	
	if($_SESSION['reservationDtls']['details']['trip_type']=='O') {
		
		 $_SESSION['reservationDtls']['details']['car']['trip1']['discount_percent']=$percent;
		 $_SESSION['reservationDtls']['details']['car']['trip1']['discount_amount']=$discount_amount; 
		 $tripDtls = $_SESSION['reservationDtls']['details']['car']['trip1'];
		 $_SESSION['reservationDtls']['details']['car']['trip1']['total_amount_with_discount']=money($tripDtls['total_amount']-$tripDtls['discount_amount']);
		 } else {
		 $trip_discount = number_format(floatval($discount_amount/2),2);
		 $_SESSION['reservationDtls']['details']['car']['trip1']['discount_percent']=$percent;
		 $_SESSION['reservationDtls']['details']['car']['trip1']['discount_amount']=$trip_discount; 
		  $tripDtls = $_SESSION['reservationDtls']['details']['car']['trip1'];
		 $_SESSION['reservationDtls']['details']['car']['trip1']['total_amount_with_discount']=money($tripDtls['total_amount']-$tripDtls['discount_amount']);
		
		 $_SESSION['reservationDtls']['details']['car']['trip2']['discount_percent']=$percent;
		 $_SESSION['reservationDtls']['details']['car']['trip2']['discount_amount']=$trip_discount;
		  $tripDtls = $_SESSION['reservationDtls']['details']['car']['trip2'];
		 $_SESSION['reservationDtls']['details']['car']['trip2']['total_amount_with_discount']==money($tripDtls['total_amount']-$tripDtls['discount_amount']);
	
	  }
		$_SESSION['reservationDtls']['details']['total']['cc_discount']='Y';
		$_SESSION['reservationDtls']['details']['total']['discount_percent']=$percent;
		$_SESSION['reservationDtls']['details']['total']['discount_amount']=$discount_amount;
		$originalAmount =$_SESSION['reservationDtls']['details']['total']['final_amount'];
		$totalAmount = $_SESSION['reservationDtls']['details']['total']['final_amount_with_discount']= money($_SESSION['reservationDtls']['details']['total']['final_amount']-$discount_amount);
		$_SESSION['reservationDtls']['details']['car']['total'] = $_SESSION['reservationDtls']['details']['total'];
		return money($discount_amount,'$').':<span class="strike">'.money($originalAmount,'$').'</span>&nbsp;<strong> '
		      .money($totalAmount,'$').'</strong>:'.money($totalAmount);
	}
	return '0';	
}


function unapplyCCDiscount() {
	if($GLOBALS['APPLY_CC_DISCOUNT']=='Y') {
	foreach($_SESSION['reservationDtls']['details']['total'] as $K=>$V) $$K=$V;
	
	if($_SESSION['reservationDtls']['details']['trip_type']=='O') {
		
		 $_SESSION['reservationDtls']['details']['car']['trip1']['discount_percent']=0;
		 $_SESSION['reservationDtls']['details']['car']['trip1']['discount_amount']=0; 
		 $tripDtls = $_SESSION['reservationDtls']['details']['car']['trip1'];
		 $_SESSION['reservationDtls']['details']['car']['trip1']['total_amount_with_discount']=0;
		 } else {
		 $_SESSION['reservationDtls']['details']['car']['trip1']['discount_percent']=0;
		 $_SESSION['reservationDtls']['details']['car']['trip1']['discount_amount']=0; 
		  $tripDtls = $_SESSION['reservationDtls']['details']['car']['trip1'];
		 $_SESSION['reservationDtls']['details']['car']['trip1']['total_amount_with_discount']=0;
		
		 $_SESSION['reservationDtls']['details']['car']['trip2']['discount_percent']=0;
		 $_SESSION['reservationDtls']['details']['car']['trip2']['discount_amount']=0;
		  $tripDtls = $_SESSION['reservationDtls']['details']['car']['trip2'];
		 $_SESSION['reservationDtls']['details']['car']['trip2']['total_amount_with_discount']==0;
	
	  }
		$_SESSION['reservationDtls']['details']['total']['cc_discount']='N';
		$_SESSION['reservationDtls']['details']['total']['discount_percent']=0;
		$_SESSION['reservationDtls']['details']['total']['discount_amount']=0;
	//	$_SESSION['reservationDtls']['details']['total']['old_final_amount']=0;
		$_SESSION['reservationDtls']['details']['total']['final_amount_with_discount']=0;
		$totalAmount = $_SESSION['reservationDtls']['details']['total']['final_amount'];
		$_SESSION['reservationDtls']['details']['car']['total'] = $_SESSION['reservationDtls']['details']['total'];
		return money($discount_amount,'$').':'.money($totalAmount,'$').':'.money($totalAmount);
	}
	return '0';	
}

?>