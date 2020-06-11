<?php   include "includes.php"; 

if($_GET['act']=='invoiceAutocomplete') {
ob_clean();	  
  $term =  $_REQUEST['term'];
  
    $filter_type = $_REQUEST['filter_type'];
	 
	 if($filter_type == 'email' || $filter_type=='client_name') {
	 if($filter_type=='email') { $condition = "client_email like '%".$term."%'"; }
	 if($filter_type=='client_name') { $condition = "client_fname like '%".$term."%' or client_lname like '%".$term."%'"; }
		           
	    $qry ="select * from `".TBL_CLIENTS."` where ".$condition." and status ='A'"; 
	    $rsRecords = dB::mExecuteSql($qry);
	 }
		  
	if($filter_type =='services') {
		 $condition = "line_item like '%".$term."%'"; 		           
		$qry ="select * from `".TBL_INVOICE_LINE_ITEM."` where ".$condition.''; 
		if($_SESSION['user_type']=='E' || $_SESSION['user_type']=='FL')
			$qry.=" and specialist_id='".$_SESSION['user_id']."'";

		$qry.=" group by service_id";
		
	    $rsRecords = dB::mExecuteSql($qry);
	}
	 
	if($filter_type =='invoice_id') {
		$condition = "TI.id like '".$term."%'";
		$qry ="select TI.id from `".TBL_INVOICE."` TI join `".TBL_INVOICE_LINE_ITEM."` TLI on TI.id=TLI.invoice_id where ".$condition.''; 
		if($_SESSION['user_type']=='E' || $_SESSION['user_type']=='FL')
			$qry.=" and TLI.specialist_id='".$_SESSION['user_id']."'";

		$qry.="	group by TLI.invoice_id order by id asc";
		$rsRecords = dB::mExecuteSql($qry);
		/*$result=array();
		$data['id'] = $val->id;	  	
			 $data['value'] = $qry;	 
			 array_push($result, $data);
			 echo json_encode($result);exit;*/
	}

	 $result=array();
	 if(count($rsRecords)>0) {
		 foreach($rsRecords as $key=>$val) {
          
		   if($filter_type == 'email' || $filter_type=='client_name') {
			    $data['id'] = $val->id;	
		  $data['value'] = ucwords(strtolower($val->client_fname.' '.$val->client_lname).' - '.$val->client_email);	 		
		   }
		  	if($filter_type =='services') {
			     $data['id'] = $val->service_id;	  	
			  $data['value'] = ucwords(strtolower($val->line_item));	 	
			}
			if($filter_type =='invoice_id') {
				$data['id'] = $val->id;	  	
			 $data['value'] = $val->id;	 	
		   }
		   array_push($result, $data);
		   
	 }   echo json_encode($result);  }
exit();
}


if($_GET['act']=='leadsAutocomplete') {
ob_clean();	  
  $term =  $_REQUEST['term'];
  
    $filter_type = $_REQUEST['filter_type'];
	 
	 if($filter_type == 'email' || $filter_type=='lead_name' || $filter_type=='company_name' || $filter_type=='lead_phone') {
	 if($filter_type=='email') { $condition = "lead_email like '%".$term."%'"; }
	 if($filter_type=='lead_name') { $condition = "lead_fname like '%".$term."%' or lead_lname like '%".$term."%'"; }
	 if($filter_type=='lead_phone') { $condition = "lead_phone like '%".$term."%'"; }
	 if($filter_type=='company_name') { $condition = "lead_company_name like '%".$term."%'"; }
		           
	    $qry ="select * from `".TBL_LEADS."` where ".$condition." and status ='A'"; 
	    $rsRecords = dB::mExecuteSql($qry);
	 }
		  
	/* if($filter_type =='services') {
		 $condition = "line_item like '%".$term."%'"; 		           
		$qry ="select * from `".TBL_LEAD_SERVICES."` where ".$condition.''; 
		if($_SESSION['user_type']=='E' || $_SESSION['user_type']=='FL')
			$qry.=" and specialist_id='".$_SESSION['user_id']."'";

		$qry.=" group by service_id";
		
	    $rsRecords = dB::mExecuteSql($qry);
	} */
	 
	 
	 if($filter_type =='services') {
		 $condition = "service_name like '%".$term."%'"; 		           
		$qry ="select * from `".TBL_SERVICES."` where ".$condition.''; 
		/* if($_SESSION['user_type']=='E' || $_SESSION['user_type']=='FL')
			$qry.=" and specialist_id='".$_SESSION['user_id']."'"; */

		/* $qry.=" group by service_id"; */
		
	    $rsRecords = dB::mExecuteSql($qry);
	}
	
	 

	 $result=array();
	 if(count($rsRecords)>0) {
		 foreach($rsRecords as $key=>$val) {
          
		   if($filter_type == 'email' || $filter_type=='lead_name') {
           $data['id'] = $val->id;	
		  $data['value'] = ucwords(strtolower($val->lead_fname.' '.$val->lead_lname).' - '.$val->lead_email);	 		
		   }
		   
		    if($filter_type == 'lead_phone') {
           $data['id'] = $val->id;	
		  $data['value'] = ucwords(strtolower($val->lead_fname.' '.$val->lead_lname).' - '.$val->lead_phone);	 		
		   }
		   
		    if($filter_type=='company_name') {
          $data['id'] = $val->id;	
		  $data['value'] = ucwords(strtolower($val->lead_company_name.' - '.$val->lead_fname.' '.$val->lead_lname));	 		
		   }
		   
		      		   
		  	if($filter_type =='services') {
			     $data['id'] = $val->id;	  	
			  $data['value'] = ucwords(strtolower($val->service_name));	 	
			}
			 
		   array_push($result, $data);
		   
	 }   echo json_encode($result);  }
exit();
}

?>  	