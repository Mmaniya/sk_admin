 <?php  include 'includes.php'; 

$ticketStatus = $_POST['ticket_status'];
$ticketObj = new Tickets;
 ?>
 
 <div class="card">     
  <div class="card-body">
	 <?php $param = array('tableName'=>TBL_TICKETS,'fields'=>array('*'),'orderby'=>'added_date','sortby'=>'desc','condition'=>array('ticket_status'=>$ticketStatus.'-CHAR'),'showSql'=>'N');
		$rsTickets = Table::getData($param);
		if(count($rsTickets)>0) {
		foreach($rsTickets as $key=>$val) { 

	if(!in_array($val->id,$shownTicket) && !in_array($val->parent_id,$shownTicket)) {


	if($val->parent_id==0) {
		 $ticketObj->ticket_id = $val->id;
		 $shownTicket[$val->id]=$val->id;
		 $mailTicket = $val->id;
	}
	else {
		  $ticketObj->ticket_id = $val->parent_id;
		  $shownTicket[$val->parent_id]=$val->parent_id;
		  $mailTicket = $val->parent_id;
	}
 
	$ticketDetails =  $ticketObj->getTicketDetails();  
	
	 $assignedUser='';
	 if(($ticketDetails['tickets']['user']['id'])>0) {  $assignedUser = $ticketDetails['tickets']['user']['name'];   }
	 $readStatus='';
	 $ticketObj->ticket_by = 'C';
	 $rsData = $ticketObj->newTicketCount();
	 if(count($rsData)>0) { $readStatus = 'badge-danger';   } else {
		 $readStatus = 'badge-primary'; 
	 }
	 48571447
	?>
		 <div class="ticket_list">
		   <a href="javascript:void(0)" onclick="viewTickets(<?php echo $mailTicket;?>,'<?php echo $val->ticket_status;?>')">
		    <h5><?php echo $ticketDetails['tickets']['clients']['name'].' - BPE-'.$ticketDetails['tickets']['invoice_id']; ?></h5>
			<p><?php echo 'TKE-'.$ticketDetails['tickets']['id'];  echo '&nbsp;&nbsp;[assign to '.$assignedUser.']';  echo '<br/>'; echo $ticketDetails['tickets']['subject'].'&nbsp;&nbsp; - '; echo getTimeAgo(strtotime($val->added_date)); ?> </p>
			</a>
			<div class="count-message fs-20 text-fade">
			<span class="badge badge-pill <?php echo $readStatus; ?>"><?php echo count($rsData); ?></span></div>
		<!--<nav class="nav gap-2 fs-16">
		<a class="nav-link hover-danger cat-delete"  href="javascript:void(0)"><i class="ti-trash"></i></a>
		</nav>-->
						
		 </div>
	<?php   } }} else { echo ' No Tickets'; }    ?> 	   
	     </div>
	  </div>
	  <style>
	 .messageCount { color: #fff;  padding: 5px;  border-radius: 5px;  }
	 .unread {   background-color: #ec1919;  }
	 .viewed {   background-color: #2196f3;  }
	 
	 .badge {
    font-weight: 600;
    padding: 3px 7px;
    font-size: 18px;
    margin-top: 1px;
}
	</style>