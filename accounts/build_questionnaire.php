<?php

if($_POST['act']=='showQuest') {
	include "includes.php";
	$lineItemId = $_POST['service_id'];
	$invoiceObj = new Invoice();
	$invoiceObj->invoice_line_item_id = $lineItemId;
	$questionnaireElements = $invoiceObj->getQuestionnaireForm();
	ob_clean();
	echo $questionnaireElements; 
	exit();
}
?>
 <div class="row">
    	<div class="col-md-12">
    		<div class="card mt-3">
    			<div class="card-header bg-secondary"><div id="quest_div">
 				    <?php  ?>	
                    </div>
			    </div>
		    </div> 
	    </div>
   </div>     

<script>

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
		   $('#quest_div').html(data);
		},
		error: function(){} 	        
		});  });
}


function buildQuestionnaire(service_id) {
	  paramData = {'act':'showQuest','service_id': service_id};
          ajax({ 
            a:'build_questionnaire',
            b:$.param(paramData),
            c:function(){},
            d:function(data){  
			  $('#quest_div').html(data);
            }});	    	  
	
}
function showQuestionnaireCmts(invLineItemId,documentId,questionnaireId) {
	 paramData = {'act':'showQuestionnaireCmts','invoice_line_item_id': invLineItemId,"document_id":documentId,"questionnaire_id":questionnaireId };
          ajax({ 
            a:'process',
            b:$.param(paramData),
            c:function(){},
            d:function(data){  
			   $('.right_bar_div').html(data);
            }}); 
}
function checkInvoiceDocNotApplicable(curCheck,ids,invId)
{
	if(confirm('Are you sure you want to update this?'))
	{	
		var ischecked=0;
		
		if(curCheck.checked)
			ischecked=1;

		paramData = {'act':'checkInvoiceDocNotApplicable','ids':ids,'ischecked':ischecked,'invoice_id':invId};
		
		ajax({ 
            a:'process',
            b:$.param(paramData),
            c:function(){},
            d:function(data){  
//alert(data);
		}}); 	
	}	
	else{curCheck.checked=false;}	
}

buildQuestionnaire(<?php echo $_POST['service_id'];?>)
</script>