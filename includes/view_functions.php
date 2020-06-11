<?


function reservationDtl($reservationId,$roundTripRezId=0,$receiverType,$showRR=1) {

  $rsReservation = Reservation::getReservation(array('id'=>$reservationId.'-INT'));
  foreach($rsReservation as $K=>$V) $$K=$V;
  
  if($trip_type=='O')  { $trip_type='O';	
  						 $trip_type_name = 'One Way';
						 $roundTripRezId=0; } 
 else {
 
  $trip_type='R';	
  $trip_type_name = 'Round Trip'; $roundTripRezId = $roundtrip_child_id;
  if($showRR==1) {	 
  if($roundTripRezId==0) {
	    $roundTripRezId=$reservationId;
	    $reservationId = $roundtrip_parent_id;
	    $rsReservation = Reservation::getReservation(array('id'=>$reservationId.'-INT'));
        foreach($rsReservation as $K=>$V) $$K=$V;
  }
  }
 }
  
   $reservationIds = $reservationId;
  if($roundTripRezId>0) $reservationIds .= ' and '.$roundTripRezId;
  
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
   if($receiverType=='Admin') {   $view_type='Admin'; 
								  }
  if($receiverType=='Company') {  $companyDtl = Companies::getCompanies(array('id'=>$company_id));	
                                  $company_name=$companyDtl->company_name; 
                                  $view_type='Company'; $welcome_text=''; 
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
   
   $pickup_date = date('d M,Y - D',strtotime($pickup_date));
   $flight_date= date('d M,Y - D',strtotime($flight_date));

   if($roundTripRezId>0  && $showRR==1) {
	   $trip_type='R';	   
	   $trip_type_name = 'Round Trip';
	   $rsReservation = Reservation::getReservation(array('id'=>$roundTripRezId.'-INT'));
	   $round_trip_direction = $rsReservation->trip_direction;
	   $return_pickup_date = date('d M,Y - D',strtotime($rsReservation->pickup_date));
	   $return_pickup_time = $rsReservation->pickup_time;
	   $return_flight_date =  date('d M,Y - D',strtotime($rsReservation->flight_date));
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
  
   $driving_company_amount= money($driving_company_amount);
   $adults_children = $adults;
   if($children>0) $adults_children = $adults.'/'.$children;
   $trip_direction_name =$GLOBALS['TRIP_DIRECTION'][$trip_direction];
   $roundtrip_direction_name =$GLOBALS['TRIP_DIRECTION'][$round_trip_direction];   
  
  
   $airport_fee = money($airport_fee);
   ob_start();
   include "../view/view_rez.php";
   $Content = ob_get_contents();
   ob_clean();
   foreach($GLOBALS['mailFields'] as $K=>$V) {
	 $Content = str_replace($K,$$V,$Content);   
   }
   echo $Content;
}

?>