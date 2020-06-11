 <?php  include 'includes.php';

 $lineItemId = $_POST['service_id'];
 
 $ticketObj = new tickets;
 ?>
 <script type="text/javascript" src="../ckeditor/ckeditor.js"></script> 
  <div class="card" id="ticket_line_item">      
        <h5 class="card-header warning-text text-left">Support Tickets </h5>
		<span class="response_text"></span>
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
  <?php 
            $condition = array('client_id'=>$_SESSION['CLIENT_ID'].'-INT','parent_id'=>'0-INT');
  
            if($lineItemId>0) {   $condition = array('invoice_line_item_id'=>$lineItemId.'-INT','client_id'=>$_SESSION['CLIENT_ID'].'-INT','parent_id'=>'0-INT'); }
  
  $param = array('tableName'=>TBL_TICKETS,'fields'=>array('*'),'condition'=>$condition,'showSql'=>'N');
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
 
 $readStatus='';
 $ticketObj->ticket_by = 'U';
	 $rsData = $ticketObj->newTicketCount();
	 if(count($rsData)>0) { $readStatus = 'unread';   } else {
		 $readStatus = 'viewed'; 
	 }
 
 
 
 
 $ticketStatus='';
	if($ticketDetails['tickets']['ticket_status']=='O') {  $ticketStatus = 'Open'; }
	if($ticketDetails['tickets']['ticket_status']=='I') {  $ticketStatus = 'In Progress'; }
	if($ticketDetails['tickets']['ticket_status']=='R') {  $ticketStatus = 'Resolved'; }
	if($ticketDetails['tickets']['ticket_status']=='N') {  $ticketStatus = 'Not Resolved'; }
	if($ticketDetails['tickets']['ticket_status']=='C') {  $ticketStatus = 'Close'; }
 
		?>
    <tr>
      <th scope="row"><?php echo $key+1; ?></th>
      <td><?php echo $ticketDetails['tickets']['subject']; ?></td>
      <td><?php echo $ticketStatus; ?></td>
      <td>
	  <a href="javascript:void(0)" onclick="viewTickets(<?php echo $val->id;?>,'<?php echo $val->ticket_status;?>','<?php echo $lineItemId;?>')"><i class="fas fa-reply"></i>
	  
	  </a> &nbsp; <span class="messageCount <?php echo $readStatus; ?>"><?php echo $ticketDetails['tickets']['parent_count']; ?></span> 
	  </td>
    </tr>
    
  <?php  } } } else { echo '<tr> <td colspan="4" style="text-align:center;">No tickets</td> </tr>
           <tr> <td colspan="4" style="text-align:right;"> </td> </tr>'; } ?>
  
  </tbody>
</table>

<div class="row">
 <div class="col-md-12"> <button type="button" class="btn btn-danger btn-sm" style="padding:6px;font-size:16px;float:right;" onclick="add_line_item_ticket('<?php echo $lineItemId; ?>')">Open Ticket</button>
  <br/><br/><p style="text-align:right;"><small style="font-size: 70%;">24 Hours Standard Response time </small> </p></div>
</div>

</div>

        </div>  <br/>
      </div>
	 
 <div class="line_item_ticket"></div> 
	<style>
	 .messageCount { color: #fff;  padding: 5px;  border-radius: 5px;  }
	 .unread {   background-color: #ec1919;  }
	 .viewed {   background-color: #2196f3;  } 
	</style>  
	  <script>
 function viewTickets(ticket_id,ticket_status,line_item_id) {
	$('#content_order').html('<h3>Loading...</h3>'); 
	paramData = {'act':'reply_tickets','ticket_id':ticket_id,'ticket_status':ticket_status,'line_item_id':line_item_id};
	ajax({ 
		a:'ticket_line_item_reply',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		  $('#content_order').html(data); 
     }});	
}

 function add_line_item_ticket(line_item_id) {
	$('.line_item_ticket').html('<h3>Loading...</h3>'); 
	paramData = {'line_item_id':line_item_id};
	ajax({ 
		a:'add_line_item_ticket',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		  $('.line_item_ticket').html(data); 
     }});	
}

</script>