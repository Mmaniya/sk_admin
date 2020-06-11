<?php 

 require("includes.php");
 
 $serviceObj = new Invoice();
$serviceObj->invoice_id = 6210;
$servicesOrdered = $serviceObj->getServicesByInvoiceId();
$services='';
foreach($servicesOrdered as $K1=>$V1) { 	
 if(is_array($V1)) { 
  $services.=$V1['item_name'].',&nbsp;';
}
}

echo $services;
 

?>