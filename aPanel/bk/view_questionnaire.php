<?php
$invoiceObj = new Invoice();
$invoiceObj->invoice_line_item_id= $_POST['line_item_id'];
$invoiceObj->invoice_id= $_POST['invoice_id'];
$questionnaireDtls = $invoiceObj->getQuestionnaireDetails();

?>

	<div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">			 
			<div class="modal-body">
				 <div class="row">
					<div class="col-md-12" id="questionnaire_html">
						<?php print_r($questionnaireDtls); ?>
					</div>
				</div>		




				
			</div>
			<div class="modal-footer">
			  <div class="col-md-6">
				<button type="button" class="btn btn-primary waves-effect" onclick="showQuestionnaire(<?php echo $_POST['line_item_id']; ?>)">Edit Questionnaire</button>	
              </div>
			  <div class="col-md-6">
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
 //showQuestionnaire(<?php echo $_REQUEST['line_item_id'];?>);

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