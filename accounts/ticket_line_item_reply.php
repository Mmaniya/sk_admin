 <?php  include 'includes.php';  
 
 $ticketsObj = new tickets;
 
 $ticketId = $_POST['ticket_id'];
 $ticketStatus = $_POST['ticket_status'];
 $lineItemId = $_POST['line_item_id'];
 $ticketsObj->ticket_by = 'U';
	 $ticketsObj->ticket_id = $ticketId;
	 $ticketsObj->setTicketRead();
 
  $param = array('tableName'=>TBL_TICKETS,'fields'=>array('*'),'condition'=>array('id'=>$ticketId.'-INT'),'showSql'=>'N');
  $rsTicket = Table::getData($param); 
 ?>
 <h5 class="card-header warning-text text-left bg-primary text-white">TKE-<?php echo $rsTicket->id; ?> - <?php echo $rsTicket->subject; ?>   <small class="float-right"><?php echo date('m/d/Y h:i:s a',strtotime($rsTicket->added_date)); ?></small> </h5>
 
 
 <div class="list-item" style="max-height:500px; overflow:scroll;overflow-x: hidden;">
  <?php 
 
  
    $param = array('tableName'=>TBL_SERVICE_CATEGORY,'fields'=>array('id,category_name'),'condition'=>array('id'=>$rsTicket->category_id.'-INT'),'showSql'=>'N');
	$rsCategory = Table::getData($param);
	  if($rsTicket->ticket_by=='C') { 
  $param = array('tableName'=>TBL_CLIENTS,'fields'=>array('*'),'condition'=>array('id'=>$rsTicket->client_id.'-INT'),'showSql'=>'N');
  $rsClient = Table::getData($param);
  $senderName = $rsClient->client_fname.' '.$rsClient->client_lname; 
  }
  
  if($rsTicket->ticket_by=='U') { 
  $param = array('tableName'=>TBL_USERS,'fields'=>array('*'),'condition'=>array('id'=>$rsTicket->user_id.'-INT'),'showSql'=>'N');
  $rsUser = Table::getData($param);
 $senderName = $rsUser->contact_fname.' '.$rsUser->contact_lname;
  }
  
  ?>
  <div class="card">     
         <div class="card-body">
		     <div class="ticket_list_reply"> 		  
		   
			<p><?php echo $rsCategory->category_name.' - '.getTimeAgo(strtotime($rsTicket->added_date)); ?> </p> 
			 
			<?php if($rsTicket->files!='') { ?>
			<a href="../support_tickets/<?php echo $val->files; ?>" download>Download Attachment</a>
			<?php } ?>
	    	 </div>
		 </div>		 
     </div> 		
	 
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
	
     <div class="card" style="margin-top:20px">     
         <div class="card-body">
		     <div class="ticket_list_reply"> 		  
		    <h5><?php echo  $senderName.' - <small>'.getTimeAgo(strtotime($val->added_date));?></small> <span class="float-right"><?php echo date('m/d/Y h:i:s a',strtotime($val->added_date)); ?></span> </h5>  <hr/>
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
 
       <input type="hidden" name="act" value="submitTicket">
       <input type="hidden"   id="line_item_id" value="<?php echo $lineItemId; ?>">
       <input type="hidden" name="ticket_id" id="ticket_id" value="<?php echo $ticketId; ?>">
       <input type="hidden" id="ticket_status" name="ticket_status" value="<?php echo $ticketStatus; ?>">
       <div class="form-group col-md-12"> <button class="btn btn-info" id="submitBtn"  type="submit">Send</button>  
	    <button class="btn btn-danger" id="submitBtn" onclick="viewItemTickets(<?php echo $lineItemId; ?>)"  type="button">Close</button> 
	   </div>						
     			
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
		 //alert(res[1]);   
		    //$(".list-item").load(" .list-item");
              $('form#support_ticket_form')[0].reset();
			  var ticket_id =  $('#ticket_id').val();
			  var ticket_status =  $('#ticket_status').val();
			  var line_item_id =  $('#line_item_id').val();
			  
                  viewItemTickets(line_item_id);
				  $('.response_text').html('<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> This alert box could indicate a successful or positive action.</div>');  
		},
		error: function(){} 	        
		});
		} 
  });  
	

 function viewTicketsload(ticket_id,ticket_status,line_item_id) {
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
	
		
 </script>
 
 <style>
.ticket_list_reply {  padding-top: 10px;  }  
.ticket_list_reply h5{ font-size: 16px; }
.ticket_list_reply p{ font-size: 13px; }  
.ticket_list_reply { padding: 0; padding-left: 10px; }
 
</style>