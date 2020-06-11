<?php include 'includes.php'; 

 
 $lineItemId = $_POST['line_item_id'];
 


$param = array('tableName'=>TBL_INVOICE_LINE_ITEM,'fields'=>array('*'),'condition'=>array('id'=>$lineItemId.'-INT'));
$rsInvoiceLineItem = Table::getData($param);
	
 ?> 
 <script type="text/javascript" src="../ckeditor/ckeditor.js"></script>  <br/>
 <div class="card">
      <div class="card-body">
        <h5 class="card-title warning-text text-left">Open Ticket</h5>
       <form name="support_ticket_form" id="support_ticket_form"  enctype="multipart/form-data">
            <div class="container-fluid">
			     
				 
				 <input type="hidden" name="ticket_id" value="">
				 <input type="hidden" name="ticket_for" value="I">
				 <input type="hidden" name="invoice_id" value="<?php echo $rsInvoiceLineItem->invoice_id; ?>">
				 <input type="hidden" name="category_id" value="<?php echo $rsInvoiceLineItem->category_id; ?>">
				 <input type="hidden" name="invoice_line_item_id" id="invoice_line_item_id" value="<?php echo $rsInvoiceLineItem->invoice_line_item_id; ?>">
				  
				 
				     <div class="row">
                        <div class="form-group col-md-12">
                          <label class="require">Subject</label>
                          <input class="form-control" type="text" name="subject" id="subject">
                        </div>                         
                     </div>  
					 
					 
					 <div class="row">
                        <div class="form-group col-md-12">
                          <label class="require">Priority</label>
                            <select class="form-control" name="priority" id="priority">
							 <option value="N">Normal</option>
							 <option value="H">Height</option>
							</select>
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
	<script>  		
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
 
 
var editorValue = editor.getData();

 if(editorValue=='' ){ err=1; $('#editor').css("border","1px solid #ff0000 ");  $('.editor_error').html('Enter Description'); } else {  $('#editor').css("border",""); $('.editor_error').html(''); }
   
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
		    viewItemTickets();
            $('form#support_ticket_form')[0].reset();

		},
		error: function(){} 	        
		});
		}


  });
  
   function viewItemTickets() { service_id =  $('#invoice_line_item_id').val();
	  paramData = {'service_id': service_id};
          ajax({ 
            a:'ticket_line_item_list',
            b:$.param(paramData),
            c:function(){},
            d:function(data){  
			  $('#content_order').html(data);
            }});	    	  
 }


  </script>