<?php function main() { 

$ticketsObj = new tickets;

$ticketStatus = $_GET['ticket_status'];

if($ticketStatus=='O') {  $ticketStatusText = 'Open'; }
if($ticketStatus=='I') {  $ticketStatusText = 'In Progress'; }
if($ticketStatus=='R') {  $ticketStatusText = 'Resolved'; }
if($ticketStatus=='N') {  $ticketStatusText = 'Not Resolved'; }
if($ticketStatus=='C') {  $ticketStatusText = 'Close'; }
?>

<script type="text/javascript" src="../ckeditor/ckeditor.js"></script> 
	<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<h4 class="page-title"><?php echo $ticketStatusText; ?> Tickets</h4>
			<ol class="breadcrumb float-right">
				<li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
				<li class="breadcrumb-item active">Tickets</li>
			</ol>
			<div class="clearfix"></div>
		</div>
	</div>
	</div>

 
    <div class="row">   
			<div class="col-sm-6">
               <div class="ticket_list_item">
			   </div>  
			</div> 			
   
	  
 <div class="col-sm-6">
      <div class="right_div"></div>
 </div>
 </div>
	  		 
		 
	<script>

function viewTickets(ticket_id,ticket_status) {
	$('.right_div').html('<h3>Loading...</h3>'); 
	paramData = {'act':'reply_tickets','ticket_id':ticket_id,'ticket_status':ticket_status};
	ajax({ 
		a:'tickets',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		  $('.right_div').html(data); 
     }});	
}

showTicketsList(<?php echo '"'.$ticketStatus.'"'; ?>);
function showTicketsList(ticket_status) {
	paramData = {'act':'show_ticket_list','ticket_status':ticket_status};
	ajax({ 
		a:'tickets',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		  $('.ticket_list_item').html(data); 
     }});	
}
</script>	
<style>
.ticket_list {border-bottom: 1px solid #eee; padding-top: 10px; display:flex;flex:1;  }
.ticket_list a{ width:90%; }
.ticket_list h5{ font-size: 16px; }
.ticket_list p{ font-size: 13px; }
.ticket_list a{ color:#000; }
.ticket_list .nav-link { padding: 0; padding-left: 10px; }
.count-message,.nav-link{ font-size:18px; }
</style>

<?php } include 'template.php'; ?>