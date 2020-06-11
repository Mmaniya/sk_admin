<?php
print_r($_REQUEST);
$lineItemId = $_REQUEST['line_item_id']; 

$param = array('tableName'=>TBL_INVOICE_LINE_ITEM,'fields'=>array('*'),'condition'=>array('id'=>$lineItemId.'-INT'),'showSql'=>'N');
$rsInvLItem = Table::getData($param);
/*
$param = array('tableName'=>TBL_INVOICE,'fields'=>array('*'),'condition'=>array('id'=>$rsInvLItem->invoice_id.'-INT'),'showSql'=>'N');
$rsInvoices = Table::getData($param);  */

?> 
  <div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">			 
			<div class="modal-body"> <h4>BPE - <?php echo $rsInvLItem->invoice_id; ?></h4>
				 <div class="row">
					<div class="col-md-12">
						<div id="questionnaire_html" class="border"></div>
					</div>
				</div>				
			</div>
			<div class="modal-footer">			   
			  <div class="col-md-12">
				<button type="button" class="btn btn-primary waves-effect float-right" data-dismiss="modal">Close</button>	
              </div>				
			</div>
		</div>
	</div>
	</div><!-- /.modal -->
<script> 
function showQuestionnaire(service_id) {
	      paramData = {'act':'showQuestionnaire', 'service_id': service_id};
          ajax({ 
            a:'process',
            b:$.param(paramData),
            c:function(){},
            d:function(data){   	
			   $('#questionnaire_html').html(data);
            }});	    
	 
}
showQuestionnaire(<?php echo $_REQUEST['line_item_id'];?>);

function processQuestionnaire() {
  $( "form#questionnaire" ).submit(function( event ) {
   event.preventDefault();
   $.ajax({
		url: "process_questionnaire.php",
		type: "POST",
		data:  new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		success: function(data){  
		 
		   $('#questionnaire_html').html(data);
		},
		error: function(){} 	        
		});  });
}  
</script> 
	 