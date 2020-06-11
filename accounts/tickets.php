<?
function main() { 
     
	 $ticketObj = new Tickets;
	  $serviceCategoryObj = new ServiceCategory();
	  
	 
		$clientId = $_SESSION['CLIENT_ID'];
		$param = array('tableName'=>TBL_CLIENTS,'fields'=>array('*'),'condition'=>array('id'=>$clientId.'-INT'),'showSql'=>'N');
		$rsClient = Table::getData($param);
	
	
	 
	
	if($_POST['act']=='submitTicket') {
		ob_clean();
		$param=array();
		 
		$params = array('subject','message');
		foreach($params as $K=>$V) {  $param[$V]=$$V=check_input($_POST[$V]); } 
		
		  
		$param['client_id']= $_SESSION['CLIENT_ID']; 
		
		$param['ticket_by']='C'; // CLIENT 
		
		if($_POST['ticket_id']=='') {
		$param['ticket_for']= $_POST['ticket_for'];
		if($_POST['ticket_for']=='I') {
		$param['category_id'] = $_POST['category_id'];
		$param['invoice_id'] = $_POST['invoice_id'];
		$param['invoice_line_item_id'] = $_POST['line_item'];
		}
		if($_POST['ticket_for']=='G') {
			$param['category_id'] = $_POST['category_list_id']; 			
		}
		}
		else {
				$param1= array('tableName'=>TBL_TICKETS,'fields'=>array('*'),'condition'=>array('id'=>$_POST['ticket_id'].'-INT'));
			$rsPTicket = Table::getData($param1); 			 
			$param['subject']= $rsPTicket->subject; 			
			$param['invoice_id']= $rsPTicket->invoice_id; 			
			$param['category_id']= $rsPTicket->category_id; 			
			$param['invoice_line_item_id']= $rsPTicket->invoice_line_item_id; 
			
			if($rsPTicket->parent_id==0) { 				
			$param['parent_id']= $_POST['ticket_id']; 
			$param['root_parent_id']= $_POST['ticket_id']; }
			else  {
			$param['parent_id']= $_POST['ticket_id']; 
			$param['root_parent_id']= $rsPTicket->root_parent_id;
			}
			
		}
		
		if(count($_FILES['files']['name'])>0) {
		foreach($_FILES['files']['name'] as $key=>$val) { 		
	$imagefile=$_FILES['files']['name'][$key]; 
	if($imagefile!='') {
	$expImage=explode('.',$imagefile);
	$imageExpType=$expImage[1];
	$date = date('m/d/Yh:i:sa', time());
	$rand=rand(10000,99999);
	$encname=$date.$rand;
	$service_files_serialize[] = $imageName=md5($encname).'.'.$imageExpType;
	$imagePath="../support_tickets/".$imageName;
	move_uploaded_file($_FILES["files"]["tmp_name"][$key],$imagePath);
		} }
	 }
		$param['files']= $imageName;
		
		$param['added_date'] = date('Y-m-d H:i:s',time());		
		$param['added_by']= $_SESSION['CLIENT_ID'];  
		$param['message']= $_POST['message'];
		echo $rsDtls = Table::insertData(array('tableName'=>TBL_TICKETS,'fields'=>$param,'showSql'=>'N')); 
		 $explode = explode('::',$rsDtls);  
		 
		 $ticketId = $explode[2]; 
		  if($_POST['ticket_id']=='') {
				$tickets_to = 'C';
				$ticketType = 'reply';
				include 'ticket_send_email.php';
				
				$tickets_to = 'U';
				$ticketType = 'reply';
				include 'ticket_send_email.php';

		  
		  } else {
				$tickets_to = 'U';
				$ticketType = 'create'; 
				include 'ticket_send_email.php';
		 
		 		$tickets_to = 'C';
				$ticketType = 'create'; 
				include 'ticket_send_email.php'; 
				}
	
	
		exit();		
	}
	
	if($_POST['act']=='show_ticket_list') {
 ob_clean();
   include 'ticket_list.php';
 exit();	
}

	if($_POST['act']=='reply_tickets') {
 ob_clean();
   include 'ticket_reply.php';
 exit();	
}
	
	
	
	
if($_POST['act']=='show_category_list') {
 ob_clean(); 
$invoiceId = $_POST['invoice_id'];
 $ticketObj->invoice_id = $invoiceId;
 $categoryList = $ticketObj->getCategoryListByInvoice();
 ?>  
	<label class="require">Category</label> <br/>
	  <select class="form-control" id="category_id" name="category_id" onchange="loadLineItemList(this.value)">
		 <option value="">Select</option>
		<?php  		 
	if(count($categoryList)>0) {
	  foreach($categoryList as $key=>$val) {
		  if($val->category_id>0) {
		$param = array('tableName'=>TBL_SERVICE_CATEGORY,'fields'=>array('*'),'condition'=>array('id'=>$val->category_id.'-INT'));
		$rsCategoryId = Table::getData($param);
		 echo '<option value="'.$rsCategoryId->id.'">'.$rsCategoryId->category_name.'</option>'; 
	} }  }
	
	?>	 
	   </select>
	   
 <?php  exit(); } 


	
if($_POST['act']=='show_category_service_list') {
 ob_clean(); 
$categoryId = $_POST['category_id'];
$invoiceId = $_POST['invoice_id'];
  
 ?>  
	<label class="require">Service type </label> <br/>
	  <select class="form-control" id="line_item" name="line_item">
		 <option value="">Select</option>
		<?php  		 
	$param = array('tableName'=>TBL_INVOICE_LINE_ITEM,'fields'=>array('*'),'condition'=>array('category_id'=>$categoryId.'-INT','invoice_id'=>$invoiceId.'-INT'));
	$rsInvoiceLineItem = Table::getData($param);
	if(count($rsInvoiceLineItem)>0) {
	  foreach($rsInvoiceLineItem as $key=>$val) {
		  if($val->category_id>0) {
		
		 echo '<option value="'.$val->id.'">'.$val->line_item.'</option>'; 
	} }  }
	
	?>	 
	   </select>
	   
 <?php  exit(); } 



 ?>
	

 <script type="text/javascript" src="../ckeditor/ckeditor.js"></script> 
<h1 class="heading">Tickets	</h1>
<div class="row">
  <div class="col-md-6">
    <div class="card h-100">
      <div class="card-body">
        <h5 class="card-title warning-text text-left">Open Ticket</h5>
       <form name="support_ticket_form" id="support_ticket_form"  enctype="multipart/form-data">
            <div class="container-fluid">
			   <div class="row">
                        <div class="form-group col-md-6">
                          <label class="require">Name</label>
                          <input class="form-control" type="text" name="name" value="<?php echo $_SESSION['CLIENT_NAME']; ?>" readonly>
                        </div>
                         <div class="form-group col-md-6">
                          <label class="require">Email</label>
                          <input class="form-control" type="email" name="email" value="<?php echo $_SESSION['CLIENT_EMAIL']; ?>" readonly>
                        </div>
                 </div>
				 
				 
				  <div class="row">
                        <div class="form-group col-md-12">
                          <label class="require">Support for</label> <br/>
                          <p style="font-size: 17px;margin: 0;"> 
						  <input type="radio" name="ticket_for" value="I" onclick="showTicketType('I')"> Invoice
                          <input type="radio" name="ticket_for" value="G" onclick="showTicketType('G')"> General </p>
						  <span class="support_for_error" style="color:#ff0000;font-size:16px"></span>
                        </div>                         
                 </div>  
				 
				 
				 <div class="row" id="invoice_div" style="display:none;margin-bottom:25px;">
                        <div class="col-md-4">
                          <label class="require">Invoice</label> <br/>
                          <select class="form-control" id="invoice_id" name="invoice_id" onchange="loadCategoryList(this.value)">
						     <option value="">Select</option>
						<?php 
							$param = array('tableName'=>TBL_INVOICE,'fields'=>array('*'),'condition'=>array('client_id'=>$_SESSION['CLIENT_ID'].'-INT'));
							$rsInvoice = Table::getData($param);
						if(count($rsInvoice)>0) {
						  foreach($rsInvoice as $key=>$val) {
							  $invoiceNo = '#invoice'.$val->id.' - ';
							 echo '<option value="'.$val->id.'">'.$invoiceNo.$val->subject.'</option>'; 
						} } ?>	 
						   </select>
                        </div> 


                        <div class="col-md-4" id="category_list_div" style="display:none">
					      <div class="category_list"></div>						  
                        </div>
							 
						<div class="col-md-4" id="line_item_list_div" style="display:none">
                           <div class="line_item_list"></div>		
                        </div> 
                 </div>  
				 
				 
				  <div class="row" id="category_div" style="display:none">
                        <div class="form-group col-md-6">
                          <label class="require">Category</label>
                           <select class="form-control" id="category_list_id" name="category_list_id">
						     <option value="">Select</option>
						<?php 
						$serviceCategoryObj->category_id = $rsClient->client_enquiry_for; 
						$categoryList = $serviceCategoryObj->getCategoryByIds();
						if(count($categoryList)>0) {
						  foreach($categoryList as $key=>$val) {
							 echo '<option value="'.$val->id.'">'.$val->category_name.'</option>'; 
						} }
						?>	 
						   </select>
                        </div>                         
                 </div>  	 
				 
				     <div class="row">
                        <div class="form-group col-md-12">
                          <label class="require">Subject</label>
                          <input class="form-control" type="text" name="subject" id="subject">
                        </div>                         
                     </div>  
  
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
                   <div class="form-group col-md-12"> <button class="btn btn-info" id="submitBtn"  type="submit">Send</button></div>						
                 </div>    
			</div>  	
		</form> 		
 </div>
    </div>
       </div>
	   
	   
	   
	 <div class="col-md-6">
    <div class="card h-100">
     
        <h5 class="card-header warning-text text-left">Recent Support Tickets </h5>
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
  $param = array('tableName'=>TBL_TICKETS,'fields'=>array('*'),'condition'=>array('client_id'=>$_SESSION['CLIENT_ID'].'-INT'),'showSql'=>'N');
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
      <th scope="row"><?php echo $no++; ?></th>
      <td><?php echo $ticketDetails['tickets']['subject']; ?></td>
      <td><?php echo $ticketStatus; ?></td>
     <td><a href="ticket_view.php"><i class="fas fa-reply"></i>  &nbsp; <span class="messageCount <?php echo $readStatus; ?>"><?php echo $ticketDetails['tickets']['parent_count']; ?></span> </a></td> 
    </tr>
    
  <?php  } } } else { echo '<tr> <td colspan="3" style="text-align:center;">No tickets</td> </tr>'; } ?>
  
  </tbody>
</table></div>

        </div>
      </div>
    </div>
 
          </div>
		  
		  <script>
		
		
		function showTicketType(type) {
			$('#invoice_div').hide(); $('#category_div').hide();
			
			if(type=='I') {  $('#invoice_div').show(); }
			if(type=='G') {  $('#category_div').show(); }
			
		}
		

function loadCategoryList(invoice_id) {
	paramData = {'act':'show_category_list','invoice_id':invoice_id};
	ajax({ 
		a:'tickets',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		  $('.category_list').html(data);	
$('#category_list_div').show();		  
		}});	
}

function loadLineItemList(category_id) {
	var invoice_id = $('#invoice_id').val();
	paramData = {'act':'show_category_service_list','category_id':category_id,'invoice_id':invoice_id};
	ajax({ 
		a:'tickets',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		  $('.line_item_list').html(data);	
         $('#line_item_list_div').show();		  
		}});	
}


		
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
       
    err=0;
  
  if($('#subject').val()=='' ){ err=1; $('#subject').css("border","1px solid #ff0000 "); } else{  $('#subject').css("border","");}
 
  var ticket_for = $("input[name='ticket_for']:checked").val();
  $('.support_for_error').html('');
  if(ticket_for==undefined) {  err=1;  $('.support_for_error').html('Select Support '); }
 
 if(ticket_for=='I') {
	 if($('#invoice_id').val()=='' ){ err=1; $('#invoice_id').css("border","1px solid #ff0000 "); } else{  $('#invoice_id').css("border","");}
	 if($('#category_id').val()=='' ){ err=1; $('#category_id').css("border","1px solid #ff0000 "); } else{  $('#category_id').css("border","");}
	 if($('#line_item').val()=='' ){ err=1; $('#line_item').css("border","1px solid #ff0000 "); } else{  $('#line_item').css("border","");}
	 
 } 
 
 if(ticket_for=='G') {
	 
	  if($('#category_list_id').val()=='' ){ err=1; $('#category_list_id').css("border","1px solid #ff0000 "); } else{  $('#category_list_id').css("border","");}
 }
 
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
		    $("#ticket_list_div").load(" #ticket_list_div");
                  $('form#support_ticket_form')[0].reset();

		},
		error: function(){} 	        
		});
		}


  });  
		
		
   
  
  </script>
<?php 	
}
include "template.php";

?>