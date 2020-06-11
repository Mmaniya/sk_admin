 <?php  include 'includes.php'; 

$ticketObj = new Tickets;
 ?>
 
  <div class="card h-100">      
        <h5 class="card-header warning-text text-left ">Support Tickets </h5>
      <div class="card-body">
        
        <div class="table-responsive-md" id="ticket_list_div">
            <table class="table table-hover" style="border: 2px solid #eee;">
  <thead class="bg-primary text-white">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Subject</th>
       <th scope="col">Status</th>
	   <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
  <?php  $no=1;
  $param = array('tableName'=>TBL_TICKETS,'fields'=>array('*'),'orderby'=>'added_date','sortby'=>'desc','condition'=>array('client_id'=>$_SESSION['CLIENT_ID'].'-INT'),'showSql'=>'N');
  $rsTickets = Table::getData($param);
  if(count($rsTickets)>0) {
	foreach($rsTickets as $key=>$val) {
		
		$ticketStatus='';
	if($val->ticket_status=='O') {  $ticketStatus = 'Open'; }
	if($val->ticket_status=='I') {  $ticketStatus = 'In Progress'; }
	if($val->ticket_status=='R') {  $ticketStatus = 'Resolved'; }
	if($val->ticket_status=='N') {  $ticketStatus = 'Not Resolved'; }
	if($val->ticket_status=='C') {  $ticketStatus = 'Close'; }
 
 
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
 
 $readStatus='';
 $ticketObj->ticket_by = 'U';
	 $rsData = $ticketObj->newTicketCount();
	 if(count($rsData)>0) { $readStatus = 'unread';   } else {
		 $readStatus = 'viewed'; 
	 }
 
		?>
    <tr>
      <th scope="row"><?php echo $no++; ?></th>
      <td><?php echo $ticketDetails['tickets']['subject']; ?></td>
      <td><?php echo $ticketStatus; ?></td>
      <td><a href="javascript:void(0)" onclick="viewTickets(<?php echo $mailTicket;?>,'<?php echo $val->ticket_status;?>')"><i class="fas fa-reply"></i></a>
	  &nbsp; &nbsp;
	 <a href="javascript:void(0)" onclick="viewTickets(<?php echo $mailTicket;?>,'<?php echo $val->ticket_status;?>')"> <span class="messageCount <?php echo $readStatus; ?>"><?php echo $ticketDetails['tickets']['parent_count']; ?></span> </a></td>
    </tr>
    
<?php  } }} else { echo '<tr> <td colspan="3" style="text-align:center;">No tickets</td> </tr>'; } ?>
  
  </tbody>
</table></div>

        </div>
      </div><style>
	 .messageCount { color: #fff;  padding: 5px;  border-radius: 5px;  }
	 .unread {   background-color: #ec1919;  }
	 .viewed {   background-color: #2196f3;  }
	 
	 
	</style>