<?
function sendMail($mailSubject,$mailContent,$toEmailAddress,$fromName = FROM_NAME,$fromEmail = FROM_EMAIL,$attachmentFile=array(),$additionalEmailAddress=array()) {
	try {
	
		include_once "/home2/eikonshu/public_html/bookmyprivatecar/Unirest/lib/Unirest.php";
		include_once "/home2/eikonshu/public_html/bookmyprivatecar/sendgrid/lib/SendGrid.php";
		
		//SendGrid::register_autoloader();
		
		//$sendgrid = new SendGrid('eikonshuttleservices', 'E1kon2004$!');
		//$mail = new SendGrid\Email(); 
		
		$mail->addTo($toEmailAddress)->
		setFromName($fromName)->
			   setFrom($fromEmail)->
			   setSubject($mailSubject)->
			   setHtml($mailContent);
		
		if(is_array($attachmentFile) && count($attachmentFile)>0)
			foreach($attachmentFile as $vv)		$mail->addAttachment($vv);
			
	
		if(is_array($additionalEmailAddress) && count($additionalEmailAddress)>0)
			foreach($additionalEmailAddress as $vv)		 $mail->addTo($vv);
		
		$sendgrid->web->send($mail);
		
	}
	catch(ErrorException $e) {
	  return "Error:".$e->getMessage();
	}
}

function sendMailLog() {
	$mailSubject=  ' [BMPC] New Search on Website ';
	$reservationDtls = $_SESSION['reservationDtls'];
	$reservationArr=array_flatten($reservationDtls);	
	foreach($reservationArr as $K=>$V) 	$mailContentArr[]=$K.' = '.$V;	
	$mailContentArr[]='IP Address = '.$_SERVER['REMOTE_ADDR'];
	$toEmailAddress = 'eikonshuttleservices@gmail.com'; 
	//sendMail($mailSubject,implode('<br/>',$mailContentArr),$toEmailAddress);
}


function sendErrorLog($mailSubject,$Message,$toEmailAddress,$otherContent=array()) {
	$mailSubject=  ' [BMPC] Error on '.$otherContent['step'];
	$mailContentArr[]='IP Address = '.$_SERVER['REMOTE_ADDR'];
	//sendMail($mailSubject,$mailContent,$toEmailAddress);
}


function newreservationMail($reservationId,$roundTripRezId=0,$receiverType,$mailCategory='New',$showRR=1) {

  $rsReservation = Reservation::getReservation(array('id'=>$reservationId.'-INT'));
  foreach($rsReservation as $K=>$V) $$K=$V;
  
  if($trip_type=='O')  { $trip_type='O';	
  						 $trip_type_name = 'One Way';
						 $roundTripRezId=0; } 
 else {
  $trip_type='R';	
  $trip_type_name = 'Round Trip';
  $roundTripRezId = $roundtrip_child_id;
  if($showRR==1) {	 
	  if($roundTripRezId==0) {
			$roundTripRezId=$reservationId;
			$reservationId = $roundtrip_parent_id;
			$rsReservation = Reservation::getReservation(array('id'=>$reservationId.'-INT'));
			foreach($rsReservation as $K=>$V) $$K=$V;
	  }
  }
 }
  
  $r_id = $reservationIds = $reservationId;
  if($roundTripRezId>0) { $reservationIds .= ' and '.$roundTripRezId;
  $r_id .= '-'.$roundTripRezId;
  $r_id = base64_encode($r_id);
  }
  
  if($driver_id>0) {
	$rsDriver = Drivers::getDrivers(array('id'=>$driver_id));	
	$driver_name = $rsDriver->first_name.' '.$rsDriver->last_name;
	$driver_phone = $rsDriver->phone;
	  
  }
  
  $pax_name = $first_name.' '.$last_name;
  $pax_phone = $phone;
  $pax_email = $email_address;
  $pax_addl_phone = $addl_phone;
  if(!$showRR) $roundTripRezId=0;
  
  if($receiverType=='Admin') {    $name ='web master'; $mail_type='Admin'; $welcome_text='New Reservation from BMPC, Details below'; 
								  $mailSubject = SUBJECT_PREFIX.' New Job Request - Booking Id - '.$reservationIds; 
								  $companyDtl = Companies::getCompanyToAssign($airport_id);	$driving_company_name=$companyDtl->company_name;
								  $driving_company_email=$companyDtl->email_address;
								  $toEmailAddress=NOTIFICATION_EMAIL;
								  }
  if($receiverType=='Customer') { $name = $first_name.' '.$last_name; $mail_type='Customer'; 
   								  if($mailCategory=='New') {	
                                  $welcome_text='Thank you for choosing BookmyPrivateCar.com for your ride. Details of your Booking listed below:'; 
								  $mailSubject = SUBJECT_PREFIX.' Confirmation of your Private Car Booking - Booking Id - '.$reservationIds;
								 
								  }
   								  if($mailCategory=='Assigned') {	
                                  $welcome_text='Thank you for choosing BookmyPrivateCar.com for your ride.Chaffeur is assigned for your pickup.
								  Please find the contact details of the Chaffeur below:'; 
								  $mailSubject = SUBJECT_PREFIX.' Chaffuer Contact Details for your Booking Id - '.$reservationIds;
								  }

								  $toEmailAddress=$email_address;
								  }
  if($receiverType=='Company' ) {  
   								   if($mailCategory=='New') {	
								      $show_acceptance=1;
									  $companyDtl = Companies::getCompanyToAssign($airport_id);	
									  $c_id = base64_encode($companyDtl->id);
									  $toEmailAddress= $companyDtl->email_address; 
									  $name=$companyDtl->company_name; // $name ='web master'; 
									  $mail_type='Company'; $welcome_text='New Job Request. Details listed below:';  
									  $mailSubject = SUBJECT_PREFIX.' New Job Request - Booking Id - '.$reservationIds;
									  $accept_url = SITE_HTTP_COMPANY.'/job_request_status.php?r_id='.$r_id.'&c_id='.$c_id.'&s=A';
									  $reject_url = SITE_HTTP_COMPANY.'/job_request_status.php?r_id='.$r_id.'&c_id='.$c_id.'&s=R';
								   }
								  if($companyDtl->id==0 || $companyDtl->id=='') {
									$mailSubject='[BMPC ALERT] New Reservation in <strong>Non-Servicing Airport</strong>';
									$mailContent="Dear Kavitha, <br> We have got a reservation in $airport_name where we do not have any driving companies. Details:<br />
											<br />Reservation Id : $reservationId,$roundTripRezId<br />This is an automated message";
									sendMail($mailSubject,$mailContent,SUPPORT_EMAIL); return;}
								 }


  if($receiverType=='Driver' ) {  
   								   if($mailCategory=='Assigned') {	
									  $toEmailAddress= $rsDriver->email_address; 
									  $name=$rsDriver->first_name.' '.$rsDriver->last_name; // $name ='web master'; 
									  $mail_type='Driver'; $welcome_text='New Job has been assigned to you. Details listed below:'; 
								   }
   								  $mailSubject = SUBJECT_PREFIX.' New Job Assignment - Booking Id - '.$reservationIds;
                                  }


  $rsCar = Cars::getCarDetails(array('id'=>$car_id));
  $photo = $rsCar->photo;
  if($photo!="" && file_exists(CAR_FILE_PATH.$photo)) {
		$car_photo=(CAR_FILE_PATH.$photo);
		$thumb_car_photo_name=(CAR_FILE_PATH.'front_mail_thumb_'.$photo);
		$thumb_car = CAR_FILE_REL.'front_mail_thumb_'.$photo;
		if(!file_exists($thumb_car_photo_name)) {
		smart_resize_image($car_photo , null, 130 ,130 , true , $thumb_car_photo_name , false , false ,100 );
	}}   
   $car_photo = $thumb_car;	
   $car_name = $rsCar->name;
   
   $pickup_date = date('d M,Y',strtotime($pickup_date));
   $flight_date= date('d M,Y',strtotime($flight_date));

   if($roundTripRezId>0) {
	   $trip_type='R';	   
	   $trip_type_name = 'Round Trip';
	   $rsReservation = Reservation::getReservation(array('id'=>$roundTripRezId.'-INT'));
	   $round_trip_direction = $rsReservation->trip_direction;
	   $return_pickup_date = date('d M,Y',strtotime($rsReservation->pickup_date));
	   $return_pickup_time = $rsReservation->pickup_time;
	   $return_flight_date =  date('d M,Y',strtotime($rsReservation->flight_date));
	   $return_flight_time = $rsReservation->flight_time;
	   $return_airline_name = $rsReservation->airline_name;
	   $return_airline_number = $rsReservation->airline_number;
	   $return_airline_type = $rsReservation->airline_type;
	   $fare_amount += $rsReservation->fare_amount;
	   $airport_fee += $rsReservation->airport_fee;
	   $surcharge_fee += $rsReservation->surcharge_fee;
	   $gratuity_fee += $rsReservation->gratuity_fee;
	   $total_amount +=   $rsReservation->total_amount;
	   $driving_company_amount +=   $rsReservation->driving_company_amount;
	   
   }
  
   $driving_company_amount = money($driving_company_amount);
   $adults_children = $adults;
   if($children>0) $adults_children = $adults.'/'.$children;
   
   $trip_direction_name =$GLOBALS['TRIP_DIRECTION'][$trip_direction];
   $roundtrip_direction_name =$GLOBALS['TRIP_DIRECTION'][$round_trip_direction];   
  return;
  
   $airport_fee = money($airport_fee);
   ob_start();
   include "/home2/eikonshu/public_html/bookmyprivatecar/mail/new_rez.php";
   $mailContent = ob_get_contents();
   ob_clean();
   foreach($GLOBALS['mailFields'] as $K=>$V) {
	 $mailContent = str_replace($K,$$V,$mailContent);   
   }
 //  echo $mail_content;
   
  // sendMail($mailSubject,$mailContent,$toEmailAddress);
}

?>