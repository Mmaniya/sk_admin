<?php

function main() {
//4107212097335918


$quotationId = $_REQUEST['id'];
$quoteObj = new Quotation();
$quoteObj->quotation_id= $quotationId;
$quoteServices = $quoteObj->getQuoteDetails();


    
$client = $quoteServices['client'];
$clientNameArr = explode(' ',$client['name']);
$clientFName = $clientNameArr[0];
$clientLName = $clientNameArr[1];
$clientPhone =$client['phone'];
$clientEmail = $client['email'];
$clientAddress = $client['address_line'];
$clientCity =$client['city'];
$clientState = $client['state'];
$clientZip = $client['zipcode'];
?>

<form id="payment_form">
 <input name="ptype" value="first" type="hidden">
 <input name="lead_id" value="<?php echo $quoteServices['client'];?>" type="hidden">
    <div class="row checkout-head"> 
	     <div class="col-sm-12"> <h4 style="font-size:20px;"><i class="fa fa-lock" aria-hidden="true"></i> &nbsp; Secure Checkout</h4></div>
	</div>
	
	<div class="row"> 
	     <div class="col-sm-6 left-column ">
		 <h5><span> <i class="fa fa-user text-primary" aria-hidden="true" ></i> &nbsp; &nbsp;Customer Information </span></h5>
		 <input type="hidden" name="paymentType" value="Sale" />
 <input type="hidden" name="quotationId" value="<?=$quotationId?>" />
  <input type="hidden" name="itemName" value="<?=$quoteServices['services']['email_subject']?>" />
    
    <div class="col-sm-12"> 	 
  <div class="row">
    <div class="col-sm-6 nopadding"> 	
 <div class="form-group">
    <label for="first_name"><strong>First Name </strong></label>
    <input type="text" class="form-control" name="first_name" value="<?php echo $clientFName?>">
  </div>
  </div>
  
   <div class="col-sm-6 nopadding" style="padding-right:0px;"> 
   <div class="form-group">
    <label for="last_name"><strong>Last Name </strong></label>
    <input type="text" class="form-control" name="last_name" value="<?php echo $clientLName?>">
  </div>
  </div>
  
  </div>  
    </div>
  
	  <div class="form-group">
	<label for="email"><strong>Email address: </strong></label>
	<input type="email" class="form-control" id="email" readonly value="<?php echo $clientEmail?>">
	</div>
    
    
		 
	 <h5 class="billing-tag"><i class="fa fa-tags text-primary" aria-hidden="true"></i> &nbsp; Billing Information</h5>	 
		 
		  <span class="error_credit_card" style="color:#ff0000"></span>
		
       
 <div class="form-group">
    <label for="creditCardName"><strong>Cardholder Name*</strong></label>
    <input type="text" class="form-control" name="creditCardName">
  </div>


 <div class="form-group">
    <label for="creditCardNumber"><strong>Card Number* </strong></label>
    <input type="text" class="form-control" name="creditCardNumber">
  </div> 
        
	 <div class="col-sm-12">	
	 <div class="row payment-type-row">  	 
	  <div class="col-sm-6"> 	  
 <div class="form-group">
    <label for="creditCardType"><strong>Payment Method*</strong></label>
	 <select name="creditCardType" id="creditCardType" class="form-control">
	   <option value="Visa">Visa</option>
		<option value="MasterCard">MasterCard</option>
		<option value="Discover">Discover</option>
		<option value="Amex">Amex</option>

	 </select>
 </div> 
 
 </div> 
 
  <div class="col-sm-6"> 
  <div class="payment_type_images">&nbsp;&nbsp;
	    <img alt="logo_ccVisa" src="images/logo_ccVisa.gif">
		<img alt="logo_ccMC" src="images/logo_ccMC.gif">
		<img alt="logo_ccAmex" src="images/logo_ccAmex.gif">
		<img alt="logo_ccDiscover" src="images/logo_ccDiscover.gif">		
    </div>
 </div>  
</div>
</div>



 <div class="col-sm-12">	
	 <div class="row payment-type-row">  	 
	  <div class="col-sm-6"> 	  
	   <label for="payment_method"><strong>Expiry Date*</strong></label> <br/>
 <div class="form-group" style="display:flex">
   
	 <select name="expDateMonth"  class="form-control" style="width:inherit;margin-right:10px;">
	  <option value="01">01</option>
		<option value="02">02</option>
		<option value="03">03</option>
		<option value="04">04</option>
		<option value="05">05</option>
		<option value="06">06</option>
		<option value="07">07</option>
		<option value="08">08</option>
		<option value="09">09</option>
		<option value="10">10</option>
		<option value="11">11</option>
		<option value="12">12</option>
	 </select>
	 
    <select name="expDateYear"  class="form-control" style="width:inherit">
		<option value="2019">2019</option>
		<option value="2020">2020</option>
		<option value="2021">2021</option>
		<option value="2022">2022</option>
		<option value="2023">2023</option>
		<option value="2024">2024</option>
		<option value="2025">2025</option>
		<option value="2026">2026</option>
		<option value="2027">2027</option>
		<option value="2028">2028</option>
		<option value="2029">2029</option>
	 </select>
 </div> 
 </div> 
 
  <div class="col-sm-6"> 
 <div class="form-group">
    <label for="ccv"><strong>Security Code(CVV)*</strong></label>
	   <input type="text" class="form-control" name="cvv2Number">
 </div> 
 </div>  
</div>
</div>
 
 
  <h5 class="billing-tag"><i class="fa fa-map-marker text-primary" aria-hidden="true"></i>&nbsp;Address Information</h5>	 
		 
   <div class="form-group">
    <label for="first_name"><strong>Street </strong></label>
    <input type="text" class="form-control" name="clientAddress" value="<?php echo $clientAddress?>">
  </div>


 <div class="form-group">
    <label for="city"><strong>City </strong></label>
    <input type="text" class="form-control" name="clientCity" value="<?php echo $clientCity?>">
  </div>
		 
		 
 <div class="col-sm-12"> 	 
  <div class="row">
    <div class="col-sm-6 nopadding"> 	
 <div class="form-group">
    <label for="state"><strong>State </strong></label>
    <input type="text" class="form-control" name="clientState" value="<?php echo $clientState?>">
  </div>
  </div>
  
   <div class="col-sm-6 nopadding" style="padding-right:0px;"> 
   <div class="form-group">
    <label for="zip_code"><strong>Zipcode </strong></label>
    <input type="text" class="form-control" name="clientZip" value="<?php echo $clientZip?>">
  </div>
  </div>
  
  </div>  
    </div>
  
		 </div> 
	     <div class="col-sm-6 right-column" style="background-color:#f4f6f6">	 
		  <h5><span> <i class="fa fa-shopping-cart text-primary" aria-hidden="true"></i>  &nbsp; &nbsp; Order Summary</span></h5>
		  
		  
		  <ul class="payment-summary">
          <?php
		  unset($quoteServices['services']['email_subject']);
          foreach($quoteServices['services'] as $K=>$V) {	
		  
		  ?>
		  <li><?php echo $V['item_name'];?>  <span><?php echo $V['item_amount'];?></span></li>
          <?php
		  }
		  ?>
		 <!-- <li>Tax	 <span>$11.95</span></li> -->
         
         <?php
		 $amountDtls = $quoteServices['amount_details'];
		 if($amountDtls['is_discount']=='Y') {
			   $discountCode =$amountDtls['discount']['code']; 
			   $discountValue =$amountDtls['discount']['value']; 
			   $discountAmt =$amountDtls['discount']['amount']; 
		 ?>
         <li>Discount (<?php echo $discountCode; ?>)	 <span> (-)<?php echo $discountAmt?></span></li>
         <?php
		 }
		 ?>
		  	  
          
          <?php
		  if(!is_array($quoteServices['amount_details']['installment'])){
			   
				
		  ?>
            <li class="text-primary" style="font-size:22px;"><strong>TOTAL</strong>	 <span><strong><?php echo $quoteServices['amount_details']['final_amount']?></strong></span></li>	
          <input type="hidden" name="finalAmountVal" value="<?=$amountDtls['finalAmountVal']?>">
         <input type="hidden" name="is_downpayment" value="N">
          
          <?php
		  } else {
			  $installment = $quoteServices['amount_details']['installment'];
			   $isInstallment = 'Y';
		  ?>
         <li ><strong>TOTAL</strong>	 <span><strong><?php echo $quoteServices['amount_details']['final_amount']?></strong></span></li>	
            <input type="hidden" name="finalAmountVal" value="<?=$installment['down_payment']?>">
            <input type="hidden" name="is_downpayment" value="Y">
            
          <li class="text-primary" style="font-size:18px;"><strong>Amount to be paid now (Downpayment)</strong>	 <span><strong><?php echo money($installment['down_payment'],'$');?></strong></span></li>	
          <?php } ?>
		  </ul>
          
          <div id="agree_text" style="font-size:14px; padding:10px;"><input type="checkbox"  id="agree" /> <strong>By clicking pay, you agree to <a href="privacy_policy.php">BizPlanEasy Privacy Policy</a> & <a href="terms.php">Terms of Service</strong></a></div>
		  
		  <button type="button" class="paynowBtn" onClick="processPayment()">Pay Now</button>
         		  <span class="alert-danger" style="display:none"> There was a problem in processing your payment. Please try again</span>
       
		  <div class="service_image">
		    <img src="images/mac.png" alt="mcafee">
		    <img src="images/getseal.gif" alt="getseal">
		    <img src="images/kount_logo.gif" alt="kount_logo">			
		  </div>
             
           <div style="margin-top:20px; border-radius:15px; background-color:#fefedc">  
        <?php         if( $isInstallment =='Y') { ?>
	       <h5 style="padding-left:15px;"><span> <i class="fas fa-dollar-sign text-primary" aria-hidden="true"></i>  &nbsp; &nbsp; Installment Schedule</span></h5>
           <ul class="payment-summary">
           <li style="padding-left:15px; padding-right:15px; font-size:16px;">Installment Date <span><strong> Amount</strong> </span> </li>

           <?php foreach($installment['schedule'] as $K=>$V) { ?>
           <li style="padding-left:10px;padding-right:10px;"><?php echo $V['installment_date']; ?><span><strong> <?php echo $V['installment_amount']; ?></strong></span> </li>


		   
		   <?php }  ?>
                      </ul>
           
        <?php   } ?>
        </div>
		  <div align="center" style="margin-top:10px"><a href="https://www.bbb.org/us/nj/fair-lawn/profile/business-plan/bizplaneasy-0221-90173468/#sealclick" id="bbblink" class="ruhzbum" target="_blank" rel="nofollow"><img src="https://seal-newjersey.bbb.org/logo/ruhzbum/bbb-90173468.png" style="border: 0;" alt="BizPlanEasy BBB Business Review" /></a></div>
		 </div>
	</div>
 </form>
	 
  <form id="submitFrm" action="thankyou.php" method="post">
  <input type="hidden" name="txnid" id="txnid">
  <input type="hidden" name="amount" id="amount">
  <input type="hidden" name="quoteid" id="quoteid">
  <input type="hidden" name="invoiceid" id="invoiceid">
  <input type="hidden" name="clientid" id="clientid">
  <input type="hidden" name="invoice_payment_id" id="invoice_payment_id">
  </form>
  

  
  
  <script>
  
 
   function setExpiryDate() {
		var d = new Date();
		var month = d.getMonth();
		var year = d.getFullYear();
		fullmonth = month +2 ;
		fullMonth = '0'+fullmonth; 
		document.forms["payment_form"]["expDateMonth"].value = fullMonth;
		document.forms["payment_form"]["expDateYear"].value=year;
 }
 
  setExpiryDate();
   $(".credit_card").inputmask({"mask": "9999 9999 9999"});
   
  function processPayment() {
	err=0;
	var form = $('#payment_form'); 

	var first_name = document.forms["payment_form"]["first_name"].value;
	 
	if(first_name=='' ){ err=1; $('input[name="first_name"]').css("border","1px solid #ff0000 ");  } else{  $('input[name="first_name"]').css("border","");  }

	var last_name = document.forms["payment_form"]["last_name"].value;

	if(last_name=='' ){ err=1; $('input[name="payment_form"]').css("border","1px solid #ff0000 ");  } else{  $('input[name="payment_form"]').css("border","");  }
	  
	var creditCardName = document.forms["payment_form"]["creditCardName"].value;

	if(creditCardName=='' ){ err=1; $('input[name="creditCardName"]').css("border","1px solid #ff0000 ");  } else{  $('input[name="creditCardName"]').css("border","");  }

	var creditCardNumber = document.forms["payment_form"]["creditCardNumber"].value;

	if(creditCardNumber=='' ){ err=1; $('input[name="creditCardNumber"]').css("border","1px solid #ff0000 ");  } else{  $('input[name="creditCardNumber"]').css("border","");  }


	 if(creditCardNumber=='' ){ err=1; $('input[name="creditCardNumber"]').css("border","1px solid #ff0000 ");  } else{   $('input[name="creditCardNumber"]').css("border","");
	 
	 creditChar = creditCardNumber.replace(/[^A-Z0-9]+/ig, "");  
	 if(creditChar.length<10) { err=1; $('.error_credit_card').html( 'Enter vaild credit card number');$('input[name="creditCardNumber"]').css("border","1px solid #ff0000 ");  }
	 else { $('.error_credit_card').html(''); $('input[name="creditCardNumber"]').css("border",""); }
	 }



	var creditCardType = document.forms["payment_form"]["creditCardType"].value;

	if(creditCardType=='' ){ err=1; $('input[name="creditCardType"]').css("border","1px solid #ff0000 ");  } else{  $('input[name="creditCardType"]').css("border","");  }

	var expDateMonth = document.forms["payment_form"]["expDateMonth"].value;
	if(expDateMonth=='' ){ err=1; $('input[name="expDateMonth"]').css("border","1px solid #ff0000 ");  } else{  $('input[name="expDateMonth"]').css("border","");  }


	var expDateYear = document.forms["payment_form"]["expDateYear"].value;
	if(expDateYear=='' ){ err=1; $('input[name="expDateYear"]').css("border","1px solid #ff0000 ");  } else{  $('input[name="expDateYear"]').css("border","");  }

	var cvv2Number = document.forms["payment_form"]["cvv2Number"].value;
	if(cvv2Number=='' ){ err=1; $('input[name="cvv2Number"]').css("border","1px solid #ff0000 ");  } else{  $('input[name="cvv2Number"]').css("border","");  }

/*var clientAddress = document.forms["payment_form"]["clientAddress"].value;
	 if(clientAddress=='' ){ err=1; $('input[name="clientAddress"]').css("border","1px solid #ff0000 ");  } else{  $('input[name="clientAddress"]').css("border","");  }


	var clientCity = document.forms["payment_form"]["clientCity"].value;
	 if(clientCity==''){ err=1; $('input[name="clientCity"]').css("border","1px solid #ff0000 ");  } else{  $('input[name="clientCity"]').css("border","");  }



	var clientState = document.forms["payment_form"]["clientState"].value;
	if(clientState==''){ err=1; $('input[name="clientState"]').css("border","1px solid #ff0000 ");  } else{  $('input[name="clientState"]').css("border","");  }

	var clientZip = document.forms["payment_form"]["clientZip"].value;
	 if(clientZip==''){ err=1; $('input[name="clientZip"]').css("border","1px solid #ff0000 ");  } else{  $('input[name="clientZip"]').css("border","");  }
	*/
	if(!$('#agree').is(":checked")) { err=1; $('#agree_text').css("color","#ff0000 ");  } else{  $('#agree_text').css("color","#000000");  }

	
		if(err==0) {
    $('.paynowBtn').html('processing payment..pls wait'); 
	 $('.alert-danger').hide();	
	
	   ajax({ 
		a:'process',
		b:form.serialize(),
		c:function(){},
		d:function(data){    
		dataArr = data.split(':::');
		var result = dataArr[0].trim();

		if(result=='SUCCESS') {
			 $('.paynowBtn').html('Payment successful...redirecting');
		  	$('#txnid').val(dataArr[1]);
		  	$('#amount').val(dataArr[2]);
		  	$('#quoteid').val(dataArr[3]);
		  	$('#clientid').val(dataArr[4]);
		  	$('#invoiceid').val(dataArr[5]);
		  	$('#invoice_payment_id').val(dataArr[6]);
			$('#submitFrm').submit();
								  	
		} else {
		     $('.alert-danger').html(data);	
			 $('.alert-danger').show();	
			 $('.paynowBtn').html('Pay Now');
		}
        		
	 }}); 	
	} }
   
   </script>
   
<?php
}

include "payment_template.php";
?>