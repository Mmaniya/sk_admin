<?php   include "includes.php"; 

if($_GET['act']=='clientAutocomplete') {
ob_clean();	  
  $term =  $_REQUEST['term'];
  
    $filter_type = $_REQUEST['filter_type'];
	 
	 if($filter_type == 'email_address' || $filter_type=='client_name') {
	 if($filter_type=='email_address') { $condition = "client_email like '%".$term."%'"; }
	 if($filter_type=='client_name') { 
	 
	  $condition = "client_fname like '%".$term."%' or client_lname like '%".$term."%'"; 
	  
	  
	  }
	  
	      $qry ="select * from `".TBL_INVOICE_LINE_ITEM."` where  specialist_id = ".$_SESSION['user_id'].""; 
	    $rsInvLineItem  = dB::mExecuteSql($qry);
       if(count($rsInvLineItem)>0) {		
		foreach($rsInvLineItem as $key=>$val) {
			$invoiceId[] = $val->invoice_id;
	   } $invoiceId  = implode(',',$invoiceId); }  
		   

		$qry ="select * from `".TBL_INVOICE."` where  id in (".$invoiceId.")"; 
		$rsInvoice  = dB::mExecuteSql($qry);
		if(count($rsInvoice)>0) {		
		foreach($rsInvoice as $key=>$val) {
			$clientId[] = $val->client_id;
		} $clientId  = implode(',',$clientId); }  
	   
				   
	        $qry ="select * from `".TBL_CLIENTS."` where id in (".$clientId.") and (".$condition.")"; 
	        $rsRecords = dB::mExecuteSql($qry);
	 }
	 
	  /*if($filter_type=='invoice_id') {
		  
		   $qry ="select * from `".TBL_INVOICE_LINE_ITEM."` where  specialist_id = ".$_SESSION['user_id'].""; 
	    $rsInvLineItem  = dB::mExecuteSql($qry);
       if(count($rsInvLineItem)>0) {		
		foreach($rsInvLineItem as $key=>$val) {
			$invoiceId[] = $val->invoice_id;
	   } $invoiceId  = implode(',',$invoiceId); }  
		   
          $condition = "id like '%".$term."%'";

		$qry ="select * from `".TBL_INVOICE."` where  id in (".$invoiceId.") and ".$condition.""; 
		$rsRecords   = dB::mExecuteSql($qry);
	  } */
		  
	 if($filter_type =='services') {
		 $condition = "line_item like '%".$term."%'"; 		           
	      $qry ="select * from `".TBL_INVOICE_LINE_ITEM."` where specialist_id = ".$_SESSION['user_id']." and ".$condition.' group by service_id'; 
	    $rsRecords = dB::mExecuteSql($qry);
	}
	 
	 $result=array();
	 if(count($rsRecords)>0) {
		 foreach($rsRecords as $key=>$val) {
          
		   if($filter_type == 'email_address' || $filter_type=='client_name') {
			    $data['id'] = $val->id;	
		  $data['value'] = ucwords(strtolower($val->client_fname.' '.$val->client_lname).' - '.$val->client_email);	 		
		   }
		  	/*if($filter_type =='invoice_id') {
			     $data['id'] = $val->id;	  	
			  $data['value'] = ucwords(strtolower($val->id));	 	
			} */
			
			if($filter_type =='services') {
			     $data['id'] = $val->service_id;	  	
			  $data['value'] = ucwords(strtolower($val->line_item));	 	
			}
			
		   array_push($result, $data);
		   
	 }   echo json_encode($result);  }
exit();
}

?>  	