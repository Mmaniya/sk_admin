 <?php  include 'includes.php';  
 
 $ticketsObj = new tickets;
 
 $ticketId = $_POST['ticket_id'];
 $ticketStatus = $_POST['ticket_status'];
 
	$ticketsObj->ticket_by = 'C';
	$ticketsObj->ticket_id = $ticketId;
	$ticketsObj->setTicketRead();
	 
 $param = array('tableName'=>TBL_TICKETS,'fields'=>array('*'),'condition'=>array('id'=>$ticketId.'-INT'),'showSql'=>'N');
  $rsTicket = Table::getData($param); 
  
 
 ?>
 
 <div class="card" style="margin-top:20px">    
  <div class="card-body"> <h5>Ticket Status</h5>
   <hr/>
   <form>
    <div class="row">
       <div class="form-group col-md-3">  
        <select class="form-control" id="ticket_status_id">
		<option value="O" <?php if($ticketStatus=='O') { echo 'selected'; } ?>>Open</option>
		<option value="I" <?php if($ticketStatus=='I') { echo 'selected'; } ?>>In Progress</option>
		<option value="R" <?php if($ticketStatus=='R') { echo 'selected'; } ?>>Resolved</option>
		<option value="NR" <?php if($ticketStatus=='NR') { echo 'selected'; } ?>>Not Resolved</option>
		<option value="C" <?php if($ticketStatus=='C') { echo 'selected'; } ?>>Closed</option>
		</select>
	   </div>
	    
	    <div class="form-group col-md-3">  
        <select class="form-control"  id="ticket_user_id">
		<option value="">Move to :</option>
		<?php $param = array('tableName'=>TBL_USERS,'fields'=>array('*'),'condition'=>array('status'=>'A-CHAR'),'showSql'=>'N');
              $rsUsers = Table::getData($param); 
			  if(count($rsUsers)>0) {
             foreach($rsUsers as $key=>$val) { $selected='';
				 if($rsTicket->user_id==$val->id) { $selected ='selected'; }
				 echo '<option value='.$val->id.' '.$selected.'>'.$val->contact_fname.' '.$val->contact_lname.'</option>'; 				 
			  } }  ?>		
		</select>
	   </div>
	    <input type="hidden" name="update_ticket_id" id="update_ticket_id" value="<?php echo $ticketId; ?>"/>
	    <div class="form-group col-md-3"> 
		   <button type="button" class="btn btn-primary btn-sm" onclick="updateTicketStatus()">Submit</button>
		</div>
   </div>
   </form>
   </div>
</div>
<?php 
  $param = array('tableName'=>TBL_TICKETS,'fields'=>array('*'),'condition'=>array('id'=>$ticketId.'-INT'),'showSql'=>'N');
  $rsTicket = Table::getData($param); 
  
    $param = array('tableName'=>TBL_SERVICE_CATEGORY,'fields'=>array('id,category_name'),'condition'=>array('id'=>$rsTicket->category_id.'-INT'),'showSql'=>'N');
	$rsCategory = Table::getData($param);
	
	 $ticketFor = 'Invoice';
  if($rsTicket->ticket_for=='G') { $ticketFor = 'General'; }
  $ticketInfo = $ticketFor;
 if($rsTicket->ticket_for=='I') {
	$param = array('tableName'=>TBL_INVOICE_LINE_ITEM,'fields'=>array('*'),'condition'=>array('id'=>$rsTicket->invoice_line_item_id.'-INT'));
	$rsInvoiceLineItem = Table::getData($param);
	$lineItem = $rsInvoiceLineItem->line_item;
	
	$param = array('tableName'=>TBL_INVOICE,'fields'=>array('*'),'condition'=>array('id'=>$rsTicket->invoice_id.'-INT'));
	$rsInvoice = Table::getData($param);
	$invoiceName =  'invoice No : '.$rsInvoice->id.' '.$rsInvoice->subject;
	$ticketInfo = $invoiceName.' '.$lineItem;
 }
 
  ?>
 <div class="card card-header warning-text text-left bg-primary text-white"  style="margin-top:20px;padding:0px;">     
         <div class="card-body">
		     <div class="ticket_list_reply"> 		  
		    <h5><?php echo 'TKE-'.$rsTicket->id.' - '; echo $rsTicket->subject;?>  <span class="float-right"><?php echo date('m/d/Y h:i:s a',strtotime($rsTicket->added_date)); ?></span></h5> 
         <p><?php echo $ticketInfo;?></p>	
	    <p style="margin-bottom:0px"><?php  echo $rsCategory->category_name.' - '.getTimeAgo(strtotime($rsTicket->added_date)); ?>  </p>
	   	 </div>
		 </div>		 
     </div> 
  <div class="list-item" style="max-height:500px; overflow:scroll;">
  
 		
	 
 <?php 
 /* $ticketsObj->ticket_status = $ticketStatus;
 $ticketsObj->ticket_id = $ticketId;
 $rsTickets = $ticketsObj->getTicketsReplyList();  */
 $param = array('tableName'=>TBL_TICKETS,'fields'=>array('*'),'condition'=>array('parent_id'=>$ticketId.'-INT'),'showSql'=>'N');
  $rsTickets = Table::getData($param); 
 
  if(count($rsTickets)>0) {
	foreach($rsTickets as $key=>$val) { 

	$param = array('tableName'=>TBL_SERVICE_CATEGORY,'fields'=>array('id,category_name'),'condition'=>array('id'=>$val->category_id.'-INT'),'showSql'=>'N');
	$rsCategory = Table::getData($param);
  $rsParentTicket='';
  $senderName='';
  if($val->ticket_by=='C') { 
  $param = array('tableName'=>TBL_CLIENTS,'fields'=>array('*'),'condition'=>array('id'=>$val->client_id.'-INT'),'showSql'=>'N');
  $rsClient = Table::getData($param);
  $senderName = $rsClient->client_fname.' '.$rsClient->client_lname; 
  }
  
  if($val->ticket_by=='U') { 
  $param = array('tableName'=>TBL_USERS,'fields'=>array('*'),'condition'=>array('id'=>$val->user_id.'-INT'),'showSql'=>'N');
  $rsUser = Table::getData($param);
 $senderName = $rsUser->contact_fname.' '.$rsUser->contact_lname;
  }
  
	?>
	<script type="text/javascript" src="../ckeditor/ckeditor.js"></script> 
     <div class="card" style="margin-top:20px">     
         <div class="card-body">
		     <div class="ticket_list_reply"> 		  
		    <h5><?php echo  $senderName.' - <small>'.getTimeAgo(strtotime($val->added_date));?></small>   <span class="float-right"><?php echo date('m/d/Y h:i:s a',strtotime($val->added_date)); ?></span></h5>  <hr/>
			<p><?php echo $val->message; ?> </p>
			
			<?php if($val->files!='') { ?>
			<a href="../support_tickets/<?php echo $val->files; ?>" download>Download Attachment</a>
			<?php } ?>
	    	 </div>
		 </div>		 
     </div> 		 
 <?php  } } ?>
 </div>
 <!--
 invoice |  general
 invice
    category group by
	line item 
  -->   	
    	
		<?php if($ticketStatus=='O' || $ticketStatus=='I' || $ticketStatus=='NR') {  ?>
 
 <form name="support_ticket_form" id="support_ticket_form"   enctype="multipart/form-data">
 <div class="card" style="margin-top:20px">     
         <div class="card-body">
		 <h5> Reply </h5>
        	 <hr/>
				<div class="row">
					<div class="form-group col-md-12">
					  <label class="require">Description</label>
					   <textarea name="message"  class="form-control" id="editor"></textarea>
					   <span class="editor_error" style="border: none;font-size: 12px;color:#ff0000;"></span>
					</div>                         
				</div>  
				 
				  <div class="row">
                        <div class="form-group col-md-12">
                          <label class="require">Attachments(optional)</label>
                            <input type="file" name="files[]" style="border: none;font-size: 12px;">
                        </div>
 
       <input type="hidden" name="act" value="submitReplyTicket">
       <input type="hidden" name="ticket_id" id="ticket_id" value="<?php echo $ticketId; ?>">
       <input type="hidden" id="ticket_status" name="ticket_status" value="<?php echo $ticketStatus; ?>">
       <div class="form-group col-md-12"> <button class="btn btn-info" id="submitBtn"  type="submit">Send</button></div>						
                 </div> 
				 
     </div>		 
 </div>	
</form> 

		<?php } ?>


	
 <script>
 $(".list-item").scrollTop($(".list-item")[0].scrollHeight);

 
  var editor = CKEDITOR.replace('editor');
 CKEDITOR.editorConfig = function( config ) {
	    config.toolbarGroups = [
		 { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
	];
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
   /* config.filebrowserBrowseUrl = '../ckeditor/kcfinder/browse.php?opener=ckeditor&type=files';
   config.filebrowserImageBrowseUrl = '../cckeditor/kcfinder/browse.php?opener=ckeditor&type=images';
   config.filebrowserFlashBrowseUrl = '../cckeditor/kcfinder/browse.php?opener=ckeditor&type=flash';
   config.filebrowserUploadUrl = '../cckeditor/kcfinder/upload.php?opener=ckeditor&type=files';
   config.filebrowserImageUploadUrl = '../cckeditor/kcfinder/upload.php?opener=ckeditor&type=images';
   config.filebrowserFlashUploadUrl = '../cckeditor/kcfinder/upload.php?opener=ckeditor&type=flash'; */
    
};
 
 $( "form#support_ticket_form" ).submit(function( event ) {
   event.preventDefault();        
    err=0;    CKEDITOR.instances.editor.updateElement();

 
  var editorValue = editor.getData(); 
 if(editorValue=='' ){ err=1; $('#editor').css("border","1px solid #ff0000 ");  $('.editor_error').html('Enter Description'); } else{  $('#editor').css("border",""); $('.editor_error').html(''); }
   
		if(err==0) {
		   $.ajax({
		url: "tickets.php",
		type: "POST",
		data:  new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		success: function(data){   
		var res = data.split("::");
		 alert(res[1]);   
		    //$(".list-item").load(" .list-item");
              $('form#support_ticket_form')[0].reset();
			  var ticket_id =  $('#ticket_id').val();
			  var ticket_status =  $('#ticket_status').val();
			  
                  viewTickets(ticket_id,ticket_status);
		},
		error: function(){} 	        
		});
		}


  });  
	
	
	
	function updateTicketStatus() {
		err=0;
		if($('#ticket_user_id')=='' ){ err=1; $('#ticket_user_id').css("border","1px solid #ff0000 ");   } else{  $('#ticket_user_id').css("border","");  }
		if($('#ticket_status_id')=='' ){ err=1; $('#ticket_status_id').css("border","1px solid #ff0000 ");   } else{  $('#ticket_status_id').css("border","");  }
		 
		var user_id =  $('#ticket_user_id').val();
		var update_ticket_id =  $('#update_ticket_id').val();
		var ticket_status =  $('#ticket_status_id').val();
		if(err==0) {
			if(confirm('Are you sure update ticket status ?')) {
	paramData = {'act':'update_ticket_status','user_id':user_id,'ticket_status':ticket_status,'update_ticket_id':update_ticket_id};
	ajax({ 
		a:'tickets',
		b:$.param(paramData),
		c:function(){},
		d:function(data){ 
			var res = data.split("::");
		 alert(res[1]);   
		    viewTickets(ticket_id,ticket_status);
     }});	
		} }
}
	
	
	

function viewTickets(ticket_id,ticket_status) {
	paramData = {'act':'reply_tickets','ticket_id':ticket_id,'ticket_status':ticket_status};
	ajax({ 
		a:'tickets',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		  $('.right_div').html(data); 
     }});	
}
	
		
 </script>
 
 <style>
.ticket_list_reply {  padding-top: 10px;  }  
.ticket_list_reply h5{ font-size: 16px; }
.ticket_list_reply p{ font-size: 13px; }  
.ticket_list_reply { padding: 0; padding-left: 10px; }
 
</style>